<?php	
	include "conecta.php";
	
	$sql = "Select diaria_id,diaria_dt_saida, diaria_dt_chegada from diaria.diaria";
	$consulta = executar_SQL($sql);		
	
	$cont = 0;
	while($tupla = retorna_linha($consulta)){

		$dt_saida = $tupla['diaria_dt_saida'];	
		$dt_chegada = $tupla['diaria_dt_chegada'];	
		$diaria_id = $tupla['diaria_id'];	
				
		$sqlAltera = "UPDATE diaria.diaria
						SET data_viagem_saida='$dt_saida', data_viagem_chegada='$dt_chegada' where diaria_id = $diaria_id AND diaria_excluida = 0";		
				
		$altera = executar_SQL($sqlAltera);	
		$cont++;
    }
	echo "Sucesso!!!";
	echo "<br>";;
	echo $cont;
?>

