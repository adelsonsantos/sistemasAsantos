<?php


		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Funcao";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;


		If (($AcaoSistema == "buscar") || ($AcaoSistema == ""))
        {
            $numFiltro = $_GET['filtro'];

            If ($numFiltro != "")
            {	$strStringSQL = "funcao_st = ".$numFiltro;

            }
            Else
            {	$strStringSQL = "funcao_st <> 2";
            }
            //fim do filtro

            If ($RetornoFiltro != "")
            {	$sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE ".$strStringSQL. " AND funcao_id <> 0 AND funcao_ds ILIKE '%" .$RetornoFiltro ."%' ORDER BY UPPER(funcao_ds)";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE ".$strStringSQL. " AND funcao_id <> 0 ORDER BY UPPER(funcao_ds)";

            }


           $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
		{
            $DataCriacao 	 = date("Y-m-d");
            $FuncaoDescricao = strtoupper(trim($_POST['txtFuncao']));

            $sqlConsulta = "SELECT funcao_id FROM dados_unico.funcao WHERE UPPER(funcao_ds) = '".strtoupper($FuncaoDescricao). "'";
             $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If(pg_fetch_row($rsConsulta)==0)
            {
                $sqlInsere = "INSERT INTO dados_unico.funcao (funcao_ds, funcao_dt_criacao) VALUES ('" .$FuncaoDescricao. "', '" .$DataCriacao. "')";
                pg_query(abreConexao(),$sqlInsere);

                echo "<script>window.location = 'FuncaoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "FUN&Ccedil;&Atilde;O J&Aacute; EXISTENTE.";

            }

        }
		ElseIf ($AcaoSistema == "consultar")
        {
            $FuncaoCodigo = $_GET['cod'];

            If ($FuncaoCodigo == "")
            {
                $FuncaoCodigo = $_POST['checkbox'];

                $sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE funcao_id IN (" .$FuncaoCodigo. ")";
            }

            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE funcao_id = ".$FuncaoCodigo;
            }

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
            $linha=pg_fetch_assoc($rsConsulta);

            If ($linha)
            {
                $FuncaoDescricao	 = $linha['funcao_ds'];
                $FuncaoStatusCod	 = $linha['funcao_st'];
                $FuncaoDataCriacao   = $linha['funcao_dt_criacao'];
                $FuncaoDataAlteracao = $linha['funcao_dt_alteracao'];

                If ($FuncaoStatusCod == "0")
                {  $FuncaoStatus = "Ativo";

                }
                Else
                {  $FuncaoStatus = "Inativo";

                }

            }
        }
		ElseIf ($AcaoSistema == "alterar")
        {
            $DataAlteracao	 = date("Y-m-d");
            $FuncaoCodigo	 = $_POST['txtCodigo'];
            $FuncaoDescricao = strtoupper(trim($_POST['txtFuncao']));

            $sqlConsulta = "SELECT funcao_id FROM dados_unico.funcao WHERE UPPER(funcao_ds) = '". strtoupper($FuncaoDescricao). "' AND funcao_id <> " .$FuncaoCodigo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

             If(pg_fetch_row($rsConsulta)==0)
            {
                    $sqlAltera = "UPDATE dados_unico.funcao SET funcao_ds = '".$FuncaoDescricao. "', funcao_dt_alteracao = '".$DataAlteracao. "' WHERE funcao_id = ".$FuncaoCodigo;
                    pg_query(abreConexao(),$sqlAltera);

                    echo "<script>window.location = 'FuncaoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "FUN&Ccedil;&Atilde;O J&Aacute; EXISTENTE.";

            }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {
            $DataAlteracao 	= date("Y-m-d");
            $FuncaoCodigo 	= $_GET['cod'];
            $FuncaoStatusCod = $_GET['status'];

            If ($FuncaoStatusCod == 0)
            {  $FuncaoStatusCod = 1;

            }
            Else
            {  $FuncaoStatusCod = 0;

            }
            $sqlAltera = "UPDATE dados_unico.funcao SET funcao_st = " .$FuncaoStatusCod. ", funcao_dt_alteracao = '" .$DataAlteracao. "' WHERE funcao_id = ".$FuncaoCodigo;
            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'FuncaoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
        {
            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {
                $FuncaoCodigo	= $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE dados_unico.funcao SET funcao_st = 2 WHERE funcao_id IN (".$FuncaoCodigo. ")";
            }
            Else
            {	$FuncaoCodigo	= $_GET['cod'];
                $sqlDeleta = "UPDATE dados_unico.funcao SET funcao_st = 2  WHERE funcao_id = ".$FuncaoCodigo;
            }

            pg_query(abreConexao(),$sqlDeleta);

            echo "<script>window.location = 'FuncaoInicio.php ';</script>";

}

?>
