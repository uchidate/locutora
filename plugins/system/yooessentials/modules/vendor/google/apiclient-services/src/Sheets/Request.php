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

class Request extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $addBandingType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddBandingRequest::class;
    protected $addBandingDataType = '';
    protected $addChartType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddChartRequest::class;
    protected $addChartDataType = '';
    protected $addConditionalFormatRuleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddConditionalFormatRuleRequest::class;
    protected $addConditionalFormatRuleDataType = '';
    protected $addDataSourceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddDataSourceRequest::class;
    protected $addDataSourceDataType = '';
    protected $addDimensionGroupType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddDimensionGroupRequest::class;
    protected $addDimensionGroupDataType = '';
    protected $addFilterViewType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddFilterViewRequest::class;
    protected $addFilterViewDataType = '';
    protected $addNamedRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddNamedRangeRequest::class;
    protected $addNamedRangeDataType = '';
    protected $addProtectedRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddProtectedRangeRequest::class;
    protected $addProtectedRangeDataType = '';
    protected $addSheetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddSheetRequest::class;
    protected $addSheetDataType = '';
    protected $addSlicerType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddSlicerRequest::class;
    protected $addSlicerDataType = '';
    protected $appendCellsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AppendCellsRequest::class;
    protected $appendCellsDataType = '';
    protected $appendDimensionType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AppendDimensionRequest::class;
    protected $appendDimensionDataType = '';
    protected $autoFillType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AutoFillRequest::class;
    protected $autoFillDataType = '';
    protected $autoResizeDimensionsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AutoResizeDimensionsRequest::class;
    protected $autoResizeDimensionsDataType = '';
    protected $clearBasicFilterType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ClearBasicFilterRequest::class;
    protected $clearBasicFilterDataType = '';
    protected $copyPasteType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CopyPasteRequest::class;
    protected $copyPasteDataType = '';
    protected $createDeveloperMetadataType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CreateDeveloperMetadataRequest::class;
    protected $createDeveloperMetadataDataType = '';
    protected $cutPasteType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CutPasteRequest::class;
    protected $cutPasteDataType = '';
    protected $deleteBandingType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteBandingRequest::class;
    protected $deleteBandingDataType = '';
    protected $deleteConditionalFormatRuleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteConditionalFormatRuleRequest::class;
    protected $deleteConditionalFormatRuleDataType = '';
    protected $deleteDataSourceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDataSourceRequest::class;
    protected $deleteDataSourceDataType = '';
    protected $deleteDeveloperMetadataType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDeveloperMetadataRequest::class;
    protected $deleteDeveloperMetadataDataType = '';
    protected $deleteDimensionType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDimensionRequest::class;
    protected $deleteDimensionDataType = '';
    protected $deleteDimensionGroupType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDimensionGroupRequest::class;
    protected $deleteDimensionGroupDataType = '';
    protected $deleteDuplicatesType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDuplicatesRequest::class;
    protected $deleteDuplicatesDataType = '';
    protected $deleteEmbeddedObjectType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteEmbeddedObjectRequest::class;
    protected $deleteEmbeddedObjectDataType = '';
    protected $deleteFilterViewType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteFilterViewRequest::class;
    protected $deleteFilterViewDataType = '';
    protected $deleteNamedRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteNamedRangeRequest::class;
    protected $deleteNamedRangeDataType = '';
    protected $deleteProtectedRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteProtectedRangeRequest::class;
    protected $deleteProtectedRangeDataType = '';
    protected $deleteRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteRangeRequest::class;
    protected $deleteRangeDataType = '';
    protected $deleteSheetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteSheetRequest::class;
    protected $deleteSheetDataType = '';
    protected $duplicateFilterViewType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DuplicateFilterViewRequest::class;
    protected $duplicateFilterViewDataType = '';
    protected $duplicateSheetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DuplicateSheetRequest::class;
    protected $duplicateSheetDataType = '';
    protected $findReplaceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\FindReplaceRequest::class;
    protected $findReplaceDataType = '';
    protected $insertDimensionType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\InsertDimensionRequest::class;
    protected $insertDimensionDataType = '';
    protected $insertRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\InsertRangeRequest::class;
    protected $insertRangeDataType = '';
    protected $mergeCellsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\MergeCellsRequest::class;
    protected $mergeCellsDataType = '';
    protected $moveDimensionType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\MoveDimensionRequest::class;
    protected $moveDimensionDataType = '';
    protected $pasteDataType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PasteDataRequest::class;
    protected $pasteDataDataType = '';
    protected $randomizeRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\RandomizeRangeRequest::class;
    protected $randomizeRangeDataType = '';
    protected $refreshDataSourceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\RefreshDataSourceRequest::class;
    protected $refreshDataSourceDataType = '';
    protected $repeatCellType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\RepeatCellRequest::class;
    protected $repeatCellDataType = '';
    protected $setBasicFilterType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SetBasicFilterRequest::class;
    protected $setBasicFilterDataType = '';
    protected $setDataValidationType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SetDataValidationRequest::class;
    protected $setDataValidationDataType = '';
    protected $sortRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SortRangeRequest::class;
    protected $sortRangeDataType = '';
    protected $textToColumnsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TextToColumnsRequest::class;
    protected $textToColumnsDataType = '';
    protected $trimWhitespaceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TrimWhitespaceRequest::class;
    protected $trimWhitespaceDataType = '';
    protected $unmergeCellsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UnmergeCellsRequest::class;
    protected $unmergeCellsDataType = '';
    protected $updateBandingType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateBandingRequest::class;
    protected $updateBandingDataType = '';
    protected $updateBordersType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateBordersRequest::class;
    protected $updateBordersDataType = '';
    protected $updateCellsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateCellsRequest::class;
    protected $updateCellsDataType = '';
    protected $updateChartSpecType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateChartSpecRequest::class;
    protected $updateChartSpecDataType = '';
    protected $updateConditionalFormatRuleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateConditionalFormatRuleRequest::class;
    protected $updateConditionalFormatRuleDataType = '';
    protected $updateDataSourceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDataSourceRequest::class;
    protected $updateDataSourceDataType = '';
    protected $updateDeveloperMetadataType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDeveloperMetadataRequest::class;
    protected $updateDeveloperMetadataDataType = '';
    protected $updateDimensionGroupType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDimensionGroupRequest::class;
    protected $updateDimensionGroupDataType = '';
    protected $updateDimensionPropertiesType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDimensionPropertiesRequest::class;
    protected $updateDimensionPropertiesDataType = '';
    protected $updateEmbeddedObjectBorderType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateEmbeddedObjectBorderRequest::class;
    protected $updateEmbeddedObjectBorderDataType = '';
    protected $updateEmbeddedObjectPositionType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateEmbeddedObjectPositionRequest::class;
    protected $updateEmbeddedObjectPositionDataType = '';
    protected $updateFilterViewType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateFilterViewRequest::class;
    protected $updateFilterViewDataType = '';
    protected $updateNamedRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateNamedRangeRequest::class;
    protected $updateNamedRangeDataType = '';
    protected $updateProtectedRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateProtectedRangeRequest::class;
    protected $updateProtectedRangeDataType = '';
    protected $updateSheetPropertiesType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateSheetPropertiesRequest::class;
    protected $updateSheetPropertiesDataType = '';
    protected $updateSlicerSpecType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateSlicerSpecRequest::class;
    protected $updateSlicerSpecDataType = '';
    protected $updateSpreadsheetPropertiesType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateSpreadsheetPropertiesRequest::class;
    protected $updateSpreadsheetPropertiesDataType = '';
    /**
     * @param AddBandingRequest
     */
    public function setAddBanding(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddBandingRequest $addBanding)
    {
        $this->addBanding = $addBanding;
    }
    /**
     * @return AddBandingRequest
     */
    public function getAddBanding()
    {
        return $this->addBanding;
    }
    /**
     * @param AddChartRequest
     */
    public function setAddChart(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddChartRequest $addChart)
    {
        $this->addChart = $addChart;
    }
    /**
     * @return AddChartRequest
     */
    public function getAddChart()
    {
        return $this->addChart;
    }
    /**
     * @param AddConditionalFormatRuleRequest
     */
    public function setAddConditionalFormatRule(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddConditionalFormatRuleRequest $addConditionalFormatRule)
    {
        $this->addConditionalFormatRule = $addConditionalFormatRule;
    }
    /**
     * @return AddConditionalFormatRuleRequest
     */
    public function getAddConditionalFormatRule()
    {
        return $this->addConditionalFormatRule;
    }
    /**
     * @param AddDataSourceRequest
     */
    public function setAddDataSource(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddDataSourceRequest $addDataSource)
    {
        $this->addDataSource = $addDataSource;
    }
    /**
     * @return AddDataSourceRequest
     */
    public function getAddDataSource()
    {
        return $this->addDataSource;
    }
    /**
     * @param AddDimensionGroupRequest
     */
    public function setAddDimensionGroup(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddDimensionGroupRequest $addDimensionGroup)
    {
        $this->addDimensionGroup = $addDimensionGroup;
    }
    /**
     * @return AddDimensionGroupRequest
     */
    public function getAddDimensionGroup()
    {
        return $this->addDimensionGroup;
    }
    /**
     * @param AddFilterViewRequest
     */
    public function setAddFilterView(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddFilterViewRequest $addFilterView)
    {
        $this->addFilterView = $addFilterView;
    }
    /**
     * @return AddFilterViewRequest
     */
    public function getAddFilterView()
    {
        return $this->addFilterView;
    }
    /**
     * @param AddNamedRangeRequest
     */
    public function setAddNamedRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddNamedRangeRequest $addNamedRange)
    {
        $this->addNamedRange = $addNamedRange;
    }
    /**
     * @return AddNamedRangeRequest
     */
    public function getAddNamedRange()
    {
        return $this->addNamedRange;
    }
    /**
     * @param AddProtectedRangeRequest
     */
    public function setAddProtectedRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddProtectedRangeRequest $addProtectedRange)
    {
        $this->addProtectedRange = $addProtectedRange;
    }
    /**
     * @return AddProtectedRangeRequest
     */
    public function getAddProtectedRange()
    {
        return $this->addProtectedRange;
    }
    /**
     * @param AddSheetRequest
     */
    public function setAddSheet(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddSheetRequest $addSheet)
    {
        $this->addSheet = $addSheet;
    }
    /**
     * @return AddSheetRequest
     */
    public function getAddSheet()
    {
        return $this->addSheet;
    }
    /**
     * @param AddSlicerRequest
     */
    public function setAddSlicer(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AddSlicerRequest $addSlicer)
    {
        $this->addSlicer = $addSlicer;
    }
    /**
     * @return AddSlicerRequest
     */
    public function getAddSlicer()
    {
        return $this->addSlicer;
    }
    /**
     * @param AppendCellsRequest
     */
    public function setAppendCells(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AppendCellsRequest $appendCells)
    {
        $this->appendCells = $appendCells;
    }
    /**
     * @return AppendCellsRequest
     */
    public function getAppendCells()
    {
        return $this->appendCells;
    }
    /**
     * @param AppendDimensionRequest
     */
    public function setAppendDimension(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AppendDimensionRequest $appendDimension)
    {
        $this->appendDimension = $appendDimension;
    }
    /**
     * @return AppendDimensionRequest
     */
    public function getAppendDimension()
    {
        return $this->appendDimension;
    }
    /**
     * @param AutoFillRequest
     */
    public function setAutoFill(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AutoFillRequest $autoFill)
    {
        $this->autoFill = $autoFill;
    }
    /**
     * @return AutoFillRequest
     */
    public function getAutoFill()
    {
        return $this->autoFill;
    }
    /**
     * @param AutoResizeDimensionsRequest
     */
    public function setAutoResizeDimensions(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AutoResizeDimensionsRequest $autoResizeDimensions)
    {
        $this->autoResizeDimensions = $autoResizeDimensions;
    }
    /**
     * @return AutoResizeDimensionsRequest
     */
    public function getAutoResizeDimensions()
    {
        return $this->autoResizeDimensions;
    }
    /**
     * @param ClearBasicFilterRequest
     */
    public function setClearBasicFilter(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ClearBasicFilterRequest $clearBasicFilter)
    {
        $this->clearBasicFilter = $clearBasicFilter;
    }
    /**
     * @return ClearBasicFilterRequest
     */
    public function getClearBasicFilter()
    {
        return $this->clearBasicFilter;
    }
    /**
     * @param CopyPasteRequest
     */
    public function setCopyPaste(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CopyPasteRequest $copyPaste)
    {
        $this->copyPaste = $copyPaste;
    }
    /**
     * @return CopyPasteRequest
     */
    public function getCopyPaste()
    {
        return $this->copyPaste;
    }
    /**
     * @param CreateDeveloperMetadataRequest
     */
    public function setCreateDeveloperMetadata(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CreateDeveloperMetadataRequest $createDeveloperMetadata)
    {
        $this->createDeveloperMetadata = $createDeveloperMetadata;
    }
    /**
     * @return CreateDeveloperMetadataRequest
     */
    public function getCreateDeveloperMetadata()
    {
        return $this->createDeveloperMetadata;
    }
    /**
     * @param CutPasteRequest
     */
    public function setCutPaste(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\CutPasteRequest $cutPaste)
    {
        $this->cutPaste = $cutPaste;
    }
    /**
     * @return CutPasteRequest
     */
    public function getCutPaste()
    {
        return $this->cutPaste;
    }
    /**
     * @param DeleteBandingRequest
     */
    public function setDeleteBanding(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteBandingRequest $deleteBanding)
    {
        $this->deleteBanding = $deleteBanding;
    }
    /**
     * @return DeleteBandingRequest
     */
    public function getDeleteBanding()
    {
        return $this->deleteBanding;
    }
    /**
     * @param DeleteConditionalFormatRuleRequest
     */
    public function setDeleteConditionalFormatRule(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteConditionalFormatRuleRequest $deleteConditionalFormatRule)
    {
        $this->deleteConditionalFormatRule = $deleteConditionalFormatRule;
    }
    /**
     * @return DeleteConditionalFormatRuleRequest
     */
    public function getDeleteConditionalFormatRule()
    {
        return $this->deleteConditionalFormatRule;
    }
    /**
     * @param DeleteDataSourceRequest
     */
    public function setDeleteDataSource(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDataSourceRequest $deleteDataSource)
    {
        $this->deleteDataSource = $deleteDataSource;
    }
    /**
     * @return DeleteDataSourceRequest
     */
    public function getDeleteDataSource()
    {
        return $this->deleteDataSource;
    }
    /**
     * @param DeleteDeveloperMetadataRequest
     */
    public function setDeleteDeveloperMetadata(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDeveloperMetadataRequest $deleteDeveloperMetadata)
    {
        $this->deleteDeveloperMetadata = $deleteDeveloperMetadata;
    }
    /**
     * @return DeleteDeveloperMetadataRequest
     */
    public function getDeleteDeveloperMetadata()
    {
        return $this->deleteDeveloperMetadata;
    }
    /**
     * @param DeleteDimensionRequest
     */
    public function setDeleteDimension(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDimensionRequest $deleteDimension)
    {
        $this->deleteDimension = $deleteDimension;
    }
    /**
     * @return DeleteDimensionRequest
     */
    public function getDeleteDimension()
    {
        return $this->deleteDimension;
    }
    /**
     * @param DeleteDimensionGroupRequest
     */
    public function setDeleteDimensionGroup(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDimensionGroupRequest $deleteDimensionGroup)
    {
        $this->deleteDimensionGroup = $deleteDimensionGroup;
    }
    /**
     * @return DeleteDimensionGroupRequest
     */
    public function getDeleteDimensionGroup()
    {
        return $this->deleteDimensionGroup;
    }
    /**
     * @param DeleteDuplicatesRequest
     */
    public function setDeleteDuplicates(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDuplicatesRequest $deleteDuplicates)
    {
        $this->deleteDuplicates = $deleteDuplicates;
    }
    /**
     * @return DeleteDuplicatesRequest
     */
    public function getDeleteDuplicates()
    {
        return $this->deleteDuplicates;
    }
    /**
     * @param DeleteEmbeddedObjectRequest
     */
    public function setDeleteEmbeddedObject(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteEmbeddedObjectRequest $deleteEmbeddedObject)
    {
        $this->deleteEmbeddedObject = $deleteEmbeddedObject;
    }
    /**
     * @return DeleteEmbeddedObjectRequest
     */
    public function getDeleteEmbeddedObject()
    {
        return $this->deleteEmbeddedObject;
    }
    /**
     * @param DeleteFilterViewRequest
     */
    public function setDeleteFilterView(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteFilterViewRequest $deleteFilterView)
    {
        $this->deleteFilterView = $deleteFilterView;
    }
    /**
     * @return DeleteFilterViewRequest
     */
    public function getDeleteFilterView()
    {
        return $this->deleteFilterView;
    }
    /**
     * @param DeleteNamedRangeRequest
     */
    public function setDeleteNamedRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteNamedRangeRequest $deleteNamedRange)
    {
        $this->deleteNamedRange = $deleteNamedRange;
    }
    /**
     * @return DeleteNamedRangeRequest
     */
    public function getDeleteNamedRange()
    {
        return $this->deleteNamedRange;
    }
    /**
     * @param DeleteProtectedRangeRequest
     */
    public function setDeleteProtectedRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteProtectedRangeRequest $deleteProtectedRange)
    {
        $this->deleteProtectedRange = $deleteProtectedRange;
    }
    /**
     * @return DeleteProtectedRangeRequest
     */
    public function getDeleteProtectedRange()
    {
        return $this->deleteProtectedRange;
    }
    /**
     * @param DeleteRangeRequest
     */
    public function setDeleteRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteRangeRequest $deleteRange)
    {
        $this->deleteRange = $deleteRange;
    }
    /**
     * @return DeleteRangeRequest
     */
    public function getDeleteRange()
    {
        return $this->deleteRange;
    }
    /**
     * @param DeleteSheetRequest
     */
    public function setDeleteSheet(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteSheetRequest $deleteSheet)
    {
        $this->deleteSheet = $deleteSheet;
    }
    /**
     * @return DeleteSheetRequest
     */
    public function getDeleteSheet()
    {
        return $this->deleteSheet;
    }
    /**
     * @param DuplicateFilterViewRequest
     */
    public function setDuplicateFilterView(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DuplicateFilterViewRequest $duplicateFilterView)
    {
        $this->duplicateFilterView = $duplicateFilterView;
    }
    /**
     * @return DuplicateFilterViewRequest
     */
    public function getDuplicateFilterView()
    {
        return $this->duplicateFilterView;
    }
    /**
     * @param DuplicateSheetRequest
     */
    public function setDuplicateSheet(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DuplicateSheetRequest $duplicateSheet)
    {
        $this->duplicateSheet = $duplicateSheet;
    }
    /**
     * @return DuplicateSheetRequest
     */
    public function getDuplicateSheet()
    {
        return $this->duplicateSheet;
    }
    /**
     * @param FindReplaceRequest
     */
    public function setFindReplace(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\FindReplaceRequest $findReplace)
    {
        $this->findReplace = $findReplace;
    }
    /**
     * @return FindReplaceRequest
     */
    public function getFindReplace()
    {
        return $this->findReplace;
    }
    /**
     * @param InsertDimensionRequest
     */
    public function setInsertDimension(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\InsertDimensionRequest $insertDimension)
    {
        $this->insertDimension = $insertDimension;
    }
    /**
     * @return InsertDimensionRequest
     */
    public function getInsertDimension()
    {
        return $this->insertDimension;
    }
    /**
     * @param InsertRangeRequest
     */
    public function setInsertRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\InsertRangeRequest $insertRange)
    {
        $this->insertRange = $insertRange;
    }
    /**
     * @return InsertRangeRequest
     */
    public function getInsertRange()
    {
        return $this->insertRange;
    }
    /**
     * @param MergeCellsRequest
     */
    public function setMergeCells(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\MergeCellsRequest $mergeCells)
    {
        $this->mergeCells = $mergeCells;
    }
    /**
     * @return MergeCellsRequest
     */
    public function getMergeCells()
    {
        return $this->mergeCells;
    }
    /**
     * @param MoveDimensionRequest
     */
    public function setMoveDimension(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\MoveDimensionRequest $moveDimension)
    {
        $this->moveDimension = $moveDimension;
    }
    /**
     * @return MoveDimensionRequest
     */
    public function getMoveDimension()
    {
        return $this->moveDimension;
    }
    /**
     * @param PasteDataRequest
     */
    public function setPasteData(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PasteDataRequest $pasteData)
    {
        $this->pasteData = $pasteData;
    }
    /**
     * @return PasteDataRequest
     */
    public function getPasteData()
    {
        return $this->pasteData;
    }
    /**
     * @param RandomizeRangeRequest
     */
    public function setRandomizeRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\RandomizeRangeRequest $randomizeRange)
    {
        $this->randomizeRange = $randomizeRange;
    }
    /**
     * @return RandomizeRangeRequest
     */
    public function getRandomizeRange()
    {
        return $this->randomizeRange;
    }
    /**
     * @param RefreshDataSourceRequest
     */
    public function setRefreshDataSource(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\RefreshDataSourceRequest $refreshDataSource)
    {
        $this->refreshDataSource = $refreshDataSource;
    }
    /**
     * @return RefreshDataSourceRequest
     */
    public function getRefreshDataSource()
    {
        return $this->refreshDataSource;
    }
    /**
     * @param RepeatCellRequest
     */
    public function setRepeatCell(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\RepeatCellRequest $repeatCell)
    {
        $this->repeatCell = $repeatCell;
    }
    /**
     * @return RepeatCellRequest
     */
    public function getRepeatCell()
    {
        return $this->repeatCell;
    }
    /**
     * @param SetBasicFilterRequest
     */
    public function setSetBasicFilter(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SetBasicFilterRequest $setBasicFilter)
    {
        $this->setBasicFilter = $setBasicFilter;
    }
    /**
     * @return SetBasicFilterRequest
     */
    public function getSetBasicFilter()
    {
        return $this->setBasicFilter;
    }
    /**
     * @param SetDataValidationRequest
     */
    public function setSetDataValidation(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SetDataValidationRequest $setDataValidation)
    {
        $this->setDataValidation = $setDataValidation;
    }
    /**
     * @return SetDataValidationRequest
     */
    public function getSetDataValidation()
    {
        return $this->setDataValidation;
    }
    /**
     * @param SortRangeRequest
     */
    public function setSortRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SortRangeRequest $sortRange)
    {
        $this->sortRange = $sortRange;
    }
    /**
     * @return SortRangeRequest
     */
    public function getSortRange()
    {
        return $this->sortRange;
    }
    /**
     * @param TextToColumnsRequest
     */
    public function setTextToColumns(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TextToColumnsRequest $textToColumns)
    {
        $this->textToColumns = $textToColumns;
    }
    /**
     * @return TextToColumnsRequest
     */
    public function getTextToColumns()
    {
        return $this->textToColumns;
    }
    /**
     * @param TrimWhitespaceRequest
     */
    public function setTrimWhitespace(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TrimWhitespaceRequest $trimWhitespace)
    {
        $this->trimWhitespace = $trimWhitespace;
    }
    /**
     * @return TrimWhitespaceRequest
     */
    public function getTrimWhitespace()
    {
        return $this->trimWhitespace;
    }
    /**
     * @param UnmergeCellsRequest
     */
    public function setUnmergeCells(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UnmergeCellsRequest $unmergeCells)
    {
        $this->unmergeCells = $unmergeCells;
    }
    /**
     * @return UnmergeCellsRequest
     */
    public function getUnmergeCells()
    {
        return $this->unmergeCells;
    }
    /**
     * @param UpdateBandingRequest
     */
    public function setUpdateBanding(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateBandingRequest $updateBanding)
    {
        $this->updateBanding = $updateBanding;
    }
    /**
     * @return UpdateBandingRequest
     */
    public function getUpdateBanding()
    {
        return $this->updateBanding;
    }
    /**
     * @param UpdateBordersRequest
     */
    public function setUpdateBorders(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateBordersRequest $updateBorders)
    {
        $this->updateBorders = $updateBorders;
    }
    /**
     * @return UpdateBordersRequest
     */
    public function getUpdateBorders()
    {
        return $this->updateBorders;
    }
    /**
     * @param UpdateCellsRequest
     */
    public function setUpdateCells(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateCellsRequest $updateCells)
    {
        $this->updateCells = $updateCells;
    }
    /**
     * @return UpdateCellsRequest
     */
    public function getUpdateCells()
    {
        return $this->updateCells;
    }
    /**
     * @param UpdateChartSpecRequest
     */
    public function setUpdateChartSpec(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateChartSpecRequest $updateChartSpec)
    {
        $this->updateChartSpec = $updateChartSpec;
    }
    /**
     * @return UpdateChartSpecRequest
     */
    public function getUpdateChartSpec()
    {
        return $this->updateChartSpec;
    }
    /**
     * @param UpdateConditionalFormatRuleRequest
     */
    public function setUpdateConditionalFormatRule(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateConditionalFormatRuleRequest $updateConditionalFormatRule)
    {
        $this->updateConditionalFormatRule = $updateConditionalFormatRule;
    }
    /**
     * @return UpdateConditionalFormatRuleRequest
     */
    public function getUpdateConditionalFormatRule()
    {
        return $this->updateConditionalFormatRule;
    }
    /**
     * @param UpdateDataSourceRequest
     */
    public function setUpdateDataSource(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDataSourceRequest $updateDataSource)
    {
        $this->updateDataSource = $updateDataSource;
    }
    /**
     * @return UpdateDataSourceRequest
     */
    public function getUpdateDataSource()
    {
        return $this->updateDataSource;
    }
    /**
     * @param UpdateDeveloperMetadataRequest
     */
    public function setUpdateDeveloperMetadata(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDeveloperMetadataRequest $updateDeveloperMetadata)
    {
        $this->updateDeveloperMetadata = $updateDeveloperMetadata;
    }
    /**
     * @return UpdateDeveloperMetadataRequest
     */
    public function getUpdateDeveloperMetadata()
    {
        return $this->updateDeveloperMetadata;
    }
    /**
     * @param UpdateDimensionGroupRequest
     */
    public function setUpdateDimensionGroup(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDimensionGroupRequest $updateDimensionGroup)
    {
        $this->updateDimensionGroup = $updateDimensionGroup;
    }
    /**
     * @return UpdateDimensionGroupRequest
     */
    public function getUpdateDimensionGroup()
    {
        return $this->updateDimensionGroup;
    }
    /**
     * @param UpdateDimensionPropertiesRequest
     */
    public function setUpdateDimensionProperties(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDimensionPropertiesRequest $updateDimensionProperties)
    {
        $this->updateDimensionProperties = $updateDimensionProperties;
    }
    /**
     * @return UpdateDimensionPropertiesRequest
     */
    public function getUpdateDimensionProperties()
    {
        return $this->updateDimensionProperties;
    }
    /**
     * @param UpdateEmbeddedObjectBorderRequest
     */
    public function setUpdateEmbeddedObjectBorder(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateEmbeddedObjectBorderRequest $updateEmbeddedObjectBorder)
    {
        $this->updateEmbeddedObjectBorder = $updateEmbeddedObjectBorder;
    }
    /**
     * @return UpdateEmbeddedObjectBorderRequest
     */
    public function getUpdateEmbeddedObjectBorder()
    {
        return $this->updateEmbeddedObjectBorder;
    }
    /**
     * @param UpdateEmbeddedObjectPositionRequest
     */
    public function setUpdateEmbeddedObjectPosition(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateEmbeddedObjectPositionRequest $updateEmbeddedObjectPosition)
    {
        $this->updateEmbeddedObjectPosition = $updateEmbeddedObjectPosition;
    }
    /**
     * @return UpdateEmbeddedObjectPositionRequest
     */
    public function getUpdateEmbeddedObjectPosition()
    {
        return $this->updateEmbeddedObjectPosition;
    }
    /**
     * @param UpdateFilterViewRequest
     */
    public function setUpdateFilterView(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateFilterViewRequest $updateFilterView)
    {
        $this->updateFilterView = $updateFilterView;
    }
    /**
     * @return UpdateFilterViewRequest
     */
    public function getUpdateFilterView()
    {
        return $this->updateFilterView;
    }
    /**
     * @param UpdateNamedRangeRequest
     */
    public function setUpdateNamedRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateNamedRangeRequest $updateNamedRange)
    {
        $this->updateNamedRange = $updateNamedRange;
    }
    /**
     * @return UpdateNamedRangeRequest
     */
    public function getUpdateNamedRange()
    {
        return $this->updateNamedRange;
    }
    /**
     * @param UpdateProtectedRangeRequest
     */
    public function setUpdateProtectedRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateProtectedRangeRequest $updateProtectedRange)
    {
        $this->updateProtectedRange = $updateProtectedRange;
    }
    /**
     * @return UpdateProtectedRangeRequest
     */
    public function getUpdateProtectedRange()
    {
        return $this->updateProtectedRange;
    }
    /**
     * @param UpdateSheetPropertiesRequest
     */
    public function setUpdateSheetProperties(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateSheetPropertiesRequest $updateSheetProperties)
    {
        $this->updateSheetProperties = $updateSheetProperties;
    }
    /**
     * @return UpdateSheetPropertiesRequest
     */
    public function getUpdateSheetProperties()
    {
        return $this->updateSheetProperties;
    }
    /**
     * @param UpdateSlicerSpecRequest
     */
    public function setUpdateSlicerSpec(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateSlicerSpecRequest $updateSlicerSpec)
    {
        $this->updateSlicerSpec = $updateSlicerSpec;
    }
    /**
     * @return UpdateSlicerSpecRequest
     */
    public function getUpdateSlicerSpec()
    {
        return $this->updateSlicerSpec;
    }
    /**
     * @param UpdateSpreadsheetPropertiesRequest
     */
    public function setUpdateSpreadsheetProperties(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateSpreadsheetPropertiesRequest $updateSpreadsheetProperties)
    {
        $this->updateSpreadsheetProperties = $updateSpreadsheetProperties;
    }
    /**
     * @return UpdateSpreadsheetPropertiesRequest
     */
    public function getUpdateSpreadsheetProperties()
    {
        return $this->updateSpreadsheetProperties;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Request::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_Request');
