<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseUsuario.php";
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
                for(cont=0; cont < frm.elements.length; cont++)
                    frm.elements[cont].style.backgroundColor = '';

                if ((!document.getElementById('sede').checked) && (!document.getElementById('coord').checked))  
                {
                    alert("Escolha o Local de Lotação do Usuário.");
                    frm.radioLocal.focus();
                    frm.radioLocal.style.backgroundColor='#B9DCFF';
                    return false;		
                }		

                if ((document.getElementById('coord').checked) && (frm.combo_usuario_local.value == ""))
                {						
                    alert("Escolha a Coordenadoria.");
                    frm.combo_usuario_local.focus();
                    frm.combo_usuario_local.style.backgroundColor='#B9DCFF';
                    return false;			
                }				

                if (frm.txtLogin.value == "")
                {
                    alert("Campo LOGIN em Branco.");
                    frm.txtLogin.focus();
                    frm.txtLogin.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtEmail.value == "")
                {
                    alert("Campo E-MAIL em Branco.");
                    frm.txtEmail.focus();
                    frm.txtEmail.style.backgroundColor='#B9DCFF';
                    return false;
                }
                else
                {
                    if (frm.txtEmail.value.indexOf('@')==-1 || frm.txtEmail.value.indexOf('.')==-1 )
                    {
                        alert("E-MAIL inserido invalido.");
                        frm.txtEmail.focus();
                        frm.txtEmail.style.backgroundColor='#B9DCFF';
                        return false;
                    }
                }

                if (frm.txtPossuiLogin.value == "0")
                    frm.action = "UsuarioCadastrar.php?acao=incluir";
                else
                    frm.action = "UsuarioCadastrar.php?acao=alterar";

                frm.submit();
            }

        </script>
    </head>

    <body onLoad="WM_initializeToolbar();HabCamposLocal();">
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
                                            <td height="21" colspan="2" width="266">Login</td>
                                            <td height="21" colspan="2" width="334">E-Mail</td> 
                                            <td height="21" width="200" colspan="2">
                                                <?php                                                  
                                                if($id_Coord == '0')
                                                {
                                                    $sede   = "checked";
                                                    $coord  = "";  
                                                }
                                                elseif(($id_Coord != '0')&&($id_Coord != null))
                                                {
                                                    $coord = "checked";
                                                    $sede  = "";                                                    
                                                }
                                                ?>
                                                Sede: <input id="sede" type="radio" name="radioLocal" class="radio" onClick="HabCamposLocal()" value="sede" <?=$sede?> style="width:10px; height:15px;" />
                                                Coordenadoria: <input id="coord" type="radio"  class="radio" name="radioLocal" onClick="HabCamposLocal()" <?=$coord?>  style="width:10px; height:15px;" value="coord"/>
                                            </td> 											
                                        </tr>											
                                        <tr class="dataField">
                                            <td height="21" colspan="2"><input name="txtLogin" maxlength="50" type="text" value="<?=$Login?>" style=" width:120px;"/></td>
                                            <td height="21" colspan="2"><input name="txtEmail" maxlength="200" type="text" value="<?=$Email?>" style=" width:200px;"/></td>                                                      
                                            <td height="21" colspan="2">
                                                <label id="campo_coordenadoria_usu" style="display:none;">
                                                    <select name="combo_usuario_local">
                                                        <option value="">[-------Selecione-------]</option>
                                                    <?php                                                     
                                                        $sql      = "select id_coordenadoria, nome From diaria.coordenadoria order by nome asc";
                                                        $consulta =  pg_query(abreConexao(), $sql);		
                                                        if(pg_num_rows($consulta))
                                                        {			
                                                            while($tupla = pg_fetch_assoc($consulta))
                                                            {                                                                
                                                                $idCoordenadoria   = $tupla["id_coordenadoria"];
                                                                $nomeCoordenadoria = $tupla["nome"];
                                                                
                                                                if(($id_Coord != 0) && ($id_Coord != null))
                                                                {
                                                                    if($id_Coord == $tupla["id_coordenadoria"])
                                                                    {
                                                                        echo "<option selected value=\"$id_Coord\">$nomeCoordenadoria </option>";	
                                                                    }
                                                                }
                                                                echo "<option value=\"$idCoordenadoria\">$nomeCoordenadoria </option>";				
                                                            }	
                                                        }	
                                                    ?>
                                                    </select>
                                                </label>		
                                            </td>										
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21" colspan="2" width="266">Nome</td>
                                            <td height="21" colspan="2" width="334">Estrutura Organizacional</td>
                                            <td height="21" width="100">Ramal</td>
                                            <td height="21" width="100">&nbsp;</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" colspan="2"><?=$Nome?></td>
                                            <td height="21" colspan="2"><?=f_ConsultaEstruturaOrganizacional($EstOrganizacional)?></td>
                                            <td height="21"><?=$Ramal?></td>
                                            <td height="21">&nbsp;</td>
                                        </tr>
                                    </table>                                            
                                <?php
                                    If ($Nome != "")
                                    {
                                ?>
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr class="titulo_pagina">
                                                <td height="30">
                                                    <font size="2">Sistemas Dispon&iacute;veis</font>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                            <tr>
                                                <td>
                                                    <?php
                                                    $sqlSistema = "SELECT * FROM seguranca.sistema WHERE sistema_st = 0 ORDER BY UPPER(sistema_ds)";
                                                    $rsSistema  = pg_query(abreConexao(),$sqlSistema);

                                                    echo "<table width='800' border='0' cellpadding='1' cellspacing='1'>";
                                                        echo "<tr class=GridPaginacaoRegistroCabecalho>";
                                                            echo "<td height=20 colspan=2>Sistema e Tipos de Usuário</td>";
                                                        echo "</tr>";
                                                    while($linha=pg_fetch_assoc($rsSistema))
                                                    {
                                                        $SistemaAcessoCodigo = $linha['sistema_id'];
                                                        $SistemaAcessoNome   = $linha['sistema_nm'];

                                                        $radioNaoNulo = false;
                                                        
                                                        echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                            echo "<td height='20' colspan=2><b>" .$SistemaAcessoNome. "</b></td>";
                                                        echo "</tr>";

                                                        $sqlTipoUsuario = "SELECT * FROM seguranca.tipo_usuario WHERE sistema_id = " .$SistemaAcessoCodigo. " ORDER BY UPPER(tipo_usuario_ds)";
                                                        $rsTipoUsuario  = pg_query(abreConexao(),$sqlTipoUsuario);

                                                        while($linha2=pg_fetch_assoc($rsTipoUsuario))
                                                        {
                                                            $TipoUsuarioCodigo = $linha2['tipo_usuario_id'];
                                                            $TipoUsuarioNome   = $linha2['tipo_usuario_ds'];

                                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                            if ($Codigo != "")
                                                            {
                                                                $sqlConsultaPermissoes = "SELECT tipo_usuario_id FROM seguranca.usuario_tipo_usuario WHERE tipo_usuario_id = " .$TipoUsuarioCodigo." AND pessoa_id = " .$Codigo;
                                                                $rsConsultaPermissoes  = pg_query(abreConexao(),$sqlConsultaPermissoes);
                                                                $linha3                = pg_fetch_assoc($rsConsultaPermissoes);

                                                                if($linha3)
                                                                {
                                                                    $radioNaoNulo = true;
                                                                    echo "<td height='20' width=15><input type='radio' class='checkbox' name='radio".$SistemaAcessoCodigo."' value='".$TipoUsuarioCodigo."' checked /></td>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<td height='20' width=15><input type='radio' class='checkbox' name='radio".$SistemaAcessoCodigo."' value='".$TipoUsuarioCodigo."' /></td>";
                                                                }
                                                            }
                                                            else
                                                            {	 
                                                                echo "<td height='20' width=15><input type='radio' class='checkbox' name='radio".$SistemaAcessoCodigo."' value='".$TipoUsuarioCodigo."' /></td>";                                
                                                            }
                                                                echo "<td height='20' width=785>".$TipoUsuarioNome."</td>";
                                                            echo "</tr>";
                                                        }
                                                        echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                        if($radioNaoNulo)
                                                            echo "<td height='20' width=15><input type='radio' class='checkbox' name='radio".$SistemaAcessoCodigo."' value='0' /></td>";
                                                        else
                                                            echo "<td height='20' width=15><input type='radio' class='checkbox' name='radio".$SistemaAcessoCodigo."' value='0' checked /></td>";
                                                            echo "<td height='20' width=785>Nenhum</td>";
                                                        echo "</tr>";
                                                    }
                                                    echo "</table>";
                                                }
                                                include "../Include/Inc_Linha.php";
                                                if ($MensagemErroBD != "")
                                                {
                                                    echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                                                        echo "<tr class='MensagemErro'>";
                                                            echo "<td>".$MensagemErroBD."</td>";
                                                        echo "</tr>";
                                                        echo "<tr>";
                                                            echo "<td><img src='../Imagens/vazio.gif' width='1' height='10' border='0'/></td>";
                                                        echo "</tr>";
                                                    echo "</table>";
                                                }
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
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input name="txtLocal" id="txtLocal" type="hidden" value="<?=$id_Coord?>"/>
            <input name="txtPossuiLogin" type="hidden" value="<?=$PossuiLogin?>"/>
            <input name="txtCodigo" type="hidden" value="<?=$Codigo?>"/>
        </form>
    </body>
</html>
