<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use function YOOtheme\app;
use YOOtheme\View\HtmlHelper;

abstract class Feature
{
    public const SOURCE_QUERY_AST = 'SOURCE_QUERY_AST';
    public const SOURCE_INPUT_TYPE = 'SOURCE_INPUT_TYPE';
    public const SOURCE_EXTEND_TYPE = 'SOURCE_EXTEND_TYPE';
    public const VIEW_ADD_TRANSFORM = 'VIEW_ADD_TRANSFORM';

    private const FEATURES = [
        self::SOURCE_QUERY_AST => [self::class, 'doesSourceSupportQueryAst'],
        self::SOURCE_INPUT_TYPE => [self::class, 'doesSourceSupportInputType'],
        self::SOURCE_EXTEND_TYPE => [self::class, 'doesSourceSupportExtendType'],
        self::VIEW_ADD_TRANSFORM => [self::class, 'doesViewSupportTransforms']
    ];

    public static function canUse(string $feature): bool
    {
        if (!isset(self::FEATURES[$feature])) {
            return false;
        }

        if (is_callable(self::FEATURES[$feature])) {
            return call_user_func(self::FEATURES[$feature]);
        }

        if ($ytpVersion = app()->config->get('theme.version', '') && is_string(self::FEATURES[$feature])) {
            return version_compare($ytpVersion, self::FEATURES[$feature], '>=');
        }

        return false;
    }

    public static function cannotUse(string $feature): bool
    {
        return !self::canUse($feature);
    }

    protected static function doesViewSupportTransforms(): bool
    {
        $r = new \ReflectionClass(HtmlHelper::class);

        return $r->hasMethod('addTransform') && $r->getMethod('addTransform')->isPublic();
    }

    protected static function doesSourceSupportInputType(): bool
    {
        if (!class_exists('YOOtheme\GraphQL\SchemaBuilder')) {
            return false;
        }

        $r = new \ReflectionClass(\YOOtheme\GraphQL\SchemaBuilder::class);

        return $r->hasMethod('inputType') && $r->getMethod('inputType')->isPublic();
    }

    protected static function doesSourceSupportExtendType(): bool
    {
        if (!class_exists('YOOtheme\GraphQL\SchemaBuilder')) {
            return false;
        }

        $r = new \ReflectionClass(\YOOtheme\GraphQL\SchemaBuilder::class);

        return $r->hasMethod('extendType') && $r->getMethod('extendType')->isPublic();
    }

    protected static function doesSourceSupportQueryAst(): bool
    {
        if (!class_exists('YOOtheme\Builder\Source\Query\AST')) {
            return false;
        }

        if (!class_exists('YOOtheme\Builder\Source\Query\Node')) {
            return false;
        }

        $r = new \ReflectionClass(\YOOtheme\Builder\Source\Query\Node::class);

        return $r->hasMethod('toAST') && $r->getMethod('toAST')->isPublic();
    }
}
