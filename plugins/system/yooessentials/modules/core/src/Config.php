<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Config\ConfigInterface;
use ZOOlanders\YOOessentials\Config\ConfigRepositoryInterface;
use ZOOlanders\YOOessentials\Config\ConfigStorage;

class Config extends ConfigStorage implements ConfigInterface
{
    /** @var ConfigRepositoryInterface */
    private $repository;

    public function __construct(ConfigRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->repository->load($this);

        $values = Event::emit('yooessentials.config.load|filter', $this->values);

        if (is_array($values)) {
            $this->values = $values;
        }
    }
}
