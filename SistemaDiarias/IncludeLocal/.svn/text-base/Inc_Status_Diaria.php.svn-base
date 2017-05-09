<?php
	switch ($Status)
	{
		case 100:
			$StatusNome = "Pré-Autorização"; // Modificado por Erinaldo em 18/02/2011
			break;	
		case 0:
			$StatusNome = "Autorização";
			break;
		case 1:
			$StatusNome = "Aprova&ccedil;&atilde;o";
			break;
		case 2:
			$StatusNome = "Empenho";
			break;
		case 3:
			$StatusNome = "Execu&ccedil;&atilde;o";
			break;
		case 4:
			$StatusNome = "Comprova&ccedil;&atilde;o";
			break;
		case 5:
			$StatusNome = "Aprova&ccedil;&atilde;o de Comprova&ccedil;&atilde;o";
			break;
		case 6:
			$StatusNome = "Aguardando Arquivamento";
			break;
		case 7:
			$StatusNome = "Arquivada";
			break;
	} 
 
	if (($linha['diaria_devolvida'] == "1") or ($diaria_devolvida == "1"))
	{
		$StatusNome .= "<br/>(Devolvida)";

		$sqlConsultaMotivoDevolucao = "SELECT diaria_devolucao_ds, motivo_ds FROM diaria.diaria_devolucao d, diaria.motivo m WHERE (d.motivo_id = m.motivo_id) AND diaria_id = " .$Codigo. " ORDER BY diaria_devolucao_id DESC LIMIT 1";
		$rsConsultaMotivoDevolucao = pg_query(abreConexao(),$sqlConsultaMotivoDevolucao);
		$linhaMotivo=pg_fetch_assoc($rsConsultaMotivoDevolucao);
		if($linhaMotivo)
		{
			if ($linhaMotivo['diaria_devolucao_ds'] != "")
			{
				$labelDevolucao = $linhaMotivo['diaria_devolucao_ds'];
			}

			$MotivoDevolucao = $linhaMotivo['motivo_ds'];
		}
  }

	if ($linha['diaria_cancelada'] == 1)
	{
		$StatusNome .= "<br/>(Cancelada)";
	}

	/*
	'*****************************************************************************
	' Alterado por Rodolfo em 15/09/2008
	' SolicitaÃ§Ã£o da DA - ComprovaÃ§Ã£o
	'*****************************************************************************
	*/

	if (($linha['diaria_comprovada'] == 1) &&  ($Status =="3" ))
	{
		$StatusNome =  $StatusNome." (Comprovada) ".$comprovada ;
	}
	if ($diaria_excluida == 1)
	{
		$StatusNome = "(Exclu&iacute;­da)";
	}

?>
