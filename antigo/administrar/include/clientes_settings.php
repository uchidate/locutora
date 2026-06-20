<?php
require_once(getabspath("classes/cipherer.php"));




$tdataclientes = array();	
	$tdataclientes[".truncateText"] = true;
	$tdataclientes[".NumberOfChars"] = 80; 
	$tdataclientes[".ShortName"] = "clientes";
	$tdataclientes[".OwnerID"] = "";
	$tdataclientes[".OriginalTable"] = "clientes";

//	field labels
$fieldLabelsclientes = array();
$fieldToolTipsclientes = array();
$pageTitlesclientes = array();

if(mlang_getcurrentlang()=="Portuguese(Brazil)")
{
	$fieldLabelsclientes["Portuguese(Brazil)"] = array();
	$fieldToolTipsclientes["Portuguese(Brazil)"] = array();
	$pageTitlesclientes["Portuguese(Brazil)"] = array();
	$fieldLabelsclientes["Portuguese(Brazil)"]["idcli"] = "Idcli";
	$fieldToolTipsclientes["Portuguese(Brazil)"]["idcli"] = "";
	$fieldLabelsclientes["Portuguese(Brazil)"]["nomeCliente"] = "Nome Cliente";
	$fieldToolTipsclientes["Portuguese(Brazil)"]["nomeCliente"] = "";
	$fieldLabelsclientes["Portuguese(Brazil)"]["foto"] = "Foto";
	$fieldToolTipsclientes["Portuguese(Brazil)"]["foto"] = "";
	if (count($fieldToolTipsclientes["Portuguese(Brazil)"]))
		$tdataclientes[".isUseToolTips"] = true;
}
if(mlang_getcurrentlang()=="")
{
	$fieldLabelsclientes[""] = array();
	$fieldToolTipsclientes[""] = array();
	$pageTitlesclientes[""] = array();
	if (count($fieldToolTipsclientes[""]))
		$tdataclientes[".isUseToolTips"] = true;
}
	
	
	$tdataclientes[".NCSearch"] = true;



$tdataclientes[".shortTableName"] = "clientes";
$tdataclientes[".nSecOptions"] = 0;
$tdataclientes[".recsPerRowList"] = 1;
$tdataclientes[".mainTableOwnerID"] = "";
$tdataclientes[".moveNext"] = 1;
$tdataclientes[".nType"] = 0;

$tdataclientes[".strOriginalTableName"] = "clientes";




$tdataclientes[".showAddInPopup"] = false;

$tdataclientes[".showEditInPopup"] = false;

$tdataclientes[".showViewInPopup"] = false;

//page's base css files names
$popupPagesLayoutNames = array();
$tdataclientes[".popupPagesLayoutNames"] = $popupPagesLayoutNames;


$tdataclientes[".fieldsForRegister"] = array();

$tdataclientes[".listAjax"] = false;

	$tdataclientes[".audit"] = false;

	$tdataclientes[".locking"] = false;

$tdataclientes[".edit"] = true;

$tdataclientes[".list"] = true;

$tdataclientes[".view"] = true;

$tdataclientes[".import"] = true;

$tdataclientes[".exportTo"] = true;

$tdataclientes[".printFriendly"] = true;

$tdataclientes[".delete"] = true;

$tdataclientes[".showSimpleSearchOptions"] = false;

// search Saving settings
$tdataclientes[".searchSaving"] = false;
//

$tdataclientes[".showSearchPanel"] = true;
		$tdataclientes[".flexibleSearch"] = true;		

if (isMobile())
	$tdataclientes[".isUseAjaxSuggest"] = false;
else 
	$tdataclientes[".isUseAjaxSuggest"] = true;

$tdataclientes[".rowHighlite"] = true;



$tdataclientes[".addPageEvents"] = false;

// use timepicker for search panel
$tdataclientes[".isUseTimeForSearch"] = false;





$tdataclientes[".allSearchFields"] = array();
$tdataclientes[".filterFields"] = array();
$tdataclientes[".requiredSearchFields"] = array();

$tdataclientes[".allSearchFields"][] = "idcli";
	$tdataclientes[".allSearchFields"][] = "nomeCliente";
	$tdataclientes[".allSearchFields"][] = "foto";
	

$tdataclientes[".googleLikeFields"] = array();
$tdataclientes[".googleLikeFields"][] = "idcli";
$tdataclientes[".googleLikeFields"][] = "nomeCliente";
$tdataclientes[".googleLikeFields"][] = "foto";


$tdataclientes[".advSearchFields"] = array();
$tdataclientes[".advSearchFields"][] = "idcli";
$tdataclientes[".advSearchFields"][] = "nomeCliente";
$tdataclientes[".advSearchFields"][] = "foto";

$tdataclientes[".tableType"] = "list";

$tdataclientes[".printerPageOrientation"] = 0;
$tdataclientes[".nPrinterPageScale"] = 100;

$tdataclientes[".nPrinterSplitRecords"] = 40;

$tdataclientes[".nPrinterPDFSplitRecords"] = 40;





	





// view page pdf

// print page pdf


$tdataclientes[".pageSize"] = 20;

$tdataclientes[".warnLeavingPages"] = true;



$tstrOrderBy = "";
if(strlen($tstrOrderBy) && strtolower(substr($tstrOrderBy,0,8))!="order by")
	$tstrOrderBy = "order by ".$tstrOrderBy;
$tdataclientes[".strOrderBy"] = $tstrOrderBy;

$tdataclientes[".orderindexes"] = array();

$tdataclientes[".sqlHead"] = "SELECT idcli,  nomeCliente,  foto";
$tdataclientes[".sqlFrom"] = "FROM clientes";
$tdataclientes[".sqlWhereExpr"] = "";
$tdataclientes[".sqlTail"] = "";




//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdataclientes[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdataclientes[".arrGroupsPerPage"] = $arrGPP;

$tdataclientes[".highlightSearchResults"] = true;

$tableKeysclientes = array();
$tableKeysclientes[] = "idcli";
$tdataclientes[".Keys"] = $tableKeysclientes;

$tdataclientes[".listFields"] = array();
$tdataclientes[".listFields"][] = "idcli";
$tdataclientes[".listFields"][] = "nomeCliente";
$tdataclientes[".listFields"][] = "foto";

$tdataclientes[".hideMobileList"] = array();


$tdataclientes[".viewFields"] = array();
$tdataclientes[".viewFields"][] = "idcli";
$tdataclientes[".viewFields"][] = "nomeCliente";
$tdataclientes[".viewFields"][] = "foto";

$tdataclientes[".addFields"] = array();
$tdataclientes[".addFields"][] = "nomeCliente";
$tdataclientes[".addFields"][] = "foto";

$tdataclientes[".inlineAddFields"] = array();

$tdataclientes[".editFields"] = array();
$tdataclientes[".editFields"][] = "nomeCliente";
$tdataclientes[".editFields"][] = "foto";

$tdataclientes[".inlineEditFields"] = array();

$tdataclientes[".exportFields"] = array();
$tdataclientes[".exportFields"][] = "idcli";
$tdataclientes[".exportFields"][] = "nomeCliente";
$tdataclientes[".exportFields"][] = "foto";

$tdataclientes[".importFields"] = array();
$tdataclientes[".importFields"][] = "idcli";
$tdataclientes[".importFields"][] = "nomeCliente";
$tdataclientes[".importFields"][] = "foto";

$tdataclientes[".printFields"] = array();
$tdataclientes[".printFields"][] = "idcli";
$tdataclientes[".printFields"][] = "nomeCliente";
$tdataclientes[".printFields"][] = "foto";

//	idcli
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "idcli";
	$fdata["GoodName"] = "idcli";
	$fdata["ownerTable"] = "clientes";
	$fdata["Label"] = GetFieldLabel("clientes","idcli"); 
	$fdata["FieldType"] = 3;
	
		
		$fdata["AutoInc"] = true;
	
		
				
		$fdata["bListPage"] = true; 
	
		
		
		
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "idcli"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "idcli";
	
		
		
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

	

	
	$tdataclientes["idcli"] = $fdata;
//	nomeCliente
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "nomeCliente";
	$fdata["GoodName"] = "nomeCliente";
	$fdata["ownerTable"] = "clientes";
	$fdata["Label"] = GetFieldLabel("clientes","nomeCliente"); 
	$fdata["FieldType"] = 200;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		
		$fdata["bEditPage"] = true; 
	
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "nomeCliente"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "nomeCliente";
	
		
		
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

	

	
	$tdataclientes["nomeCliente"] = $fdata;
//	foto
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "foto";
	$fdata["GoodName"] = "foto";
	$fdata["ownerTable"] = "clientes";
	$fdata["Label"] = GetFieldLabel("clientes","foto"); 
	$fdata["FieldType"] = 201;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		
		$fdata["bEditPage"] = true; 
	
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "foto"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "foto";
	
		$fdata["DeleteAssociatedFile"] = true;
	
		$fdata["CompatibilityMode"] = true; 
	
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "Document Download");
	
		
		
		
				$vdata["ShowThumbnail"] = true; 
			$vdata["ShowFileSize"] = true; 
			$vdata["ShowIcon"] = true; 
			
		
		
		
		
		
		
		
		
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Document upload");
	
			
	
	


		$edata["IsRequired"] = true; 
	
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
		
		
		
		$edata["controlWidth"] = 200;
	
//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
						$edata["validateAs"]["basicValidate"][] = "IsRequired";
			
		
	//	End validation
	
		$edata["CreateThumbnail"] = true;
	$edata["StrThumbnail"] = "th";
			$edata["ThumbnailSize"] = 150;
	
				
		
	
		
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats
	
	
	$fdata["isSeparate"] = false;
	
	
	$fdata["Absolute"] = true;
	
	
// the field's search options settings
		
			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Empty");
// the end of search options settings	

	

	
	$tdataclientes["foto"] = $fdata;

	
$tables_data["clientes"]=&$tdataclientes;
$field_labels["clientes"] = &$fieldLabelsclientes;
$fieldToolTips["clientes"] = &$fieldToolTipsclientes;
$page_titles["clientes"] = &$pageTitlesclientes;

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)
$detailsTablesData["clientes"] = array();
	
// tables which are master tables for current table (detail)
$masterTablesData["clientes"] = array();


// -----------------end  prepare master-details data arrays ------------------------------//

require_once(getabspath("classes/sql.php"));










function createSqlQuery_clientes()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "idcli,  nomeCliente,  foto";
$proto0["m_strFrom"] = "FROM clientes";
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
	"m_strName" => "idcli",
	"m_strTable" => "clientes",
	"m_srcTableName" => "clientes"
));

$proto5["m_sql"] = "idcli";
$proto5["m_srcTableName"] = "clientes";
$proto5["m_expr"]=$obj;
$proto5["m_alias"] = "";
$obj = new SQLFieldListItem($proto5);

$proto0["m_fieldlist"][]=$obj;
						$proto7=array();
			$obj = new SQLField(array(
	"m_strName" => "nomeCliente",
	"m_strTable" => "clientes",
	"m_srcTableName" => "clientes"
));

$proto7["m_sql"] = "nomeCliente";
$proto7["m_srcTableName"] = "clientes";
$proto7["m_expr"]=$obj;
$proto7["m_alias"] = "";
$obj = new SQLFieldListItem($proto7);

$proto0["m_fieldlist"][]=$obj;
						$proto9=array();
			$obj = new SQLField(array(
	"m_strName" => "foto",
	"m_strTable" => "clientes",
	"m_srcTableName" => "clientes"
));

$proto9["m_sql"] = "foto";
$proto9["m_srcTableName"] = "clientes";
$proto9["m_expr"]=$obj;
$proto9["m_alias"] = "";
$obj = new SQLFieldListItem($proto9);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto11=array();
$proto11["m_link"] = "SQLL_MAIN";
			$proto12=array();
$proto12["m_strName"] = "clientes";
$proto12["m_srcTableName"] = "clientes";
$proto12["m_columns"] = array();
$proto12["m_columns"][] = "idcli";
$proto12["m_columns"][] = "nomeCliente";
$proto12["m_columns"][] = "foto";
$obj = new SQLTable($proto12);

$proto11["m_table"] = $obj;
$proto11["m_sql"] = "clientes";
$proto11["m_alias"] = "";
$proto11["m_srcTableName"] = "clientes";
$proto13=array();
$proto13["m_sql"] = "";
$proto13["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto13["m_column"]=$obj;
$proto13["m_contained"] = array();
$proto13["m_strCase"] = "";
$proto13["m_havingmode"] = false;
$proto13["m_inBrackets"] = false;
$proto13["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto13);

$proto11["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto11);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="clientes";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_clientes = createSqlQuery_clientes();


	
			
	
$tdataclientes[".sqlquery"] = $queryData_clientes;

$tableEvents["clientes"] = new eventsBase;
$tdataclientes[".hasEvents"] = false;

?>