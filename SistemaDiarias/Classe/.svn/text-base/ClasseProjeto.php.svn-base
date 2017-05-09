<?php

    //define o nome da pagina local para facilitar nos links
    $PaginaLocal = "Projeto";

    //controla a visibilidade do botao consultar
    $_SESSION['BotaoConsultar']= 0;

    If (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
    {
        $numFiltro = $_GET['filtro'];

        If ($numFiltro != "")
        {
            $strStringSQL = "projeto_st = ".$numFiltro;
        }
        Else
        {   $strStringSQL = "projeto_st <> 2";

        }
        If ($RetornoFiltro != "")
        {
           // $sqlConsulta = "SELECT * FROM diaria.projeto WHERE ".$strStringSQL." AND ((projeto_ds ILIKE '%".$RetornoFiltro."%') OR (projeto_cd ILIKE '%".$RetornoFiltro."%')) ORDER BY (projeto_cd)";
            $sqlConsulta = "SELECT * FROM diaria.projeto WHERE ".$strStringSQL." AND ((projeto_ds ILIKE '%".$RetornoFiltro."%')) ORDER BY (projeto_cd)";
        }
        Else
        {    $sqlConsulta = "SELECT * FROM diaria.projeto WHERE ".$strStringSQL." ORDER BY (projeto_cd)";
        }
		//echo  $sqlConsulta; EXIT(); 
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    }

    ElseIf ($AcaoSistema == "incluir")
    {
                $Date       =date("Y-m-d");
                $Numero		= trim($_POST['txtNumero']);
                $Saldo		= $_POST['txtSaldo'];
                $Descricao	= strtoupper(trim($_POST['txtDescricao']));

                $sqlConsulta = "SELECT projeto_cd FROM diaria.projeto WHERE UPPER(projeto_ds) = '".strtoupper($Descricao)."' OR projeto_cd = '".$Numero."'";
                $rsConsulta = pg_query(abreConexao(),$sqlConsulta);


                If(pg_fetch_row($rsConsulta)==0)
                {   $sqlInsere = "INSERT INTO diaria.projeto (projeto_cd, projeto_saldo, projeto_ds, projeto_dt_criacao) VALUES ('".$Numero. "','".$Saldo."','".$Descricao."', '".$Date."')";
                    pg_query(abreConexao(),$sqlInsere);
                    echo "<script>window.location = 'ProjetoInicio.php ';</script>";
                }
                Else
                {    $MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";

                }
    }

    ElseIf ($AcaoSistema == "consultar")
    {

                $Codigo = $_GET['cod'];

                If ($Codigo == "")
                {

                    $Codigo = $_POST['checkbox'];

                    $sqlConsulta = "SELECT * FROM diaria.projeto WHERE projeto_cd IN (".$Codigo.")";
                }

                Else
                {    $sqlConsulta = "SELECT * FROM diaria.projeto WHERE projeto_cd = '".$Codigo."' ";

                }
                $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                $linhaConsulta=pg_fetch_assoc($rsConsulta);

                If ($linhaConsulta)
                {

                    $Codigo	  	  = $linhaConsulta['projeto_cd'];
                    $Numero	  	  = $linhaConsulta['projeto_cd'];
                    $Saldo		  = $linhaConsulta['projeto_saldo'];
                    $Descricao	  = $linhaConsulta['projeto_ds'];
                    $StatusNumero  = $linhaConsulta['projeto_st'];

                    If ($StatusNumero == "0")
                    {  $StatusNome = "Ativo";

                    }
                    Else
                    {  $StatusNome = "Inativo";
                    }
                  }
    }
    ElseIf ($AcaoSistema == "alterar")
    {
        $Date           =date("Y-m-d");
        $Codigo			= $_POST['txtCodigo'];
        $Saldo			= $_POST['txtSaldo'];
        $Descricao		= strtoupper(trim($_POST['txtDescricao']));

        $sqlConsulta = "SELECT projeto_cd FROM diaria.projeto WHERE (UPPER(projeto_ds) = '".strtoupper($Descricao)."') AND projeto_cd <> '".$Codigo."' ";
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

         $linhaConsulta=pg_fetch_assoc($rsConsulta);

        If(pg_fetch_row($rsConsulta)==0)
        {

            $sqlAltera = "UPDATE diaria.projeto SET projeto_saldo = '".$Saldo."', projeto_ds = '".$Descricao."', projeto_dt_alteracao = '".$Date."' WHERE projeto_cd = '".$Codigo."' ";
            pg_query(abreConexao(),$sqlAltera);

            echo "<script>window.location = 'ProjetoInicio.php ';</script>";
        }

        Else
        {    $MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE."	;
        }
    }
    ElseIf ($AcaoSistema == "alterarStatus")
    {
        $Date           =  date("Y-m-d");
        $Codigo 		= $_GET['cod'];
        $StatusNumero 	= $_GET['status'];

        If ($StatusNumero == 0)
        {   $StatusNumero = 1;

        }
         Else
         {  $StatusNumero = 0;

         }

        $sqlAltera = "UPDATE diaria.projeto SET projeto_st = ".$StatusNumero.", projeto_dt_alteracao = '".$Date."' WHERE projeto_cd = '".$Codigo."' ";
        pg_query(abreConexao(),$sqlAltera);

       echo "<script>window.location = 'ProjetoInicio.php ';</script>";
    }

    ElseIf ($AcaoSistema == "excluir")
    {

        $ExcluirCheckbox = $_GET['excluirMultiplo'];

        If ($ExcluirCheckbox == 1)
        {    $Codigo	= $_POST['txtCodigo'];
            $sqlDeleta  = "UPDATE diaria.projeto SET projeto_st = 2 WHERE projeto_cd IN ('".$Codigo."')";
        }
        Else
        {   $Codigo	= $_GET['cod'];
            $sqlDeleta = "UPDATE diaria.projeto SET projeto_st = 2  WHERE projeto_cd = '".$Codigo."' ";
        }
        pg_query(abreConexao(),$sqlDeleta);

       echo "<script>window.location = 'ProjetoInicio.php ';</script>";	

    }
?>
