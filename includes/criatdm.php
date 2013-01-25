<?

$dbname="hitpbx";
$usuario="root";
$password="7901228899";
if(!($id = mysql_connect("localhost",$usuario,$password))) {
   echo "Erro ao Conectar com o gerenciador MySQL. Favor Contactar o Administrador.";
   exit;
}
if(!($con=mysql_select_db($dbname,$id))) {
   echo "Erro ao Selecionar o gerenciador MySQL. Favor Contactar o Administrador.";
   exit;
}

$TDM = "SELECT name,hitport from tab_sipuser where hittype='TDM' and hitassoc='S' order by name";
$exec = mysql_query($TDM,$id);

// Limpar o arquivo
$cmd1 = "> /etc/asterisk/ramaistdm.conf";
$exec1 = shell_exec($cmd1);

$ponteiro = fopen('/etc/asterisk/ramaistdm.conf', 'w');
      while ($row = mysql_fetch_array($exec)) {
          $vname=$row['name'];
          $vport=$row['hitport'];
          $salva = "callerid=$vname\nchannel => $vport\n\n";
          fwrite($ponteiro, $salva);
      }
fclose($ponteiro);

?>
