<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\Respect\Validation\Rules;

use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ComponentException;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Helpers\CanCompareValues;
/**
 * Validates whether the input is between two other values.
 *
 * @author Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 * @author Henrique Moody <henriquemoody@gmail.com>
 */
final class Between extends \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Rules\AbstractEnvelope
{
    use CanCompareValues;
    /**
     * Initializes the rule.
     *
     * @param mixed $minValue
     * @param mixed $maxValue
     *
     * @throws ComponentException
     */
    public function __construct($minValue, $maxValue)
    {
        if ($this->toComparable($minValue) >= $this->toComparable($maxValue)) {
            throw new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ComponentException('Minimum cannot be less than or equals to maximum');
        }
        parent::__construct(new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Rules\AllOf(new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Rules\Min($minValue), new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Rules\Max($maxValue)), ['minValue' => $minValue, 'maxValue' => $maxValue]);
    }
}
