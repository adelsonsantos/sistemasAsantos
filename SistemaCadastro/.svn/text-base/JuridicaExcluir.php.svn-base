<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClassePessoaJuridica.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function ExcluirForm(frm, checkbox) 
	 {
		frm.action="JuridicaExcluir.php?excluirMultiplo=1&acao=excluir";
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
                                            <td width="360" align="left">&nbsp;Raz&atilde;o Social</td>
                                            <td width="260" align="left">&nbsp;Nome Fantasia</td>                                                                                    
                                            <td width="118" align="left">&nbsp;CNPJ</td>
                                            <td width="80" align="center">Status</td>
                                        </tr>                       
<?

										
										
										$ExcluirCheckbox = $_GET['excluirMultiplo'];
										$codCheckbox 	= $_POST['checkbox'];
										
										If ($ExcluirCheckbox == 1)
                                        {
										
											$sqlConsultaExclusao = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_juridica_cnpj, pessoa_juridica_nm_fantasia FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj WHERE (p.pessoa_id = pj.pessoa_id) AND p.pessoa_id IN (".$codCheckbox. ") ORDER BY UPPER(pessoa_nm)";
                                            $rsConsultaExclusao = pg_query(abreConexao(),$sqlConsultaExclusao);

                                            while($linha=pg_fetch_assoc($rsConsultaExclusao))
                                            {
	
												$Codigo = $codCheckbox;
												
												$CNPJ  				= $linha['pessoa_juridica_cnpj'];
												$NomeFantasia		= $linha['pessoa_juridica_nm_fantasia'];
												$RazaoSocial  		= $linha['pessoa_nm'];
												$StatusNumero   	= $linha['pessoa_st'];
											
												If ($StatusNumero == "0")
                                                {  $StatusNome = "Ativo";
                                                }
                                                else
                                                {  $StatusNome = "Inativo";
                                                }

														echo "<tr height='21' class='dataField'>";
														echo "<td>&nbsp;".$RazaoSocial. "</td>";
														echo "<td>&nbsp;".$NomeFantasia. "</td>";
														echo "<td>&nbsp;".$CNPJ."</td>";
														echo "<td align='center'>" .$StatusNome."</td>";
														echo "</tr>";
                                            	
                                            }
                                        }
								
										Else
                                        {
											echo "<tr height='21' class='dataField'>";
											echo "<td>&nbsp;" .$RazaoSocial. "</td>";
											echo "<td>&nbsp;" .$NomeFantasia."</td>";
											echo "<td>&nbsp;" .$CNPJ. "</td>";
											echo "<td align='center'>" .$StatusNome. "</td>";
											echo "</tr>" ;

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
