<?php
$sqlACP = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_centro_custo = 1 ORDER BY est_organizacional_sigla";
$rsACP = pg_query(abreConexao(),$sqlACP);

If ($AcaoSistema == "alterar")
{ 
    $QtdeACP = $_GET['i'];

    For ($i = 1; $i<=$QtdeACP;$i++)
    {
        $Pessoa = $_POST["cmbAutorizador".$i];
        $Unidade = $_POST["txtUnidade".$i];        
        $sql = "SELECT * FROM diaria.autorizador_acp WHERE est_organizacional_id = " .$Unidade;
        $rs  = pg_query(abreConexao(),$sql);
        $linhars = pg_fetch_assoc($rs);

        If($linhars)
        {
            $sqlAltera = "UPDATE diaria.autorizador_acp SET pessoa_id = " .$Pessoa. " WHERE est_organizacional_id = " .$Unidade;
            pg_query(abreConexao(),$sqlAltera);
        }
        Else
        {
            If ($Pessoa != 0)
            {
                $sqlInsere = "INSERT INTO diaria.autorizador_acp VALUES (" .$Unidade. ", " .$Pessoa. ")";
                pg_query(abreConexao(),$sqlInsere);
            }
        }
   }
   echo "<script>window.location = 'AssociarAutorizador.php?sucesso=1';</script>";
}   
?>
