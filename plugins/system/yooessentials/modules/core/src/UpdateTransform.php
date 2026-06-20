<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

class UpdateTransform
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
     */
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    /**
     * Transform callback.
     */
    public function __invoke(object $node, array &$params)
    {
        if (isset($node->transient)) {
            return;
        }

        if (isset($node->yooessentialsVersion)) {
            $params['yooessentialsVersion'] = $node->yooessentialsVersion;
        } elseif (empty($params['yooessentialsVersion'])) {
            $params['yooessentialsVersion'] = '1.0.0';
        }

        if (empty($params['parent'])) {
            $node->yooessentialsVersion = $this->version;
        } else {
            unset($node->yooessentialsVersion);
        }

        $version = $params['yooessentialsVersion'] ?? '';

        // check node version
        if (version_compare($version, $this->version, '>=')) {
            return;
        }

        // apply update callbacks
        foreach ($this->resolveUpdates($params['type'], $version) as $update) {
            $update($node, $params);
        }
    }

    /**
     * Adds global updates for any type.
     */
    public function addGlobals(array $globals): self
    {
        $this->globals[] = $globals['nodes'] ?? [];

        return $this;
    }

    /**
     * Resolves updates for a type and current version.
     */
    protected function resolveUpdates(object $type, string $version): array
    {
        if (isset($this->updates[$type->name][$version])) {
            return $this->updates[$type->name][$version];
        }

        $updates = $this->globals;

        // get only yooessentials scoped updates
        if (isset($type->yooessentialsUpdates)) {
            $updates[] = $type->yooessentialsUpdates;
        }

        $resolved = [];

        foreach ($updates as $update) {
            foreach ($update as $ver => $func) {
                if (version_compare($ver, $version, '>') && is_callable($func)) {
                    $resolved[$ver][] = $func;
                }
            }
        }

        uksort($resolved, 'version_compare');

        return $this->updates[$type->name][$version] = $resolved ? array_merge(...array_values($resolved)) : [];
    }
}
