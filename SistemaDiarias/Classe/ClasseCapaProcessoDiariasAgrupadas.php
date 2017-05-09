<?php
    $Codigo = $_GET['cod'];

    $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf, diaria.diaria_motivo dm, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (d.diaria_id = dm.diaria_id) AND (p.pessoa_id = pf.pessoa_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id)
					AND d.super_sd = '$Codigo'";
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    //$linhaConsulta=pg_fetch_assoc($rsConsulta);
	$BeneficiarioNome = "";
	 
	while($linhaConsulta=pg_fetch_assoc($rsConsulta)){
    //If($linhaConsulta){
        $Numero 	       = $linhaConsulta['super_sd'];
        $PessoaCodigo      = $linhaConsulta['pessoa_id'];
        $Beneficiario      = $linhaConsulta['diaria_beneficiario'];
        $Nome              = $linhaConsulta['pessoa_nm'];
        $Matricula         = $linhaConsulta['funcionario_matricula'];
        $EstruturaAtuacao  = $linhaConsulta['est_organizacional_id'];
        $Escolaridade      = $linhaConsulta['nivel_escolar_id'];        
        $Processo          = $linhaConsulta['diaria_processo'];	
       	$UnidadeCusto           = $linhaConsulta['diaria_unidade_custo'];	
        $sql = "SELECT pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND f.pessoa_id= ".$Beneficiario;

        $rs = pg_query(abreConexao(),$sql);
        $linhars=pg_fetch_assoc($rs);

        If($linhars){
            if($BeneficiarioNome == ""){
				$BeneficiarioNome = $linhars['pessoa_nm'];
			}else{
				$BeneficiarioNome = $BeneficiarioNome." / ".$linhars['pessoa_nm'];
			}
        }
        
        $sql2 	= "SELECT est_organizacional_centro_custo_num, est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = ".$UnidadeCusto;
        $Consulta		= pg_query(abreConexao(),$sql2);

        $tupla	= pg_fetch_assoc($Consulta);

        $UnidadeCustoNumero = $tupla['est_organizacional_centro_custo_num'];
        $UnidadeCustoSigla  = $tupla['est_organizacional_sigla'];
        $UnidadeCustoNome   = $tupla['est_organizacional_ds'];
	}
?>