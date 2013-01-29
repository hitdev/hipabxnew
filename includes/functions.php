<?php

function database() {
    $dbservidor = 'localhost';
    $dbusuario = 'root';
    // Do not write the password in GITHub
    $dbsenha = '';
    $dbnome = 'hitpbx';

    $db = mysql_connect($dbservidor, $dbusuario, $dbsenha) or die(mysql_error());
    mysql_select_db($dbnome, $db);

    mysql_query("SET NAMES 'utf8'", $db);
    mysql_query('SET character_set_connection=utf8', $db);
    mysql_query('SET character_set_client=utf8', $db);
    mysql_query('SET character_set_results=utf8', $db);

    return $db;
}

function getTranslator($language, $ids, $db) {
    $sql = "SELECT id, text FROM tab_language WHERE language = '" . $language . "' AND id IN (";
    foreach ($ids as $value) {
        $sql.= $value . ",";
    }
    $sql = substr($sql, 0, -1) . ") ORDER BY id";
    $result = mysql_query($sql, $db);

    $arrReturn = array();
    while ($resultLinha = mysql_fetch_array($result)) {
        $arrReturn[$resultLinha['id']] = $resultLinha['text'];
    }

    return $arrReturn;
}

?>