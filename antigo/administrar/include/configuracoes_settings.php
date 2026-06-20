<?php
require_once(getabspath("classes/cipherer.php"));




$tdataconfiguracoes = array();	
	$tdataconfiguracoes[".truncateText"] = true;
	$tdataconfiguracoes[".NumberOfChars"] = 80; 
	$tdataconfiguracoes[".ShortName"] = "configuracoes";
	$tdataconfiguracoes[".OwnerID"] = "";
	$tdataconfiguracoes[".OriginalTable"] = "configuracoes";

//	field labels
$fieldLabelsconfiguracoes = array();
$fieldToolTipsconfiguracoes = array();
$pageTitlesconfiguracoes = array();

if(mlang_getcurrentlang()=="Portuguese(Brazil)")
{
	$fieldLabelsconfiguracoes["Portuguese(Brazil)"] = array();
	$fieldToolTipsconfiguracoes["Portuguese(Brazil)"] = array();
	$pageTitlesconfiguracoes["Portuguese(Brazil)"] = array();
	$fieldLabelsconfiguracoes["Portuguese(Brazil)"]["idconf"] = "Idconf";
	$fieldToolTipsconfiguracoes["Portuguese(Brazil)"]["idconf"] = "";
	$fieldLabelsconfiguracoes["Portuguese(Brazil)"]["titulosite"] = "Titulosite";
	$fieldToolTipsconfiguracoes["Portuguese(Brazil)"]["titulosite"] = "";
	$fieldLabelsconfiguracoes["Portuguese(Brazil)"]["descricaosite"] = "Descricaosite";
	$fieldToolTipsconfiguracoes["Portuguese(Brazil)"]["descricaosite"] = "";
	$fieldLabelsconfiguracoes["Portuguese(Brazil)"]["rodapesite"] = "Rodape do site";
	$fieldToolTipsconfiguracoes["Portuguese(Brazil)"]["rodapesite"] = "";
	$fieldLabelsconfiguracoes["Portuguese(Brazil)"]["emailcontato"] = "Email de contato";
	$fieldToolTipsconfiguracoes["Portuguese(Brazil)"]["emailcontato"] = "";
	if (count($fieldToolTipsconfiguracoes["Portuguese(Brazil)"]))
		$tdataconfiguracoes[".isUseToolTips"] = true;
}
if(mlang_getcurrentlang()=="")
{
	$fieldLabelsconfiguracoes[""] = array();
	$fieldToolTipsconfiguracoes[""] = array();
	$pageTitlesconfiguracoes[""] = array();
	if (count($fieldToolTipsconfiguracoes[""]))
		$tdataconfiguracoes[".isUseToolTips"] = true;
}
	
	
	$tdataconfiguracoes[".NCSearch"] = true;



$tdataconfiguracoes[".shortTableName"] = "configuracoes";
$tdataconfiguracoes[".nSecOptions"] = 0;
$tdataconfiguracoes[".recsPerRowList"] = 1;
$tdataconfiguracoes[".mainTableOwnerID"] = "";
$tdataconfiguracoes[".moveNext"] = 1;
$tdataconfiguracoes[".nType"] = 0;

$tdataconfiguracoes[".strOriginalTableName"] = "configuracoes";




$tdataconfiguracoes[".showAddInPopup"] = false;

$tdataconfiguracoes[".showEditInPopup"] = false;

$tdataconfiguracoes[".showViewInPopup"] = false;

//page's base css files names
$popupPagesLayoutNames = array();
$tdataconfiguracoes[".popupPagesLayoutNames"] = $popupPagesLayoutNames;


$tdataconfiguracoes[".fieldsForRegister"] = array();

$tdataconfiguracoes[".listAjax"] = false;

	$tdataconfiguracoes[".audit"] = false;

	$tdataconfiguracoes[".locking"] = false;

$tdataconfiguracoes[".edit"] = true;

$tdataconfiguracoes[".list"] = true;

$tdataconfiguracoes[".view"] = true;

$tdataconfiguracoes[".import"] = true;

$tdataconfiguracoes[".exportTo"] = true;

$tdataconfiguracoes[".printFriendly"] = true;

$tdataconfiguracoes[".delete"] = true;

$tdataconfiguracoes[".showSimpleSearchOptions"] = false;

// search Saving settings
$tdataconfiguracoes[".searchSaving"] = false;
//

$tdataconfiguracoes[".showSearchPanel"] = true;
		$tdataconfiguracoes[".flexibleSearch"] = true;		

if (isMobile())
	$tdataconfiguracoes[".isUseAjaxSuggest"] = false;
else 
	$tdataconfiguracoes[".isUseAjaxSuggest"] = true;

$tdataconfiguracoes[".rowHighlite"] = true;



$tdataconfiguracoes[".addPageEvents"] = false;

// use timepicker for search panel
$tdataconfiguracoes[".isUseTimeForSearch"] = false;





$tdataconfiguracoes[".allSearchFields"] = array();
$tdataconfiguracoes[".filterFields"] = array();
$tdataconfiguracoes[".requiredSearchFields"] = array();

$tdataconfiguracoes[".allSearchFields"][] = "idconf";
	$tdataconfiguracoes[".allSearchFields"][] = "titulosite";
	$tdataconfiguracoes[".allSearchFields"][] = "descricaosite";
	$tdataconfiguracoes[".allSearchFields"][] = "rodapesite";
	$tdataconfiguracoes[".allSearchFields"][] = "emailcontato";
	

$tdataconfiguracoes[".googleLikeFields"] = array();
$tdataconfiguracoes[".googleLikeFields"][] = "idconf";
$tdataconfiguracoes[".googleLikeFields"][] = "titulosite";
$tdataconfiguracoes[".googleLikeFields"][] = "descricaosite";
$tdataconfiguracoes[".googleLikeFields"][] = "rodapesite";
$tdataconfiguracoes[".googleLikeFields"][] = "emailcontato";


$tdataconfiguracoes[".advSearchFields"] = array();
$tdataconfiguracoes[".advSearchFields"][] = "idconf";
$tdataconfiguracoes[".advSearchFields"][] = "titulosite";
$tdataconfiguracoes[".advSearchFields"][] = "descricaosite";
$tdataconfiguracoes[".advSearchFields"][] = "rodapesite";
$tdataconfiguracoes[".advSearchFields"][] = "emailcontato";

$tdataconfiguracoes[".tableType"] = "list";

$tdataconfiguracoes[".printerPageOrientation"] = 0;
$tdataconfiguracoes[".nPrinterPageScale"] = 100;

$tdataconfiguracoes[".nPrinterSplitRecords"] = 40;

$tdataconfiguracoes[".nPrinterPDFSplitRecords"] = 40;





	





// view page pdf

// print page pdf


$tdataconfiguracoes[".pageSize"] = 20;

$tdataconfiguracoes[".warnLeavingPages"] = true;



$tstrOrderBy = "";
if(strlen($tstrOrderBy) && strtolower(substr($tstrOrderBy,0,8))!="order by")
	$tstrOrderBy = "order by ".$tstrOrderBy;
$tdataconfiguracoes[".strOrderBy"] = $tstrOrderBy;

$tdataconfiguracoes[".orderindexes"] = array();

$tdataconfiguracoes[".sqlHead"] = "SELECT idconf,   titulosite,   descricaosite,   rodapesite,   emailcontato";
$tdataconfiguracoes[".sqlFrom"] = "FROM configuracoes";
$tdataconfiguracoes[".sqlWhereExpr"] = "";
$tdataconfiguracoes[".sqlTail"] = "";




//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdataconfiguracoes[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdataconfiguracoes[".arrGroupsPerPage"] = $arrGPP;

$tdataconfiguracoes[".highlightSearchResults"] = true;

$tableKeysconfiguracoes = array();
$tableKeysconfiguracoes[] = "idconf";
$tdataconfiguracoes[".Keys"] = $tableKeysconfiguracoes;

$tdataconfiguracoes[".listFields"] = array();
$tdataconfiguracoes[".listFields"][] = "idconf";
$tdataconfiguracoes[".listFields"][] = "titulosite";
$tdataconfiguracoes[".listFields"][] = "descricaosite";
$tdataconfiguracoes[".listFields"][] = "rodapesite";
$tdataconfiguracoes[".listFields"][] = "emailcontato";

$tdataconfiguracoes[".hideMobileList"] = array();


$tdataconfiguracoes[".viewFields"] = array();
$tdataconfiguracoes[".viewFields"][] = "idconf";
$tdataconfiguracoes[".viewFields"][] = "titulosite";
$tdataconfiguracoes[".viewFields"][] = "descricaosite";
$tdataconfiguracoes[".viewFields"][] = "rodapesite";
$tdataconfiguracoes[".viewFields"][] = "emailcontato";

$tdataconfiguracoes[".addFields"] = array();
$tdataconfiguracoes[".addFields"][] = "titulosite";
$tdataconfiguracoes[".addFields"][] = "descricaosite";
$tdataconfiguracoes[".addFields"][] = "rodapesite";
$tdataconfiguracoes[".addFields"][] = "emailcontato";

$tdataconfiguracoes[".inlineAddFields"] = array();
$tdataconfiguracoes[".inlineAddFields"][] = "titulosite";
$tdataconfiguracoes[".inlineAddFields"][] = "descricaosite";
$tdataconfiguracoes[".inlineAddFields"][] = "rodapesite";
$tdataconfiguracoes[".inlineAddFields"][] = "emailcontato";

$tdataconfiguracoes[".editFields"] = array();
$tdataconfiguracoes[".editFields"][] = "titulosite";
$tdataconfiguracoes[".editFields"][] = "descricaosite";
$tdataconfiguracoes[".editFields"][] = "rodapesite";
$tdataconfiguracoes[".editFields"][] = "emailcontato";

$tdataconfiguracoes[".inlineEditFields"] = array();
$tdataconfiguracoes[".inlineEditFields"][] = "titulosite";
$tdataconfiguracoes[".inlineEditFields"][] = "descricaosite";
$tdataconfiguracoes[".inlineEditFields"][] = "rodapesite";
$tdataconfiguracoes[".inlineEditFields"][] = "emailcontato";

$tdataconfiguracoes[".exportFields"] = array();
$tdataconfiguracoes[".exportFields"][] = "idconf";
$tdataconfiguracoes[".exportFields"][] = "titulosite";
$tdataconfiguracoes[".exportFields"][] = "descricaosite";
$tdataconfiguracoes[".exportFields"][] = "rodapesite";
$tdataconfiguracoes[".exportFields"][] = "emailcontato";

$tdataconfiguracoes[".importFields"] = array();
$tdataconfiguracoes[".importFields"][] = "idconf";
$tdataconfiguracoes[".importFields"][] = "titulosite";
$tdataconfiguracoes[".importFields"][] = "descricaosite";
$tdataconfiguracoes[".importFields"][] = "rodapesite";
$tdataconfiguracoes[".importFields"][] = "emailcontato";

$tdataconfiguracoes[".printFields"] = array();
$tdataconfiguracoes[".printFields"][] = "idconf";
$tdataconfiguracoes[".printFields"][] = "titulosite";
$tdataconfiguracoes[".printFields"][] = "descricaosite";
$tdataconfiguracoes[".printFields"][] = "rodapesite";
$tdataconfiguracoes[".printFields"][] = "emailcontato";

//	idconf
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "idconf";
	$fdata["GoodName"] = "idconf";
	$fdata["ownerTable"] = "configuracoes";
	$fdata["Label"] = GetFieldLabel("configuracoes","idconf"); 
	$fdata["FieldType"] = 3;
	
		
		$fdata["AutoInc"] = true;
	
		
				
		$fdata["bListPage"] = true; 
	
		
		
		
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "idconf"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "idconf";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "");
	
		
		
		
		
		
		
		
		
		
		
		
		$vdata["NeedEncode"] = true;
	
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Text field");
	
			
	
	


		$edata["IsRequired"] = true; 
	
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
		
			$edata["HTML5InuptType"] = "number";
	
		$edata["EditParams"] = "";
			
		$edata["controlWidth"] = 200;
	
//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
				$edata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");	
						$edata["validateAs"]["basicValidate"][] = "IsRequired";
			
		
	//	End validation
	
		
				
		
	
		
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats
	
	
	$fdata["isSeparate"] = false;
	
	
	
	
// the field's search options settings
		
			// the default search options list
				$fdata["searchOptionsList"] = array("Equals", "More than", "Less than", "Between");
// the end of search options settings	

	

	
	$tdataconfiguracoes["idconf"] = $fdata;
//	titulosite
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "titulosite";
	$fdata["GoodName"] = "titulosite";
	$fdata["ownerTable"] = "configuracoes";
	$fdata["Label"] = GetFieldLabel("configuracoes","titulosite"); 
	$fdata["FieldType"] = 200;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		$fdata["bInlineAdd"] = true; 
	
		$fdata["bEditPage"] = true; 
	
		$fdata["bInlineEdit"] = true; 
	
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "titulosite"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "titulosite";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "");
	
		
		
		
		
		
		
		
		
		
		
		
		$vdata["NeedEncode"] = true;
	
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Text field");
	
			
	
	


		
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
		
			$edata["HTML5InuptType"] = "text";
	
		$edata["EditParams"] = "";
			$edata["EditParams"].= " maxlength=50";
	
		$edata["controlWidth"] = 200;
	
//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
		
		
	//	End validation
	
		
				
		
	
		
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats
	
	
	$fdata["isSeparate"] = false;
	
	
	
	
// the field's search options settings
		
			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Empty");
// the end of search options settings	

	

	
	$tdataconfiguracoes["titulosite"] = $fdata;
//	descricaosite
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "descricaosite";
	$fdata["GoodName"] = "descricaosite";
	$fdata["ownerTable"] = "configuracoes";
	$fdata["Label"] = GetFieldLabel("configuracoes","descricaosite"); 
	$fdata["FieldType"] = 201;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		$fdata["bInlineAdd"] = true; 
	
		$fdata["bEditPage"] = true; 
	
		$fdata["bInlineEdit"] = true; 
	
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "descricaosite"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "descricaosite";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "");
	
		
		
		
		
		
		
		
		
		
		
		
		$vdata["NeedEncode"] = true;
	
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Text area");
	
			
	
	


		
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
				$edata["nRows"] = 100;
			$edata["nCols"] = 200;
	
		
		
		$edata["controlWidth"] = 200;
	
//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
		
		
	//	End validation
	
		
				
		
	
		
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats
	
	
	$fdata["isSeparate"] = false;
	
	
	
	
// the field's search options settings
		
			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Empty");
// the end of search options settings	

	

	
	$tdataconfiguracoes["descricaosite"] = $fdata;
//	rodapesite
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 4;
	$fdata["strName"] = "rodapesite";
	$fdata["GoodName"] = "rodapesite";
	$fdata["ownerTable"] = "configuracoes";
	$fdata["Label"] = GetFieldLabel("configuracoes","rodapesite"); 
	$fdata["FieldType"] = 200;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		$fdata["bInlineAdd"] = true; 
	
		$fdata["bEditPage"] = true; 
	
		$fdata["bInlineEdit"] = true; 
	
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "rodapesite"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "rodapesite";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "");
	
		
		
		
		
		
		
		
		
		
		
		
		$vdata["NeedEncode"] = true;
	
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Text field");
	
			
	
	


		
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
		
			$edata["HTML5InuptType"] = "text";
	
		$edata["EditParams"] = "";
			$edata["EditParams"].= " maxlength=50";
	
		$edata["controlWidth"] = 200;
	
//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
		
		
	//	End validation
	
		
				
		
	
		
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats
	
	
	$fdata["isSeparate"] = false;
	
	
	
	
// the field's search options settings
		
			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Empty");
// the end of search options settings	

	

	
	$tdataconfiguracoes["rodapesite"] = $fdata;
//	emailcontato
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 5;
	$fdata["strName"] = "emailcontato";
	$fdata["GoodName"] = "emailcontato";
	$fdata["ownerTable"] = "configuracoes";
	$fdata["Label"] = GetFieldLabel("configuracoes","emailcontato"); 
	$fdata["FieldType"] = 200;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		$fdata["bInlineAdd"] = true; 
	
		$fdata["bEditPage"] = true; 
	
		$fdata["bInlineEdit"] = true; 
	
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "emailcontato"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "emailcontato";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "");
	
		
		
		
		
		
		
		
		
		
		
		
		$vdata["NeedEncode"] = true;
	
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Text field");
	
			
	
	


		
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
		
			$edata["HTML5InuptType"] = "text";
	
		$edata["EditParams"] = "";
			$edata["EditParams"].= " maxlength=50";
	
		$edata["controlWidth"] = 200;
	
//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
		
		
	//	End validation
	
		
				
		
	
		
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats
	
	
	$fdata["isSeparate"] = false;
	
	
	
	
// the field's search options settings
		
			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Empty");
// the end of search options settings	

	

	
	$tdataconfiguracoes["emailcontato"] = $fdata;

	
$tables_data["configuracoes"]=&$tdataconfiguracoes;
$field_labels["configuracoes"] = &$fieldLabelsconfiguracoes;
$fieldToolTips["configuracoes"] = &$fieldToolTipsconfiguracoes;
$page_titles["configuracoes"] = &$pageTitlesconfiguracoes;

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)
$detailsTablesData["configuracoes"] = array();
	
// tables which are master tables for current table (detail)
$masterTablesData["configuracoes"] = array();


// -----------------end  prepare master-details data arrays ------------------------------//

require_once(getabspath("classes/sql.php"));










function createSqlQuery_configuracoes()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "idconf,   titulosite,   descricaosite,   rodapesite,   emailcontato";
$proto0["m_strFrom"] = "FROM configuracoes";
$proto0["m_strWhere"] = "";
$proto0["m_strOrderBy"] = "";
$proto0["m_strTail"] = "";
			$proto0["cipherer"] = null;
$proto1=array();
$proto1["m_sql"] = "";
$proto1["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto1["m_column"]=$obj;
$proto1["m_contained"] = array();
$proto1["m_strCase"] = "";
$proto1["m_havingmode"] = false;
$proto1["m_inBrackets"] = false;
$proto1["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto1);

$proto0["m_where"] = $obj;
$proto3=array();
$proto3["m_sql"] = "";
$proto3["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto3["m_column"]=$obj;
$proto3["m_contained"] = array();
$proto3["m_strCase"] = "";
$proto3["m_havingmode"] = false;
$proto3["m_inBrackets"] = false;
$proto3["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto3);

$proto0["m_having"] = $obj;
$proto0["m_fieldlist"] = array();
						$proto5=array();
			$obj = new SQLField(array(
	"m_strName" => "idconf",
	"m_strTable" => "configuracoes",
	"m_srcTableName" => "configuracoes"
));

$proto5["m_sql"] = "idconf";
$proto5["m_srcTableName"] = "configuracoes";
$proto5["m_expr"]=$obj;
$proto5["m_alias"] = "";
$obj = new SQLFieldListItem($proto5);

$proto0["m_fieldlist"][]=$obj;
						$proto7=array();
			$obj = new SQLField(array(
	"m_strName" => "titulosite",
	"m_strTable" => "configuracoes",
	"m_srcTableName" => "configuracoes"
));

$proto7["m_sql"] = "titulosite";
$proto7["m_srcTableName"] = "configuracoes";
$proto7["m_expr"]=$obj;
$proto7["m_alias"] = "";
$obj = new SQLFieldListItem($proto7);

$proto0["m_fieldlist"][]=$obj;
						$proto9=array();
			$obj = new SQLField(array(
	"m_strName" => "descricaosite",
	"m_strTable" => "configuracoes",
	"m_srcTableName" => "configuracoes"
));

$proto9["m_sql"] = "descricaosite";
$proto9["m_srcTableName"] = "configuracoes";
$proto9["m_expr"]=$obj;
$proto9["m_alias"] = "";
$obj = new SQLFieldListItem($proto9);

$proto0["m_fieldlist"][]=$obj;
						$proto11=array();
			$obj = new SQLField(array(
	"m_strName" => "rodapesite",
	"m_strTable" => "configuracoes",
	"m_srcTableName" => "configuracoes"
));

$proto11["m_sql"] = "rodapesite";
$proto11["m_srcTableName"] = "configuracoes";
$proto11["m_expr"]=$obj;
$proto11["m_alias"] = "";
$obj = new SQLFieldListItem($proto11);

$proto0["m_fieldlist"][]=$obj;
						$proto13=array();
			$obj = new SQLField(array(
	"m_strName" => "emailcontato",
	"m_strTable" => "configuracoes",
	"m_srcTableName" => "configuracoes"
));

$proto13["m_sql"] = "emailcontato";
$proto13["m_srcTableName"] = "configuracoes";
$proto13["m_expr"]=$obj;
$proto13["m_alias"] = "";
$obj = new SQLFieldListItem($proto13);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto15=array();
$proto15["m_link"] = "SQLL_MAIN";
			$proto16=array();
$proto16["m_strName"] = "configuracoes";
$proto16["m_srcTableName"] = "configuracoes";
$proto16["m_columns"] = array();
$proto16["m_columns"][] = "idconf";
$proto16["m_columns"][] = "titulosite";
$proto16["m_columns"][] = "descricaosite";
$proto16["m_columns"][] = "rodapesite";
$proto16["m_columns"][] = "emailcontato";
$obj = new SQLTable($proto16);

$proto15["m_table"] = $obj;
$proto15["m_sql"] = "configuracoes";
$proto15["m_alias"] = "";
$proto15["m_srcTableName"] = "configuracoes";
$proto17=array();
$proto17["m_sql"] = "";
$proto17["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto17["m_column"]=$obj;
$proto17["m_contained"] = array();
$proto17["m_strCase"] = "";
$proto17["m_havingmode"] = false;
$proto17["m_inBrackets"] = false;
$proto17["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto17);

$proto15["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto15);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="configuracoes";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_configuracoes = createSqlQuery_configuracoes();


	
					
	
$tdataconfiguracoes[".sqlquery"] = $queryData_configuracoes;

$tableEvents["configuracoes"] = new eventsBase;
$tdataconfiguracoes[".hasEvents"] = false;

?>