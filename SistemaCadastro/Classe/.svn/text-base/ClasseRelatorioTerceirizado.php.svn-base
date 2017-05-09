<?php

	$sqlConsulta = "SELECT * FROM dados_unico.pessoa p, dados_unico.funcionario f, dados_unico.contrato c, dados_unico.funcao func,dados_unico.funcionario_lotacao lotFuc,dados_unico.lotacao lot WHERE (lot.lotacao_id = lotFuc.lotacao_id) and  (lotFuc.funcionario_id = f.funcionario_id) and (f.funcao_id = func.funcao_id ) AND (c.contrato_id = f.contrato_id) AND (p.pessoa_id = f.pessoa_id)";


	if ($_POST['cmbContrato']!= 0)
    {

		$Contrato= $_POST['cmbContrato'];
		$sqlConsulta = $sqlConsulta." AND c.contrato_id = ".$Contrato;
    }



	if ($_POST['cmbLotacao']!= 0)
    {
		$Lotacao= $_POST['cmbLotacao'];
		$sqlConsulta = $sqlConsulta." AND lotFuc.lotacao_id = ".$Lotacao;
    }


 	if ($_POST['cmbFuncao'] != 0)
    {
		$Funcao= $_POST['cmbFuncao'];
		$sqlConsulta = $sqlConsulta. " AND f.funcao_id = ".$Funcao;
    }

/*
	'**************************************************
	' Trata a Situação do Funcionário Terceirizado.
	'**************************************************
 *
 */
		if ($_POST['cmbSituacao'] == 0)
        {

        }
	   if ($_POST['cmbSituacao'] == 1)
       {
		$sqlConsulta = $sqlConsulta." and funcionario_dt_demissao = '' ";
       }

		if($_POST['cmbSituacao']== 2)
        {  $sqlConsulta = $sqlConsulta." and funcionario_dt_demissao <> '' ";

        }
	/*
	'**************************************************

     *
     */
	 $sqlConsulta = $sqlConsulta."ORDER BY UPPER(pessoa_nm)";

     $rsConsulta = pg_query(abreConexao(),$sqlConsulta);


?>
