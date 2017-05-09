<?php
		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Contrato";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 1;

		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {

            $numFiltro = $_GET['filtro'];

            If ($numFiltro != "")
            {
                $strStringSQL = "contrato_st = ".$numFiltro;
            }
            Else
            {	$strStringSQL = "contrato_st <> 2";
            }
            //fim do filtro

            If ($RetornoFiltro != "")
            {
                $sqlConsulta = "SELECT * FROM dados_unico.contrato c, dados_unico.pessoa p WHERE (c.pessoa_id = p.pessoa_id) AND " .$strStringSQL." AND contrato_id <> 0 AND contrato_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(contrato_ds)";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.contrato c, dados_unico.pessoa p WHERE (c.pessoa_id = p.pessoa_id) AND " .$strStringSQL. " AND contrato_id <> 0 ORDER BY UPPER(contrato_ds)";
            }

           $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {

            $DataCriacao = date("Y-m-d");
            $Numero		 = trim($_POST['txtNumero']);
            $Descricao	 = strtoupper(trim($_POST['txtDescricao']));
            $Tipo		 = $_POST['cmbContratoTipo'];
            $Empresa	 = $_POST['cmbPJ'];
            $DataInicio	 = trim($_POST['txtDataInicio']);
            $DataTermino = trim($_POST['txtDataTermino']);
            $Valor		 = trim($_POST['txtValor']);
            $Qtde		 = trim($_POST['txtQtde']);

            If ($Qtde == "")
            {  $Qtde = 0;

            }

            $sqlConsulta = "SELECT contrato_id FROM dados_unico.contrato WHERE contrato_num = '" .$Numero. "' AND pessoa_id = " .$Empresa;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If (pg_fetch_row($rsConsulta)==0)
            {

                $sqlInsere = "INSERT INTO dados_unico.contrato (pessoa_id, contrato_num, contrato_ds, contrato_dt_inicio, contrato_dt_termino, contrato_valor, contrato_num_max, contrato_dt_criacao, contrato_tipo_id) VALUES (" .$Empresa. ", '" .$Numero. "', '" .$Descricao. "', '" .$DataInicio. "', '" .$DataTermino. "', '" .$Valor. "', " .$Qtde. ", '" .$DataCriacao. "', " .$Tipo. " )";

                pg_query(abreConexao(),$sqlInsere);

                  echo "<script>window.location = 'ContratoInicio.php ';</script>";
            }
            Else
            {	$MensagemErroBD = "N&Uacute;MERO DE CONTRATO J&Aacute; EXISTENTE PARA ESTA EMPRESA.";

            }
        }

		ElseIf ($AcaoSistema == "consultar")
        {
            $Codigo = $_GET['cod'];

            If ($Codigo == "")
            {

                $Codigo = $_POST['checkbox'];

                $sqlConsulta = "SELECT * FROM dados_unico.contrato WHERE contrato_id IN (" .$Codigo.")";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.contrato WHERE contrato_id = " .$Codigo;

            }

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
            $linha=pg_fetch_assoc($rsConsulta);

            If ($linha)
            {
                $Numero	   	    = $linha['contrato_num'];
                $Descricao	    = $linha['contrato_ds'];
                $StatusCod	    = $linha['contrato_st'];
                $DataCriacao    = $linha['contrato_dt_criacao'];
                $DataAlteracao  = $linha['contrato_dt_alteracao'];
                $Empresa	    = $linha['pessoa_id'];
                $DataInicio	    = $linha['contrato_dt_inicio'];
                $DataTermino	= $linha['contrato_dt_termino'];
                $Tipo		    = $linha['contrato_tipo_id'];
                $Valor		    = $linha['contrato_valor'];
                $Qtde		    = $linha['contrato_num_max'];

                If ($StatusCod == "0")
                {  $StatusNome = "Ativo";

                }
                Else
                {  $StatusNome = "Inativo";

                }

            }
        }

		ElseIf ($AcaoSistema == "alterar")
        {

					$Codigo = $_POST['txtCodigo'];
					$DataAlteracao	= date("Y-m-d");
					$Numero		 = trim($_POST['txtNumero']);
					$Descricao	 = strtoupper(trim($_POST['txtDescricao']));
					$Empresa	 = $_POST['cmbPJ'];
					$Tipo		 = $_POST['cmnContratoTipo'];
					$DataInicio	 = trim($_POST['txtDataInicio']);
					$DataTermino = trim($_POST['txtDataTermino']);
					$Valor		 = trim($_POST['txtValor']);
					$Qtde		 = trim($_POST['txtQtde']);

					$sqlConsulta = "SELECT contrato_id FROM dados_unico.contrato WHERE contrato_num = '" .$Numero. "' AND pessoa_id = " .$Empresa. " AND contrato_id <> " .$Codigo;
                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    If (pg_fetch_row($rsConsulta)==0)
                    {
                        $sqlAltera = "UPDATE dados_unico.contrato SET contrato_num = '" .$Numero. "', contrato_ds = '" .$Descricao. "', contrato_dt_inicio = '" .$DataInicio. "', contrato_dt_termino = '" .$DataTermino. "', contrato_valor = '" .$Valor. "', contrato_num_max = '" .$Qtde. "', contrato_dt_alteracao = '" .$DataAlteracao. "' WHERE contrato_id = " .$Codigo;
                        pg_query(abreConexao(),$sqlAltera);

                        echo "<script>window.location = 'ContratoInicio.php ';</script>";
                    }

					Else
					{	$MensagemErroBD = "N&Uacute;MERO DE CONTRATO J&Aacute; EXISTENTE PARA ESTA EMPRESA.";
                    }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {
            $DataAlteracao 	= date("Y-m-d");
            $Codigo 	= $_GET['cod'];
            $StatusCod 	= $_GET['status'];

            If ($StatusCod == 0)
            {  $StatusCod = 1;

            }
             Else
             {  $StatusCod = 0;

             }

            $sqlAltera = "UPDATE dados_unico.contrato SET contrato_st = " .$StatusCod. ", contrato_dt_alteracao = '" .$DataAlteracao. "' WHERE contrato_id = " .$Codigo;
            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'ContratoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
        {
            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {
                $Codigo	= $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE dados_unico.contrato SET contrato_st = 2 WHERE contrato_id IN (" .$Codigo. ")";
            }
            Else
            {	$Codigo	= $_GET['cod'];
                $sqlDeleta = "UPDATE dados_unico.contrato SET contrato_st = 2  WHERE contrato_id = " .$Codigo;
            }

             pg_query(abreConexao(),$sqlDeleta);

            echo "<script>window.location = 'ContratoInicio.php ';</script>";

        }
?>
