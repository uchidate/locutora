<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database;

use RuntimeException;

class InvalidRelationConfigException extends RuntimeException
{
    /** @var array */
    protected $config;

    public function __construct(string $message, array $config = [])
    {
        $message = "Invalid Relation configuration: $message.";

        $this->config = $config;

        parent::__construct($message, 400);
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
