<?php


        $Codigo = $_GET['cod'];

        $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf, diaria.diaria_motivo dm WHERE (d.diaria_id = dm.diaria_id) AND (p.pessoa_id = pf.pessoa_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

        $linhaConsulta=pg_fetch_assoc($rsConsulta);

        If($linhaConsulta)
        {
            $Numero 				= $linhaConsulta['diaria_numero'];
            $PessoaCodigo  		 	= $linhaConsulta['pessoa_id'];
            $Beneficiario   		        = $linhaConsulta['diaria_beneficiario'];
            $DataPartida			= $linhaConsulta['diaria_dt_saida'];
            $Nome           		        = $linhaConsulta['pessoa_nm'];
            $Matricula      		        = $linhaConsulta['funcionario_matricula'];
            $Escolaridade  			= $linhaConsulta['nivel_escolar_id'];
            $CPF				= $linhaConsulta['pessoa_fisica_cpf'];
            $HoraPartida	 		= $linhaConsulta['diaria_hr_saida'];
            $DataChegada	 		= $linhaConsulta['diaria_dt_chegada'];
            $HoraChegada	 		= $linhaConsulta['diaria_hr_chegada'];
	    $DiaSemanaPartida 		        = diasemana($DataPartida);
	    $DiaSemanaChegada 		        = diasemana($DataChegada);
            $Desconto 				= $linhaConsulta['diaria_desconto'];
            $Qtde				= $linhaConsulta['diaria_qtde'];
            $ValorRef				= $linhaConsulta['diaria_valor_ref'];
            $Valor				= $linhaConsulta['diaria_valor'];
            $JustificativaFimSemana             = $linhaConsulta['diaria_justificativa_fds'];
            $JustificativaFeriado  	        = $linhaConsulta['diaria_justificativa_feriado'];
            $MeioTransporte			= $linhaConsulta['meio_transporte_id'];
            $TransporteObservacao	        = $linhaConsulta['diaria_transporte_obs'];
            $Motivo				= $linhaConsulta['motivo_id'];
            $SubMotivo				= $linhaConsulta['sub_motivo_id'];
            $Descricao 				= $linhaConsulta['diaria_descricao'];
            $UnidadeCusto 			= $linhaConsulta['diaria_unidade_custo'];
            $Projeto 				= $linhaConsulta['projeto_cd'];
            $Acao 				= $linhaConsulta['acao_cd'];
            $Territorio 			= $linhaConsulta['territorio_cd'];
            $Fonte 				= $linhaConsulta['fonte_cd'];
            $Processo 				= $linhaConsulta['diaria_processo'];
            $Empenho 				= $linhaConsulta['diaria_empenho'];
            $DataEmpenho 			= $linhaConsulta['diaria_dt_empenho'];
            $Convenio                           = $linhaConsulta['ger_id'];

            if ($Convenio == "0")
            {
                //Verifica qual a GER do Projeto.

                 $sqlProjeto = "SELECT * FROM diaria.projeto where projeto_cd = ".$Projeto;
                 $rsProjeto = pg_query(abreConexao(),$sqlProjeto);

                 $linharsProjeto=pg_fetch_assoc($rsProjeto);

                 if($linharsProjeto)
                 {
                  $Ger_Id = $linharsProjeto['ger_id'];
                 }
            }else{
               $Ger_Id = $Convenio;
            }
            //Seleciona o tipo de GER para Deposito

            $sqlGER = "SELECT * FROM diaria.ger where ger_id = ".$Ger_Id;
            $rsGER = pg_query(abreConexao(),$sqlGER);

            $sqlComprovacao = "SELECT * FROM diaria.diaria_comprovacao WHERE diaria_id = ".$Codigo;
            $rsComprovacao = pg_query(abreConexao(),$sqlComprovacao);

            $linharsComprovacao= pg_fetch_assoc($rsComprovacao);
			
			
            If ($linharsComprovacao['diaria_comprovacao_saldo_tipo']== "D")
            {
                // Altera o valor do banco de dados no momento da impress�o da GER. para positivo. 
				
		$SaldoPagar = (-1)* (str_replace(",",".",($linharsComprovacao['diaria_comprovacao_saldo'])));
                $SaldoReceber = "&nbsp;";
            }
            ElseIf ($linharsComprovacao['diaria_comprovacao_saldo_tipo']== "C")
            {
                $SaldoReceber =(str_replace(",",".",($linharsComprovacao['diaria_comprovacao_saldo'])));
                $SaldoPagar = "&nbsp;";
            }
            Else
            {   $SaldoPagar = "&nbsp;";
                $SaldoReceber = "&nbsp;";
            }

            If ($linharsComprovacao['diaria_comprovacao_qtde']== "")
            {
               $QtdeComprovacao = $Qtde;
            }
            If ($linharsComprovacao['diaria_comprovacao_valor']== "")
            {    $ValorComprovacao = $Valor;

            }
            If ($Desconto == "N")
            {  $Desconto = "N&atilde;o";

            }
            Else
            {  $Desconto = "Sim";

            }

            $sqlConsulta = "SELECT est_organizacional_centro_custo_num, est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = ".$UnidadeCusto;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            $linhaConsulta=pg_fetch_assoc($rsConsulta);

            $UnidadeCustoNumero = $linhaConsulta['est_organizacional_centro_custo_num'];
            $UnidadeCustoSigla = $linhaConsulta['est_organizacional_sigla'];
            $UnidadeCustoNome = $linhaConsulta['est_organizacional_ds'];

            $sqlConsulta = "SELECT nivel_escolar_ds FROM dados_unico.nivel_escolar WHERE nivel_escolar_id = ".$Escolaridade;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            $EscolaridadeNome = $linhaConsulta['nivel_escolar_ds'];

            $sqlEndereco = "SELECT * FROM dados_unico.endereco e, dados_unico.municipio m WHERE (e.municipio_cd = m.municipio_cd) AND pessoa_id = ".$PessoaCodigo;

			$rsEndereco = pg_query(abreConexao(),$sqlEndereco);

            $linhaEndereco=pg_fetch_assoc($rsEndereco);
            
			$Endereco 		= $linhaEndereco['endereco_ds'].", ".$linhaEndereco['endereco_num']." ".$linhaEndereco['endereco_complemento'];

			
            $sqlDadosBancarios = "SELECT * FROM dados_unico.dados_bancarios db, dados_unico.banco b WHERE (db.banco_id = b.banco_id) AND pessoa_id = ".$PessoaCodigo;
            $rsDadosBancarios = pg_query(abreConexao(),$sqlDadosBancarios);

            $linharsDadosBancarios=pg_fetch_assoc($rsDadosBancarios);

            $Banco	= $linharsDadosBancarios['banco_cd'];
            $Agencia = $linharsDadosBancarios['dados_bancarios_agencia'];
            $Conta	= $linharsDadosBancarios['dados_bancarios_conta'];

            $sqlTransporte = "SELECT meio_transporte_ds FROM diaria.meio_transporte WHERE meio_transporte_id = ".$MeioTransporte;
            $rsTransporte = pg_query(abreConexao(),$sqlTransporte);

            $linharsTransporte=pg_fetch_assoc($rsTransporte);
            $MeioTransporte = $linharsTransporte['meio_transporte_ds'];

            $sqlConsulta = "SELECT motivo_ds FROM diaria.motivo WHERE motivo_id = ".$Motivo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            $linhaConsulta=pg_fetch_assoc($rsConsulta);

            $Motivo = $linhaConsulta['motivo_ds'];

            $sqlConsulta = "SELECT sub_motivo_ds FROM diaria.sub_motivo WHERE sub_motivo_id = ".$SubMotivo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            $linhaConsulta=pg_fetch_assoc($rsConsulta);

            $SubMotivo = $linhaConsulta['sub_motivo_ds'];

        }

?>
