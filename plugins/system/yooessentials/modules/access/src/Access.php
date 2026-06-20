<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

use function YOOtheme\app;

class Access
{
    public const MODE_OR = 'OR';
    public const MODE_AND = 'AND';
    public const MODE_CUSTOM = 'custom';

    /**
     * @var array
     */
    protected $rules = [];

    public function addRule(string $rule): self
    {
        $ruleInstance = app($rule);
        $namespace = $ruleInstance->namespace();

        if (!isset($this->rules[$namespace])) {
            $this->rules[$namespace] = $ruleInstance;
        }

        return $this;
    }

    public function rule(string $type = null): ?RuleInterface
    {
        return $this->rules[$type] ?? null;
    }

    public function rules(): array
    {
        return $this->rules;
    }
}
