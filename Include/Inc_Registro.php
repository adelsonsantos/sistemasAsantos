<?php
echo "<td width='20' align='center'><input type='checkbox' class='checkbox' name='checkbox' value=".$CodigoRegistro." /></td>";
    echo "<td width='20' align='center'>";
    if ($_SESSION['BotaoConsultar']== false)
    { 
        echo "<img src='../Icones/ico_consultar_off.png' alt='Consultar' border='0'/>";
    }
    else
    { 
        if ($_SESSION['BotaoConsultar']!=0)
        {  
            echo "<a href='".$PaginaLocal."Consultar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Consultar'><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'></a>";
        }
    }
    echo "</td>";
echo "<td width='20' align='center'><a href='".$PaginaLocal."Cadastrar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Editar'><img src='../Icones/ico_alterar.png' alt='Editar' border='0'/></a></td>";
echo "<td width='20' align='center'><a href='".$PaginaLocal."Excluir.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Excluir'><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'/></a></td>";

?>