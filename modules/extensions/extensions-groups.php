<?php

	session_start();
	
	include('../../includes/security.php');
	include($_SESSION['BASE_PATH'].'includes/db.php');
	
	$sql = "SELECT * FROM tab_group ORDER BY grupo";
	$resultGrupos = mysql_query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

	<?php include($_SESSION['BASE_PATH'].'includes/head.php'); ?>

</head>

<body>

	<?php include($_SESSION['BASE_PATH'].'includes/menu.php'); ?>
	
    <div class="container">
		
		<div class="well">
			<form class="form-inline" method="post">
				<input name="novogrupo" type="text" />
				<a class="btn btn-primary pull-right" href="<?php echo $_SESSION['BASE_URL'].'soon.php'; ?>">Cadastro</a>
			</form>
		</div>
		
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Grupo</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while ($resultGruposLinha = mysql_fetch_array($resultGrupos)) {
						echo '
							<tr><td>
								'.$resultGruposLinha['grupo'].'
								<div class="btn-group pull-right">
								<a class="btn" href="ramais-grupos.php?altera='.$resultGruposLinha['id'].'">Editar</a>
								<a class="btn" href="ramais-grupos.php?exclui='.$resultGruposLinha['id'].'">Excluir</a>
								</div>
							</td></tr>
						';
					}
				?>
			</tbody>
		</table>
		
        <div class="modal hide" id="modalCadastro">
	        <div class="modal-header">
    		    <button type="button" class="close" data-dismiss="modal">×</button>
        		<h3>Cadastro</h3>
	        </div>
	        <div class="modal-body">
    	    	<p id="modalMSG"></p>
        	</div>
	        <div class="modal-footer">
            	<div class="btn-group pull-right">
    	        	<a id="btnNovoCadastro" href="#" class="btn">Salvar</a>
		    	    <a href="#" class="btn btn-info" data-dismiss="modal">Fechar</a>
                </div>
	        </div>
        </div>

	</div>

</body>
</html>