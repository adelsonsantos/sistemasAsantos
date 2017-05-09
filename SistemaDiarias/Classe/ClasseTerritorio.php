<?php

		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Territorio";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;

		if (($AcaoSistema == "buscar")||($AcaoSistema == ""))
		{

			$numFiltro = $_GET['filtro'];

			if ($numFiltro != "")
			{
				$strStringSQL = "territorio_st = ".$numFiltro;
			}
			else
			{
				$strStringSQL = "territorio_st <> 2";
			}
			if ($RetornoFiltro != "")
			{
				$sqlConsulta = "SELECT * FROM diaria.territorio WHERE " .$strStringSQL. " AND (territorio_ds ILIKE '%" .$RetornoFiltro. "%' OR territorio_cd ILIKE '%" .$RetornoFiltro. "%') ORDER BY territorio_cd";
			}
			else
			{
				$sqlConsulta = "SELECT * FROM diaria.territorio WHERE " .$strStringSQL." ORDER BY territorio_cd";
			}
			$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
		}

		ElseIf ($AcaoSistema == "incluir")
        {

					$DataCriacao = date("Y-m-d");
					$Numero		= trim($_POST['txtNumero']);
					$Descricao	= strtoupper(trim($_POST['txtDescricao']));

					$sqlConsulta = "SELECT territorio_cd FROM diaria.territorio WHERE UPPER(territorio_ds) = '" .strtoupper($Descricao)."' OR territorio_cd = '" .$Numero."'";
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If(pg_fetch_row($rsConsulta)==0)
                    {
						$sqlInsere = "INSERT INTO diaria.territorio (territorio_cd, territorio_ds, territorio_dt_criacao) VALUES ('" .$Numero.  "','" .$Descricao. "', '" .$DataCriacao. "')";
						pg_query(abreConexao(),$sqlInsere);

                        echo "<script>window.location = 'TerritorioInicio.php ';</script>";
                    }
					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";

                    }
        }

		ElseIf ($AcaoSistema == "consultar")
        {

					$Codigo = $_GET['cod'];

					If($Codigo == "")
                    {

						$Codigo = $_POST['checkbox'];

						$sqlConsulta = "SELECT * FROM diaria.territorio WHERE territorio_cd IN (".$Codigo.")";
                    }

					Else
					{	$sqlConsulta = "SELECT * FROM diaria.territorio WHERE territorio_cd = '" .$Codigo. "' ";
                    }

					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);
					If($linha)
                    {

						$Codigo	  	   = $linha['territorio_cd'];
						$Numero	  	   = $linha['territorio_cd'];
						$Descricao	   = $linha['territorio_ds'];
						$StatusNumero  = $linha['territorio_st'];
						$DataCriacao   = $linha['territorio_dt_criacao'];
						$DataAlteracao = $linha['territorio_dt_alteracao'];

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


					$sqlConsulta = "SELECT territorio_cd FROM diaria.territorio WHERE (UPPER(territorio_ds) = '".strtoupper($Descricao). "') AND territorio_cd <> '" .$Codigo."' ";
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If(pg_fetch_row($rsConsulta)==0)
                    {

							$sqlAltera = "UPDATE diaria.territorio SET territorio_ds = '" .$Descricao. "', territorio_dt_alteracao = '" .$DataAlteracao. "' WHERE territorio_cd = '" .$Codigo. "' ";
							pg_query(abreConexao(),$sqlAltera);

							echo "<script>window.location = 'TerritorioInicio.php ';</script>";
                    }
					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
                    }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {

					$DataAlteracao 	= date("Y-m-d");
					$Codigo 		= $_GET['cod'];
					$StatusNumero 	= $_GET['status'];

					If ($StatusNumero == 0)
                    {  $StatusNumero = 1;
                    }
                    Else
                    {  $StatusNumero = 0;
                    }


					$sqlAltera = "UPDATE diaria.territorio SET territorio_st = " .$StatusNumero. ", territorio_dt_alteracao = '" .$DataAlteracao. "' WHERE territorio_cd = '" .$Codigo. "' ";

                    pg_query(abreConexao(),$sqlAltera);

					echo "<script>window.location = 'TerritorioInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
        {

					$ExcluirCheckbox = $_GET['excluirMultiplo'];

					If ($ExcluirCheckbox == 1)
                    {
						$Codigo	= $_POST['txtCodigo'];
						$sqlDeleta = "UPDATE diaria.territorio SET territorio_st = 2 WHERE territorio_cd IN ('" .$Codigo. "')";
                    }
                    Else
					{	$Codigo	= $_GET['cod'];
						$sqlDeleta = "UPDATE diaria.territorio SET territorio_st = 2  WHERE territorio_cd = '" .$Codigo. "' ";
                    }

					pg_query(abreConexao(),$sqlDeleta);

					echo "<script>window.location = 'TerritorioInicio.php ';</script>";

        }
?>
