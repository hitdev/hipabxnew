<?php

	session_start();
	
	include('../../includes/security.php');
	include($_SESSION['BASE_PATH'].'includes/db.php');
	
	if (isset($_POST['filtroTexto'])) {
		$filtroCampo = trim(mysql_escape_string($_POST['filtroCampo']));
		$filtroTexto = trim(mysql_escape_string($_POST['filtroTexto']));
		$filtro = (!empty($filtroTexto)) ? " WHERE ".$filtroCampo." LIKE '%".$filtroTexto."%'" : '';
	} else { $filtro = ''; }
	if (isset($_POST['orderByCampo'])) {
		$orderByCampo = trim(mysql_escape_string($_POST['orderByCampo']));
		$ramalOrderBy = (!empty($orderByCampo)) ? ' ORDER BY '.$orderByCampo : '';
	} else { $ramalOrderBy = ' ORDER BY name'; }
	$sql = "SELECT tab_sipuser.id,tab_sipuser.name,tab_sipuser.nome,tab_sipuser.email,tab_sipuser.allowed,tab_sipuser.ipaddr,tab_sipuser.hittype,(tab_group.grupo) as grupo FROM tab_sipuser LEFT JOIN tab_group ON tab_sipuser.callgroup=tab_group.id".$filtro.$ramalOrderBy;
	$resultRamais = mysql_query($sql) or die(mysql_error());
	
	$sql = "SELECT * FROM tab_group ORDER BY grupo";
	$resultGrupos = mysql_query($sql) or die(mysql_error);
	
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

	<?php include($_SESSION['BASE_PATH'].'includes/head.php'); ?>
	
    <script>
		var idExcluir;
		function btnExcluiRamal(id,name) {
			idExcluir = id;
			var texto = 'Deseja realmente excluir o ramal '+String(name)+'?';
			$('#modalConfirmaExcluir .modal-body p').html(texto);
			$('#modalConfirmaExcluir').modal();
		};
		$(document).ready(function(e) {
            $('th > a').css('display','block');
			$('#aTipo').click(function(e) {
                $('#orderByCampo').attr('value','hittype');
				$('#formFiltro').submit();
            });
			$('#aRamal').click(function(e) {
                $('#orderByCampo').attr('value','name');
				$('#formFiltro').submit();
            });
			$('#aNome').click(function(e) {
                $('#orderByCampo').attr('value','nome');
				$('#formFiltro').submit();
            });
			$('#aEmail').click(function(e) {
                $('#orderByCampo').attr('value','email');
				$('#formFiltro').submit();
            });
			$('#aGrupo').click(function(e) {
                $('#orderByCampo').attr('value','grupo');
				$('#formFiltro').submit();
            });
			$('#aIP').click(function(e) {
                $('#orderByCampo').attr('value','ipaddr');
				$('#formFiltro').submit();
            });
			$("#btnConfirmaExcluir").click(function(e) {

				$.post("extensions-list-ajax.php", {id:idExcluir},
					function(data){
						$(window.document.location).attr("href","extensions-list.php");
					}, "json"
				);

            });
        });
	</script>

</head>

<body>

	<?php include($_SESSION['BASE_PATH'].'includes/menu.php'); ?>
	
    <div class="container">
		<!-- InstanceBeginEditable name="EditRegionConteudo" -->
        <form id="formFiltro" class="form-inline well" method="post">
        	<input id="orderByCampo" name="orderByCampo" type="hidden" value="<?php echo $orderByCampo; ?>" />
            <button id="btnFiltrar" type="submit" class="btn pull-right">Filtrar</button>
            <input name="filtroTexto" type="text" class="input-medium search-query pull-right" value="<?php echo $filtroTexto; ?>">
            <select name="filtroCampo" class="pull-right input-small">
            	<option value="name" <?php if ($filtroCampo=='name') { echo 'selected'; } ?>>Ramal</option>
                <option value="nome" <?php if ($filtroCampo=='nome') { echo 'selected'; } ?>>Nome</option>
                <option value="email" <?php if ($filtroCampo=='email') { echo 'selected'; } ?>>Email</option>
            </select>
        </form>
        
        <table class="table table-bordered table-striped">
        	<thead>
            	<tr>
                	<th><a id="aTipo" href="#">Tipo</a></th>
                    <th><a id="aRamal" href="#">Ramal</a></th>
                    <th><a id="aNome" href="#">Nome do usu&aacute;rio</a></th>
                    <th><a id="aEmail" href="#">Email</a></th>
                    <th><a id="aGrupo" href="#">Grupo</a></th>
                    <th><a id="aIP" href="#">Endere&ccedil;o IP</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            	<?php
				
					if (mysql_num_rows($resultRamais)) {
						
						while ($resultRamaisLinha = mysql_fetch_array($resultRamais)) {
					
							echo '
								<tr>
									<td>'.$resultRamaisLinha['hittype'].'</td>
									<td>'.$resultRamaisLinha['name'].'</td>
									<td>'.$resultRamaisLinha['nome'].'</td>
									<td>'.$resultRamaisLinha['email'].'</td>
									<td>'.$resultRamaisLinha['grupo'].'</td>
									<td>'.$resultRamaisLinha['ipaddr'].'</td>
									<td>
										<div class="btn-group pull-right">
											<a href="extensions-register.php?idRamal='.$resultRamaisLinha['id'].'" class="btn">Editar</a>
											<a href="#" class="btn" onClick="btnExcluiRamal(\''.$resultRamaisLinha['id'].'\',\''.$resultRamaisLinha['name'].'\')">Excluir</a>
										</div>
									</td>
								</tr>
							';
						
						}
						
					} else {
						
						echo '
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						';
						
					}
					
				?>
            </tbody>
        </table>
        
        <div class="modal hide" id="modalConfirmaExcluir">
	        <div class="modal-header">
    		    <button type="button" class="close" data-dismiss="modal">×</button>
        		<h3>Aten&ccedil;&atilde;o</h3>
	        </div>
	        <div class="modal-body">
    	    	<p></p>
        	</div>
	        <div class="modal-footer">
            	<div class="btn-group pull-right">
		    	    <a href="#" class="btn" data-dismiss="modal">N&atilde;o</a>
	                <a id="btnConfirmaExcluir" href="#" class="btn btn-danger">Sim</a>
                </div>
	        </div>
        </div>

	</div>

</body>
</html>