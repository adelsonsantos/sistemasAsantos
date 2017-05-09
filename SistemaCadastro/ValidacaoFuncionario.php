<?php
include "../Include/Inc_Configuracao.php";


if ($acaosistema == "")
{
	$AcaoSistema = "consultar";
}


$CodigoValidacao = $_SESSION['UsuarioCodigo'];
?>
<?include "Classe/ClasseFuncionarioValidacao.php"?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptAjax.js"></script>
<script language="javascript" src="JavaScript/FormPessoaValidacao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

-->
</script>

<body onLoad="Foco(document.Form);">

<form name="Form" method="post">

<table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
       <td><?include "../Include/Inc_Topo.php"?></td>
    </tr>
    <tr>
    	<td>
            <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td valign="top" align="left">

                    <table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
                        <tr>
                            <td align="left" class="titulo_pagina">&nbsp;Valida&ccedil;&atilde;o do Funcion&atilde;rio</td>
                        </tr>
                    </table>

                        <?include "../Include/Inc_Linha.php"?>

						<?include "IncludeLocal/IncludeCadastroDadosBasicos.php"?>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="1">Dados Adicionais</font></td></tr></table>

						<?include "IncludeLocal/IncludeCadastroDadosAdicionais.php"?>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="1">Endere&ccedil;o</font></td></tr></table>

						<?include "IncludeLocal/IncludeCadastroEndereco.php"?>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="1">Contato</font></td></tr></table>

						<?include "IncludeLocal/IncludeCadastroContato.php"?>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="1">Dados Funcionais</font></td></tr></table>

						<?include "IncludeLocal/IncludeCadastroInformacoesOrganizacionaisValidacao.php"?>

                        <table width="798" border="0" cellpadding="0" cellspacing="1">
                            <tr height="21">
                                <td class="dataLinha">(*) Campo obrigat&oacute;rio</td>
                            </tr>
                        </table>

                        <input name="txtCodigo" type="hidden" value="<?=$Codigo?>">
                        <input name="txtEstruturaOriginal" type="hidden" value="<?=$EstruturaAtuacao?>">
                        <input name="erroCPF" type="hidden" value="">


                        <table border="0" cellpadding="0" cellspacing="0" width="800">
                            <tr height="25">
                                <td align="right"><input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form);" value="Gravar"><br><br><br>
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
