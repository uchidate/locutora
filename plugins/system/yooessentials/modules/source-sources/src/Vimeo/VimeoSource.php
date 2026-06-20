<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Vimeo;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\Vimeo\VimeoApi;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class VimeoSource extends AbstractSourceType implements SourceInterface
{
    public const VIDEO_LIMIT_DEFAULT = 20;
    public const VIDEO_CACHE_TIME_DEFAULT = 3600;

    /** @var VimeoApi */
    private $api;

    public function types(): array
    {
        return [
            new Type\VimeoTagType(),
            new Type\VimeoUserType(),
            new Type\VimeoVideoType(),
            new Type\VimeoMyVideosQueryType($this),
            new Type\VimeoMyFolderVideosQueryType($this),
            new Type\VimeoMyShowcaseVideosQueryType($this),
        ];
    }

    public function account(): ?string
    {
        return $this->config()['account'] ?? null;
    }

    public function api(): VimeoApi
    {
        if ($this->api) {
            return $this->api;
        }

        try {
            $auth = app(AuthManager::class)->auth($this->account());

            return $this->api = app(VimeoApi::class)->withAuth($auth);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'vimeo',
                'error' => $e->getMessage(),
                'exception' => $e
            ]);

            return app(VimeoApi::class);
        }
    }
}
