<?php
  //abre conexao
  function abreConexao()
  {  $conexao = pg_connect("host= 127.0.0.1 dbname=diarias_producao port=5432 user=postgres password=123456") or die("Conexao com o banco falhou!");
    //@pg_set_client_encoding($conexao,"UTF-8");
	return $conexao;
  }
?>