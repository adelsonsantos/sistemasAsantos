<?php
include "../../Include/Inc_Configuracao.php";

$acao     = $_POST['acao'];
$controle = $_POST['controle'];

if($acao == 'limpar')
{
    echo f_ComboMunicipio("cmbRoteiroDestinoMunicipio$controle",'','');    
}
?>
