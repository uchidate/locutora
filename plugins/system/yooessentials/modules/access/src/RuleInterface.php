<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

interface RuleInterface
{
    public function name(): string;

    public function group(): string;

    public function icon(): string;

    public function namespace(): string;

    public function description(): string;

    public function docs(): string;

    public function fields(): array;

    public function resolveProps(object $props, object $node): object;

    /**
     * @param $props The settings values from the rule fields
     * @param $node The current element node being evaluated
     */
    public function resolve(object $props, object $node): bool;
}
