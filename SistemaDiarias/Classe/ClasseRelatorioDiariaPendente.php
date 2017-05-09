<?php

    $vetData = explode("/", $_POST['txtDataComprova']);
    $Dia = $vetData[0];
	$Mes = $vetData[1];
	$Ano = $vetData[2];
    if(strlen($Dia)==1)
	{ $Dia = "0". $Dia;
    }
	if (strlen($Mes)==1)
	{	$Mes = "0" . $Mes;
    }
    $DataComprovacao=implode("/", array($Dia,$Mes,$Ano));

    $TipoRelatorio	= 	$_POST['TipoRelatorio'];
	$DataComprovacao	=	$DataComprovacao;

	if ($TipoRelatorio == 0)
    {
		$sqlConsulta = "SELECT p.pessoa_nm,d.diaria_numero,d.diaria_hr_chegada,diaria_processo,to_date(d.diaria_dt_chegada,'DD-MM-YYYY'),diaria_st FROM diaria.diaria d ,dados_unico.pessoa p  where p.pessoa_id = d.diaria_beneficiario and d.diaria_comprovada = 0 and d.diaria_st > 2 and to_date(d.diaria_dt_chegada,'DD-MM-YYYY') <= '".$DataComprovacao."'order by pessoa_nm ,to_date(d.diaria_dt_chegada,'DD-MM-YYYY')";
    }
	if ($TipoRelatorio  == 1)
	{	$sqlConsulta = "SELECT p.pessoa_nm,d.diaria_numero,d.diaria_hr_chegada,diaria_processo,to_date(d.diaria_dt_chegada,'DD-MM-YYYY'),diaria_st FROM diaria.diaria d ,dados_unico.pessoa p where p.pessoa_id = d.diaria_beneficiario and d.diaria_comprovada = 1 and (d.diaria_st > 2 AND d.diaria_st <= 5 )  and to_date(d.diaria_dt_chegada,'DD-MM-YYYY') <= '".$DataComprovacao. "' order by  pessoa_nm ,to_date(d.diaria_dt_chegada,'DD-MM-YYYY')";

    }
	$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
?>
