function GravarForm(frm)
{

	for(cont=0; cont < frm.elements.length; cont++)
		frm.elements[cont].style.backgroundColor = '';	

	if (frm.txtCPF.value == "")
	{
		alert("Campo CPF em Branco.");
		document.getElementById("formaba1").style.display = '';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("aba1_on").style.display = '';		
		document.getElementById("aba1_off").style.display = 'none';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		frm.txtCPF.focus();
		frm.txtCPF.style.backgroundColor='#B9DCFF';
		return false;
	}
	else
		if (Verifica_CPF(document.Form) == false){
		return false;
	}


	if (frm.txtDtNasc.value == "")
	{
		alert("Campo DATA DE NASCIMENTO em Branco.");
		document.getElementById("formaba1").style.display = '';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("formaba4").style.display = 'none';		
		document.getElementById("aba1_on").style.display = '';		
		document.getElementById("aba1_off").style.display = 'none';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		document.getElementById("aba4_on").style.display = 'none';		
		document.getElementById("aba4_off").style.display = '';			
		frm.txtDtNasc.focus();
		frm.txtDtNasc.style.backgroundColor='#B9DCFF';
		return false;
	}	

	if (frm.txtNome.value == "")
	{
		alert("Campo NOME em Branco.");
		document.getElementById("formaba1").style.display = '';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("formaba4").style.display = 'none';	
		document.getElementById("aba1_on").style.display = '';		
		document.getElementById("aba1_off").style.display = 'none';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		document.getElementById("aba4_on").style.display = 'none';		
		document.getElementById("aba4_off").style.display = '';			
		frm.txtNome.focus();
		frm.txtNome.style.backgroundColor='#B9DCFF';
		return false;
	}		
	

	
	if (frm.txtRG.value == "")
	{
		alert("Campo RG em Branco.");
		document.getElementById("formaba1").style.display = '';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("formaba4").style.display = 'none';	
		document.getElementById("aba1_on").style.display = '';		
		document.getElementById("aba1_off").style.display = 'none';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		document.getElementById("aba4_on").style.display = 'none';		
		document.getElementById("aba4_off").style.display = '';			
		frm.txtRG.focus();
		frm.txtRG.style.backgroundColor='#B9DCFF';
		return false;
	}

	if (frm.txtMatricula.value == "")
	{
		alert("Campo MATRICULA em Branco.");
		document.getElementById("formaba1").style.display = 'none';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("formaba4").style.display = '';	
		document.getElementById("aba1_on").style.display = 'none';		
		document.getElementById("aba1_off").style.display = '';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		document.getElementById("aba4_on").style.display = '';		
		document.getElementById("aba4_off").style.display = 'none';			
		frm.txtMatricula.focus();
		frm.txtMatricula.style.backgroundColor='#B9DCFF';
		return false;
	}	
		
	if (frm.txtDtAdmissao.value == "")
	{
		alert("Campo DATA DA ADMISSAO em Branco.");
		document.getElementById("formaba1").style.display = 'none';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("formaba4").style.display = '';		
		document.getElementById("aba1_on").style.display = 'none';		
		document.getElementById("aba1_off").style.display = '';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		document.getElementById("aba4_on").style.display = '';		
		document.getElementById("aba4_off").style.display = 'none';			
		frm.txtDtAdmissao.focus();
		frm.txtDtAdmissao.style.backgroundColor='#B9DCFF';
		return false;
	}				

	if (frm.cmbUnidadeFuncional.value == "0")
	{
		alert("Campo UNIDADE DE LOTACAO em Branco.");
		document.getElementById("formaba1").style.display = 'none';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("formaba4").style.display = '';		
		document.getElementById("aba1_on").style.display = 'none';		
		document.getElementById("aba1_off").style.display = '';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		document.getElementById("aba4_on").style.display = '';		
		document.getElementById("aba4_off").style.display = 'none';			
		frm.cmbUnidadeFuncional.focus();
		frm.cmbUnidadeFuncional.style.backgroundColor='#B9DCFF';
		return false;
	}

	
	if (frm.cmbLotacao.value == "0")
	{
		alert("Campo LOCAL DE TRABALHO em Branco.");
		document.getElementById("formaba1").style.display = 'none';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("formaba4").style.display = '';		
		document.getElementById("aba1_on").style.display = 'none';		
		document.getElementById("aba1_off").style.display = '';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		document.getElementById("aba4_on").style.display = '';		
		document.getElementById("aba4_off").style.display = 'none';			
		frm.cmbLotacao.focus();
		frm.cmbLotacao.style.backgroundColor='#B9DCFF';
		return false;
	}
	
	if (frm.cmbOrgaoOrigem.value == "0")
	{	
		if (frm.cmbContrato.value == "0")
		{
			alert("Campo CONTRATO em Branco.");
			document.getElementById("formaba1").style.display = 'none';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';	
			document.getElementById("formaba4").style.display = '';		
			document.getElementById("aba1_on").style.display = 'none';		
			document.getElementById("aba1_off").style.display = '';	
			document.getElementById("aba2_on").style.display = 'none';		
			document.getElementById("aba2_off").style.display = '';	
			document.getElementById("aba3_on").style.display = 'none';		
			document.getElementById("aba3_off").style.display = '';	
			document.getElementById("aba4_on").style.display = '';		
			document.getElementById("aba4_off").style.display = 'none';			
			frm.cmbContrato.focus();
			frm.cmbContrato.style.backgroundColor='#B9DCFF';
			return false;
		}
		if (frm.cmbFuncao.value == "0")
		{
			alert("Campo FUNÇÃO em Branco.");
			document.getElementById("formaba1").style.display = 'none';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';	
			document.getElementById("formaba4").style.display = '';		
			document.getElementById("aba1_on").style.display = 'none';		
			document.getElementById("aba1_off").style.display = '';	
			document.getElementById("aba2_on").style.display = 'none';		
			document.getElementById("aba2_off").style.display = '';	
			document.getElementById("aba3_on").style.display = 'none';		
			document.getElementById("aba3_off").style.display = '';	
			document.getElementById("aba4_on").style.display = '';		
			document.getElementById("aba4_off").style.display = 'none';			
			frm.cmbFuncao.focus();
			frm.cmbFuncao.style.backgroundColor='#B9DCFF';
			return false;
		}

	}
	
	if (frm.cmbBanco.value == "2")
	{
		if (frm.txtAgencia.value == "")
		{
			alert("Campo AGENCIA em Branco.");
			document.getElementById("formaba1").style.display = 'none';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';	
			document.getElementById("formaba4").style.display = '';	
			document.getElementById("aba1_on").style.display = 'none';		
			document.getElementById("aba1_off").style.display = '';	
			document.getElementById("aba2_on").style.display = 'none';		
			document.getElementById("aba2_off").style.display = '';	
			document.getElementById("aba3_on").style.display = 'none';		
			document.getElementById("aba3_off").style.display = '';	
			document.getElementById("aba4_on").style.display = '';		
			document.getElementById("aba4_off").style.display = 'none';				
			frm.txtAgencia.focus();
			frm.txtAgencia.style.backgroundColor='#B9DCFF';
			return false;
		}			
		
		if (frm.txtConta.value == "")
		{
			alert("Campo CONTA em Branco.");
			document.getElementById("formaba1").style.display = 'none';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';	
			document.getElementById("formaba4").style.display = '';		
			document.getElementById("aba1_on").style.display = 'none';		
			document.getElementById("aba1_off").style.display = '';	
			document.getElementById("aba2_on").style.display = 'none';		
			document.getElementById("aba2_off").style.display = '';	
			document.getElementById("aba3_on").style.display = 'none';		
			document.getElementById("aba3_off").style.display = '';	
			document.getElementById("aba4_on").style.display = '';		
			document.getElementById("aba4_off").style.display = 'none';				
			frm.txtConta.focus();
			frm.txtConta.style.backgroundColor='#B9DCFF';
			return false;
		}	
	}
			
											
	if (frm.txtCodigo.value == "")
		frm.action = "TerceirizadoCadastrar.php?acao=incluir";
	else
		frm.action = "TerceirizadoCadastrar.php?acao=alterar";

	frm.submit();
	
}