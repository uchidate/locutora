<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

use function YOOtheme\app;
use YOOtheme\Arr;
use ZOOlanders\YOOessentials\Dynamic\DynamicResolver;
use ZOOlanders\YOOessentials\Logger;

class AccessResolver
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Access
     */
    protected $access;

    /**
     * @var DynamicResolver
     */
    protected $dynamic;

    /**
     * @var array
     */
    protected $conditions;

    /**
     * @var string
     */
    protected $query;

    public function __construct(array $conditions)
    {
        $this->access = app(Access::class);
        $this->dynamic = app(DynamicResolver::class);

        // filter out orphan conditions
        $this->conditions = array_filter($conditions, function ($condition) {
            return $this->access->rule($condition->type);
        });

        if (!$this->conditions) {
            throw new \RuntimeException('No Valid Conditions.');
        }
    }

    public function query(): string
    {
        return $this->query;
    }

    public function withLogger(Logger $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function withQuery(string $query): self
    {
        $this->query = $this->validateQuery($query);

        return $this;
    }

    public function resolve(object $node, array $params = []): bool
    {
        $resolved = $this->resolveConditions($node, $params);
        $result = $this->resolveQuery($resolved);

        return $result;
    }

    private function resolveConditions(object $node, array $params): array
    {
        return array_map(function ($condition) use ($node, $params) {
            $rule = $this->access->rule($condition->type);

            $result = true;

            $id = $condition->id ?? uniqid();
            $status = $condition->props->status ?? '';
            $isDisabled = $status === 'disabled';

            if ($isDisabled) {
                $this->logger->log($id, compact('result'));

                return $result;
            }

            try {
                // resolve dynamic props
                $condition->props = (array) $condition->props;
                $condition->source_extended = json_decode(json_encode($condition->source_extended ?? []));
                $condition = $this->dynamic->resolveNodeAdjacent((object) $condition, $node, $params);

                $status = $condition->props['status'] ?? true;
                $reversed = $condition->props['reversed'] ?? false;

                // resolve rule props
                $resolvedProps = $rule->resolveProps((object) $condition->props, $node);

                $this->logger->log($id, [
                    'args' => $this->resolveArgsLabels($rule, (array) $resolvedProps)
                ]);

                if ($status === false) {
                    $this->logger->log($id, compact('result'));

                    return $result;
                }

                $result = $rule->resolve($resolvedProps, $node);

                if ($reversed) {
                    $result = !$result;
                }
            } catch (\Exception $e) {
                $result = false;
                $this->logger->logError($id, $e->getMessage());
            }

            $this->logger->log($id, compact('result'));

            return $result;
        }, $this->conditions);
    }

    private function resolveQuery(array $resolved): bool
    {
        if (count($resolved) === 1) {
            return $resolved[0];
        }

        if ($this->query === Access::MODE_OR) {
            return Arr::some($resolved, function ($v) {
                return $v;
            });
        }

        if ($this->query === Access::MODE_AND) {
            return Arr::every($resolved, function ($v) {
                return $v;
            });
        }

        $result = false;
        $query = $this->query;

        // resolving custom query, replace conditions {n}
        foreach ($resolved as $i => $state) {
            $pattern = '/\{' . ($i + 1) . '\}/';
            $query = preg_replace($pattern, $state ? '1' : '0', $query);
        }

        // at this point there should not be any brackets left
        if (preg_match('/{|}/', $query)) {
            throw new \RuntimeException('Invalid Query');
        }

        eval("\$result = $query;");

        return $result;
    }

    private function validateQuery(string $query): string
    {
        if (count($this->conditions) === 1) {
            return '';
        }

        if ($query === Access::MODE_AND || $query === Access::MODE_OR) {
            return $query;
        }

        // remove all spaces
        $query = preg_replace('/ */', '', $query);

        // replace operators
        $query = preg_replace(['/AND/i', '/OR/i'], ['&&', '||'], $query);

        // remove unsupported characters
        $query = preg_replace('/[^0-9&&||(){}]+/', '', $query);

        return $query;
    }

    private function resolveArgsLabels(RuleInterface $rule, array $args): array
    {
        $result = [];
        $fields = $rule->fields();

        foreach ($args as $key => $value) {
            $field = $fields[$key] ?? [];
            $type = $field['type'] ?? '';
            $label = $field['label'] ?? $key;

            if ($key === 'status' || $key === 'name') {
                continue;
            }

            if (is_string($value) && $type === 'select' and $field['options'] ?? null) {
                $value = array_search($value, $field['options']);
            }

            if ($value instanceof \DateTime || $value instanceof \DateTimeImmutable) {
                $value = $value->format('r');
            }

            $result[$label] = $value;
        }

        return $result;
    }
}
