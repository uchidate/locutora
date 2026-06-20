<?php
require_once(getabspath("classes/cipherer.php"));




$tdataadmin = array();	
	$tdataadmin[".truncateText"] = true;
	$tdataadmin[".NumberOfChars"] = 80; 
	$tdataadmin[".ShortName"] = "admin";
	$tdataadmin[".OwnerID"] = "";
	$tdataadmin[".OriginalTable"] = "admin";

//	field labels
$fieldLabelsadmin = array();
$fieldToolTipsadmin = array();
$pageTitlesadmin = array();

if(mlang_getcurrentlang()=="Portuguese(Brazil)")
{
	$fieldLabelsadmin["Portuguese(Brazil)"] = array();
	$fieldToolTipsadmin["Portuguese(Brazil)"] = array();
	$pageTitlesadmin["Portuguese(Brazil)"] = array();
	$fieldLabelsadmin["Portuguese(Brazil)"]["idadm"] = "Idadm";
	$fieldToolTipsadmin["Portuguese(Brazil)"]["idadm"] = "";
	$fieldLabelsadmin["Portuguese(Brazil)"]["nome"] = "Nome";
	$fieldToolTipsadmin["Portuguese(Brazil)"]["nome"] = "";
	$fieldLabelsadmin["Portuguese(Brazil)"]["email"] = "Email";
	$fieldToolTipsadmin["Portuguese(Brazil)"]["email"] = "";
	$fieldLabelsadmin["Portuguese(Brazil)"]["senha"] = "Senha";
	$fieldToolTipsadmin["Portuguese(Brazil)"]["senha"] = "";
	if (count($fieldToolTipsadmin["Portuguese(Brazil)"]))
		$tdataadmin[".isUseToolTips"] = true;
}
if(mlang_getcurrentlang()=="")
{
	$fieldLabelsadmin[""] = array();
	$fieldToolTipsadmin[""] = array();
	$pageTitlesadmin[""] = array();
	$fieldLabelsadmin[""]["idadm"] = "Idadm";
	$fieldToolTipsadmin[""]["idadm"] = "";
	if (count($fieldToolTipsadmin[""]))
		$tdataadmin[".isUseToolTips"] = true;
}
	
	
	$tdataadmin[".NCSearch"] = true;



$tdataadmin[".shortTableName"] = "admin";
$tdataadmin[".nSecOptions"] = 0;
$tdataadmin[".recsPerRowList"] = 1;
$tdataadmin[".mainTableOwnerID"] = "";
$tdataadmin[".moveNext"] = 1;
$tdataadmin[".nType"] = 0;

$tdataadmin[".strOriginalTableName"] = "admin";




$tdataadmin[".showAddInPopup"] = false;

$tdataadmin[".showEditInPopup"] = false;

$tdataadmin[".showViewInPopup"] = false;

//page's base css files names
$popupPagesLayoutNames = array();
$tdataadmin[".popupPagesLayoutNames"] = $popupPagesLayoutNames;


$tdataadmin[".fieldsForRegister"] = array();

$tdataadmin[".listAjax"] = false;

	$tdataadmin[".audit"] = false;

	$tdataadmin[".locking"] = false;

$tdataadmin[".edit"] = true;

$tdataadmin[".list"] = true;

$tdataadmin[".view"] = true;

$tdataadmin[".import"] = true;

$tdataadmin[".exportTo"] = true;

$tdataadmin[".printFriendly"] = true;

$tdataadmin[".delete"] = true;

$tdataadmin[".showSimpleSearchOptions"] = false;

// search Saving settings
$tdataadmin[".searchSaving"] = false;
//

$tdataadmin[".showSearchPanel"] = true;
		$tdataadmin[".flexibleSearch"] = true;		

if (isMobile())
	$tdataadmin[".isUseAjaxSuggest"] = false;
else 
	$tdataadmin[".isUseAjaxSuggest"] = true;

$tdataadmin[".rowHighlite"] = true;



$tdataadmin[".addPageEvents"] = false;

// use timepicker for search panel
$tdataadmin[".isUseTimeForSearch"] = false;





$tdataadmin[".allSearchFields"] = array();
$tdataadmin[".filterFields"] = array();
$tdataadmin[".requiredSearchFields"] = array();

$tdataadmin[".allSearchFields"][] = "idadm";
	$tdataadmin[".allSearchFields"][] = "nome";
	$tdataadmin[".allSearchFields"][] = "email";
	$tdataadmin[".allSearchFields"][] = "senha";
	

$tdataadmin[".googleLikeFields"] = array();
$tdataadmin[".googleLikeFields"][] = "idadm";
$tdataadmin[".googleLikeFields"][] = "nome";
$tdataadmin[".googleLikeFields"][] = "email";
$tdataadmin[".googleLikeFields"][] = "senha";


$tdataadmin[".advSearchFields"] = array();
$tdataadmin[".advSearchFields"][] = "idadm";
$tdataadmin[".advSearchFields"][] = "nome";
$tdataadmin[".advSearchFields"][] = "email";
$tdataadmin[".advSearchFields"][] = "senha";

$tdataadmin[".tableType"] = "list";

$tdataadmin[".printerPageOrientation"] = 0;
$tdataadmin[".nPrinterPageScale"] = 100;

$tdataadmin[".nPrinterSplitRecords"] = 40;

$tdataadmin[".nPrinterPDFSplitRecords"] = 40;





	





// view page pdf

// print page pdf


$tdataadmin[".pageSize"] = 20;

$tdataadmin[".warnLeavingPages"] = true;



$tstrOrderBy = "";
if(strlen($tstrOrderBy) && strtolower(substr($tstrOrderBy,0,8))!="order by")
	$tstrOrderBy = "order by ".$tstrOrderBy;
$tdataadmin[".strOrderBy"] = $tstrOrderBy;

$tdataadmin[".orderindexes"] = array();

$tdataadmin[".sqlHead"] = "SELECT idadm,  nome,  email,  senha";
$tdataadmin[".sqlFrom"] = "FROM `admin`";
$tdataadmin[".sqlWhereExpr"] = "";
$tdataadmin[".sqlTail"] = "";




//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdataadmin[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdataadmin[".arrGroupsPerPage"] = $arrGPP;

$tdataadmin[".highlightSearchResults"] = true;

$tableKeysadmin = array();
$tableKeysadmin[] = "idadm";
$tdataadmin[".Keys"] = $tableKeysadmin;

$tdataadmin[".listFields"] = array();
$tdataadmin[".listFields"][] = "idadm";
$tdataadmin[".listFields"][] = "nome";
$tdataadmin[".listFields"][] = "email";
$tdataadmin[".listFields"][] = "senha";

$tdataadmin[".hideMobileList"] = array();


$tdataadmin[".viewFields"] = array();
$tdataadmin[".viewFields"][] = "idadm";
$tdataadmin[".viewFields"][] = "nome";
$tdataadmin[".viewFields"][] = "email";
$tdataadmin[".viewFields"][] = "senha";

$tdataadmin[".addFields"] = array();
$tdataadmin[".addFields"][] = "nome";
$tdataadmin[".addFields"][] = "email";
$tdataadmin[".addFields"][] = "senha";

$tdataadmin[".inlineAddFields"] = array();
$tdataadmin[".inlineAddFields"][] = "nome";
$tdataadmin[".inlineAddFields"][] = "email";
$tdataadmin[".inlineAddFields"][] = "senha";

$tdataadmin[".editFields"] = array();
$tdataadmin[".editFields"][] = "nome";
$tdataadmin[".editFields"][] = "email";
$tdataadmin[".editFields"][] = "senha";

$tdataadmin[".inlineEditFields"] = array();
$tdataadmin[".inlineEditFields"][] = "nome";
$tdataadmin[".inlineEditFields"][] = "email";
$tdataadmin[".inlineEditFields"][] = "senha";

$tdataadmin[".exportFields"] = array();
$tdataadmin[".exportFields"][] = "idadm";
$tdataadmin[".exportFields"][] = "nome";
$tdataadmin[".exportFields"][] = "email";
$tdataadmin[".exportFields"][] = "senha";

$tdataadmin[".importFields"] = array();
$tdataadmin[".importFields"][] = "idadm";
$tdataadmin[".importFields"][] = "nome";
$tdataadmin[".importFields"][] = "email";
$tdataadmin[".importFields"][] = "senha";

$tdataadmin[".printFields"] = array();
$tdataadmin[".printFields"][] = "idadm";
$tdataadmin[".printFields"][] = "nome";
$tdataadmin[".printFields"][] = "email";
$tdataadmin[".printFields"][] = "senha";

//	idadm
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "idadm";
	$fdata["GoodName"] = "idadm";
	$fdata["ownerTable"] = "admin";
	$fdata["Label"] = GetFieldLabel("admin","idadm"); 
	$fdata["FieldType"] = 3;
	
		
		$fdata["AutoInc"] = true;
	
		
				
		$fdata["bListPage"] = true; 
	
		
		
		
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "idadm"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "idadm";
	
		
		
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

	

	
	$tdataadmin["idadm"] = $fdata;
//	nome
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "nome";
	$fdata["GoodName"] = "nome";
	$fdata["ownerTable"] = "admin";
	$fdata["Label"] = GetFieldLabel("admin","nome"); 
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
	
		$fdata["strField"] = "nome"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "nome";
	
		
		
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

	

	
	$tdataadmin["nome"] = $fdata;
//	email
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "email";
	$fdata["GoodName"] = "email";
	$fdata["ownerTable"] = "admin";
	$fdata["Label"] = GetFieldLabel("admin","email"); 
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
	
		$fdata["strField"] = "email"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "email";
	
		
		
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
	
		
		
		
		
			$edata["HTML5InuptType"] = "email";
	
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

	

	
	$tdataadmin["email"] = $fdata;
//	senha
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 4;
	$fdata["strName"] = "senha";
	$fdata["GoodName"] = "senha";
	$fdata["ownerTable"] = "admin";
	$fdata["Label"] = GetFieldLabel("admin","senha"); 
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
	
		$fdata["strField"] = "senha"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "senha";
	
		
		
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

	

	
	$tdataadmin["senha"] = $fdata;

	
$tables_data["admin"]=&$tdataadmin;
$field_labels["admin"] = &$fieldLabelsadmin;
$fieldToolTips["admin"] = &$fieldToolTipsadmin;
$page_titles["admin"] = &$pageTitlesadmin;

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)
$detailsTablesData["admin"] = array();
	
// tables which are master tables for current table (detail)
$masterTablesData["admin"] = array();


// -----------------end  prepare master-details data arrays ------------------------------//

require_once(getabspath("classes/sql.php"));










function createSqlQuery_admin()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "idadm,  nome,  email,  senha";
$proto0["m_strFrom"] = "FROM `admin`";
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
	"m_strName" => "idadm",
	"m_strTable" => "admin",
	"m_srcTableName" => "admin"
));

$proto5["m_sql"] = "idadm";
$proto5["m_srcTableName"] = "admin";
$proto5["m_expr"]=$obj;
$proto5["m_alias"] = "";
$obj = new SQLFieldListItem($proto5);

$proto0["m_fieldlist"][]=$obj;
						$proto7=array();
			$obj = new SQLField(array(
	"m_strName" => "nome",
	"m_strTable" => "admin",
	"m_srcTableName" => "admin"
));

$proto7["m_sql"] = "nome";
$proto7["m_srcTableName"] = "admin";
$proto7["m_expr"]=$obj;
$proto7["m_alias"] = "";
$obj = new SQLFieldListItem($proto7);

$proto0["m_fieldlist"][]=$obj;
						$proto9=array();
			$obj = new SQLField(array(
	"m_strName" => "email",
	"m_strTable" => "admin",
	"m_srcTableName" => "admin"
));

$proto9["m_sql"] = "email";
$proto9["m_srcTableName"] = "admin";
$proto9["m_expr"]=$obj;
$proto9["m_alias"] = "";
$obj = new SQLFieldListItem($proto9);

$proto0["m_fieldlist"][]=$obj;
						$proto11=array();
			$obj = new SQLField(array(
	"m_strName" => "senha",
	"m_strTable" => "admin",
	"m_srcTableName" => "admin"
));

$proto11["m_sql"] = "senha";
$proto11["m_srcTableName"] = "admin";
$proto11["m_expr"]=$obj;
$proto11["m_alias"] = "";
$obj = new SQLFieldListItem($proto11);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto13=array();
$proto13["m_link"] = "SQLL_MAIN";
			$proto14=array();
$proto14["m_strName"] = "admin";
$proto14["m_srcTableName"] = "admin";
$proto14["m_columns"] = array();
$proto14["m_columns"][] = "idadm";
$proto14["m_columns"][] = "nome";
$proto14["m_columns"][] = "email";
$proto14["m_columns"][] = "senha";
$obj = new SQLTable($proto14);

$proto13["m_table"] = $obj;
$proto13["m_sql"] = "`admin`";
$proto13["m_alias"] = "";
$proto13["m_srcTableName"] = "admin";
$proto15=array();
$proto15["m_sql"] = "";
$proto15["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto15["m_column"]=$obj;
$proto15["m_contained"] = array();
$proto15["m_strCase"] = "";
$proto15["m_havingmode"] = false;
$proto15["m_inBrackets"] = false;
$proto15["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto15);

$proto13["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto13);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="admin";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_admin = createSqlQuery_admin();


	
				
	
$tdataadmin[".sqlquery"] = $queryData_admin;

$tableEvents["admin"] = new eventsBase;
$tdataadmin[".hasEvents"] = false;

?>