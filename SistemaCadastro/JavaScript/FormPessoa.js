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
        document.getElementById("formaba4").style.display = 'none';
        document.getElementById("aba1_on").style.display = '';		
        document.getElementById("aba1_off").style.display = 'none';	
        document.getElementById("aba2_on").style.display = 'none';		
        document.getElementById("aba2_off").style.display = '';	
        document.getElementById("aba3_on").style.display = 'none';		
        document.getElementById("aba3_off").style.display = '';	
        document.getElementById("aba4_on").style.display = 'none';		
        document.getElementById("aba4_off").style.display = '';			
        frm.txtCPF.focus();
        frm.txtCPF.style.backgroundColor='#B9DCFF';
        return false;
    }
    else
        if (Verifica_CPF(document.Form) == false)
        {
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

    if (frm.txtEnderecoBairro.value == "")
    {
        alert("Campo BAIRRO em Branco.");
        document.getElementById("formaba1").style.display = 'none';
        document.getElementById("formaba2").style.display = '';
        document.getElementById("formaba3").style.display = 'none';	
        document.getElementById("formaba4").style.display = 'none';	
        document.getElementById("aba1_on").style.display = 'none';		
        document.getElementById("aba1_off").style.display = '';	
        document.getElementById("aba2_on").style.display = '';		
        document.getElementById("aba2_off").style.display = 'none';	
        document.getElementById("aba3_on").style.display = 'none';		
        document.getElementById("aba3_off").style.display = '';	
        document.getElementById("aba4_on").style.display = 'none';		
        document.getElementById("aba4_off").style.display = '';			
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
        document.getElementById("formaba4").style.display = 'none';	
        document.getElementById("aba1_on").style.display = 'none';		
        document.getElementById("aba1_off").style.display = '';	
        document.getElementById("aba2_on").style.display = '';		
        document.getElementById("aba2_off").style.display = 'none';	
        document.getElementById("aba3_on").style.display = 'none';		
        document.getElementById("aba3_off").style.display = '';	
        document.getElementById("aba4_on").style.display = 'none';		
        document.getElementById("aba4_off").style.display = '';			
        frm.txtEndereco.focus();
        frm.txtEndereco.style.backgroundColor='#B9DCFF';
        return false;
    }		

    if (frm.cmbFuncionarioTipo.value == "0")
    {
        alert("Campo TIPO DO FUNCIONARIO em Branco.");
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
        frm.cmbFuncionarioTipo.focus();
        frm.cmbFuncionarioTipo.style.backgroundColor='#B9DCFF';
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

    if (frm.cmbEstruturaAtuacao.value == "0")
    {
        alert("Campo ESTRUTURA ORGANIZACIONAL ATUAÇÃO em Branco.");
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
        frm.cmbEstruturaAtuacao.focus();
        frm.cmbEstruturaAtuacao.style.backgroundColor='#B9DCFF';
        return false;
    }

    if (frm.cmbBanco.value != "0")
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

    if (frm.txtFuncionarioEmail.value != "")
    {
        if (frm.txtFuncionarioEmail.value.indexOf('@')==-1 || frm.txtFuncionarioEmail.value.indexOf('.')==-1 ) 
        {
            alert("E-MAIL inserido invalido.");
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
            frm.txtFuncionarioEmail.focus();
            frm.txtFuncionarioEmail.style.backgroundColor='#B9DCFF';
            return false;
        }				
    }	

    if (frm.txtCodigo.value == "")
        frm.action = "FuncionarioCadastrar.php?acao=incluir";
    else
        frm.action = "FuncionarioCadastrar.php?acao=alterar";

    frm.submit();
}