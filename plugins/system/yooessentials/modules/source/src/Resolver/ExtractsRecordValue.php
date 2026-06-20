<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver;

use ZOOlanders\YOOessentials\Source\SourceService;

trait ExtractsRecordValue
{
    public static function extractRecordValue($field, $record)
    {
        foreach ($record as $key => $value) {
            if (SourceService::encodeField($field) !== SourceService::encodeField($key)) {
                continue;
            }

            return $value;
        }

        return null;
    }
}
