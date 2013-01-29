<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>

        <?php include('../../includes/head.php'); ?>

        <script>

            $(document).ready(function(e) {

                $('#myModal').modal();

                $('#formLogin input[name="usuario"]').keyup(function(e) {

                    var code = (e.keyCode ? e.keyCode : e.which);

                    if(code == 13) {

                        $('#formLogin input[name="usuario"]').focus();

                    }

                });

			

                $('#formLogin input[name="senha"]').keyup(function(e) {

                    var code = (e.keyCode ? e.keyCode : e.which);

                    if(code == 13) {

                        $('#btnEntrar').click();

                    }

                });

			

                $("#btnEntrar").click(function(e) {

                    $.post("login-ajax.php", $("#formLogin").serialize(),

                    function(data){

                        if (data.statusRetorno == 'ok') {

                            $(window.document.location).attr("href","../dashboard/dashboard.php");

                        } else {

                            $('#boxMsg div strong').html(data.msgdeerro);
                            $('#boxMsg').show();

                        }

                    }, "json"

                );



                });

            });

        </script>

    </head>

    <body>

        <?php include('../../includes/menu.php'); ?>

        <div class="container">

            <div class="modal" id="myModal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>HITPabx</h3>
                </div>        

                <div class="modal-body">
                    <br />
                    <form id="formLogin" class="form-horizontal" action="#" method="post"> 
                        <div class="control-group">
                            <label class="control-label">Username</label>
                            <div class="controls">
                                <input name="username" type="text" class="span3">
                            </div>            
                        </div>            
                        <div class="control-group">
                            <label class="control-label">Password</label>
                            <div class="controls">
                                <input name="password" type="password" class="span3">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">&nbsp;</label>
                            <div class="controls">
                                <select name="language">
                                    <option value="en">English</option>
                                    <option value="es">Español</option>
                                    <option value="br">Português</option>
                                </select>
                            </div>
                        </div>
                    </form>           
                </div>

                <div class="modal-footer">            

                    <a id="btnEntrar" href="#" class="btn btn-primary">Login</a><br />
                    <div id="boxMsg" class="hide">        
                        <br />            
                        <div class="alert alert-error">
                            <strong>...</strong>
                        </div>
                    </div>    

                </div>

            </div>

        </div>

    </body>

</html>

