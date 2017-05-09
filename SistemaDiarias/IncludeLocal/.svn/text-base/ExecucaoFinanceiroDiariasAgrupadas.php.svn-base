<?php
	
	$sql_SuperSD = "SELECT super_sd FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf 
					WHERE (f.pessoa_id = pf.pessoa_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) 
						  AND diaria_st = 3 AND diaria_devolvida = 0 AND diaria_cancelada = 0 AND super_sd = super_sd AND
						  diaria_agrupada = 1 group by super_sd";
	
	$Consulta_SuperSD = pg_query(abreConexao(),$sql_SuperSD);
					  
	
	 while($tupla=pg_fetch_assoc($Consulta_SuperSD)) {
			
			$Super_SD = $tupla['super_sd']; 
			
			$sql = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p
					WHERE (p.pessoa_id = f.pessoa_id) AND 
					      (d.diaria_beneficiario = f.pessoa_id) AND
						   diaria_st = 3 AND
					       diaria_cancelada = 0 AND
						   super_sd = '$Super_SD' AND
						   diaria_agrupada = 1 Limit 1";			
			$Consulta = pg_query(abreConexao(),$sql);
	    while($tupla=pg_fetch_assoc($Consulta)){		
	
			$Codigo	     	= $tupla['diaria_id'];
			$Numero			= $tupla['diaria_numero'];
			$Nome			= $tupla['pessoa_nm'];
			$Diaria_agrupada = $tupla['diaria_agrupada'];
			$Diaria_Super_SD = $tupla['super_sd'];		
			$DataPartida 	= $tupla['diaria_dt_saida'];
			$HoraPartida 	= $tupla['diaria_hr_saida'];
			$DataChegada 	= $tupla['diaria_dt_chegada'];
			$HoraChegada 	= $tupla['diaria_hr_chegada'];
			$DataCriacao 	= f_FormataData($tupla['diaria_dt_criacao']);
			$Status			 = $tupla['diaria_st'];
	
			echo "<tr height='20' bgcolor='#FFD700' class='GridPaginacaoLink'>";
			/***** Executar todas as diárias de uma vez - Foi feito para não funcionar mesmosó para aparcer o check *****/			
			echo "<td width='100' align='center' ><input type='checkbox' class='checkbox' DISABLED></td>";				
			/***** Fim do Executar todas as diárias de uma vez *****/			
			echo "<td align='center'><a href='SolicitacaoConsultarFinanceiro.php?acao=consultar&cod=".$Codigo."'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";			
			echo "<td align='center'><a href='SolicitacaoExecutar.php?acao=consultar&cod=".$Codigo."'><img src='../Icones/ico_comprovar.png' border='0' alt='Executar'></a></td>";
			//echo "<td align='center'><a href='SolicitacaoDevolver.php?cod=".$Codigo."&pagina=SolicitacaoFinanceiroExecucao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></a></td>";
			echo "<td align='center'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></td>";
			
			if($Diaria_agrupada == 0 ){
				echo "<td align='center'>".$Numero."</td>";
			}else{
				echo "<td align='center'>".$Diaria_Super_SD."</td>";
			}	
			
			echo "<td>&nbsp;".$Nome."</a></td>";
			echo "<td align='center'>".$DataCriacao."</a></td>";
			echo "<td align='center'>".$DataPartida." &agrave;s ".$HoraPartida. "</td>";
			echo "<td align='center'>".$DataChegada." &agrave;s ".$HoraChegada."</td>";
			echo "</tr>";
		}
    }
?>