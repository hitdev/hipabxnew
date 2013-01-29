<?php

	session_start();
	
	include('../../includes/security.php');
	include('../../includes/db.php');
?>        
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php include('../../includes/head.php'); ?>
</head>    
<body>
	<?php include('../../includes/menu.php'); ?>
    <div class="container">
   <table class="table table-bordered table-striped">
        	<thead>
            	<tr>
                	<th><a id="qName" href="#">Tipo</a></th>
                    <th><a id="qNumber" href="#">Ramal</a></th>
                    <th><a id="aNome" href="#">Nome do usu&aacute;rio</a></th>
                    <th><a id="aEmail" href="#">Email</a></th>
                    <th><a id="aGrupo" href="#">Grupo</a></th>
                    <th><a id="aIP" href="#">Endere&ccedil;o IP</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <div class="btn-group pull-right"><a href="extensions-register.php?idRamal=" class="btn">Editar</a>
                            <a href="#" class="btn" onClick="btnExcluiRamal('10','1234')">Excluir</a>
                        </div>
                    </td>
                </tr>
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
    