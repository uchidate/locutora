<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\YouTube;

use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class YouTubePlaylistSource extends YouTubeChannelSource
{
    /** @var string */
    public $playlist;

    /** @var string */
    protected $configFile = 'config-playlist.json';

    public function bind(array $config): SourceInterface
    {
        parent::bind($config);

        $this->account = $config['account'] ?? null;
        $this->playlist = $config['playlist_id'] ?? null;

        return $this;
    }

    public function types(): array
    {
        $objectType = new Type\YouTubeVideoType();

        return [
            $objectType,
            new Type\YouTubePlaylistVideosQueryType($this, $objectType)
        ];
    }
}
