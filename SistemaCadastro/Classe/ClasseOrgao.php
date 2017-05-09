<?php

		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Orgao";
		
		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;			
	
		If (($AcaoSistema == "buscar") ||($AcaoSistema ==""))
		{
			$numFiltro = $_GET['filtro'];
			
			If ($numFiltro != "")
            {
				$strStringSQL = "orgao_st = " .$numFiltro;
            }
			Else
			{	$strStringSQL = "orgao_st <> 2";
                
            }
			
			//fim do filtro 		
			
			If ($RetornoFiltro != "")
            {
				$sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE " .$strStringSQL. " AND orgao_id <> 0 AND orgao_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(orgao_ds)";
            }
			Else
			{	$sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE " .$strStringSQL. " AND orgao_id <> 0 ORDER BY UPPER(orgao_ds)";
            }
             $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }        	
		ElseIf($AcaoSistema == "incluir")
        {
		
            $DataCriacao 	= date("Y-m-d");
            $OrgaoDescricao	= strtoupper(trim($_POST['txtOrgao']));

            $sqlConsulta = "SELECT orgao_id FROM dados_unico.orgao WHERE UPPER(orgao_ds) = '" .strtoupper($OrgaoDescricao)."'";

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If (pg_fetch_row($rsConsulta)==0)
            {

                $sqlInsere = "INSERT INTO dados_unico.orgao (orgao_ds, orgao_dt_criacao) VALUES ('" .$OrgaoDescricao. "', '" .$DataCriacao. "')";

                pg_query(abreConexao(),$sqlInsere);
                echo "<script>window.location = 'OrgaoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "&Oacute;RG&Atilde;O J&Aacute; EXISTENTE.";
            }
        }
	
		ElseIf ($AcaoSistema == "consultar")
        {
		
            $OrgaoCodigo = $_GET['cod'];

            If ($OrgaoCodigo == "")
            {

                $OrgaoCodigo = $_POST['checkbox'];

                $sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE orgao_id IN (".$OrgaoCodigo. ")";
            }

            Else
            { $sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE orgao_id = " .$OrgaoCodigo;

            }
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
            $linha=pg_fetch_assoc($rsConsulta);

            If($linha)
            {
                $OrgaoDescricao	   = $linha['orgao_ds'];
                $OrgaoStatusCod	   = $linha['orgao_st'];
                $OrgaoDataCriacao   = $linha['orgao_dt_criacao'];
                $OrgaoDataAlteracao = $linha['orgao_dt_alteracao'];

                If ($OrgaoStatusCod == "0")
                {  $OrgaoStatus = "Ativo";

                }
                 Else
                 {  $OrgaoStatus = "Inativo";

                 }

            }
        }
							
		ElseIf ($AcaoSistema == "alterar")
        {

            $DataAlteracao	= date("Y-m-d");
            $OrgaoCodigo	= $_POST['txtCodigo'];
            $OrgaoDescricao	= strtoupper(trim($_POST['txtOrgao']));

            $sqlConsulta = "SELECT orgao_id FROM dados_unico.orgao WHERE UPPER(orgao_ds) = '" .strtoupper($OrgaoDescricao). "' AND orgao_id <> " .$OrgaoCodigo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If(pg_fetch_row($rsConsulta)==0)
            {

                    $sqlAltera = "UPDATE dados_unico.orgao SET orgao_ds = '" .$OrgaoDescricao. "', orgao_dt_alteracao = '" .$DataAlteracao. "' WHERE orgao_id = " .$OrgaoCodigo;
                    pg_query(abreConexao(),$sqlAltera);

                     echo "<script>window.location = 'OrgaoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "&Oacute;RG&Atilde;O J&Aacute; EXISTENTE.";
            }
        }
		ElseIf ($AcaoSistema == "alterarStatus")
        {
            $DataAlteracao 	= date("Y-m-d");
			$OrgaoCodigo 	= $_GET['cod'];
		    $OrgaoStatusCod = $_GET['status'];
					
            If ($OrgaoStatusCod == 0)
            {  $OrgaoStatusCod = 1;

            }
            Else
            {  $OrgaoStatusCod = 0;

            }

            $sqlAltera = "UPDATE dados_unico.orgao SET orgao_st = " .$OrgaoStatusCod. ", orgao_dt_alteracao = '" .$DataAlteracao."' WHERE orgao_id = " .$OrgaoCodigo;
            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'OrgaoInicio.php ';</script>";
        }
		ElseIf ($AcaoSistema == "excluir")
        {
				
            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {
                $OrgaoCodigo = $_POST['txtCodigo'];
                $sqlDeleta   = "UPDATE dados_unico.orgao SET orgao_st = 2 WHERE orgao_id IN (" .$OrgaoCodigo. ")";
            }
            Else
            {	$OrgaoCodigo = $_GET['cod'];
                $sqlDeleta   = "UPDATE dados_unico.orgao SET orgao_st = 2  WHERE orgao_id = " .$OrgaoCodigo;
            }

            pg_query(abreConexao(),$sqlDeleta);
            echo "<script>window.location = 'OrgaoInicio.php ';</script>";
        }
?>