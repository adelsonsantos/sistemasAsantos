<?php
include "../../Include/Inc_Configuracao.php";

$codigo = $_POST['diariaID'];
$ped    = $_POST['ped'];

if(($ped == 1))
{
    $sqlUpdate = "UPDATE diaria.diaria
                     SET pedido_empenho = 1
                   WHERE diaria_id = ".$codigo;
    pg_query(abreConexao(),$sqlUpdate);
    echo "1";
}
else
{
    $sqlUpdate = "UPDATE diaria.diaria
                     SET pedido_empenho = 2
                   WHERE diaria_id = ".$codigo;
    pg_query(abreConexao(),$sqlUpdate);
    echo "2";
}
?>
