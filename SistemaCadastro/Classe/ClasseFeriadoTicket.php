<?php
include "../Include/Inc_Configuracao.php";

//define o nome da pagina local para facilitar nos links
$PaginaLocal = 'FeriadoTicket';
$acaoSistema = $_GET['acao'];

switch ($acaoSistema)
{
    case '':        
        $rsConsulta = Inicializar();
    break;

    case 'consultar':        
        $rsConsulta = Consultar();
    break;

    case 'incluir':        
        Incluir($PaginaLocal);
    break;
    
    case 'alterar':         
        Alterar($PaginaLocal);
    break;

    case 'alterarTicket':            
        AlterarTicket($PaginaLocal);
    break;

    case 'excluir':          
        Excluir($PaginaLocal);
    break;
}

function Inicializar()
{
    global $valTicket,$idTicket;
    
    $sqlTicket   = "SELECT * FROM dados_unico.ticket_refeicao ORDER BY ticket_data_inclusao DESC";
    $rsTicket    = pg_query(abreConexao(),$sqlTicket); 
    $linhaTicket = pg_fetch_assoc($rsTicket);
    $valTicket   = $linhaTicket['ticket_valor'];
    $idTicket    = $linhaTicket['ticket_id'];
    
    $sqlFeriados = "SELECT * FROM dados_unico.feriado";
    $rsConsulta  = pg_query(abreConexao(),$sqlFeriados); 
    return $rsConsulta;
}

function Consultar()
{
    $idFeriado = $_GET['feriado_id'];    
    $sqlConsulta = "SELECT * FROM dados_unico.feriado
                            WHERE feriado_id =".$idFeriado;
    $rsConsulta  = pg_query(abreConexao(),$sqlConsulta); 
    return $rsConsulta;
}

function Incluir($PaginaLocal)
{
    $diaFeriado       = $_POST['diaFeriado'];
    $mesFeriado       = $_POST['cmbMes'];
    $descricaoFeriado = strtoupper($_POST['desFeriado']);
    $tipoFeriado      = $_POST['tipoFeriado']; 
    $dataInclusao     = date('Y-m-d');
    
    $sqlConflito = "SELECT * 
                      FROM dados_unico.feriado 
                     WHERE feriado_dia =".$diaFeriado."
                       AND feriado_mes =".$mesFeriado;
    
    $rsConflito  = pg_query(abreConexao(),$sqlConflito);     
    
    if(pg_num_rows($rsConflito) > 0)
    {
        echo "<script type='text/javascript' language='javascript'>
                alert('Este Feriado já foi cadastrado.'); 
                return false;
              </script>";
    }
    else
    {
        $sqlInsere = "INSERT INTO dados_unico.feriado
                                  (feriado_dt_modificacao, feriado_ds, feriado_tipo, feriado_mes, feriado_dia)
                           VALUES ('$dataInclusao', '$descricaoFeriado', $tipoFeriado, $mesFeriado, $diaFeriado)";
        
        pg_query(abreConexao(),$sqlInsere);
        
        echo "<script type='text/javascript' language='javascript'>window.location = '".$PaginaLocal."Inicio.php';</script>";
    }    
}

function Alterar($PaginaLocal)
{
    $idFeriado        = $_POST['codigo'];
    $diaFeriado       = $_POST['diaFeriado'];
    $mesFeriado       = $_POST['cmbMes'];
    $descricaoFeriado = strtoupper($_POST['desFeriado']);
    $tipoFeriado      = $_POST['tipoFeriado'];   
    $dataAtualizacao  = date('Y-m-d');        
    
    $sqlUpdate = " UPDATE dados_unico.feriado
                      SET feriado_dt_modificacao = '".$dataAtualizacao."',
                          feriado_dia  = ".$diaFeriado.",
                          feriado_mes  = ".$mesFeriado.",
                          feriado_ds   = '".$descricaoFeriado."',
                          feriado_tipo = ".$tipoFeriado."
                    WHERE feriado_id = ".$idFeriado;
    
    pg_query(abreConexao(),$sqlUpdate);   
    
    echo "<script type='text/javascript' language='javascript'>window.location = '".$PaginaLocal."Inicio.php';</script>";
}

function AlterarTicket($PaginaLocal)
{
    $valorTicket  = $_POST['valTicket'];     
    $dataInclusao = date('Y-m-d').' '.date('H:i:s');
    
    $sqlInsere = "INSERT INTO dados_unico.ticket_refeicao
                              (ticket_valor, ticket_data_inclusao)
                       VALUES ($valorTicket, '$dataInclusao')";
    
    pg_query(abreConexao(),$sqlInsere);   
    
    echo "<script type='text/javascript' language='javascript'>window.location = '".$PaginaLocal."Inicio.php';</script>";
}

function Excluir($PaginaLocal)
{
    $idFeriado = $_POST['feriado_id'];    
    $sqlDelete = "DELETE FROM dados_unico.feriado
                        WHERE feriado_id = ".$idFeriado;
    
    pg_query(abreConexao(),$sqlDelete);
    
    echo "<script type='text/javascript' language='javascript'>window.location = '".$PaginaLocal."Inicio.php';</script>";
}

?>
