<?php
	$sqlConsulta = "SELECT projeto_cd, 
	                       projeto_saldo, 
									       projeto_ds, 
									       projeto_st, 
									       projeto_dt_criacao, 
												 projeto_dt_alteracao, 
												 ger_id 
										FROM diaria.projeto 
									 WHERE projeto_st = 0 
								ORDER BY projeto_cd";
	$rsConsulta = pg_query(abreConexao(), $sqlConsulta);
?>