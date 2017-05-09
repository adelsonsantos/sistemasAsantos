<?php

    //define o nome da pagina local para facilitar nos links
    $PaginaLocal = "DiariaEstorno";

    //controla a visibilidade do botao consultar
    $_SESSION['BotaoConsultar']= 0;
	
    If (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
    {
        If ($numFiltro != "")
        {
            $strStringSQL = $numFiltro;
        }
        Else
        {   $strStringSQL = "diaria_estorno_st <> 2";

        }
 //  Verifica se foi enviado um atributo
        If ($RetornoFiltro != "")
        {
//  Verifica se foi enviado um atributo
            if ($_GET['atributo']!='')
                {
//  Possui filtro e atributo
                    $sqlConsulta = "SELECT * FROM diaria.diaria d, diaria.diaria_comprovacao dc, diaria.diaria_estorno de, dados_unico.pessoa p,dados_unico.pessoa_fisica pf where  (de.diaria_estorno_st <> 2) and (d.diaria_id = de.diaria_id) and (d.diaria_id = dc.diaria_id) and (d.diaria_beneficiario = p.pessoa_id) and (p.pessoa_id = pf.pessoa_id) and ".$strStringSQL." and (d.diaria_numero ILIKE '%".$RetornoFiltro."%' or pf.pessoa_fisica_cpf ILIKE '%".$RetornoFiltro."%' or p.pessoa_nm ILIKE '%".$RetornoFiltro."%' ) ORDER BY ".$_GET['atributo'];
                }
            else
                {
//  Possui filtro, mas não possui atributo
                    $sqlConsulta = "SELECT * FROM diaria.diaria d, diaria.diaria_comprovacao dc, diaria.diaria_estorno de, dados_unico.pessoa p,dados_unico.pessoa_fisica pf where (de.diaria_estorno_st <> 2) and (d.diaria_id = de.diaria_id) and (d.diaria_id = dc.diaria_id) and (d.diaria_beneficiario = p.pessoa_id) and (p.pessoa_id = pf.pessoa_id) and ".$strStringSQL." and (d.diaria_numero ILIKE '%".$RetornoFiltro."%' or pf.pessoa_fisica_cpf ILIKE '%".$RetornoFiltro."%' or p.pessoa_nm ILIKE '%".$RetornoFiltro."%' ) ORDER BY (diaria_numero)";
                }
        }
        Else
        {
            if ($_GET['atributo']!='')
                { 
// Não possui filtro, mas posssui Atributo.
                    $sqlConsulta = "SELECT * FROM diaria.diaria d, diaria.diaria_comprovacao dc, diaria.diaria_estorno de, dados_unico.pessoa p,dados_unico.pessoa_fisica pf  where (de.diaria_estorno_st <> 2) and (d.diaria_id = de.diaria_id) and (d.diaria_id = dc.diaria_id) and (d.diaria_beneficiario = p.pessoa_id) and (p.pessoa_id = pf.pessoa_id) and ".$strStringSQL." ORDER BY ".$_GET['atributo'];
                  
                }
              else
                {
// Não possui atributo e não possui filtro
                    $sqlConsulta = "SELECT * FROM diaria.diaria d, diaria.diaria_comprovacao dc, diaria.diaria_estorno de, dados_unico.pessoa p,dados_unico.pessoa_fisica pf  where (de.diaria_estorno_st <> 2) and (d.diaria_id = de.diaria_id) and (d.diaria_id = dc.diaria_id) and (d.diaria_beneficiario = p.pessoa_id) and (p.pessoa_id = pf.pessoa_id) and ".$strStringSQL." ORDER BY UPPER(diaria_numero)";
                }
        }
		//echo $sqlConsulta;
                $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    }
	elseif ($AcaoSistema == "EstornoFinanceiro")
	{	
	
		
		$Date               = date("Y-m-d");
		$Time				= date("H:i:s");
		$Codigo				= $_GET['cod'];
		
		$sqlAltera = "UPDATE diaria.diaria_estorno SET 
												diaria_estorno_financeiro=".$_SESSION['UsuarioCodigo'].",
												diaria_estorno_dt_financeiro='".$Date."',
												diaria_estorno_hr_financeiro='".$Time."',
												diaria_estorno_situacao=2,
												diaria_estorno_dt_alteracao='".$Date."'													
												WHERE diaria_id = '".$Codigo."'";;
		
		pg_query(abreConexao(),$sqlAltera);
		
		echo "<script>window.location = 'DiariaEstornoInicio.php';</script>";
	}elseif ($AcaoSistema == "ImprimirEstorno")
	{
            $strStringSQL = $_GET['Multiplos'];
            //$strStringSQL = substr($strStringSQL,0, -1); // o JS ja esta tratando a virgula final;

            $sqlConsulta = "SELECT * FROM diaria.diaria d, diaria.diaria_comprovacao dc, diaria.diaria_estorno de, dados_unico.pessoa p,dados_unico.pessoa_fisica pf  where (de.diaria_estorno_st <> 2) and (d.diaria_id = de.diaria_id) and (d.diaria_id = dc.diaria_id) and (d.diaria_beneficiario = p.pessoa_id) and (p.pessoa_id = pf.pessoa_id) and d.diaria_id in (".$strStringSQL.") ORDER BY UPPER(pessoa_nm)";
            //echo $sqlConsulta;
            //exit;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

            }

?>
