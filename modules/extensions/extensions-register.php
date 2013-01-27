<?php

	session_start();

	include('../../includes/security.php');
	include($_SESSION['BASE_PATH'].'includes/db.php');
	
	// Se idRamal não existir ou igual a zero, é pq é cadastro.
	$idRamal = (isset($_REQUEST['idRamal'])) ? $_REQUEST['idRamal'] : 0;
	
	if (isset($_POST['cadastroName'])) {

		$cadastroName = trim(mysql_escape_string($_POST['cadastroName']));
		$cadastroHittype = trim(mysql_escape_string($_POST['cadastroHittype']));
		$cadastroNome = trim(mysql_escape_string($_POST['cadastroNome']));
		$cadastroEmail = trim(mysql_escape_string($_POST['cadastroEmail']));
		$cadastroSecret = trim(mysql_escape_string($_POST['cadastroSecret']));
		$cadastroSecretVM = trim(mysql_escape_string($_POST['cadastroSecretVM']));
		$cadastroExcluiVoicemail = trim(mysql_escape_string($_POST['cadastroExcluiVoicemail']));
		$cadastroGrupo = trim(mysql_escape_string($_POST['cadastroGrupo']));
		$cadastroTipo = trim(mysql_escape_string($_POST['cadastroTipo']));
		$cadastroHitport = trim(mysql_escape_string($_POST['cadastroHitport']));
		$cadastroRA = trim(mysql_escape_string($_POST['cadastroRA']));
		$cadastroLF = trim(mysql_escape_string($_POST['cadastroLF']));
		$cadastroLC = trim(mysql_escape_string($_POST['cadastroLC']));
		$cadastroDF = trim(mysql_escape_string($_POST['cadastroDF']));
		$cadastroDC = trim(mysql_escape_string($_POST['cadastroDC']));
		$cadastroDI = trim(mysql_escape_string($_POST['cadastroDI']));
	
	} else if ($idRamal > 0) {

		$sql = "SELECT tab_sipuser.id,";
		$sql.= "tab_sipuser.name,";
		$sql.= "tab_sipuser.nome,";
		$sql.= "tab_sipuser.email,";
		$sql.= "tab_sipuser.allowed,";
		$sql.= "tab_sipuser.ipaddr,";
		$sql.= "tab_sipuser.hittype,";
		$sql.= "tab_sipuser.nat,";
		$sql.= "tab_sipuser.hitport,";
		$sql.= "tab_sipuser.callgroup, ";
		$sql.= "tab_voicemail.delete as vmDelete ";
		$sql.= "FROM tab_sipuser ";
		//$sql.= "LEFT JOIN tab_group ON tab_sipuser.callgroup=tab_group.id ";
		$sql.= "LEFT JOIN tab_voicemail ON tab_sipuser.name=tab_voicemail.customer_id ";
		$sql.= "WHERE tab_sipuser.id = ".$idRamal;
		$resultRamal = mysql_query($sql) or die($sql."<br /><br />s".mysql_error());

		$cadastroName = mysql_result($resultRamal,0,'name');
		$cadastroHittype = mysql_result($resultRamal,0,'hittype');
		$cadastroNome = mysql_result($resultRamal,0,'nome');
		$cadastroEmail = mysql_result($resultRamal,0,'email');
		$cadastroSecret = "";
		$cadastroSecretVM = "";
		$cadastroExcluiVoicemail = mysql_result($resultRamal,0,'vmDelete');
		$cadastroGrupo = mysql_result($resultRamal,0,'callgroup');
		$cadastroTipo = (mysql_result($resultRamal,0,'nat') == 'no') ? '1' : '2';
		$cadastroHitport = mysql_result($resultRamal,0,'hitport');
		$allowed = mysql_result($resultRamal,0,'allowed');

		$cadastroRA = (strpos($allowed,'RA')!==false) ? 'RA' : '';
		$cadastroLF = (strpos($allowed,'LF')!==false) ? 'LF' : '';
		$cadastroLC = (strpos($allowed,'LC')!==false) ? 'LC' : '';
		$cadastroDF = (strpos($allowed,'DF')!==false) ? 'DF' : '';
		$cadastroDC = (strpos($allowed,'DC')!==false) ? 'DC' : '';
		$cadastroDI = (strpos($allowed,'DI')!==false) ? 'DI' : '';
		unset($allowed);

	} else {

		$cadastroName = "";
		$cadastroHittype = "";
		$cadastroNome = "";
		$cadastroEmail = "";
		$cadastroSecret = "";
		$cadastroSecretVM = "";
		$cadastroExcluiVoicemail = "";
		$cadastroGrupo = "";
		$cadastroTipo = "";
		$cadastroHitport = "";
		$cadastroRA = "";
		$cadastroLF = "";
		$cadastroLC = "";
		$cadastroDF = "";
		$cadastroDC = "";
		$cadastroDI = "";
	
	}
	
	if (isset($_POST['submitSalvar'])) {
					
		$name = $cadastroName;
		$nome = $cadastroNome;
		$callgroup = $cadastroGrupo;
		$pickupgroup = $cadastroGrupo;
		$callerid = $cadastroName;
		$context = 'padrao';
		$secret = $cadastroSecret;
		$email = $cadastroEmail;
		$mailbox = $cadastroName;
		$hittype = $cadastroHittype;
		$hitport = $cadastroHitport;
		$hitassoc = ($hitport>0) ? 'S' : 'N';
		$vContexto = $cadastroRA.$cadastroLF.$cadastroLC.$cadastroDF.$cadastroDC.$cadastroDI;
		$allowed = $vContexto;
		$vAllow = $cadastroTipo;
		$allow = $vAllow;
		$extentype = $vAllow;
		if ( $extentype == '1' ){
		   $allow = 'ulaw;alaw;gsm';
		   $nat = 'no';
	 	} elseif ( $extentype == '2' ){
	 	   $allow = 'g729;ulaw';
	 	   $nat = 'yes';
		}		
		$vDelVM = ($cadastroExcluiVoicemail == 'yes') ? 'yes' : 'no';
		
		$VMcustomer_id = $name;
		$VMdelete = $vDelVM;
		$VMmailbox = $name;
		$VMpassword = $cadastroSecretVM;
		$VMfullname = $nome;
		$VMemail = $email;
		
		if (!empty($name)) {
		
			$sql = "SELECT * FROM tab_sipuser WHERE name = '".$name."' AND id != '".$idRamal."'";
			$resultSipuser = mysql_query($sql) or die(mysql_error().'---'.$sql);
			
			if (mysql_num_rows($resultSipuser) < 1) {
			
				if ($idRamal < 1) {
				
					// Cadastro
				
					$sql = "INSERT INTO tab_sipuser SET ";
					$sql.= "name = '".$name."', ";
					$sql.= "nome = '".$nome."', ";
					$sql.= "callgroup = '".$callgroup."', ";
					$sql.= "context = 'padrao', ";
					$sql.= "secret = '".$secret."', ";
					$sql.= "email = '".$email."', ";
					$sql.= "mailbox = '".$mailbox."', ";
					$sql.= "allowed = '".$allowed."', ";
					$sql.= "extentype = '".$extentype."', ";
					$sql.= "hittype = '".$hittype."', ";
					$sql.= "hitassoc = '".$hitassoc."', ";
					$sql.= "hitport = '".$hitport."', ";
					$sql.= "allow = '".$allow."', ";
					$sql.= "nat = '".$nat."'";
					mysql_query($sql) or die(mysql_error().'---'.$sql);
					
					exec("php atualiza.php");
					exec("php criatdm.php");
					
					$sql = "INSERT INTO tab_cadeado SET ramal = '".$name."', senha = '1234'";
					mysql_query($sql) or die(mysql_error().'---'.$sql);
					exec("sudo asterisk -rx \"sip prune realtime $name\"");
					exec("sudo asterisk -rx \"module reload chan_dahdi.so\"");
					
					/*
					$sql = "INSERT INTO tab_voicemail SET ";
					$sql.= "uniqueid = '0', ";
					$sql.= "customer_id = '".$VMcustomer_id."', ";
					$sql.= "context = 'default', ";
					$sql.= "delete = '".$delete."', ";
					$sql.= "mailbox = '".$mailbox."', ";
					$sql.= "password = '".$password."', ";
					$sql.= "fullname = '".$fullname."', ";
					$sql.= "email = '".$email."'";
					*/
					$sql = "INSERT INTO tab_voicemail ";
					$sql.= "(`customer_id`,`context`,`delete`,`mailbox`,`password`,`fullname`,`email`) ";
					$sql.= "VALUES ('".$VMcustomer_id."','default','".$VMdelete."','".$VMmailbox."','".$VMpassword."','".$VMfullname."','".$VMemail."')";
					mysql_query($sql) or die($sql);
					
					$sql = "INSERT INTO tab_sigame SET ";
					$sql.= "ramal = '".$name."' ";
					$sql.= "id = '0'";
					
					$msgPopup = 'Cadastro efetuado';
				
				} else {
				
					// Edição
					
					$sql = "SELECT tab_sipuser.name FROM tab_sipuser WHERE id = '".$idRamal."';";
					$result = mysql_query($sql) or die($sql."<br />".mysql_error());
					$nameAtual = mysql_result($result,0,'name');
				
					$sql = "UPDATE tab_sipuser SET ";
					$sql.= "name = '".$name."', ";
					$sql.= "nome = '".$nome."', ";
					$sql.= "callgroup = '".$callgroup."', ";
					$sql.= "context = 'padrao', ";
					if (!empty($secret)) { $sql.= "secret = '".$secret."', "; }
					$sql.= "email = '".$email."', ";
					$sql.= "mailbox = '".$mailbox."', ";
					$sql.= "allowed = '".$allowed."', ";
					$sql.= "extentype = '".$extentype."', ";
					$sql.= "hittype = '".$hittype."', ";
					$sql.= "hitassoc = '".$hitassoc."', ";
					$sql.= "hitport = '".$hitport."', ";
					$sql.= "allow = '".$allow."', ";
					$sql.= "nat = '".$nat."' ";
					$sql.= "WHERE id = '".$idRamal."'";
					mysql_query($sql) or die($sql."<br />".mysql_error());
					
					require_once("php atualiza.php");
					require_once("php criatdm.php");
					
					if (!empty($cadastroSecret)) { 
						$sql = "UPDATE tab_cadeado SET ramal = '".$name."', senha = '".$cadastroSecret."' WHERE name = '".$nameAtual."'";
					} else {
						$sql = "UPDATE tab_cadeado SET ramal = '".$name."' WHERE name = '".$nameAtual."'";
					}
					mysql_query($sql) or die(mysql_error().'---'.$sql);
					exec("sudo asterisk -rx \"sip prune realtime $name\"");
					exec("sudo asterisk -rx \"module reload chan_dahdi.so\"");
					
					if (!empty($VMpassword)) {
					
						$sql = "UPDATE tab_voicemail ";
						$sql.= "(`customer_id`,`context`,`delete`,`mailbox`,`password`,`fullname`,`email`) ";
						$sql.= "VALUES ('".$VMcustomer_id."','default','".$VMdelete."','".$VMmailbox."','".$VMpassword."','".$VMfullname."','".$VMemail."') ";
						$sql.= "WHERE customer_id = '".$nameAtual."'";
						mysql_query($sql) or die($sql);
					
					} else {
					
						$sql = "UPDATE tab_voicemail ";
						$sql.= "(`customer_id`,`context`,`delete`,`mailbox`,`fullname`,`email`) ";
						$sql.= "VALUES ('".$VMcustomer_id."','default','".$VMdelete."','".$VMmailbox."','".$VMfullname."','".$VMemail."') ";
						$sql.= "WHERE customer_id = '".$nameAtual."'";
						mysql_query($sql) or die($sql);
					
					}
					
					$sql = "UPDATE tab_sigame SET ";
					$sql.= "ramal = '".$name."' ";
					$sql.= "WHERE ramal = '".$nameAtual."'";
					
					$msgPopup = 'Cadastro alterado.';
				
				}
				
			} else {

				$msgPopup = 'Numero de ramal j&aacute; cadastrado!';				
				
			}
		
		} else {
			
			$msgPopup = 'Dados incompletos!';
				
		}
		
	}
	
	$sql = "SELECT * FROM tab_group ORDER BY grupo";
	$resultGrupos = mysql_query($sql) or die(mysql_error().'---'.$sql);
	
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

	<?php include($_SESSION['BASE_PATH'].'includes/head.php'); ?>
	
    <script>
		$(document).ready(function(e) {
            <?php
				if (isset($msgPopup)) {
					echo "
						$('#msgPopup').html('".$msgPopup."');
						$('#modalMsgPopup').modal();
						/*
						$('#modalMsgPopup').on('hidden', function () {
							$(window.document.location).attr('href','extensions-list.php');
						})
						$('#btnNovoCadastro').click(function(e){
							$(window.document.location).attr('href','extensions-register.php');
						});
						*/
					";
				}
			?>
        });
	</script>

</head>

<body>
    
    <?php include($_SESSION['BASE_PATH'].'includes/menu.php'); ?>
	
    <div class="container">
	
		<br />

        <form id="formCadastroRamal" class="form-horizontal" method="post">
		
			<input name="idRamal" type="hidden" value="<?php echo $idRamal; ?>" />
		
        	<div class="row">
            	<div class="span6">
					<div class="control-group">
						<label class="control-label">N&uacute;mero do ramal</label>
						<div class="controls">
							<input name="cadastroName" type="text" class="input-medium" value="<?php echo $cadastroName; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Tipo do ramal</label>
						<div class="controls">
							<select name="cadastroHittype" class="input-medium">
								<?php $selected = ($cadastroHittype == "SIP") ? 'selected' : ''; ?>
								<option value="SIP" <?php echo $selected; ?>>SIP</option>
								<?php $selected = ($cadastroHittype == "TDM") ? 'selected' : ''; ?>
								<option value="TDM" <?php echo $selected; ?>>TDM</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Nome do usu&aacute;rio</label>
						<div class="controls">
							<input name="cadastroNome" type="text" class="input-medium" value="<?php echo $cadastroNome; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input name="cadastroEmail" type="text" class="input-medium" value="<?php echo $cadastroEmail; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Senha do ramal</label>
						<div class="controls">
							<input name="cadastroSecret" type="text" class="input-medium" value="<?php echo $cadastroSecret; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Senha do voicemail</label>
						<div class="controls">
							<input name="cadastroSecretVM" type="text" class="input-medium" value="<?php echo $cadastroSecretVM; ?>">
							<label class="checkbox">
								<?php $checked = ($cadastroExcluiVoicemail == 'yes') ? 'checked' : ''; ?>
								<input name="cadastroExcluiVoicemail" type="checkbox" value="yes" <?php echo $checked; ?>>Excluir voicemail ap&oacute;s envio por email
							</label>
						</div>
					</div>
            	</div>
                <div class="span6">
					<div class="control-group">
						<label class="control-label">Grupo</label>
						<div class="controls">
							<select name="cadastroGrupo" class="input-medium">
							<?php
								while ($resultGruposLinha = mysql_fetch_array($resultGrupos)) {
									$selected = ($cadastroGrupo == $resultGruposLinha['id']) ? 'selected' : '';
									echo '
										<option value="'.$resultGruposLinha['id'].'" '.$selected.'>'.$resultGruposLinha['grupo'].'</option>
									';
								}
							?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">O ramal ser&aacute;</label>
						<div class="controls">
							<select name="cadastroTipo" class="input-medium">
								<?php $selected = ($cadastroTipo == "1") ? 'selected' : ''; ?>
								<option value="1" <?php echo $selected; ?>>Interno</option>
								<?php $selected = ($cadastroTipo == "2") ? 'selected' : ''; ?>
								<option value="2" <?php echo $selected; ?>>Externo</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Porta fisica (caso tenha)</label>
						<div class="controls">
							<input name="cadastroHitport" type="text" class="input-medium" value="<?php echo $cadastroHitport; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Permiss&otilde;es</label>
						<div class="controls">
							<label class="checkbox">
								<?php $checked = ($cadastroRA == 'RA') ? 'checked' : ''; ?>
								<input name="cadastroRA" type="checkbox" value="RA" <?php echo $checked ?>>Ramal
							</label>
							<label class="checkbox">
								<?php $checked = ($cadastroLF == 'LF') ? 'checked' : ''; ?>
								<input name="cadastroLF" type="checkbox" value="LF" <?php echo $checked ?>>Local fixo
							</label>
							<label class="checkbox">
								<?php $checked = ($cadastroLC == 'LC') ? 'checked' : ''; ?>
								<input name="cadastroLC" type="checkbox" value="LC" <?php echo $checked ?>>Local celular
							</label>
							<label class="checkbox">
								<?php $checked = ($cadastroDF == 'DF') ? 'checked' : ''; ?>
								<input name="cadastroDF" type="checkbox" value="DF" <?php echo $checked ?>>DDD fixo
							</label>
							<label class="checkbox">
								<?php $checked = ($cadastroDC == 'DC') ? 'checked' : ''; ?>
								<input name="cadastroDC" type="checkbox" value="DC" <?php echo $checked ?>>DDD celular
							</label>
							<label class="checkbox">
								<?php $checked = ($cadastroDI == 'DI') ? 'checked' : ''; ?>
								<input name="cadastroDI" type="checkbox" value="DI" <?php echo $checked ?>>DDI
							</label>
						</div>
					</div>
            	</div>
            </div>
            <div class="form-actions">
	            <button name="submitSalvar" type="submit" class="btn btn-primary pull-right">Salvar</button>
            </div>
        </form>
        
        <div class="modal hide" id="modalMsgPopup">
	        <div class="modal-header">
    		    <button type="button" class="close" data-dismiss="modal">×</button>
        		<h3>Informativo</h3>
	        </div>
	        <div class="modal-body">
    	    	<p id="msgPopup"></p>
        	</div>
	        <div class="modal-footer">
            	<div class="btn-group pull-right">
    	        	<!--<a id="btnNovoCadastro" href="#" class="btn">Novo cadastro</a>-->
		    	    <a href="#" class="btn btn-info" data-dismiss="modal">Fechar</a>
                </div>
	        </div>
        </div>
		
	</div>

</body>
</html>