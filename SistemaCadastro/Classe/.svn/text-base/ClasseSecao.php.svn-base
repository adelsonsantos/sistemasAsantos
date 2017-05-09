<?php

		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Secao";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = false;



		If (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
        {

            If ($RetornoFiltro != "")
            {
                $sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.sistema si WHERE (se.sistema_id = si.sistema_id) AND secao_st <> 2 AND secao_id <> 0 AND secao_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(sistema_nm), UPPER(secao_ds)";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.sistema si WHERE (se.sistema_id = si.sistema_id) AND secao_st <> 2 AND secao_id <> 0 ORDER BY UPPER(sistema_nm), UPPER(secao_ds)";
            }

           $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {

            $strDataCriacao = date("Y-m-d");
            $numSistema		= $_POST['cmbSistema'];
            $strDescricao	= trim($_POST['txtDescricao']);

            $sqlConsulta = "SELECT secao_id FROM seguranca.secao WHERE secao_st <> 2 AND UPPER(secao_ds) = '" .strtoupper($strDescricao). "' AND sistema_id = ".$numSistema;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            If (pg_fetch_row($rsConsulta)==0)
            {
                $sqlInsere = "INSERT INTO seguranca.secao (secao_ds, sistema_id, secao_dt_criacao) VALUES ('" .$strDescricao. "', '" .$numSistema. "', '".$strDataCriacao."')";
                pg_query(abreConexao(),$sqlInsere);
                echo "<script>window.location = 'SecaoInicio.php ';</script>";

            }
            Else
            {	$MensagemErroBD = "SE&Ccedil;&Atilde;O J&Aacute;  EXISTENTE.";
            }
        }

		ElseIf ($AcaoSistema == "consultar")
        {
            $numCodigo = $_GET['cod'];
            $sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.sistema si WHERE (se.sistema_id = si.sistema_id) AND secao_id = ".$numCodigo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            $linha=pg_fetch_assoc($rsConsulta);

            if($linha)
            {
                $numSistema	   	  = $linha['sistema_id'];
                $strSistema	   	  = $linha['sistema_nm'];
                $strDescricao	  = $linha['secao_ds'];
                $numStatus	      = $linha['secao_st'];
                $strDataCriacao   = $linha['secao_dt_criacao'];
                $strDataAlteracao = $linha['secao_dt_alteracao'];

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
            $strDataAlteracao = date("Y-m-d");
            $numCodigo		 =  $_POST['txtCodigo'];
            $numSistema		 =  $_POST['cmbSistema'];
            $strDescricao	 =  trim($_POST['txtDescricao']);

            $sqlConsulta = "SELECT secao_id FROM seguranca.secao WHERE secao_st <> 2 AND secao_ds = '".strtoupper($strDescricao)."' AND sistema_id = ".$numSistema. " AND secao_id <> ".$numCodigo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            if(pg_fetch_row($rsConsulta)==0)
            {
                    $sqlAltera = "UPDATE seguranca.secao SET sistema_id = '" .$numSistema. "', secao_ds = '" .$strDescricao. "', secao_dt_alteracao = '" .$strDataAlteracao."' WHERE secao_id = " .$numCodigo;
                    pg_query(abreConexao(),$sqlAltera);

                    echo "<script>window.location = 'SecaoInicio.php ';</script>";
            }
            Else
            {	$MensagemErroBD = "SE&Ccedil;&Atilde;O J&Aacute;  EXISTENTE.";

            }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {
            $strDataAlteracao = date("Y-m-d");
            $numCodigo 		 = $_GET['cod'];
            $numStatus 		 = $_GET['status'];

            If ($numStatus == 0)
            { $numStatus = 1;

            }
            Else
            {  $numStatus = 0;

            }
            $sqlAltera = "UPDATE seguranca.secao SET secao_st = ".$numStatus. ", secao_dt_alteracao = '".$strDataAlteracao. "' WHERE secao_id = " .$numCodigo;
            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'SecaoInicio.php ';</script>";
          }

		ElseIf ($AcaoSistema == "excluir")
        {
            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {
                $numCodigo	= $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE seguranca.secao SET secao_st = 2 WHERE secao_id IN (" .$numCodigo. ")";
            }
            Else
            {	$numCodigo	= $_GET['cod'];
                $sqlDeleta = "UPDATE seguranca.secao SET secao_st = 2  WHERE secao_id = " .$numCodigo;
            }

           pg_query(abreConexao(),$sqlDeleta);


            echo "<script>window.location = 'SecaoInicio.php ';</script>";

        }

?>
