<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver\Orders;

class InvalidOrderException extends \RuntimeException
{
    public static function create(string $message, array $config): self
    {
        return new InvalidOrderException($message . ' - Configuration: '  . json_encode($config));
    }
}
