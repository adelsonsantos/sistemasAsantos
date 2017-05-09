<?php
        //define o nome da pagina local para facilitar nos links
		$PaginaLocal = "SolicitacaoGestao";
		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;
		If (($AcaoSistema == "consultar")|| ($AcaoSistema == ""))
		{
			$Codigo = $_GET['cod'];
			$sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.motivo m, diaria.diaria_comprovacao dc WHERE (d.diaria_id = dc.diaria_id) AND (d.motivo_id = m.motivo_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }
		ElseIf ($AcaoSistema == "empenhar")
        {
					$Codigo 		= $_POST['txtCodigo'];
					$Empenho        = $_POST['txtEmpenho'];
					$DataEmpenho    = $_POST['txtDataEmpenho'];
					$sqlAltera = "UPDATE diaria.diaria_comprovacao SET diaria_comprovacao_empenho = '".$Empenho. "', diaria_comprovacao_dt_empenho = '".$DataEmpenho."' WHERE diaria_id = ".$Codigo;
					pg_query(abreConexao(),$sqlAltera);
                    echo "<script>window.location = 'ComprovacaoAprovacaoInicio.php ';</script>";
        }
?>
