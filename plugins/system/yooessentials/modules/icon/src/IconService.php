<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon;

class IconService
{
    /**
     * @var IconLoader
     */
    public $loader;

    /**
     * Constructor.
     */
    public function __construct(IconLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Adds icon collections from path.
     *
     * @param string $dir
     * @return $this
     */
    public function addCollectionPath(string $dir): self
    {
        $this->loader->addCollectionPath($dir);

        return $this;
    }
}
