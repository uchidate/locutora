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
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class YouTubeSource extends AbstractSourceType implements SourceInterface
{
    /** @var string */
    public $account;

    /** @var string */
    public $apiKey;

    /** @var YouTubeApiInterface */
    protected $api;

    public function bind(array $config): SourceInterface
    {
        parent::bind($config);

        $this->apiKey = $config['api_key'] ?? null;
        $this->account = $config['account'] ?? null;

        return $this;
    }

    public function types(): array
    {
        $objectType = new Type\YouTubeVideoType();

        return [
            $objectType,
            new Type\YouTubeVideosQueryType($this, $objectType)
        ];
    }

    public function api(): YouTubeApiInterface
    {
        if ($this->api) {
            return $this->api;
        }

        $apiKey = app(AuthManager::class)->auth($this->apiKey);

        if (!$apiKey) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'youtube',
                'error' => 'Missing Api Key'
            ]);
        }

        return $this->api = app(YouTubeApiInterface::class)->withApiKey($apiKey);
    }
}
