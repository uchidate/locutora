<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Joomla;

use YOOtheme\Arr;
use YOOtheme\Config;
use ZOOlanders\YOOessentials\Access\AbstractRule;

class UserRule extends AbstractRule
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function group(): string
    {
        return 'user';
    }

    public function name(): string
    {
        return 'User';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_user';
    }

    public function description(): string
    {
        return 'Validates against the User ID or Username.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->users)) {
            throw new \RuntimeException('Not Valid Input');
        }

        $users = $props->users;
        $currentUser = $this->config->get('user');

        if (is_string($users)) {
            $users = explode(',', str_replace([' ', "\r", "\n"], ['', '', ','], $users));
        }

        return Arr::some($users, function ($user) use ($currentUser) {
            return (int) $currentUser->id === (int) $user or $currentUser->username === $user;
        });
    }

    public function fields(): array
    {
        return [
            'users' => [
                'label' => 'List',
                'source' => true,
                'type' => 'textarea',
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "346\nusername"
                ],
                'description' => 'A list of User ID or Usernames that the current user must match. Separate the entries with a comma and/or new line.'
            ]
        ];
    }
}
