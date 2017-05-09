<?php

		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "MeioTransporte";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;

		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {

					$numFiltro = $_GET['filtro'];

					If ($numFiltro != "")
                    {
						$strStringSQL = "meio_transporte_st = ".$numFiltro;
                    }
					Else
					{	$strStringSQL = "meio_transporte_st <> 2";

                    }

					//fim do filtro

					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM diaria.meio_transporte WHERE " .$strStringSQL." AND meio_transporte_id <> 0 AND meio_transporte_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(meio_transporte_ds)";
                    }
					Else
					{	$sqlConsulta = "SELECT * FROM diaria.meio_transporte WHERE " .$strStringSQL." AND meio_transporte_id <> 0 ORDER BY UPPER(meio_transporte_ds)";

                    }


                   $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {

					$DataCriacao = date("Y-m-d");
					$Descricao	= strtoupper(trim($_POST['txtDescricao']));

					$sqlConsulta = "SELECT meio_transporte_id FROM diaria.meio_transporte WHERE UPPER(meio_transporte_ds) = '".strtoupper($Descricao)."'";
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If(pg_fetch_row($rsConsulta)==0)
                    {

						$sqlInsere = "INSERT INTO diaria.meio_transporte (meio_transporte_ds, meio_transporte_dt_criacao) VALUES ('" .$Descricao. "', '" .$DataCriacao. "')";
						pg_query(abreConexao(),$sqlInsere);

						 echo "<script>window.location = 'MeioTransporteInicio.php ';</script>";
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

						$Codigo =$_POST['checkbox'];

						$sqlConsulta = "SELECT * FROM diaria.meio_transporte WHERE meio_transporte_id IN (" .$Codigo. ")";
                    }
					Else
					{	$sqlConsulta = "SELECT * FROM diaria.meio_transporte WHERE meio_transporte_id = " .$Codigo;
                    }

					$rsConsulta =  pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);

					If($linha)
                    {

						$Descricao	  = $linha['meio_transporte_ds'];
						$StatusNumero  = $linha['meio_transporte_st'];
						$DataCriacao   = $linha['meio_transporte_dt_criacao'];
						$DataAlteracao = $linha['meio_transporte_dt_alteracao'];

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

					$DataAlteracao	= date("Y-m-d");
					$Codigo			= $_POST['txtCodigo'];
					$Descricao		= strtoupper(trim($_POST['txtDescricao']));

					$sqlConsulta = "SELECT meio_transporte_id FROM diaria.meio_transporte WHERE (UPPER(meio_transporte_ds) = '" .strtoupper($Descricao). "') AND meio_transporte_id <> " .$Codigo;
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If (pg_fetch_row($rsConsulta)==0)
                    {

							$sqlAltera = "UPDATE diaria.meio_transporte SET meio_transporte_ds = '" .$Descricao. "', meio_transporte_dt_alteracao = '" .$DataAlteracao."' WHERE meio_transporte_id = " .$Codigo;
                            pg_query(abreConexao(),$sqlAltera);

							 echo "<script>window.location = 'MeioTransporteInicio.php ';</script>";
                    }

					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
                    }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {           $DataAlteracao 	= date("Y-m-d");
					$Codigo 		= $_GET['cod'];
					$StatusNumero 	= $_GET['status'];

					If ($StatusNumero == 0)
                    {  $StatusNumero = 1;

                    }
                     Else
                     {  $StatusNumero = 0;

                     }

					$sqlAltera = "UPDATE diaria.meio_transporte SET meio_transporte_st = " .$StatusNumero. ", meio_transporte_dt_alteracao = '" .$DataAlteracao. "' WHERE meio_transporte_id = " .$Codigo;
                    pg_query(abreConexao(),$sqlAltera);

					 echo "<script>window.location = 'MeioTransporteInicio.php ';</script>";
        }
		ElseIf ($AcaoSistema == "excluir")
        {

					$ExcluirCheckbox = $_GET['excluirMultiplo'];

					If ($ExcluirCheckbox == 1)
                    {
						$Codigo	=$_POST['txtCodigo'];
						$sqlDeleta = "UPDATE diaria.meio_transporte SET meio_transporte_st = 2 WHERE meio_transporte_id IN (" .$Codigo. ")";
                    }
                    Else
					{	$Codigo	= $_GET['cod'];
						$sqlDeleta = "UPDATE diaria.meio_transporte SET meio_transporte_st = 2  WHERE meio_transporte_id = " .$Codigo;
                    }

					pg_query(abreConexao(),$sqlDeleta);

					 echo "<script>window.location = 'MeioTransporteInicio.php ';</script>";

        }
?>
