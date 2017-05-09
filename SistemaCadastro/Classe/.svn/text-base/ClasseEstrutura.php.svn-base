<?php
    //define o nome da pagina local para facilitar nos links
	$PaginaLocal = "EstOrganizacional";

	//controla a visibilidade do botao consultar
	$_SESSION['BotaoConsultar'] = 0;


	$ErroBD = 0;

	If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
    {
        $numFiltro = $_GET['filtro'];

        If ($numFiltro != "")
        {
            $strStringSQL = "tFilha.est_organizacional_st = " .$numFiltro;
        }
        Else
        {	$strStringSQL = "tFilha.est_organizacional_st <> 2";

        }


        If ($RetornoFiltro != "")
        {
            $sqlConsulta = "SELECT tFilha.est_organizacional_id, tFilha.est_organizacional_ds, tFilha.est_organizacional_sigla, tPai.est_organizacional_sigla AS EstSuperior, tFilha.est_organizacional_st, tFilha.est_organizacional_dt_criacao,tFilha.est_organizacional_dt_alteracao, tFilha.est_organizacional_centro_custo, tFilha.est_organizacional_centro_custo_num FROM dados_unico.est_organizacional tFilha LEFT JOIN dados_unico.est_organizacional tPai ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd) WHERE " .$strStringSQL. " AND (tFilha.est_organizacional_ds ILIKE '%" .$RetornoFiltro. "%') OR (tFilha.est_organizacional_sigla ILIKE '%" .$RetornoFiltro. "%') ORDER BY UPPER(tFilha.est_organizacional_sigla)";
        }
        Else
        {	$sqlConsulta = "SELECT tFilha.est_organizacional_id, tFilha.est_organizacional_ds, tFilha.est_organizacional_sigla, tPai.est_organizacional_sigla AS EstSuperior, tFilha.est_organizacional_st, tFilha.est_organizacional_dt_criacao,tFilha.est_organizacional_dt_alteracao, tFilha.est_organizacional_centro_custo, tFilha.est_organizacional_centro_custo_num FROM dados_unico.est_organizacional tFilha LEFT JOIN dados_unico.est_organizacional tPai ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd) WHERE " .$strStringSQL. " ORDER BY UPPER(tFilha.est_organizacional_sigla)";
        }
      
      $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    }

	ElseIf ($AcaoSistema == "incluir")
    {
			$DataCriacao 				 = date("Y-m-d");
			$EstOrganizacionalDescricao	 = strtoupper(trim($_POST['txtEstOrganizacional']));
			$EstOrganizacionalSigla		 = strtoupper(trim($_POST['txtEstOrganizacionalSigla']));
			$EstOrganizacionalSuperiorCod = $_POST['cmbEstruturaSuperior'];
			$CentroCusto 				 = $_POST['rdCentro'];
			$CentroCustoNumero			 = trim($_POST['txtCentroCusto']);
			$CentroCustoTransporte		 = $_POST['rdCentroTransporte'];
			$CentroCustoAcompanhamento	 = $_POST['rdCentroAcompanhamento'];

			If ($CentroCustoNumero != "")
            {
				$strParametroConsulta = "(est_organizacional_centro_custo_num = '" .$CentroCustoNumero. "') OR";
            }
			Else
			{	$strParametroConsulta = "";

            }
			

			//verifica se ja existe a estrutura
			$sqlConsulta = "SELECT est_organizacional_id FROM dados_unico.est_organizacional WHERE " .$strParametroConsulta." UPPER(est_organizacional_ds) = '" .strtoupper($EstOrganizacionalDescricao). "' OR UPPER(est_organizacional_sigla) = '" .strtoupper($EstOrganizacionalSigla). "'";
			$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
            If(pg_fetch_row($rsConsulta)==0)
            {
			
				$sqlInsere = "INSERT INTO dados_unico.est_organizacional (est_organizacional_sup_cd, est_organizacional_ds, est_organizacional_sigla, est_organizacional_dt_criacao, est_organizacional_centro_custo, est_organizacional_centro_custo_num,est_organizacional_centro_custo_transporte,est_organizacional_centro_custo_acompanhamento) VALUES (".$EstOrganizacionalSuperiorCod. ", '" .$EstOrganizacionalDescricao. "','" .$EstOrganizacionalSigla. "', '" .$DataCriacao. "', " .$CentroCusto. ", '" .$CentroCustoNumero. "', ".$CentroCustoTransporte.", ".$CentroCustoAcompanhamento." )";
			
				pg_query(abreConexao(),$sqlInsere);

                $sqlCodigo= "SELECT  last_value FROM dados_unico.seq_est_organizacional";
				$rsCodigo = pg_query(abreConexao(),$sqlCodigo);
				$ultimoValorSeq=pg_fetch_assoc($rsCodigo);

				

				$sqlInsere = "INSERT INTO diaria.autorizador_acp (est_organizacional_id) VALUES (" .$ultimoValorSeq['last_value']. ")";
				pg_query(abreConexao(),$sqlInsere);
                echo "<script>window.location = 'EstOrganizacionalInicio.php ';</script>";
            }

			Else
			{	$MensagemErroBD = "ESTRUTURA ORGANIZACIONAL J&Aacute; CADASTRADA.";
            }
    }

	elseif ($AcaoSistema == "consultar")
	{
		$EstOrganizacionalCodigo = $_GET['cod'];
		if ($EstOrganizacionalCodigo =="")
		{
			$EstOrganizacionalCodigo = $_POST['checkbox'];
			$sqlConsulta = "SELECT tFilha.est_organizacional_id, tFilha.est_organizacional_ds, tFilha.est_organizacional_sigla, tPai.est_organizacional_ds AS EstSuperior, tFilha.est_organizacional_sup_cd, tFilha.est_organizacional_st, tFilha.est_organizacional_dt_criacao,tFilha.est_organizacional_dt_alteracao, tFilha.est_organizacional_centro_custo, tFilha.est_organizacional_centro_custo_num FROM dados_unico.est_organizacional tFilha LEFT JOIN dados_unico.est_organizacional tPai ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd) WHERE tFilha.est_organizacional_id IN (" .$EstOrganizacionalCodigo. ")";
		}
		else
		{
			$sqlConsulta = "SELECT tFilha.est_organizacional_id, 
														 tFilha.est_organizacional_ds, 
														 tFilha.est_organizacional_sigla,
														 tPai.est_organizacional_ds AS EstSuperior, 
														 tFilha.est_organizacional_sup_cd, 
														 tFilha.est_organizacional_st, 
														 tFilha.est_organizacional_dt_criacao, 
														 tFilha.est_organizacional_dt_alteracao, 
														 tFilha.est_organizacional_centro_custo, 
														 tFilha.est_organizacional_centro_custo_num,
														 tFilha.est_organizacional_centro_custo_transporte,
														 tFilha.est_organizacional_centro_custo_acompanhamento
												FROM dados_unico.est_organizacional tFilha 
									 LEFT JOIN dados_unico.est_organizacional tPai 
									  		  ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd)
											 WHERE tFilha.est_organizacional_id = " .$EstOrganizacionalCodigo;
		}

		$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
		$linha = pg_fetch_assoc($rsConsulta);

		if($linha)
		{
			$EstOrganizacionalSuperiorCod   = $linha['est_organizacional_sup_cd'];
			$EstOrganizacionalSuperior      = $linha['EstSuperior'];
			$EstOrganizacionalCodigo        = $linha['est_organizacional_id'];
			$EstOrganizacionalDescricao     = $linha['est_organizacional_ds'];
			$EstOrganizacionalSigla         = $linha['est_organizacional_sigla'];
			$EstOrganizacionalStatusCod     = $linha['est_organizacional_st'];
			$EstOrganizacionalDataCriacao   = $linha['est_organizacional_dt_criacao'];
			$EstOrganizacionalDataAlteracao = $linha['est_organizacional_dt_alteracao'];
			$CentroCusto                    = $linha['est_organizacional_centro_custo'];
			$CentroCustoNumero              = $linha['est_organizacional_centro_custo_num'];
			$CentroCustoTransporte          = $linha['est_organizacional_centro_custo_transporte'];
			$CentroCustoAcompanhamento      = $linha['est_organizacional_centro_custo_acompanhamento'];				
			
			if ($EstOrganizacionalStatusCod == "0")
			{
				$EstOrganizacionalStatus = "Ativo";
			}
			else
			{
				$EstOrganizacionalStatus = "Inativo";
			}
		}
	}

	elseif ($AcaoSistema == "alterar")
	{
		$DataAlteracao              = date("Y-m-d");
		$EstOrganizacionalCodigo    = $_POST['txtCodigo'];
		$EstOrganizacionalDescricao = strtoupper(trim($_POST['txtEstOrganizacional']));
		$EstOrganizacionalSigla     = strtoupper(trim($_POST['txtEstOrganizacionalSigla']));
		$EstOrganizacionalSuperior  = $_POST['cmbEstruturaSuperior'];
		$CentroCusto                = $_POST['rdCentro'];
		$CentroCustoNumero          = trim($_POST['txtCentroCusto']);
		$CentroCustoTransporte      = $_POST['rdCentroTransporte'];
		$CentroCustoAcompanhamento  = $_POST['rdCentroAcompanhamento'];
		
		$sqlConsulta = "SELECT est_organizacional_id FROM dados_unico.est_organizacional WHERE UPPER(est_organizacional_ds) = '" .strtoupper($EstOrganizacionalDescricao). "' AND est_organizacional_sup_cd = " .$EstOrganizacionalSuperior. " AND UPPER(est_organizacional_sigla) = '" .strtoupper($EstOrganizacionalSigla). "' AND est_organizacional_id <> " .$EstOrganizacionalCodigo;
		$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

		if (pg_fetch_row($rsConsulta)==0)
		{
			$sqlAltera = "UPDATE dados_unico.est_organizacional SET est_organizacional_sup_cd = " .$EstOrganizacionalSuperior. ", est_organizacional_ds = '" .$EstOrganizacionalDescricao."', est_organizacional_sigla = '" .$EstOrganizacionalSigla. "', est_organizacional_dt_alteracao = '" .$DataAlteracao. "', est_organizacional_centro_custo = " .$CentroCusto. ", est_organizacional_centro_custo_transporte = " .$CentroCustoTransporte.",est_organizacional_centro_custo_acompanhamento = " .$CentroCustoAcompanhamento.", est_organizacional_centro_custo_num = '" .$CentroCustoNumero. "' WHERE est_organizacional_id = " .$EstOrganizacionalCodigo;
			pg_query(abreConexao(),$sqlAltera);
			echo "<script>window.location = 'EstOrganizacionalInicio.php ';</script>";
		}
		else
		{
			$MensagemErroBD = "ESTRUTURA ORGANIZACIONAL OU SIGLA J&Aacute; EXISTENTES.";
		}
	}
	elseif ($AcaoSistema == "alterarStatus")
    {
		$DataCriacao 				= date("Y-m-d");
		$EstOrganizacionalCodigo 	= $_GET['cod'];
		$EstOrganizacionalStatusCod = $_GET['status'];

		If ($EstOrganizacionalStatusCod == 0)
        {  $EstOrganizacionalStatusCod = 1;
        }
        Else
        {  $EstOrganizacionalStatusCod = 0;
        }
		$sqlAltera = "UPDATE dados_unico.est_organizacional SET est_organizacional_st = " .$EstOrganizacionalStatusCod. ", est_organizacional_dt_alteracao = '" .$DataCriacao. "' WHERE est_organizacional_id = " .$EstOrganizacionalCodigo;
		pg_query(abreConexao(),$sqlAltera);
		 echo "<script>window.location = 'EstOrganizacionalInicio.php ';</script>";
    }

	ElseIf ($AcaoSistema == "excluir")
    {
        $ExcluirCheckbox = $_GET['excluirMultiplo'];

        If ($ExcluirCheckbox == 1)
        {
            $EstOrganizacionalCodigo	= $_POST['txtCodigo'];
            $sqlDeleta = "UPDATE dados_unico.est_organizacional SET est_organizacional_st = 2 WHERE est_organizacional_id IN (" .$EstOrganizacionalCodigo. ")";
        }
        Else
        {	$EstOrganizacionalCodigo	= $_GET['cod'];
            $sqlDeleta = "UPDATE dados_unico.est_organizacional SET est_organizacional_st = 2  WHERE est_organizacional_id = " .$EstOrganizacionalCodigo;
        }

        pg_query(abreConexao(),$sqlDeleta);


        echo "<script>window.location = 'EstOrganizacionalInicio.php ';</script>";

    }

?>
