<?php

$Codigo = $_GET['cod'];

if($_GET['pagina'] == "")
{ 
    $PaginaLocal = "SolicitacaoConsultaGlobal";		
}
else
{
    $PaginaLocal = $_GET['pagina'];		
}	

If($AcaoSistema == "")
{
    $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, diaria.motivo m, dados_unico.pessoa p, diaria.diaria_comprovacao dc, diaria.diaria_motivo dm WHERE (d.diaria_id = dm.diaria_id) AND (d.diaria_id = dc.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
}
/****************************** Ação Devolver Comprovação *************************************************/
ElseIf ($AcaoSistema == "devolver")
{
    $Date   = date("Y-m-d");
    $Codigo = $_POST['txtCodigo'];
    $Status = $_POST['txtStatus'];
    
    IF ($Status == 3)
    {
        $sqlAltera = "UPDATE diaria.diaria SET diaria_comprovada = 0 WHERE diaria_id = " .$Codigo;
        pg_query(abreConexao(),$sqlAltera);
    }
    else
    {
        $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4, diaria_devolvida = 1 WHERE diaria_id = " .$Codigo;
        pg_query(abreConexao(),$sqlAltera);
    }

    $sqlConsulta     = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];
    $rsConsulta      = pg_query(abreConexao(),$sqlConsulta);
    $linharsConsulta = pg_fetch_assoc($rsConsulta);
    $Descricao       = strtoupper(trim($_POST['txtDescricaoDevolucao']));
    $Motivo          = $_POST['cmbMotivoDiaria'];
    $sqlInsere       = "INSERT INTO diaria.diaria_devolucao (diaria_id, motivo_id, diaria_devolucao_ds, diaria_devolucao_dt, diaria_devolucao_hr, diaria_devolucao_func) VALUES (" .$Codigo. ", " .$Motivo. ", '" .$Descricao. "', '" .$Date."', '" .$Time. "'," .$linharsConsulta['funcionario_id']. ")";
    pg_query(abreConexao(),$sqlInsere);

    echo "<script>alert(\"Comprovação Devolvida com Sucesso.!!!\");</script>";	                   
    echo "<script>window.location = '".$PaginaLocal."inicio.php';</script>";
}
?>
