X<?php


		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Acao";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = false;



		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {
            If ($RetornoFiltro != "")
            {
                $sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.acao ac, seguranca.sistema si WHERE (ac.secao_id = se.secao_id) AND (se.sistema_id = si.sistema_id) AND acao_st <> 2 AND acao_id <> 0 AND acao_ds ILIKE '%".$RetornoFiltro. "%' ORDER BY UPPER(sistema_nm), UPPER(secao_ds), UPPER(acao_ds)";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.acao ac, seguranca.sistema si WHERE (ac.secao_id = se.secao_id) AND (se.sistema_id = si.sistema_id) AND acao_st <> 2 AND acao_id <> 0 ORDER BY UPPER(sistema_nm), UPPER(secao_ds), UPPER(acao_ds)";
            }

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {
            $strDataCriacao = date("Y-m-d");
            $numSistema		= $_POST['cmbSistema'];
            $numSecao		= $_POST['cmbSecao'];
            $strDescricao	= trim($_POST['txtDescricao']);
            $strURL			= strtolower(trim($_POST['txtURL']));

            $sqlConsulta = "SELECT acao_id FROM seguranca.acao WHERE acao_st <> 2 AND UPPER(acao_ds) = '".strtoupper($strDescricao). "' AND secao_id = ".$numSecao;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If(pg_fetch_assoc($rsConsulta)==0)
            {
                $sqlInsere = "INSERT INTO seguranca.acao (acao_ds, secao_id, acao_url, acao_dt_criacao) VALUES ('" .$strDescricao. "', " .$numSecao. ", '" .$strURL. "', '" .$strDataCriacao. "')";
                pg_query(abreConexao(),$sqlInsere);

                echo "<script>window.location = 'AcaoInicio.php ';</script>";
            }
            Else
            {	$MensagemErroBD = "A&Ccedil;&Atilde;O J&Aacute; EXISTENTE.";

            }
        }

		ElseIf ($AcaoSistema == "consultar")
        {

					$numCodigo = $_GET['cod'];

					$sqlConsulta = "SELECT * FROM seguranca.acao ac, seguranca.secao se, seguranca.sistema si WHERE (si.sistema_id = se.sistema_id) AND (se.secao_id = ac.secao_id) AND acao_id = " .$numCodigo;
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);
					If($linha)
                    {
						$numSistema	   	  = $linha['sistema_id'];
						$strSistema	   	  = $linha['sistema_nm'];
						$numSecao	   	  = $linha['secao_id'];
						$strSecao	   	  = $linha['secao_ds'];
						$strDescricao	  = $linha['acao_ds'];
						$numStatus	      = $linha['acao_st'];
						$strURL			  = $linha['acao_url'];
						$strDataCriacao   = $linha['acao_dt_criacao'];
						$strDataAlteracao = $linha['acao_dt_alteracao'];

						If ($numStatus == "0")
                        {$strStatus = "Ativo";

                        }
                         Else
                         {  $strStatus = "Inativo";

                         }

                    }
        }

		ElseIf ($AcaoSistema == "alterar")
        {

					$strDataAlteracao = date("Y-m-d");
					$numCodigo		  = $_POST['txtCodigo'];
					$numSistema		  = $_POST['cmbSistema'];
					$strDescricao	  = trim($_POST['txtDescricao']);

					$sqlConsulta = "SELECT acao_id FROM seguranca.acao WHERE acao_st <> 2 AND acao_ds = '".$strtoupper($strDescricao)."' AND sistema_id = " .$numSistema. " AND acao_id <> ".$numCodigo;
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

					
					If(pg_fetch_assoc($rsConsulta)==0)
                    {

							$sqlAltera = "UPDATE seguranca.acao SET sistema_id = '".$numSistema. "', acao_ds = '".$strDescricao. "', acao_dt_alteracao = '".$strDataAlteracao. "' WHERE acao_id = ".$numCodigo;
							pg_query(abreConexao(),$sqlAltera);

							echo "<script>window.location = 'AcaoInicio.php ';</script>";
                    }
					Else
					{	$MensagemErroBD = "SE&Ccedil;&Atilde;O J&Aacute EXISTENTE."	;
                    }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {

					$strDataAlteracao = date("Y-m-d");
					$numCodigo 		  = $_GET['cod'];
					$numStatus 		  = $_GET['status'];

					If ($numStatus == 0)
                    {  $numStatus = 1;

                    }
                     Else
                     {  $numStatus = 0;

                     }

					$sqlAltera = "UPDATE seguranca.acao SET acao_st = ".$numStatus. ", acao_dt_alteracao = '" .$strDataAlteracao. "' WHERE acao_id = " .$numCodigo;
					pg_query(abreConexao(),$sqlAltera);

					echo "<script>window.location = 'AcaoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
        {

					$ExcluirCheckbox = $_GET['excluirMultiplo'];

					If ($ExcluirCheckbox == 1)
                    {
						$numCodigo	= $_POST['txtCodigo'];
						$sqlDeleta = "UPDATE seguranca.acao SET acao_st = 2 WHERE acao_id IN (" .$numCodigo. ")";
                    }
                    Else
					{	$numCodigo	= $_GET['cod'];
						$sqlDeleta = "UPDATE seguranca.acao SET acao_st = 2  WHERE acao_id = ".$numCodigo;
                    }

					pg_query(abreConexao(),$sqlDeleta);

					echo "<script>window.location = 'AcaoInicio.php ';</script>";

        }
?>
