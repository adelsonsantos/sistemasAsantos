<?php
include "../../Include/Inc_Configuracao.php";

if($_POST['acao'] == 'adicionar')
{
    $mes      = $_POST['mesVal'];
    $mesId    = $_POST['mesId'];
    $saldoMes = $_POST['saldoVal']; 

    unset($mesAtual); 

    $mesAtual = '<tr class="dataField">
                    <td height="21"><input type="text" value="'.$mes.'" id="mesSelecionado'.$mesId.'" name="mesSelecionado'.$mesId.'" style="width:150px; height:18px;" readonly="readonly" /></td>
                    <td height="21"><input type="text" value="'.$saldoMes.'" id="saldoMes'.$mesId.'" name="saldoMes'.$mesId.'" onKeyPress=\'return(MascaraMoeda(this,".",",",event))\'  style="width:150px; height:18px;" readonly="readonly" /></td>
                    <td height="21">&nbsp;</td>
                 </tr>';

    if($_SESSION['mesHtml'] == '')
    {
        $_SESSION['mesHtml']      = $mesAtual; 
        $_SESSION['controleHtml'] = 1;

        print '<table width="800" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                  <tr class="dataLabel">
                    <td width="200" height="21">Mês</td>
                    <td width="200" height="21">Saldo</td>
                    <td width="400" height="21">&nbsp;</td>
                  </tr>
                  '.$_SESSION['mesHtml'].' 
               </table>||'.$_SESSION['controleHtml'];
    }
    else
    {    
        $_SESSION['mesHtml'] .= $mesAtual;
        $_SESSION['controleHtml'] = $_SESSION['controleHtml'] + 1;

        print '<table width="800" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                  <tr class="dataLabel">
                    <td width="200" height="21">Mês</td>
                    <td width="200" height="21">Saldo</td>
                    <td width="400" height="21">&nbsp;</td>
                  </tr>
                  '.$_SESSION['mesHtml'].' 
               </table>||'.$_SESSION['controleHtml'];
    }

    if($_SESSION['controleHtml'] == 12)
    {
        unset($_SESSION['mesHtml']);
        unset($_SESSION['controleHtml']);
    }
}
elseif($_POST['acao'] == 'consultar')
{
    
}
elseif($_POST['acao'] == 'limpar')
{
    unset($_SESSION['mesHtml']);
    unset($_SESSION['controleHtml']);
    unset($mes);
    unset($mesId);
    unset($saldoMes);
}   
?>
