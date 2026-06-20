<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Joomla;

use YOOtheme\Config;
use YOOtheme\Database;
use ZOOlanders\YOOessentials\Access\AbstractRule;

class UserAccessRule extends AbstractRule
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Database
     */
    private $db;

    public function __construct(Config $config, Database $db)
    {
        $this->config = $config;
        $this->db = $db;
    }

    public function group(): string
    {
        return 'user';
    }

    public function name(): string
    {
        return 'User Access';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_useraccess';
    }

    public function description(): string
    {
        return 'Validates against the User Access Level.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->levels)) {
            throw new \RuntimeException('Not Valid Input');
        }

        $user = $this->config->get('user');
        $props = $this->parseProps($props, $node);
        $userLevels = $user->getAuthorisedViewLevels();

        $missingLevels = array_diff($props['levels'], $userLevels);

        return $props['strict']
            ? count($missingLevels) === 0
            : count($missingLevels) < count($props['levels']);
    }

    public function parseProps($props, $node): array
    {
        $levels = (array) ($props->levels ?? []);
        $strict = $props->strict ?? false;

        return compact('levels', 'strict');
    }

    public function fields(): array
    {
        return [
            'levels' => [
                'label' => 'Levels',
                'type' => 'select',
                'source' => true,
                'description' => 'The access levels that the current user must met. Use the shift or ctrl/cmd key to select multiple entries.',
                'attrs' => [
                    'multiple' => true,
                    'class' => 'uk-height-small uk-resize-vertical'
                ],
                'options' => $this->getUserAccessLevels()
            ],
            'strict' => [
                'text' => 'All selected levels must be met',
                'type' => 'checkbox',
                'source' => true,
            ]
        ];
    }

    protected function getUserAccessLevels(): array
    {
        static $accessLevels = [];

        if (empty($accessLevels)) {
            $query = 'SELECT a.id AS value, a.title AS text
                FROM #__viewlevels AS a
                GROUP BY a.id, a.title, a.ordering
                ORDER BY a.ordering ASC';

            // Get the user access levels from the database.
            foreach ($this->db->fetchAllObjects($query) as $access) {
                $accessLevels[$access->text] = $access->value;
            }
        }

        return $accessLevels;
    }
}
