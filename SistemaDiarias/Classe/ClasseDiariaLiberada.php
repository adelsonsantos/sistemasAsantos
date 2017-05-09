<?php
$Codigo = $_POST['cmbBeneficiario'];
$Justificativa	   = $_POST['txtJustificativaDiaria'];
$Datajustificativa  = date("Y-m-d");
$Horajustificativa  = date("H:i:s");
If ($AcaoSistema == "Liberar")
{   $sqlAltera = "UPDATE seguranca.usuario SET usuario_diaria=1  WHERE pessoa_id= ".$Codigo;
    pg_query(abreConexao(),$sqlAltera);
    $sqlAltera = "INSERT INTO diaria.diaria_liberacao(diaria_liberacao_justificativa,diaria_dt_liberacao,diaria_hr_liberacao, diaria_beneficiario) VALUES ('".$justificativa. "','".$Datajustificativa."','".$Horajustificativa."',".$Codigo.")";
     pg_query(abreConexao(),$sqlAltera);
}
?>
