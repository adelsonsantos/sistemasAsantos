<?php
		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "SolicitacaoGestao";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;

		if (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
        {

					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 2 AND diaria_cancelada = 0 AND (pessoa_nm ILIKE '%" .$RetornoFiltro. "%' OR diaria_numero ILIKE '%" .$RetornoFiltro."%') ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
                    }
                    Else
					{	$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 2 AND diaria_cancelada = 0 ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
                    }

					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "empenhar")
        {


					$Codigo 		= $_POST['txtCodigo'];
					$Empenho        = $_POST['txtEmpenho'];
					$DataEmpenho    = $_POST['txtDataEmpenho'];
					$Processo       = $_POST['txtProcesso'];

					$sqlAltera = "UPDATE diaria.diaria SET diaria_st = 3, diaria_empenho = '" .$Empenho."', diaria_dt_empenho = '" .$DataEmpenho."', diaria_processo = '" .$Processo."' WHERE diaria_id = " .$Codigo;
					pg_query(abreConexao(),$sqlAltera);

                    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "imprimir")
        {

					$Codigo = $_GET['cod'];

					$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE (p.pessoa_id = pf.pessoa_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_id = ".$Codigo;
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    $linhaConsulta=pg_fetch_assoc($rsConsulta);

                    If($linhaConsulta)
                    {

						$Numero 		 = $linhaConsulta['diaria_numero'];
						$PessoaCodigo    = $linhaConsulta['pessoa_id'];
						$Beneficiario    = $linhaConsulta['diaria_beneficiario'];
						$DataPartida	 = $linhaConsulta['diaria_dt_saida'];
						$Nome            = $linhaConsulta['pessoa_nm'];
						$Matricula       = $linhaConsulta['funcionario_matricula'];
						$Escolaridade    = $linhaConsulta['nivel_escolar_id'];
						$CPF			 = $linhaConsulta['pessoa_fisica_cpf'];

						$HoraPartida	 = $linhaConsulta['diaria_hr_saida'];
						$DataChegada	 = $linhaConsulta['diaria_dt_chegada'];
						$HoraChegada	 = $linhaConsulta['diaria_hr_chegada'];

						$DiaSemanaPartida = diasemana($DataPartida);
						$DiaSemanaChegada = diasemana($DataChegada);

						$Desconto 		= $linhaConsulta['diaria_desconto'];
						$Qtde			= $linhaConsulta['diaria_qtde'];
						$ValorRef		= $linhaConsulta['diaria_valor_ref'];
						$Valor			= $linhaConsulta['diaria_valor'];
						$JustificativaFimSemana 	= $linhaConsulta['diaria_justificativa_fds'];
						$JustificativaFeriado  	= $linhaConsulta['diaria_justificativa_feriado'];
						$MeioTransporte			= $linhaConsulta['meio_transporte_id'];
						$TransporteObservacao	= $linhaConsulta['diaria_transporte_obs'];
						$Motivo			= $linhaConsulta['motivo_id'];
						$SubMotivo		= $linhaConsulta['sub_motivo_id'];
						$Descricao 		= $linhaConsulta['diaria_descricao'];
						$UnidadeCusto 	= $linhaConsulta['diaria_unidade_custo'];
						$Projeto 		= $linhaConsulta['projeto_cd'];
						$Acao 			= $linhaConsulta['acao_cd'];
						$Territorio 		= $linhaConsulta['territorio_cd'];
						$Fonte 			= $linhaConsulta['fonte_cd'];
						$Processo 		= $linhaConsulta['diaria_processo'];
						$Empenho 		= $linhaConsulta['diaria_empenho'];
						$DataEmpenho 	= $linhaConsulta['diaria_dt_empenho'];

						If ($Desconto == "N")
                        {  $Desconto = "N&atilde;o";

                        }
                        Else
                        {  $Desconto = "Sim";

                        }

						$sqlConsulta = "SELECT est_organizacional_centro_custo_num, est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = " .$UnidadeCusto;
						$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                        $linhaConsulta=pg_fetch_assoc($rsConsulta);

                        $UnidadeCustoNumero = $linhaConsulta['est_organizacional_centro_custo_num'];
						$UnidadeCustoSigla = $linhaConsulta['est_organizacional_sigla'];
						$UnidadeCustoNome = $linhaConsulta['est_organizacional_ds'];

						$sqlConsulta = "SELECT nivel_escolar_ds FROM dados_unico.nivel_escolar WHERE nivel_escolar_id = " .$Escolaridade;
						$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                        $linhaConsulta=pg_fetch_assoc($rsConsulta);

                        $EscolaridadeNome = $linhaConsulta['nivel_escolar_ds'];

						$TemporarioValor = False;
						$PermanenteValor = False;

						$sql4 = "SELECT cargo_temporario, cargo_permanente FROM dados_unico.funcionario WHERE funcionario_id = " .$Beneficiario;
						$rs4 = pg_query(abreConexao(),$sql4);

                        $linhars4=pg_fetch_assoc($rs4);

                        If (($linhars4['cargo_temporario']!= 0)|| ($linhars4['cargo_temporario']!= ""))
                        {

							$CargoTemporario = $linhars4['cargo_temporario'];

							$sql1 = "SELECT classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl WHERE (ca.classe_id = cl.classe_id) AND cargo_id = " .$CargoTemporario;
							$rs1 = pg_query(abreConexao(),$sql1);

                            $linhars1=pg_fetch_assoc($rs1);

                            $TemporarioValor = True;

                        }

						If (($linhqrs4['cargo_permanente'] != 0) && ($linhars4['cargo_permanente']!= ""))
                        {

							$CargoPermanente = $linhars4['cargo_permanente'];

							$sql2 = "SELECT classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl WHERE (ca.classe_id = cl.classe_id) AND cargo_id = " .$CargoPermanente;
							$rs2 = pg_query(abreConexao(),$sql2);

                            $linhars2=pg_fetch_assoc($rs2);

                            $PermanenteValor = True;

                        }

						If (($TemporarioValor)&&($PermanenteValor))
                        {
							If (((int)($linhars1['classe_valor'])) > ((int)($linhars2['classe_valor'])))
                            {
								$Cargo = $CargoTemporario;
                            }
							Else
							{	$Cargo = $CargoPermanente;

                            }
                        }
						ElseIf ($TemporarioValor)
                        {
							$Cargo = $CargoTemporario;
                        }
						ElseIf ($PermanenteValor)
                        {
							$Cargo = $CargoPermanente;

                            }



						$sql3 = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = " .$Cargo;
						$rsConsulta = pg_query(abreConexao(),$sql3);

                        $linhaConsulta=pg_fetch_assoc($rsConsulta);

                        $CargoNome = $linhaConsulta['cargo_ds'];

						$sqlEndereco = "SELECT * FROM dados_unico.endereco e, dados_unico.municipio m WHERE (e.municipio_cd = m.municipio_cd) AND pessoa_id = " .$PessoaCodigo;
						$rsEndereco = pg_query(abreConexao(),$sqlEndereco);

                        $linharsEndereco=pg_fetch_assoc($rsEndereco);

                        If ($linhaEndereco)
                        {
							$Endereco = $linharsEndereco['endereco_ds'].", " .$linharsEndereco['endereco_num']." " .$linharsEndereco['endereco_complemento'].", " .$linharsEndereco['endereco_bairro'].", " .$linharsEndereco['municipio_ds']." - " .$linharsEndereco['estado_uf'];
                        }
                        Else
						{	$Endereco = "";
                        }

						$sqlDadosBancarios = "SELECT * FROM dados_unico.dados_bancarios db, dados_unico.banco b WHERE (db.banco_id = b.banco_id) AND pessoa_id = " .$PessoaCodigo;
						$rsDadosBancarios = pg_query(abreConexao(),$sqlDadosBancarios);

                        $linharsDadosBancarios=pg_fetch_assoc($rsDadosBancarios);

                        If($linhaDadosBancarios)
                        {

							$Banco	 = $linharsDadosBancarios['banco_cd'];
							$Agencia = $linharsDadosBancarios['dados_bancarios_agencia'];
							$Conta	 = $linharsDadosBancarios['dados_bancarios_conta'];
                        }
						Else
                        {

							$Banco	= "";
							$Agencia = "";
							$Conta	= "";

                        }

						$sqlTransporte = "SELECT meio_transporte_ds FROM diaria.meio_transporte WHERE meio_transporte_id = " .$MeioTransporte;
						$rsTransporte = pg_query(abreConexao(),$sqlTransporte);

                        $linharsTransporte=pg_fetch_assoc($rsTransporte);

                        $MeioTransporte = $linharsTransporte['meio_transporte_ds'];

						$sqlConsulta = "SELECT motivo_ds FROM diaria.motivo WHERE motivo_id = " .$Motivo;
						$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                        $linhaConsulta=pg_fetch_assoc($rsConsulta);

                        $Motivo = $linhaConsulta['motivo_ds'];

						$sqlConsulta = "SELECT sub_motivo_ds FROM diaria.sub_motivo WHERE sub_motivo_id = " .$SubMotivo;
						$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                        $linhaConsulta=pg_query(abreConexao(),$sqlConsulta);

                        $SubMotivo = $linhaConsulta['sub_motivo_ds'];
                    }
        }
?>
