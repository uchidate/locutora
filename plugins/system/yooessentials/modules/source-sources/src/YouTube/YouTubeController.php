<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\YouTube;

use function YOOtheme\app;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\Google\YouTube\YouTubeApiInterface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;

class YouTubeController
{
    use LoadsSourceFromArgs;

    /**
     * @var string
     */
    public const PRESAVE_ENDPOINT = 'yooessentials/source/youtube';

    /**
     * @var string
     */
    public const GET_VIDEOS_ENDPOINT = 'yooessentials/source/youtube/videos';

    /**
     * @var string
     */
    public const GET_CHANNELS_ENDPOINT = 'yooessentials/source/youtube/channels';

    /**
     * @var string
     */
    public const GET_PLAYLISTS_ENDPOINT = 'yooessentials/source/youtube/playlists';

    public function presave(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $account = $form['account'] ?? null;
        $provider = $form['provider'] ?? null;
        $channelId = $form['channel_id'] ?? null;
        $playlistId = $form['playlist_id'] ?? null;

        if (!$account && $provider !== 'youtube') {
            return $response->withJson('Account must be specified.', 400);
        }

        if ($provider === 'youtube_channel' && !$channelId) {
            return $response->withJson('Channel must be specified.', 400);
        }

        if ($provider === 'youtube_playlist' && !$playlistId) {
            return $response->withJson('Playlist must be specified.', 400);
        }

        return $response->withStatus(200);
    }

    public function videos(Request $request, Response $response)
    {
        try {
            $source = self::loadSource($request->getParsedBody(), GoogleMyBusinessSource::class);
            $channelId = $source->channel;
            $videos = $source->api()->channelVideos($channelId, ['maxResults' => 50]);

            $items = array_map(function ($video) {
                return [
                    'text' => $video['title'],
                    'value' => $video['id'],
                    'meta' => $video['id'],
                ];
            }, $videos);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    public function channels(Request $request, Response $response)
    {
        $form = $request->getParam('form');

        try {
            $api = $this->initApi($form);
            $channels = $api->channels(['mine' => true, 'maxResults' => 50]);

            $items = array_map(function ($channel) {
                return [
                    'text' => $channel->snippet->title,
                    'value' => $channel->id,
                    'meta' => $channel->id,
                ];
            }, $channels);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    public function playlists(Request $request, Response $response)
    {
        $form = $request->getParam('form');

        try {
            $api = $this->initApi($form);
            $playlists = $api->playlists(['mine' => true, 'maxResults' => 50]);

            $items = array_map(function ($playlist) {
                return [
                    'text' => $playlist->snippet->title,
                    'value' => $playlist->id,
                    'meta' => $playlist->id,
                ];
            }, $playlists);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    protected function initApi(array $data): YouTubeApiInterface
    {
        $account = $data['account'] ?? null;

        if (!$account) {
            throw new \Exception('Account must be specified.');
        }

        $authManager = app(AuthManager::class);
        $auth = $authManager->auth($account);

        if (!$auth) {
            throw new \Exception('Invalid Auth.');
        }

        if (!$auth->accessToken ?? false) {
            throw new \Exception('Account Token is invalid.');
        }

        return app(YouTubeApiInterface::class)->forAccount($auth);
    }
}
