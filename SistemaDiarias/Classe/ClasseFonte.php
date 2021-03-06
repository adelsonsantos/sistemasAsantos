<?php
//define o nome da pagina local para facilitar nos links
$PaginaLocal = "Fonte";
//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

$AcaoSistema = $_GET['acao'];

If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
{
    $numFiltro = $_GET['filtro'];

    If ($numFiltro != "")
    {
        $strStringSQL = "fonte_st = " .$numFiltro;
    }
    Else
    {
        $strStringSQL = "fonte_st <> 2";
    }

    If ($RetornoFiltro != "")
    {
        $sqlConsulta = "SELECT * FROM diaria.fonte WHERE ".$strStringSQL." AND (fonte_ds ILIKE '%".$RetornoFiltro."%' OR fonte_cd ILIKE '%".$RetornoFiltro."%') ORDER BY UPPER(fonte_cd)";
    }
    Else
    {
        $sqlConsulta = "SELECT * FROM diaria.fonte WHERE ".$strStringSQL." ORDER BY UPPER(fonte_cd)";
    }
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
}
ElseIf ($AcaoSistema == "incluir")
{
    $DataCriacao = date("Y-m-d");
    $Numero      = trim($_POST['txtNumero']);
    $Descricao	 = strtoupper(trim($_POST['txtDescricao']));

    $sqlConsulta = "SELECT fonte_cd FROM diaria.fonte WHERE (UPPER(fonte_ds) = '".strtoupper($Descricao)."' OR fonte_cd = '".$Numero."') AND fonte_st = 0";
    
    $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
      
    If (pg_fetch_row($rsConsulta)==0)
    {
        $sqlInsere = "INSERT INTO diaria.fonte (fonte_cd, fonte_ds, fonte_st, fonte_dt_criacao, fonte_padrao) VALUES ('".$Numero. "','".$Descricao."', 0, '".$DataCriacao."', 0)";
        pg_query(abreConexao(),$sqlInsere);
        echo "<script>window.location = 'FonteInicio.php ';</script>";
    }
    Else
    {
        $MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
    }
}
ElseIf ($AcaoSistema == "consultar")
{
    $Codigo = $_GET['cod'];

    If ($Codigo == "")
    {
        $Codigo      = $_POST['checkbox'];
        $sqlConsulta = "SELECT * FROM diaria.fonte WHERE fonte_cd IN (".$Codigo.")";
    }
    Else
    {
        $sqlConsulta = "SELECT * FROM diaria.fonte WHERE fonte_cd = '".$Codigo."'";
    }

    $rsConsulta     = pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta  = pg_fetch_assoc($rsConsulta);

    If ($linhaConsulta)
    {
        $Codigo        = $linhaConsulta['fonte_cd'];
        $Numero	       = $linhaConsulta['fonte_cd'];
        $Descricao     = $linhaConsulta['fonte_ds'];
        $StatusNumero  = $linhaConsulta['fonte_st'];
        $DataCriacao   = $linhaConsulta['fonte_dt_criacao'];
        $DataAlteracao = $linhaConsulta['fonte_dt_alteracao'];

        If ($StatusNumero == "0")
        { 
            $StatusNome = "Ativo";
        }
        Else
        {  
            $StatusNome = "Inativo";
        }
    }
}
ElseIf ($AcaoSistema == "alterar")
{
    $DataAlteracao = date("Y-m-d");
    $Codigo        = $_POST['txtCodigo'];
    $Descricao     = strtoupper(trim($_POST['txtDescricao']));

    $sqlConsulta = "SELECT fonte_cd FROM diaria.fonte WHERE (UPPER(fonte_ds) = '".strtoupper($Descricao)."' AND fonte_cd <> '".$Codigo."') AND fonte_st = 0 ";
    
    $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);

    If (pg_fetch_row($rsConsulta)==0)
    {
        $sqlAltera = "UPDATE diaria.fonte SET fonte_ds = '".$Descricao."', fonte_dt_alteracao = '".$DataAlteracao."' WHERE fonte_cd = '".$Codigo."' ";
        pg_query(abreConexao(),$sqlAltera);
        echo "<script>window.location = 'FonteInicio.php ';</script>";
    }
    Else
    {
        $MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
    }
}
ElseIf ($AcaoSistema == "alterarStatus")
{
    $DataAlteracao = date("Y-m-d");
    $Codigo        = $_GET['cod'];
    $StatusNumero  = $_GET['status'];

    If ($StatusNumero == 0)
    {  
        $StatusNumero = 1;
    }
    Else
    {  
        $StatusNumero = 0;
    }    
    $sqlAltera = "UPDATE diaria.fonte SET fonte_st = ".$StatusNumero.", fonte_dt_alteracao = '".$DataAlteracao."' WHERE fonte_cd = '".$Codigo."' ";
    pg_query(abreConexao(),$sqlAltera);
    echo "<script>window.location = 'FonteInicio.php ';</script>";
}
ElseIf ($AcaoSistema == "excluir")
{
    $ExcluirCheckbox = $_GET['excluirMultiplo'];
    
    If ($ExcluirCheckbox == 1)
    {
        $Codigo    = $_POST['txtCodigo'];
        $sqlDeleta = "UPDATE diaria.fonte SET fonte_st = 2 WHERE fonte_cd IN ('".$Codigo."')";
    }
    Else
    {   
        $Codigo    = $_GET['cod'];
        $sqlDeleta = "UPDATE diaria.fonte SET fonte_st = 2  WHERE fonte_cd = '".$Codigo."' ";
    }
    pg_query(abreConexao(),$sqlDeleta);
    echo "<script>window.location = 'FonteInicio.php ';</script>";
}
?>
