<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Api\Instagram\InstagramApiInterface;
use ZOOlanders\YOOessentials\Api\Instagram\InstagramPersonalApi;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class InstagramSource extends AbstractSourceType implements SourceInterface
{
    public const MEDIA_LIMIT_DEFAULT = 20;
    public const MEDIA_CACHE_TIME_DEFAULT = 3600;

    /** @var InstagramApiInterface */
    protected $api;

    public function types(): array
    {
        if (!$this->auth()) {
            return [];
        }

        return [
            new Type\InstagramMediaType(),
            new Type\InstagramAlbumMediaType(),
            new Type\InstagramMediaQueryType($this),
            new Type\InstagramMediaSingleQueryType($this),
        ];
    }

    public function account(): ?string
    {
        return $this->config()['account'] ?? null;
    }

    public function auth(): ?AuthOAuth
    {
        return app(AuthManager::class)->auth($this->account());
    }

    public function api(): InstagramApiInterface
    {
        if ($this->api) {
            return $this->api;
        }

        return $this->api = app(InstagramPersonalApi::class)->forAccount($this->auth());
    }
}
