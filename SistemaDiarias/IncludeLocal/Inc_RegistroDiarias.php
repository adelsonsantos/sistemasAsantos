<?php
echo "<td width='20' align='center'>";
    //************* Botão Consultar *************//
    if($_SESSION['BotaoConsultar'] == false)
    {
        echo "<img src='../Icones/ico_consultar_off.png' alt='Consultar' border='0'/>";
    }
    else
    {
        if(($status > '4')&&($status < '10'))
        {
            echo "<a href=ComprovacaoConsultar.php?acao=consultar&cod=".$codigoRegistro."&pagina=Solicitacao><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'/></a>";
        }
        else
        {
            if ($_SESSION['BotaoConsultar']!= 0)
            {
                echo "<a href=".$PaginaLocal."Consultar.php?acao=consultar&cod=".$codigoRegistro."><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'/></a>";
            }
        }
    }
echo "</td>";

echo "<td width='20' align='center'>";
    //************* Botão Editar só aparece antes da diaria ser aprovada *************//
    if($diariaLocal == 'Sede')
    {
        if(($status == '0')&&($diariaDevolvida != 2))
        {
            echo "<a href=".$PaginaLocal."Cadastrar.php?acao=consultar&cod=".$codigoRegistro."><img src='../Icones/ico_alterar.png' alt='Editar' border='0'/></a>";
        }
        else
        {
            echo "<img src='../Icones/ico_alterar_off.png' alt='Editar' border='0'/>";
        }        
    }
    else
    {
        if($status == '100')
        {
            echo "<a href=".$PaginaLocal."Cadastrar.php?acao=consultar&cod=".$codigoRegistro."><img src='../Icones/ico_alterar.png' alt='Editar' border='0'/></a>";
        }
        else
        {
            echo "<img src='../Icones/ico_alterar_off.png' alt='Editar' border='0'/>";
        }        
    }
    
echo "</td>";

echo "<td width='20' align='center'>";
    //Botao Excluir so aparece antes da diaria ser autorizada
    if($diariaLocal == 'Sede')
    {        
        if(($status == '0')&&($diariaDevolvida == 1))
        {
            echo "<a href=".$PaginaLocal."Excluir.php?acao=consultar&cod=".$codigoRegistro. "><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'/></a>";
        }
        else
        {
            echo "<img src='../Icones/ico_excluir_off.png' alt='Excluir' border='0'/>";
        }
    }
    else
    {   
        if($status == '100')
        {
            echo "<a href=".$PaginaLocal."Excluir.php?acao=consultar&cod=".$codigoRegistro. "><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'/></a>";
        }
        else
        {
            echo "<img src='../Icones/ico_excluir_off.png' alt='Excluir' border='0'/>";
        }
    }    
echo "</td>";

echo "<td width='20' align='center'>";
    // Botão ativado para comprovar
    if($status == '4')
    {
        if(($beneficiario == $_SESSION['UsuarioCodigo']) || ($_SESSION['Administrador'] == 1))
        {
            echo "<a href='SolicitacaoComprovar.php?acao=consultar&cod=".$codigoRegistro."'><img src='../Icones/ico_comprovar.png'  alt='Comprovar' border='0'/></a>";        
        }
        else
        {
             echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'/>";        
        }
    }
    else
    {  //************** Botao comprovar fica desabilitado ate chegar no status comprovacao ********************//
        echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'/>";        
    }
echo "</td>";

echo "<td width='20' align='center'>";
    //******************** Habilita os Botões de Impressão com o Fluxo Normal do Sistema *************************// 
    if (($status > '4')&&($status <='8'))
    {
        if ($diariaComprovada == "1")
        {
            $sqlGer   = "SELECT diaria_comprovacao_saldo_tipo FROM diaria.diaria_comprovacao WHERE diaria_id = ".$codigoRegistro;
            $rsGer    = pg_query(abreConexao(),$sqlGer);
            $linhaGer = pg_fetch_assoc($rsGer);
            if($linhaGer)
            {
                if($linhaGer['diaria_comprovacao_saldo_tipo']=="D")
                {
                    if($diariaDevolvida == "0")
                    {                       
                        echo "<a href='http://sistemas.sefaz.ba.gov.br/sistemas/arasp/nt/modulos/dae/nt/dae_nt.aspx'; target='_blank';><img src='../Icones/ico_imprimir_ger.png' border='0' alt='Imprimir GER'/></a>";
                    }
                    else
                    {
                        echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'/>";
                    }
                }
                else
                {
                    echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'/>";
                }
            }
        }
        else
        {
            echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'/>";
        }
    }
    else
    {
        echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'/>";
    }
echo "</td>";

echo"<td align='center' width='20'>";
    if(($diariaComprovada == "1")&&(($status >='4')&&($status <= '8')))
    {
        echo "<a href='SolicitacaoComprovacaoImprimirPDF.php?cod=".$codigoRegistro."'; target='_blank';><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Comprovação'/></a>"	;
    }
    else
    {
        echo "<img src='../Icones/ico_imprimir_off.png' alt='Imprimir Comprovação' border='0'/>";
    }
echo "</td>";

echo"<td align='center' width='20'>";
if(($diariaComprovada == "1")&&(($status >='4')&&($status <= '10')))
{
    echo "<a href='SolicitacaoComprovacaoImprimirJPG.php?cod=".$codigoRegistro."'; target='_blank';><img src='../Icones/ico_imprimir_jpg.png' border='0' alt='Imprimir Comprovação JPG'/></a>"	;
}
else
{
    echo "<img src='../Icones/ico_imprimir_off.png' alt='Imprimir Comprovação JPG' border='0'/>";
}
echo "</td>";
?>
