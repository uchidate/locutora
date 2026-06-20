<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Config;

use YOOtheme\Config as Yooconfig;

class YooconfigUpdater
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
    public function __invoke(Yooconfig $config)
    {
        if (!$this->version) {
            return;
        }

        if (!$config->get('~theme.yooessentials')) {
            return;
        }

        // current yooess config version
        $version = $config->get('~theme.yooessentials.version', '1.0.0');

        // check node version
        if (version_compare($version, $this->version, '>=')) {
            return;
        }

        // apply update callbacks
        foreach ($this->resolveUpdates($version) as $update) {
            $update($config);
        }

        // set new version
        $config->set('~theme.yooessentials.version', $this->version);
    }

    /**
     * Adds global updates.
     */
    public function addGlobals(array $updates): self
    {
        $this->globals[] = $updates['yooconfig'] ?? [];

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
                if (version_compare($ver, $version, '>') && is_callable($func)) {
                    $resolved[$ver][] = $func;
                }
            }
        }

        uksort($resolved, 'version_compare');

        return $this->updates[$version] = $resolved ? array_merge(...array_values($resolved)) : [];
    }
}
