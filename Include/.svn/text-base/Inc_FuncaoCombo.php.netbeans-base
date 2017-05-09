<?php
/*
**************************************************
combo que carrega as pessoas juridicas
**************************************************
 *
 */
function f_ComboPJ($codigoEscolhido)
{ echo "<select name=cmbPJ style=width:300px>";
  $sql = "SELECT pessoa_id, pessoa_nm FROM dados_unico.pessoa WHERE pessoa_st = 0 AND pessoa_tipo = 'J' ORDER BY UPPER(pessoa_nm)";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[------------------------------------ Selecione ------------------------------------]</option>";
  while($linha=pg_fetch_assoc($rs))
  { $codigo = $linha['pessoa_id'];
	$descricao 	= $linha['pessoa_nm'];
	if ((int)$codigoEscolhido== (int)$codigo)
    {  echo "<option value=" .$codigo. " selected>" .$descricao."</option>";
    }
    else
    {  echo "<option value=" .$codigo.">".$descricao."</option>";
    }
  }
  echo "</select>";
}
/*
**************************************************
combo que carrega as pessoas juridicas para contrato
**************************************************
 *
 */
function f_ComboPJContrato($codigoEscolhido)
{ echo "<select name=cmbPJ style=width:300px>";
  $sql = "SELECT p.pessoa_id, pessoa_nm FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj WHERE (p.pessoa_id = pj.pessoa_id) AND pessoa_juridica_fornecedor = 1 AND pessoa_st = 0 AND pessoa_tipo = 'J' ORDER BY UPPER(pessoa_nm)";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[------------------------------------ Selecione ------------------------------------]</option>";
  while($linha=pg_fetch_assoc($rs))
  {  $codigo = $linha['pessoa_id'];
     $descricao = $linha['pessoa_nm'];
     if((int)$codigoEscolhido==(int)$codigo)
     {  echo "<option value=" .$codigo. " selected>".$descricao."</option>";
     }
	 else
     {  echo "<option value=".$codigo.">".$descricao."</option>";
     }

 }
 echo "</select>";

}
/*
 *consulta cargos permanentes e temporarios
 */
function f_ComboCargo($NomeCombo, $codigoEscolhido,$Tipo)
{  echo "<select name=".$NomeCombo." style=width:302px>";
   $sql = "SELECT * FROM dados_unico.cargo WHERE funcionario_tipo_id =".$Tipo." AND cargo_st = 0 AND cargo_id <> 0 ORDER BY UPPER(cargo_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------------------------------ Selecione ------------------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   {
     if ($codigoEscolhido==$linha['cargo_id'])
     {  echo "<option value=" .$linha['cargo_id']. " selected>".$linha['cargo_ds']. "</option>";
     }
	 else
     { echo"<option value=" .$linha['cargo_id']. ">".$linha['cargo_ds']. "</option>";
     }

   }
   echo "</select>";
}
/*
**************************************************
combo que carrega as funcoes
**************************************************
 *
 */
function f_ComboFuncao($codigoEscolhido)
{  echo "<select name=cmbFuncao style=width:260px>";
   $sql = "SELECT * FROM dados_unico.funcao WHERE funcao_st = 0 AND funcao_id <> 0 ORDER BY UPPER(funcao_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[----------------------------- Selecione -----------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   {  $codigo = $linha['funcao_id'];
      $descricao = $linha['funcao_ds'];
      if((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=" .$codigo. " selected>".$descricao."</option>";
      }
      else
      {  echo "<option value=".$codigo.">".$descricao. "</option>";
      }
   }
   echo "</select>";
}
/*
**************************************************
combo que carrega as lotacoes
**************************************************
 *
 */
function f_ComboLotacao($codigoEscolhido)
{  echo "<select name=cmbLotacao style=width:200px>";
   $sql = "SELECT * FROM dados_unico.lotacao WHERE lotacao_st = 0 AND lotacao_id <> 0 ORDER BY UPPER(lotacao_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------------- Selecione -------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   {  $codigo = $linha['lotacao_id'];
      $descricao = $linha['lotacao_ds'];
      if((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=".$codigo." selected>".$descricao."</option>";
      }
      else
      {  echo "<option value=".$codigo.">" .$descricao. "</option>";
      }
   }
   echo "</select>";
}
/*
**************************************************
combo que carrega contratos
**************************************************
 *
 */
function f_ComboContrato($codigoEscolhido)
{  /*  esta parte do codigo já estava comentada no asp e não sofreu alteração
   sqlTotal 	= "SELECT COUNT(*) FROM dados_unico.funcionario WHERE contrato_st = 0 AND contrato_id <> 0 ORDER BY UPPER(contrato_ds)"
   Set rsTotal = objConexao.execute(sqlTotal)
 *
 */
   echo "<select name=cmbContrato style=width:330px>";
   $sql = "SELECT * FROM dados_unico.contrato WHERE contrato_st = 0 AND contrato_id <> 0 ORDER BY UPPER(contrato_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[----------------------------------------- Selecione -----------------------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   { $codigo = $linha['contrato_id'];
	 $descricao = $linha['contrato_ds'];
	 $numero = $linha['contrato_num'];
	 $total = $linha['contrato_num_max'];
     
     $sqlConsultaTipo = "SELECT funcionario_tipo_id FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_terceirizado = 1";
	 $rsConsultaTipo=pg_query(abreConexao(),$sqlConsultaTipo);
     $linha2=pg_fetch_assoc($rsConsultaTipo);

     if($linha2)
     {  $CodigoTipo = $linha2['funcionario_tipo_id'];
     }
     
     $sqlConsultaQtde = "SELECT COUNT(funcionario_id) as Total FROM dados_unico.funcionario WHERE contrato_id = '".$codigo. "'"." AND funcionario_tipo_id = '".$CodigoTipo."'";
	 $rsConsultaQtde=pg_query(abreConexao(),$sqlConsultaQtde);
     /* esta parte do codigo já estava comentada no asp e não sofreu alteração
      * If CInt(total) > CInt(rsConsultaQtde("Total")) Then
      */
     if((int)$codigoEscolhido==(int)$codigo)
     {  echo "<option value=".$codigo." selected>".$numero." - " .$descricao."</option>";
     }
     else
     {  echo "<option value=".$codigo.">".$numero." - ".$descricao."</option>";
     }
   
  }
  echo "</select>";

}
/*
**************************************************
carrega os tipos de contrato
**************************************************
 *
 */
function f_ContratoTipo($codigoEscolhido)
{  echo "<select name=cmbContratoTipo style=width:160px>";
   $sql = "SELECT * FROM dados_unico.contrato_tipo ORDER BY UPPER(contrato_tipo_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------- Selecione ------------]</option>";
   echo "<option value=0></option>";
   while($linha=pg_fetch_assoc($rs))
   {  $codigo = $linha['contrato_tipo_id'];
	  $descricao = $linha['contrato_tipo_ds'];
	  if((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=".$codigo. " selected>".$descricao. "</option>";
      }
      else
      {  echo "<option value=" .$codigo. ">" .$descricao. "</option>";
      }
   }
   echo "</select>";
}


function f_ComboClasse($codigoEscolhido)
{  echo "<select name=cmbClasse style=width:260px>";
   $sql = "SELECT * FROM diaria.classe WHERE classe_st = 0 ORDER BY UPPER(classe_nm)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[----------------------------- Selecione -----------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   {  if((int)$codigoEscolhido==(int)($linha['classe_id']))
      { echo "<option value=" .$linha['classe_id']. " selected>" .$linha['classe_nm']. " - " .$linha['classe_ds']. "</option>";
      }
      else
      {  echo "<option value=" .$linha['classe_id']. ">" .$linha['classe_nm']. " - " .$linha['classe_ds']. "</option>";
      }
   }
   echo "</select>";
}

function f_ComboSistema($NomeCombo, $codigoEscolhido, $FuncaoJavaScript)
{  echo "<select name=".$NomeCombo. " style=width:240px " .$FuncaoJavaScript. ">";
   $sql = "SELECT sistema_id, sistema_nm FROM seguranca.sistema WHERE sistema_st = 0 ORDER BY UPPER(sistema_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[-------------------------- Selecione --------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {  $codigo = $linha['sistema_id'];
	   $descricao = $linha['sistema_nm'];
	   if((int)$codigoEscolhido==(int)$codigo)
       {  echo "<option value=" .$codigo. " selected>".$descricao. "</option>";
       }
       else
       {  echo "<option value=" .$codigo. ">" .$descricao. "</option>";
       }
    }
   echo "</select>";
}

function f_ComboSecao($NomeCombo, $codigoEscolhido, $codigoFiltro)
{  echo "<select name=" .$NomeCombo. " style=width:240px>";
   $sql = "SELECT * FROM seguranca.secao WHERE secao_st = 0 AND sistema_id = '" .$codigoFiltro."'". " ORDER BY UPPER(secao_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[-------------------------- Selecione --------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
    {  $codigo = $linha['secao_id'];
	   $descricao = $linha['secao_ds'];
          if((int)$codigoEscolhido==(int)$codigo)
       {  echo "<option value=" .$codigo. " selected>".$descricao. "</option>";
       }
       else
       {  echo "<option value=" .$codigo. ">" .$descricao. "</option>";
       }
    }
   echo "</select>";
}

?>
