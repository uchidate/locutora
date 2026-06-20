<?php
$dalTableclientes = array();
$dalTableclientes["idcli"] = array("type"=>3,"varname"=>"idcli");
$dalTableclientes["nomeCliente"] = array("type"=>200,"varname"=>"nomeCliente");
$dalTableclientes["foto"] = array("type"=>201,"varname"=>"foto");
	$dalTableclientes["idcli"]["key"]=true;
$dal_info["clientes"]=&$dalTableclientes;

?>