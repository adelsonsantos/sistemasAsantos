<?php

		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Lotacao";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;



		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {

					$numFiltro = $_GET['filtro'];

					If ($numFiltro != "")
                    {
						$strStringSQL = "lotacao_st = " .$numFiltro;
                    }
					Else
					{	$strStringSQL = "lotacao_st <> 2";
                    }
					
                    //fim do filtro

					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND " .$strStringSQL. " AND lotacao_id <> 0 AND lotacao_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(lotacao_ds)";
                    }
					Else
					{	$sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND " .$strStringSQL. " AND lotacao_id <> 0 ORDER BY UPPER(lotacao_ds)";
                    }

                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {
            $DataCriacao 		= date("Y-m-d");
            $LotacaoOrgao		= $_POST['cmbOrgao'];
            $LotacaoDescricao	= strtoupper(trim($_POST['txtLotacao']));

            $sqlConsulta = "SELECT lotacao_id FROM dados_unico.lotacao WHERE UPPER(lotacao_ds) = '" .strtoupper($LotacaoDescricao). "' AND orgao_id = " .$LotacaoOrgao;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If (pg_fetch_row($rsConsulta)==0)
            {

                $sqlInsere = "INSERT INTO dados_unico.lotacao (lotacao_ds, orgao_id, lotacao_dt_criacao) VALUES ('" .$LotacaoDescricao. "', " .$LotacaoOrgao. ", '" .$DataCriacao. "')";
                pg_query(abreConexao(),$sqlInsere);
                 echo "<script>window.location = 'LotacaoInicio.php ';</script>";

            }
            Else
            {	$MensagemErroBD = "LOT&Ccedil;&Atilde;O J&Aacute;  EXISTENTE.";
            }
        }

		ElseIf ($AcaoSistema == "consultar")
        {
                $LotacaoCodigo = $_GET['cod'];

                If ($LotacaoCodigo == "")
                {

                    $LotacaoCodigo = $_POST['checkbox'];

                    $sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND lotacao_id IN (" .$LotacaoCodigo. ")";
                }
                Else
                {	$sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND lotacao_id = " .$LotacaoCodigo;
                }

                $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                $linha=pg_fetch_assoc($rsConsulta);

                If ($linha)
                {

                    $LotacaoOrgao	   		= $linha['orgao_id'];
                    $OrgaoNome				= $linha['orgao_ds'];
                    $LotacaoDescricao	   	= $linha['lotacao_ds'];
                    $LotacaoStatusCod	   	= $linha['lotacao_st'];
                    $LotacaoDataCriacao   	= $linha['lotacao_dt_criacao'];
                    $LotacaoDataAlteracao 	= $linha['lotacao_dt_alteracao'];

                    If ($LotacaoStatusCod == "0")
                    {  $LotacaoStatus = "Ativo";

                    }
                    Else
                    {  $LotacaoStatus = "Inativo";

                    }

                }
    }

    ElseIf ($AcaoSistema == "alterar")
    {
        $DataAlteracao		= date("Y-m-d");
        $LotacaoCodigo		= $_POST['txtCodigo'];
        $LotacaoOrgao		= $_POST['cmbOrgao'];
        $LotacaoDescricao	= strtoupper(trim($_POST['txtLotacao']));

        $sqlConsulta = "SELECT lotacao_id FROM dados_unico.lotacao WHERE UPPER(lotacao_ds) = '" .strtoupper($LotacaoDescricao). "' AND lotacao_id <> " .$LotacaoCodigo;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

        If(pg_fetch_row($rsConsulta)==0)
        {
            $sqlAltera = "UPDATE dados_unico.lotacao SET orgao_id = " .$LotacaoOrgao. ", lotacao_ds = '" .$LotacaoDescricao. "', lotacao_dt_alteracao = '" .$DataAlteracao. "' WHERE lotacao_id = " .$LotacaoCodigo;
            pg_query(abreConexao(),$sqlAltera);
             echo "<script>window.location = 'LotacaoInicio.php ';</script>";
        }
        Else
        {	$MensagemErroBD = "LOT&Ccedil;&Atilde;O J&Aacute;  EXISTENTE.";

        }
    }
    ElseIf ($AcaoSistema == "alterarStatus")
    {

        $DataAlteracao 		= date("Y-m-d");
        $LotacaoCodigo 		= $_GET['cod'];
        $LotacaoStatusCod 	= $_GET['status'];

        If ($LotacaoStatusCod == 0)
        {  $LotacaoStatusCod = 1;

        }
        Else
        {  $LotacaoStatusCod = 0;

        }

        $sqlAltera = "UPDATE dados_unico.lotacao SET lotacao_st = " .$LotacaoStatusCod. ", lotacao_dt_alteracao = '" .$DataAlteracao. "' WHERE lotacao_id = " .$LotacaoCodigo;
        pg_query(abreConexao(),$sqlAltera);

        echo "<script>window.location = 'LotacaoInicio.php ';</script>";
        }
		ElseIf ($AcaoSistema == "excluir")
        {
            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {
                $LotacaoCodigo	= $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE dados_unico.lotacao SET lotacao_st = 2 WHERE lotacao_id IN (" .$LotacaoCodigo. ")";
            }
            Else
            {	$LotacaoCodigo	= $_GET['cod'];
                $sqlDeleta = "UPDATE dados_unico.lotacao SET lotacao_st = 2  WHERE lotacao_id = " .$LotacaoCodigo;
            }
            pg_query(abreConexao(),$sqlDeleta);

            echo "<script>window.location = 'LotacaoInicio.php ';</script>";

        }
?>
