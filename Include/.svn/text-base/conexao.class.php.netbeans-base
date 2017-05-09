<?php
class Conexao
{
	private $db;
	private $conexao;
	
	public function __construct($host="localhost", $user="postgres", $password="123456", $db = "diarias_producao", $port = "5432")
	{
		$this->db["host"]    = $host;
		$this->db["user"]    = $user;
		$this->db["password"] = $password;
		$this->db["db"]      = $db;
		$this->db["port"]    = $port;
		$this->conexao       = NULL;
	}
	
	public function __destruct()
	{
		if($this->conexao)
			@pg_close($this->conexao);
	}
	
	public function abreConexao()
  {
		if(!$this->conexao)
			$this->conexao = @pg_connect("host=".$this->db["host"]." dbname=".$this->db["db"]." port=".$this->db["port"]." user=".$this->db["user"]." password=".$this->db["password"]) or die("Conexao com o banco falhou!");
  }
	
	public function fechaConexao()
	{
		if($this->conexao)
		{
			@pg_close($this->conexao);
			$this->conexao = NULL;
		}
	}
	
	public function query($query)
	{
		$this->abreConexao();
		$result = @pg_query($this->conexao, $query);
		$this->fechaConexao();
		
		return $result;
	}
}

/*$teste = new Conexao("127.0.0.1", "postgres", "123456", "bd_h_gestor_externo");
$t = $teste->query("SELECT * FROM dados_unico.estado");
while ($row = pg_fetch_row($t)) {
  echo "Author: $row[0]  E-mail: $row[1]";
  echo "<br />\n";
}*/

?>