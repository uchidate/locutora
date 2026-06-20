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

class CellData extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'textFormatRuns';
    protected $dataSourceFormulaType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceFormula::class;
    protected $dataSourceFormulaDataType = '';
    protected $dataSourceTableType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceTable::class;
    protected $dataSourceTableDataType = '';
    protected $dataValidationType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataValidationRule::class;
    protected $dataValidationDataType = '';
    protected $effectiveFormatType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CellFormat::class;
    protected $effectiveFormatDataType = '';
    protected $effectiveValueType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ExtendedValue::class;
    protected $effectiveValueDataType = '';
    /**
     * @var string
     */
    public $formattedValue;
    /**
     * @var string
     */
    public $hyperlink;
    /**
     * @var string
     */
    public $note;
    protected $pivotTableType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotTable::class;
    protected $pivotTableDataType = '';
    protected $textFormatRunsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TextFormatRun::class;
    protected $textFormatRunsDataType = 'array';
    protected $userEnteredFormatType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CellFormat::class;
    protected $userEnteredFormatDataType = '';
    protected $userEnteredValueType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ExtendedValue::class;
    protected $userEnteredValueDataType = '';
    /**
     * @param DataSourceFormula
     */
    public function setDataSourceFormula(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceFormula $dataSourceFormula)
    {
        $this->dataSourceFormula = $dataSourceFormula;
    }
    /**
     * @return DataSourceFormula
     */
    public function getDataSourceFormula()
    {
        return $this->dataSourceFormula;
    }
    /**
     * @param DataSourceTable
     */
    public function setDataSourceTable(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceTable $dataSourceTable)
    {
        $this->dataSourceTable = $dataSourceTable;
    }
    /**
     * @return DataSourceTable
     */
    public function getDataSourceTable()
    {
        return $this->dataSourceTable;
    }
    /**
     * @param DataValidationRule
     */
    public function setDataValidation(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataValidationRule $dataValidation)
    {
        $this->dataValidation = $dataValidation;
    }
    /**
     * @return DataValidationRule
     */
    public function getDataValidation()
    {
        return $this->dataValidation;
    }
    /**
     * @param CellFormat
     */
    public function setEffectiveFormat(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CellFormat $effectiveFormat)
    {
        $this->effectiveFormat = $effectiveFormat;
    }
    /**
     * @return CellFormat
     */
    public function getEffectiveFormat()
    {
        return $this->effectiveFormat;
    }
    /**
     * @param ExtendedValue
     */
    public function setEffectiveValue(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ExtendedValue $effectiveValue)
    {
        $this->effectiveValue = $effectiveValue;
    }
    /**
     * @return ExtendedValue
     */
    public function getEffectiveValue()
    {
        return $this->effectiveValue;
    }
    /**
     * @param string
     */
    public function setFormattedValue($formattedValue)
    {
        $this->formattedValue = $formattedValue;
    }
    /**
     * @return string
     */
    public function getFormattedValue()
    {
        return $this->formattedValue;
    }
    /**
     * @param string
     */
    public function setHyperlink($hyperlink)
    {
        $this->hyperlink = $hyperlink;
    }
    /**
     * @return string
     */
    public function getHyperlink()
    {
        return $this->hyperlink;
    }
    /**
     * @param string
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }
    /**
     * @param PivotTable
     */
    public function setPivotTable(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotTable $pivotTable)
    {
        $this->pivotTable = $pivotTable;
    }
    /**
     * @return PivotTable
     */
    public function getPivotTable()
    {
        return $this->pivotTable;
    }
    /**
     * @param TextFormatRun[]
     */
    public function setTextFormatRuns($textFormatRuns)
    {
        $this->textFormatRuns = $textFormatRuns;
    }
    /**
     * @return TextFormatRun[]
     */
    public function getTextFormatRuns()
    {
        return $this->textFormatRuns;
    }
    /**
     * @param CellFormat
     */
    public function setUserEnteredFormat(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CellFormat $userEnteredFormat)
    {
        $this->userEnteredFormat = $userEnteredFormat;
    }
    /**
     * @return CellFormat
     */
    public function getUserEnteredFormat()
    {
        return $this->userEnteredFormat;
    }
    /**
     * @param ExtendedValue
     */
    public function setUserEnteredValue(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ExtendedValue $userEnteredValue)
    {
        $this->userEnteredValue = $userEnteredValue;
    }
    /**
     * @return ExtendedValue
     */
    public function getUserEnteredValue()
    {
        return $this->userEnteredValue;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CellData::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_CellData');
