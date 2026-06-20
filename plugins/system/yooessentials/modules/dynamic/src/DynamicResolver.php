<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Dynamic;

use function YOOtheme\app;
use YOOtheme\Arr;
use YOOtheme\Builder\Source\SourceTransform;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Config;

class DynamicResolver
{
    public function preload(object $node, array $params)
    {
        $this->resolveExtendedQuery($node, $params);
    }

    public function prerender(object $node, array $params)
    {
        if (!isset($node->source_extended)) {
            return $node;
        }

        // deal with no transient children from transient ancestors
        if (isset($params['parent']->transient) && !isset($node->transient)) {
            $node = clone $node;
            $node->transient = true;

            array_splice($params['parent']->children, $params['i'] + 1, 0, [$node]);

            return false;
        }

        $this->resolveExtendedProps($node, $params);

        return true;
    }

    public function resolveExtendedQuery(object $node, array $params = []): ?object
    {
        if (!isset($node->source_extended->query)) {
            return $node;
        }

        if (!isset($node->source)) {
            $node->source = new \StdClass();
        }

        $node->source->query = $node->source_extended->query;

        unset($node->source_extended->query);

        if (empty((array) $node->source_extended)) {
            unset($node->source_extended);
        }

        $node->source->query = $this->resolveQuery($node->source->query, $params);

        return $node;
    }

    public function resolveNodeAdjacent(object $adjacent, object $node, array $params = []): object
    {
        $node = $this->resolveTransient($node, $params);

        if (!isset($adjacent->source)) {
            $adjacent->source = new \StdClass();
        }

        if (isset($node->source->query)) {
            $adjacent->source->query = $node->source->query;
        }

        return $this->resolveProps($adjacent, $params);
    }

    public function resolveProps(object $node, array $params = []): object
    {
        $node = $this->_resolveProps((array) ($node->source->props ?? []), $node, $params);
        $node = $this->resolveExtendedProps($node, $params);

        return $node;
    }

    public function resolveExtendedProps(object $node, array $params = []): object
    {
        if (!isset($node->source_extended)) {
            return $node;
        }

        return $this->_resolveProps((array) ($node->source_extended->props ?? []), $node, $params);
    }

    protected function _resolveProps(array $props, object $node, array $params = []): object
    {
        foreach ($props as $name => $prop) {
            $queryOrigin = $this->getQueryOrigin($prop, $node, $params);

            $data = $this->resolvePropQueryData($name, $prop, $node, $params);

            if (!is_array($data)) {
                continue;
            }

            $isMulti = isset($data[0]);

            // if query origin is node and data multi item
            // it must be reconstructed from the transient node
            if ($queryOrigin === 'node' && $isMulti) {
                $data = $data[$params['i'] - 1] ?? $data[0];
            }

            // when multiple content set in a prop group the result
            if (Str::startsWith($queryOrigin, 'prop') && $isMulti) {
                $data = [
                    $prop->name => array_map(function ($val) use ($prop) {
                        return Arr::get($val, $prop->name);
                    }, $data)
                ];
            }

            $this->mapPropsSource($name, $prop, $node, $params + compact('data'));
        }

        return $node;
    }

    protected function resolvePropQueryData(string $name, object $prop, object $node, array $params): ?array
    {
        if (isset($prop->query->inherit) && $closest = $this->closestInheritableNode($node, $params)) {
            return $closest->resolvedSourceData;
        }

        if (isset($prop->query)) {
            $query = $this->resolveQuery($prop->query, $params);
        }

        if (!isset($prop->query) && isset($node->source->query)) {
            $query = $this->resolveQuery($node->source->query, $params);
        }

        if (empty($query)) {
            return null;
        }

        // create fake node to resolve single prop
        $clone = clone $node;
        $clone->source = (object) [
            'props' => [
                $name => $prop
            ],
            'query' => $query
        ];

        return $this->resolveSource($clone, $params);
    }

    protected function getClosestResolvedQueryData(object $node, array $params = []): ?array
    {
        foreach ($params['path'] ?? [] as $ancestor) {
            if ($ancestor !== $node && isset($ancestor->resolvedSourceData)) {
                return $ancestor->resolvedSourceData;
            }
        }

        return [];
    }

    protected function getQueryOrigin(object $prop, object $node, array $params = []): ?string
    {
        if (($prop->query->inherit ?? null) === 'closest') {
            return 'prop.inherit.closest';
        }

        if (isset($prop->query)) {
            return 'prop.global';
        }

        if (isset($node->source->query->name)) {
            return 'node';
        }

        return null;
    }

    protected function resolveQuery(object $query, array $params = []): ?object
    {
        if (isset($query->global) && $query = $this->getGlobalQuery($query->global)) {
            return json_decode(json_encode($query));
        }

        return $query;
    }

    protected function getGlobalQuery(string $id): ?object
    {
        $queries = app(Config::class)->get('dynamic.queries', []);

        $key = array_search($id, array_column($queries, 'id'));

        if (isset($queries[$key])) {
            return (object) ($queries[$key]['source']['query'] ?? []);
        }

        return null;
    }

    protected function resolveSource(object $node, array $params = []): ?array
    {
        $node = $this->resolveTransient($node, $params);

        if (!$result = app(SourceTransform::class)->querySource($node, $params)) {
            return null;
        }

        $name = $node->source->query->name;

        // add field name
        if (isset($node->source->query->field)) {
            $name .= ".{$node->source->query->field->name}";
        }

        return (array) Arr::get($result, "data.{$name}");
    }

    protected function mapPropsSource(string $name, object $prop, object &$node, array $params)
    {
        $value = Arr::get($params['data'], $prop->name);
        $isMulti = is_array($value);
        $implode = $prop->implode->join ?? null;

        if ($isMulti && $implode === 'before') {
            $value = implode($prop->implode->glue ?? '', $value);
            $isMulti = false;
        }

        // apply filters
        $filters = isset($prop->filters) ? (array) $prop->filters : [];

        if ($isMulti) {
            foreach ($value as $i => $val) {
                $value[$i] = $this->applyFilters(trim($this->toString($val)), $filters, $params);
            }
        } else {
            $value = $this->applyFilters(trim($this->toString($value)), $filters, $params);
        }

        if ($isMulti && $implode === 'after') {
            $value = implode($prop->implode->glue ?? '', $value);
        }

        $node->props[$name] = $value;
    }

    protected function applyFilters(string $value, array $filters, array $params): ?string
    {
        foreach (array_intersect_key(app(SourceTransform::class)->filters, $filters) as $key => $filter) {
            $value = $filter($value, $filters[$key], $filters, $params);
        }

        return $value;
    }

    protected function closestInheritableNode(object $node, array $params): ?object
    {
        foreach ($params['path'] ?? [] as $ancestor) {
            if ($ancestor !== $node && isset($ancestor->resolvedSourceData)) {
                return $ancestor;
            }
        }

        return null;
    }

    protected function resolveTransient(object $node, array $params): object
    {
        if (!isset($node->transient, $params['parent']->children[0])) {
            return $node;
        }

        $node = clone $params['parent']->children[0];
        $node->transient = true;

        return $node;
    }

    protected function toString($str)
    {
        if (is_scalar($str) || is_callable([$str, '__toString'])) {
            return (string) $str;
        }

        return '';
    }
}
