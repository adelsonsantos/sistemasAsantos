<?php
include("../Include/conexao.class.php");

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
					echo "Não existe";
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
					echo "Não existe";
			}
			break;
	}
}
?>