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

class BandingProperties extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $firstBandColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $firstBandColorDataType = '';
    protected $firstBandColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $firstBandColorStyleDataType = '';
    protected $footerColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $footerColorDataType = '';
    protected $footerColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $footerColorStyleDataType = '';
    protected $headerColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $headerColorDataType = '';
    protected $headerColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $headerColorStyleDataType = '';
    protected $secondBandColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $secondBandColorDataType = '';
    protected $secondBandColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $secondBandColorStyleDataType = '';
    /**
     * @param Color
     */
    public function setFirstBandColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $firstBandColor)
    {
        $this->firstBandColor = $firstBandColor;
    }
    /**
     * @return Color
     */
    public function getFirstBandColor()
    {
        return $this->firstBandColor;
    }
    /**
     * @param ColorStyle
     */
    public function setFirstBandColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $firstBandColorStyle)
    {
        $this->firstBandColorStyle = $firstBandColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getFirstBandColorStyle()
    {
        return $this->firstBandColorStyle;
    }
    /**
     * @param Color
     */
    public function setFooterColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $footerColor)
    {
        $this->footerColor = $footerColor;
    }
    /**
     * @return Color
     */
    public function getFooterColor()
    {
        return $this->footerColor;
    }
    /**
     * @param ColorStyle
     */
    public function setFooterColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $footerColorStyle)
    {
        $this->footerColorStyle = $footerColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getFooterColorStyle()
    {
        return $this->footerColorStyle;
    }
    /**
     * @param Color
     */
    public function setHeaderColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $headerColor)
    {
        $this->headerColor = $headerColor;
    }
    /**
     * @return Color
     */
    public function getHeaderColor()
    {
        return $this->headerColor;
    }
    /**
     * @param ColorStyle
     */
    public function setHeaderColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $headerColorStyle)
    {
        $this->headerColorStyle = $headerColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getHeaderColorStyle()
    {
        return $this->headerColorStyle;
    }
    /**
     * @param Color
     */
    public function setSecondBandColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $secondBandColor)
    {
        $this->secondBandColor = $secondBandColor;
    }
    /**
     * @return Color
     */
    public function getSecondBandColor()
    {
        return $this->secondBandColor;
    }
    /**
     * @param ColorStyle
     */
    public function setSecondBandColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $secondBandColorStyle)
    {
        $this->secondBandColorStyle = $secondBandColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getSecondBandColorStyle()
    {
        return $this->secondBandColorStyle;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\BandingProperties::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_BandingProperties');
