<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaGestao.php";
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
                alert("Digite filtro para busca.");
                frm.txtFiltro.focus();
                frm.txtFiltro.style.backgroundColor='#B9DCFF';
                return false;
            }

            frm.action = "SolicitacaoGestaoInicio.php?acao=buscar";
            frm.submit();
        }

        function TodosForm(frm)
        {
            frm.txtFiltro.value = "";
            frm.action = "SolicitacaoGestaoInicio.php";
            frm.submit();
        }

        function AutorizarForm(frm, checkbox)
        {
            cont = 0;
            for (i = 0 ; i < checkbox.length ; i++)
                if (checkbox[i].checked == true)
            {
                cont = cont + 1;
            }

            if (cont == 0)
            {
                alert("Escolha pelo menos uma\nSOLICITA��O DE DI�RIA.");
                return false;
            }

            var resposta = confirm('Tem certeza que deseja autorizar a(s) di�ria(s)?');

            if (resposta == true)
            {
                frm.action="SolicitacaoGestaoInicio.php?acao=autorizar";
                frm.submit();
            }

        }


        function ImprimirDiaria(codigo)
        {
            window.open ("SolicitacaoImprimirPDF.php?acao=imprimir&cod="+codigo);
        }

        function ImprimirProcesso(codigo)
        {
            window.open ("SolicitacaoProcessoPDF.php?acao=imprimir&cod="+codigo);
        }
        function LiberarEmpenho (codigo)
        {
            var resposta = confirm('Tem certeza que deseja LIBERAR o EMPENHO?');
            if (resposta == true)
            {
                window.location="SolicitacaoGestaoInicio.php?acao=empenharST&Cod="+codigo;
            }
        }
        function LiberarSegundoEmpenho (codigo)
        {
            var resposta = confirm('Tem certeza que deseja LIBERAR o 2� EMPENHO?');
            if (resposta == true)
            {
                window.location="SolicitacaoGestaoInicio.php?acao=SegundoEmpenharST&Cod="+codigo;
            }
        }

        function ExtratoEmpenho (checkbox)
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
					//Se o checkbox estiver marcado a di�ria j� foi impressa
					if (checkbox[i].checked == false)
					{
						StringDiaria = (checkbox[i].value)+','+StringDiaria ;
					}
				}
			}
            if (StringDiaria == "") 
			{
               alert("Todas as di�rias j� foram IMPRESSAS.\n\Para REIMPRIMIR alguma di�ria DESMARQUE a mesma!");
               return;
            }
          if (StringDiaria.length > 4)
		  {
		  		StringDiaria = StringDiaria.substr(0,StringDiaria.length-1);//retira a virgula do final
			    
		  }
		  document.Form.action="SolicitacaoImprimirEmpenhoPDF.php?Multiplos="+StringDiaria;
          document.Form.submit();
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
                                            <td align="right" height='20'><a href="javascript:ExtratoEmpenho(document.Form.checkbox);" >Imprimir Extrato Empenho</a> <a href="javascript:ExtratoEmpenho(document.Form.checkbox);" ><img src="../Icones/ico_imprimir.png" border="0" alt="Extrato Empenho"></a></td>
                                        </tr>
                                    </table>

                                    <?include "../Include/Inc_Linha.php"?>

                                    <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                    <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                        <td width="150" colspan="7"></td>
                                                        <td width="90" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=diaria_id'><u>SD</u></a></td>
                                                        <td width="308" align="left">&nbsp;<a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=pessoa_nm'><u>Nome</u></a></td>
                                                        <td width="130" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=diaria_dt_criacao'><u>Data Solicita&ccedil;&atilde;o</u></a></td>
                                                        <td width="130" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=diaria_dt_saida'><u>Partida Prevista</u></a></td>
                                                        <td width="10" >EMP</td>
                                                    </tr>
                                                    <?
                                                    while($linharsConsulta=pg_fetch_assoc($rsConsulta)) {
                                                        $Codigo				= $linharsConsulta['diaria_id'];
                                                        $Numero				= $linharsConsulta['diaria_numero'];
                                                        $Nome				= $linharsConsulta['pessoa_nm'];
                                                        $DataPartida                    = $linharsConsulta['diaria_dt_saida'];
                                                        $HoraPartida                    = $linharsConsulta['diaria_hr_saida'];
                                                        $DataChegada                    = $linharsConsulta['diaria_dt_chegada'];
                                                        $DataDaSolicitacao              = $linharsConsulta['diaria_dt_criacao'];
                                                        $HoraDaSolicitacao              = $linharsConsulta['diaria_hr_criacao'];
                                                        $HoraChegada                    = $linharsConsulta['diaria_hr_chegada'];
                                                        $Status				= $linharsConsulta['diaria_st'];
                                                        $Beneficiario                   = $linharsConsulta['diaria_beneficiario'];
                                                        $Processo			= $linharsConsulta['diaria_processo'];
                                                        $Empenho			= $linharsConsulta['diaria_empenho'];
                                                        $Devolvida			= $linharsConsulta['diaria_devolvida'];
                                                        $Indenizacao			= $linharsConsulta['indenizacao'];
                                                        $Convenio			= $linharsConsulta['convenio_id'];
                                                        $ExtratoEmpenho                 = $linharsConsulta['diaria_extrato_empenho'];
                                                        ?>
                                                        <?include "IncludeLocal/Inc_Regra_Bloqueio.php"?>

                                                        <?include "IncludeLocal/Inc_Status_Diaria.php"?>
                                                        <?
                                                        // DIARIA NO PRIMEIRO EMPENHO.
                                                        if ($Status == 2)
                                                        {
                                                            echo "<tr height='20' bgcolor='#f2f2f2' class='GridPaginacaoLink' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                            
                                                            if ($ExtratoEmpenho == 1)
                                                            {
                                                                echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo." checked></td>";
                                                            }
                                                            else
                                                            {
                                                                echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo."></td>";
                                                            }
                                                            echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" .$Codigo."&pagina=SolicitacaoGestao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                            echo "<td align='center'><a href='SolicitacaoEmpenhar.php?cod=" .$Codigo. "&acao=consultar&pagina=SolicitacaoGestao'><img src='../Icones/ico_comprovar.png' border='0' alt='Empenhar'></a></td>";

                                                            
                                                            if(($Processo != "") && ($Empenho!=""))
                                                            {
                                                                echo "<td align='center'><a href='javascript:ImprimirDiaria(" .$Codigo. ");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
                                                            }
                                                            else {
                                                                echo "<td align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
                                                            }
                                                            
                                                            if(($Processo != "") && ($Empenho!="")) {
                                                                echo "<td align='center'><a href='javascript:ImprimirProcesso(" .$Codigo. ");'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'></a></td>";
                                                            }
                                                            else {
                                                                echo "<td align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'></a></td>";
                                                            }
                                                            /*

                                                            '*****************************************************************************
                                                            ' Alterado por Rodolfo em 16/09/2008
                                                            ' Solicita��o da DA - Paulo Bispo - Diaria Comprovada n�o pode ser devolvida
                                                            '*****************************************************************************
                                                             *
                                                             */
                                                            IF (($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status == 2)) {
                                                                echo "<td align='center'><img src='../icones/ico_devolver_offG.png' alt='Devolver' border='0'></td>";
                                                            }
                                                            else {    echo "<td align='center'><a href='SolicitacaoDevolver.php?cod=".$Codigo."&pagina=SolicitacaoGestao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></a></td>";
                                                            }

                                                            IF ($Empenho=="") {
                                                                echo "<td align='center'><img src='../icones/ico_aceitar_off.png' alt='Liberar Empenho' border='0'></td>";
                                                            }
                                                            else {
                                                                echo "<td align='center'><a href='javascript:LiberarEmpenho(" .$Codigo. ");'><img src='../Icones/ico_aceitar.png' border='0' alt='Liberar Empenho'></a></td>";
                                                            }
                                                            echo "<td align='center'>".$Numero."</td>";
                                                            echo "<td>&nbsp;" .$Nome."</a></td>";
                                                            echo "<td align='center'>".f_FormataData($DataDaSolicitacao)." &agrave;s ".$HoraDaSolicitacao."</td>";
                                                            echo "<td align='center'>".$DataPartida." &agrave;s ".$HoraPartida."</td>";
                                                            echo "<td align='center'>";
                                                        }
                                                        else
                                                        {
                                                        // DIARIO NO SEGUNDO EMPENHO.
                                                            echo "<tr height='20' bgcolor='#f2f2f2' class='GridPaginacaoLink' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                            if ($ExtratoEmpenho == 1)
                                                            {
                                                                echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo." checked></td>";
                                                            }
                                                            else
                                                            {
                                                                echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo."></td>";
                                                            }
                                                            echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" .$Codigo."&pagina=SolicitacaoGestao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                            echo "<td align='center'><a href='SolicitacaoEmpenhar.php?cod=" .$Codigo. "&acao=consultar&pagina=SolicitacaoGestao'><img src='../Icones/ico_comprovar.png' border='0' alt='Empenhar'></a></td>";
                                                            echo "<td align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
                                                            echo "<td align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'></a></td>";
                                                            IF (($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status == 6)) {
                                                                echo "<td align='center'><img src='../icones/ico_devolver_offG.png' alt='Devolver' border='0'></td>";
                                                            }
                                                            else {    echo "<td align='center'><a href='SolicitacaoDevolver.php?cod=".$Codigo."&pagina=SolicitacaoGestao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></a></td>";
                                                            }

                                                            IF ($Empenho=="") {
                                                                echo "<td align='center'><img src='../icones/ico_aceitar_off.png' alt='Liberar Empenho' border='0'></td>";
                                                            }
                                                            else {
                                                                echo "<td align='center'><a href='javascript:LiberarSegundoEmpenho(" .$Codigo. ");'><img src='../Icones/ico_aceitar.png' border='0' alt='Liberar Empenho'></a></td>";
                                                            }
                                                            
                                                            echo "<td align='center'><font color='#CC9933'>".$Numero."</font></td>";
                                                            echo "<td>&nbsp;<font color='#CC9933'>" .$Nome."</font></a></td>";
                                                            echo "<td align='center'><font color='#CC9933'>".f_FormataData($DataDaSolicitacao)." &agrave;s ".$HoraDaSolicitacao."</font></td>";
                                                            echo "<td align='center'><font color='#CC9933'>".$DataPartida." &agrave;s ".$HoraPartida."</font></td>";
                                                            echo "<td align='center'>";
                                                            

                                                        }
                                                       // VERIFICA O TIPO DE DI�RIA SE � INDENIZA��O, CONVENIO OU NORMAL 
                                                       if ($Indenizacao == 0)
                                                            {
                                                                if ($Convenio == 0)
                                                                    {
                                                                        if ($Status ==2){echo "N-1";}
                                                                        else{echo "<font color='#CC9933'>N-2</font>";}
                                                                    }
                                                                 else
                                                                    {
                                                                        if ($Status ==2){echo "C-1";}
                                                                        else{echo "<font color='#CC9933'>C-2</font>";}
                                                                    }
                                                            }
                                                         else
                                                            {
                                                                if ($Status ==2){echo "I";}
                                                                else{echo "<font color='#CC9933'>I-2</font>";}
                                                            }

                                                        echo "</td>";
                                                        echo "</tr>";

                                                        If (($StatusNome == "Devolvida") || ($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status == 2)) {

                                                            echo "<tr height='20' bgcolor='#f2f2f2'>";
                                                            echo "<td class='GridPaginacaoLink'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0'></td>";
                                                            echo "<td class='GridPaginacaoLink' colspan='7'>&nbsp;&nbsp;&nbsp;<font color='#ff0000'>&nbsp;".$MotivoDevolucao.": ".$labelDevolucao."</font></td>";
                                                            echo "<td></td>";
                                                            echo "<td></td>";

                                                        }

                                                        If ($ContadorVirtual > 1) {    echo "<tr height='21'><td colspan='11' class='dataField'>&nbsp;Beneficiario com Diaria comprovada e pendente de documenta&ccedil;&atilde;o - &nbsp;".$NumeroDiariaVirtual."</td>";

                                                        }
                                                        If ($ContadorAtraso > 0) {        echo "<tr height='21'><td colspan='11' class='dataField'>&nbsp;Beneficiario que n&atilde;o fez comprova&ccedil;&atilde;o - &nbsp;".$NumeroDiariaAtrasada."</td>";

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