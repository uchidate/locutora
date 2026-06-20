<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon;

use YOOtheme\Config;
use YOOtheme\File;
use YOOtheme\HttpClientInterface;
use ZOOlanders\YOOessentials\Unzipper;

class IconApi
{    /**
     * @var Config
     */
    public $config;

    /**
     * @var HttpClientInterface
     */
    public $client;

    /**
     * @var Unzipper
     */
    public $unzipper;

    /**
     * @var IconLoader
     */
    public $loader;

    /**
     * Constructor.
     */
    public function __construct(Config $config, HttpClientInterface $client, IconLoader $loader, Unzipper $unzipper)
    {
        $this->config = $config;
        $this->loader = $loader;
        $this->client = $client;
        $this->unzipper = $unzipper;
    }

    /**
     * Load collection package.
     */
    public function loadCollection(string $name): void
    {
        $manifest = $this->loader->collections()[$name];

        if (!$manifest) {
            throw new \Exception('Unknown collection: ' . $name);
        }

        if (File::exists("{$this->loader->location()}/$name") && File::exists("{$this->loader->location()}/$name.json")) {
            return;
        }

        if (!$manifest->package) {
            throw new \Exception('Missing package url in collection manifest.');
        }

        $tmp = $this->config->get('app.tempDir') . '/' . uniqid();
        $packed = "$tmp/package.zip";
        $unpacked = "$tmp/package";

        try {
            $data = $this->downloadCollection($manifest);
        } catch (\Exception $e) {
            throw new \Exception("Failed to download '$name' collection.");
        }

        if (!File::makeDir($unpacked, 0777, true)) {
            throw new \Exception('Failed to create temp folder.');
        }

        File::putContents($packed, $data);

        $this->unzipper->unzip($packed, $unpacked);

        $manifest = File::glob("$unpacked/*.json")[0] ?? false;

        if (!$manifest) {
            throw new \Exception('Missing manifest file in downloaded package.');
        }

        $manifest = json_decode(File::getContents($manifest), true);
        $name = $manifest['name'] ?? false;

        if (!$name) {
            throw new \Exception('Missing name in downloaded package manifest.');
        }

        $this->unzipper->unzip($packed, $this->loader->location());

        // update manifest
        $manifest['installed'] = $manifest['version'];
        File::putContents("{$this->loader->location()}/$name.json", json_encode($manifest, JSON_PRETTY_PRINT));

        $this->loader->addCollection($manifest);
    }

    public function downloadCollection($manifest): string
    {
        $response = $this->client->get($manifest->package);

        return (string) $response->getBody();
    }

    /**
     * Remove installed collection.
     */
    public function removeCollection(string $name): void
    {
        $manifest = $this->loader->collections()[$name];

        if (!$manifest) {
            throw new \Exception('Unknown collection: ' . $name);
        }

        // skip if already removed
        if (!(File::exists("{$this->loader->location()}/$name") && File::exists("{$this->loader->location()}/$name.json"))) {
            return;
        }

        File::delete("{$this->loader->location()}/$name.json");
        File::deleteDir("{$this->loader->location()}/$name");
    }

    /**
     * Fetch icons for UI related task.
     */
    public function fetchIcons($offset, $length, $search = null, $collection = null, $group = null): array
    {
        $collections = array_keys($this->loader->collections());
        $isMyicons = $collection === 'myicons';

        $locations = $isMyicons
            ? [$this->config->get('theme.childDir')]
            : $this->loader->locations();

        if (empty($locations)) {
            throw new \Exception('Locations are empty.');
        }

        $namePattern = $search ? "*$search*" : '*';
        $collectionPattern = $collection ? "/$collection/" : '/*/';
        $groupPattern = $group === '__main' ? '' : ($group ? "$group/" : '{,*/}');

        $pattern = '{' . implode(',', $locations) . '}' . $collectionPattern . $groupPattern . "$namePattern.svg";

        $icons = File::glob($pattern);
        $total = count($icons);
        $icons = array_splice($icons, $offset, $length);

        $data = new \stdClass;

        array_walk($icons, function ($path) use ($collections, $data, $isMyicons) {
            $group = basename(dirname($path));
            $collection = $isMyicons ? 'myicons' : basename(dirname(dirname($path)));

            if (!$isMyicons && !in_array($collection, $collections)) {
                $collection = $group;
                $group = null;
            }

            $icon = basename($path, '.svg');
            $content = File::getContents($path);

            $key = $group && $group !== 'myicons'
                ? sprintf('%s-%s--%s', $collection, $group, $icon)
                : sprintf('%s--%s', $collection, $icon);

            $data->$key = $content;
        });

        return compact('data', 'total', 'offset', 'length', 'search', 'collection', 'group');
    }
}
