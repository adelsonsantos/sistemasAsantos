<?php
		//define o nome da pagina local para facilitar nos links

        $PaginaLocal = "Banco";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;


		//filtro por status

		If (($AcaoSistema == "buscar")||  ($AcaoSistema == ""))
		{
            $numFiltro = $_GET['filtro'];

            If ($numFiltro != "")
            {	$strStringSQL = "banco_st = ".$numFiltro;

            }
            Else
            {	$strStringSQL = "banco_st <> 2";

            }

            If ($RetornoFiltro != "")
            {	$sqlConsulta = "SELECT * FROM dados_unico.banco WHERE ".$strStringSQL. " AND banco_id <> 0 AND banco_ds ILIKE '%".$RetornoFiltro. "%' ORDER BY UPPER(banco_ds)";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.banco WHERE ".$strStringSQL. " AND banco_id <> 0 ORDER BY UPPER(banco_ds)";

            }

           $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }
		ElseIf ($AcaoSistema == "incluir")
        {
            $DataCriacao 	= date("Y-m-d");
            $BancoNumero	= trim($_POST['txtBancoNumero']);
            $BancoDescricao	= strtoupper(trim($_POST['txtBanco']));

            $sqlConsulta = "SELECT banco_id FROM dados_unico.banco WHERE banco_st <> 2 AND UPPER(banco_ds) = '".strtoupper($BancoDescricao)."' OR banco_cd = '" .$BancoNumero. "'";
            $rsConsulta =pg_query(abreConexao(),$sqlConsulta);

            If (pg_fetch_row($rsConsulta)==0)
            {
                $sqlInsere = "INSERT INTO dados_unico.banco (banco_cd, banco_ds, banco_dt_criacao) VALUES ('".$BancoNumero. "', '".$BancoDescricao. "', '" .$DataCriacao. "')";
                pg_query(abreConexao(),$sqlInsere);
               echo "<script>window.location = 'BancoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "N&Uacute;MERO OU BANCO J&Aacute; EXISTENTES.";
            }
        }
		ElseIf ($AcaoSistema == "consultar")
		{
            $BancoCodigo = $_GET['cod'];

            If ($BancoCodigo == "")
            {
                $BancoCodigo = $_POST['checkbox'];

                $sqlConsulta = "SELECT * FROM dados_unico.banco WHERE banco_id IN (".$BancoCodigo. ")";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.banco WHERE banco_id = " .$BancoCodigo;
            }

            $rsConsulta =pg_query(abreConexao(),$sqlConsulta);
            $linha=pg_fetch_assoc($rsConsulta);

            If($linha)
            {
                $BancoNumero	  = $linha['banco_cd'];
                $BancoDescricao	  = $linha['banco_ds'];
                $BancoStatusCod	  = $linha['banco_st'];
                $strDataCriacao   = $linha['banco_dt_criacao'];
                $strDataAlteracao = $linha['banco_dt_alteracao'];

                If ($BancoStatusCod == "0")
                {  $BancoStatus = "Ativo";

                }
                Else
                {  $BancoStatus = "Inativo";

                }

            }
        }

		ElseIf ($AcaoSistema == "alterar")
        {
            $DataAlteracao	= date("Y-m-d");
            $BancoCodigo    = $_POST['txtCodigo'];
            $BancoNumero	= trim($_POST['txtBancoNumero']);
            $BancoDescricao	= strtoupper(trim($_POST['txtBanco']));

            $sqlConsulta = "SELECT banco_id FROM dados_unico.banco WHERE banco_st <> 2 AND (UPPER(banco_ds) = '".strtoupper($BancoDescricao). "' OR banco_cd = '".$BancoNumero. "') AND banco_id <> ".$BancoCodigo;

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);


            If (pg_fetch_row($rsConsulta)==0)
            {
                    $sqlAltera = "UPDATE dados_unico.banco SET banco_cd = '".$BancoNumero. "', banco_ds = '".$BancoDescricao. "', banco_dt_alteracao = '".$DataAlteracao. "' WHERE banco_id = ".$BancoCodigo;
                    pg_query(abreConexao(),$sqlAltera);

                    echo "<script>window.location = 'BancoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "N&Uacute;MERO OU BANCO J&Aacute; EXISTENTES.";

            }
        }


		ElseIf ($AcaoSistema == "alterarStatus")
        {

            $DataAlteracao 	= date("Y-m-d");
            $BancoCodigo 	= $_GET['cod'];
            $BancoStatusCod = $_GET['status'];

            If ($BancoStatusCod == 0)
            { $BancoStatusCod = 1;

            }
            Else
            {  $BancoStatusCod = 0;

            }

            $sqlAltera = "UPDATE dados_unico.banco SET banco_st = ".$BancoStatusCod. ", banco_dt_alteracao = '".$DataAlteracao. "' WHERE banco_id = ".$BancoCodigo;

            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'BancoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
        {
                     
            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {
                $BancoCodigo	= $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE dados_unico.banco SET banco_st = 2 WHERE banco_id IN (" .$BancoCodigo. ")";
            }
            Else
            {	$BancoCodigo	= $_GET['cod'];
                $sqlDeleta = "UPDATE dados_unico.banco SET banco_st = 2  WHERE banco_id = ".$BancoCodigo;
            }

            pg_query(abreConexao(),$sqlDeleta);

            echo "<script>window.location = 'BancoInicio.php ';</script>";

        }
?>
