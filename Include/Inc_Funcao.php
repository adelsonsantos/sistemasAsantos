<?php
function ConverteStringMoeda($valoreferencia){

    $Valortmp 		= str_replace("R$","",$valoreferencia); 
    $Valortmp		= str_replace(".","",$Valortmp);
    $Valortmp		= str_replace(",",".",$Valortmp); 
    return $Valortmp;
}

/*
**************************************************
função para inserir log diaria
**************************************************
 *
 */
function f_InsereLogDiaria ($Pessoa, $Diaria, $Descricao)
{
	$Time = date("H:i:s");
	$Date = date("Y-m-d");
	$sql = "INSERT INTO diaria.diaria_log (diaria_id, pessoa_id, diaria_log_dt, diaria_log_hr, diaria_log_ds) VALUES (".$Diaria.",".$Pessoa.",'".$Date."','".$Time."','".$Descricao."')";
	
	pg_query(abreConexao(),$sql);
}

/*
**************************************************
função para inserir log
**************************************************
 *
 */
function f_InsereLog($Descricao)
{ 
	$Time=date("H:i:s");
	$Date=date("Y-m-d");
	$sql = "INSERT INTO dados_unico.log_evento (pessoa_id, log_evento_dt, log_evento_hr, log_evento_ds) VALUES (".$_SESSION['UsuarioCodigo'].",'".$Date."','".$Time."','".$Descricao."')";
  pg_query(abreConexao(),$sql);
}
/*
**************************************************
função para tratar sql injection;
**************************************************
 *
 */
function TrataSqlInj($string)
{
    $string = (string) $string;
    $trataString = pg_escape_string(strtoupper(strtr(trim(stripslashes($string)),"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
    return $trataString;
}
/*'**************************************************

**************************************************
função para formata data no padrao DD/MM/AAAA
**************************************************
 *
 */

function f_FormataTime($Data)
{
	$hora = substr($Data,11,2);
	$minuto = substr($Data,14,2);
    
	If (strlen($hora)== 1)
    	{	$hora = "0".$hora;
    }
    If (strlen($minuto)== 1)
    	{ $minuto = "0".$minuto;
    }
	
	return $hora.":".$minuto;
}

function f_FormataData($Data)
{ 
   if ($Data)
   {
   $dia = substr($Data,8,2);
   $mes = substr($Data,5,2);
   $ano = substr($Data,0,4);
    if(strlen($dia)==1)
	{ $dia = "0". $dia;
    }
	if (strlen($mes)==1)
	{	$mes = "0" . $mes;
    }
    return $dia."/".$mes."/".$ano;
	}	
}

function f_FormataDataTimeStamp($Data)
{
   if ($Data != '')
   {
       $Dt_formatada = f_FormataData($Data);
       $DataTime = substr($Data, 11, 5);
       return $Dt_formatada." &aacute;s ".$DataTime;
   }
}
/*
 *************************************************

**************************************************
função para carregar os paises
**************************************************
 *
 */
function f_ComboPais($NomeCombo, $codigoEscolhido)
{  
	
   echo "<select name=" .$NomeCombo." style=width:100px>";
   $sql = "SELECT pais_ds FROM dados_unico.pais";
   $rs=pg_query(abreConexao(),$sql);
   While ($linha=pg_fetch_assoc($rs))
   {  
   	  $descricao = $linha['pais_ds'];
      if ($codigoEscolhido == $descricao)
      { echo "<option value=".$descricao." selected>".$descricao."</option>";
      }
	  else
	  {	echo "<option value=".$descricao.">".$descricao."</option>";
       }
   }
	echo "</select>";

}
function f_NomePessoa($codigoPessoa) 
{	
	$sql = "SELECT p.pessoa_nm FROM dados_unico.pessoa p WHERE p.pessoa_id = ".$codigoPessoa;
    $rs = pg_query(abreConexao(),$sql);
    $linhars=pg_fetch_assoc($rs);

    If($linhars)
    {
      return $linhars['pessoa_nm'];
    }
}
function f_MatriculaPessoa($codigoPessoa)
{
	$sql = "SELECT f.funcionario_matricula FROM dados_unico.funcionario f WHERE f.pessoa_id = ".$codigoPessoa;
    $rs = pg_query(abreConexao(),$sql);
    $linhars=pg_fetch_assoc($rs);

    If($linhars)
    {
      return $linhars['funcionario_matricula'];
    }
}

/*
**************************************************
função para carregar os estados
**************************************************
 *
 */
function f_ComboEstado($NomeCombo,$FuncaoJavaScript,$codigoEscolhido)
{  
   $retorno = "<select name=".$NomeCombo." id=".$NomeCombo." style='width:45px; height:21px;' ".$FuncaoJavaScript.">";
   $sql = "SELECT estado_uf 
           FROM dados_unico.estado";
   
   $rs=pg_query(abreConexao(),$sql);
   while ($linha=pg_fetch_assoc($rs))
   {  
      $descricao = $linha['estado_uf'];
      
      if($codigoEscolhido == $descricao)
      {  
          $retorno .= "<option value=" .$descricao. " selected>" .$descricao. "</option>";
      }
      else
      { 
          $retorno .= "<option value=" .$descricao. ">" .$descricao. "</option>";
      }
   }
   $retorno .= "</select>";
   return $retorno;
}
/*
**************************************************

**************************************************
função para carregar os municipios
**************************************************
 *
 */
function f_ComboMunicipio($NomeCombo,$EstadoFuncao, $codigoEscolhido)
{          
    if($EstadoFuncao == "")
    { 
        $EstadoFuncao = "BA";
    }
    $retorno = "<select name=".$NomeCombo." id=".$NomeCombo." style='width:200px; height:21px;'>";
    $sql = "SELECT municipio_cd, municipio_ds, municipio_capital FROM dados_unico.municipio WHERE estado_uf = '".$EstadoFuncao."' ORDER BY municipio_ds";
    $rs  = pg_query(abreConexao(),$sql);
    
    while ($linha = pg_fetch_assoc($rs)) 
    { 
        $codigo     = $linha['municipio_cd'];
        $descricao  = $linha['municipio_ds'];
        $capital    = $linha['municipio_capital'];
        if (strval($codigoEscolhido) == strval($codigo))
        {  
            $retorno .= "<option value=".$codigo." selected>".$descricao."</option>";
        }
        else
        { 
            if (((int)$capital == 1) && ($codigoEscolhido == ""))
            { 
                $retorno .= "<option value=".$codigo." selected>".$descricao."</option>";
            }
            Else
            { 
                $retorno .= "<option value=".$codigo.">".$descricao."</option>";
            }
      }
    }
    $retorno .= "</select>";
    
    return $retorno;
}
/*
**************************************************

**************************************************
função para carregar as Coordenadorias
**************************************************
 *
 */
function comboCoordenadorias($nome,$tamanho,$codigo,$funcaoJavaScript)
{        
    echo'<select id="'.$nome.'" name="'.$nome.'" '.$funcaoJavaScript.' style="width:'.$tamanho.'px;">';
        echo'<option value="0"></option>';
        
    $sql      = "SELECT id_coordenadoria, nome FROM diaria.coordenadoria ORDER BY nome";
    $consulta = pg_query(abreConexao(),$sql);
    
    while($linhaCoreg = pg_fetch_assoc($consulta)) 
    {
        if(trim($codigo) == trim($linhaCoreg['id_coordenadoria']))
        {
            echo '<option value ="'.$linhaCoreg['id_coordenadoria'].'" selected>'.$linhaCoreg['nome'].'</option>';                
        }
        else
        {
            echo '<option value = "'.$linhaCoreg['id_coordenadoria'].'">'.$linhaCoreg['nome'].'</option>';
        }
    }
    echo '</select>';
}
/*
**************************************************

**************************************************
função para carregar os niveis escolares
**************************************************
 *
 */
function f_ComboNivelEscolar($codigoEscolhido)
{  echo "<select name=cmbNivelEscolar style=width:120px>";
   $sql = "SELECT * FROM dados_unico.nivel_escolar WHERE nivel_escolar_st = 0 AND nivel_escolar_id <> 0 ORDER BY nivel_escolar_ds";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------ Selecione ------]</option>";
   while ($linha=pg_fetch_assoc($rs)) 
   {  $codigo = $linha['nivel_escolar_id'];
	  $descricao = $linha['nivel_escolar_ds'];
	  if (((int)$codigoEscolhido) == ((int)$codigo))
	  {  echo "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {	echo "<option value=" .$codigo. ">"  .substr($descricao,0,47). "</option>";
      }
   }
   echo "</select>";
}
/*
**************************************************

**************************************************
função para carregar os estados civis
**************************************************
 *
 */
function f_ComboEstadoCivil($codigoEscolhido)
{  echo "<select name=cmbEstadoCivil style=width:120px>";
   $sql = "SELECT * FROM dados_unico.estado_civil WHERE estado_civil_st = 0 AND estado_civil_id <> 0 ORDER BY estado_civil_ds";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------ Selecione ------]</option>";
   while ($linha=pg_fetch_assoc($rs))
   {  $codigo=$linha['estado_civil_id'];
	  $descricao=$linha['estado_civil_ds'];
	  if ((int)$codigoEscolhido== (int)$codigo)
      {  echo "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {  echo "<option value=".$codigo. ">" .substr($descricao,0,47). "</option>";
      }
    }
	echo"</select>";
}
/*
**************************************************

**************************************************
função para carregar os tipos de funcionários
**************************************************
 *
 */
function f_ComboTipoFuncionario($codigoEscolhido)
{ echo "<select name=cmbFuncionarioTipo style=width:140px>";
  $sql = "SELECT * FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_terceirizado = 0 ORDER BY funcionario_tipo_ds";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[--------- Selecione ---------]</option>";
  while ($linha=pg_fetch_assoc($rs)) 
  { $codigo = $linha['funcionario_tipo_id'];
	$descricao = $linha['funcionario_tipo_ds'];
    if ((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {  echo "<option value=".$codigo. ">" .substr($descricao,0,47). "</option>";
      }
   }
   echo"</select>";
}
/*
**************************************************

**************************************************
função para carregar ministerios da defesa
**************************************************
 *
 */
function f_ComboMinisterio($codigoEscolhido)
{ 
$codigoEscolhido = rtrim($codigoEscolhido);

$MinisterioAero 	= "";
$MinisterioExer  	= "";
$MinisterioMari		= "";

if($codigoEscolhido != "")
  { switch ($codigoEscolhido)
    {
    case "Aeronautica":
      $MinisterioAero = " selected ";
        break;
    case "Exercito":
      $MinisterioExer = " selected ";
        break;
    case "Marinha":
      $MinisterioMari = " selected ";
        break;
    }
  }
  echo "<select name=cmbMinisterio style=width:120px>";
  echo "<option value=0>[------ Selecione ------]</option>";
  echo "<option value=Aeronautica ".$MinisterioAero. ">Aeron&aacute;utica</option>";
  echo "<option value=Exercito ".$MinisterioExer.">Ex&eacute;rcito</option>";
  echo "<option value=Marinha ".$MinisterioMari.">Marinha</option>";
  echo "</select>";

}
/*
**************************************************

**************************************************
função para carregar estrutura organizacional sigla
**************************************************
 *
 */
function f_ComboEstruturaOrganizacionalSigla()
{  echo "<select name=cmbEstOrganizacional style=width:200px>";
   $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
   $rs=pg_query(abreConexao(),$sql);
   echo"<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs))
   { $codigo = $linha['est_organizacional_id'];
	 $descricao = $linha['est_organizacional_sigla'];
	 echo "<option value=" .$codigo.">" .$descricao."</option>";
    }
	echo"</select>";

}
/*
'**************************************************
 carrega a estrutura de atuacao da secretaria (exercendo alguma funcao)
 */

function f_ComboEstruturaOrganizacional($NomeCombo, $codigoEscolhido,$Tamanho="200px")
{ 
  echo "<select name=" .$NomeCombo." style=width:".$Tamanho.">";
  $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
  $rs=pg_query(abreConexao(),$sql);
  echo"<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs))
   {
     if ($codigoEscolhido==$linha['est_organizacional_id'])
     {  echo "<option value=" .$linha['est_organizacional_id']. " selected>".$linha['est_organizacional_sigla']. "</option>";
     }
	 else
     { echo"<option value=" .$linha['est_organizacional_id']. ">".$linha['est_organizacional_sigla']. "</option>";
     }

   }
   echo "</select>";
}

/**************************************************
 * carrega as guias de recolhimento estadual (GER)
 */

function f_ComboGer($NomeCombo, $codigoEscolhido)
{  
   echo"<select name=".$NomeCombo." style=width:200px>";
   $sql = "SELECT*FROM diaria.ger WHERE status = 0 AND
   ger_id <> 0 ORDER BY ger_id, ger_nm_conta";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs))
   { if ($codigoEscolhido != "")
     {  if((int)$codigoEscolhido == (int)($linha['ger_id']))
        { echo "<option value=".$linha['ger_id']. " selected>".$linha['ger_nm_conta']."</option>";
        }
		else
		{ echo "<option value=".$linha['ger_id'].">".$linha['ger_nm_conta']."</option>";
        }
     }
	 else
	 {  echo "<option value=".$linha['ger_id'].">".$linha['ger_nm_conta']."</option>";
     }
   }
  echo "</select>";
}
/*
**************************************************
função para carregar bancos (unidades financeiras)
**************************************************
 * //Carrega combo de bancos
 */
Function f_ComboBanco($codigoEscolhido)
{ echo "<select name=cmbBanco style=width:190px>";
  $sql = "SELECT * FROM dados_unico.banco WHERE banco_st = 0 AND banco_id <> 0 ORDER BY UPPER(banco_ds)";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[------------------ Selecione ------------------]</option>";
  While ($linha=pg_fetch_assoc($rs))
  { $codigo = $linha ['banco_id'];
    $descricao= $linha ['banco_ds'];
	if((int)$codigoEscolhido==(int)$codigo)
	{ echo "<option value=" .$codigo." selected>".$descricao."</option>";
    }
    else
    { echo "<option value=".$codigo. ">".$descricao."</option>";
    }
  }
  echo "</select>";
}
		
/*
**************************************************

**************************************************
função para carregar tipos de conta
**************************************************
 *
 */
function f_ComboTipoConta($codigoEscolhido)
{
   switch ($codigoEscolhido) 
    {
    case "C":
      $ContaCorrente = "selected";
        break;
    case "P":
        $ContaPoupanca = "selected";
        break;
    }
    echo "<select name=cmbTipoConta style=width:115px>";
	echo "<option value=C ".$ContaCorrente. ">Conta Corrente</option>";
	echo "<option value=P ".$ContaPoupanca. ">Conta Poupan&ccedil;a</option>";
	echo "</select>";

}
/*
'**************************************************
'carrega os orgaos do estado da bahia
 *
 */
function f_ComboOrgao($codigoEscolhido,$NomeCombo,$tamanho ="175px")
{
  

  echo "<select name='" .$NomeCombo."' style=width:".$tamanho.">";
  $sql = "SELECT * FROM dados_unico.orgao WHERE orgao_st = 0 AND orgao_id <> 0 ORDER BY UPPER(orgao_ds)";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[--------------- Selecione ---------------]</option>";
  While ($linha=pg_fetch_assoc($rs))
  { if($codigoEscolhido != "")
    {  if ((int)$codigoEscolhido == (int)($linha ['orgao_id']))
       { echo "<option value=" .$linha ['orgao_id']. " selected>" .$linha ['orgao_ds']."</option>";
       }
	  else
	  {	echo "<option value=" .$linha ['orgao_id'].">" .$linha ['orgao_ds']. "</option>";
      }
    }
	else
	{  echo "<option value=" .$linha ['orgao_id']. ">" .$linha ['orgao_ds']. "</option>";
    }
   }
	echo  "</select>";
}

/*

'**************************************************
'função para carregar grupo sanguineo
'**************************************************
 *
 */
function f_ComboGrupoSanguineo($codigoEscolhido)
{
		switch ($codigoEscolhido)
        { case "A+":
              $SangueAP = "selected";
              break;
          case "A-":
              $SangueAN = "selected";
              break;
          case "AB+":
              $SangueABP = "selected";
              break;
          case "AB-":
              $SangueABN = "selected";
              break;
         case "B+":
              $SangueBP = "selected";
              break;
          case "B-":
              $SangueBN = "selected";
              break;
          case "O+":
              $SangueOP = "selected";
              break;
          case "O-":
              $SangueON = "selected";
              break;

    }
    echo "<select name=cmbGrupoSanguineo style=width:120px>";
	echo "<option value=0>[------ Selecione ------]</option>";
	echo "<option value=A+ ".$SangueAP. ">Tipo A+</option>";
	echo "<option value=A- " .$SangueAN. ">Tipo A-</option>";
	echo "<option value=AB+ " .$SangueABP. ">Tipo AB+</option>";
	echo "<option value=AB- " .$SangueABN.">Tipo AB-</option>";
	echo "<option value=B+ " .$SangueBP.">Tipo B+</option>";
	echo"<option value=B- " .$SangueBN. ">Tipo B-</option>";
	echo "<option value=O+ " .$SangueOP. ">Tipo O+</option>";
	echo"<option value=O- " .$SangueON. ">Tipo O-</option>";
	echo"</select>";

}
/*
'**************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
Function f_ConsultaEstadoCivil($codigoEscolhido)
{  $sql = "SELECT estado_civil_ds FROM dados_unico.estado_civil WHERE estado_civil_id = '" .$codigoEscolhido."'";
		$rs=pg_query(abreConexao(),$sql);
        $linha=pg_fetch_assoc($rs);
		echo $linha['estado_civil_ds'];
}
/*
'**************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
function f_ConsultaNivelEscolar($codigoEscolhido)
{ 
$sql = "SELECT nivel_escolar_ds FROM dados_unico.nivel_escolar WHERE nivel_escolar_id = '".$codigoEscolhido."'";
  $rs=pg_query(abreConexao(),$sql);
  $linha=pg_fetch_assoc($rs);
  echo $linha['nivel_escolar_ds'];
}
/*
**************************************************

**************************************************
função para carregar órgãos do governo do estado
**************************************************
 *
 */
function f_ConsultaMunicipio($codigoEscolhido)
{ 
 	if ($codigoEscolhido != "") 
		{ 
			$sql = "SELECT municipio_ds FROM dados_unico.municipio WHERE municipio_cd = '" .$codigoEscolhido."'";
    		$rs=pg_query(abreConexao(),$sql);
 
    		if($rs)
    		{
   				$linha=pg_fetch_assoc($rs);
   				echo $linha['municipio_ds'];
    		}
		}
}
   
/*
**************************************************

**************************************************
função para carregar órgãos do governo do estado
**************************************************
 *
 */
function f_ConsultaTipoFuncionario($codigoEscolhido)
{
	$sql = "SELECT funcionario_tipo_ds FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_id = '".$codigoEscolhido."'";
	$rs = pg_query(abreConexao(),$sql);
	$linha = pg_fetch_assoc($rs);
	echo $linha['funcionario_tipo_ds'];
}
/*
**************************************************

**************************************************
função para carregar órgãos do governo do estado
**************************************************
 *
 */
function f_ConsultaOrgao($codigoEscolhido)
{ $sql = "SELECT orgao_ds FROM dados_unico.orgao WHERE orgao_id = '".$codigoEscolhido."'";
  $rs=pg_query(abreConexao(),$sql);
  $linha=pg_fetch_assoc($rs);
  echo $linha['orgao_ds'];


}
/*
 **************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
function f_ConsultaEstruturaOrganizacional($codigoEscolhido)
{  if($codigoEscolhido!= "")
   { $sql = "SELECT est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = '".$codigoEscolhido."'";
	 $rs=pg_query(abreConexao(),$sql);
     $linha=pg_fetch_assoc($rs);
     return $linha['est_organizacional_ds'];
	}
}

/*
function f_ConsultaEstruturaOrganizacionalReturn($codigoEscolhido)
{  if($codigoEscolhido!= "")
   { $sql = "SELECT est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = '".$codigoEscolhido."'";
	 $rs=pg_query(abreConexao(),$sql);
     $linha=pg_fetch_assoc($rs);
	 return $linha['est_organizacional_ds']; // ALTERADO POR DANILLO 12/08/2010
   }
}
*/

function f_ConsultaEstruturaOrganizacionalLotacao($codigoEscolhido)
{ if (codigoEscolhido != "")
  { $sql = "SELECT est_organizacional_lotacao_ds FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_id = '".$codigoEscolhido."'";
	$rs=pg_query(abreConexao(),$sql);
     $linha=pg_fetch_assoc($rs);
     echo $linha['est_organizacional_lotacao_ds'];
  }
}

/*
'**************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
function f_ConsultaEstruturaOrganizacionalSigla($codigoEscolhido)
{ if ($codigoEscolhido != "")
  { $sql = "SELECT est_organizacional_sigla FROM dados_unico.est_organizacional WHERE est_organizacional_id = '".$codigoEscolhido."'";
    $rs=pg_query(abreConexao(),$sql);
    $linha=pg_fetch_assoc($rs);
    return $linha['est_organizacional_sigla'];
  }
}

function f_PossuiFeriado($Inicio, $Fim)
{  
    //Modifica��es de Ramon Garrido
    //retira a barra '/' da data e retorna um array
    $vetDataAcr    = explode("/", $Inicio);
    $vetDataF      = explode("/", $Fim);
    
    // depois inclui a barra '-' pois o strotime s� trabalha com data no formato americano.
    $dataAcrescida = implode("-", array($vetDataAcr[2], $vetDataAcr[1], $vetDataAcr[0]));   
    $dataFim       = implode("-", array($vetDataF[2],$vetDataF[1],$vetDataF[0]));

    //transforma as datas em timestemp
    $timestampDataAcrescida = strtotime($dataAcrescida);
    $timestampFim           = strtotime($dataFim);
    
    //verifica se o timeStamp da data de partida � menor que o de sa�da.
    while ($timestampDataAcrescida <= $timestampFim)
    {
        $diaVerificado = $timestampDataAcrescida;        
        $dia_semana    = date("w", $diaVerificado); 
        $diaFeriado   = date('d',$diaVerificado);
        $mesFeriado   = date('m',$diaVerificado);
        
        //Verifica se o dia da semana n�o � s�bado nem domingo. E caso n�o seja, verifica se � um feriado.
        if (($dia_semana != 0) && ($dia_semana != 6))
        { 
            $sqlConsultaFeriado = "SELECT feriado_mes, feriado_dia 
                                     FROM dados_unico.feriado 
                                    WHERE feriado_dia = '" .$diaFeriado. "'
                                      AND feriado_mes = '".$mesFeriado."'";
              
            $rsConsultaFeriado  = pg_query(abreConexao(),$sqlConsultaFeriado);            
            
            //Retorna que existe um feriado.
            if(pg_num_rows($rsConsultaFeriado))
            {
                return true;
            }
        }
        
        //Caso contr�rio soma um dia e refaz o teste, at� que o dia testado seja maior que o dia final informado.
        $diaVerificado           = date('Y-m-d', $diaVerificado);                       
        $diaSeguinte             = strtotime($diaVerificado." + 1 days");
        $timestampDataAcrescida  = $diaSeguinte;                         
    }
    return false;
}

function f_PossuiFimSemana($Inicio, $Fim)
{ 
    //retira a barra '/' da data e retorna um array
    $vetDataAcr    = explode("/", $Inicio);
    $vetDataF      = explode("/", $Fim);
    
    // depois inclui a barra '-' pois o strotime s� trabalha com data no formato americano.
    $dataAcrescida = implode("-", array($vetDataAcr[2], $vetDataAcr[1], $vetDataAcr[0]));   
    $dataFim       = implode("-", array($vetDataF[2],$vetDataF[1],$vetDataF[0]));

    //transforma as datas em timestemp
    $timestampDataAcrescida = strtotime($dataAcrescida);
    $timestampFim           = strtotime($dataFim);
    
    //verifica se o timeStamp da data de partida � menor que o de sa�da.
    while ($timestampDataAcrescida <= $timestampFim)
    {
        $diaVerificado = $timestampDataAcrescida;        
        $dia_semana    = date("w", $diaVerificado);  
        
        //Verifica se o dia da semana � s�bado ou domingo. E caso seja, retorna que existe um fim de semana.
        if (($dia_semana == 0) || ($dia_semana == 6))
        { 
            return true;
        }
        
        //Caso contr�rio soma um dia e refaz o teste, at� que o dia testado seja maior que o dia final informado.
        $diaVerificado           = date('Y-m-d', $diaVerificado);                       
        $diaSeguinte             = strtotime($diaVerificado." + 1 days");
        $timestampDataAcrescida  = $diaSeguinte;                            
    }            
    return false;
}

function diasemana($data) {
	$ano =  substr("$data", 6, 4);
	$mes =  substr("$data", 3, 2);
	$dia =  substr("$data", 0, 2);
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano));

	switch($diasemana) {
		case"0": $diasemana = "Domingo";       break;
		case"1": $diasemana = "Segunda-Feira"; break;
		case"2": $diasemana = "Terça-Feira";   break;
		case"3": $diasemana = "Quarta-Feira";  break;
		case"4": $diasemana = "Quinta-Feira";  break;
		case"5": $diasemana = "Sexta-Feira";   break;
		case"6": $diasemana = "Sábado";        break;
	}

	return  $diasemana;
}

function f_GeraSenha()
{
    $CaracteresAceitos = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $max = strlen($CaracteresAceitos)-1;
    $password = null;
    for($i=0; $i < 8; $i++) 
    { 
       $password.= $CaracteresAceitos{mt_rand(0, $max)}; 
    }    
    
    $sql       = "SELECT p.pessoa_id, p.pessoa_nm, u.usuario_login, u.usuario_senha FROM dados_unico.pessoa p, seguranca.usuario u, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND (p.pessoa_id = u.pessoa_id) AND usuario_login = '".$_POST['txtLogin']."'";
    $rs        = pg_query(abreConexao(),$sql);
    $linhars   = pg_fetch_assoc($rs);
    
    if($linhars)
    {
        $sqlUpdate = "UPDATE seguranca.usuario SET usuario_senha ='".sha1($password)."' , usuario_primeiro_logon = '1' WHERE pessoa_id = ".$linhars['pessoa_id'];
        pg_query(abreConexao(),$sqlUpdate); // Não dar o comando STRTOUPPER, pois essa string é um HASH
    }        
    return $password;
}



function f_ComboEstruturaOrganizacionalLotacao($NomeCombo, $codigoEscolhido)
{  print"<select name=".$NomeCombo. " style=width:200px>";

   $sql = "SELECT * FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_st = 0 AND est_organizacional_lotacao_id <> 0 ORDER BY est_organizacional_lotacao_sigla";

   $rs=pg_query(abreConexao(),$sql);

   print "<option value=0>[------------------- Selecione -------------------]</option>";

   while ($linha=pg_fetch_assoc($rs))
   {
   	if (codigoEscolhido != "")
     {
	 	if((int)$codigoEscolhido == (int)($linha['est_organizacional_lotacao_id']))
         {
			print "<option value=" .$linha['est_organizacional_lotacao_id']. " selected>".$linha['est_organizacional_lotacao_sigla']."</option>";
         }
		else
		 {
		 	print "<option value=" .$linha['est_organizacional_lotacao_id'].">".$linha['est_organizacional_lotacao_sigla']. "</option>";
         }
     }
	 else
	 {
	 	print "<option value=" .$linha['est_organizacional_lotacao_id'].  ">".$linha['est_organizacional_lotacao_sigla'].  "</option>";
     }
   }
  print "</select>";
}

function f_ComboMes($nome,$tamanho,$tracos,$funcaoJavaScript,$codigo)
{
    $tracos = geraSelecione($tracos);
    
    echo'<select id="'.$nome.'" name="'.$nome.'" '.$funcaoJavaScript.' style="width:'.$tamanho.'px;">';
    $selected = 'selected';
        
        if($codigo != '')
        {
            if($codigo == 1)
            {
                echo'<option '.$selected.' value="1">JANEIRO</option>';
            }
            if($codigo == 2)
            {
                echo'<option '.$selected.' value="2">FEVEREIRO</option>';
            }
            if($codigo == 3)
            {
                echo'<option '.$selected.' value="3">MARÇO</option>';
            }
            if($codigo == 4)
            {
                echo'<option '.$selected.' value="4">ABRIL</option>';
            }
            if($codigo == 5)
            {
                echo'<option '.$selected.' value="5">MAIO</option>';
            }
            if($codigo == 6)
            {
                echo'<option '.$selected.' value="6">JUNHO</option>';
            }
            if($codigo == 7)
            {
                echo'<option '.$selected.' value="7">JULHO</option>';
            }
            if($codigo == 8)
            {
                echo'<option '.$selected.' value="8">AGOSTO</option>';
            }
            if($codigo == 9)
            {
                echo'<option '.$selected.' value="9">SETEMBRO</option>';
            }
            if($codigo == 10)
            {
                echo'<option '.$selected.' value="10">OUTUBRO</option>';
            }
            if($codigo == 11)
            {
                echo'<option '.$selected.' value="11">NOVEMBRO</option>';
            }
            if($codigo == 12)
            {
                echo'<option '.$selected.' value="12">DEZEMBRO</option>';
            }
        }
        else
        {
            echo'<option '.$selected.' value="0">'.$tracos.'</option>';
        }
        echo'<option value="1">JANEIRO</option>';
        echo'<option value="2">FEVEREIRO</option>';
        echo'<option value="3">MARÇO</option>';
        echo'<option value="4">ABRIL</option>';
        echo'<option value="5">MAIO</option>';
        echo'<option value="6">JUNHO</option>';
        echo'<option value="7">JULHO</option>';
        echo'<option value="8">AGOSTO</option>';
        echo'<option value="9">SETEMBRO</option>';
        echo'<option value="10">OUTUBRO</option>';
        echo'<option value="11">NOVEMBRO</option>';        
        echo'<option value="12">DEZEMBRO</option>';                       
    echo '</select>';
}

/*FUNÇÃO QUE GERA A PRIMEIRA LINHA DE UM COMBO*/
function geraSelecione($numeroTracos)
{
    if($numeroTracos % 2 == 0)
    {
        $controle = $numeroTracos / 2;
        for($i = 0; $i < $controle; $i++) 
        {
            $montarRetorno .= ' - '; 
        }        
    }
    else
    {        
        $controle = ($numeroTracos + 1) / 2;
        for($i = 0; $i < $controle; $i++) 
        {
            $montarRetorno .= ' - '; 
        }
    }
    
    $selecione = '['.$montarRetorno.' SELECIONE '.$montarRetorno.']';
    
    return $selecione;
}

/*FUNÇÃO QUE RETORNA O MÊS À PARTIR DO NÚMERO DO MÊS*/
function retornaMes($codigo)
{
    $mes = '';
    
    switch ($codigo)
    {
        case '1':
            $mes = 'JANEIRO';
            break;
        case '2':
            $mes = 'FEVEREIRO';
            break;
        case '3':
            $mes = 'MARÇO';
            break;
        case '4':
            $mes = 'ABRIL';
            break;
        case '5':
            $mes = 'MAIO';
            break;
        case '6':
            $mes = 'JUNHO';
            break;
        case '7':
            $mes = 'JULHO';
            break;
        case '8':
            $mes = 'AGOSTO';
            break;
        case '9':
            $mes = 'SETEMBRO';
            break;
        case '10':
            $mes = 'OUTUBRO';
            break;
        case '11':
            $mes = 'NOVEMBRO';
            break;        
        case '12':
            $mes = 'DEZEMBRO';
            break;        
    }    
    return $mes;
}

?>
