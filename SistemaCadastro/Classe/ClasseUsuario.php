<?php
//define o nome da pagina local para facilitar nos links
$PaginaLocal = "Usuario";
//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

$ErroTipoUsuario = 1;

if (($AcaoSistema == "buscar") || ($AcaoSistema == "")) 
{
    $numFiltro = $_GET['filtro'];

    if ($RetornoFiltro != "") 
    {
        $sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u RIGHT JOIN dados_unico.pessoa p ON (p.pessoa_id = u.pessoa_id) WHERE (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR usuario_login ILIKE '%" . $RetornoFiltro . "%' OR est_organizacional_sigla ILIKE '%" . $RetornoFiltro . "%') ORDER BY UPPER(pessoa_nm)";
    } 
    else 
    {
        if ($numFiltro == "1") 
        {
            $sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u, dados_unico.pessoa p WHERE (p.pessoa_id = u.pessoa_id) AND (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 ORDER BY UPPER(pessoa_nm) ";
        }
        elseif ($numFiltro == "0") 
        {
            $sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u RIGHT JOIN dados_unico.pessoa p ON (p.pessoa_id = u.pessoa_id) WHERE (usuario_login is null) AND (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 ORDER BY UPPER(pessoa_nm) ";
        }
        else 
        {
            $sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u RIGHT JOIN dados_unico.pessoa p ON (p.pessoa_id = u.pessoa_id) WHERE (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 ORDER BY UPPER(pessoa_nm) ";
        }
    }

    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
} 
ElseIf ($AcaoSistema == "incluir") 
{    
    $DataCriacao = date("Y-m-d");
    $Codigo      = $_POST['txtCodigo'];
    $Login       = trim(strtolower($_POST['txtLogin']));
    $Email       = trim(strtolower($_POST['txtEmail']));

    $sqlConsulta = "SELECT pessoa_id FROM seguranca.usuario WHERE usuario_login = '".$Login."'";
    $rsConsulta  = pg_query(abreConexao(), $sqlConsulta);

    If (pg_num_rows($rsConsulta) == 0) 
    {
        $CurrPass = f_GeraSenha();        
        // Aqui vamos inserir o c�digo da coordenadoria
        $ID_coord = $_POST['combo_usuario_local']; // Atributo Novo Colocado por Erinaldo em 25/02/2011	
        
        if ($ID_coord == "[-------Selecione-------]") 
        {
            $ID_coord = 0;
        }
        elseif($ID_coord == "")
        {
            $ID_coord = 0;
        }
        // $sqlInsere = "INSERT INTO seguranca.usuario (pessoa_id, usuario_login, usuario_senha, usuario_dt_criacao,id_coordenadoria) VALUES (" .$Codigo. ", '" .$Login. "', '" .strtolower($CurrPass). "', '" .$DataCriacao. "')";
        $sqlInsere = "INSERT INTO seguranca.usuario (pessoa_id, usuario_login, usuario_senha, usuario_dt_criacao,id_coordenadoria) VALUES (".$Codigo.", '".$Login."', '".sha1($CurrPass)."', '".$DataCriacao."',".$ID_coord.")";
        pg_query(abreConexao(), $sqlInsere);

        $sqlSistema = "SELECT * FROM seguranca.sistema WHERE sistema_st = 0 ORDER BY UPPER(sistema_ds)";
        $rsSistema = pg_query(abreConexao(), $sqlSistema);
        
        If ($_SESSION['UsuarioEmail'] == 0) 
        {
            $sqlAltera = "UPDATE dados_unico.funcionario SET funcionario_email = '".$Email."' WHERE pessoa_id = " . $Codigo;
            pg_query(abreConexao(), $sqlAltera);
        }
        
        $linha = pg_fetch_assoc($rsSistema);

        While ($linha) 
        {
            $SistemaAcessoCodigo = $linha['sistema_id'];
            $TipoUsuario = $_POST["radio".$SistemaAcessoCodigo];
            
            If ($TipoUsuario != "" && $TipoUsuario != 0) 
            {
                $ErroTipoUsuario = 0;
                $sqlInsere = "INSERT INTO seguranca.usuario_tipo_usuario (pessoa_id, tipo_usuario_id) VALUES (" . $Codigo . ", " . $TipoUsuario . ")";
                pg_query(abreConexao(), $sqlInsere);
            }
            $linha = pg_fetch_assoc($rsSistema);
        }
        If ($ErroTipoUsuario == 1) 
        {
            $sqlDeleta = "DELETE FROM seguranca.usuario WHERE pessoa_id = " . $Codigo;
            pg_query(abreConexao(), $sqlDeleta);
        }
               
        // REMETENTE
        $FromEmail = "sistemas.adab@adab.ba.gov.br";
        $FromName = "Sistema Corporativo (ADAB - Agencia de Defesa Agropecuaria da Bahia)";
        // ASSUNTO
        $subj = "Informativo - Senha para acesso ao Sistema Corporativo de Di&aacute;rias";
        // MESSAGEM
        $texto .= "Caro(a) Servidor(a),<br><br>";
        $texto .= "Segue seu login e senha para acesso ao Sistema Corporativo:<br><br>";
        $texto.= "Login: ".$Login."<br>";   
        $texto.= "Senha: ".$CurrPass."<br><br>";
        $texto.= "<font color=#ff0000><strong>ACESSE O <a href='http://sdadab.ba.gov.br/gestor/Home/Login.php' target='_blank'> Sistema de Diárias</a> DIGITE SEU LOGIN E SENHA<strong></font><br><br>";
        $texto.= "<font><strong>A T E N Ç Ã O! Sua senha é pessoal e intransferível<strong></font><br><br>";		
        $texto.= "Assessoria de Planejamento Estratégico (APE)<br>";
        $texto.= "GT Sistemas<br>";
        $texto.= "Telefones: (71) 3116-7824 / 7861<br><br>";
        $texto.= "E-mail: sistemas.adab@adab.ba.gov.br<br><br><br>";        	
        // CABECALHO
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers.= 'To: <'.$Email.'>' . "\r\n";
        $headers.= 'From: '.$FromName.' <'.$FromEmail.'>' . "\r\n";               
        
        mail($Email, $subj, $texto, $headers);
        
        If ($Err != 0) 
        { //error occurred
            $bSuccess = False;
        }
        Else 
        {
            $bSuccess = True;
            echo "<script>window.location = 'UsuarioInicio.php ';</script>";
        }
    }
    Else 
    {
        $MensagemErroBD = "LOGIN EXISTENTE.";
    }
} 
ElseIf ($AcaoSistema == "consultar") 
{
    $Codigo = $_GET['cod'];
    $_SESSION['UsuarioEmail'] = 0;

    $sqlConsulta = "SELECT 
                           pessoa_nm,
                           eof.est_organizacional_id, 
                           funcionario_email, 
                           funcionario_ramal, 
                           p.pessoa_id,
                           id_coordenadoria 
                    FROM dados_unico.pessoa p                     
                    JOIN dados_unico.pessoa_fisica pf
                      ON pf.pessoa_id = p.pessoa_id
                    JOIN dados_unico.funcionario f 
                      ON pf.pessoa_id = f.pessoa_id
                    JOIN dados_unico.est_organizacional_funcionario eof
                      ON eof.funcionario_id = f.funcionario_id
               LEFT JOIN seguranca.usuario u
                      ON p.pessoa_id = u.pessoa_id
                   WHERE eof.est_organizacional_funcionario_st = 0
                     AND pessoa_fisica_funcionario = 1
                     AND p.pessoa_id = " . $Codigo;
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    $linha = pg_fetch_assoc($rsConsulta);
    
    If ($linha) 
    {
        $Codigo            = $linha['pessoa_id'];
        $Nome              = $linha['pessoa_nm'];
        $EstOrganizacional = $linha['est_organizacional_id'];
        $Email             = $linha['funcionario_email'];
        $Ramal             = $linha['funcionario_ramal'];
        $id_Coord          = $linha['id_coordenadoria'];

        $sqlConsultaUsuario = "SELECT * FROM seguranca.usuario WHERE pessoa_id = " . $Codigo;
        $rsConsultaUsuario = pg_query(abreConexao(), $sqlConsultaUsuario);

        //traz o login caso o funcionario já possua login
        $linha1 = pg_fetch_assoc($rsConsultaUsuario);
        If ($linha1)
        {
            $Login = $linha1['usuario_login'];
        }

        If ($Email != "") 
        {
            $_SESSION['UsuarioEmail'] = 1;
        }

        If ($StatusNumero == "0") 
        {
            $StatusNome = "Ativo";
        }

        $sqlConsultaUsuario = "SELECT usuario_login FROM seguranca.usuario WHERE pessoa_id = " . $Codigo;
        $rsConsultaUsuario = pg_query(abreConexao(), $sqlConsultaUsuario);
        $linha2 = pg_fetch_assoc($rsConsultaUsuario);
        
        If ($linha2) 
        {
            $PossuiLogin = 1;
        }
        Else 
        {
            $PossuiLogin = 0;
        }
    } 
    Else 
    {
        $MensagemErroBD = "REGISTRO NÂO EXISTENTE.";
    }
} 
ElseIf ($AcaoSistema == "alterar") 
{
    $Codigo = $_POST['txtCodigo'];
    $Login = trim(strtolower($_POST['txtLogin']));
    $Email = trim(strtolower($_POST['txtEmail']));
 
    // Aqui vamos inserir o c�digo da coordenadoria
    $ID_coord = $_POST['combo_usuario_local']; // Atributo Novo Colocado por Erinaldo em 25/02/2011			
    if ($ID_coord == "[-------Selecione-------]") 
    {
        $ID_coord = 0;
    }
    elseif($ID_coord == "")
    {
        $ID_coord = 0;
    }

    $sqlConsulta = "SELECT pessoa_id FROM seguranca.usuario WHERE (UPPER(usuario_login) = '" . strtoupper($Login) . "') AND pessoa_id <> " . $Codigo;

    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

    If (pg_num_rows($rsConsulta) == 0) 
    {
        $Date = date("Y-m-d");
        $sqlAltera = "UPDATE seguranca.usuario SET id_coordenadoria = $ID_coord , usuario_login = '".$Login."', usuario_dt_alteracao = '".$Date."' WHERE pessoa_id = ".$Codigo;

        pg_query(abreConexao(), $sqlAltera);

        $sqlAltera = "UPDATE dados_unico.funcionario SET funcionario_email = '" . $Email . "' WHERE pessoa_id = " . $Codigo;
        pg_query(abreConexao(), $sqlAltera);

        $sqlSistema = "SELECT * FROM seguranca.sistema WHERE sistema_st = 0 ORDER BY UPPER(sistema_ds)";
        $rsSistema = pg_query(abreConexao(), $sqlSistema);

        $linha = pg_fetch_assoc($rsSistema);
        
        $sqlDeleta = "DELETE FROM seguranca.usuario_tipo_usuario WHERE pessoa_id = " . $Codigo; 
        pg_query(abreConexao(), $sqlDeleta);

        While ($linha) 
        {
            $SistemaAcessoCodigo = $linha['sistema_id'];
            $TipoUsuario = $_POST["radio". $SistemaAcessoCodigo];
            
            print "<br>";
            If ($TipoUsuario != "" && $TipoUsuario != "0") 
            {
                $sqlInsere = "INSERT INTO seguranca.usuario_tipo_usuario (pessoa_id, tipo_usuario_id) VALUES (" . $Codigo . ", " . $TipoUsuario . ")";
                pg_query(abreConexao(), $sqlInsere);
            }            
            $linha = pg_fetch_assoc($rsSistema);
        }         
        echo "<script>window.location = 'UsuarioInicio.php ';</script>";
    } 
    Else 
    {
        $MensagemErroBD = "REGISTRO JÁ; EXISTENTE.";
    }
} 
ElseIf ($AcaoSistema == "alterarStatus") 
{
    $DataAlteracao = date("Y-m-d");
    $Codigo        = $_GET['cod'];
    $StatusNumero  = $_GET['status'];

    If ($StatusNumero == 0) 
    {
        $StatusNumero = 1;
    }
    Else 
    {
        $StatusNumero = 0;
    }

    $sqlAltera = "UPDATE seguranca.usuario SET usuario_st = " . $StatusNumero . ", usuario_dt_alteracao = '" . $DataAlteracao . "' WHERE usuario_id = " . $Codigo;
    pg_query(abreConexao(), $sqlAltera);

    echo "<script>window.location = 'UsuarioInicio.php ';</script>";
} 
ElseIf ($AcaoSistema == "excluir") 
{
    $Codigo = $_GET['cod'];
    $sqlDeleta = "UPDATE seguranca.usuario SET usuario_st = 2  WHERE pessoa_id = " . $Codigo;
    pg_query(abreConexao(), $sqlDeleta);

    echo "<script>window.location ='UsuarioInicio.php ';</script>";
}
?>
