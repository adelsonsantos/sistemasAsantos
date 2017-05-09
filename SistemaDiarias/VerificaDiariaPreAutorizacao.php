<?php
include "../Include/Inc_Configuracao.php";
//include "conecta.php";

//define o nome da pagina local para facilitar nos links

if ($_GET['pagina'] == "") 
{
    $PaginaLocal = "SolicitacaoPreAutorizacao";
}else 
{
    $PaginaLocal = $_GET['pagina'];
}

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;
$_SESSION['OrigemPagina']   = "SolicitacaoPreAutorizacao";

//$Roteiro = $_GET['roteiro'];		
$idCoordenadoria = $_SESSION['UsuarioCoordenadoria'];
$AcaoSistema     = $_GET['acao'];
//	echo $AcaoSistema; EXIT();
if ($AcaoSistema == "preautorizar") 
{
    $Date   = date("Y-m-d");
    $Codigo = $_GET['cod'];
    $Time   = date("H:i:s");

    // Executa consulta de alteração na Tabela Diaria para mudar o status da Diaria
    $sqlAlterar = "UPDATE diaria.diaria SET diaria_st = 0 WHERE diaria_id = $Codigo AND id_coordenadoria = $idCoordenadoria";
    pg_query(abreConexao(), $sqlAlterar);
    
    //Consulta feita para pegar o ID do funcionário que está logado
    $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = ".$_SESSION['UsuarioCodigo'];
    $rsConsulta  = pg_query(abreConexao(), $sqlConsulta);
    $tupla       = pg_fetch_array($rsConsulta);

    //Inserção de daods na tabela DIARIA_PRE_AUTORIZAÇÃO
    $sqlInsere = "INSERT INTO diaria.diaria_pre_autorizacao(diaria_id,diaria_pre_autorizacao_func,diaria_pre_autorizacao_func_exec,diaria_pre_autorizacao_dt,diaria_pre_autorizacao_hr) VALUES (" . $Codigo . ", " . $tupla['funcionario_id'] . ", 1, '" . $Date . "', '" . $Time . "')";
    pg_query(abreConexao(), $sqlInsere);
    
    // Fecha conexão com o banco de dados    
    $msg = 1;
    echo "<script>alert(\"Diária Pré-Autorizada com Sucesso.!!!\");</script>";
    echo "<script>window.location = 'SolicitacaoPreAutorizacaoInicio.php?msg=$msg ';</script>";
} // Fim do IF
//echo "<script>alert(\"Diária Pré-Autorizada com Sucesso.!!!\");</script>";		
echo "<script>window.location = 'SolicitacaoPreAutorizacaoInicio.php';</script>";
?>
