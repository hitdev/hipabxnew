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
    

$tdm = "SELECT name,nome,context,hitport from tab_sipuser where hittype='TDM' and hitassoc='S' order by name";
$restdm = mysql_query($tdm,$id);

$sip = "SELECT name,nome,context from tab_sipuser where hittype='SIP' order by name";
$ressip = mysql_query($sip,$id);
$posicao = 0;

// Funcao para tirar o acento
function RemoverAcentos($Msg)
{
 $a = array(
  "/[ÂÀÁÄÃ]/"=>"A",
  "/[âãàáä]/"=>"a",
  "/[ÊÈÉË]/"=>"E",
  "/[êèéë]/"=>"e",
  "/[ÎÍÌÏ]/"=>"I",
  "/[îíìï]/"=>"i",
  "/[ÔÕÒÓÖ]/"=>"O",
  "/[ôõòóö]/"=>"o",
  "/[ÛÙÚÜ]/"=>"U",
  "/[ûúùü]/"=>"u",
  "/ç/"=>"c",
  "/Ç/"=> "C");
 
// Retira o acento pela chave do array 
return preg_replace(array_keys($a), array_values($a), $Msg);
}

// Para execução do processo op_server.pl
$cmd00 = "sudo killall -15 op_server.pl";
$cmd10 = shell_exec($cmd00);

// Apagar as arquivo variables.txt
$cmd01 = "sudo rm ".$_SERVER[DOCUMENT_ROOT]."/panel/variables.txt";
$cmd11 = shell_exec($cmd01);

// Limpar o arquivo
$cmd02 = "> ".$_SERVER[DOCUMENT_ROOT]."/op_panel-0.29/op_buttons.cfg";
$cmd12 = shell_exec($cmd02);

// Abrir arquivo op_buttons.cfg e recriar os ramais
$ponteiro = fopen($_SERVER[DOCUMENT_ROOT].'/op_panel-0.29/op_buttons.cfg', 'w');
      while ($row = mysql_fetch_array($ressip)) {    
          $vname=$row['name'];
          $vnome=$row['nome'];
          $vnome=RemoverAcentos($vnome);  
          $vcontexto=$row['context'];            
          $posicao = $posicao + 1;
          $salva = "[SIP/$vname]\nPosition=$posicao\nLabel=\"$vname $vnome\"\nExtension=$vname\nIcon=3\nServer=1\n\n";
          fwrite($ponteiro, $salva);       
      }

      while ($row = mysql_fetch_array($restdm)) {
          $vname=$row['name'];
          $vnome=$row['nome'];
	  $vport=$row['hitport'];
          $vnome=RemoverAcentos($vnome);
          $vcontexto=$row['context'];
          $posicao = $posicao + 1;
          $salva = "[ZAP/$vport]\nPosition=$posicao\nLabel=\"$vname $vnome\"\nExtension=$vname\nIcon=3\nServer=1\n\n";
          fwrite($ponteiro, $salva);
      }
fclose($ponteiro); 

// Rodar o op_server.pl
$cmd03 = "sudo ".$_SERVER[DOCUMENT_ROOT]."/op_panel-0.29/op_server.pl -d";
$cmd13 = shell_exec($cmd03);

?>
