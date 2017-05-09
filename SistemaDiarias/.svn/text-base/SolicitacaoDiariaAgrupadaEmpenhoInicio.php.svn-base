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
        		
        function ImprimirDiariasAgrupadas(codigo){
            window.open ("ImprimirDiariasAgrupadasEmpenhoPDF.php?cod="+codigo);
        }
		
        function ImprimirProcessoDiariasAgrupadas(codigo)
        {
            window.open ("CapaProcessoDiariasAgrupadasPDF.php?cod="+codigo);
        }
	
/* Função que Libera todos os Empenhos*/
        function LiberarTodosEmpenho(checkbox){
            CodigoDiarias ='';
             
            for (i=0; i < checkbox.length; i++) {
                if (checkbox[i].checked) {
                    if(CodigoDiarias == ''){
                        CodigoDiarias = (checkbox[i].value);
                    } else {
                        CodigoDiarias += ','+(checkbox[i].value);
                    }
                }
            }
			
            if (CodigoDiarias == ""){
                alert("Todas os Empenhos j\u00E1 foram Liberados.\n\Para Liberar algum Empenho \u00E9 Ncess\u00E1rio Empenhar Alguma Di\u00E1ria.!!!");
                return;
            }
		  
            var resposta = confirm('Tem certeza que deseja Liberar Todos os Empenhos ?');
            if (resposta == true)
            {
                Form.action = "SolicitacaoDiariaAgrupadaEmpenhoInicio.php?acao=liberarEmpenho&ssd="+CodigoDiarias;		  
                document.Form.submit();		  
            }		  
        }

        function liberarEmpenho(cod){
            var resposta = confirm('Tem certeza que deseja liberar este Empenho?');
            if (resposta == true)
            {
                Form.action = "SolicitacaoDiariaAgrupadaEmpenhoInicio.php?acao=liberarEmpenho&ssd="+cod;		  
                document.Form.submit();		  
            }
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
                                    
                                    <?php include "../Include/Inc_Pesquisa_Sem_Filtro.php"?>

                                    <?php include "../Include/Inc_Linha.php"?>
                                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                            <td width="10"><input class="checkbox" type="checkbox" value="*" name="*" onclick="selecionarTodos(this,'checkbox');" /></td>
                                                            <td colspan="3" align="center" style="width: 40px;">A&ccedil;&otilde;es</td>
                                                            <td align="center">SD</td>
                                                            <td align="center">Processo</td>
                                                            <td align="center">Projeto</td>
                                                            <td align="center">Fonte</td>
                                                        </tr>
                                                    <?php
                                                        for ($index = 0; $index < count($agrupamentos); $index++) { 
                                                            if(verificaEmpenhoSSD($agrupamentos[$index]->super_sd)){
                                                                $checkStatus = "checked='checked'";
                                                                $checkName = "checkbox";
                                                                if($agrupamentos[$index]->diaria_devolvida == 1){
                                                                    $bgcolor = "bgcolor='#CCCC66'";
                                                                } else {
                                                                    $bgcolor = "bgcolor='#8FBC8F'";
                                                                }
                                                                $empenhado=true;
                                                            } else {
                                                                $checkStatus = "disabled = 'disabled'";
                                                                $checkName = "";
                                                                $bgcolor = "";
                                                                $empenhado=false;
                                                            } ?>
                                                            <tr height='20' class='linhaGrid'>
                                                                <td width='10' align='center' <?php echo $bgcolor; ?>><input type='checkbox' class='checkbox' name='<?php echo $checkName;?>' value=<?php echo $agrupamentos[$index]->super_sd; ?> <?php echo $checkStatus; ?>/></td>
                                                                <td align='center' style="width: 30px;"><a href='SolicitacaoDiariaAgrupadaEmpenho.php?acao=ssd&ssd=<?php echo $agrupamentos[$index]->super_sd; ?>'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>
                                                               <!-- <td align='center' style="width: 30px;"><a href='javascript:ImprimirDiariasAgrupadas(<?php echo $agrupamentos[$index]->super_sd; ?>);'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>
                                                                <td align='center' style="width: 30px;"><a href='javascript:ImprimirProcessoDiariasAgrupadas(<?php echo $agrupamentos[$index]->super_sd; ?>);'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'></a></td>-->
                                                                <td align='center' style="width: 30px;"><a href='SolicitacaoDevolver.php?cod=<?php echo $agrupamentos[$index]->super_sd; ?>&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></a></td>
                                                                <?php if($empenhado){?>
                                                                <td align='center' style="width: 30px;"><a href='javascript:liberarEmpenho(<?php echo $agrupamentos[$index]->super_sd; ?>);'><img src='../Icones/ico_aceitar.png' border='0' alt='Liberar Empenho'/></a></td>
                                                                <?php }else{ ?>
                                                                <td align='center' style="width: 30px;"><img src='../Icones/ico_aceitar_off.png' border='0' alt='Liberar Empenho'/></td>
                                                                <?php } ?>
                                                                <td align='center'><?php echo $agrupamentos[$index]->super_sd; ?></td>
                                                                <td align='center'><?php echo $agrupamentos[$index]->diaria_processo; ?></td>
                                                                <td align='center'><?php echo $agrupamentos[$index]->projeto_cd; ?></td>
                                                                <td align='center'><?php echo $agrupamentos[$index]->fonte_cd; ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <table>
                                                <tr class="linhaGrid">
                                                    <td>Legenda:</td>
                                                </tr>
                                                <tr height='20' class='linhaGrid'>
                                                    <td width='20' style="background-color: #8FBC8F"></td>
                                                    <td>Liberar Empenho</td>
                                                </tr>
                                                <tr height='20' class='linhaGrid'>
                                                    <td width='20' style="background-color: #CCCC66"></td>
                                                    <td>Devolvida</td>
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