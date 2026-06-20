<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\Google\MyBusiness\GoogleMyBusinessApiInteface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\ItemInterface;

class GoogleMyBusinessSource extends AbstractSourceType implements SourceInterface
{
    /** @var string */
    public $account;

    /** @var string */
    public $location;

    /** @var string */
    public $businessAccount;

    private $api;

    public function bind(array $config): SourceInterface
    {
        parent::bind($config);

        $this->account = $config['account'] ?? null;
        $this->location = $config['location'] ?? null;
        $this->businessAccount = $config['businessAccount'] ?? null;

        return $this;
    }

    public function types(): array
    {
        return [
            new Type\GoogleMyBusinessLocation($this),
            new Type\GoogleMyBusinessStoreAddress($this),
            new Type\GoogleMyBusinessReviewer($this),
            new Type\GoogleMyBusinessPeriod($this),
            new Type\GoogleMyBusinessReply($this),
            new Type\GoogleMyBusinessReview($this),
            new Type\GoogleMyBusinessMedia($this),
            new Type\GoogleMyBusinessMediaAttribution($this),
            new Type\GoogleMyBusinessMediaLocationAssociation($this),
            new Type\GoogleMyBusinessLocationQuery($this),
            new Type\GoogleMyBusinessReviewsQuery($this),
            new Type\GoogleMyBusinessReviewQuery($this),
            new Type\GoogleMyBusinessLocationMediaQuery($this),
        ];
    }

    public function defaultName(): string
    {
        return 'Google My Business';
    }

    public function auth(): ?AuthOAuth
    {
        return app(AuthManager::class)->auth($this->account);
    }

    public function api(): GoogleMyBusinessApiInteface
    {
        if ($this->api) {
            return $this->api;
        }

        if (!$this->auth()) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'google-my-business',
                'error' => 'Missing Auth'
            ]);
        }

        return $this->api = app(GoogleMyBusinessApiInteface::class)->forAccount($this->auth());
    }

    public function cache(string $key, callable $callback = null)
    {
        /** @var FilesystemAdapter $cache */
        $cache = app(CacheInterface::class);

        if ($callback) {
            return $cache->get($key, function (ItemInterface $item) use ($callback) {
                $item->expiresAfter($args['cache'] ?? self::DEFAULT_CACHE_TIME);

                return $callback();
            });
        }

        $cache->delete($key);
    }
}
