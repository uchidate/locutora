<?php

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
namespace ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets;

class UpdateBordersRequest extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $bottomType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border::class;
    protected $bottomDataType = '';
    protected $innerHorizontalType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border::class;
    protected $innerHorizontalDataType = '';
    protected $innerVerticalType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border::class;
    protected $innerVerticalDataType = '';
    protected $leftType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border::class;
    protected $leftDataType = '';
    protected $rangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange::class;
    protected $rangeDataType = '';
    protected $rightType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border::class;
    protected $rightDataType = '';
    protected $topType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border::class;
    protected $topDataType = '';
    /**
     * @param Border
     */
    public function setBottom(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border $bottom)
    {
        $this->bottom = $bottom;
    }
    /**
     * @return Border
     */
    public function getBottom()
    {
        return $this->bottom;
    }
    /**
     * @param Border
     */
    public function setInnerHorizontal(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border $innerHorizontal)
    {
        $this->innerHorizontal = $innerHorizontal;
    }
    /**
     * @return Border
     */
    public function getInnerHorizontal()
    {
        return $this->innerHorizontal;
    }
    /**
     * @param Border
     */
    public function setInnerVertical(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border $innerVertical)
    {
        $this->innerVertical = $innerVertical;
    }
    /**
     * @return Border
     */
    public function getInnerVertical()
    {
        return $this->innerVertical;
    }
    /**
     * @param Border
     */
    public function setLeft(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border $left)
    {
        $this->left = $left;
    }
    /**
     * @return Border
     */
    public function getLeft()
    {
        return $this->left;
    }
    /**
     * @param GridRange
     */
    public function setRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange $range)
    {
        $this->range = $range;
    }
    /**
     * @return GridRange
     */
    public function getRange()
    {
        return $this->range;
    }
    /**
     * @param Border
     */
    public function setRight(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border $right)
    {
        $this->right = $right;
    }
    /**
     * @return Border
     */
    public function getRight()
    {
        return $this->right;
    }
    /**
     * @param Border
     */
    public function setTop(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Border $top)
    {
        $this->top = $top;
    }
    /**
     * @return Border
     */
    public function getTop()
    {
        return $this->top;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateBordersRequest::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_UpdateBordersRequest');
