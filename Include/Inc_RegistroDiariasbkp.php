<?php
 /*
 *****************************************************************************
 Alterado por Rodolfo em 12/09/2008
 Solicitação da DA - Comprovação
 *****************************************************************************
  *
  */
 $sql1 = "SELECT diaria_comprovada,diaria_devolvida FROM diaria.diaria d WHERE d.diaria_id = ".$Codigo;
 $rs=pg_query(abreConexao(),$sql);
 $linha=pg_fetch_assoc($rs);
 $DiariaComprovada = $linha['diaria_comprovada'];
 $DiariaDevolvida = $linha['diaria_devolvida'];
 echo "<td width='20' align='center'>";
 //botao consultar
 if ($_SESSION['BotaoConsultar'] == false)
 {  echo "<img src='../Icones/ico_consultar_off.png' alt='Consultar' border='0'>";
 }
 else
 {  if ($Status > 6)
    { echo "<a href=ComprovacaoConsultar.php?cod=".$CodigoRegistro."&acao=consultar><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'></a>";
    }
    else
	{  if ($_SESSION['BotaoConsultar']!=0)
       { echo "<a href=".$PaginaLocal. "Consultar.php?cod=".$CodigoRegistro."&acao=consultar><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'></a>";
       }
    }
 }
 echo "</td>";
 echo "<td width='20' align='center'>";
 //botao editar so aparece antes da diaria ser aprovada
 if ($Status!=0)
 {  echo "<img src='../Icones/ico_alterar_off.png' alt='Editar' border='0'>";
 }
 else
 { echo "<a href=".$PaginaLocal."Cadastrar.php?cod=".$CodigoRegistro. "&acao=consultar><img src='../Icones/ico_alterar.png' alt='Editar' border='0'></a>";

 }
 echo "</td>";
 echo "<td width='20' align='center'>";
//botao excluir so aparece antes da diaria ser autorizada
if ($Status >= 2)
{  echo  "<img src='../Icones/ico_excluir_off.png' alt='Excluir' border='0'>";
}
else
{ if($DiariaComprovada == "1")
  {  echo "<img src='../Icones/ico_excluir_off.png' alt='Excluir' border='0'>";
  }
  else
  {	echo "<a href=" .$PaginaLocal."Excluir.php?cod=".$CodigoRegistro."&acao=consultar><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'></a>";
  }
}
echo "</td>";
echo "<td width='20' align='center'>";
/*
*****************************************************************************
Alterado por Rodolfo em 12/09/2008
 Solicitação da DA - Comprovação
*****************************************************************************
 *
 */
//botao comprovar fica desabilitado ate chegar no status comprovacao
//If (Status < 6 Or Status > 7) Then
//botão não imprimir  comprovação
if ($Status < 3 )
{  echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
}
else
{   //'botao ativado para comprovar
    if ($Status >= 3)
	{  if ($DiariaComprovada == "0")
       { if ($Beneficiario == $_SESSION['UsuarioCodigo'] ) //se for o beneficiario logado, permitir a comprovacao
         {  echo "<a href='SolicitacaoComprovar.php?cod=".$CodigoRegistro."&acao=consultar'><img src='../Icones/ico_comprovar.png'  alt='Comprovar' border='0'></a>";
         }
         else
         {  echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
         }
       }
       else
	   { if ($DiariaDevolvida == "1")
         {  if ($Beneficiario == $_SESSION['UsuarioCodigo'])//se for o beneficiario logado, permitir a comprovacao
			{  echo  "<a href='SolicitacaoComprovar.php?cod=".$CodigoRegistro. "&acao=consultar'><img src='../Icones/ico_comprovar.png'  alt='Comprovar' border='0'></a>";
            }
            else
            {  echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
            }
         }
		else
		{ echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
        }
       }
    }
}
echo "</td>";
echo "<td width='20' align='center'>";
/*
*****************************************************************************
Alterado por Rodolfo em 15/09/2008
Solicitação da DA - Comprovação
*****************************************************************************
 *
 */
//If Status > 7 And Status < 10 Then
if (($Status >= 3) && ($Status <=8))
{  if($DiariaComprovada == "1")
   {  $sqlGer = "SELECT diaria_comprovacao_saldo_tipo FROM diaria.diaria_comprovacao WHERE diaria_id = ".$Codigo;
      $rsGer=pg_query(abreConexao(),$sqlGer);
      $linha=pg_fetch_assoc($rsGer);
      if ($linha['diaria_comprovacao_saldo_tipo']== "D")
      {  if($DiariaDevolvida == "0" )
         {  echo "<a href='javascript:ImprimirDiariaGER(" .$CodigoRegistro. ");'><img src='../Icones/ico_imprimir_ger.png' alt='Imprimir GER' border='0'></a>";
         }
         else
         {  echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>";
         }
      }
	  else
	  {	echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>";
      }
   }
   else
   {  echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>";
   }
}
else
{	echo"<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>";
}
?>
