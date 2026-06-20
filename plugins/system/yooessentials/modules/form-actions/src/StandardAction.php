<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions;

use ZOOlanders\YOOessentials\HasLocalConfig;

abstract class StandardAction implements Action
{
    use HasLocalConfig;

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    public function name(): string
    {
        return $this->config('name', '');
    }

    public function title(): string
    {
        return $this->config('title', '');
    }

    public function panel(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): Action
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config();
    }
}
