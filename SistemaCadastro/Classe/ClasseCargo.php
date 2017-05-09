<?php
		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Cargo";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = false;



		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {

			$numFiltro =  $_GET['filtro'];

            If ($numFiltro != "")
            {
                $strStringSQL = "cargo_st = " .$numFiltro;
            }
            Else
            {	$strStringSQL = "cargo_st <> 2";

            }


            If ($RetornoFiltro != "")
            {
                $sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND (c.classe_id = cl.classe_id) AND " .$strStringSQL. " AND cargo_id <> 0 AND cargo_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(cargo_ds)";
            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND (c.classe_id = cl.classe_id) AND " .$strStringSQL. " AND cargo_id <> 0 ORDER BY UPPER(cargo_ds)";
            }

           $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {
            $numTipo		=  $_POST['cmbFuncionarioTipo'];
            $numClasse		=  $_POST['cmbClasse'];
            $strDescricao	= strtoupper(trim( $_POST['txtDescricao']));

            $sqlConsulta = "SELECT cargo_id FROM dados_unico.cargo WHERE cargo_st <> 2 AND UPPER(cargo_ds) = '" .strtoupper($strDescricao). "' AND classe_id = " .$numClasse;
            $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);



            If (pg_fetch_row($rsConsulta)==0)
            {   $Date=date("Y-m-d");

                $sqlInsere = "INSERT INTO dados_unico.cargo (cargo_ds, classe_id, cargo_dt_criacao, funcionario_tipo_id) VALUES ('" .$strDescricao. "', '" .$numClasse. "', '" .$Date. "', " .$numTipo. ")";
                pg_query(abreConexao(),$sqlInsere);

                echo "<script>window.location = 'CargoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "CARGO J&Aacute;  EXISTENTE.";
            }
        }

		ElseIf ($AcaoSistema == "consultar")
        {

            $numCodigo =  $_GET['cod'];

            If ($numCodigo == "")
            {

                $numCodigo =  $_POST['checkbox'];

                $sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND (c.classe_id = cl.classe_id) AND cargo_id IN (" .$numCodigo. ")";


            }
            Else
            {	$sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND (c.classe_id = cl.classe_id) AND cargo_id = " .$numCodigo;
            }


          $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
          $linha=pg_fetch_assoc($rsConsulta);

            If($linha)
            {


                $numClasse	   	  = $linha['classe_id'];
                $strClasse	   	  = "Classe ".$linha['classe_nm'];
                $numTipo		  = $linha['funcionario_tipo_id'];
                $strTipo		  = $linha['funcionario_tipo_ds'];
                $strDescricao	  = $linha['cargo_ds'];
                $numStatus	      = $linha['cargo_st'];
                $strDataCriacao   = $linha['cargo_dt_criacao'];
                $strDataAlteracao = $linha['cargo_dt_alteracao'];

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
                   
            $numCodigo		=  $_POST['txtCodigo'];
            $numTipo		=  $_POST['cmbFuncionarioTipo'];
            $numClasse		=  $_POST['cmbClasse'];
            $strDescricao	= strtoupper(trim( $_POST['txtDescricao']));

            $sqlConsulta 	= "SELECT cargo_id FROM dados_unico.cargo WHERE cargo_st <> 2 AND UPPER(cargo_ds) = '".strtoupper($strDescricao). "' AND classe_id = " .$numClasse. " AND cargo_id <> " .$numCodigo;
            $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);

            If(pg_fetch_row($rsConsulta)==0)
            {       $Date=date("Y-m-d");
                    $sqlAltera = "UPDATE dados_unico.cargo SET funcionario_tipo_id = " .$numTipo. ", classe_id = '" .$numClasse. "', cargo_ds = '" .$strDescricao. "', cargo_dt_alteracao = '" .$Date. "' WHERE cargo_id = " .$numCodigo;
                    pg_query(abreConexao(),$sqlAltera);

                    echo "<script>window.location = 'CargoInicio.php ';</script>";
            }

            Else
            {	$MensagemErroBD = "CARGO J&Aacute;  EXISTENTE.";

            }
        }

		ElseIf ($AcaoSistema == "alterarStatus")
        {
            $numCodigo 		 =  $_GET['cod'];
            $numStatus 		 =  $_GET['status'];
            $Date=date("Y-m-d");

            If ($numStatus == 0)
            {  $numStatus = 1;

            }
            Else
            {  $numStatus = 0;

            }

            $sqlAltera = "UPDATE dados_unico.cargo SET cargo_st = " .$numStatus. ", cargo_dt_alteracao = '".$Date. "' WHERE cargo_id = " .$numCodigo;
            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'CargoInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
        {
            $ExcluirCheckbox =  $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {	$numCodigo	=  $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE dados_unico.cargo SET cargo_st = 2 WHERE cargo_id IN (" .$numCodigo. ")";
            }
            Else
            {	$numCodigo	=  $_GET['cod'];
                $sqlDeleta = "UPDATE dados_unico.cargo SET cargo_st = 2  WHERE cargo_id = " .$numCodigo;
               }

            pg_query(abreConexao(),$sqlDeleta);

            echo "<script>window.location = 'CargoInicio.php ';</script>";

		}

?>
