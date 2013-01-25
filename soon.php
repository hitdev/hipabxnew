<?php

	session_start();
	
	if (!isset($_SESSION['hitpabxUser'])) { header('Location: index.php'); }
	
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

	<?php include($_SESSION['BASE_PATH'].'includes/head.php'); ?>

</head>

<body>

	<?php include($_SESSION['BASE_PATH'].'includes/menu.php'); ?>
    
    <div class="container">

        Coming soon...
        
	</div>

</body>
</html>