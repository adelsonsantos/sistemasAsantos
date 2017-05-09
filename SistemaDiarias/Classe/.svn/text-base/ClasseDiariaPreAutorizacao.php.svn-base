<?php
		//define o nome da pagina local para facilitar nos links
		
		if ($_GET['pagina'] == "")
		{ 
			$PaginaLocal = "SolicitacaoPreAutorizacao";
		}
		else 
		{
			$PaginaLocal = $_GET['pagina'];		
		}	

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;
		$_SESSION['OrigemPagina']= "SolicitacaoPreAutorizacao";

		
		$Roteiro = $_GET['roteiro'];
		$diaria_tipo_local = "Coordenadoria";
		$idCoordenadoria = $_SESSION['UsuarioCoordenadoria'];		
		
		if (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
		{
			if ($RetornoFiltro != "")
			{  
				$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 0 AND diaria_local_solicitacao = '$diaria_tipo_local' AND d.id_coordenadoria = $idCoordenadoria AND diaria_cancelada = 0 AND diaria_excluida = 0 AND (pessoa_nm ILIKE '%" .$RetornoFiltro. "%' OR diaria_numero ILIKE '%" .$RetornoFiltro. "%') ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
			} else{	
				$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 0 AND diaria_excluida = 0 AND diaria_local_solicitacao = '$diaria_tipo_local' AND d.id_coordenadoria = $idCoordenadoria AND  diaria_cancelada = 0 ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
			}
			$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
		//	echo $AcaoSistema; EXIT();
		}
/*
		ElseIf ($AcaoSistema == "autorizar")
        {
                    $Date=date("Y-m-d");
					$Codigo = $_GET['cod'];
                    $Time=date("H:i:s");
					$sqlAltera = "UPDATE diaria.diaria SET diaria_st = 0 WHERE diaria_id IN (" .$Codigo. ")";
					pg_query(abreConexao(),$sqlAltera);

					$sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);
					$sqlInsere = "INSERT INTO diaria.diaria_pre_autorizacao(diaria_id,diaria_pre_autorizacao_func,diaria_pre_autorizacao_func_exec,diaria_pre_autorizacao_dt,diaria_pre_autorizacao_hr) VALUES (" .$Codigo. ", " .$linha['funcionario_id'].", 1, '" .$Date."', '" .$Time. "')";
					//-#-LINHA ORIGINAL MODIFICADA POR Erinaldo(18/02/2011)-#-$sqlInsere = "INSERT INTO diaria.diaria_autorizacao (diaria_id, diaria_autorizacao_func, diaria_autorizacao_func_exec, diaria_autorizacao_dt, diaria_autorizacao_hr) VALUES (" .$Codigo. ", " .$linha['funcionario_id'].", 1, '" .$Date."', '" .$Time. "')";

					pg_query(abreConexao(),$sqlInsere);

                    echo "<script>window.location = 'SolicitacaoPreAutorizacaoInicio.php ';</script>";
        }
*/
 echo "<script>window.location = 'SolicitacaoPreAutorizacaoInicio.php ';</script>";		
?>
