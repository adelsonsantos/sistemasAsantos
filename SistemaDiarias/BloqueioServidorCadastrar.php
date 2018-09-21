<?php
include "../Include/Inc_Configuracao.php";
include "../SistemaDiarias/Classe/ClasseBloqueioServidor.php";
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
    <script type="text/javascript" language="javascript" src="funcoes.js"></script>
    <script type="text/javascript" language="javascript">

        function BuscarForm(frm)
        {
            frm.action = "UsuarioCadastrar.php?acao=consultar";
            frm.submit();
        }

        function GravarForm(frm)
        {
            if (frm.txtBloqueio.value !== "")
                frm.action = "BloqueioServidorCadastrar.php?acao=incluir";
            else
                frm.action = "BloqueioServidorCadastrar.php?acao=alterar";
            console.log(frm.action);

            frm.submit();
        }

    </script>
</head>

<body>
<form name="Form" method="post" action="">
    <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td><?php include "../Include/Inc_Topo.php"?></td>
        </tr>
        <tr>
            <td><?php include "../Include/Inc_Aba.php"?></td>
        </tr>
        <tr>
            <td>
                <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                        <td valign="top" align="left">

                            <?php include "../Include/Inc_Titulo.php"?>
                            <?php include "../Include/Inc_Linha.php"?>

                            <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                <tr class="dataLabel">
                                    <td height="21" colspan="2" width="266">Nome</td>
                                    <td height="21" width="100">Matrícula</td>
                                    <td height="21" colspan="2" width="334">Estrutura Organizacional</td>
                                    <td height="21" width="100">Sigla</td>
                                </tr>
                                <tr class="dataField">
                                    <td height="21" colspan="2"><?=$Nome; ?></td>
                                    <td height="21"><?=$Matricula?></td>
                                    <td height="21" colspan="2"><?=$EstruturaDescricao;?></td>
                                    <td height="21"><?=$EstruturaSigla;?></td>
                                </tr>
                            </table>
                            <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                <tr>
                                    <td>
                                        <?php
                                        if($PessoaBloqueio == 0){
                                            $descricaoBloqueio = "";
                                        }


                                                    echo "<table width='800' border='0' cellpadding='1' cellspacing='1'>";
                                                        echo "<tr class=GridPaginacaoRegistroCabecalho>";
                                                            echo "<td height=20 colspan=2>Motivo do Bloqueio</td>";
                                                        echo "</tr>";
                                                        echo "<td><textarea name='txtBloqueio' id='txtBloqueio' cols='129' rows='3' >$descricaoBloqueio</textarea></td>";
                                                    echo "</table>";

                                                include "../Include/Inc_Linha.php";

                                                ?>
                                    </td>
                                </tr>
                            </table>
                            <table border="0" cellpadding="2" cellspacing="2" width="800">
                                <tr>
                                    <td width="800" height="25" align="right">
                                        <input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao" value="Gravar" />
                                        <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                    </td>
                                </tr>
                            </table>
                            <input name="txtPossuiLogin" type="hidden" value="<?=$PossuiLogin?>"/>
                            <input name="txtCodigo" type="hidden" value="<?=$Codigo?>"/>
                            <input name="txtStatus" type="hidden" value="<?=$PessoaBloqueio?>"/>

</form>
</body>
</html>
