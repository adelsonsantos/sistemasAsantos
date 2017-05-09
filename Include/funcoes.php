<?php
function checaAcesso($id)
{
	if( isset($_SESSION["Sistemas"][$id]) )
		return true;
	else
		return false;
}

/*
 * Inverte a data normal para o formato de banco de dados:
 * Ex.: 03/09/2010 -> 2010-09-03
 */
function dataToDB($data)
{
	return $data[6].$data[7].$data[8].$data[9]."-".$data[3].$data[4]."-".$data[0].$data[1];
}

/*
 * Inverte a data do banco de dados para o formato 'normal':
 * Ex.: 2010-09-03 -> 03/09/2010
 */
function DBToData($data, $simbolo = "/")
{
	return $data[8].$data[9].$simbolo.$data[5].$data[6].$simbolo.$data[0].$data[1].$data[2].$data[3];
}


/*
 * Inverte a data do Timestamp para o formato normal e retorna um vetor com a data e a hora:
 * Ex.: 2010-09-03 00:00:00 -> ["Data"] => 03/09/2010 ["Hora"] => 00:00:00
 */
function TimestampToData($timestamp, $simbolo)
{
	$ret["Data"] = $timestamp[8].$timestamp[9].$simbolo.$timestamp[5].$timestamp[6].$simbolo.$timestamp[0].$timestamp[1].$timestamp[2].$timestamp[3];
	$ret["Hora"] = $timestamp[11].$timestamp[12].$timestamp[13].$timestamp[14].$timestamp[15].$timestamp[16].$timestamp[17].$timestamp[18];
	return $ret;
}

include("conexao.class.php");

if(isset($_POST["acao"]))
{
	$acao = $_POST["acao"];

	switch($acao)
	{
		case "buscaCPF":
			if(isset($_POST["cpf"]))
			{

				$cpf = $_POST["cpf"];
				$conexao = new Conexao("10.105.12.28", "postgres", "ambiente", "bd_gestor");
				$result  = $conexao->query("SELECT * FROM dados_unico.pessoa_fisica WHERE pessoa_fisica_cpf = '$cpf'");
				if(pg_fetch_assoc($result))
					echo "existe";
				else
					echo "N&atilde;o existe";
			}
			break;
			
			case "buscaMatricula":
			if(isset($_POST["matricula"]))
			{
				$matricula = $_POST["matricula"];
				$conexao = new Conexao("10.105.12.28", "postgres", "ambiente", "bd_gestor");
				$result  = $conexao->query("SELECT * FROM dados_unico.funcionario WHERE funcionario_matricula = '$matricula'");
				if(pg_fetch_assoc($result))
					echo "existe";
				else
					echo "N&atilde;o existe";
			}
			break;
	}
}
?>