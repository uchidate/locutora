<?php
class ReportPrintPage extends ReportPage
{

	public $pageWidth = PDF_PAGE_WIDTH;
	public $pageHeight = PDF_PAGE_HEIGHT;
	public $pdfWidth = PDF_PAGE_WIDTH;
	public $splitByRecords = 0;
	
	/**
	 *	PDF rendering mode. 
	 *  empty - regular page display
	 * 	"build" - build page and return PDF
	 * 	"prepare" - build page and return HTML for browser post-processing
	 *	"convert" - convert post-processed HTML to PDF
	 */
	public $pdfContent = "";
	
	public $format = "";
	
	/**
	 *
	 */
	public $pdfFitToPage = 1;
	
	/**
	 *
	 */
	public $landscape = 0;
	
	
	function ReportPrintPage(&$params) 
	{
		parent::ReportPage($params);
		
		$this->crossTable = $this->pSet->isCrossTabReport() ? 1 : 0;
		$this->jsSettings['tableSettings'][ $this->tName ]['reportType'] = $this->crossTable;
		
		if (isRTL())
			$this->jsSettings['tableSettings'][ $this->tName ]['isRTL'] = true;
		
		$this->jsSettings['tableSettings'][ $this->tName ]['reportPrintPartitionType'] = $this->pSet->getReportPrintPartitionType();
		$this->jsSettings['tableSettings'][ $this->tName ]['reportPrintGroupsPerPage'] = $this->pSet->getReportPrintGroupsPerPage();		
		$this->jsSettings['tableSettings'][ $this->tName ]['reportPrintLayout'] = $this->pSet->getReportPrintLayout();
		$this->jsSettings['tableSettings'][ $this->tName ]['lowGroup'] = $this->pSet->getLowGroup();

		$this->jsSettings['tableSettings'][ $this->tName ]['printerPagePDF'] = $this->pSet->isPrinterPagePDF();			

		$this->jsSettings['tableSettings'][$this->tName]['printerPageOrientation'] = $this->pSet->getPrinterPageOrientation();
		$this->jsSettings['tableSettings'][$this->tName]['printerPageScale'] = $this->pSet->getPrinterPageScale();
		$this->jsSettings['tableSettings'][$this->tName]['isPrinterPageFitToPage'] = $this->pSet->isPrinterPageFitToPage();
		$this->jsSettings['tableSettings'][$this->tName]['printerSplitRecords'] = $this->pSet->getPrinterSplitRecords();
		$this->jsSettings['tableSettings'][$this->tName]['printerPDFSplitRecords'] = $this->pSet->getPrinterPDFSplitRecords();

	}
	
	/**
	 * @param String format
	 * @param Boolean exportPDF
	 */
	public function assignPDFFormatSettings( $format, $exportPDF )
	{
		if( $exportPDF )
			$this->jsSettings['tableSettings'][ $this->tName ]['exportPdf'] = 1;
		
		if( $format != "pdf" )
			return;
			
		$this->landscape = $this->pSet->isLandscapePrinterPagePDFOrientation();
		$this->pdfFitToPage = $this->crossTable ? 1 : $this->pSet->isPrinterPagePDFFitToPage();
		
		$this->pageWidth = PDF_PAGE_WIDTH;
		$this->pageHeight = PDF_PAGE_HEIGHT;
		
		if( !$this->pdfFitToPage )
		{
			$PrinterPagePDFScale = $this->pSet->getPrinterPagePDFScale();
			$this->pageWidth = $this->pageWidth * 100 / $PrinterPagePDFScale;
			$this->pageHeight = $this->pageHeight * 100 / $PrinterPagePDFScale;
		}

		$this->jsSettings['tableSettings'][ $this->tName ]['pdfPrinterPageOrientation'] = $this->pSet->isLandscapePrinterPagePDFOrientation();
		$this->jsSettings['tableSettings'][ $this->tName ]['printerPageOrientation'] = $this->landscape;
		$this->jsSettings['tableSettings'][ $this->tName ]['createPdf'] = 1;
		$this->jsSettings['tableSettings'][ $this->tName ]['pdfFitToPage'] = $this->pdfFitToPage;
		
		if( $this->landscape )
		{
			$temp = $this->pageWidth;
			$this->pageWidth = $this->pageHeight;
			$this->pageHeight = $temp;
		}
		
		$this->jsSettings['tableSettings'][ $this->tName ]['pageWidth'] = $this->pageWidth;
		$this->jsSettings['tableSettings'][ $this->tName ]['pageHeight'] = $this->pageHeight;		
	}
	
	/**
	 * @return Array
	 */
	public function getExtraReportParams()
	{
		$extraParams = parent::getExtraReportParams();
		if( !$this->crossTable )
			$extraParams['mode'] = MODE_PRINT;
		
		return $extraParams;	
	}

	/**
	 * A stub
	 */
	protected function getnoRecOnFirstPageWhereCondition()
	{	
		return "";
	}

	/**
	 * Assign values obtained from crossTable object to
	 * the basic cross table xt variables
	 * @param  CrossTableReport crosstableObj
	 * @param  Boolean showSummary
	 */
	protected function crossTableCommonAssign( $crosstableObj, $showSummary )
	{	
		$this->xt->assign("report_cross_header", $crosstableObj->getPrintCrossHeader());
	
		$arr_res = $crosstableObj->getValuesControl();
		if( $arr_res[0] )
			$this->xt->assign("totals", $crosstableObj->getTotalsName( $crosstableObj->getCurrentGroupFunction() ));
		
		$grid_row["data"] = $crosstableObj->getCrossTableData();
		
		if( count($grid_row["data"]) > 0 )
		{
			$this->xt->assign("grid_row", $grid_row);
			$this->xt->assignbyref("group_header", $crosstableObj->getCrossTableHeader());
			$this->xt->assignbyref("col_summary", $crosstableObj->getCrossTableSummary());	
			$this->xt->assignbyref("total_summary", $crosstableObj->getTotalSummary());
			$this->xt->assign("cross_totals", $showSummary);
		}
		
		$pages = array();
		$pages[0]['grid_row'] = $grid_row;
		$pages[0]['begin'] = "<div name=page class=printpage>";
		$pages[0]['end'] = "</div>";
		
		$this->xt->assign("pageno", 1);
		$this->xt->assign("maxpages", 1);	
		$this->xt->assign_loopsection("pages", $pages);
	}
	
	/**
	 * Get data for standart report and assign with xt
	 * @param &Array _options
	 */
	public function setStandartData(&$_options)
	{			
		include_once(getabspath('classes/reportlib.php'));
		
		if( !$_SESSION[ $this->sessionPrefix."_pagesize" ] )
			$_SESSION[ $this->sessionPrefix."_pagesize" ] = -1; // a temporary fix

		if( !$_SESSION[ $this->sessionPrefix."_pagenumber" ] )
			$_SESSION[ $this->sessionPrefix."_pagenumber" ] = 1;			

		
		if( isset($_REQUEST["all"]) && $_REQUEST["all"] )
		{
			$PageSize = -1;
			$pagestart = 0;
			$this->jsSettings['tableSettings'][$this->tName]['reportPrintMode'] = 1;
		}
		else
		{
			$PageSize = $_SESSION[ $this->sessionPrefix."_pagesize" ];
			$pagestart = ($_SESSION[ $this->sessionPrefix."_pagenumber" ] - 1) * $PageSize;			
		}

		
		$whereComponents = $this->getWhereComponents();	
		$sqlArray = $this->getReportSQLData();
		
		$rb = new Report($sqlArray, $this->pSet->GetTableData(".orderindexes"), $this->connection
			, $PageSize, $_options, $whereComponents["searchWhere"], $whereComponents["searchHaving"], $this);
		
		$this->arrReport = $rb->getReport( $pagestart );

		$this->standardReportCommonAssign();		
	}
	
	/**
	 * Assign the basic cross table xt variables
	 */
	protected function standardReportCommonAssign()
	{		
		foreach($this->arrReport['page'] as $key => $value)
		{
			$this->xt->assign($key, $value);
		}

		$pages = array();
		$pages[0]['grid_row'] = array("data" => $this->arrReport['list']);
		$pages[0]['begin'] = "<div name=page>";
		$pages[0]['end'] = "</div>";
		
		if( $params["repGlobalSummary"] )
		{
			foreach($this->arrReport['global'] as $key => $value)
			{
				$this->xt->assign($key, $value);
			}
				
			$pages[0]['global_summary'] = true;
		}	
		
		$this->xt->assign("pageno", 1);
		$this->xt->assign("maxpages", 1);		
		$this->xt->assign_loopsection("pages", $pages);	
		$this->xt->assign("printbuttons", true);
	}
	
	/**
	 *
	 */
	public function prepareWordOrExcelTemplate($contents)
	{
		$pos1 = 0;
		while($pos1 !== false)
		{
			$pos1 = stripos($contents, "<link ", $pos1);
			if($pos1 !== false)
			{
				$pos2 = strpos($contents, ">", $pos1);
				if(!$pos2 == false)
					$contents = substr($contents, 0, $pos1).substr($contents, $pos2 + 1);
			}
		}
		
		$contents = str_ireplace("<img src=\"/".GetRootPathForResources("images/spacer.gif")."\">", "", $contents);
		$contents = str_ireplace("<img src=\"/".GetRootPathForResources("images/spacer.gif")."\"/>", "", $contents);
		$contents = str_ireplace("<img src=\"@webRootPath/images/spacer.gif\" />", "", $contents); // .net template compatibility
		
		return $contents;
	}
}
?>