<?php    class database {        	var $dbservidor = 'localhost';	var $dbusuario = 'root';	var $dbsenha = '7901228899';	var $dbnome = 'hitpbx';        var $db;        function __construct() {	            $this->db = mysql_connect($this->dbservidor,$this->dbusuario,$this->dbsenha) or die(mysql_error());            mysql_select_db($this->dbnome, $this->db);            mysql_query("SET NAMES 'utf8'",  $this->db);            mysql_query('SET character_set_connection=utf8',  $this->db);            mysql_query('SET character_set_client=utf8',  $this->db);            mysql_query('SET character_set_results=utf8',  $this->db);                }    }       ?>