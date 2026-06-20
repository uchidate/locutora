<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Type;

use function array_filter;
use function dirname;
use function uniqid;
use function YOOtheme\app;
use YOOtheme\Config;
use YOOtheme\Path;

abstract class AbstractSourceType
{
    /** @var object */
    protected $metadata;

    /** @var array */
    protected $config = [];

    /** @var string */
    protected $configFile = 'config.json';

    /** @var string */
    protected $id;

    public function __construct(array $config = [])
    {
        $this->metadata = (object) app(Config::class)->loadFile($this->metadataFile());
        $this->bind($config);
    }

    public function config(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->config;
        }

        return $this->config[$key] ?? $default;
    }

    public function metadata(): object
    {
        return $this->metadata;
    }

    public function name(): string
    {
        $name = $this->config('name');

        return $name ?: ($this->metadata()->title ?? $this->metadata()->name ?? uniqid());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function bind(array $config): SourceInterface
    {
        $config = array_filter($config);
        $this->config = $config;
        $this->id = $this->idFromConfig($config);

        return $this;
    }

    protected function idFromConfig(array $config): string
    {
        return $config['id'] ?? '';
    }

    protected function metadataFile(): string
    {
        $basePath = new \ReflectionObject($this);
        $dir = dirname($basePath->getFileName());

        return Path::resolve($dir . '/' . $this->configFile);
    }
}
