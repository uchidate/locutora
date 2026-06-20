<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Twitter;

use YOOtheme\Http\Response;
use YOOtheme\HttpClientInterface;
use ZOOlanders\YOOessentials\Api\AbstractApi;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;

class TwitterApi extends AbstractApi implements TwitterApiInterface
{
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var CacheInterface
     */
    protected $cache;

    protected $apiEndpoint = 'https://api.twitter.com/2';

    protected const TWEET_FIELDS = ['id', 'text', 'attachments', 'author_id', 'created_at', 'entities', 'in_reply_to_user_id', 'lang', 'public_metrics', 'source'];
    protected const MEDIA_FIELDS = ['duration_ms', 'height', 'media_key', 'preview_image_url', 'type', 'url', 'width', 'public_metrics', 'non_public_metrics', 'organic_metrics', 'promoted_metrics', 'alt_text', 'variants'];
    protected const USER_FIELDS = ['created_at', 'description', 'entities', 'id', 'location', 'name', 'pinned_tweet_id', 'profile_image_url', 'protected', 'public_metrics', 'url', 'username', 'verified', 'withheld'];

    public function __construct(CacheInterface $cache, HttpClientInterface $client)
    {
        parent::__construct($client);

        $this->cache = $cache;
    }

    public function withAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function account(): array
    {
        $result = $this->get('users/me', [
            'user.fields' => implode(',', self::USER_FIELDS)
        ]);

        return $result['data'] ?? [];
    }

    /**
     * @see https://developer.twitter.com/en/docs/twitter-api/tweets/timelines/api-reference/get-users-id-tweets#tab2
     */
    public function tweets(string $accountId, int $limit = 20, array $filters = []): array
    {
        $result = $this->fetchTweetsResults($accountId, $limit, null, $filters);
        $data = $result['data'] ?? [];

        $data = $this->mapTweets($data, $result['includes'] ?? []);

        while ($limit > count($data)) {
            // iterate again, with the next page
            $next = $result['meta']['next_token'] ?? null;

            if (!$next) {
                return $data;
            }

            // Next set
            $limit = $limit - count($data);

            if ($limit <= 0) {
                return $data;
            }

            $result = $this->fetchTweetsResults($accountId, $limit, $next, $filters);
            $data = array_merge($data, $this->mapTweets($result['data'], $result['includes']));
        }

        return $data;
    }

    private function mapTweetData(array $users, array $tweet, array $medias): array
    {
        $tweet['author'] = $users[$tweet['author_id']] ?? [];
        $tweet['in_reply_to_user'] = isset($tweet['in_reply_to_user_id']) ? $users[$tweet['in_reply_to_user_id']] ?? [] : [];
        $tweet['medias'] = [];
        $tweet['urls'] = [];
        $tweet['expanded_urls'] = [];

        foreach ($tweet['entities']['urls'] ?? [] as $url) {
            $tweet['urls'][] = $url['url'];
            $tweet['expanded_urls'][] = $url['expanded_url'];
        }

        foreach ($tweet['attachments']['media_keys'] ?? [] as $media) {
            $tweet['medias'][] = $medias[$media] ?? [];
        }

        return $tweet;
    }

    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->accessToken
        ];
    }

    private function indexUsers(array $users1): array
    {
        $includedUsers = $users1;

        $users = [];
        foreach ($includedUsers as $user) {
            $users[$user['id']] = $user;
        }

        return $users;
    }

    private function indexMedias(array $media1): array
    {
        $includedMedias = $media1;

        $medias = [];
        foreach ($includedMedias as $media) {
            $medias[$media['media_key']] = $media;
        }

        return $medias;
    }

    protected function processResponse(Response $response): array
    {
        $body = json_decode($response->getBody(), true);
        $success = $response->getStatusCode() >= 200 && $response->getStatusCode() <= 299 && ($body['success'] ?? true);

        if (!$success) {
            $code = $body['data']['status'] ?? $response->getStatusCode() ?? 400;
            $message = $body['data']['detail'] ?? $response->getReasonPhrase() ?? 'Unknown Error';

            throw new \Exception("Twitter API Error: {$message}", $code);
        }

        return $body;
    }

    private function fetchTweetsResults(string $accountId, int $limit = 20, ?string $pagination_token = null, array $filters = []): array
    {
        try {
            return $this->fetchTweetsRequest($accountId, $limit, $pagination_token, $filters);
        } catch (\Exception $e) {
            // Twitter apis sometimes, especially with low limits like 2,
            // goes into a 400 error. We try then to call with a higher limit
            // and manually slice the result
            if ($e->getCode() !== 400) {
                throw $e;
            }

            $response = $this->fetchTweetsRequest($accountId, 20, $pagination_token, $filters);

            $data = $response['data'] ?? [];
            $response['data'] = array_slice($data, 0, min($limit, 100));

            return $response;
        }
    }

    private function mapTweets(array $data, array $includes): array
    {
        $users = $this->indexUsers($includes['users'] ?? []);
        $medias = $this->indexMedias($includes['media'] ?? []);

        return array_map(function (array $tweet) use ($users, $medias) {
            return $this->mapTweetData($users, $tweet, $medias);
        }, $data);
    }

    private function fetchTweetsRequest(string $accountId, int $limit = 20, ?string $paginationToken = null, array $filters = []): array
    {
        return $this->get("users/{$accountId}/tweets", array_filter([
            'tweet.fields' => implode(',', self::TWEET_FIELDS),
            'user.fields' => implode(',', self::USER_FIELDS),
            'media.fields' => implode(',', self::MEDIA_FIELDS),
            'expansions' => 'author_id,in_reply_to_user_id,attachments.media_keys',
            'max_results' => $limit,
            'pagination_token' => $paginationToken,
            'start_time' => $filters['start_time'] ?? null,
            'end_time' => $filters['end_time'] ?? null,
        ]));
    }
}
