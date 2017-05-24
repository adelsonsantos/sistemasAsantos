<?php
$sqlACP = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_centro_custo = 1 and est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
$rsACP = pg_query(abreConexao(),$sqlACP);

If ($AcaoSistema == "incluir")
{
    $diretoria   = $_GET['diretoria'];
    $autorizador = $_GET['autorizador'];

    $sqlInsere = "INSERT INTO diaria.autorizador_acp VALUES (" .$diretoria. ", " .$autorizador. ")";
    pg_query(abreConexao(),$sqlInsere);

    echo "<script>window.location = 'AssociarAutorizador.php?';</script>";
}
elseif($AcaoSistema == "excluir")
{
    $diretoria   = $_GET['diretoria'];
    $autorizador = $_GET['autorizador'];

    $sqlDelete = "DELETE FROM diaria.autorizador_acp 
                        WHERE est_organizacional_id = " .$diretoria. " 
                          AND pessoa_id = ".$autorizador;
    pg_query(abreConexao(),$sqlDelete);

    echo "<script>window.location = 'AssociarAutorizador.php?';</script>";
}
?>
