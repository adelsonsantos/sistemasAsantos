<?php
include "../Include/Inc_Configuracao.php";
include "IncludeLocal/Inc_FuncoesDiarias.php";
//define o nome da pagina local para facilitar nos links
$PaginaLocal = "Arquivamento";

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

if($_GET['filtroAno'] != '')
{
    $cmbAno = $_GET['filtroAno'];
}

If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
{
    if($cmbAno == '')
    {
        $whereAno = " AND date_part('Year', diaria_dt_criacao) = ".date('Y');
    }
    else
    {
        $whereAno = " AND date_part('Year', diaria_dt_criacao) = '".$cmbAno."' ";
    }
    
    If ($RetornoFiltro != "")
    {
        $sqlConsulta = "SELECT * 
                          FROM diaria.diaria d 
                          JOIN dados_unico.funcionario f
                            ON d.diaria_beneficiario = f.pessoa_id
                          JOIN dados_unico.pessoa p
                            ON p.pessoa_id = f.pessoa_id
                          JOIN dados_unico.pessoa_fisica pf
                            ON f.pessoa_id = pf.pessoa_id
                          JOIN diaria.diaria_comprovacao dc 
                            ON d.diaria_id = dc.diaria_id
                         WHERE diaria_st = 6
                           AND diaria_devolvida = 0 
                           AND diaria_cancelada = 0 
                           AND diaria_excluida = 0 
                           AND (pessoa_nm ILIKE '%" .$RetornoFiltro. "%' 
                            OR diaria_numero ILIKE '%" .$RetornoFiltro. "%') 
                      ORDER BY diaria_numero";
    }
    Else
    {
        $sqlConsulta = "SELECT * 
                          FROM diaria.diaria d 
                          JOIN dados_unico.funcionario f
                            ON d.diaria_beneficiario = f.pessoa_id
                          JOIN dados_unico.pessoa p
                            ON p.pessoa_id = f.pessoa_id
                          JOIN dados_unico.pessoa_fisica pf
                            ON f.pessoa_id = pf.pessoa_id
                          JOIN diaria.diaria_comprovacao dc 
                            ON d.diaria_id = dc.diaria_id
                         WHERE diaria_st = 6
                           AND diaria_devolvida = 0 
                           AND diaria_cancelada = 0 
                           $whereAno
                           AND diaria_excluida = 0
                      ORDER BY diaria_numero";
    }
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
}
ElseIf ($AcaoSistema == "arquivar")
{
    $Codigo        = $_GET['cod'];
    $DataObrigacao = $_POST['txtDataObrigacao'];
    $HoraObrigacao = $_POST['txtHoraObrigacao'];
    $Date          = date("Y-m-d");
    $Time          = date("H:i:s");
    
    $sqlAltera     = "UPDATE diaria.diaria SET diaria_st = 7 WHERE diaria_id = " .$Codigo;
    pg_query(abreConexao(),$sqlAltera);

    $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];
    $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
    $linha       = pg_fetch_assoc($rsConsulta);
    
    $sqlInsere   = "INSERT INTO diaria.diaria_arquivada (diaria_id, diaria_arquivada_func, diaria_arquivada_dt, diaria_arquivada_hr) VALUES (" .$Codigo. ", " .$linha['funcionario_id']. ",'" .$Date. "', '" .$Time. "')";

    pg_query(abreConexao(),$sqlInsere);
    
    echo "<script>alert(\"Diária Arquivada com Sucesso.!!!\");</script>";			                         
    echo "<script>window.location = 'ArquivamentoInicio.php ';</script>";
}
ElseIf ($AcaoSistema == "ArquivarTodasDiarias")
{
    $Codigo    = $_GET['Codigos'];
    $Codigo    = substr($Codigo,0,-1);   
    
    $sql       = "SELECT diaria_id,diaria_comprovada FROM diaria.diaria d WHERE d.diaria_id in ($Codigo)";	    
    $resultado = pg_query(abreConexao(),$sql);			

    while($tupla = pg_fetch_assoc($resultado)) 
    {
        $Diaria_Id        = $tupla['diaria_id'];				
        $DiariaComprovada = $tupla['diaria_comprovada'];				

        $Date        = date("Y-m-d");
        $Time        = date("H:i:s");
        $sqlAltera   = "UPDATE diaria.diaria SET diaria_st = 7 WHERE diaria_id = " .$Diaria_Id;
        
        pg_query(abreConexao(),$sqlAltera);

        $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];
        $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
        $linha       = pg_fetch_assoc($rsConsulta);
        
        $sqlInsere   = "INSERT INTO diaria.diaria_arquivada 
                                    (diaria_id, 
                                     diaria_arquivada_func, 
                                     diaria_arquivada_dt, 
                                     diaria_arquivada_hr
                                    )
                            VALUES (" .$Diaria_Id. ", 
                                    " .$linha['funcionario_id']. ",
                                    '" .$Date. "',
                                    '" .$Time. "'
                                   )";
            //echo $sqlInsere."<br>";
        pg_query(abreConexao(),$sqlInsere);
    }
    echo "<script>alert(\"Diária Arquivada com Sucesso.!!!\");</script>";			                         
    echo "<script>window.location = 'ArquivamentoInicio.php ';</script>";
}
?>
