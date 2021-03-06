<?php
require_once("../Include/conexao.class.php");
class Historico
{
	private $result;
	private $nRegistros;
	private $id;

	public function __construct($id)
	{
		$this->result     = NULL;
		$this->nRegistros = 0;
		$this->id         = $id;
		$this->construirVetor();
	}

	public function getID($id) { return $this->id; }
	public function getNRegistros() { return $this->nRegistros; }
	public function getRegistros() { return $this->result; }

	private function add($row)
	{
		if($this->nRegistros == 0)
		{
			$this->result[] = $row;
		}
		else
		{
			$i = 0;
			for($i = 0; ($i < $this->nRegistros) && (($this->result[$i]["Data"] < $row["Data"]) || (($this->result[$i]["Data"] == $row["Data"]) && ($this->result[$i]["Hora"] < $row["Hora"]))); $i++);
			if($i >= $this->nRegistros)
			{
				$this->result[] = $row;
			}
			else
			{
				$aux = $this->result[$i];
				$this->result[$i] = $row;

				for($j = $i+1; $j <= $this->nRegistros; $j++)
				{
					$aux2 = $this->result[$j];
					$this->result[$j] = $aux;
					$aux = $aux2;
				}
			}
		}
		$this->nRegistros++;
	}

	private function inverteData($data)
	{
		if(isset($data) && ($data != "") && ($data != " "))
			return $data[8].$data[9]."/".$data[5].$data[6]."/".$data[0].$data[1].$data[2].$data[3];
		else
			return "--/--/--";
	}

	private function construirVetor()
	{
		$posicao = 0;
		$this->nRegistros = 0;

		$conexao = new Conexao("127.0.0.1", "postgres", "123456");

		/* Pré-Autorização */
		$result  = $conexao->query("SELECT diaria_pre_autorizacao_dt,
                                                 diaria_pre_autorizacao_hr,
                                                 pessoa_nm
                                FROM diaria.diaria_pre_autorizacao A
                                JOIN diaria.diaria D
                                        ON A.diaria_id = D.diaria_id
                                JOIN dados_unico.funcionario F
                                        ON diaria_pre_autorizacao_func = F.funcionario_id
                                JOIN dados_unico.pessoa P
                                        ON F.pessoa_id = P.pessoa_id
                         WHERE A.diaria_id = '".$this->id."'
                ");
		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_pre_autorizacao_dt']), "Hora" => $row['diaria_pre_autorizacao_hr'], "Tabela" => "Pré-Autorização"));
			}
		}
		else
			echo "erro na Pr�-Autorizacao";	
		
		/* Autorização */
		$result  = $conexao->query("SELECT diaria_autorizacao_dt,
																			 diaria_autorizacao_hr,
																			 pessoa_nm
																	FROM diaria.diaria_autorizacao A
																	JOIN diaria.diaria D
																		ON A.diaria_id = D.diaria_id
																	JOIN dados_unico.funcionario F
																		ON diaria_autorizacao_func = F.funcionario_id
																	JOIN dados_unico.pessoa P
																		ON F.pessoa_id = P.pessoa_id
																 WHERE A.diaria_id = '".$this->id."'
															");
		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_autorizacao_dt']), "Hora" => $row['diaria_autorizacao_hr'], "Tabela" => "Autorização"));
			}
		}
		else
			echo "erro na Autorizacao";

		/* Aprovação */
		$result  = $conexao->query("SELECT diaria_aprovacao_dt,
																			 diaria_aprovacao_hr,
																			 pessoa_nm
																	FROM diaria.diaria_aprovacao A
																	JOIN diaria.diaria D
																		ON A.diaria_id = D.diaria_id
																	JOIN dados_unico.funcionario F
																		ON diaria_aprovacao_func = F.funcionario_id
																	JOIN dados_unico.pessoa P
																		ON F.pessoa_id = P.pessoa_id
																 WHERE A.diaria_id = '".$this->id."'
 															");

		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_aprovacao_dt']), "Hora" => $row['diaria_aprovacao_hr'], "Tabela" => "Aprovação"));
			}
		}
		else
			echo "erro na Aprovacao";

		$result  = $conexao->query("SELECT diaria_dt_criacao,
																			 diaria_hr_criacao,
																			 pessoa_nm
																	FROM diaria.diaria D
																	JOIN dados_unico.pessoa P
																		ON diaria_solicitante = P.pessoa_id
																 WHERE D.diaria_id = '".$this->id."'
															");
		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_dt_criacao']), "Hora" => $row['diaria_hr_criacao'], "Tabela" => "Solicitação"));
			}
		}
		else
			echo "erro na solicita��o";

		/* Empenho */
		$result  = $conexao->query("SELECT diaria_dt_empenho,
		                                   diaria_hr_empenho,
																			 pessoa_nm
																	FROM diaria.diaria D
																	JOIN dados_unico.pessoa P
																		ON diaria_empenho_pessoa_id = P.pessoa_id
																 WHERE D.diaria_id = '".$this->id."'
															");
		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				if($row['diaria_dt_empenho'] != "" && $row['diaria_dt_empenho'] != " " && $row['diaria_dt_empenho'] != null)
					$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_dt_empenho']), "Hora" => $row['diaria_hr_empenho'], "Tabela" => "Empenho"));
			}
		}
		else
			echo "erro no Empenho";

		/* Pré-Liquidação */
		$result  = $conexao->query("SELECT diaria_preliquidacao_dt,
																			 diaria_preliquidacao_hr,
																			 pessoa_nm
																	FROM diaria.diaria_financeiro A
																	JOIN diaria.diaria D
																		ON A.diaria_id = D.diaria_id
																	JOIN dados_unico.funcionario F
																		ON diaria_financeiro_preliquidante = F.funcionario_id
																	JOIN dados_unico.pessoa P
																		ON F.pessoa_id = P.pessoa_id
																 WHERE A.diaria_id = '".$this->id."'
																");
		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_preliquidacao_dt']), "Hora" => $row['diaria_preliquidacao_hr'], "Tabela" => "Pré-Liquidação"));
			}
		}
		else
			echo "erro na Pr�-Liquida��o";

		/* Liquidação */
		$result  = $conexao->query("SELECT diaria_liquidacao_dt,
                                                     diaria_liquidacao_hr,
                                                     pessoa_nm
                                    FROM diaria.diaria_financeiro A
                                    JOIN diaria.diaria D
                                            ON A.diaria_id = D.diaria_id
                                    JOIN dados_unico.funcionario F
                                            ON diaria_financeiro_liquidante = F.funcionario_id
                                    JOIN dados_unico.pessoa P
                                            ON F.pessoa_id = P.pessoa_id
                             WHERE A.diaria_id = '".$this->id."'
                            ");
		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_liquidacao_dt']), "Hora" => $row['diaria_liquidacao_hr'], "Tabela" => "Liquidação"));
			}
		}
		else
			echo "erro na Liquiada��o";

		/* Execução */
		$result  = $conexao->query("SELECT diaria_execucao_dt,
                                                 diaria_execucao_hr,
                                                 pessoa_nm
                                                    FROM diaria.diaria_financeiro A
                                                    JOIN diaria.diaria D
                                                            ON A.diaria_id = D.diaria_id
                                                    JOIN dados_unico.funcionario F
                                                            ON diaria_financeiro_executante = F.funcionario_id
                                                    JOIN dados_unico.pessoa P
                                                            ON F.pessoa_id = P.pessoa_id
                                             WHERE A.diaria_id = '".$this->id."'
                        ");
		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_execucao_dt']), "Hora" => $row['diaria_execucao_hr'], "Tabela" => "Execução"));
			}
		}
		else
			echo "erro na Execu��o";

		/* Arquivada */
		$result  = $conexao->query("SELECT diaria_arquivada_dt, 
                                       diaria_arquivada_hr,
                                         pessoa_nm
                        FROM diaria.diaria_arquivada A
                        JOIN diaria.diaria D
                                ON A.diaria_id = D.diaria_id
                        JOIN dados_unico.funcionario F
                                ON diaria_arquivada_func = F.funcionario_id
                        JOIN dados_unico.pessoa P
                                ON F.pessoa_id = P.pessoa_id
                 WHERE A.diaria_id = '".$this->id."'
                ");

		if($result)
		{
			while ($row = pg_fetch_assoc($result))
			{
				$this->add(array("Nome" => $row['pessoa_nm'], "Data" => $this->inverteData($row['diaria_arquivada_dt']), "Hora" => $row['diaria_arquivada_hr'], "Tabela" => "Arquivada"));
			}
		}
		else
			echo "erro na 'Arquivada'";




	}
}
?>