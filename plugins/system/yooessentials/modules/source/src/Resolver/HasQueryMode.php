<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver;

trait HasQueryMode
{
    protected $mode = QueryMode::MODE_AND;

    public function mode(string $mode = QueryMode::MODE_AND): self
    {
        $this->mode = $mode;

        return $this;
    }
}
