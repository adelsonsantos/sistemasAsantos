<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaAgrupadaExecucao.php";
?>

<html>

    <style type="text/css">@import url("../css/estilo.css"); </style>

    <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
    <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

    <script language="javascript">
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
                alert("Digite filtro para busca.");
                frm.txtFiltro.focus();
                frm.txtFiltro.style.backgroundColor='#B9DCFF';
                return false;
            }

            frm.action = "SolicitacaoFinanceiroExecucaoInicio.php?acao=buscar";
            frm.submit();
        }

        function TodosForm(frm)
        {
            frm.txtFiltro.value = "";
            frm.action = "SolicitacaoFinanceiroExecucaoInicio.php";
            frm.submit();
        }

        /* Função que Executa todas as Diárias*/
        function ExecutarTodasDiarias(checkboxExecutarDiaria){
            CodigoDiarias ='';
            for (i=0; i < checkboxExecutarDiaria.length; i++) {
                if (checkboxExecutarDiaria[i].checked) {
                    CodigoDiarias = (checkboxExecutarDiaria[i].value)+','+CodigoDiarias ;
                }
            }
			
            if (CodigoDiarias == ""){
                alert("Para Executar os Empenhos \u00E9 Necess\u00E1rio Selecionar Alguma Di\u00E1ria.!!!");
                return;
            }		
			
            if (CodigoDiarias.length > 4){
                CodigoDiarias = CodigoDiarias.substr(0,CodigoDiarias.length-1);//retira a virgula do final							
                //	document.write(CodigoDiarias);
            }
		  
            var resposta = confirm('Tem certeza que deseja Executar Todas as Di\u00E1rias Selecionadas ?');
            if (resposta == true)
            {
                Form.action = "SolicitacaoFinanceiroExecucaoInicio.php?acao=executarTodosGrupos&Codigos="+CodigoDiarias;
                document.Form.submit();		  
            }		  
        }
        -->
    </script>

    <body onLoad="WM_initializeToolbar();">

        <form name="Form" method="post">

            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><? include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td><? include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><? include "../Include/Inc_Menu.php" ?></td>
                                <td valign="top" align="left">

                                    <? include "../Include/Inc_Titulo.php" ?>

                                    <? include "../Include/Inc_Linha.php" ?>

                                    <? include "../Include/Inc_Pesquisa_Sem_Filtro.php" ?>

                                    <? include "../Include/Inc_Linha.php" ?>

                                    <? include "../Include/Inc_Linha.php" ?>

                                    <table cellpadding="0" cellspacing="0" width="800" border="1">
                                        <tr>
                                            <td align="left" height='20'><button style="width:100px; height: 20px;" onClick="javascript:ExecutarTodasDiarias(document.getElementsByName('checkboxExecutarDiaria'));" class="botao">Executar Di&aacute;rias</button> <img src='../Icones/ico_arquivar.gif' border="0" alt="Executar Di&aacute;rias"></td>
                                        </tr>

                                        <tr class="GridPaginacaoCabecalho">
                                            <td align="right">
                                                <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:MarcaCheckbox(document.Form.checkboxExecutarDiaria);">Marcar Todos</a> |
                                                <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:DesmarcaCheckbox(document.Form.checkboxExecutarDiaria);">Desmarcar Todos</a>
                                            </td>
                                        </tr>						
                                    </table>

                                    <? include "../Include/Inc_Linha.php" ?>

                                    <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                    <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                            <td width="10"><input class="checkbox" type="checkbox" value="*" name="*" onclick="selecionarTodos(this,'checkboxExecutarDiaria');" /></td>
                                                            <td colspan="3" align="center">A&ccedil;&otilde;es</td>
                                                            <td align="center">SD</td>
                                                            <td align="center">Processo</td>
                                                            <td align="center">Projeto</td>
                                                            <td align="center">Fonte</td>
                                                        </tr>
                                                    <?php
                                                    //include "IncludeLocal/ExecucaoFinanceiroDiariasAgrupadas.php";

                                                    for ($index = 0; $index < count($agrupamentos); $index++) {
                                                        $SD       = $agrupamentos[$index]->super_sd;
                                                        $processo = $agrupamentos[$index]->diaria_processo;
                                                        $projeto  = $agrupamentos[$index]->projeto_cd;
                                                        $fonte    = $agrupamentos[$index]->fonte_cd;
                                                        
                                                    ?>
                                                        <tr height='20' bgcolor='#f2f2f2' class='GridPaginacaoLink' onMouseOver="javascript:this.style.backgroundColor='#cccccc'" onMouseOut="javascript:this.style.backgroundColor='#f2f2f2'">
                                                            <td width='10' align='center' bgcolor='#8FBC8F' ><input type='checkbox' class='checkbox'name='checkboxExecutarDiaria' value= "<?php echo $SD; ?>"/></td>
                                                            <td width='30' align='center'><a href='SolicitacaoDiariaAgrupadaExecucao.php?acao=ssd&ssd=<?php echo $SD; ?>'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>
                                                            <td width='30' align='center'><a href='SolicitacaoExecutar.php?acao=executarAgrupamento&cod=<?php echo $SD; ?>&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_comprovar.png' border='0' alt='Executar'></a></td>
                                                            <td width="30" align='center'><a href='SolicitacaoDevolver.php?cod=<?php echo $SD; ?>&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></a></td>
                                                            <td align='center'><?php echo $SD?></td>
                                                            <td align='center'><?php echo $processo;?></td>
                                                            <td align='center'><?php echo $projeto;?></td>
                                                            <td align='center'><?php echo $fonte;?></td>
                                                       </tr>
                                                    <?php }?>
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