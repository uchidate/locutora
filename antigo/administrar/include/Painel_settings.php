<?php
require_once(getabspath("classes/cipherer.php"));



$tdataPainel = array();	
$tdataPainel[".ShortName"] = "Painel";

//	field labels
$fieldLabelsPainel = array();
$pageTitlesPainel = array();

if(mlang_getcurrentlang()=="Portuguese(Brazil)")
{
	$fieldLabelsPainel["Portuguese(Brazil)"] = array();
	$fieldLabelsPainel["Portuguese(Brazil)"]["clientes_idcli"] = "Idcli";
	$fieldLabelsPainel["Portuguese(Brazil)"]["clientes_nomeCliente"] = "Nome Cliente";
	$fieldLabelsPainel["Portuguese(Brazil)"]["clientes_foto"] = "Foto";
}
if(mlang_getcurrentlang()=="")
{
	$fieldLabelsPainel[""] = array();
}

//	search fields
$tdataPainel[".searchFields"] = array();
$dashField = array();
$dashField[] = array( "table"=>"clientes", "field"=>"idcli" );
$tdataPainel[".searchFields"]["clientes_idcli"] = $dashField;
$dashField = array();
$dashField[] = array( "table"=>"clientes", "field"=>"nomeCliente" );
$tdataPainel[".searchFields"]["clientes_nomeCliente"] = $dashField;
$dashField = array();
$dashField[] = array( "table"=>"clientes", "field"=>"foto" );
$tdataPainel[".searchFields"]["clientes_foto"] = $dashField;

// all search fields
$tdataPainel[".allSearchFields"] = array();
$tdataPainel[".allSearchFields"][] = "clientes_idcli";
$tdataPainel[".allSearchFields"][] = "clientes_nomeCliente";
$tdataPainel[".allSearchFields"][] = "clientes_foto";

// good like search fields
$tdataPainel[".googleLikeFields"] = array();
$tdataPainel[".googleLikeFields"][] = "clientes_idcli";
$tdataPainel[".googleLikeFields"][] = "clientes_nomeCliente";
$tdataPainel[".googleLikeFields"][] = "clientes_foto";

$tdataPainel[".dashElements"] = array();

	$dbelement = array( "elementName" => "clientes_list", "table" => "clientes", "type" => 0);
	$dbelement["cellName"] = "cell_0_0";
	
			$dbelement["inlineAdd"] = 0 > 0;
	$dbelement["inlineEdit"] = 0 > 0;
	$dbelement["deleteRecord"] = 0 > 0;
	
	$dbelement["popupAdd"] = 0 > 0;	
	$dbelement["popupEdit"] = 0 > 0;	
	$dbelement["popupView"] = 0 > 0;	
	$tdataPainel[".dashElements"][] = $dbelement;
	$dbelement = array( "elementName" => "configuracoes_list", "table" => "configuracoes", "type" => 0);
	$dbelement["cellName"] = "cell_1_0";
	
			$dbelement["inlineAdd"] = 0 > 0;
	$dbelement["inlineEdit"] = 0 > 0;
	$dbelement["deleteRecord"] = 0 > 0;
	
	$dbelement["popupAdd"] = 0 > 0;	
	$dbelement["popupEdit"] = 0 > 0;	
	$dbelement["popupView"] = 0 > 0;	
	$tdataPainel[".dashElements"][] = $dbelement;
	$dbelement = array( "elementName" => "paginas_list", "table" => "paginas", "type" => 0);
	$dbelement["cellName"] = "cell_1_1";
	
			$dbelement["inlineAdd"] = 0 > 0;
	$dbelement["inlineEdit"] = 0 > 0;
	$dbelement["deleteRecord"] = 0 > 0;
	
	$dbelement["popupAdd"] = 0 > 0;	
	$dbelement["popupEdit"] = 0 > 0;	
	$dbelement["popupView"] = 0 > 0;	
	$tdataPainel[".dashElements"][] = $dbelement;

$tdataPainel[".shortTableName"] = "Painel";
$tdataPainel[".nType"] = 4;


$tableEvents["Painel"] = new eventsBase;
$tdataPainel[".hasEvents"] = false;


$tdataPainel[".tableType"] = "dashboard";



$tdataPainel[".addPageEvents"] = false;

$tables_data["Painel"]=&$tdataPainel;
$field_labels["Painel"] = &$fieldLabelsPainel;
$page_titles["Painel"] = &$pageTitlesPainel;

?>