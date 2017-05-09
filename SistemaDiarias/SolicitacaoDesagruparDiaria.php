<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaDesagrupar.php";
?>
<html>
    <style type="text/css">@import url("../css/estilo.css"); </style>
    <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
    <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    <script language="javascript"charset="utf-8">
        <!--
        /**
         * Envia as diárias selecionadas para serem desagrupadas
         * @param checkbox <p>Array de elementos checkbox selecionados</p>
         */
        function DesagruparDiarias (checkbox)
        {
            var sel = 0;
            var selecionadas = "";			
            // Agrupa as diárias selecionadas
            for (i=0; i < checkbox.length; i++) {
                if (checkbox[i].checked) {
                    if(selecionadas == ""){
                        selecionadas = checkbox[i].value;
                    } else {
                        selecionadas += ','+checkbox[i].value;
                    }
                    sel++;
                }
            }
            // Verifica se ao menos uma diária foi selecionada
            /*if (sel == 0){
                alert("N\u00e3o foi informada nenhuma di\u00e1ria para desagrupar!");
                return;
            }*/			
            // Caso tenha restado apenas uma Diária no agrupamento, seleciona todas.
            if(checkbox.length - sel == 1){
                selecionadas = "";
                for (i=0; i < checkbox.length; i++) {
                    if(i==0){
                        selecionadas = checkbox[i].value;
                    } else
                        selecionadas += ','+checkbox[i].value;
                }
            }
            document.Form.action="SolicitacaoDesagruparDiaria.php?d="+selecionadas+"&acao=desagrupar";
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

		frm.action = "SolicitacaoDesagruparDiariaInicio.php?acao=buscar";
		frm.submit();
	}
        
        function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "SolicitacaoDesagruparDiariaInicio.php";
		frm.submit();
	}
        
        function CarregarGride(ssd,frm){
            
            frm.action = "SolicitacaoDesagruparDiaria.php?acao=ssd&ssd="+ssd;
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
                                                <td align="right" height='20'><button style="width:110px; height: 20px;" onClick="Javascript:DesagruparDiarias(document.Form.checkbox);" class="botao">Desagrupar Di&aacute;rias</button> <img src="../Icones/diaria_reuniao.gif" border="0" alt="Desagrupar Diárias"></td>
                                            </tr>

                                        </table>

                                        <?php include "../Include/Inc_Linha.php" ?>
                                        
                                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                            <td width="10"><input class="checkbox" type="checkbox" value="*" name="*" onclick="selecionarTodos(this,'checkbox');" /></td>
                                                            <td width="60" align="center">A&ccedil;&otilde;es</td>
                                                            <td width="100" align="center"><a href='<?php echo $PaginaLocal ?>Inicio.php?acao=buscar&atributo=super_sd'><u>SD</u></a></td>
                                                            <td width="308" align="left">Funcion&aacute;rio</td>
                                                            <td width="150" align="center">Partida</td>
                                                            <td width="130" align="center">Chegada</td>
                                                            <td width="100" align="center">Valor</td>
                                                        </tr>
                                                    <?php
                                                    for ($index = 0; $index < count($diariasAgrupadas); $index++) {
                                                    ?>
                                                            <tr height='20' class='linhaGrid'>
                                                                <td width='10' align='center'><input type='checkbox' class='checkbox' name='checkbox' value=<?php echo $diariasAgrupadas[$index]->diaria_id; ?>></td>
                                                                <td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=<?php echo $diariasAgrupadas[$index]->diaria_id; ?>&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>
                                                                <td align='center'><?php echo $diariasAgrupadas[$index]->diaria_numero; ?></td>
                                                                <td>&nbsp;<?php echo $diariasAgrupadas[$index]->pessoa_nm; ?></a></td>
                                                                <td align='center'><?php echo $diariasAgrupadas[$index]->diaria_dt_saida; ?>&agrave;s <?php echo $diariasAgrupadas[$index]->diaria_hr_saida; ?></td>
                                                                <td align='center'><?php echo $diariasAgrupadas[$index]->diaria_dt_chegada; ?> &agrave;s <?php echo $diariasAgrupadas[$index]->diaria_hr_chegada; ?></td>
                                                                <td align='center'><?php echo $diariasAgrupadas[$index]->diaria_valor; ?></td> 
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
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>