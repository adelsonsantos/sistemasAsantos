<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClassePessoaJuridica.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptAjax.js"></script>
<script language="javascript" src="JavaScript/FormPessoaJuridica.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function Foco(frm)
	{
		frm.txtCNPJ.focus();
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
    	<td>
            <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td valign="top" align="left" width="190"><?include "../Include/Inc_Menu.php"?></td>
                    <td valign="top" align="left">

                        <?// inicio titulo da pagina ?>

                        <div id="titulopagina">

                        <?include "../Include/Inc_Titulo.php"?>

                        </div>

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <?// inicio aba de cadastramento ?>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td >
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
											<?// aba 1 ?>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba1_on">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_on.gif" align="center" class="linktab">Dados Principais</td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba1_off" style="cursor:hand;display:none">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_off.gif" align="center"><a class="linktab" href="#" onClick="mostra_obj_id(aba1_on); esconde_obj_id(aba1_off); mostra_obj_id(formaba1); mostra_obj_id(aba2_off); esconde_obj_id(aba2_on); esconde_obj_id(formaba2); mostra_obj_id(aba3_off); esconde_obj_id(aba3_on); esconde_obj_id(formaba3);">Dados Principais</a></td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18"></td>
                                                    </tr>
                                                 </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
											<?// aba 2 ?>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba2_on" style="cursor:hand;display:none">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_on.gif" align="center" class="linktab">Endere&ccedil;o</td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba2_off">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_off.gif" align="center"><a class="linktab" href="#" onClick="esconde_obj_id(aba1_on); mostra_obj_id(aba1_off); esconde_obj_id(formaba1); esconde_obj_id(aba2_off); mostra_obj_id(aba2_on); mostra_obj_id(formaba2); mostra_obj_id(aba3_off); esconde_obj_id(aba3_on); esconde_obj_id(formaba3);">Endere&ccedil;o</a></td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
											<?// aba 3 ?>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba3_on" style="cursor:hand;display:none">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_on.gif" align="center" class="linktab">Contato</td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba3_off">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_off.gif" align="center"><a class="linktab" href="#" onClick="esconde_obj_id(aba1_on); mostra_obj_id(aba1_off); esconde_obj_id(formaba1); mostra_obj_id(aba2_off); esconde_obj_id(aba2_on); esconde_obj_id(formaba2); esconde_obj_id(aba3_off); mostra_obj_id(aba3_on); mostra_obj_id(formaba3);">Contato</a></td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="20"><img src="../Imagens/separa_aba.gif" width="180" height="18"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="tabFiltro"><img src="../Imagens/vazio.gif" width="1" height="10"></td>
                            </tr>
                        </table>

						<?include "../Include/Inc_Linha.php"?>

                        <?// fim das abas ?>

                        <div id="formaba1" style="display:show">  <?// inicio dados principais ?>

						<?include "IncludeLocal/IncludeCadastroJuridicaDadosBasicos.php"?>

                        </div> <?// fim dados pessoais ?>


                        <div id="formaba2" style="display:none"> <?// inicio endereco ?>

						<?include "IncludeLocal/IncludeCadastroEndereco.php"?>

                        </div> <?// fim endereco ?>


                        <div id="formaba3" style="display:none"> <?// inicio contato ?>

						<?include "IncludeLocal/IncludeCadastroJuridicaContato.php"?>

                        </div> <?// fim contato ?>

                        <table width="798" border="0" cellpadding="0" cellspacing="1">
                            <tr height="21">
                                <td class="dataLinha">(*) Campo obrigat&oacute;rio</td>
                            </tr>
                        </table>

                        <input name="txtCodigo" type="hidden" value="<?=$Codigo?>">

						<?include "../Include/Inc_Linha.php"?>
<?
						If ($MensagemErroBD != "")
                        {

							echo"<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
							echo"<tr>";
							echo"<td class='MensagemErro'>".$MensagemErroBD."</td>";
							echo"</tr>";
							echo"<tr>";
							echo"<td><img src='../images/vazio.gif' width='1' height='10' border='0'></td>";
							echo"</tr>";
							echo"</table>";
                        }

						
?>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
                                <button style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao">Gravar</button>&nbsp;&nbsp;&nbsp;
<?
								If (($Codigo != "")&&($AcaoSistema == "excluir"))
                                {
                                ?>
	                    			<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$Codigo?>'" name="btnSim" class="botao">Sim</button>&nbsp;&nbsp;&nbsp;
<?
                                }
?>
								<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao">Voltar</button>
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
