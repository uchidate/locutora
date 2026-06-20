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

class UserGroupRule extends AbstractRule
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
        $this->db = $db;
        $this->config = $config;
    }

    public function group(): string
    {
        return 'user';
    }

    public function name(): string
    {
        return 'User Group';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_usergroup';
    }

    public function description(): string
    {
        return 'Validates against the User Group.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->levels)) {
            throw new \RuntimeException('Not Valid Input');
        }

        $user = $this->config->get('user');
        $props = $this->parseProps($props, $node);
        $userLevels = $user->getAuthorisedGroups();

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
                'label' => 'Groups',
                'type' => 'select',
                'source' => true,
                'description' => 'The groups that the current user must met. Use the shift or ctrl/cmd key to select multiple entries.',
                'attrs' => [
                    'multiple' => true,
                    'class' => 'uk-height-small uk-resize-vertical'
                ],
                'options' => $this->getUserGroupLevels()
            ],
            'strict' => [
                'text' => 'All selected groups must be met',
                'type' => 'checkbox',
                'source' => true,
            ],
        ];
    }

    protected function getUserGroupLevels(): array
    {
        static $groupLevels = [];

        if (empty($groupLevels)) {
            $query = 'SELECT a.id, a.title, a.parent_id AS parent, COUNT(DISTINCT b.id) AS level
                FROM #__usergroups AS a
                LEFT JOIN `#__usergroups` AS b ON a.lft > b.lft AND a.rgt < b.rgt
                GROUP BY a.id
                ORDER BY a.lft ASC';

            // Get the user group levels from the database.
            foreach ($this->db->fetchAllObjects($query) as $group) {
                $item_name = $group->title;

                for ($i = 1; $i <= $group->level; $i++) {
                    $item_name = '| - ' . $item_name;
                }

                $groupLevels[$item_name] = $group->id;
            }
        }

        return $groupLevels;
    }
}
