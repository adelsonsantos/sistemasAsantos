<?php
		//define o link padrao para as paginas
		// Estou passando o endereço da página para evitar erro Temporáriamente. 
		if ($_GET['pagina'] == "")
		{ 
			$PaginaLocal = "SolicitacaoConsultaGlobal";		
		}
		else 
		{
			$PaginaLocal = $_GET['pagina'];		
		}	
			If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {

					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_excluida = 0 AND (pessoa_nm ILIKE '%".$RetornoFiltro. "%' OR diaria_numero ILIKE '%" .$RetornoFiltro. "%') ORDER BY diaria_numero";
                    }
                    Else
					{	$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_excluida = 0 ORDER BY diaria_numero";
                    }

					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "consultar")
        {

					$Codigo = $_GET['cod'];

					$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_motivo dm, diaria.diaria_comprovacao dc, diaria.diaria_financeiro df WHERE (d.diaria_id = df.diaria_id) AND (d.diaria_id = dc.diaria_id) AND (d.diaria_id = dm.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linhaConsulta=pg_fetch_assoc($rsConsulta);
					
					If(!$linhaConsulta){
					
					$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_motivo dm, diaria.diaria_comprovacao dc  WHERE (d.diaria_id = dc.diaria_id) AND (d.diaria_id = dm.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
					
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linhaConsulta=pg_fetch_assoc($rsConsulta);
					
					}
					
					if(!$linhaConsulta){
        $sqlConsulta = "SELECT * FROM diaria.diaria d,dados_unico.funcionario f,dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id)AND d.diaria_id =" . $Codigo;

        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        $linhaConsulta = pg_fetch_assoc($rsConsulta);
    }
					
                    If($linhaConsulta)
                    {
						$Numero 		= $linhaConsulta['diaria_numero'];
						$Solicitante    = $linhaConsulta['diaria_solicitante'];
						$Beneficiario   = $linhaConsulta['diaria_beneficiario'];
						$Nome           = $linhaConsulta['pessoa_nm'];

						$HoraPartida	 = $linhaConsulta['diaria_hr_saida'];
						$DataPartida	 = $linhaConsulta['diaria_dt_saida'];
						$DataChegada	 = $linhaConsulta['diaria_dt_chegada'];
						$HoraChegada	 = $linhaConsulta['diaria_hr_chegada'];

						$HoraPartidaEfetiva = $linhaConsulta['diaria_comprovacao_hr_saida'];
						$DataPartidaEfetiva = $linhaConsulta['diaria_comprovacao_dt_saida'];
						$DataChegadaEfetiva = $linhaConsulta['diaria_comprovacao_dt_chegada'];
						$HoraChegadaEfetiva = $linhaConsulta['diaria_comprovacao_hr_chegada'];

						$DataLiquidacao = $linhaConsulta['diaria_financeiro_dt_obrigacao'];
						$HoraLiquidacao = $linhaConsulta['diaria_financeiro_hr_obrigacao'];

						$DataExecucao = $linhaConsulta['diaria_financeiro_dt_execucao'];

						$DataCriacao 	= $linhaConsulta['diaria_dt_criacao'];
						$HoraCriacao 	= $linhaConsulta['diaria_hr_criacao'];
						$DataComprovacao = $linhaConsulta['diaria_comprovacao_dt'];
						$HoraComprovacao = $linhaConsulta['diaria_comprovacao_hr'];



     					$DiaSemanaPartida = diasemana($DataPartida);
      					$DiaSemanaChegada = diasemana($DataChegada);


						$JustificativaFimSemana = $linhaConsulta['diaria_justificativa_fds'];
						$JustificativaFeriado  	= $linhaConsulta['diaria_justificativa_feriado'];
						$MeioTransporte			= $linhaConsulta['meio_transporte_id'];
						$TransporteObservacao 	= $linhaConsulta['diaria_transporte_obs'];
						$RoteiroComplemento		= $linhaConsulta['diaria_roteiro_complemento'];

						$Desconto 		= $linhaConsulta['diaria_desconto'];
						$Qtde			= $linhaConsulta['diaria_qtde'];
						$Valor			= $linhaConsulta['diaria_valor'];
						$ValorRef	 	= $linhaConsulta['diaria_valor_ref'];
						$Motivo			= $linhaConsulta['motivo_id'];
						$SubMotivo		= $linhaConsulta['sub_motivo_id'];
						$Descricao 		= $linhaConsulta['diaria_descricao'];
						$UnidadeCusto 	= $linhaConsulta['diaria_unidade_custo'];
						$Projeto 		= $linhaConsulta['projeto_cd'];
						$Acao 			= $linhaConsulta['acao_cd'];
						$Territorio 	= $linhaConsulta['territorio_cd'];
						$Fonte 			= $linhaConsulta['fonte_cd'];
						$Status 		= $linhaConsulta['diaria_st'];
						$DataCriacao 	= $linhaConsulta['diaria_dt_criacao'];
						$HoraCriacao 	= $linhaConsulta['diaria_hr_criacao'];
						$Processo 		= $linhaConsulta['diaria_processo'];
						$Empenho 		= $linhaConsulta['diaria_empenho'];
						$DataEmpenho 	= $linhaConsulta['diaria_dt_empenho'];
						$RoteiroComplemento = $linhaConsulta['diaria_roteiro_complemento'];
						$Resumo         = $linhaConsulta['diaria_comprovacao_resumo'];
						
						$DataCriacao = f_FormataData($DataCriacao);
						$diaria_comprovacao_saldo_tipo  = $linhaConsulta['diaria_comprovacao_saldo_tipo'];  
						$diaria_comprovacao_saldo       = $linhaConsulta['diaria_comprovacao_saldo']; 
						// Corrigir o sinal .. 
						$diaria_comprovacao_saldo 			= str_replace(".","",$diaria_comprovacao_saldo);  
						$diaria_comprovacao_saldo 			= str_replace(",",".",$diaria_comprovacao_saldo);  
						if ($diaria_comprovacao_saldo < 0) 
						{
						$diaria_comprovacao_saldo = $diaria_comprovacao_saldo*(-1);
						} 
						
						$Complemento = $linhaConsulta['diaria_comprovacao_complemento'];

						If ($Complemento == "1")
                        {
							$ComplementoJustificativa = $linhaConsulta['diaria_comprovacao_complemento_justificativa'];
                        }


						If ($Desconto == "N")
                        {
							$Desconto = "N&atilde;o";
							$DescontoMarcado = "";
                        }
						Else
						{	$Desconto = "Sim";
							$DescontoMarcado = "checked";
                        }

						If ($AlterarRoteiro == 0)
                        {

								$sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$Codigo;
								$rsRoteiro = pg_query(abreConexao(),$sqlRoteiro);

                                $qtdDeRegistro= pg_fetch_row($rsRoteiro);
                                $Contador =count($qtdDeRegistro);
                                $i =1;

                                While($linharsRoteiro=pg_fetch_assoc($rsRoteiro))
                                {
                                        $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_origem'];
                                        $rsRoteiroOrigem = pg_query(abreConexao(),$sqlRoteiroOrigem);
                                        $linharsRoteiroOrigem=pg_fetch_assoc($rsRoteiroOrigem);

                                        $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_destino'];
                                        $rsRoteiroDestino = pg_query(abreConexao(),$sqlRoteiroDestino);
                                        $linharsRoteiroDestino=pg_fetch_assoc($rsRoteiroDestino);

                                        If ($i == 1)
                                        {  $Inicio = $linharsRoteiroOrigem['municipio_ds']. "(".$linharsRoteiroOrigem['estado_uf'].")" ." / ".$linharsRoteiroDestino['municipio_ds']. "(".$linharsRoteiroDestino['estado_uf']. ")";
                                        }
                                        Elseif (($i != 1) && ($i < $Contador))
                                        {
                                        $Meio = " / ".$linharsRoteiroOrigem['municipio_ds']. "(".$linharsRoteiroOrigem['estado_uf'].")" . " / ".$linharsRoteiroDestino['municipio_ds']. "(" .$linharsRoteiroDestino['estado_uf'].")";

                                        }
                                        Elseif ($i == $Contador)
                                        {	$Final = " / ".$linharsRoteiroDestino['municipio_ds'] . "(".$linharsRoteiroDestino['estado_uf'] . ")";
                                        }

                                        $i = $i+1;
                                }

                            $Roteiro = $Inicio.$Meio.$Final;
                        }
                    }
        }

?>
