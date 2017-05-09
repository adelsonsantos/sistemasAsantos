<?php
class postgre {

private $postgre;

protected $inf = array('localhost','user','senha','banco de dados');


protected function constantes()
{
if(!defined('HOST') and !defined('USU') and !defined('SENHA') and !defined('DB'))
{
define('HOST' ,$this->inf[0]);
define('USU' ,$this->inf[1]);
define('SENHA',$this->inf[2]);
define('DB' ,$this->inf[3]);
}
}

public function conect()
{
if(extension_loaded('mysqli'))
{

$this->constantes();
$this->mysqli = new mysqli(HOST,USU,SENHA,DB);

if(mysqli_connect_errno())
{
print('Falha na conexão:'. mysqli_error());
}

}else{

die('Extensão do MySQL não carregada.');

}
}


public function fechar(){
return $this->mysqli->close();
}

public function exe($sql){
$this->conect();
return $this->mysqli->query($sql);
$this->fechar();
}

}
?>