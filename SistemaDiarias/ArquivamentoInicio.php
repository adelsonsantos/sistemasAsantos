<?php
include "Classe/ClasseDiariaArquivamento.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-BR" lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="Description" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta name="Keywords" content="ADAB, Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia, Defesa Agropecu&aacute;ria, Agropecu&aacute;ria Bahia" />
        <meta name="language" content="pt-br" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />       
        <meta name="DC.title" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title>      
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript"  language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript"  language="javascript">
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

                frm.action = "ArquivamentoInicio.php?acao=buscar";
                frm.submit();
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "ArquivamentoInicio.php";
                frm.submit();
            }

            function Arquivar(codigo)
            {
                var resposta = confirm('Tem certeza que deseja arquivar a diária?');

                if (resposta == true)
                {
                    document.Form.action="ArquivamentoInicio.php?cod="+codigo+"&acao=arquivar";
                    document.Form.submit();
                }
            }
/* Função que Arquivar todas as Diárias*/
            function ArquivarTodasDiarias(checkboxArquivarDiaria)
            {
                CodigoDiarias ='';

                for (i=0; i < checkboxArquivarDiaria.length; i++) 
                {
                    if (checkboxArquivarDiaria[i].checked) 
                    {                    
                        CodigoDiarias = (checkboxArquivarDiaria[i].value)+','+CodigoDiarias ;
                    }
                }
                
                if (CodigoDiarias == "")
                {                
                    alert("Todas as Diárias já foram Arquivadas.\nPara Arquivar alguma Diária é Nécessário Selecionar Alguma.!!!");
                    return;
                }		

                if (CodigoDiarias.length > 4)
                {   //retira a barra do final	
                    CodigoDiarias = CodigoDiarias.split("/,");
                }
                
                var resposta = confirm('Tem certeza que deseja Arquivar Todas as Diárias Selecionadas ?');
                if (resposta == true)
                {
                    Form.action = "ArquivamentoInicio.php?acao=ArquivarTodasDiarias&Codigos="+CodigoDiarias;		  
                    document.Form.submit();		  
                }		  
            }
            function AlteraAno()
            {
                document.Form.action="ArquivamentoInicio.php?filtroAno="+$('#cmbAno').val();
                document.Form.submit();
            }
        </script>
    </head>

    <body onLoad="WM_initializeToolbar();">
        <form name="Form" method="post" action="">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                   <td><?php include "../Include/Inc_Topo.php"?></td>
                </tr>
                <tr>
                    <td><?php include "../Include/Inc_Aba.php"?></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">

                                    <?php include "../Include/Inc_Titulo.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <?php include "../Include/Inc_Pesquisa_Sem_Filtro.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    
                                    <table cellpadding="1" cellspacing="1" width="100%" border="0" class="GridPaginacao">
                                        <tr>
                                            <td width="200" align="left" height='20'>
                                                <input type="button" style="width:100px; height: 20px;" onClick="javascript:ArquivarTodasDiarias(document.Form.checkboxArquivarDiaria);" class="botao" value="Arquivar Diárias"/>
                                                <img src='../Icones/ico_arquivar.png' border="0" alt="Arquivar Diárias"/>
                                            </td>
                                            <td width="300" align="right" height='20' class="GridPaginacaoRegistroNumRegistro">EXIBIR DIÁRIAS DO ANO DE 
                                               <?php f_ComboAno('cmbAno','80',$cmbAno,'onChange="javascript:AlteraAno();" size="1"','2');?>
                                            </td>
                                            <td width="300" align="right" height='20'>
                                                <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:MarcaCheckbox(document.Form.checkboxArquivarDiaria);">Marcar Todos</a> |
                                                <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:DesmarcaCheckbox(document.Form.checkboxArquivarDiaria);">Desmarcar Todos</a>
                                            </td>
                                        </tr>						
                                    </table>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="100%" class="GridPaginacao">
                                        <tr class="dataLabel">
                                            <td height="20" width="100" colspan="4"></td>
                                            <td height="20" width="80" align="center">SD</td>
                                            <td height="20" width="290" align="left">Nome</td>
                                            <td height="20" width="68" align="center">Data</td>
                                            <td height="20" width="130" align="center">Partida Efetiva</td>
                                            <td height="20" width="130" align="center">Chegada Efetiva</td>
                                        </tr>
                                        <?php
                                        while($linha=pg_fetch_assoc($rsConsulta))
                                        {
                                            $Codigo         = $linha['diaria_id'];
                                            $Numero         = $linha['diaria_numero'];
                                            $Nome           = $linha['pessoa_nm'];
                                            $DataPartida    = $linha['diaria_comprovacao_dt_saida'];
                                            $HoraPartida    = $linha['diaria_comprovacao_hr_saida'];
                                            $DataChegada    = $linha['diaria_comprovacao_dt_chegada'];
                                            $HoraChegada    = $linha['diaria_comprovacao_hr_chegada'];
                                            $DataCriacao    = $linha['diaria_dt_criacao'];
                                            $Status         = $linha['diaria_st'];

                                            $DataCriacao    = f_FormataData($DataCriacao);

                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                echo "<td height='20' width='100' align='center' bgcolor='#8FBC8F' ><input type='checkbox' class='checkbox'name='checkboxArquivarDiaria' value= ".$Codigo."/></td>";
                                                echo "<td height='20' align='center'><a href='SolicitacaoConsultarFinanceiro.php?acao=consultar&cod=".$Codigo."&pagina=Arquivamento'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>";
                                                echo "<td height='20' align='center'><a href='SolicitacaoDevolver.php?cod=".$Codigo."&pagina=Arquivamento'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'/></a></td>";
                                                echo "<td height='20' align='center'><a href='javascript:Arquivar(".$Codigo.")'><img src='../Icones/ico_arquivar.png' border='0' alt='Arquivar'/></a></td>";
                                                echo "<td height='20' align='center'>".$Numero."</td>";
                                                echo "<td height='20'>".$Nome."</a></td>";
                                                echo "<td height='20' align='center'>".$DataCriacao."</a></td>";
                                                echo "<td height='20' align='center'>".$DataPartida." &agrave;s ".$HoraPartida."</td>";
                                                echo "<td height='20' align='center'>".$DataChegada." &agrave;s ".$HoraChegada."</td>";
                                            echo "</tr>";
                                        }
                                        ?>
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

