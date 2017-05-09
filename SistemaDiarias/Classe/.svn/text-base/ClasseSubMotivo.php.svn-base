<?php


		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "SubMotivo";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;

		If (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
        {

					$numFiltro = $_GET['filtro'];

					If ($numFiltro != "")
                    {
						$strStringSQL = "sub_motivo_st = " .$numFiltro;
                    }
					Else
					{	$strStringSQL = "sub_motivo_st <> 2";

                    }

					//fim do filtro

					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM diaria.sub_motivo WHERE " .$strStringSQL. " AND sub_motivo_id <> 0 AND (sub_motivo_ds ILIKE '%" .$RetornoFiltro. "%' OR sub_motivo_ds ILIKE '%" .$RetornoFiltro. "%') ORDER BY UPPER(sub_motivo_ds)";
                    }
                    Else
					{	$sqlConsulta = "SELECT * FROM diaria.sub_motivo WHERE " .$strStringSQL. " AND sub_motivo_id <> 0 ORDER BY UPPER(sub_motivo_ds)";
                    }

									//	echo $sqlConsulta;
										//exit (0);                  
									  $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {

					$Motivo	  = $_POST['cmbMotivoDiaria'];
					$Descricao = strtoupper(trim($_POST['txtDescricao']));

					$sqlConsulta    = "SELECT sub_motivo_id FROM diaria.sub_motivo WHERE UPPER(sub_motivo_ds) = '" .strtoupper($Descricao). "'";
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If (pg_fetch_row($rsConsulta)==0)
                    {   $Date=date("Y-m-d");
						$sqlInsere = "INSERT INTO diaria.sub_motivo (sub_motivo_ds, sub_motivo_dt_criacao) VALUES ('" .$Descricao. "', '" .$Date. "')";
						pg_query(abreConexao(),$sqlInsere);

						echo "<script>window.location = 'SubMotivoInicio.php ';</script>";
                    }
					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
                    }
        }

		ElseIf ($AcaoSistema == "consultar")
        {

					$Codigo = $_GET['cod'];

					If ($Codigo == "")
                    {

						$Codigo = $_POST['checkbox'];

						$sqlConsulta = "SELECT * FROM diaria.sub_motivo WHERE sub_motivo_id IN (" .$Codigo. ")";
                    }

					Else
					{	$sqlConsulta = "SELECT * FROM diaria.sub_motivo WHERE sub_motivo_id = " .$Codigo;
                    }

					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);

					If ($linha)
                    {

						$Descricao	 = $linha['sub_motivo_ds'];
						$StatusNumero = $linha['sub_motivo_st'];

						If ($StatusNumero == "0")
                        {  $StatusNome = "Ativo";

                        }
                         Else
                         {  $StatusNome = "Inativo";

                         }

                    }
        }

		ElseIf ($AcaoSistema == "alterar")
        {

					$Codigo	  = $_POST['txtCodigo'];
					$Descricao = strtoupper(trim($_POST['txtDescricao']));

					$sqlConsulta    = "SELECT sub_motivo_id FROM diaria.sub_motivo WHERE (UPPER(sub_motivo_ds) = '" .strtoupper($Descricao). "') AND sub_motivo_id <> " .$Codigo;
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If (pg_fetch_row($rsConsulta)==0)
                    {  $Date=date("Y-m-d");

							$sqlAltera = "UPDATE diaria.sub_motivo SET sub_motivo_ds = '" .$Descricao. "', sub_motivo_dt_alteracao = '" .$Date. "' WHERE sub_motivo_id = " .$Codigo;
							pg_query(abreConexao(),$sqlAltera);

							echo "<script>window.location = 'SubMotivoInicio.php ';</script>";
                    }

					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
                    }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {

					$Codigo 		= $_GET['cod'];
					$StatusNumero 	= $_GET['status'];

                    $Date=date("Y-m-d");

					If ($StatusNumero == 0)
                    {  $StatusNumero = 1;

                    }
					Else
                    { $StatusNumero = 0;

                    }
					$sqlAltera = "UPDATE diaria.sub_motivo SET sub_motivo_st = ".$StatusNumero. ", sub_motivo_dt_alteracao = '" .$Date. "' WHERE sub_motivo_id = ".$Codigo;

					pg_query(abreConexao(),$sqlAltera);

					echo "<script>window.location = 'SubMotivoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
        {

					$ExcluirCheckbox = $_GET['excluirMultiplo'];

					If ($ExcluirCheckbox == 1)
                    {
						$Codigo	= $_POST['txtCodigo'];
						$sqlDeleta = "UPDATE diaria.sub_motivo SET sub_motivo_st = 2 WHERE sub_motivo_id IN (" .$Codigo. ")";
                    }
					Else
					{	$Codigo	= $_GET['cod'];
						$sqlDeleta = "UPDATE diaria.sub_motivo SET sub_motivo_st = 2  WHERE sub_motivo_id = " .$Codigo;
                    }

					pg_query(abreConexao(),$sqlDeleta);

					echo "<script>window.location = 'SubMotivoInicio.php ';</script>";
        }
?>
