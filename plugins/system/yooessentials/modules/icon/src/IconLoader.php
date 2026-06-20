<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon;

use function YOOtheme\app;
use YOOtheme\Config;
use YOOtheme\File;
use YOOtheme\Path;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;

class IconLoader
{
    /**
     * Queue for icons to be loaded
     *
     * @var array
     */
    protected $queue = [];

    /**
     * List of rendered icons
     *
     * @var array
     */
    protected $rendered = [];

    /**
     * The collections main location.
     *
     * @var string
     */
    protected $location;

    /**
     * Additional collection locations.
     *
     * @var array
     */
    protected $locations = [];

    /**
     * @var array
     */
    public $collections = [];

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param string $location The collections main location
     */
    public function __construct(Config $config, CacheInterface $cache, string $location)
    {
        $this->cache = $cache;
        $this->config = $config;
        $this->location = $location;

        $this->addLocation($location);
        $this->addCollectionPath("$location/*.json");
    }

    public function yetToRender(array $icons = []): array
    {
        $icons = array_merge($this->queued(), $icons);

        return array_diff_key($icons, $this->rendered());
    }

    public function queued(): array
    {
        return $this->queue;
    }

    public function rendered(): array
    {
        return $this->rendered;
    }

    public function collections(): array
    {
        return $this->collections;
    }

    public function location(): string
    {
        return $this->location;
    }

    public function locations(): array
    {
        return $this->locations;
    }

    public function addCollection(array $manifest): self
    {
        // legacy, support collections with no name set
        if (!isset($manifest['name'])) {
            $manifest['name'] = str_replace(' ', '', Str::lower($manifest['title']));
        }

        $name = $manifest['name'];

        // legacy, suppport old manifest structure
        if ($manifest['meta'] ?? false) {
            $manifest = array_merge($manifest['meta'] ?? [], $manifest);
            unset($manifest['meta']);
        }

        // set install state
        if (app()->config->get('app.isCustomizer') && $this->isCollectionInstalled($name)) {
            $installed = json_decode(File::getContents("$this->location/$name.json"), true);
            $manifest['installed'] = $installed['version'] ?? '';
        }

        // if already added, merge manifests
        if ($collection = $this->collections[$name] ?? false) {
            $manifest = array_merge($collection->data, $manifest);
        }

        $this->collections[$name] = new Collection($manifest);

        return $this;
    }

    public function addCollectionPath($paths, $basePath = null): self
    {
        foreach ((array) $paths as $path) {
            $files = glob(Path::resolve($basePath, $path));
            $collections = array_map([$this->config, 'loadFile'], $files ?: []);

            foreach ($collections as $collection) {
                $this->addCollection($collection);
            }
        }

        return $this;
    }

    public function getTotalIcons($dir): int
    {
        return count(File::glob("$dir/{,*/}*.svg"));
    }

    public function getCollectionGroups($dir): array
    {
        $icons = File::glob("$dir/*.svg");
        $folders = File::glob("$dir/*", GLOB_ONLYDIR);

        $groups = array_values(array_map(function ($v) {
            return basename($v);
        }, $folders));

        if (count($icons)) {
            array_unshift($groups, '__main');
        }

        return $groups;
    }

    public function addLocation(string $location): self
    {
        $location = Path::resolveAlias($location);

        if (!File::isDir($location)) {
            File::makeDir($location, 0777, true);
        }

        $this->locations[] = $location;

        return $this;
    }

    public function isCollectionInstalled(string $name): bool
    {
        return File::exists("$this->location/$name") && File::exists("$this->location/$name.json");
    }

    public function loadIcon(string $icon): ?string
    {
        $isProvided = Str::contains($icon, '--');

        if (!$isProvided) {
            return null;
        }

        $cacheKey = sha1("icon-{$icon}.svg");
        $content = $this->cache->get($cacheKey, function () use ($icon) {
            if ($file = $this->findIcon($icon)) {
                return File::getContents($file);
            }

            return null;
        });

        // null cache if invalid icon
        if (!$content) {
            $this->cache->delete($cacheKey);

            return null;
        }

        $this->queue[$icon] = $content;

        return $content;
    }

    public function addRenderedIcons(array $icons): ?self
    {
        $this->rendered = array_merge($this->rendered, $icons);

        return $this;
    }

    /**
     * Finds the icon and returns it first location path
     */
    protected function findIcon(string $icon): ?string
    {
        list('collection' => $collection, 'group' => $group, 'name' => $name) = $this->parseIconKey($icon);

        $basepath = Path::join($group, $name);

        if ($collection === 'myicons' && $dir = $this->config->get('theme.childDir')) {
            if ($file = File::find("/$dir/myicons/$basepath.svg")) {
                return $file;
            }
        }

        foreach ($this->locations as $dir) {
            if ($file = File::find("$dir/$collection/$basepath.svg")) {
                return $file;
            }
        }

        return null;
    }

    /**
     * Parse icon info from it value
     */
    protected function parseIconKey(string $key): array
    {
        preg_match('/^([^-]*)-?(.*)--(.*)$/', $key, $matches);
        list($match, $collection, $group, $name) = $matches;

        return compact('collection', 'group', 'name');
    }

    /**
     * Retrieve icons from a node
     */
    public function retrieveIcons($node, $type): array
    {
        return array_unique(array_merge(
            $this->_retrieveIconsFields($node, $type),
            $this->_retrieveIconsHtml($node, $type)
        ));
    }

    /**
     * Retrieve icons from known icon fields
     */
    public function _retrieveIconsFields($node, $type): array
    {
        $icons = [];
        $fields = $type->data['fields'] ?? [];

        // get all fields with name including 'icon'
        $fieldsKeys = array_filter(array_keys($fields), function ($key) {
            return strpos($key ?? '', 'icon') !== false;
        });

        foreach ($fieldsKeys as $key) {
            $value = $node->props[$key] ?? false;

            if (is_string($value)) {
                // icon could be set raw or with attributes (unusual but still expected),
                // we always explode and assume the icon name is set first
                list($iconName) = explode(';', $value);

                $icons[] = trim($iconName);
            }
        }

        return $icons;
    }

    /**
     * Retrieve icons from HTML declarations, eg <span uk-icon/>
     */
    protected function _retrieveIconsHtml($node, $type): array
    {
        $icons = [];
        $content = [];

        // iterate fields content
        foreach (array_keys($type->data['fields'] ?? []) as $key) {
            if ($value = $node->props[$key] ?? false and is_string($value)) {
                $content[] = $value;
            }
        }

        // iterate source content filters (those can store html)
        foreach ($node->source->props->source->filters ?? [] as $value) {
            if (is_string($value)) {
                $content[] = $value;
            }
        }

        // match all icons set as html
        foreach ($content as $value) {
            if (strpos($value, 'uk-icon') !== false) {
                if (preg_match_all('/<[^\/]*?uk-icon.*?>/', $value, $allMatches)) {
                    foreach ($allMatches[0] as $match) {
                        if (preg_match('/[\w-]*--[\w-]*/', $match, $matches)) {
                            $icons[] = $matches[0];
                        }
                    }
                }
            }
        }

        return $icons;
    }
}
