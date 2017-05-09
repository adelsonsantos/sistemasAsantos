<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaEstorno.php";
?>

<html>

    <style type="text/css">@import url("../css/estilo.css"); </style>

    <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
    <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

    <script language="javascript" type="text/javascript">
        <!--
        function ImprimeSelecao(checkbox)
        {
            StringDiaria ='';
            
			if (!checkbox.length)
			{
                if (checkbox.checked == false)
                {
                    StringDiaria = checkbox.value;
                }
			}
			else
			{
				for (i = 0 ; i < checkbox.length ; i++)
				{
					if (checkbox[i].checked == true)
					{
						StringDiaria = (checkbox[i].value)+','+StringDiaria ;
					}
				}
			}
            if (StringDiaria == "") 
			{
               alert("Favor selecionar as diárias para impressão!! ");
               return;
            }
		    if (StringDiaria.length > 4)
			{
				StringDiaria = StringDiaria.substr(0,StringDiaria.length-1);//retira a virgula do final
					
			}
		 document.Form.action="DiariaEstornoPDF.php?Multiplos="+StringDiaria+"&acao=ImprimirEstorno";
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
                alert("Digite filtro para busca.");
                frm.txtFiltro.focus();
                frm.txtFiltro.style.backgroundColor='#B9DCFF';
                return false;
            }

            frm.action = "DiariaEstornoInicio.php?acao=buscar";
            frm.submit();
        }

        function TodosForm(frm)
        {
            frm.txtFiltro.value = "";
            frm.action = "DiariaEstornoInicio.php";
            frm.submit();
        }
        function ConfirmarEstornoFinanceiro(codigo,numero)
        {
            var resposta = confirm('Confirma ESTORNO FINANCEIRO da diária '+numero+'?');

            if (resposta == true)
            {
                document.Form.action="DiariaEstornoInicio.php?cod="+codigo+"&acao=EstornoFinanceiro";
                document.Form.submit();
            }

        }
        -->
    </script>

    <body onLoad="WM_initializeToolbar();">

        <form name="Form" method="post">

            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?include "../Include/Inc_Topo.php"?></td>
                </tr>
                <tr>
                    <td><?include "../Include/Inc_Aba.php"?></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">

                                    <?include "../Include/Inc_Titulo.php"?>

                                    <?include "../Include/Inc_Linha.php"?>

                                    <table cellpadding="0" cellspacing="0" border="0" width="800">
                                        <tr>
                                            <td align="center" class="tabPesquisa" >

                                                <table cellpadding="0" border="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="3" border="0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="LinhaTexto">
                                                            <table cellpadding="0" border="0" cellspacing="0" width="100%">
                                                                <tr>
                                                                    <td width="270" class="dataField">&nbsp;<input name="txtFiltro" id="txtFiltro" maxlength="100" type="text" value="<?=$RetornoFiltro?>" style=" width:265px;" onKeyPress="Javascript:if(event.keyCode == 13) Javascript:FiltrarForm(document.Form);" ></td>


                                                                    <td width="75" valign="middle"><button style="width:70px; height: 18px;" onClick="Javascript:FiltrarForm(document.Form);" class="botao">Pesquisar</button></td>


                                                                    <?php
                                                                    if($RetornoFiltro!="") {
                                                                        ?>
                                                                    <td valign="middle"><button style="width:90px; height: 18px;" onClick="Javascript:TodosForm(document.Form);" class="botao">Exibir Todos</button></td>
<? }
                                                                    else {
                                                                        ?>
                                                                    <td>&nbsp;</td>
                                                                    <?
}

                                                                    ?>
                                                                    </td>
                                                                </tr>
                                                            </table>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="2" border="0"></td>
                                                    </tr>
                                                    <tr class="GridPaginacaoCabecalho">
                                                        <td align="right">
                                                            <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:MarcaCheckbox(document.Form.checkbox);">Marcar Todos</a> |
                                                            <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:DesmarcaCheckbox(document.Form.checkbox);">Desmarcar Todos</a>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>


                                    <table cellpadding="0" cellspacing="0" width="800" border="0">
                                        <tr>
                                            <td align="right" height='20'><a href="#" onClick='Javascript:ImprimeSelecao(document.Form.checkbox);'>Imprimir Estorno</a> <img src="../Icones/ico_imprimir.png" border="0" alt="Extrato Empenho" onClick='Javascript:ImprimeSelecao(document.Form.checkbox);'></td>
                                        </tr>
                                    </table>
<?include "../Include/Inc_Linha.php"?>
                                    <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                    <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                        <td width="60" colspan="3"></td>

                                                        <td width="80" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=d.diaria_id'><u>SD</u></a></td>
                                                        <td width="100" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=pessoa_fisica_cpf'><u>CPF</u></a></td>
                                                        <td width="290" align="left">&nbsp;<a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=pessoa_nm'><u>Nome</u></a></td>
                                                        <td width="68" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=d.diaria_dt_criacao'><u>Data Solicitação</u></a></td>
                                                        <td width="130" align="center">Valor da Solicitacão</td>
                                                        <td width="130" align="center">Valor da Comprovação</td>
                                                        <td width="60" align="center">Valor a Restituir</td>
                                                    </tr>
<?
                                                    while($linharsConsulta=pg_fetch_assoc($rsConsulta)) {
                                                        $Codigo	     	= $linharsConsulta['diaria_id'];
                                                        $Numero             = $linharsConsulta['diaria_numero'];
                                                        $Nome               = $linharsConsulta['pessoa_nm'];
                                                        $CPF                = $linharsConsulta['pessoa_fisica_cpf'];
                                                        $Comprovacao_Saldo	= $linharsConsulta['diaria_comprovacao_saldo'];
                                                        $Comprovacao_Valor  = $linharsConsulta['diaria_comprovacao_valor'];
                                                        $Diaria_Valor	= $linharsConsulta['diaria_valor'];
                                                        $DataCriacao	= f_FormataData($linharsConsulta['diaria_dt_criacao']);
                                                        $Estorno_Status	= $linharsConsulta['diaria_estorno_situacao'];
                                                        $Comprovacao_Saldo  = ConverteStringMoeda($Comprovacao_Saldo)*(-1);
                                                        // Mostrar apenas as diária que não passaram pelo estorno financeiro e orçamentário.
                                                        // **********************************************************************************
                                                        // Estorno_Status = 0 Aguardando Estorno Financeiro.
                                                        // Estorno_Status = 2 Estorno Comcluido.

                                                        if ($Estorno_Status!= '2') {

                                                            echo "<tr height='20' bgcolor='#f2f2f2' class='GridPaginacaoLink' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                            echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo."></td>";
                                                            echo "<td align='center'><a href=ComprovacaoConsultar.php?cod=" .$Codigo. "&acao=consultar&&pagina=DiariaEstorno><img src='../icones/ico_consultar.png' alt='Consultar' border='0'></a></td>";

                                                            if ($Estorno_Status == 0 and (($_SESSION["Sistemas"][$_SESSION["Sistema"]] == 'Gestor Diarias') or ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == 'Administrador'))) {
                                                                echo "<td align='center'><a href=javascript:ConfirmarEstornoFinanceiro(".$Codigo.",".$Numero.")><img src='../Icones/ico_estono_financeiro.png' border='0' alt='Estorno Financeiro'></a></td>";
                                                            }
                                                            else {
                                                                echo "<td align='center'><img src='../Icones/ico_estono_off.gif' border='0' alt='Estorno Financeiro'></a></td>";
                                                            }
                                                            echo "<td align='center'>".$Numero."</td>";
                                                            echo "<td align='center'>".$CPF."</td>";
                                                            echo "<td>&nbsp;".$Nome."</a></td>";
                                                            echo "<td align='center'>".$DataCriacao."</a></td>";
                                                            echo "<td align='right'>".$Diaria_Valor."</td>";
                                                            echo "<td align='right'>".$Comprovacao_Valor."</td>";
                                                            echo "<td align='right'>".number_format($Comprovacao_Saldo, 2, ',', '.')."</td>";
                                                            echo "</tr>";
                                                        }
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