<?php
include '../Include/Inc_Configuracao.php';
include_once 'IncludeLocal/Inc_FuncoesDiarias.php';


//define o nome da pagina local para facilitar nos links
$PaginaLocal = "Etapa";
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
    if ($RetornoFiltro != "")
    {
        
    }
    else
    {
        $sqlConsulta = "SELECT etapa_id, etapa_meta, etapa_codigo, etapa_ds, e.projeto_id, projeto_ds, e.fonte_id, fonte_ds, saldo_superior, saldo_medio, saldo_superior_inicio, saldo_medio_inicio
                          FROM diaria.etapa e
                          JOIN diaria.projeto p
                            ON e.projeto_id = p.projeto_cd
                          JOIN diaria.fonte f
                            ON e.fonte_id = f.fonte_cd
                         WHERE etapa_st = 0
                         ORDER BY etapa_codigo";
        
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        
        return $rsConsulta; 
    }
}

function Consultar()
{  
    $codigo = $_GET['etapa_id'];
    
    $sqlConsulta = "SELECT etapa_id, etapa_meta, etapa_codigo, etapa_ds, e.projeto_id, projeto_ds, e.fonte_id, fonte_ds, saldo_superior, saldo_medio, saldo_superior_inicio, saldo_medio_inicio
                          FROM diaria.etapa e
                          JOIN diaria.projeto p
                            ON e.projeto_id = p.projeto_cd
                          JOIN diaria.fonte f
                            ON e.fonte_id = f.fonte_cd
                         WHERE etapa_id = ".$codigo;
        
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        
        return $rsConsulta;
}

function Incluir($PaginaLocal)
{  
    $meta           = TrataSqlInj($_POST['txtMeta']);
    $etapaCodigo    = TrataSqlInj($_POST['txtCodigoEtapa']);
    $etapaDescricao = TrataSqlInj($_POST['txtEtapa']);
    $cmbProjeto     = $_POST['cmbProjeto'];
    $cmbFonte       = $_POST['cmbFonte'];
    $dataCriacao    = date('Y/m/d');
    
    $pontos              = array(",", ".");
    $resultSaldoSuperior = str_replace($pontos, "", $_POST['txtSaldoSuperior']);
    $resultSaldoMedio    = str_replace($pontos, "", $_POST['txtSaldoMedio']);
    $resultSaldoSuperior = substr($resultSaldoSuperior, 0, -2);
    $resultSaldoMedio    = substr($resultSaldoMedio, 0, -2);
    
    $sqlConsulta   = "SELECT * FROM diaria.etapa WHERE etapa_st_st = 2 AND ((etapa_codigo = '".$etapaCodigo."') OR (etapa_ds = '".$etapaDescricao."'))";
    $rsConsulta    = pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta = pg_fetch_assoc($rsConsulta);
    
    if($linhaConsulta == '')
    {
        $sqlInsere = "INSERT INTO diaria.etapa
                                (etapa_meta,etapa_codigo,etapa_ds,projeto_id,fonte_id,etapa_st,saldo_superior_inicio,saldo_medio_inicio,etapa_data_criacao)
                         VALUES ('$meta','$etapaCodigo','$etapaDescricao',$cmbProjeto,'$cmbFonte',0,$resultSaldoSuperior,$resultSaldoMedio,'$dataCriacao')";

        pg_query(abreConexao(),$sqlInsere);
    }
    else
    {
        echo "<script>
                 alert('Já existe uma Etapa cadastrada com esse código ou com essa descrição!');
                 return false;
             </script>";
    }
    
    echo "<script>window.location = '".$PaginaLocal."Inicio.php ';</script>";    
}

function Alterar($PaginaLocal)
{  
    $idEtapa        = $_POST['etapa_id'];    
    $meta           = TrataSqlInj($_POST['txtMeta']);
    $etapaCodigo    = TrataSqlInj($_POST['txtCodigoEtapa']);
    $etapaDescricao = TrataSqlInj($_POST['txtEtapa']);
    $cmbProjeto     = $_POST['cmbProjeto'];
    $cmbFonte       = $_POST['cmbFonte'];
    $dataAlteracao  = date('Y/m/d');        
    
    $pontos              = array(",", ".");
    $resultSaldoSuperior = str_replace($pontos, "", $_POST['txtSaldoSuperior']);
    $resultSaldoMedio    = str_replace($pontos, "", $_POST['txtSaldoMedio']);
    $resultSaldoSuperior = substr($resultSaldoSuperior, 0, -2);
    $resultSaldoMedio    = substr($resultSaldoMedio, 0, -2);
    
    $sqlConsulta   = "SELECT * FROM diaria.etapa WHERE etapa_st <> 2 AND etapa_id <> $idEtapa AND ((etapa_codigo = '".$etapaCodigo."') OR (etapa_ds = '".$etapaDescricao."'))";    
    $rsConsulta    = pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta = pg_fetch_assoc($rsConsulta);
    
    if($linhaConsulta == '')
    {
        $sqlUpdate = "UPDATE diaria.etapa
                         SET etapa_meta = '$meta',
                             etapa_codigo = '$etapaCodigo',
                             etapa_ds = '$etapaDescricao',
                             projeto_id = $cmbProjeto,
                             fonte_id = '$cmbFonte',
                             etapa_st = 0,
                             saldo_superior_inicio = $resultSaldoSuperior,
                             saldo_medio_inicio = $resultSaldoMedio,
                             etapa_data_atualizacao = '$dataAlteracao'
                       WHERE etapa_id = $idEtapa";
        
        pg_query(abreConexao(),$sqlUpdate);        
    }
    else
    {
        echo "<script type='text/javascript' language='javascript'>
                 alert('Já existe uma Etapa cadastrada com esse código ou com essa descrição!');
                 return false;
             </script>";
    }
    
    echo "<script>window.location = '".$PaginaLocal."Inicio.php ';</script>";
}

function alterarStatus($PaginaLocal)
{  

}

function Excluir($PaginaLocal)
{  
    $idEtapa = $_POST['etapa_id'];    
    $sqlExcluir = "UPDATE diaria.etapa
                         SET etapa_st = 2
                       WHERE etapa_id = $idEtapa";
    
    pg_query(abreConexao(),$sqlExcluir);
    
    echo "<script>window.location = '".$PaginaLocal."Inicio.php ';</script>";     
}
?>
