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
use ZOOlanders\YOOessentials\Api\Instagram\InstagramBusinessApi;

class InstagramBusinessSource extends InstagramSource
{
    /** @var string */
    protected $configFile = 'config-business.json';

    public function types(): array
    {
        if (!$this->auth()) {
            return [];
        }

        return [
            new Type\InstagramAlbumMediaType(),
            new Type\InstagramBusinessUserType(),
            new Type\InstagramBusinessMediaType(),
            new Type\InstagramBusinessUserQueryType($this),
            new Type\InstagramBusinessMediaQueryType($this),
            new Type\InstagramBusinessMediaSingleQueryType($this),
            new Type\InstagramBusinessHashtaggedMediaQueryType($this),
        ];
    }

    public function pageId(): ?string
    {
        return $this->config()['page_id'] ?? null;
    }

    public function api(): InstagramApiInterface
    {
        if ($this->api) {
            return $this->api;
        }

        return $this->api = app(InstagramBusinessApi::class)->forAccount($this->auth());
    }
}
