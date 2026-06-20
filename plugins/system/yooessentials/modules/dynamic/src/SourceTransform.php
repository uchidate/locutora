<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Dynamic;

use YOOtheme\Arr;
use YOOtheme\Builder\Source\SourceTransform as YooSourceTransform;
use YOOtheme\Event;
use YOOtheme\Str;

class SourceTransform extends YooSourceTransform
{
    public function querySource($node, array $params)
    {
        if (empty($node->source->query->name) || empty($node->source->props)) {
            return;
        }

        if (is_array($node->source->props)) {
            $node->source->props = (object) $node->source->props;
        }

        // if there are inheriting children include it props in the query
        // using unique id to avoid name conflicts
        foreach (self::findInheritingChildrenProps($node) as $prop) {
            $node->source->props->{'_inherited_' . uniqid()} = $prop;
        }

        if ($result = Event::emit('yooessentials.source.query', $node, $params)) {
            return $result;
        }

        return parent::querySource($node, $params);
    }

    public function mapSource($node, array $params)
    {
        // keep resolved data for nodes inheriting
        $node->resolvedSourceData = $params['data'];

        // remove inherit props references
        foreach ($node->source->props ?? [] as $name => $prop) {
            if (Str::startsWith($name, '_inherited_')) {
                unset($node->source->props->$name);
            }
        }

        return parent::mapSource($node, $params);
    }

    public function repeatSource($node, array $params)
    {
        $nodes = [];

        // clone node for each item
        foreach ($params['data'] as $data) {
            $clone = clone $node;
            $clone->transient = true;
            $clone->source = (object) [
                'props' => $node->source->props,
            ];

            // deep clone children
            $clone->children = json_decode(json_encode($clone->children ?? []));

            if ($this->mapSource($clone, compact('data') + $params)) {
                $nodes[] = $clone;
            }
        }

        // insert all cloned nodes after current node
        if ($nodes) {
            array_splice($params['parent']->children, $params['i'] + 1, 0, $nodes);
        }

        return false;
    }

    protected static function findInheritingChildrenProps(object $node): array
    {
        $carry = [];

        foreach ($node->children ?? [] as $child) {
            foreach ($child->source_extended->props ?? [] as $prop) {
                if (($prop->query->inherit ?? false) === 'closest') {
                    $carry[] = (object) Arr::omit((array) $prop, 'query');
                }
            }

            if (!isset($child->source->query->name)) {
                $carry = array_merge($carry, self::findInheritingChildrenProps($child));
            }
        }

        return $carry;
    }
}
