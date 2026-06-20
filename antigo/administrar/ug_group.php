<?php
@ini_set("display_errors","1");
@ini_set("display_startup_errors","1");

require_once("include/dbcommon.php");
header("Expires: Thu, 01 Jan 1970 00:00:01 GMT"); 


if(!isLogged())
{ 
	return;
}
if(!IsAdmin())
{
	return;
}
$nonAdminTablesArr = array();
$nonAdminTablesArr[] = "admin";
$nonAdminTablesArr[] = "paginas";
$nonAdminTablesArr[] = "configuracoes";
$nonAdminTablesArr[] = "clientes";
$nonAdminTablesArr[] = "Painel";

$grConnection = $cman->getDefault();
$rConnection = $cman->byTable("admin_rights");
$mConnection = $cman->byTable("admin_members");

$cbxNames = array('add' => array('mask' => 'A', 'rightName' => 'add')
	, 'edt' => array('mask' => 'E', 'rightName' => 'edit')
	, 'del' => array('mask' => 'D', 'rightName' => 'delete')
	, 'lst' => array('mask' => 'S', 'rightName' => 'list')
	, 'exp' => array('mask' => 'P', 'rightName' => 'export')
	, 'imp' => array('mask' => 'I', 'rightName' => 'import')
	, 'adm' => array('mask' => 'M'));

$wGroupTableName = $grConnection->addTableWrappers( "locutoracom_uggroups" );
	
switch(postvalue("a"))
{
	case "add":
		$sql = "insert into ". $wGroupTableName ." (". $grConnection->addFieldWrappers( "Label" ) .")"
			." values (". $grConnection->prepareString( postvalue("name") ). ")";		
		$grConnection->exec( $sql );

		$sql = "select max(". $grConnection->addFieldWrappers( "GroupID") .") from ". $wGroupTableName;
		$data = $grConnection->query( $sql )->fetchNumeric();
		
		echo printJSON( array('success' => true, 'id' => $data[0]) );
		break;
		
	case "del":
		$sql = "delete from ". $wGroupTableName ." where ". $grConnection->addFieldWrappers("GroupID") ."=".(postvalue("id")+0);
		$grConnection->exec( $sql );
		
		$sql = "delete from ". $rConnection->addTableWrappers( "locutoracom_ugrights" ) 
			." where ". $rConnection->addFieldWrappers( "GroupID" ) ."=".(postvalue("id")+0);
		$rConnection->exec( $sql );
		
		$sql = "delete from ".$mConnection->addTableWrappers( "locutoracom_ugmembers" ) 
			." where ". $mConnection->addFieldWrappers( "GroupID" ) ."=".(postvalue("id")+0);
		$mConnection->exec( $sql );
		
		echo printJSON( array('success' => true) );
		break;
		
	case "rename":
		$sql = "update ". $wGroupTableName  
			." set ". $grConnection->addFieldWrappers( "Label" ) ."=". $grConnection->prepareString( postvalue("name") )
			." where ". $grConnection->addFieldWrappers( "GroupID" ) ."=".(postvalue("id")+0);
		$grConnection->exec( $sql );
		
		echo printJSON( array('success' => true) );
		break;
	
	case 'saveRights':
		$error = '';
		if( postvalue('state') )
		{	
			$allRights = array();
			$sql = "select ". $grConnection->addFieldWrappers( "GroupID" ) 
				.", ". $grConnection->addFieldWrappers( "TableName" ) 
				.", ". $grConnection->addFieldWrappers( "AccessMask" ) ." from ". $wGroupTableName;
			
			$qResult = $grConnection->query( $sql );
			// don't use fetchAssoc! because of ORACLE and PostgreSQL
			while( $rightsRow = $qResult->fetchNumeric() )
			{
				$allRights[] = $rightsRow;
			}
			
			$wRightsTableName = $rConnection->addTableWrappers( "locutoracom_ugrights" );
			
			$delGroupId = 0;
			$state = my_json_decode( postvalue('state') );
			// delete all extra permissions from db
			foreach($allRights as $i => $rightValue)
			{
				$groupIDInt = (int) $rightValue[0];
				
				if($groupIDInt == $delGroupId)
					continue;
					
				//delete all extra permissions for group
				if( !array_key_exists($groupIDInt, $state) )
				{
					$sql = "delete from ". $wRightsTableName 
						." where ". $rConnection->addFieldWrappers( "GroupID" ) ."=". $groupIDInt;
					$rConnection->exec( $sql );
				}
				//delete all extra permissions for table in group
				else if(!array_key_exists(GetTableId($data[1]), $state[$groupIDInt]))
				{
					$sql = "delete from ". $wRightsTableName 
						." where ". $rConnection->addFieldWrappers( "GroupID" ) ."=". $groupIDInt 
						." and ". $rConnection->addFieldWrappers( "TableName" ) ."=".$rConnection->prepareString( html_special_decode($data[1]) );				
					$rConnection->exec( $sql );
				}
			}
			
			$realTables = GetRealValues();
			foreach ($state as $groupId => $groupRights)
			{
				foreach ($groupRights as $table => $mask)
				{
					if( !array_key_exists($table, $realTables) )
						continue;
					
					$ins = true;
					foreach($allRights as $i => $rightValue)
					{	
						if($rightValue[0] == $groupId && $rightValue[1] == $realTables[$table])	
						{
							$ins = false;
							if($data[2]!= $mask)
							{
								$sql ="update". $wRightsTableName 
									." set ". $rConnection->addFieldWrappers( "AccessMask" ) ."=". $rConnection->prepareString( $mask )
									." where ". $rConnection->addFieldWrappers( "GroupID" ) ."=". $groupId 
									." and ". $rConnection->addFieldWrappers( "TableName" ) ."=". $rConnection->prepareString( html_special_decode($realTables[$table]) );
								$rConnection->exec( $sql );
							}
						}
					}
					if($ins)
					{
						$sql = "insert into ". $wRightsTableName
							." (". $rConnection->addFieldWrappers( "TableName" ) 
							.", ". $rConnection->addFieldWrappers( "GroupID" ) 
							.", ". $rConnection->addFieldWrappers( "AccessMask" ) .") " 
							."values (". $rConnection->prepareString(html_special_decode($realTables[$table])) .", ". $groupId .", ". $rConnection->prepareString($mask)  .")";
						$rConnection->exec( $sql );
					}
					
					$rError = $rConnection->lastError();
					$grError = $grConnection->lastError();
					if( $rError != '' || $grError != '' )
						$error.= ($error == '' ? '' : ' ').$rError.' '.$grError;
				}
			}
		}
		
		getJSONResult($error);
		break;
		
	case 'saveMembership':
		$error = '';
		$groupId = postvalue('group');
		$realUsers = GetRealValues();
		
		$wMemebersTableName = $mConnection->addTableWrappers( "locutoracom_ugmembers" );
		
		for($i = 0; $i < count($realUsers); $i++)
		{
			if( $realUsers[$i] != $_SESSION["UserID"] )
			{
				$sql = "delete from ". $wMemebersTableName ." where ". $mConnection->addFieldWrappers( "UserName" )."=%s";
			}
			else
			{
				$sql = "delete from ". $wMemebersTableName ." where ". $mConnection->addFieldWrappers( "UserName" ) ."=%s "
					."and ". $mConnection->addFieldWrappers( "GroupID" ) ."<>-1";
			}
			
			$mConnection->exec( mysprintf($sql, array( $mConnection->prepareString( html_special_decode($realUsers[$i]) ) )) );	
		}
		
		if(postvalue('state'))
		{
			$state = my_json_decode( postvalue('state') );
			foreach ($state as $group => $users)
			{
				foreach ($users as $user)
				{
					if( !array_key_exists($user, $realUsers) )
						continue;
					
					$sql = "insert into ". $wMemebersTableName 
						." (". $mConnection->addFieldWrappers( "UserName" ) 
						.", ". $mConnection->addFieldWrappers( "GroupID" ) 
						.") values (". $mConnection->prepareString( html_special_decode($realUsers[$user]) ) .", ". $group .")";
					
					$mConnection->exec( $sql );
					
					$mError = $mConnection->lastError();
					if( $mError != '' )
						$error.= $mError;
				}
			}
		}
		
		getJSONResult($error);
		break;
}

function GetTableId($name)
{
	$tbls = GetRealValues();
	for($i = 0;$i < count($tbls); $i++)
	{
		if($tbls[$i] == $name)
			return $i;
	}
	return -1;
}

/**
 * GetRealValues
 * Form array with real users or tables names
 * @return {array} array of reaf names
 */
function GetRealValues()
{
	$result = array();
	if(postvalue('realValues'))
		$realValues = my_json_decode(postvalue('realValues'));
		foreach ($realValues as $key =>$value)
			$result[$key] = $value;
	return $result;
}

/**
 * getJSONResult
 * Form result as a JSON object according of errors
 * @param {string} list of errors
 */
function getJSONResult($error)
{
	$result['success'] = $error == '';
	$result['error'] = $error;	
	echo printJSON($result);
}