<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use Joomla\CMS\Session\Session as JoomlaSession;
use ZOOlanders\YOOessentials\Session as SessionInterface;

class Session implements SessionInterface
{
    /**
     * @var JoomlaSession
     */
    public $session;

    /**
     * Constructor.
     */
    public function __construct(JoomlaSession $session)
    {
        $this->session = $session;
    }

    public function has($name)
    {
        return $this->session->has($name);
    }

    public function get($name, $default = null)
    {
        return $this->session->get($name, $default);
    }

    public function set($name, $value)
    {
        return $this->session->set($name, $value);
    }

    public function clear($name)
    {
        return $this->session->clear($name);
    }

    public function start()
    {
        $this->session->start();
    }

    public function close()
    {
        $this->session->close();
    }
}
