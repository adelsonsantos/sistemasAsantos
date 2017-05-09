<?php

include_once("funcoes.php");
include_once 'Inc_Conexao.php';
include_once 'Inc_Funcao.php';
include_once 'Inc_FuncaoCombo.php';
include_once 'Inc_FuncaoDiarias.php';
include_once 'Inc_FuncaoExibe.php';
include_once 'Inc_ComboDiaria.php';
include_once("conexao.class.php"); 

$gmtDate = gmdate("D, d M Y H:i:s");
@header("Content-Type: text/html; charset=UTF-8",true);
@header("Expires: {$gmtDate} GMT");
@header("Last-Modified: {$gmtDate} GMT");

@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
@header("Cache-Control: no-cache");
@header("Pragma: no-cache");

if($_SESSION['UsuarioCodigo'] == "")
{
    header("Location: ../Home/Login.php");
}

if(empty($_GET['acao'])== false)
{
    $AcaoSistema = $_GET['acao'];
}

if(isset($_POST['txtFiltro']) && ($_POST['txtFiltro'] != "") && ($_POST['txtFiltro'] != " "))
{
    $_SESSION["Busca"] = $_POST['txtFiltro'];
}
	
if(!$_GET) 
{
    $_SESSION["Busca"] = ""; 
}

$RetornoFiltro = $_SESSION["Busca"];

if( isset($_GET["sistema"]) && !checaAcesso($_GET["sistema"]) )
{
    if($_GET["sistema"] == "5")
    {
        header("Location: ../../Home/Home.php");
    }
    else
    {
        header("Location: ../Home/Home.php");
    }
}

//VARIÁVEL QUE RETORNARÁ A MENSAGEM DE ERRO PADRÃO QUANDO NÃO HOUVER REGISTROS NA BUSCA.
$MsgRegistroVazio=":: Registro(s) n&atilde;o encontrado(s) ::";

//VARIÁVEL QUE ARMAZENARÁ O ERRO RETORNADO PELO BANCO DE DADOS.
$MensagemErroBD="";

//ESTA VARIÁVEL SERVE PARA DEFINIR A QUANTIDADE DE REGISTROS QUE SERÃO EXIBIDOS NA PAGINAÇÃO
$iPageSize = 16;

?>