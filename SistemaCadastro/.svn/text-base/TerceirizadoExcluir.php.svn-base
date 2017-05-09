<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseTerceirizado.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function ExcluirForm(frm, checkbox)
	 {
		frm.action="TerceirizadoExcluir.php?excluirMultiplo=1&acao=excluir";
		frm.submit();
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

                        <?include "../Include/Inc_TituloExcluir.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="85" align="left">&nbsp;Matr&iacute;cula</td>
                                            <td width="336" align="left">&nbsp;Nome</td>
                                            <td width="155" align="center">&nbsp;Lota&ccedil;&atilde;o</td>
                                            <td width="80" align="center">Status</td>
                                            <td width="30" align="center">&nbsp;</td>
                                        </tr>
<?



										$ExcluirCheckbox = $_GET['excluirMultiplo'];
										$codCheckbox = $_POST['checkbox'];

										If ($ExcluirCheckbox == 1)
                                        {

											$sqlConsultaExclusao = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, lotacao_ds FROM dados_unico.pessoa p,  dados_unico.funcionario f, dados_unico.lotacao l, dados_unico.funcionario_lotacao el WHERE (f.funcionario_id = el.funcionario_id) AND (l.lotacao_id = el.lotacao_id) AND (p.pessoa_id = f.pessoa_id) AND f.pessoa_id IN (" .$codCheckbox. ") ORDER BY UPPER(pessoa_nm)";
                                            $rsConsultaExclusao = pg_query(abreConexao(),$sqlConsultaExclusao);

                                            while($linha=pg_fetch_assoc($rsConsultaExclusao))
                                            {

												$Codigo = $codCheckbox;

												$Matricula  		= $linha['funcionario_matricula'];
												$Lotacao  			= $linha['lotacao_ds'];
												$Nome	   			= $linha['pessoa_nm'];
												$StatusNumero   	= $linha['pessoa_st'];
												$DataCriacao   		= $linha['pessoa_dt_criacao'];
												$DataAlteracao 		= $linha['pessoa_dt_alteracao'];

												

													If ($DataAlteracao != "")
                                                    {
														$strTextoAlteracao = " - Alterado em " .$DataAlteracao;
                                                    }
													Else
													{	$strTextoAlteracao = "";

                                                    }


													If ($StatusNumero == "0")
                                                    {  $StatusNome = "Ativo";

                                                    }
                                                    Else
                                                    { $StatusNome = "Inativo";

                                                    }

?>
                                                    <tr height="21" class="dataField">
                                                        <td>&nbsp;<?=$Matricula?></td>
                                                        <td>&nbsp;<?=$Nome?></td>
                                                        <td>&nbsp;<?=$Lotacao?></td>
                                                        <td width="80" align="center"><?=$StatusNome?></td>
                                                        <td width="30" align="center"><img src="..\imagens\calendar.gif" alt="Criado em <?=$DataCriacao?> <?=$strTextoAlteracao?>"></td>
                                                    </tr>
<?
                                            }
                                        }
											
                                            
                                       Else
                                       {

													If ($PessoaDataAlteracao != "")
                                                    {
														$strTextoAlteracao = " - Alterado em ".$PessoaDataAlteracao;
                                                    }
													Else
													{	$strTextoAlteracao = "";

                                                    }
													
?>
                                                    <tr height="21" class="dataField">
                                                        <td>&nbsp;<?=$Matricula?></td>
                                                        <td><?=$Nome?></td>
                                                        <td align="center"><?=f_ConsultaLotacao($Lotacao)?></td>
                                                        <td width="80" align="center"><?=$StatusNome?></td>
                                                        <td width="30" align="center"><img src="..\imagens\calendar.gif" alt="Criado em <?=$PessoaDataCriacao?> <?=$strTextoAlteracao?>"></td>
                                                    </tr>
<?
                                       }
?>
                        				</table>
									</td>
								</tr>
							</table>

						<?include "../Include/Inc_Linha.php"?>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">

<?
									If ($ExcluirCheckbox == 1)
                                    {
?>
	                    				<button style="width:70px" onClick="Javascript:ExcluirForm(document.Form);" class="botao">Sim</button>&nbsp;&nbsp;
<?
                                    }
                                    Else
                                    {
?>
                                    	<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$Codigo?>';" class="botao">Sim</button>&nbsp;&nbsp;
<?
                                    }
?>
                                	<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" class="botao">N&atilde;o</button>
								</td>
                           	</tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
</table>
<input name="txtCodigo" type="hidden" value="<?=$Codigo?>">
</form>

</body>
</html>
