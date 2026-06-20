<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\TikTok;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\TikTok\TikTokApi;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class TikTokSource extends AbstractSourceType implements SourceInterface
{
    public const VIDEO_LIMIT_DEFAULT = 20;
    public const VIDEO_CACHE_TIME_DEFAULT = 3600;

    /** @var string */
    public $account;

    /** @var TikTokApi */
    private $api;

    public function bind(array $config): SourceInterface
    {
        parent::bind($config);

        $this->account = $config['account'] ?? null;

        return $this;
    }

    public function types(): array
    {
        return [
            new Type\TikTokVideoType(),
            new Type\TikTokVideosQueryType($this)
        ];
    }

    public function api(): TikTokApi
    {
        if ($this->api) {
            return $this->api;
        }

        try {
            $auth = app(AuthManager::class)->auth($this->account);

            return $this->api = app(TikTokApi::class)->forAccount($auth);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'tiktok',
                'error' => $e->getMessage(),
                'exception' => $e
            ]);

            return app(TikTokApi::class);
        }
    }
}
