<?php
// separa as datas em dia,mes e ano
function calculaIntervalo($data_1,$data_2){
	/*$data_1 = "21/03/2011";
	$data_2 = "27/04/2011";
*/
	list($dia_ini,$mes_ini,$ano_ini) = explode("/",$data_1);
	list($dia_fim,$mes_fim,$ano_fim) = explode("/",$data_2);

	$dini = mktime(0,0,0,$mes_ini,$dia_ini,$ano_ini); // timestamp da data inicial
	$dfim = mktime(0,0,0,$mes_fim,$dia_fim,$ano_fim); // timestamp da data final
	
	//Array dos dias que o solicitante já viajou
	$dias = array();
	
 if($dini > $dfim) {				
	while($dini >= $dfim){//enquanto uma data for inferior a outra {   
		$dt = date("d/m/Y",$dini);//convertendo a data no formato dia/mes/ano			
		array_push($dias,$dt);		
		$dini -= 86400; // adicionando mais 1 dia (em segundos) na data inicial					
	}	
}else{
	while($dini <= $dfim){//enquanto uma data for inferior a outra {      
		$dt = date("d/m/Y",$dini);//convertendo a data no formato dia/mes/ano
		array_push($dias,$dt);	
		$dini += 86400; // adicionando mais 1 dia (em segundos) na data inicial
	}
} 	
	return $dias;
}
	
	/*	
	$data1 = "21/03/2011";
	$data2 = "27/04/2011";	
	
	print_r(calculaIntervalo($data1,$data2));	
	//echo "a: ".array_search("a",$a)."<br>";
	
	/*for($n = 0 ;$n < count($dias);$n++){
	
		echo $dias[$n]."<br>";
	
	}	
	*/
?>