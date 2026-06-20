<?php
$dalTableadmin = array();
$dalTableadmin["idadm"] = array("type"=>3,"varname"=>"idadm");
$dalTableadmin["nome"] = array("type"=>200,"varname"=>"nome");
$dalTableadmin["email"] = array("type"=>200,"varname"=>"email");
$dalTableadmin["senha"] = array("type"=>200,"varname"=>"senha");
	$dalTableadmin["idadm"]["key"]=true;
$dal_info["admin"]=&$dalTableadmin;

?>