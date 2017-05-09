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



	if (frm.txtNome.value == "")
	{
		alert("Campo NOME em Branco.");
		document.getElementById("formaba1").style.display = '';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("aba1_on").style.display = '';		
		document.getElementById("aba1_off").style.display = 'none';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		frm.txtNome.focus();
		frm.txtNome.style.backgroundColor='#B9DCFF';
		return false;
	}		
	
	if (frm.txtDtNasc.value == "")
	{
		alert("Campo DATA DE NASCIMENTO em Branco.");
		document.getElementById("formaba1").style.display = '';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("aba1_on").style.display = '';		
		document.getElementById("aba1_off").style.display = 'none';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		frm.txtDtNasc.focus();
		frm.txtDtNasc.style.backgroundColor='#B9DCFF';
		return false;
	}	
	
	if (frm.txtRG.value == "")
	{
		alert("Campo RG em Branco.");
		document.getElementById("formaba1").style.display = '';
		document.getElementById("formaba2").style.display = 'none';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("aba1_on").style.display = '';		
		document.getElementById("aba1_off").style.display = 'none';	
		document.getElementById("aba2_on").style.display = 'none';		
		document.getElementById("aba2_off").style.display = '';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		frm.txtRG.focus();
		frm.txtRG.style.backgroundColor='#B9DCFF';
		return false;
	}
	// TIVE QUE RETIRAR O COMENTARIO PARA CADASTRO DE PESSOA FISICA NO CADASTRO UNICO.. 23/09/2010.
	if (frm.txtEnderecoBairro.value == "")
	{
		alert("Campo BAIRRO em Branco.");
		document.getElementById("formaba1").style.display = 'none';
		document.getElementById("formaba2").style.display = '';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("aba1_on").style.display = 'none';		
		document.getElementById("aba1_off").style.display = '';	
		document.getElementById("aba2_on").style.display = '';		
		document.getElementById("aba2_off").style.display = 'none';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		frm.txtEnderecoBairro.focus();
		frm.txtEnderecoBairro.style.backgroundColor='#B9DCFF';
		return false;
	}

    if (frm.txtEndereco.value == "")
	{
		alert("Campo ENDERECO em Branco.");
		document.getElementById("formaba1").style.display = 'none';
		document.getElementById("formaba2").style.display = '';
		document.getElementById("formaba3").style.display = 'none';	
		document.getElementById("aba1_on").style.display = 'none';		
		document.getElementById("aba1_off").style.display = '';	
		document.getElementById("aba2_on").style.display = '';		
		document.getElementById("aba2_off").style.display = 'none';	
		document.getElementById("aba3_on").style.display = 'none';		
		document.getElementById("aba3_off").style.display = '';	
		frm.txtEndereco.focus();
		frm.txtEndereco.style.backgroundColor='#B9DCFF';
		return false;
	}		

										
	if (frm.txtCodigo.value == "")
	{
		frm.action = "FisicaCadastrar.php?acao=incluir";
	}
	else
	{
		frm.action = "FisicaCadastrar.php?acao=alterar";
	}

	frm.submit();
}