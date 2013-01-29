<?php

if (!isset($_SESSION['hitpabxUser'])) {

    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hitpabxnew/index.php');
}

?>