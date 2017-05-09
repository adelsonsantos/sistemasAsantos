<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaAgrupadaEmpenho.php";
?>
<html>
    <style type="text/css">@import url("../css/estilo.css"); </style>
    <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
    <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    <script language="javascript"charset="utf-8">
        <!--
        
        function ExtratoEmpenho (checkbox)
        {
            
            StringDiaria ='';
            
            if (!checkbox.length)
            {
                if (checkbox.checked)
                {
                    StringDiaria = checkbox.value;
                }
            }
            else
            {
                for (i = 0 ; i < checkbox.length ; i++)
                {
                    //Se o checkbox não estiver marcado a diária já foi impressa
                    if (checkbox[i].checked)
                    {
                        if (StringDiaria == "")
                            StringDiaria = (checkbox[i].value);
                        else
                            StringDiaria += ','+(checkbox[i].value) ;
                    }
                }
            }
            if (StringDiaria == "") 
            {
                alert("Nenhuma di\u00E1ria foi marcada para IMPRESS\u00C3O ou REIMPRESS\u00C3O!");
                return;
            }

            document.Form.action="SolicitacaoImprimirEmpenhoPDF.php?Multiplos="+StringDiaria;
            document.Form.submit();
        }
		
		
        function Foco(frm)
        {
            frm.txtFiltro.focus();
        }
        
        function FiltrarForm(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.txtFiltro.value == "")
		{
			alert("Digite o n\u00famero da solicita\u00e7\u00e3o.");
			frm.txtFiltro.focus();
			frm.txtFiltro.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "SolicitacaoDiariaAgrupadaEmpenhoInicio.php?acao=buscar";
		frm.submit();
	}
        
        function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "SolicitacaoDiariaAgrupadaEmpenhoInicio.php";
		frm.submit();
	}
        
        function CarregarGride(ssd,frm){
            
            frm.action = "SolicitacaoDiariaAgrupadaEmpenho.php?acao=ssd&ssd="+ssd;
            frm.submit();
        }

        -->
    </script>

    <body onLoad="WM_initializeToolbar();">

        <form name="Form" method="post">

            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td><?php include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php" ?></td>
                                <td valign="top" align="left">

                                    <?php include "../Include/Inc_Titulo.php" ?>

                                    <?php include "../Include/Inc_Linha.php"?>

                                    
                                        <table cellpadding="0" cellspacing="0" width="800" border="0">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td class="GridPaginacaoRegistroCabecalho">Solicita&ccedil;&atilde;o:</td>
                                                            <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->super_sd; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="GridPaginacaoRegistroCabecalho">Processo:</td>
                                                            <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->diaria_processo; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="GridPaginacaoRegistroCabecalho">Projeto:</td>
                                                            <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->projeto_cd; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="GridPaginacaoRegistroCabecalho">Fonte:</td>
                                                            <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->fonte_cd; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                        </table>

                                        <?php include "../Include/Inc_Linha.php" ?>
                                        
                                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                            <td width="20"></td>
                                                            <td colspan="2" width="60" align="center">A&ccedil;&otilde;es</td>
                                                            <td width="100" align="center"><a href='<?php echo $PaginaLocal ?>Inicio.php?acao=buscar&atributo=super_sd'><u>SD</u></a></td>
                                                            <td width="308" align="left">Funcion&aacute;rio</td>
                                                            <td width="150" align="center">Data de Solicita&ccedil;&atilde;o</td>
                                                            <td width="130" align="center">Partida Prevista</td>
                                                            <td align="center">EMP</td>
                                                            <td width="100" align="center">Valor</td>
                                                        </tr>
                                                    <?php
                                                    for ($index = 0; $index < count($diariasAgrupadas); $index++) {?>
                                                        <tr height='20' class='linhaGrid'>
                                                        <?php $diaria = $diariasAgrupadas[$index];
                                                        if($diaria->diaria_st == '2'){
                                                            if($diaria->diaria_empenho == ""){
                                                                $bgcolor = "bgcolor='#8FBC8F'";
                                                            } else {
                                                                $bgcolor = "";
                                                            }
                                                            
                                                            // Verifica o tipo de empenho
                                                            if ($diaria->indenizacao == 0) {
                                                                if ($diaria->convenio_id == 0) {
                                                                    $emp = "N-1";
                                                                } else {
                                                                    $emp = "C-1";
                                                                }
                                                            } else {
                                                                $emp = "I";
                                                            }
                                                        } else {
                                                            if ($diaria->indenizacao == 0) {
                                                                if ($diaria->convenio_id == 0) {
                                                                    $emp = "<font color='#CC9933'>N-2</font>";
                                                                } else {
                                                                    $emp = "<font color='#CC9933'>C-2</font>";
                                                                }
                                                            } else {
                                                                $emp = "<font color='#CC9933'>I-2</font>";
                                                            }
                                                        }
                                                        
                                                        ?>
                                                            <td width='20' align='center' <?php echo $bgcolor; ?>><!--<input type='checkbox' class='checkbox' name='checkbox' value=<?php echo $diaria->diaria_id; ?> <?php echo $checked; ?>/>--></td>
                                                            <td align='center' width="30"><a href='SolicitacaoConsultarFinanceiro.php?acao=consultar&cod=<?php echo $diaria->diaria_id; ?>&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>
                                                            <td align='center'width="30"><a href='SolicitacaoEmpenhar.php?cod=<?php echo $diaria->diaria_id; ?>&acao=consultar&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_comprovar.png' border='0' alt='Empenhar'/></a></td>
                                                            <td align='center'><?php echo $diaria->diaria_numero; ?></td>
                                                            <td>&nbsp;<?php echo $diaria->pessoa_nm; ?></a></td>
                                                            <td align='center'><?php echo $diaria->diaria_dt_criacao; ?> &agrave;s <?php echo $diaria->diaria_hr_criacao; ?></td>
                                                            <td align='center'><?php echo $diaria->diaria_dt_saida; ?>&agrave;s <?php echo $diaria->diaria_hr_saida; ?></td>
                                                            <td align="center"><?php echo $emp; ?></td>
                                                            <td align='center'><?php echo $diaria->diaria_valor; ?></td> 
                                                        </tr>
                                                    <?
                                                    } // for
                                                     ?>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <table>
                                        <tr class="linhaGrid">
                                            <td>Legenda:</td>
                                        </tr>
                                        <tr height='20' class='linhaGrid'>
                                            <td width='20' style="background-color: #8FBC8F"></td>
                                            <td>Falta Empenhar</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>