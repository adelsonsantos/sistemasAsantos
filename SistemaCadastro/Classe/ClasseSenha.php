<?php

If ($AcaoSistema == "alterar")
{
    $SenhaAntiga = sha1($_POST['txtSenhaAtual']);
    $NovaSenha = sha1($_POST['txtNovaSenha']);
    $Codigo = $_POST['txtCodigo'];

    $sqlConsulta = "SELECT pessoa_id FROM seguranca.usuario WHERE usuario_senha = '".$SenhaAntiga."' AND pessoa_id = ".$Codigo;

    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    $linha=pg_fetch_assoc($rsConsulta);
    If($linha) {
        $sqlAltera = "UPDATE seguranca.usuario SET usuario_senha = '".$NovaSenha."', usuario_primeiro_logon = 0 WHERE pessoa_id = ".$Codigo;
        pg_query(abreConexao(),$sqlAltera);
        echo "<script>window.location = 'Home.php ';</script>";
    }
    Else {	$MensagemErroBD = "SENHA ATUAL FORNECIDA &Eacute; INV&Aacute;LIDA.";
    }
}
?>