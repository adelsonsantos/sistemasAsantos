<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaComprovacaoAprovacaoSei.php";
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
    <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8'></meta>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title>
    <style type="text/css">@import url("../css/estilo.css"); </style>
    <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
    <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    <script type="text/javascript" language="javascript" charset="utf-8">
        function Foco(frm)
        {
            console.log('2');
            frm.txtFiltro.focus();
        }
        console.log('2');
        function FiltrarForm(frm)
        {
            console.log('2');
            for(cont=0; cont < frm.elements.length; cont++)
                frm.elements[cont].style.backgroundColor = '';

            if (frm.txtFiltro.value == "")
            {
                alert("Digite filtro para busca.");
                frm.txtFiltro.focus();
                frm.txtFiltro.style.backgroundColor='#B9DCFF';
                return false;
            }

            frm.action = "ComprovacaoAprovacaoInicioSei.php?acao=buscar";
            frm.submit();
        }

        function TodosForm(frm)
        {

            frm.txtFiltro.value = "";
            frm.action = "ComprovacaoAprovacaoInicioSei.php";
            frm.submit();
        }

        function Aprovar(codigo)
        {

            var resposta = confirm('Tem certeza que deseja aprovar a comprovação do SEI?');

            if (resposta == true)
            {
                document.Form.action="ComprovacaoAprovacaoSeiInicio.php?cod="+codigo+"&acao=aprovar";
                document.Form.submit();
            }

        }
    </script>
</head>

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
                            <?php include "../Include/Inc_Linha.php" ?>
                            <?php include "../Include/Inc_Pesquisa_Sem_Filtro.php" ?>
                            <?php include "../Include/Inc_Linha.php" ?>
                            <table border="0" cellpadding="1" cellspacing="1" width="798" class="GridPaginacao">
                                <tr class="dataLabel">
                                    <td height="5" width="8%" colspan="3"></td>
                                    <td height="20" width="8%" align="center">SD</td>
                                    <td height="20" width="29%" align="left">Nome</td>
                                    <td height="20" width="10%" align="left">Partida Efetiva</td>
                                    <td height="20" width="10%" align="center">Chegada Efetiva</td>
                                    <td height="20" width="10%" align="center">Processo</td>
                                    <td height="20" width="30%" align="center">Status</td>
                                </tr>
                                <?php
                                //DADOS PARA A PAGINAÇÃO
                                $paginaAtual        = (int)$_GET['PaginaMostrada'];
                                $qtdRegistroPagina  = $iPageSize;
                                $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                $qtdPagina          = ceil($qtdPagina);

                                while(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal))
                                {
                                    $linhaDiaria     = pg_fetch_assoc($rsConsulta, $qtdIndice);

                                    $Codigo          = $linhaDiaria['diaria_id'];
                                    $Numero          = $linhaDiaria['diaria_numero'];
                                    $DataPartida     = $linhaDiaria['diaria_comprovacao_dt_saida'];
                                    $HoraPartida     = $linhaDiaria['diaria_comprovacao_hr_saida'];
                                    $DataChegada     = $linhaDiaria['diaria_comprovacao_dt_chegada'];
                                    $HoraChegada     = $linhaDiaria['diaria_comprovacao_hr_chegada'];
                                    $Processo        = $linhaDiaria['diaria_processo'];
                                    $Status          = $linhaDiaria['diaria_st'];
                                    $Nome            = $linhaDiaria['pessoa_nm'];
                                    $StatusDevolvida = $linhaDiaria['diaria_devolvida'];
                                    $Processo        = $linhaDiaria['diaria_processo'];

                                    include "IncludeLocal/Inc_StatusDiaria.php";

                                    echo "<tr bgcolor='#f2f2f2' class='GridPaginacaoLink' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                    echo "  <td height='20' align='center'><a href='ComprovacaoConsultar.php?acao=consultar&cod=" . $Codigo . "&pagina=ComprovacaoAprovacao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>";
                                    echo "  <td height='20' align='center'><a href='ComprovacaoDevolver.php?cod=" . $Codigo . "&pagina=ComprovacaoAprovacao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'/></a></td>";
                                    echo "  <td height='20' align='center'><a href='javascript:Aprovar(" . $Codigo . ")'><img src='../Icones/ico_aceitar.png' border='0' alt='Aprovar'/></a></td>";
                                    echo "  <td height='20' align='center'>" . $Numero . "</td>";
                                    echo "  <td height='20'>" . $Nome . "</td>";
                                    echo "  <td height='20'>" . $DataPartida . " &agrave;s " . $HoraPartida ."</td>";
                                    echo "  <td height='20' align='center'>" . $DataChegada . " &agrave;s " . $HoraChegada . "</td>";
                                    echo "  <td height='20'>" . $Processo . "</td>";
                                    echo "  <td height='20' align='center'><font color='#000099'>" .$StatusNome. "</td>";
                                    echo "</tr>";

                                    if ($StatusDevolvida == "1")
                                    {
                                        $sqlConsultaMotivoDevolucao     = "SELECT diaria_devolucao_ds, motivo_ds FROM diaria.diaria_devolucao d, diaria.motivo m WHERE (d.motivo_id = m.motivo_id) AND diaria_id = " .$Codigo." ORDER BY diaria_devolucao_id DESC LIMIT 1";
                                        $rsConsultaMotivoDevolucao      = pg_query(abreConexao(),$sqlConsultaMotivoDevolucao);
                                        $linharsConsultaMotivoDevolucao = pg_fetch_assoc($rsConsultaMotivoDevolucao);
                                        $labelDevolucao                 = "";
                                        $MotivoDevolucao                = "";

                                        if ($linharsConsultaMotivoDevolucao)
                                        {
                                            if ($linharsConsultaMotivoDevolucao['diaria_devolucao_ds'] != "")
                                            {
                                                $labelDevolucao = $linharsConsultaMotivoDevolucao['diaria_devolucao_ds'];
                                            }
                                            $MotivoDevolucao = $linharsConsultaMotivoDevolucao['motivo_ds'];
                                        }

                                        if(($MotivoDevolucao != "") or ($labelDevolucao != ""))
                                        {
                                            echo "<tr bgcolor='#f2f2f2'>";
                                            echo "  <td height='20' class='GridPaginacaoLink'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0'/></td>";
                                            echo "  <td height='20' class='GridPaginacaoLink' colspan='6'><font color='#ff0000'>" . $MotivoDevolucao . ": " . $labelDevolucao . "</font></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    $qtdIndice++;
                                }
                                $paginaAtual++;
                                ?>
                                <tr>
                                    <td height="20" colspan="7"><?php include "IncludeLocal/Inc_Paginacao.php"?></td>
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
