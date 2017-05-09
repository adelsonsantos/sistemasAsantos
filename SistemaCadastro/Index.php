<?php
include "../Include/Inc_Configuracao.php";

$_SESSION['Sistema'] = $_GET['sistema'];

$sqlConsulta = "SELECT * FROM seguranca.tipo_usuario tp, seguranca.usuario_tipo_usuario utu WHERE (tp.tipo_usuario_id = utu.tipo_usuario_id) AND sistema_id = " .$_SESSION['Sistema']. " AND pessoa_id = ".$_SESSION['UsuarioCodigo'];
  
$rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
$linha       = pg_fetch_assoc($rsConsulta);

If ($linha)
{ 
    $_SESSION['TipoUsuario'] = $linha['tipo_usuario_id'];
    
    If ($linha['tipo_usuario_ds'] == "Administrador")
    {
        $_SESSION['Administrador'] = 1;
    }
    Else
    {
        $_SESSION['Administrador'] = 0;
    }
}

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
        <script type="text/javascript" language="javascript">
            window.location.href = 'FuncionarioInicio.php';
        </script>
    </head>
    <body></body>
</html>