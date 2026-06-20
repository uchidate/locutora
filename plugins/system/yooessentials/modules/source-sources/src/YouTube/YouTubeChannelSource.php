<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\YouTube;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\Google\YouTube\YouTubeApiInterface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class YouTubeChannelSource extends YouTubeSource
{
    /** @var string */
    public $channel;

    /** @var string */
    protected $configFile = 'config-channel.json';

    public function bind(array $config): SourceInterface
    {
        parent::bind($config);

        $this->account = $config['account'] ?? null;
        $this->channel = $config['channel_id'] ?? null;

        return $this;
    }

    public function types(): array
    {
        $objectType = new Type\YouTubeVideoType();

        return [
            $objectType,
            new Type\YouTubeChannelVideoQueryType($this, $objectType),
            new Type\YouTubeChannelVideosQueryType($this, $objectType)
        ];
    }

    public function api(): YouTubeApiInterface
    {
        if ($this->api) {
            return $this->api;
        }

        $auth = app(AuthManager::class)->auth($this->account);

        if (!$auth) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'youtube',
                'error' => 'Missing Auth'
            ]);
        }

        return $this->api = app(YouTubeApiInterface::class)->forAccount($auth);
    }
}
