<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use Joomla\Archive\Archive as JoomlaUnzipper;
use ZOOlanders\YOOessentials\Unzipper as UnzipperInterface;

class Unzipper implements UnzipperInterface
{
    /**
     * @var JoomlaUnzipper
     */
    public $unzipper;

    /**
     * Constructor.
     */
    public function __construct(JoomlaUnzipper $unzipper)
    {
        $this->unzipper = new $unzipper;
    }

    public function unzip(string $file, string $dest): bool
    {
        return $this->unzipper->extract($file, $dest);
    }
}
