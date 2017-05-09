<?php
  //define o nome da pagina local para facilitar nos links
	$PaginaLocal = "EstOrganizacionalLotacao";

	//controla a visibilidade do botao consultar
	$_SESSION['BotaoConsultar'] = 0;


	$ErroBD = 0;

	If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
	{

		$numFiltro = $_GET['filtro'];

		If ($numFiltro != "")
		{
				$strStringSQL = "tFilha.est_organizacional_lotacao_st = " .$numFiltro;
		}
		Else
		{	$strStringSQL = "tFilha.est_organizacional_lotacao_st <> 2";

		}


		If ($RetornoFiltro != "")
		{
				$sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_sigla AS EstSuperior, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE " .$strStringSQL. " AND tFilha.est_organizacional_lotacao_id <> 0 AND (tFilha.est_organizacional_lotacao_ds ILIKE '%" .$RetornoFiltro. "%') OR (tFilha.est_organizacional_lotacao_sigla ILIKE '%" .$RetornoFiltro. "%') ORDER BY UPPER(tFilha.est_organizacional_lotacao_sigla)";

		}
		Else
		{	$sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_sigla AS EstSuperior, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE " .$strStringSQL. " AND tFilha.est_organizacional_lotacao_id <> 0 ORDER BY UPPER(tFilha.est_organizacional_lotacao_sigla)";
		}

	 $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
	}

	ElseIf ($AcaoSistema == "incluir")
	{
			$EstOrganizacionalDescricao	 = strtoupper(trim($_POST['txtEstOrganizacional']));
			$EstOrganizacionalSigla = strtoupper(trim($_POST['txtEstOrganizacionalSigla']));
			$EstOrganizacionalSuperiorCod = $_POST['cmbEstruturaSuperior'];

			$sqlConsulta = "SELECT est_organizacional_lotacao_id FROM dados_unico.est_organizacional_lotacao WHERE UPPER(est_organizacional_lotacao_ds) = '" .strtoupper($EstOrganizacionalDescricao). "' OR UPPER(est_organizacional_lotacao_sigla) = '" .strtoupper($EstOrganizacionalSigla). "'";
			$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

			If(pg_fetch_row($rsConsulta)==0)
			{
					$Date=date("Y-m-d");
					$sqlInsere = "INSERT INTO dados_unico.est_organizacional_lotacao (est_organizacional_lotacao_sup_cd, est_organizacional_lotacao_ds, est_organizacional_lotacao_sigla, est_organizacional_lotacao_dt_criacao) VALUES (".$EstOrganizacionalSuperiorCod. ", '" .$EstOrganizacionalDescricao. "','" .$EstOrganizacionalSigla. "', '" .$Date. "')";
					pg_query(abreConexao(),$sqlInsere);
					echo "<script>window.location = 'EstOrganizacionalLotacaoInicio.php ';</script>";
			}

			Else
			{	$MensagemErroBD = "ESTRUTURA ORGANIZACIONAL J&Aacute; CADASTRADA.";

			}
	}

	ElseIf ($AcaoSistema == "consultar")
	{
        $EstOrganizacionalCodigo = $_GET['cod'];

        If ($EstOrganizacionalCodigo == "")
        {

            $EstOrganizacionalCodigo = $_POST['checkbox'];

            $sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_ds AS EstSuperior, tFilha.est_organizacional_lotacao_sup_cd, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE tFilha.est_organizacional_lotacao_id IN (".$EstOrganizacionalCodigo. ")";
        }
        Else
        {	$sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_ds AS EstSuperior, tFilha.est_organizacional_lotacao_sup_cd, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE tFilha.est_organizacional_lotacao_id = " .$EstOrganizacionalCodigo;
        }


        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        $linha=pg_fetch_assoc($rsConsulta);

        If($linha)
        {
            $EstOrganizacionalSuperiorCod   = $linha['est_organizacional_lotacao_sup_cd'];
            $EstOrganizacionalSuperior    	= $linha['estsuperior'];
            $EstOrganizacionalCodigo		= $linha['est_organizacional_lotacao_id'];
            $EstOrganizacionalDescricao	    = $linha['est_organizacional_lotacao_ds'];
            $EstOrganizacionalSigla	    	= $linha['est_organizacional_lotacao_sigla'];
            $EstOrganizacionalStatusCod	    = $linha['est_organizacional_lotacao_st'];

            If ($EstOrganizacionalStatusCod == "0")
            {  $EstOrganizacionalStatus = "Ativo";
            }
            Else
            {  $EstOrganizacionalStatus = "Inativo";
            }

        }
    }

	ElseIf ($AcaoSistema == "alterar")
   {
        $EstOrganizacionalCodigo	= $_POST['txtCodigo'];
        $EstOrganizacionalDescricao	= strtoupper(trim($_POST['txtEstOrganizacional']));
        $EstOrganizacionalSigla		= strtoupper(trim($_POST['txtEstOrganizacionalSigla']));
        $EstOrganizacionalSuperior	= $_POST['cmbEstruturaSuperior'];

        $sqlConsulta = "SELECT est_organizacional_lotacao_id FROM dados_unico.est_organizacional_lotacao WHERE UPPER(est_organizacional_lotacao_ds) = '" .strtoupper($EstOrganizacionalDescricao). "' AND est_organizacional_lotacao_sup_cd = " .$EstOrganizacionalSuperior." AND UPPER(est_organizacional_lotacao_sigla) = '" .strtoupper($EstOrganizacionalSigla). "' AND est_organizacional_lotacao_id <> " .$EstOrganizacionalCodigo;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

         If(pg_fetch_row($rsConsulta)==0)
         {  $Date=date("Y-m-d");
            $sqlAltera = "UPDATE dados_unico.est_organizacional_lotacao SET est_organizacional_lotacao_sup_cd = " .$EstOrganizacionalSuperior.", est_organizacional_lotacao_ds = '" .$EstOrganizacionalDescricao. "', est_organizacional_lotacao_sigla = '" .$EstOrganizacionalSigla. "',est_organizacional_lotacao_dt_alteracao = '" .$Date. "'WHERE est_organizacional_lotacao_id = " .$EstOrganizacionalCodigo;

            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'EstOrganizacionalLotacaoInicio.php ';</script>";
         }
        Else
        {	$MensagemErroBD = "ESTRUTURA ORGANIZACIONAL OU SIGLA J&Aacute; EXISTENTES.";
        }
   }

	ElseIf ($AcaoSistema == "alterarStatus")
    {
	    $Date=date("Y-m-d");
		$EstOrganizacionalCodigo 	= $_GET['cod'];
		$EstOrganizacionalStatusCod = $_GET['status'];
		If ($EstOrganizacionalStatusCod == 0)
        {  $EstOrganizacionalStatusCod = 1;
        }
        Else
        {  $EstOrganizacionalStatusCod = 0;
        }
		$sqlAltera = "UPDATE dados_unico.est_organizacional_lotacao SET est_organizacional_lotacao_st = " .$EstOrganizacionalStatusCod. ", est_organizacional_lotacao_dt_alteracao = '" .$Date. "' WHERE est_organizacional_lotacao_id = " .$EstOrganizacionalCodigo;
		pg_query(abreConexao(),$sqlAltera);
		echo "<script>window.location = 'EstOrganizacionalLotacaoInicio.php ';</script>";
    }


	ElseIf ($AcaoSistema == "excluir")
    {
        $ExcluirCheckbox = $_GET['excluirMultiplo'];

        If ($ExcluirCheckbox == 1)
        {
            $EstOrganizacionalCodigo	= $_POST['txtCodigo'];
            $sqlDeleta = "UPDATE dados_unico.est_organizacional_lotacao SET est_organizacional_lotacao_st = 2 WHERE est_organizacional_lotacao_id IN (" .$EstOrganizacionalCodigo. ")";
        }
        Else
        {
            $EstOrganizacionalCodigo	= $_GET['cod'];
            $sqlDeleta = "UPDATE dados_unico.est_organizacional_lotacao SET est_organizacional_lotacao_st = 2  WHERE est_organizacional_lotacao_id = " .$EstOrganizacionalCodigo;
        }
         pg_query(abreConexao(),$sqlDeleta);


        echo "<script>window.location = 'EstOrganizacionalLotacaoInicio.php ';</script>";

    }

?>
