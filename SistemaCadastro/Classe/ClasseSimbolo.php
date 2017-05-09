<?php

        //define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Simbolo";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = false;



		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
		{
					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND simbolo_id <> 0 AND simbolo_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(simbolo_ds)";
                    }
                    Else
					{	$sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND simbolo_id <> 0 ORDER BY UPPER(simbolo_ds)";
                    }
                    $rsConsulta = pg_query(abreConexao,$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {

            $strDataCriacao = date("Y-m-d");
            $strDescricao	= strtoupper(trim($_POST['txtSimbolo']));
            $strValorDiaria	= trim($_POST['txtValor']);
            $strSalario		= trim($_POST['txtSalario']);

            $sqlConsulta = "SELECT simbolo_id FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND UPPER(simbolo_ds) = '" .strtoupper($strDescricao). "'";
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If(pg_fetch_row($rsConsulta)==0)
            {

                $sqlInsere = "INSERT INTO dados_unico.simbolo (simbolo_ds, simbolo_valor_diaria, simbolo_dt_criacao, simbolo_salario) VALUES ('" .$strDescricao. "', '" .$strValorDiaria. "', '" .$strDataCriacao. "','" .$strSalario. "')";
                pg_query(abreConexao(),$sqlInsere);


                 echo "<script>window.location = 'SimboloInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "S&Iacute;MBOLO J&Aacute; EXISTENTE.";
            }
        }

		ElseIf ($AcaoSistema == "consultar")
        {

            $numCodigo = $_GET['cod'];

            If ($numCodigo == "")
            {

                $numCodigo = $_POST['checkbox'];

                $sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_id IN (" .$numCodigo. ")";

            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_id = " .$numCodigo;
            }

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
            $linha=pg_fetch_assoc($rsConsulta);

            If ($linha)
            {

                $strDescricao	 = $linha['simbolo_ds'];
                $strValorDiaria	 = $linha['simbolo_valor_diaria'];
                $strSalario		 = $linha['simbolo_salario'];
                $numStatus	   	 = $linha['simbolo_st'];
                $strDataCriacao   = $linha['simbolo_dt_criacao'];
                $strDataAlteracao = $linha['simbolo_dt_alteracao'];

                If ($numStatus == "0")
                {  $strStatus = "Ativo";

                }
                Else
                {  $strStatus = "Inativo";

                }

             }
        }

		ElseIf ($AcaoSistema == "alterar")
        {

            $strDataAlteracao= date("Y-m-d");
            $numCodigo		= $_POST['txtCodigo'];
            $strDescricao	= strtoupper(trim($_POST['txtSimbolo']));
            $strValorDiaria	= trim($_POST['txtValor']);
            $strSalario		= trim($_POST['txtSalario']);

            $sqlConsulta = "SELECT simbolo_id FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND UPPER(simbolo_ds) = '" .strtoupper($strDescricao). "' AND simbolo_id <> " .$numCodigo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            if(pg_fetch_row($rsConsulta)==0)
            {

                $sqlAltera = "UPDATE dados_unico.simbolo SET simbolo_salario = '" .$strSalario. "', simbolo_valor_diaria = '" .$strValorDiaria. "', simbolo_ds = '" .$strDescricao. "', simbolo_dt_alteracao = '" .$strDataAlteracao. "' WHERE simbolo_id = " .$numCodigo;
                pg_query(abreConexao(),$sqlAltera);

                echo "<script>window.location = 'SimboloInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "S&Iacute;MBOLO J&Aacute; EXISTENTE.";
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

                $sqlAltera = "UPDATE dados_unico.simbolo SET simbolo_st = " .$numStatus. ", simbolo_dt_alteracao = '".$strDataAlteracao. "' WHERE simbolo_id = " .$numCodigo;
                pg_query(abreConexao(),$sqlAltera);

                echo "<script>window.location = 'SimboloInicio.php ';</script>";
        }

		ElseIf($AcaoSistema == "excluir")
        {

            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {
                $numCodigo = $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE dados_unico.simbolo SET simbolo_st = 2 WHERE simbolo_id IN (" .$numCodigo. ")";
            }
            Else
            {	$numCodigo = $_GET['cod'];
                $sqlDeleta = "UPDATE dados_unico.simbolo SET simbolo_st = 2  WHERE simbolo_id = " .$numCodigo;
            }


            pg_query(abreConexao(),$sqlDeleta);

            echo "<script>window.location = 'SimboloInicio.php ';</script>";

        }
?>