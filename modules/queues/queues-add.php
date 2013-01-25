<?php

	session_start();
	
	include('../../includes/security.php');
	include($_SESSION['BASE_PATH'].'includes/db.php');
        
        if(isset($_POST['queue']['name'])){
            echo "<pre>";
            echo "Hay datos para guardar";
            echo "</pre>";
            
            
        }
        
?>        
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php include($_SESSION['BASE_PATH'].'includes/head.php'); ?>
</head>    
<body>
	<?php include($_SESSION['BASE_PATH'].'includes/menu.php'); ?>
     <div class="container">
       <form accept-charset="ISO-8859-1" action="" class="simple_form form-horizontal" id="queue_insert" method="post" >
           
        <legend>Queue</legend>
        <div class="control-group string required">
            <label class="string required control-label" for="queue_name">
                <abbr title="required">*</abbr> Name</label>
            <div class="controls">
                <input class="string required " id="queue_name" name="queue[name]" size="20" type="text" value="" />
                <!-- <p class="help-block">add your article title here</p>-->
            </div>
        </div>
        <div class="control-group string required">
            <label class="string required control-label" for="queue_number">
                <abbr title="required">*</abbr> Number</label>
            <div class="controls">
                <input class="string required " id="queue_number" name="queue[number]" size="20" type="text" value="" />
                <!-- <p class="help-block">add your article title here</p>-->
            </div>
        </div>
        
        
        <div class="control-group select optional">
            <label class="select optional control-label" for="queue_group"> Group Members</label>
            <div class="controls">
                <select class="select optional" id="queue_group" name="queue[group]">
                    <option value=""></option>         
                    <option value="Blog">Blog</option>
                    <option value="Editorial">Editorial</option>
                    <option value="Announce">Announce</option>
                    <option value="Advertisement">Advertisement</option>
                </select>
                <p class="help-block">simple select box</p>
            </div>
        </div>
        <div class="control-group select optional">
            <label class="select optional control-label" for="queue_strategy"> Strategy</label>
            <div class="controls">
                <select class="select optional" id="queue_strategy" name="queue[strategy]">
                    <option value="ringall">Ringall</option>         
                    <option value="leastrecent">Least Recent</option>
                    <option value="fewestcalls">Fewest</option>
                    <option value="random">Random</option>
                    <option value="rrmemory">Round Robin</option>
                    <option value="linear">Linear</option>
                </select>
                <p class="help-block">simple select box</p>
            </div>
        </div>
        <div class="control-group select optional">
            <label class="select optional control-label" for="queue_timeout"> Timeout</label>
            <div class="controls">
                <select class="select optional" id="queue_timeout" name="queue[timeout]">
                    <option value="5">5</option>         
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                    <option value="45">60</option>
                    <option value="45">90</option>
                    <option value="45">120</option>
                    <option value="45">180</option>
                    <option value="45">240</option>
                </select>
                <p class="help-block">simple select box</p>
            </div>
        </div>
        <div class="control-group string required">
            <label class="string required control-label" for="queue_weight">
                <abbr title="required">*</abbr> Weight</label>
            <div class="controls">
                <input class="string required " id="queue_weight" name="queue[weight]" size="20" type="text" value="" />
                <!-- <p class="help-block">add your article title here</p>-->
            </div>
        </div>
        <div class="control-group string required">
            <label class="string required control-label" for="queue_slevel">
                <abbr title="required">*</abbr> Service Level</label>
            <div class="controls">
                <input class="string required " id="queue_slevel" name="queue[slevel]" size="20" type="text" value="" />
                <!-- <p class="help-block">add your article title here</p>-->
            </div>
        </div>
        <div class="control-group boolean optional">
            <label class="boolean optional control-label" for="queue_record">Record Call</label>
            <div class="controls">                
                <label class="checkbox"><input class="boolean optional" id="queue_record" name="queue[record]" type="checkbox" value="1" /></label>
            </div>
        </div>
        <div class="form-actions">
	            <button name="submitGuardar" type="submit" class="btn btn-primary pull-right">Guardar</button>
        </div>
        
        
        </form>
         </div>
</body>
</html>
    