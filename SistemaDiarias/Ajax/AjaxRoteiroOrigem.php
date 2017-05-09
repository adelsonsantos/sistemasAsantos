<?php
include "../../Include/Inc_Configuracao.php";

$controle = $_POST['controle'];

echo f_ComboMunicipio("cmbRoteiroOrigemMunicipio$controle",$_POST['estado_id'],$_POST['municipio_id'])?>

