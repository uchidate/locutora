<?php
require_once(getabspath("classes/cipherer.php"));




$tdatapaginas = array();	
	$tdatapaginas[".truncateText"] = true;
	$tdatapaginas[".NumberOfChars"] = 80; 
	$tdatapaginas[".ShortName"] = "paginas";
	$tdatapaginas[".OwnerID"] = "";
	$tdatapaginas[".OriginalTable"] = "paginas";

//	field labels
$fieldLabelspaginas = array();
$fieldToolTipspaginas = array();
$pageTitlespaginas = array();

if(mlang_getcurrentlang()=="Portuguese(Brazil)")
{
	$fieldLabelspaginas["Portuguese(Brazil)"] = array();
	$fieldToolTipspaginas["Portuguese(Brazil)"] = array();
	$pageTitlespaginas["Portuguese(Brazil)"] = array();
	$fieldLabelspaginas["Portuguese(Brazil)"]["idpage"] = "Idpage";
	$fieldToolTipspaginas["Portuguese(Brazil)"]["idpage"] = "";
	$fieldLabelspaginas["Portuguese(Brazil)"]["titulopage"] = "Titulopage";
	$fieldToolTipspaginas["Portuguese(Brazil)"]["titulopage"] = "";
	$fieldLabelspaginas["Portuguese(Brazil)"]["datapage"] = "Data";
	$fieldToolTipspaginas["Portuguese(Brazil)"]["datapage"] = "";
	$fieldLabelspaginas["Portuguese(Brazil)"]["conteudo"] = "Conteudo";
	$fieldToolTipspaginas["Portuguese(Brazil)"]["conteudo"] = "";
	$fieldLabelspaginas["Portuguese(Brazil)"]["publicado"] = "Publicado";
	$fieldToolTipspaginas["Portuguese(Brazil)"]["publicado"] = "";
	$fieldLabelspaginas["Portuguese(Brazil)"]["subtitulo"] = "Subtitulo";
	$fieldToolTipspaginas["Portuguese(Brazil)"]["subtitulo"] = "";
	if (count($fieldToolTipspaginas["Portuguese(Brazil)"]))
		$tdatapaginas[".isUseToolTips"] = true;
}
if(mlang_getcurrentlang()=="")
{
	$fieldLabelspaginas[""] = array();
	$fieldToolTipspaginas[""] = array();
	$pageTitlespaginas[""] = array();
	if (count($fieldToolTipspaginas[""]))
		$tdatapaginas[".isUseToolTips"] = true;
}
	
	
	$tdatapaginas[".NCSearch"] = true;



$tdatapaginas[".shortTableName"] = "paginas";
$tdatapaginas[".nSecOptions"] = 0;
$tdatapaginas[".recsPerRowList"] = 1;
$tdatapaginas[".mainTableOwnerID"] = "";
$tdatapaginas[".moveNext"] = 1;
$tdatapaginas[".nType"] = 0;

$tdatapaginas[".strOriginalTableName"] = "paginas";




$tdatapaginas[".showAddInPopup"] = false;

$tdatapaginas[".showEditInPopup"] = false;

$tdatapaginas[".showViewInPopup"] = false;

//page's base css files names
$popupPagesLayoutNames = array();
$tdatapaginas[".popupPagesLayoutNames"] = $popupPagesLayoutNames;


$tdatapaginas[".fieldsForRegister"] = array();

$tdatapaginas[".listAjax"] = false;

	$tdatapaginas[".audit"] = false;

	$tdatapaginas[".locking"] = false;

$tdatapaginas[".edit"] = true;

$tdatapaginas[".list"] = true;

$tdatapaginas[".view"] = true;

$tdatapaginas[".import"] = true;

$tdatapaginas[".exportTo"] = true;

$tdatapaginas[".printFriendly"] = true;

$tdatapaginas[".delete"] = true;

$tdatapaginas[".showSimpleSearchOptions"] = false;

// search Saving settings
$tdatapaginas[".searchSaving"] = false;
//

$tdatapaginas[".showSearchPanel"] = true;
		$tdatapaginas[".flexibleSearch"] = true;		

if (isMobile())
	$tdatapaginas[".isUseAjaxSuggest"] = false;
else 
	$tdatapaginas[".isUseAjaxSuggest"] = true;

$tdatapaginas[".rowHighlite"] = true;



$tdatapaginas[".addPageEvents"] = false;

// use timepicker for search panel
$tdatapaginas[".isUseTimeForSearch"] = false;





$tdatapaginas[".allSearchFields"] = array();
$tdatapaginas[".filterFields"] = array();
$tdatapaginas[".requiredSearchFields"] = array();

$tdatapaginas[".allSearchFields"][] = "idpage";
	$tdatapaginas[".allSearchFields"][] = "titulopage";
	$tdatapaginas[".allSearchFields"][] = "subtitulo";
	$tdatapaginas[".allSearchFields"][] = "datapage";
	$tdatapaginas[".allSearchFields"][] = "conteudo";
	$tdatapaginas[".allSearchFields"][] = "publicado";
	

$tdatapaginas[".googleLikeFields"] = array();
$tdatapaginas[".googleLikeFields"][] = "idpage";
$tdatapaginas[".googleLikeFields"][] = "titulopage";
$tdatapaginas[".googleLikeFields"][] = "datapage";
$tdatapaginas[".googleLikeFields"][] = "conteudo";
$tdatapaginas[".googleLikeFields"][] = "publicado";
$tdatapaginas[".googleLikeFields"][] = "subtitulo";


$tdatapaginas[".advSearchFields"] = array();
$tdatapaginas[".advSearchFields"][] = "idpage";
$tdatapaginas[".advSearchFields"][] = "titulopage";
$tdatapaginas[".advSearchFields"][] = "subtitulo";
$tdatapaginas[".advSearchFields"][] = "datapage";
$tdatapaginas[".advSearchFields"][] = "conteudo";
$tdatapaginas[".advSearchFields"][] = "publicado";

$tdatapaginas[".tableType"] = "list";

$tdatapaginas[".printerPageOrientation"] = 0;
$tdatapaginas[".nPrinterPageScale"] = 100;

$tdatapaginas[".nPrinterSplitRecords"] = 40;

$tdatapaginas[".nPrinterPDFSplitRecords"] = 40;





	





// view page pdf

// print page pdf


$tdatapaginas[".pageSize"] = 20;

$tdatapaginas[".warnLeavingPages"] = true;



$tstrOrderBy = "";
if(strlen($tstrOrderBy) && strtolower(substr($tstrOrderBy,0,8))!="order by")
	$tstrOrderBy = "order by ".$tstrOrderBy;
$tdatapaginas[".strOrderBy"] = $tstrOrderBy;

$tdatapaginas[".orderindexes"] = array();

$tdatapaginas[".sqlHead"] = "SELECT idpage,   titulopage,   datapage,   conteudo,   publicado,   subtitulo";
$tdatapaginas[".sqlFrom"] = "FROM paginas";
$tdatapaginas[".sqlWhereExpr"] = "";
$tdatapaginas[".sqlTail"] = "";




//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdatapaginas[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdatapaginas[".arrGroupsPerPage"] = $arrGPP;

$tdatapaginas[".highlightSearchResults"] = true;

$tableKeyspaginas = array();
$tableKeyspaginas[] = "idpage";
$tdatapaginas[".Keys"] = $tableKeyspaginas;

$tdatapaginas[".listFields"] = array();
$tdatapaginas[".listFields"][] = "idpage";
$tdatapaginas[".listFields"][] = "titulopage";
$tdatapaginas[".listFields"][] = "subtitulo";
$tdatapaginas[".listFields"][] = "datapage";
$tdatapaginas[".listFields"][] = "conteudo";
$tdatapaginas[".listFields"][] = "publicado";

$tdatapaginas[".hideMobileList"] = array();


$tdatapaginas[".viewFields"] = array();
$tdatapaginas[".viewFields"][] = "idpage";
$tdatapaginas[".viewFields"][] = "titulopage";
$tdatapaginas[".viewFields"][] = "subtitulo";
$tdatapaginas[".viewFields"][] = "datapage";
$tdatapaginas[".viewFields"][] = "conteudo";
$tdatapaginas[".viewFields"][] = "publicado";

$tdatapaginas[".addFields"] = array();
$tdatapaginas[".addFields"][] = "titulopage";
$tdatapaginas[".addFields"][] = "subtitulo";
$tdatapaginas[".addFields"][] = "datapage";
$tdatapaginas[".addFields"][] = "conteudo";
$tdatapaginas[".addFields"][] = "publicado";

$tdatapaginas[".inlineAddFields"] = array();

$tdatapaginas[".editFields"] = array();
$tdatapaginas[".editFields"][] = "titulopage";
$tdatapaginas[".editFields"][] = "subtitulo";
$tdatapaginas[".editFields"][] = "datapage";
$tdatapaginas[".editFields"][] = "conteudo";
$tdatapaginas[".editFields"][] = "publicado";

$tdatapaginas[".inlineEditFields"] = array();

$tdatapaginas[".exportFields"] = array();
$tdatapaginas[".exportFields"][] = "idpage";
$tdatapaginas[".exportFields"][] = "titulopage";
$tdatapaginas[".exportFields"][] = "subtitulo";
$tdatapaginas[".exportFields"][] = "datapage";
$tdatapaginas[".exportFields"][] = "conteudo";
$tdatapaginas[".exportFields"][] = "publicado";

$tdatapaginas[".importFields"] = array();
$tdatapaginas[".importFields"][] = "idpage";
$tdatapaginas[".importFields"][] = "titulopage";
$tdatapaginas[".importFields"][] = "datapage";
$tdatapaginas[".importFields"][] = "conteudo";
$tdatapaginas[".importFields"][] = "publicado";
$tdatapaginas[".importFields"][] = "subtitulo";

$tdatapaginas[".printFields"] = array();
$tdatapaginas[".printFields"][] = "idpage";
$tdatapaginas[".printFields"][] = "titulopage";
$tdatapaginas[".printFields"][] = "subtitulo";
$tdatapaginas[".printFields"][] = "datapage";
$tdatapaginas[".printFields"][] = "conteudo";
$tdatapaginas[".printFields"][] = "publicado";

//	idpage
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "idpage";
	$fdata["GoodName"] = "idpage";
	$fdata["ownerTable"] = "paginas";
	$fdata["Label"] = GetFieldLabel("paginas","idpage"); 
	$fdata["FieldType"] = 3;
	
		
		$fdata["AutoInc"] = true;
	
		
				
		$fdata["bListPage"] = true; 
	
		
		
		
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "idpage"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "idpage";
	
		
		
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

	

	
	$tdatapaginas["idpage"] = $fdata;
//	titulopage
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "titulopage";
	$fdata["GoodName"] = "titulopage";
	$fdata["ownerTable"] = "paginas";
	$fdata["Label"] = GetFieldLabel("paginas","titulopage"); 
	$fdata["FieldType"] = 200;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		
		$fdata["bEditPage"] = true; 
	
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "titulopage"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "titulopage";
	
		
		
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

	

	
	$tdatapaginas["titulopage"] = $fdata;
//	datapage
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "datapage";
	$fdata["GoodName"] = "datapage";
	$fdata["ownerTable"] = "paginas";
	$fdata["Label"] = GetFieldLabel("paginas","datapage"); 
	$fdata["FieldType"] = 7;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		
		$fdata["bEditPage"] = true; 
	
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "datapage"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "datapage";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "Short Date");
	
		
		
		
		
		
		
		
		
		
		
		
		$vdata["NeedEncode"] = true;
	
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Date");
	
			
	
	


		
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		$edata["DateEditType"] = 5; 
	$edata["InitialYearFactor"] = 100; 
	$edata["LastYearFactor"] = 10; 
	
		
		
		
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
				$fdata["searchOptionsList"] = array("Equals", "More than", "Less than", "Between");
// the end of search options settings	

	

	
	$tdatapaginas["datapage"] = $fdata;
//	conteudo
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 4;
	$fdata["strName"] = "conteudo";
	$fdata["GoodName"] = "conteudo";
	$fdata["ownerTable"] = "paginas";
	$fdata["Label"] = GetFieldLabel("paginas","conteudo"); 
	$fdata["FieldType"] = 201;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		
		$fdata["bEditPage"] = true; 
	
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "conteudo"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "conteudo";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "HTML");
	
		
		
		
		
		
		
		
		
		
		
		
		
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Text area");
	
			
	
	


		
		$edata["UseRTE"] = true; 
	
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
				$edata["nRows"] = 250;
			$edata["nCols"] = 500;
	
		
		
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

	

	
	$tdatapaginas["conteudo"] = $fdata;
//	publicado
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 5;
	$fdata["strName"] = "publicado";
	$fdata["GoodName"] = "publicado";
	$fdata["ownerTable"] = "paginas";
	$fdata["Label"] = GetFieldLabel("paginas","publicado"); 
	$fdata["FieldType"] = 3;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		
		$fdata["bEditPage"] = true; 
	
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "publicado"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "publicado";
	
		
		
				$fdata["FieldPermissions"] = true;
	
				$fdata["UploadFolder"] = "files";
		
//  Begin View Formats
	$fdata["ViewFormats"] = array();
	
	$vdata = array("ViewFormat" => "Checkbox");
	
		
		
		
		
		
		
		
		
		
		
		
		
	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats 	
	$fdata["EditFormats"] = array();
	
	$edata = array("EditFormat" => "Checkbox");
	
			
	
	


		
		
		
		
			$edata["acceptFileTypes"] = ".+$";
	
		$edata["maxNumberOfFiles"] = 1;
	
		
		
		
		
		
		
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
				$fdata["searchOptionsList"] = array("Equals", "More than", "Less than", "Between");
// the end of search options settings	

	

	
	$tdatapaginas["publicado"] = $fdata;
//	subtitulo
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 6;
	$fdata["strName"] = "subtitulo";
	$fdata["GoodName"] = "subtitulo";
	$fdata["ownerTable"] = "paginas";
	$fdata["Label"] = GetFieldLabel("paginas","subtitulo"); 
	$fdata["FieldType"] = 200;
	
		
		
		
				
		$fdata["bListPage"] = true; 
	
		$fdata["bAddPage"] = true; 
	
		
		$fdata["bEditPage"] = true; 
	
		
		$fdata["bViewPage"] = true; 
	
		$fdata["bAdvancedSearch"] = true; 
	
		$fdata["bPrinterPage"] = true; 
	
		$fdata["bExportPage"] = true; 
	
		$fdata["strField"] = "subtitulo"; 
	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "subtitulo";
	
		
		
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

	

	
	$tdatapaginas["subtitulo"] = $fdata;

	
$tables_data["paginas"]=&$tdatapaginas;
$field_labels["paginas"] = &$fieldLabelspaginas;
$fieldToolTips["paginas"] = &$fieldToolTipspaginas;
$page_titles["paginas"] = &$pageTitlespaginas;

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)
$detailsTablesData["paginas"] = array();
	
// tables which are master tables for current table (detail)
$masterTablesData["paginas"] = array();


// -----------------end  prepare master-details data arrays ------------------------------//

require_once(getabspath("classes/sql.php"));










function createSqlQuery_paginas()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "idpage,   titulopage,   datapage,   conteudo,   publicado,   subtitulo";
$proto0["m_strFrom"] = "FROM paginas";
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
	"m_strName" => "idpage",
	"m_strTable" => "paginas",
	"m_srcTableName" => "paginas"
));

$proto5["m_sql"] = "idpage";
$proto5["m_srcTableName"] = "paginas";
$proto5["m_expr"]=$obj;
$proto5["m_alias"] = "";
$obj = new SQLFieldListItem($proto5);

$proto0["m_fieldlist"][]=$obj;
						$proto7=array();
			$obj = new SQLField(array(
	"m_strName" => "titulopage",
	"m_strTable" => "paginas",
	"m_srcTableName" => "paginas"
));

$proto7["m_sql"] = "titulopage";
$proto7["m_srcTableName"] = "paginas";
$proto7["m_expr"]=$obj;
$proto7["m_alias"] = "";
$obj = new SQLFieldListItem($proto7);

$proto0["m_fieldlist"][]=$obj;
						$proto9=array();
			$obj = new SQLField(array(
	"m_strName" => "datapage",
	"m_strTable" => "paginas",
	"m_srcTableName" => "paginas"
));

$proto9["m_sql"] = "datapage";
$proto9["m_srcTableName"] = "paginas";
$proto9["m_expr"]=$obj;
$proto9["m_alias"] = "";
$obj = new SQLFieldListItem($proto9);

$proto0["m_fieldlist"][]=$obj;
						$proto11=array();
			$obj = new SQLField(array(
	"m_strName" => "conteudo",
	"m_strTable" => "paginas",
	"m_srcTableName" => "paginas"
));

$proto11["m_sql"] = "conteudo";
$proto11["m_srcTableName"] = "paginas";
$proto11["m_expr"]=$obj;
$proto11["m_alias"] = "";
$obj = new SQLFieldListItem($proto11);

$proto0["m_fieldlist"][]=$obj;
						$proto13=array();
			$obj = new SQLField(array(
	"m_strName" => "publicado",
	"m_strTable" => "paginas",
	"m_srcTableName" => "paginas"
));

$proto13["m_sql"] = "publicado";
$proto13["m_srcTableName"] = "paginas";
$proto13["m_expr"]=$obj;
$proto13["m_alias"] = "";
$obj = new SQLFieldListItem($proto13);

$proto0["m_fieldlist"][]=$obj;
						$proto15=array();
			$obj = new SQLField(array(
	"m_strName" => "subtitulo",
	"m_strTable" => "paginas",
	"m_srcTableName" => "paginas"
));

$proto15["m_sql"] = "subtitulo";
$proto15["m_srcTableName"] = "paginas";
$proto15["m_expr"]=$obj;
$proto15["m_alias"] = "";
$obj = new SQLFieldListItem($proto15);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto17=array();
$proto17["m_link"] = "SQLL_MAIN";
			$proto18=array();
$proto18["m_strName"] = "paginas";
$proto18["m_srcTableName"] = "paginas";
$proto18["m_columns"] = array();
$proto18["m_columns"][] = "idpage";
$proto18["m_columns"][] = "titulopage";
$proto18["m_columns"][] = "datapage";
$proto18["m_columns"][] = "conteudo";
$proto18["m_columns"][] = "publicado";
$proto18["m_columns"][] = "subtitulo";
$obj = new SQLTable($proto18);

$proto17["m_table"] = $obj;
$proto17["m_sql"] = "paginas";
$proto17["m_alias"] = "";
$proto17["m_srcTableName"] = "paginas";
$proto19=array();
$proto19["m_sql"] = "";
$proto19["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto19["m_column"]=$obj;
$proto19["m_contained"] = array();
$proto19["m_strCase"] = "";
$proto19["m_havingmode"] = false;
$proto19["m_inBrackets"] = false;
$proto19["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto19);

$proto17["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto17);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="paginas";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_paginas = createSqlQuery_paginas();


	
						
	
$tdatapaginas[".sqlquery"] = $queryData_paginas;

$tableEvents["paginas"] = new eventsBase;
$tdatapaginas[".hasEvents"] = false;

?>