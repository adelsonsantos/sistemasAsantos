<?php
include '../Include/Inc_Configuracao.php';
include_once 'IncludeLocal/Inc_FuncoesDiarias.php';

//define o nome da pagina local para facilitar nos links
$PaginaLocal = "CadastroSaldoRecurso";
$acaoSistema = $_GET['acao'];

switch ($acaoSistema)
{
    case '':
        $rsConsulta = Inicializar();
    break;
        
    case "consultar":  
        $rsConsulta = Consultar();          
    break;

    case "incluir":         
        Incluir($PaginaLocal);
    break;
    
    case "alterar":        
        Alterar($PaginaLocal);
    break;

    case "alterarStatus":
        alterarStatus($PaginaLocal);
    break;

    case "excluir":        
        Excluir($PaginaLocal);
    break;
}

function Inicializar()
{    
    if($_GET['filtroMes'] != "")
    {
        $mes = $_GET['filtroMes'];
    }
    else
    {
        $mes = date('m'); 
    }
    $ano         = date("Y");
    
    If ($RetornoFiltro != "")
    {
        $sqlConsulta = "SELECT  id_saldo,
                                id_saldo_projeto,
                                projeto_ds,
                                id_saldo_fonte,
                                fonte_ds,
                                saldo_mes,
                                saldo_valor,
                                saldo_st,
                                saldo_valor_inicial
                        FROM diaria.saldo_projeto_fonte
                        JOIN diaria.projeto p
                        ON p.projeto_cd = id_saldo_projeto
                        JOIN diaria.fonte f
                        ON f.fonte_cd = id_saldo_fonte
                        WHERE saldo_st <> 2 AND saldo_mes = ".$mes." AND (id_saldo_projeto ILIKE '%".$RetornoFiltro."%' OR id_saldo_fonte ILIKE '%".$RetornoFiltro."%') ORDER BY id_saldo_projeto,id_saldo_fonte";           
    }
    Else
    {
        $sqlConsulta = "SELECT  id_saldo,
                                id_saldo_projeto,
                                projeto_ds,
                                id_saldo_fonte,
                                fonte_ds,
                                saldo_mes,
                                saldo_valor,
                                saldo_st,
                                saldo_valor_inicial
                        FROM diaria.saldo_projeto_fonte
                        JOIN diaria.projeto p
                        ON p.projeto_cd = id_saldo_projeto
                        JOIN diaria.fonte f
                        ON f.fonte_cd = id_saldo_fonte
                        WHERE saldo_st <> 2 
                        AND DATE_PART('YEAR', data_criacao) = '".$ano."'
                        AND saldo_mes = ".$mes;
    }
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        
    return $rsConsulta; 
}

function Consultar()
{    
    $ano         = date("Y");
    $codProjeto  = $_GET['codProjeto'];
    $codFonte    = $_GET['codFonte'];
    $sqlConsulta = "SELECT * 
                      FROM diaria.saldo_projeto_fonte
                      JOIN diaria.projeto p
                        ON p.projeto_cd = id_saldo_projeto
                      JOIN diaria.fonte f
                        ON f.fonte_cd = id_saldo_fonte 
                     WHERE id_saldo_projeto = ".$codProjeto." AND saldo_st <> 2 AND DATE_PART('YEAR', data_criacao) = '".$ano."' AND id_saldo_fonte ='".$codFonte."'";        
    $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);                    
    return $rsConsulta;
}

function Incluir($PaginaLocal)
{
    $codigoProjeto = $_POST['cmbProjeto'];
    $codigoFonte   = trim($_POST['cmbFonte']);
    $dataCriacao   = date("Y-m-d");        
    $ano           = date("Y");
    $sqlConsulta = "SELECT * FROM diaria.saldo_projeto_fonte WHERE id_saldo_projeto = ".$codigoProjeto." AND id_saldo_fonte ='".$codigoFonte."' AND DATE_PART('YEAR', data_criacao) = '".$ano."'";        
    $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
    $linha       = pg_fetch_assoc($rsConsulta);
    
    if($linha == '')
    {
        $controle = 0;        
        $indice   = 1;
        
        while($indice <= 12)
        {        
            if($_POST['mesSelecionado'.$indice] != null)
            {
                if($indice < 10)
                {
                    $mesSelecionado = '0'.$indice;
                }
                else
                {
                    $mesSelecionado = $indice;
                }            
            }

            if($_POST['saldoMes'.$indice] != null)
            {                
                $result = trim($_POST['saldoMes'.$indice]);            
                $pontos = array(",", ".");
                $result = str_replace($pontos, "", $result);                
                $result = substr($result, 0, -2);                
                $saldoMes[$controle] = $result;                
                
                $sqlInsere = "INSERT INTO diaria.saldo_projeto_fonte
                                          (id_saldo_projeto,id_saldo_fonte,saldo_mes,saldo_valor,saldo_st,data_criacao,saldo_valor_inicial)
                                   VALUES ($codigoProjeto,'$codigoFonte',$mesSelecionado,$saldoMes[$controle],0,'$dataCriacao',$saldoMes[$controle])";

                pg_query(abreConexao(),$sqlInsere);
                $controle ++;            
            }             
            $indice ++;
        }   
        echo "<script>window.location = '".$PaginaLocal."Inicio.php ';</script>";
    }
    else
    {
        echo "<script>
                 alert('Já existe um saldo cadastrado para junção deste projeto e fonte!');
                 return false;
             </script>";
    }
}

function Alterar($PaginaLocal)
{    
    $dataAlteracao = date("Y-m-d");           
    $codigoProjeto = $_POST['cmbProjeto'];
    $codigoFonte   = trim($_POST['cmbFonte']);  
    $ano           = date("Y");
    $sqlConsulta = "SELECT * FROM diaria.saldo_projeto_fonte WHERE id_saldo_projeto = ".$codigoProjeto." AND DATE_PART('YEAR', data_criacao) = '$ano' AND id_saldo_fonte ='".$codigoFonte."' ORDER BY saldo_mes";        
    $rsConsulta  = pg_query(abreConexao(),$sqlConsulta); 

    $controle  = 0;        
    $indice    = 1;

    while($indice <= 12)
    {        
        $linha = pg_fetch_assoc($rsConsulta);        
        
        if($_POST['saldoMes'.$indice] != null)
        {
            if($indice == $linha['saldo_mes'])
            {
                $result = trim($_POST['saldoMes'.$indice]);            
                $pontos = array(",", ".");
                $result = str_replace($pontos, "", $result);                
                $result = substr($result, 0, -2);                
                $saldoMes[$controle] = $result;
                $ano    = date("Y");
                if($saldoMes[$controle] != $linha['saldo_valor'])
                {
                    $sqlUpdate = "UPDATE diaria.saldo_projeto_fonte 
                                  SET saldo_valor = $saldoMes[$controle], data_atualizacao = '".$linha['data_criacao']."'
                                  WHERE id_saldo_projeto = $codigoProjeto AND id_saldo_fonte = '$codigoFonte' AND DATE_PART('YEAR', data_criacao) = '".$ano."' AND saldo_mes = $indice";                                           
                    pg_query(abreConexao(),$sqlUpdate);                                        
                }
            }
            $controle ++;
        }              
        $indice ++; 
    }
    echo "<script>window.location = '".$PaginaLocal."Inicio.php';</script>";    
}

function alterarStatus($PaginaLocal)
{
    $dataAlteracao = date("Y-m-d");
    $codigo        = $_GET['cod'];
    $statusNumero  = $_GET['status'];

    If ($statusNumero == 0)
    {  
        $statusNumero = 1;
    }
    Else
    {  
        $statusNumero = 0;
    }    
    $sqlAltera = "UPDATE diaria.fonte SET fonte_st = ".$statusNumero.", fonte_dt_alteracao = '".$dataAlteracao."' WHERE fonte_cd = '".$Codigo."' ";
    pg_query(abreConexao(),$sqlAltera);
    
    echo "<script>window.location = '".$PaginaLocal."Inicio.php ';</script>";
}

function Excluir($PaginaLocal)
{
    $codigoProjeto = $_POST['hdnCodProjeto'];
    $codigoFonte   = $_POST['hdnCodFonte'];  
    $ano           = date("Y");
    $sqlDelete = "DELETE FROM diaria.saldo_projeto_fonte WHERE id_saldo_projeto =".$codigoProjeto." AND DATE_PART('YEAR', data_criacao) = '$ano' AND id_saldo_fonte ='".$codigoFonte."'";    
    pg_query(abreConexao(),$sqlDelete);
    
    echo "<script>window.location = '".$PaginaLocal."Inicio.php ';</script>";    
}
?>
