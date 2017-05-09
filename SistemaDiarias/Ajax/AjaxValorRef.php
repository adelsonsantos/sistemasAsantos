<?php
include "../../Include/Inc_Configuracao.php";

$CodBeneficiario = $_POST['funcionario_id'];
$DataPartida     = $_POST['DataPartida'];

If ($CodBeneficiario != "0") 
{
    f_ValorReferencia($CodBeneficiario,$DataPartida);
}
	
?>