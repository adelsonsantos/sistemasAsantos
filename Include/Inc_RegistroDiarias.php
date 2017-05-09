<?php

	$sql1 = "SELECT diaria_comprovada,diaria_devolvida FROM diaria.diaria d WHERE d.diaria_id = " .$Codigo;
	$rs1 = pg_query(abreConexao(),$sql1);
	$linha=pg_fetch_assoc($rs1);
	$DiariaComprovada =$linha['diaria_comprovada'];
	$DiariaDevolvida = $linha['diaria_devolvida'];
	echo "<td width='20' align='center'>";

//************* Botão Consultar *************//
	if($_SESSION['BotaoConsultar'] == false)
        {
            echo "<img src='../Icones/ico_consultar_off.png' alt='Consultar' border='0'>";
	}
        else{
            if(($Status > 5)&&($Status<10))
            {
                echo "<a href=ComprovacaoConsultar.php?cod=".$CodigoRegistro."&acao=consultar&pagina=Solicitacao><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'></a>";
            }else
            {
                if ($_SESSION['BotaoConsultar']!= 0){
                        echo "<a href=".$PaginaLocal."Consultar.php?cod=".$CodigoRegistro."&acao=consultar><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'></a>";
                }
            }
	}
	echo "</td>";
	echo "<td width='20' align='center'>";

//************* Botão Editar só aparece antes da diaria ser aprovada *************//
	if ($Status != 0){
		echo "<img src='../Icones/ico_alterar_off.png' alt='Editar' border='0'>";
	}else{
		echo "<a href=".$PaginaLocal."Cadastrar.php?cod=".$CodigoRegistro."&acao=consultar><img src='../Icones/ico_alterar.png' alt='Editar' border='0'></a>";
	}
	echo "</td>";
	echo "<td width='20' align='center'>";

//Botao Excluir so aparece antes da diaria ser autorizada
	if ($Status >= 2){
		echo "<img src='../Icones/ico_excluir_off.png' alt='Excluir' border='0'>";
	}else{
		if ($DiariaComprovada == "1"){
			echo "<img src='../Icones/ico_excluir_off.png' alt='Excluir' border='0'>";
		}else{
			echo "<a href=".$PaginaLocal."Excluir.php?cod=".$CodigoRegistro. "&acao=consultar><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'></a>";
		}
	}
	echo "</td>";
	echo "<td width='20' align='center'>";

//************** Botao comprovar fica desabilitado ate chegar no status comprovacao ********************//
	if ($Status < 3 || $Status == 100){
		echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
	}else{ // Botão ativado para comprovar 
		if($Status >= 4){
			if($DiariaComprovada =="0"){   // Se for o beneficiario logado, permitir a comprovacao
				if ($Beneficiario == $_SESSION['UsuarioCodigo']){
					echo "<a href='SolicitacaoComprovar.php?cod=".$CodigoRegistro."&acao=consultar'><img src='../Icones/ico_comprovar.png'  alt='Comprovar' border='0'></a>";
				}else{
					echo  "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
				}
			}else{
				if($DiariaDevolvida == "1"){   //se for o beneficiario logado, permitir a comprovacao
					if ($Beneficiario == $_SESSION['UsuarioCodigo']){
						echo "<a href='SolicitacaoComprovar.php?cod=".$CodigoRegistro."&acao=consultar'><img src='../Icones/ico_comprovar.png'  alt='Comprovar' border='0'></a>";
					}else{
						echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
					}
				}else{
					echo "<img src='../Icones/ico_comprovar_off.png' alt='Comprovar' border='0'>";
				}
			}
		}
	}
	echo "</td>";
	echo "<td width='20' align='center'>";

//******************** Habilita os Botões de Impressão com o Fluxo Normal do Sistema *************************// 
	if (($Status >= 4)&& ($Status <=8)){
		if ($DiariaComprovada == "1"){
			$sqlGer = "SELECT diaria_comprovacao_saldo_tipo FROM diaria.diaria_comprovacao WHERE diaria_id = ".$Codigo;
			$rsGer = pg_query(abreConexao(),$sqlGer);
			$linha=pg_fetch_assoc($rsGer);
			if($linha){
				if($linha['diaria_comprovacao_saldo_tipo']=="D"){
					if($DiariaDevolvida == "0"){
						echo "<a href='javascript:ImprimirDiariaGER(" .$CodigoRegistro. ");'><img src='../Icones/ico_imprimir_ger.png' alt='Imprimir GER' border='0'></a>";
					}else{
						echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>"	;
					}
				}else{
					echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>";
				}
			}
		}else{
			echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>";
		}
	}else{
		echo "<img src='../Icones/ico_imprimir_ger_off.png' alt='Imprimir GER' border='0'>";
	}

	if(($DiariaComprovada == "1")&&($Status <= 8)){
		echo "<td align='center'><a href='javascript:ImprimirDiaria(" .$Codigo.");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Comprova&ccedil;&atilde;o'></a></td>"	;
	}else{
		echo "<td>";
		echo "<img src='../Icones/ico_imprimir_off.png' alt='Imprimir Comprovação ' border='0'>";
		echo "</td>";
	}
?>
