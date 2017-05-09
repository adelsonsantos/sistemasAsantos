function GravarForm(frm)
{

	for(cont=0; cont < frm.elements.length; cont++)
		frm.elements[cont].style.backgroundColor = '';	

	if (frm.txtCPF.value == "")
	{
		alert("Campo CPF em Branco.");
		frm.txtCPF.focus();
		frm.txtCPF.style.backgroundColor='#B9DCFF';
		return false;
	}
	
	if (frm.txtDtNasc.value == "")
	{
		alert("Campo DATA DE NASCIMENTO em Branco.");
		
		frm.txtDtNasc.focus();
		frm.txtDtNasc.style.backgroundColor='#B9DCFF';
		return false;
	}	
	
	
	if (frm.txtNome.value == "")
	{
		alert("Campo NOME em Branco.");
		
		frm.txtNome.focus();
		frm.txtNome.style.backgroundColor='#B9DCFF';
		return false;
	}		
	

	if (frm.txtRG.value == "")
	{
		alert("Campo RG em Branco.");
			
		frm.txtRG.focus();
		frm.txtRG.style.backgroundColor='#B9DCFF';
		return false;
	}
	
	if (frm.txtEnderecoBairro.value == "")
	{
		alert("Campo BAIRRO em Branco.");
		
		frm.txtEnderecoBairro.focus();
		frm.txtEnderecoBairro.style.backgroundColor='#B9DCFF';
		return false;
	}

    if (frm.txtEndereco.value == "")
	{
		alert("Campo ENDERECO em Branco.");
	
		frm.txtEndereco.focus();
		frm.txtEndereco.style.backgroundColor='#B9DCFF';
		return false;
	}		


	if (frm.txtMatricula.value == "")
	{
		alert("Campo MATRICULA em Branco.");
		
		frm.txtMatricula.focus();
		frm.txtMatricula.style.backgroundColor='#B9DCFF';
		return false;
	}	
		
	if (frm.txtDtAdmissao.value == "")
	{
		alert("Campo DATA DA ADMISSAO em Branco.");
		
		frm.txtDtAdmissao.focus();
		frm.txtDtAdmissao.style.backgroundColor='#B9DCFF';
		return false;
	}				

	
	if (frm.cmbBanco.value != "0")
	{
		if (frm.txtAgencia.value == "")
		{
			alert("Campo AGENCIA em Branco.");
			
			frm.txtAgencia.focus();
			frm.txtAgencia.style.backgroundColor='#B9DCFF';
			return false;
		}			
		
		if (frm.txtConta.value == "")
		{
			alert("Campo CONTA em Branco.");
			
			frm.txtConta.focus();
			frm.txtConta.style.backgroundColor='#B9DCFF';
			return false;
		}	
	}
	
	if (frm.txtFuncionarioEmail.value != "")
	{
		if (frm.txtFuncionarioEmail.value.indexOf('@')==-1 || frm.txtFuncionarioEmail.value.indexOf('.')==-1 ) 
		{
			alert("E-MAIL inserido invalido.");
		
			frm.txtFuncionarioEmail.focus();
			frm.txtFuncionarioEmail.style.backgroundColor='#B9DCFF';
			return false;
		}				
	}	
			
	frm.action = "ValidacaoFuncionario.php?acao=alterar";
	frm.submit();
}