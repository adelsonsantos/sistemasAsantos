<?php

		$PaginaLocal 		= "Relatorio";

		$vetData = explode("/", $_POST['txtDataComprovaIni']);
        $Dia = $vetData[0];
        $Mes = $vetData[1];
        $Ano = $vetData[2];
        if(strlen($Dia)==1)
        { $Dia = "0". $Dia;
        }
        if (strlen($Mes)==1)
        {	$Mes = "0" . $Mes;
        }
        $DataComprovacaoIni=implode("/", array($Dia,$Mes,$Ano));

        $vetData = explode("/", $_POST['txtDataComprovaFim']);
        $Dia = $vetData[0];
        $Mes = $vetData[1];
        $Ano = $vetData[2];
        if(strlen($Dia)==1)
        { $Dia = "0". $Dia;
        }
        if (strlen($Mes)==1)
        {	$Mes = "0" . $Mes;
        }
        $DataComprovacaoFim=implode("/", array($Dia,$Mes,$Ano));
		
        $Beneficiario_id		= $_POST['cmbBeneficiario'];
		$FiltrarProjeto         = $_POST['FiltrarProjeto'];
		$Projeto_id 			= $_POST['cmbProjeto'];
		$checkExrato			= $_POST['checkExrato'];

		$sqlConsulta = "SELECT pessoa_id, pessoa_nm, pessoa_tipo, pessoa_email, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao FROM dados_unico.pessoa where pessoa_id =".$Beneficiario_id;

    	$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

        $linhaConsulta=pg_fetch_assoc($rsConsulta);

        if($linhaConsulta)
        {  $Beneficiario	= 	$linhaConsulta['pessoa_nm'];
        }

	    If ($checkExrato == "on")
		{ $sqlConsulta = "SELECT * FROM diaria.diaria_comprovacao cmp ,diaria.diaria dia  where dia.diaria_excluida = 0  and  dia.diaria_id = cmp.diaria_id and dia.diaria_beneficiario = ".$Beneficiario_id." and  (to_date(dia.diaria_dt_saida,'DD-MM-YYYY') >= '".$DataComprovacaoIni. "' and to_date(dia.diaria_dt_saida,'DD-MM-YYYY') <= '".$DataComprovacaoFim."')";
        }
        else
		{  $sqlConsulta = "SELECT * FROM diaria.diaria_comprovacao cmp ,diaria.diaria dia  where dia.diaria_excluida = 0 and dia.diaria_st >= 3  and  dia.diaria_id = cmp.diaria_id and dia.diaria_beneficiario = ".$Beneficiario_id." and  (to_date(dia.diaria_dt_saida,'DD-MM-YYYY') >= '".$DataComprovacaoIni. "' and to_date(dia.diaria_dt_saida,'DD-MM-YYYY') <= '".$DataComprovacaoFim."')";
        }


		$sqlConsulta = "SELECT * FROM diaria.diaria_comprovacao cmp ,diaria.diaria dia  where dia.diaria_excluida = 0 and dia.diaria_st >= 3  and  dia.diaria_id = cmp.diaria_id and dia.diaria_beneficiario = ".$Beneficiario_id." and  (to_date(dia.diaria_dt_saida,'DD-MM-YYYY') >= '".$DataComprovacaoIni. "' and to_date(dia.diaria_dt_saida,'DD-MM-YYYY') <= '".$DataComprovacaoFim."')";

	    If ($FiltrarProjeto == "on")
        {

		  $sqlConsulta = $sqlConsulta." and projeto_cd = ".$Projeto_id;

		  $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_cd = " .$Projeto_id;
		  $rs = pg_query(abreConexao(),$sql);
          $linha=pg_fetch_assoc($rs);

          If ($linha)
          {  $ProjetoDescricao = $linha['projeto_cd'];
          }

        }

		$sqlConsulta = $sqlConsulta." order by to_date(dia.diaria_dt_saida,'DD-MM-YYYY')";


	$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

?>
