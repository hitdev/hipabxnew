<?php
	$dbservidor = 'localhost';
	$dbusuario = 'root';	// Write the password in HIT Manager only.
	$dbsenha = '';
	$dbnome = 'hitpbx';
	$db = mysql_connect($dbservidor,$dbusuario,$dbsenha) or die(mysql_error());
	mysql_select_db($dbnome, $db);
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
?>