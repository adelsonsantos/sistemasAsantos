<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaAgrupada.php";
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

		frm.action = "SolicitacaoDiariaAgrupadaInicio.php?acao=buscar";
		frm.submit();
	}
        
        function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "SolicitacaoDiariaAgrupadaInicio.php";
		frm.submit();
	}

        function CarregarGride(ssd,frm){
            
            frm.action = "SolicitacaoDiariaAgrupada.php?acao=ssd&ssd="+ssd;
            frm.submit();
        }
        		
        function ImprimirDiariasAgrupadas(codigo){
            window.open ("ImprimirDiariasAgrupadasEmpenhoPDF.php?cod="+codigo);
        }
		
        function ImprimirProcessoDiariasAgrupadas(codigo)
        {
            window.open ("CapaProcessoDiariasAgrupadasPDF.php?cod="+codigo);
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
                                                            <td colspan="3" align="center" style="width: 40px;">A&ccedil;&otilde;es</td>
                                                            <td align="center">SD</td>
                                                            <td align="center">Processo</td>
                                                            <td align="center">Projeto</td>
                                                            <td align="center">Fonte</td>
                                                        </tr>
                                                    <?php
                                                 
                                                        for ($index = 0; $index < count($agrupamentos); $index++) {  ?>
                                                            <tr height='20' bgcolor='#F5DEB3' class='GridPaginacaoLink'>
                                                                <td align='center' style="width: 30px;"><a href='SolicitacaoDiariaAgrupada.php?acao=ssd&ssd=<?php echo $agrupamentos[$index]->super_sd; ?>'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>
                                                                <td align='center' style="width: 30px;"><a href='javascript:ImprimirDiariasAgrupadas(<?php echo $agrupamentos[$index]->super_sd; ?>);'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>
                                                                <td align='center' style="width: 30px;"><a href='javascript:ImprimirProcessoDiariasAgrupadas(<?php echo $agrupamentos[$index]->super_sd; ?>);'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'></a></td>
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