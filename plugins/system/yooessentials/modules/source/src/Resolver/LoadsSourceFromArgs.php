<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

trait LoadsSourceFromArgs
{
    public static function loadSource(array $args, string $sourceClass): ?SourceInterface
    {
        $sourceId = $args['source_id'] ?? null;

        /** @var SourceService $sourceManager */
        $sourceManager = app(SourceService::class);

        try {
            return $sourceId
                ? $sourceManager->source($sourceId, $args)
                : new $sourceClass($args);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-load',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);

            return null;
        }
    }
}
