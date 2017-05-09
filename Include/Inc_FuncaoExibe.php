<?php
/*
**************************************************
combo que carrega as pessoas juridicas
**************************************************
 *
 */
function f_ExibePJ($codigoEscolhido)
{  $sql = "SELECT pessoa_nm FROM dados_unico.pessoa WHERE pessoa_id = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  echo  $linha['pessoa_nm'];
   }

}
/*
**************************************************
exibe a funcao escolhida
**************************************************
 *
 */
function f_ConsultaFuncao($codigoEscolhido)
{  $sql = "SELECT funcao_ds FROM dados_unico.funcao WHERE funcao_id = $codigoEscolhido";
     
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   echo  $linha['funcao_ds'];

}

function f_ConsultaCargo($codigoEscolhido)
{  $sql = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = $codigoEscolhido";
   
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   echo  $linha['cargo_ds'];
}
/*
**************************************************
exibe a lotacao
**************************************************
 *
 */
function f_ConsultaLotacao($codigoEscolhido)
{  $sql = "SELECT lotacao_ds FROM dados_unico.lotacao WHERE lotacao_id = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   echo  $linha['lotacao_ds'];
}
/*
**************************************************
exibe o contrato
**************************************************
 *
 */
function f_ConsultaContrato($codigoEscolhido)
{  $sql = "SELECT contrato_ds FROM dados_unico.contrato WHERE contrato_id = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   echo  $linha['contrato_ds'];

}
/*
**************************************************
exibe tipo do contrato
**************************************************
 *
 */
function f_ConsultaContratoTipo($codigoEscolhido)
{  $sql = "SELECT contrato_tipo_ds FROM dados_unico.contrato_tipo WHERE contrato_tipo_id = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   echo  $linha['contrato_tipo_ds'];
}
/*
funcao para exibir titulo de formulario
 *
 */
function ExibirTitulo($strTitulo)
{ if($strTitulo!="")
  {  echo "<table cellpadding=0 cellspacing=0 border=0 width=100% height=30><tr><td class=titulo_pagina><font size=1>".$strTitulo. "</font></td></tr></table>";
  }
}
/*
**************************************************
exibe nome pessoa
**************************************************
 *
 */
function f_ConsultaNomeFuncionario($codigoEscolhido)
{  $sql = "SELECT p.pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND f.pessoa_id = $codigoEscolhido";
//{  $sql = "SELECT pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND f.pessoa_id= '".$codigoEscolhido."'";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   echo  $linha['pessoa_nm'];
}

 /*
**************************************************
exibe o meio de transporte
**************************************************
  *
  */
function f_ExibeMeioTransporte($codigoEscolhido)
{  
    $sql = "SELECT meio_transporte_ds FROM diaria.meio_transporte WHERE meio_transporte_id = $codigoEscolhido";
    $rs=pg_query(abreConexao(),$sql);
    $linha=pg_fetch_assoc($rs);
    if($linha)
    { 
        echo  $linha['meio_transporte_ds'];
    }
}
 /*
**************************************************
exibe o motivo
**************************************************
  *
  */
function f_ExibeMotivo($codigoEscolhido)
{  
   $sql = "SELECT motivo_ds FROM diaria.motivo WHERE motivo_id = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  
       echo  $linha['motivo_ds'];
   }
}
/*
**************************************************
exibe o submotivo
**************************************************
 *
 */
function f_ExibeSubMotivo($codigoEscolhido)
{  $sql = "SELECT sub_motivo_ds FROM diaria.sub_motivo WHERE sub_motivo_id = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  
       echo  $linha['sub_motivo_ds'];
   }

}

/*
**************************************************
exibe o projeto
**************************************************
 *
 */
function f_ExibeProjeto($codigoEscolhido)
{  $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_cd = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  echo  $linha['projeto_cd']." - ".$linha['projeto_ds'];
   }

}
/*
**************************************************
exibe o unidade de custo
**************************************************
 *
 */
function f_ExibeUnidadeCusto($codigoEscolhido)
{  $sql = "SELECT est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  echo  $linha['est_organizacional_sigla']." - ".$linha['est_organizacional_ds'];
   }

}
/*
**************************************************
exibe o acao
**************************************************
 *
 */
function f_ExibeAcao($codigoEscolhido)
{ $sql = "SELECT acao_cd, acao_ds FROM diaria.acao WHERE acao_cd = $codigoEscolhido";
  $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  echo  $linha['acao_cd']." - ".$linha['acao_ds'];
   }

}
/*
**************************************************
exibe o territorio
**************************************************
 *
 */
function f_ExibeTerritorio($codigoEscolhido)
{  $sql = "SELECT territorio_cd, territorio_ds FROM diaria.territorio WHERE territorio_cd = $codigoEscolhido";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  echo  $linha['territorio_cd']." - ".$linha['territorio_ds'];
   }

}
/*
**************************************************
exibe o fonte
**************************************************
 *
 */
function f_ExibeFonte($codigoEscolhido)
{  $sql = "SELECT fonte_cd, fonte_ds FROM diaria.fonte WHERE fonte_cd = '$codigoEscolhido'";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   if($linha)
   {  echo  $linha['fonte_cd']." - ".$linha['fonte_ds'];
   }

}

Function f_ExibeTipoVeiculo($codigoEscolhido)
{
	if ($codigoEscolhido != "") 
	{ 
    	$sql = "SELECT tipo_veiculo_ds FROM transporte.tipo_veiculo where tipo_veiculo_id = $codigoEscolhido";
   
    	$rs = pg_query(abreConexao(),$sql);
		$linhars=pg_fetch_assoc($rs);

    	if($linhars)
    	{    
			return $linhars['tipo_veiculo_ds'];
    	} 
	}

}
?>
