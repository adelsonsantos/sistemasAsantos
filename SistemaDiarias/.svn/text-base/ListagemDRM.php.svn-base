<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAssociarDRM.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

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

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
<?
						$sql = "select distinct p.projeto_cd, projeto_ds from diaria.projeto p, diaria.projeto_acao_territorio pat where (p.projeto_cd = pat.projeto_cd) order by projeto_cd";
						$rs = pg_query(abreConexao(),$sql);

                        while($linha=pg_fetch_assoc($rs))
                        {
                            echo "<tr height=21><td colspan='3'><font size=1>&nbsp;" .$linha['projeto_cd']. " - " .substr($linha['projeto_ds'],0,120)."</td></tr>";

                            $sql1 = "select distinct a.acao_cd, acao_ds from diaria.acao a, diaria.projeto_acao_territorio pat where projeto_cd = " .$linha['projeto_cd']. " and (a.acao_cd = pat.acao_cd) order by acao_ds";

                            $rs1 = pg_query(abreConexao(),$sql1);

                            while($linhars1)
                            {   echo "<tr height=21><td width=30></td><td colspan=2 width=770><font size=1>" .$linhars1['acao_cd']. " - " .substr($linhars1['acao_ds'],0,110)."</td></tr>";

                                $sql2 = "select distinct t.territorio_cd, territorio_ds from diaria.territorio t, diaria.projeto_acao_territorio pat where acao_cd = " .$linhars1['acao_cd']. " and projeto_cd = " .$linha['projeto_cd']. " and (t.territorio_cd = pat.territorio_cd) order by territorio_ds";
                                $rs2 = pg_query(abreConexao(),$sql2);

                                while($linhars2=pg_fetch_assoc($rs2))
                                {  echo "<tr height=21><td width=30></td><td width=30></td><td width=740><font size=1>" .$linhars2['territorio_cd']. " - " .substr($linhars2['territorio_ds'],0,110)."</td></tr>";

                                }
                            }
                        }
?>
                        	<tr>
                            	<td></td>
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