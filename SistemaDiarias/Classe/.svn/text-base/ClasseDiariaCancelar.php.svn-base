<?php

		$Codigo = $_POST['txtCodigo'];

		If ($AcaoSistema == "")
        {

					$sqlConsulta = "SELECT diaria_id, diaria_numero, pessoa_nm, diaria_dt_saida, diaria_hr_saida, diaria_dt_chegada, diaria_hr_chegada, motivo_ds, diaria_st, diaria_beneficiario, diaria_solicitante FROM diaria.diaria d, dados_unico.funcionario f, diaria.motivo m, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (m.motivo_id = d.motivo_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 0 AND diaria_id = " .$Codigo;
                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }
		ElseIf ($AcaoSistema == "cancelar")
        {

					$Codigo = $_POST['txtCodigo'];
                    $Date=date("Y-m-d");
                    $Time=date("H:i:s");
					$sqlAltera = "UPDATE diaria.diaria SET diaria_st = 0, diaria_cancelada = 1 WHERE diaria_id = " .$Codigo;
					pg_query(abreConexao(),$sqlAltera);

					$sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);
					$Descricao = strtoupper(trim($_POST['txtDescricao']));
					$Motivo    = $_POST['cmbMotivoDiaria'];

					$sqlInsere = "INSERT INTO diaria.diaria_cancelamento (diaria_id, motivo_id, diaria_cancelamento_ds, diaria_cancelamento_dt, diaria_cancelamento_hr, diaria_cancelamento_func) VALUES (" .$Codigo.", " .$Motivo. ", '" .$Descricao. "', '" .$Date. "', '" .$Time. "'," .$linha['funcionario_id']. ")";

					pg_query(abreConexao(),$sqlInsere);
					echo "<script>window.location = 'SolicitacaoInicio.php ';</script>";

        }
?>
