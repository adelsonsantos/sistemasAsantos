<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAssociarAutorizador.php";
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
    <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
    <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    <script type="text/javascript" language="javascript">
        function AdicionarAutorizador(frm)
        {
            frm.action = "AssociarAutorizador.php?acao=incluir&diretoria="+$('#comboDiretoria').val()+"&autorizador="+$('#cmbAutorizador').val();
            frm.submit();
        }
        function ExcluirAutorizador(frm,codUnid,codPessoa)
        {
            frm.action = "AssociarAutorizador.php?acao=excluir&diretoria="+codUnid+"&autorizador="+codPessoa;
            frm.submit();
        }
    </script>
</head>
<body onLoad="WM_initializeToolbar();">
<form name="Form" method="post">
    <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td><?php include "../Include/Inc_Topo.php"?></td>
        </tr>
        <tr>
            <td><?php include"../Include/Inc_Aba.php"?></td>
        </tr>
        <tr>
            <td align="left">
                <table width="990" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                        <td valign="top" align="left">
                            <?php
                            include "../Include/Inc_Titulo.php";
                            include "../Include/Inc_Linha.php";

                            $i = 0;
                            ?>
                            <table border='0' cellpadding='1' cellspacing='1' width='100%' class='GridPaginacao'>
                                <tr class=dataLabel>
                                    <td height=21 width=200>Unidade</td>
                                    <td height=21 width=498 align='center'>Autorizador</td>
                                    <td height=21 width=100 ></td>
                                </tr>
                                <tr class=dataLabel>
                                    <td height=21 width=200>
                                        <select name='comboDiretoria' id='comboDiretoria' style='width:150px; height:18px;'>
                                            <option selected value='0'>[---------- Selecione ----------]</option>
                                            <?php $sqlDiretoria = 'SELECT est.est_organizacional_id, est_organizacional_sigla 
                                                                       FROM dados_unico.est_organizacional est
                                                                      WHERE est_organizacional_st = 0
                                                                        AND est_organizacional_id 
                                                                         IN (
                                                                             SELECT diaria_unidade_custo 
                                                                             FROM diaria.diaria
                                                                             WHERE diaria_st = 0 
                                                                             ) 
                                                                    ORDER BY est_organizacional_sigla ASC';
                                            $consultaDiretoria = pg_query(abreConexao(),$sqlDiretoria);
                                            while ($linhaDiretoria = pg_fetch_assoc($consultaDiretoria))
                                            {
                                                echo "<option value=".$linhaDiretoria['est_organizacional_id'].">".$linhaDiretoria['est_organizacional_sigla']."</option>";
                                            } ?>
                                        </select>
                                    </td>
                                    <td height=21 width=498 align='center'>
                                        <?php echo f_ComboAutorizador('',$i); ?>
                                    </td>
                                    <td height=21 width=100 ><input type='button' style='width:80px' onClick='Javascript:AdicionarAutorizador(document.Form, );' name='btnAdicionar' id='btnAdicionar' class='botao' value='Adicionar'/></td>
                                </tr>
                            </table>


                            <hr>
                            <table border='0' cellpadding='1' cellspacing='1' width='100%' class='GridPaginacao'>
                                <tr>
                                    <th align='center'>Unidade</th>
                                    <th align='center'>Autorizador</th>
                                    <th align='center'>Excluir</th>
                                </tr>
                                <?php
                                While ($linharsACP = pg_fetch_assoc($rsACP))
                                {
                                    $sql     = "SELECT DISTINCT pessoa_id FROM diaria.autorizador_acp WHERE est_organizacional_id = ".$linharsACP['est_organizacional_id'];
                                    $rs      = pg_query(abreConexao(),$sql);
                                    While ($linhars = pg_fetch_assoc($rs))
                                    {
                                        If($linhars)
                                        {
                                            $CodigoPessoa  = $linhars['pessoa_id'];
                                        }
                                        Else
                                        {
                                            $CodigoPessoa = 0;
                                        }
                                        ?>
                                        <tr>
                                            <td align='center' id='".$CodigoPessoa."' class="txtUnidade{$id}">
                                                <input type="text" name="<?="txtUnidade"?>" id="<?="txtUnidade"?>" readonly value="<?=$linharsACP['est_organizacional_sigla'];?>">
                                                <input type="hidden" name="<?="codUnidade"?>" id="<?="codUnidade"?>" readonly value="<?=$linharsACP['est_organizacional_id'];?>">
                                            </td>
                                            <td align='center' id="">
                                                <input type="text" style="width: 382px" name="txtAutorizador" id="txtAutorizador" readonly value="<?php echo f_NomePessoa($CodigoPessoa);?>">
                                                <input type="hidden" name="codAutorizador" id="codAutorizador" value="<?php echo $CodigoPessoa;?>">
                                            </td>
                                            <td align='center'>
                                                <input type='button' style='width:80px' onClick='Javascript:ExcluirAutorizador(document.Form,<?=$linharsACP['est_organizacional_id']?>,<?php echo $CodigoPessoa;?>);' name='btnExcluir' id='btnExcluir' class='botao' value='Excluir'/>
                                            </td>
                                        </tr>
                                    <?php    }
                                }
                                If ($_GET['sucesso'] == 1)
                                {
                                    echo "<table width='800'>
                                                <tr class='MensagemErro'>
                                                    <td align='right'>Associção realizada com sucesso</td>
                                                </tr>
                                      </table>";
                                }
                                ?>
                                </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
</form>
</body>
</html>

