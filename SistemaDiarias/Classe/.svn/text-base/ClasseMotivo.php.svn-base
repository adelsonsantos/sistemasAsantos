<?php
        //define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Motivo";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;

		If (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
        {

					$numFiltro = $_GET['filtro'];

					If ($numFiltro != "")
                    {
						$strStringSQL = "motivo_st = " .$numFiltro;
                    }
					Else
					{	$strStringSQL = "motivo_st <> 2"; //Motivo Excluido ..  

                    }

					//fim do filtro

					 
					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM diaria.motivo m, diaria.motivo_tipo mt WHERE (m.motivo_tipo_id = mt.motivo_tipo_id) AND " .$strStringSQL. " AND motivo_id <> 0 AND (motivo_ds ILIKE '%" .$RetornoFiltro. "%' OR motivo_tipo_ds ILIKE '%" .$RetornoFiltro. "%') ORDER BY UPPER(motivo_ds)";
                    }
                    Else
					{	$sqlConsulta = "SELECT * FROM diaria.motivo m, diaria.motivo_tipo mt WHERE (m.motivo_tipo_id = mt.motivo_tipo_id) AND " .$strStringSQL." AND motivo_id <> 0 ORDER BY UPPER(motivo_ds)";
                    }
				
                   $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {

					$DataCriacao = date("Y-m-d");
					$MotivoTipo  = $_POST['cmbMotivoTipo'];
					$Descricao	= strtoupper(trim($_POST['txtDescricao']));

					$sqlConsulta = "SELECT motivo_id FROM diaria.motivo WHERE motivo_tipo_id = " .$MotivoTipo. " AND UPPER(motivo_ds) = '" .strtoupper($Descricao). "'";
                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    if(pg_fetch_row($rsConsulta)==0)
                    {

						$sqlInsere = "INSERT INTO diaria.motivo (motivo_ds, motivo_dt_criacao, motivo_tipo_id) VALUES ('" .$Descricao. "', '" .$DataCriacao. "', " .$MotivoTipo. " )";
						pg_query(abreConexao(),$sqlInsere);

						 echo "<script>window.location = 'MotivoInicio.php ';</script>";
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

						$sqlConsulta = "SELECT * FROM diaria.motivo m, diaria.motivo_tipo mt WHERE (m.motivo_tipo_id = mt.motivo_tipo_id) AND motivo_id IN (" .$Codigo. ")";
                    }
					Else
					{	$sqlConsulta = "SELECT * FROM diaria.motivo m, diaria.motivo_tipo mt WHERE (m.motivo_tipo_id = mt.motivo_tipo_id) AND motivo_id = " .$Codigo;
                    }

                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);
                    If($linha)
                    {

						$Descricao	    = $linha['motivo_ds'];
						$MotivoTipo 	= $linha['motivo_tipo_id'];
						$MotivoTipoNome = $linha['motivo_tipo_ds'];
						$StatusNumero   = $linha['motivo_st'];
						$DataCriacao    = $linha['motivo_dt_criacao'];
						$DataAlteracao  = $linha['motivo_dt_alteracao'];

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
					$MotivoTipo     = $_POST['cmbMotivoTipo'];
					$Descricao		= strtoupper(trim($_POST['txtDescricao']));

					$sqlConsulta = "SELECT motivo_id FROM diaria.motivo WHERE motivo_tipo_id = " .$MotivoTipo. " AND (UPPER(motivo_ds) = '" .strtoupper($Descricao)."') AND motivo_id <> " .$Codigo;
                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If(pg_fetch_row($rsConsulta)==0)
                    {

							$sqlAltera = "UPDATE diaria.motivo SET motivo_tipo_id = ".$MotivoTipo. ", motivo_ds = '" .$Descricao. "', motivo_dt_alteracao = '".$DataAlteracao. "' WHERE motivo_id = " .$Codigo;
							pg_query(abreConexao(),$sqlAltera);

							 echo "<script>window.location = 'MotivoInicio.php ';</script>";
                    }
					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";

                    }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {

					$DataAlteracao 	= date("Y-m-d");
					$Codigo 			= $_GET['cod'];
					$StatusNumero 	= $_GET['status'];

					If ($StatusNumero == 0)
                    {  $StatusNumero = 1;

                    }
                    Else
                    { $StatusNumero = 0;

                    }

					$sqlAltera = "UPDATE diaria.motivo SET motivo_st = " .$StatusNumero. ", motivo_dt_alteracao = '" .$DataAlteracao. "' WHERE motivo_id = " .$Codigo;
					pg_query(abreConexao(),$sqlAltera);

					 echo "<script>window.location = 'MotivoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
		{
					$ExcluirCheckbox = $_GET['excluirMultiplo'];

					If ($ExcluirCheckbox == 1)
                    {
						$Codigo	= $_POST['txtCodigo'];
						$sqlDeleta = "UPDATE diaria.motivo SET motivo_st = 2 WHERE motivo_id IN (" .$Codigo. ")";
                    }
                    Else
					{	$Codigo	= $_GET['cod'];
						$sqlDeleta = "UPDATE diaria.motivo SET motivo_st = 2  WHERE motivo_id = " .$Codigo;
                    }
					pg_query(abreConexao(),$sqlDeleta);

					 echo "<script>window.location = 'MotivoInicio.php ';</script>";
        }
?>
