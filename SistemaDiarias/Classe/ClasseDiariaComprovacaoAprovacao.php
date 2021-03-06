<?php
//define o nome da pagina local para facilitar nos links

if ($_GET['pagina'] == "") 
{
    $PaginaLocal = "ComprovacaoAprovacao";
} 
else 
{
    $PaginaLocal = $_GET['pagina'];
}
//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

If (($AcaoSistema == "buscar") || ($AcaoSistema == "")) 
{
    if ($_SESSION['Administrador'] != 1) 
    {
        If ($RetornoFiltro != "") 
        {
            $sqlConsulta = "SELECT * 
                            FROM diaria.diaria d
                            JOIN dados_unico.pessoa p
                              ON d.diaria_beneficiario = p.pessoa_id
                            JOIN diaria.diaria_comprovacao dc 
                              ON d.diaria_id = dc.diaria_id 
                           WHERE diaria_st = 5
                             AND diaria_excluida = 0
                             AND diaria_solicitante = ".$_SESSION['UsuarioCodigo']."
                             /*AND id_coordenadoria 
                                 IN (SELECT id_coordenadoria
                                      FROM seguranca.tipo_usuario tu
                                      JOIN seguranca.usuario_tipo_usuario utu
                                      ON tu.tipo_usuario_id = utu.tipo_usuario_id
                                      JOIN seguranca.usuario u
                                      ON utu.pessoa_id = u.pessoa_id
                                      WHERE tipo_usuario_ds IN ('Autorizador','Pré-Autorizador','Solicitante')
                                      AND u.pessoa_id = " .$_SESSION['UsuarioCodigo']. ")*/
                             AND (pessoa_nm ILIKE '%".$RetornoFiltro."%' OR diaria_numero ILIKE '%".$RetornoFiltro."%') 
                        ORDER BY diaria_numero";
        } 
        Else 
        {
            $sqlConsulta = "SELECT * 
                            FROM diaria.diaria d
                            JOIN dados_unico.pessoa p
                              ON d.diaria_beneficiario = p.pessoa_id
                            JOIN diaria.diaria_comprovacao dc 
                              ON d.diaria_id = dc.diaria_id 
                           WHERE diaria_st = 5
                             AND diaria_excluida = 0
                             AND diaria_solicitante = ".$_SESSION['UsuarioCodigo']."
                             /*AND id_coordenadoria 
                                 IN (SELECT id_coordenadoria
                                      FROM seguranca.tipo_usuario tu
                                      JOIN seguranca.usuario_tipo_usuario utu
                                      ON tu.tipo_usuario_id = utu.tipo_usuario_id
                                      JOIN seguranca.usuario u
                                      ON utu.pessoa_id = u.pessoa_id
                                      WHERE tipo_usuario_ds IN ('Autorizador','Pré-Autorizador','Solicitante')
                                      AND u.pessoa_id = " .$_SESSION['UsuarioCodigo']. ") */      
                        ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
        }
        //var_dump($sqlConsulta); exit;
    } 
    else 
    {
        If ($RetornoFiltro != "") 
        {
            $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_comprovacao dc WHERE (d.diaria_id = dc.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 5 AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') ORDER BY diaria_numero";
        } 
        Else 
        {            
            $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_comprovacao dc WHERE (d.diaria_id = dc.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_excluida = 0 AND (diaria_st = 5 ) ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
        }
    }
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
}
/* * ***************** Ação Aprovar Comprovação ************************** */ 
ElseIf ($AcaoSistema == "aprovar") 
{
    $Date   = date("Y-m-d");
    $Codigo = $_GET['cod'];
    $Time   = date("H:i:s");
    $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 10 WHERE diaria_id = " . $Codigo;
    pg_query(abreConexao(), $sqlAltera);

    $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    $linhaConsulta = pg_fetch_assoc($rsConsulta);
    $sqlInsere = "INSERT INTO diaria.diaria_aprovacao (diaria_id, diaria_aprovacao_func, diaria_aprovacao_func_exec, diaria_aprovacao_dt, diaria_aprovacao_hr) VALUES (" . $Codigo . ", " . $linhaConsulta['funcionario_id'] . ", 1, '" . $Date . "', '" . $Time . "')";

    pg_query(abreConexao(), $sqlInsere);
    echo "<script>alert(\"Aprovação de Comprovação realizada com Sucesso.!!!\");</script>";
    echo "<script>window.location = '".$PaginaLocal."Inicio.php ';</script>";
}
?>
