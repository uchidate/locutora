<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Twitter;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Api\Twitter\TwitterApiInterface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class TwitterSource extends AbstractSourceType implements SourceInterface
{
    public const TWEETS_DEFAULT_LIMIT = 20;

    private $api;

    public function types(): array
    {
        if (!$this->auth()) {
            return [];
        }

        return [
            new Type\TwitterUserType(),
            new Type\TwitterTweetType(),
            new Type\TwitterUserQueryType($this),
            new Type\TwitterTweetsQueryType($this),
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

    public function api(): TwitterApiInterface
    {
        if ($this->api) {
            return $this->api;
        }

        return $this->api = app(TwitterApiInterface::class)->withAccessToken($this->auth()->accessToken());
    }
}
