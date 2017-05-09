<?php
 // Verifica se o arquivo já foi importado
if(!defined("CONST_CONECTA.PHP")){
	define("CONST_CONECTA.PHP", "CONECTA.PHP importado"); 
 
// Define os paramentros de conexão com  o PostgreSQL  
define('PGHOST','localhost');
define('PGPORT',5432);
define('PGDATABASE','Diarias_Homologacao');
define('PGUSER', 'postgres');
define('PGPASSWORD', '123456');
define('PGCLIENTENCODING','utf8');
define('ERROR_ON_CONNECT_FAILED','Desculpe, Não foi possível conectar com o Banco de Dados!');
define('CONEXAO_SGBD',pg_pconnect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD));

 // Função que faz a conexão com o Postgres
function conectar_BD(){	

	//$conexao_sgbd = pg_pconnect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
	 if(!CONEXAO_SGBD){
	    die('Não foi possível conectar ao banco de dados: '.pg_result_error());
	  }
	  //else{ echo ' Conexão com o banco '. pg_dbname() .' foi um sucesso'."<br>";}
	return CONEXAO_SGBD;  
}

function codificacao_BD(){
//$code = pg_set_client_encoding(CONEXAO_SGBD, $encoding );
 return pg_client_encoding(CONEXAO_SGBD);	
	
}

// Função que encerra uma conexão com o Postgres
function desconectar_BD(){
	pg_close(CONEXAO_SGBD);
}

// Executa uma consulta e retorna o resultado, se houver
function executar_SQL($SQL){
	// Realiza a consulta
	$resultado = pg_query(CONEXAO_SGBD, $SQL);
	if(!$resultado){
		die('Não foi possível realizar a consulta: ' . pg_last_error());
	}
	// Retorna o resultado da consulta
	return $resultado;
}

// Verifica se a consulta gerou algum resultado
function verifica_resultado($resultado){
	return ( pg_num_rows($resultado) !=0 );	
}

// Coloca uma tupla de uma consulta em um array associativo
function retorna_linha($consulta){
	return pg_fetch_assoc($consulta);	
}

// Retorna o número de linhas do resultado
function numero_linhas($resultado){
	return pg_num_rows($resultado);
}

// Libera a memória do resultado de uma query
function libera_consulta($consulta){
	pg_free_result($consulta);
}
  
 // Valida e converte a data no formato dd/mm/aaaa para o formato aaaa-mm-dd
function valida_data($data){
	if($data[2] == "\\" || $data[5] == "\\")
		return false;

	$dia = intval(substr($data, 0, 2));
	$mes = intval(substr($data, 3, 4));
	$ano = intval(substr($data, 6));

	if(!checkdate($mes, $dia, $ano))
		return false;

	return $ano . "-" . $mes . "-" . $dia;
}

// Converte a data no formato aaaa-mm-dd para o formato dd/mm/aaaa
function converte_data($data){
	if(strlen($data) < 1)
		return "";

	$dia = intval(substr($data, 8));
	$mes = intval(substr($data, 5, 6));
	$ano = intval(substr($data, 0, 4));

	if(strlen($dia) == 1)
		$dia = "0" . $dia;
	if(strlen($mes) == 1)
		$mes = "0" . $mes;

	return $dia . "/" . $mes . "/" . $ano;
}

// Converte a data no formato dd/mm/aaaa para o formato aaaa-mm-dd
function converte_data_postgres($data){
	if(strlen($data) < 1)
		return "";

	$dia = intval(substr($data, 0,2));
	$mes = intval(substr($data, 3, 4));
	$ano = intval(substr($data, 6, 9));

	if(strlen($dia) == 1)
		$dia = "0" . $dia;
	if(strlen($mes) == 1)
		$mes = "0" . $mes;

	return $ano . "-" . $mes . "-" . $dia;
}

// Seta a codificação do Banco
//$codificacao = codificacao_BD();
//echo "<script>alert(\"$codificacao\");</script>";

// Conecta ao banco de dados
$conexao = conectar_BD();

// Recebe data e hora e retorna data convertida para o formato dd/mm/aaaa
function retorna_data($datahora){
	return converte_data(substr($datahora, 0, 10));
}

function dataLog(){
	$data_time = date(" Y-m-d H:i:s");
	return $data_time;
}
function moedaBanco($moeda){
$moeda = str_replace('.', "",$moeda);
$moeda = str_replace(',', ".",$moeda);
$dinheiro  = (float) $moeda;
return $dinheiro;
}

function formatoMoeda($number){
$number = number_format($number,2,',','.');
return $number;
}

// Recebe um número e retorna o mês correspondente
function nome_mes($n){
	switch($n){
		case 1:
			return "Janeiro";
			break;
		case 2:
			return "Fevereiro";
			break;
		case 3:
			return "Março";
			break;
		case 4:
			return "Abril";
			break;
		case 5:
			return "Maio";
			break;
		case 6:
			return "Junho";
			break;
		case 7:
			return "Julho";
			break;
		case 8:
			return "Agosto";
			break;
		case 9:
			return "Setembro";
			break;
		case 10:
			return "Outubro";
			break;
		case 11:
			return "Nobembro";
			break;
		case 12:
			return "Dezembro";
			break;
		default:
			return $n;
	}
}

 } // Fim do if (!defined("CONST_CONECTA.PHP"))
?>