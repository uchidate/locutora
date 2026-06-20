<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use function YOOtheme\app;
use YOOtheme\Builder;
use ZOOlanders\YOOessentials\Form\Actions\ActionInstance;
use ZOOlanders\YOOessentials\Form\Actions\ActionManager;

class Form
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Builder
     */
    protected $builder = [];

    public function __construct(string $id, array $config = [])
    {
        $this->id = $id;
        $this->config = $config;
        $this->builder = app(Builder::class);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function config(): array
    {
        return $this->config;
    }

    public function controls(): array
    {
        return $this->config()['controls'] ?? [];
    }

    public function control(string $name): array
    {
        foreach ($this->controls() as $control) {
            $controlName = $control['name'] ?? false;
            if ($controlName !== $name) {
                continue;
            }

            return $control;
        }

        return [];
    }

    public function hasActions(): bool
    {
        return count($this->actions()) > 0;
    }

    public function hasExternalActionUrl(): bool
    {
        $config = $this->config();

        return ($config['override_action_url'] ?? false) && strlen($config['action_url'] ?? '') > 0;
    }

    public function hasAction(string $action): bool
    {
        $actions = $this->actionsByType()[$action] ?? [];

        return count(array_filter($actions, function (?ActionInstance $action) {
            return $action && $action->shouldRun();
        })) > 0;
    }

    /**
     * @param string $action
     * @return ActionInstance[]
     */
    public function actionConfigs(string $action): array
    {
        return $this->actionsByType()[$action] ?? [];
    }

    /**
     * @return ActionInstance[]
     */
    public function actions(): array
    {
        /** @var ActionManager $actionManager */
        $actionManager = app(ActionManager::class);

        $actions = array_filter(array_map(function (array $config) use ($actionManager) {
            return $actionManager->actionFromConfig((array) $config);
        }, $this->config()['after_submit_actions'] ?? []));

        $actions = array_filter($actions, function ($action) {
            return ($action->config()['status'] ?? true) !== 'disabled';
        });

        return $actions;
    }

    /**
     * @return ActionInstance[][]
     */
    public function actionsByType(): array
    {
        return array_reduce($this->actions(), function ($carry, ActionInstance $action) {
            $carry[$action->action()->name()][$action->id()] = $action;

            return $carry;
        }, []);
    }
}
