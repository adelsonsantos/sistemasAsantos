<table border="0" cellpadding="0" cellspacing="0" width="798" height="20">
    <tr class="GridPaginacaoCabecalho">
        <td align="left">
            <a href="<?=$PaginaLocal?>Cadastrar.php?acaoTitulo=Cadastrar" class="GridPaginacaoRegistroNumRegistro">Novo</a> |
        <?php 
            //<a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="Javascript:AlterarForm(document.Form, document.Form.checkbox);">Editar</a> |
	   // removido por Danillo dia 16/08-2010
        ?>
            <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="Javascript:ExcluirForm(document.Form, document.Form.checkbox);">Excluir</a>
        </td>
        <td align="right">
            <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:MarcaCheckbox(document.Form.checkbox);">Marcar Todos</a> |
            <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:DesmarcaCheckbox(document.Form.checkbox);">Desmarcar Todos</a>
        </td>
    </tr>
</table>

