<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Config;

class ConfigUpdater
{
    /**
     * @var string
     */
    protected $version;

    /**
     * @var array
     */
    protected $updates = [];

    /**
     * @var array
     */
    protected $globals = [];

    /**
     * Constructor.
     *
     * @param string $version
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * Transform callback.
     */
    public function __invoke($config)
    {
        $version = empty($config['version']) ? '1.0.0' : $config['version'];

        // check config version
        if (version_compare($version, $this->version, '>=')) {
            return $config;
        }

        $sha = sha1(json_encode($config));

        // apply update callbacks
        foreach ($this->resolveUpdates($version) as $update) {
            $config = $update($config);
        }

        $config['version'] = $this->version;

        // give a hint to customizer there was an update
        $config['updated'] = $sha !== sha1(json_encode($config));

        return $config;
    }

    /**
     * Adds global updates.
     */
    public function addGlobals(array $updates): self
    {
        $this->globals[] = $updates['config'] ?? [];

        return $this;
    }

    /**
     * Resolves updates for a type and current version.
     */
    protected function resolveUpdates(string $version): array
    {
        if (isset($this->updates[$version])) {
            return $this->updates[$version];
        }

        $updates = $this->globals;

        $resolved = [];

        foreach ($updates as $update) {
            foreach ($update as $ver => $func) {
                if (version_compare($ver, $version, '>=') && is_callable($func)) {
                    $resolved[$ver][] = $func;
                }
            }
        }

        uksort($resolved, 'version_compare');

        return $this->updates[$version] = $resolved ? array_merge(...array_values($resolved)) : [];
    }
}
