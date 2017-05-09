<?php
include "../../Include/Inc_Configuracao.php";
include "../IncludeLocal/Inc_FuncoesDiarias.php";

$projetoId = $_POST['projetoId'];
$fonteId   = $_POST['fonteId'];

$sqlConsulta = "SELECT * FROM diaria.etapa
                 WHERE projeto_id = $projetoId
                   AND fonte_id = '$fonteId'";

$rsConsulta  = pg_query(abreConexao(), $sqlConsulta);
$linhaEtapa  = pg_fetch_assoc($rsConsulta);

if($linhaEtapa)
{
    echo f_ComboEtapas('cmbEtapa','783', '','','114',$projetoId,$fonteId);
}
else
{
    echo '';
}
?>
