<?php

	session_start();
	include('../../includes/security.php');
	
	if (isset($_POST['id'])) {
		
		include($_SESSION['BASE_PATH'].'includes/db.php');
		
		$id = trim(mysql_escape_string(($_POST['id'])));
		
		$sql = "SELECT name FROM tab_sipuser WHERE id = '".$id."' LIMIT 1";
		$result = mysql_query($sql);
		$ramal = mysql_result($result,0,'name');
		
		$sql = "DELETE FROM tab_cadeado WHERE ramal = '".$ramal."'";
		$result = mysql_query($sql);
		
		$sql = "DELETE FROM tab_voicemail WHERE customer_id = '".$ramal."'";
		$result = mysql_query($sql);
		
		$sql = "DELETE FROM tab_sigame WHERE ramal = '".$ramal."'";
		$result = mysql_query($sql);
		
		$sql = "DELETE FROM tab_sipuser WHERE id = '".$id."'";
		$result = mysql_query($sql);

        exec("php atualiza.php");
		exec("php criatdm.php");
		exec('sudo asterisk -rx "sip prune realtime peer '.$ramal.'"');
		exec('sudo asterisk -rx "module reload chan_dahdi.so"');
		
		$ajaxRetorno['statusRetorno'] = 'ok';
		
	}
	
	echo json_encode($ajaxRetorno);
	
?>