<?php
		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "ComprovacaoAutorizacao";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;

		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {

					If ($RetornoFiltro != "")
                    {
						$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_comprovacao dc WHERE (d.diaria_id = dc.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 5 AND diaria_devolvida = 0 AND (pessoa_nm ILIKE '%" .$RetornoFiltro. "%' OR diaria_numero ILIKE '%" .$RetornoFiltro. "%') ORDER BY diaria_numero";
                    }
                    Else
					{	$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_comprovacao dc WHERE (d.diaria_id = dc.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 5 AND diaria_devolvida = 0 ORDER BY diaria_numero";
                    }

					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "autorizar")
        {
                    $Date=date("Y-m-d");
					$Codigo = $_GET['cod'];
                    $Time=date("H:i:s");

					$sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5 WHERE diaria_id = " .$Codigo;
					pg_query(abreConexao(),$sqlAltera);

					$sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linharsConsulta=pg_fetch_assoc($rsConsulta);
					$sqlInsere = "INSERT INTO diaria.diaria_autorizacao (diaria_id, diaria_autorizacao_func, diaria_autorizacao_func_exec, diaria_autorizacao_dt, diaria_autorizacao_hr) VALUES (" .$Codigo. ", " .$linharsConsulta['funcionario_id']. ", 1, '" .$Date. "', '" .$Time. "')";

					pg_query(abreConexao(),$sqlInsere);

                    echo "<script>window.location = 'ComprovacaoAutorizacaoInicio.php ';</script>";
        }
?>
