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

use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Helpers\CanValidateUndefined;
use function in_array;
/**
 * Abstract class for searches into arrays.
 *
 * @author Henrique Moody <henriquemoody@gmail.com>
 */
abstract class AbstractSearcher extends \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Rules\AbstractRule
{
    use CanValidateUndefined;
    /**
     * {@inheritDoc}
     */
    public function validate($input) : bool
    {
        $dataSource = $this->getDataSource();
        if ($this->isUndefined($input) && empty($dataSource)) {
            return \true;
        }
        return \in_array($input, $dataSource, \true);
    }
    /**
     * @return mixed[]
     */
    protected abstract function getDataSource() : array;
}
