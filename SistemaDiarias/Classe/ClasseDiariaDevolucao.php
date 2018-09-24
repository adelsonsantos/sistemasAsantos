<?php

$Codigo = $_GET['cod'];

if ($_GET['pagina'] == "") 
{
    $PaginaLocal = "Solicitacao";
} 
else 
{
    $PaginaLocal = $_GET['pagina'];
}

If ($AcaoSistema == "") 
{
    $sqlConsulta = " SELECT diaria_id, 
                            diaria_numero, 
                            pessoa_nm, 
                            diaria_dt_saida, 
                            diaria_hr_saida, 
                            diaria_dt_chegada, 
                            diaria_hr_chegada,  
                            diaria_st, 
                            diaria_solicitante,
                            diaria_beneficiario,
                            id_coordenadoria
                       FROM diaria.diaria d, 
                            dados_unico.funcionario f, 
                            dados_unico.pessoa p 
                      WHERE (p.pessoa_id = f.pessoa_id) 
                        AND (d.diaria_beneficiario = f.pessoa_id) 
                        AND diaria_id = " . $Codigo;

    $rsConsulta  = pg_query(abreConexao(), $sqlConsulta);
} 
ElseIf ($AcaoSistema == "devolver") 
{
    $Codigo      = $_POST['txtCodigo'];
    $Status      = $_POST['txtStatus'];
    $localDiaria = $_POST['txtLocalDiaria'];
    $Date        = date("Y-m-d");   

    If($Status == 3)
    {
        $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 2, diaria_devolvida = 1 WHERE diaria_id = " . $Codigo;
    }
    ElseIf($Status == 10)
    {
        $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4, diaria_devolvida = 1 WHERE diaria_id = " . $Codigo;
        $sqlAnulaComprovacao = "UPDATE diaria.diaria_comprovacao SET diaria_comprovacao_st = 2 WHERE diaria_ id = ".$Codigo;
        pg_query(abreConexao(), $sqlAnulaComprovacao);
    }
    ElseIf ($Status == 6) 
    {
        $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4, diaria_devolvida = 1 WHERE diaria_id = " . $Codigo;
    }
    ElseIf($Status == 100)
    {
        $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 100, diaria_devolvida = 1 WHERE diaria_id = " . $Codigo;
    }
    ElseIf($Status == 0)
    {       
        if(($localDiaria != 0)&&($localDiaria != ''))
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 100, diaria_devolvida = 2 WHERE diaria_id = " . $Codigo;
        }        
        else
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 0, diaria_devolvida = 1 WHERE diaria_id = " . $Codigo;
        } 
    }
    ElseIf(($Status == 2)||($Status == 1))
    {
        $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 0, diaria_devolvida = 2 WHERE diaria_id = " . $Codigo;
    }
    Else 
    {
        if(($localDiaria != 0)&&($localDiaria != ''))
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 100, diaria_devolvida = 1 WHERE diaria_id = " . $Codigo;
        }
        else
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 0, diaria_devolvida = 1 WHERE diaria_id = " . $Codigo;
        }        
    }
    
    pg_query(abreConexao(), $sqlAltera);

    $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
    $rsConsulta  = pg_query(abreConexao(), $sqlConsulta);
    $linha       = pg_fetch_assoc($rsConsulta);
    
    $Descricao   = strtoupper(trim($_POST['txtDescricaoDevolucao']));
    $Motivo      = $_POST['cmbMotivoDiaria'];
    $Time        = date("H:i:s");
    
    $sqlInsere   = "INSERT INTO diaria.diaria_devolucao (diaria_id, motivo_id, diaria_devolucao_ds, diaria_devolucao_dt, diaria_devolucao_hr, diaria_devolucao_func, diaria_st)
                         VALUES (" . $Codigo . ", " . $Motivo . ", '" . $Descricao . "', '" . $Date . "', '" . $Time . "'," . $linha['funcionario_id'] . "," . $Status . ")";
    
    pg_query(abreConexao(), $sqlInsere);
    echo "<script>window.location = '" . $PaginaLocal . "inicio.php';</script>";
}
?>