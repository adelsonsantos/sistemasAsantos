<?
/*
********************************************************** Criada por Danillo 23/08/2010 11:50 ***********************************************************
************************************* Função criada para possibilitar a exclusão de vários registros ao mesmo tempo **************************************
**********************************************************************************************************************************************************

* PARA ESTA FUNÇÃO AGIR CORRETAMENTE TERÁ QUE OLHAR O ARQUIVO XXXINICIO.PHP (EX: VEICULOINICIO.PHP) E VERIFICAR SE O 
JAVASCRIPT ESTA DESTA MANEIRA (COMO DEMOSNTRADO LOGO ABAIXO), CASO NÃO ESTEJA ALTERE-O PARA O BOM FUNCIONAMENTO DA FUNÇÃO.

	function ExcluirForm(frm, checkbox) // FUNÇÃO CRIADA POR GABRIEL E ALTERADA POR DANILLO
	 {	
	 	cont = 0;
		multiplos = "";
		qtdcheckbox = "";
		for (i = 0 ; i < checkbox.length ; i++)
			if (checkbox[i].checked == true)
			{
				multiplos += "&checkbox"+i+"="+checkbox[i].value;
				cont = cont + 1;
			}

		if ((checkbox.checked == false)&&(cont == 0))
		{
			alert("Escolha pelo menos um registro.");
			return false;
		}
		
		qtdcheckbox = "&qtdcheckbox"+"="+checkbox.length;
		
		frm.action="VeiculoExcluir.php?excluirMultiplo=1"+multiplos+qtdcheckbox; 
		
		frm.submit();

		//VERIFIQUE SEMPRE ESSA LINHA, POIS PODE ESTA ENCAMINHANDO A SOLICITAÇÃO PARA A PÁGINA ERRADA COMO POR EXEMPLO 
		//frm.action="VeiculoExcluir.php?excluirMultiplo=1"+multiplos+qtdcheckbox; E ERA
		//frm.action="TipoVeiculoExcluir.php?excluirMultiplo=1"+multiplos+qtdcheckbox;
	 }
	 
**********************************************************************************************************************************************************

* NA CLASSEXXX (EX: CLASSEVEICULO.PHP) NA AÇÃO "EXCLUIR" VERIFIQUE A CONSULTA SQL PARA QUE A MESMA RECEBA A VARIAVEL DA SESSION. ANTES DO TERMINO
DA AÇÃO EXCLUIR DA CLASSEVEICULO APÓS A ALTERAÇÃO DO STATUS ESTOU REALIZANDO UM UNSET NA SESSION PARA GARANTIR QUE NÃO HAVERÁ INTERFERENCIA POSTERIORES.
    
	If ($ExcluirCheckbox == 1){   
	
		$sqlDeleta = "UPDATE transporte.veiculo SET veiculo_st = 2 WHERE veiculo_id IN (".$_SESSION['excluirMultiplosCod'].")";
		
		
		unset ($_SESSION['excluirMultiplosCod']);

**********************************************************************************************************************************************************

* NA AÇÃO DA PAGINA XXXEXCLUIR (EX: VEICULOEXCLUIR.PHP) VOCÊ DEVERÁ ALTERAR NA PARTE QUE FAZ A VERIFICAÇÃO DE EXCLUSÃO COM CHECKBOX E COLOCAR O INCLUDE E A CHAMADA A FUNÇÃO DENTRO DO IF QUE VERIFICA A EXCLUSÃO A PARTIR DE VÁRIOS CHECKBOX SELECIONADOS E TAMBÉM TERÁ QUE PASSAR O ARRAY PARA A PESQUISA DENTRO DO IN DO SELECTE DO SQL.

            <?include "../Include/Inc_Excluir_Multiplo.php"?> 

			If ($ExcluirCheckbox == 1){ 

				f_ExclusaoMultipla ();

				$sqlConsulta = "SELECT * FROM transporte.veiculo,transporte.tipo_veiculo where (veiculo.tipo_veiculo_id = tipo_veiculo.tipo_veiculo_id ) and veiculo_id IN (".$_SESSION['excluirMultiplosCod'].")"; 
				
**********************************************************************************************************************************************************

*/
function f_ExclusaoMultipla (){
$CodigosArray = "'";	
	$i=0;
	while($i < $_GET["qtdcheckbox"]){
       if (isset($_GET["checkbox".$i])) // VERIFICA SE O CHECKBOX ESTA MARCADO
		{
			$CodigosArray = $CodigosArray . $_GET["checkbox".$i] . "','"; // alterado por Danillo criando a condição IN
		}
		$i++;
	}
	$CodigosArray = substr($CodigosArray, 0, (strlen($CodigosArray)-2)); // alterado por Danillo
	$_SESSION['excluirMultiplosCod'] = $CodigosArray; //Passando o array por session para realização do UPDATE

}
?>
