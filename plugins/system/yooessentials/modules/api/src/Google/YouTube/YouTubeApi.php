<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\YouTube;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Auth\Auth;
use ZOOlanders\YOOessentials\Vendor\Google\Client;
use ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube;

class YouTubeApi implements YouTubeApiInterface
{
    /** @var Auth */
    private $auth;

    /** @var Client */
    private $client;

    /** @var YouTube */
    private $service;

    public function channels(array $filters = []): array
    {
        try {
            $result = $this->service->channels->listChannels('id,snippet,contentDetails', array_merge([
                'maxResults' => 50
            ], $filters));
        } catch (\Exception $e) {
            $this->processException($e);
        }

        return $result['items'];
    }

    public function playlists(array $filters = []): array
    {
        try {
            $result = $this->service->playlists->listPlaylists('id,snippet', array_merge([
                'maxResults' => 50
            ], $filters));
        } catch (\Exception $e) {
            $this->processException($e);
        }

        return $result['items'];
    }

    public function videos(array $ids): array
    {
        if (!count($ids)) {
            return [];
        }

        try {
            $items = $this->service->videos->listVideos('snippet,contentDetails,statistics', [
                'id' => $ids
            ])->getItems();

            return $this->parseVideos($items);
        } catch (\Exception $e) {
            $this->processException($e);
        }

        return [];
    }

    /**
     * https://developers.google.com/youtube/v3/docs/search/list
     */
    public function searchVideos(array $filters): array
    {
        try {
            $items = $this->service->search->listSearch('snippet', array_merge([
                'maxResults' => 50
            ], $filters))->getItems();

            return $this->videos(array_map(function ($item) {
                return $item->id->videoId;
            }, $items));
        } catch (\Exception $e) {
            $this->processException($e);
        }

        return [];
    }

    public function channelVideos(string $channelId, array $filters = []): array
    {
        try {
            $channel = $this->channels(['id' => $channelId]);
            $playlistId = $channel[0]['contentDetails']['relatedPlaylists']['uploads'] ?? '';

            if ($playlistId) {
                return $this->playlistVideos($playlistId, $filters);
            }
        } catch (\Exception $e) {
            $this->processException($e);
        }

        return [];
    }

    public function playlistVideos(string $playlistId, array $filters = []): array
    {
        try {
            $items = $this->service->playlistItems->listPlaylistItems('contentDetails', array_merge(
                ['maxResults' => 50],
                $filters,
                ['playlistId' => $playlistId]
            ))->getItems();

            return $this->videos(array_map(function ($item) {
                return $item->contentDetails->videoId;
            }, $items));
        } catch (\Exception $e) {
            $this->processException($e);
        }

        return [];
    }

    protected function parseVideos(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $id = $item->id->videoId ?? $item->id;
            $thumbs = $item->snippet->thumbnails;

            $result[] = [
                'id' => $id,
                'title' => $item->snippet->title,
                'description' => $item->snippet->description,
                'duration' => $item->contentDetails->duration,
                'publishedAt' => $item->snippet->publishedAt,
                'viewCount' => $item->statistics->viewCount,
                'commentCount' => $item->statistics->commentCount,
                'dislikeCount' => $item->statistics->dislikeCount,
                'favoriteCount' => $item->statistics->favoriteCount,
                'thumbnails' => [
                    'default' => $thumbs->getDefault() ?? [],
                    'standard' => $thumbs->getMedium() ?? [],
                    'medium' => $thumbs->getHigh() ?? [],
                    'high' => $thumbs->getStandard() ?? [],
                    'maxres' => $thumbs->getMaxres() ?? [],
                ]
            ];
        }

        return $result;
    }

    public function forAccount(Auth $account): YouTubeApiInterface
    {
        $this->auth = $account;

        /** @var Client $client */
        $this->client = app(Client::class);

        $this->client->setAccessToken([
            'expires_in' => $this->auth->expiresIn(),
            'access_token' => $this->auth->accessToken(),
            'refresh_token' => $this->auth->refreshToken(),
        ]);

        // there can be 2 clients with different configs, don't cache them together
        $this->client->setCacheConfig([
            'prefix' => 'youtube-client-' . sha1($this->auth->refreshToken())
        ]);

        $this->service = new YouTube($this->client);

        return $this;
    }

    public function withApiKey(Auth $key): YouTubeApiInterface
    {
        $this->auth = $key;

        /** @var Client $client */
        $this->client = app(Client::class);

        $this->client->setDeveloperKey($this->auth->key);

        // there can be 2 clients with different configs, don't cache them together
        $this->client->setCacheConfig([
            'prefix' => 'youtube-client-' . sha1($this->auth->key)
        ]);

        $this->service = new YouTube($this->client);

        return $this;
    }

    public function processException(\Exception $e): array
    {
        $result = json_decode($e->getMessage(), true) ?? [];

        $code = $result['error']['code'] ?? $e->getCode();
        $message = $result['error']['message'] ?? $e->getMessage();

        throw new \Exception($message, $code);
    }
}
