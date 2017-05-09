function AdicionaSaldoMes()
{  
    if($('#cmbFonte').val() == '0')
    {
        alert('Informe a Fonte!');
        $('#cmbFonte').focus();  
        return false;
    }
    
    if($('#cmbMes').val() == 0)
    {
        alert('Informe o mês!');
        $('#cmbMes').focus();
        return false;
    }
    
    if($('#txtSaldo').val() == '')
    {
        alert('Informe o Saldo!');
        $('#txtSaldo').focus();
        return false;
    }
    
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxListaSaldoMes.php",
        data: "acao=adicionar&fonteId="+$('#cmbFonte').val()+"&mesId="+$('#cmbMes').val()+"&mesVal="+$('#cmbMes :selected').text()+"&saldoVal="+$('#txtSaldo').val(),        
        success: function(result)
        {   
            arrResult = result.split('||');
            
            $('#listaSaldoMes').html(arrResult[0]);
            
            if(arrResult[1] == 12)
            {
                $('#btnAdicionar').attr('disabled',true);
            }
            
            if($('#cmbMes').val() < 12)
            {
                var valor = parseInt($('#cmbMes').val());
                valor = valor + parseInt(1);
                $('#cmbMes').attr({value : valor});
            }
            else if($('#cmbMes').val() == 12)
            {                
                $('#cmbMes').attr({value : '1'});
            }
        },
        error: function()
        {
            alert('erro');
        }
    })
}

function carregaSaldo()
{    
    if($('#txtAcao').val() == 'consultar')
    {       
        $.ajax
        ({
            type: 'POST',
            url : "Ajax/AjaxListaSaldoMes.php",
            data: "acao=consultar&projetoId="+$('#cmbProjeto').val()+"&fonteId="+$('#cmbFonte').val(),        
            success: function(result)
            {   
                $('#listaSaldoMes').html(result);
            },
            error: function()
            {

            }
        })
    }
}

function repassaSaldo(dia,mes,ano)
{            
    if(dia == 1)
    {
        $.ajax
        ({
            type: 'POST',
            url : "Ajax/AjaxAtualizaSaldoMes.php",
            data: "mes="+mes+"&dia="+dia+"&ano="+ano,
            success: function(result)
            { 

            },
            error: function()
            {

            }
        }) 
    }                      
}

function LimpaDados()
{        
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxListaSaldoMes.php",
        data: "acao=limpar",        
        success: function()
        {
            $('#listaSaldoMes').html('');
            $('#listaSaldoMesEditar').html('');
            $('#cmbMes').attr({value : '0'});
            $('#txtSaldo').attr({value : ''});
            $('#btnAdicionar').attr('disabled',false);
        },
        error: function()
        {
            alert('erro');
        }
    })
}

function HabilitarDados()
{    
    if($('#cmbProjeto').val() != '0')
    {
        $('#cmbFonte').attr('disabled',false);
        $('#cmbMes').attr('disabled',false);
        $('#txtSaldo').attr('disabled',false);
        $('#btnAdicionar').attr('disabled',false);
        $('#btnLimparSaldo').attr('disabled',false);                 
    }
    
    if($('#numRegistros').val() == '12')
    {
        $('#btnAdicionar').attr('disabled',true);
    }
}

function frm_number_only_exc()
{
    // allowed: numeric keys, numeric numpad keys, backspace, del and delete keys
    if( event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || ( event.keyCode < 106 && event.keyCode > 95 ) ) 
    { 
        return true;
    }
    else
    {
        return false;
    }
}

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e)
{  
    var sep = 0;  
    var key = '';  
    var i = j = 0;  
    var len = len2 = 0;  
    var strCheck = '0123456789';  
    var aux = aux2 = '';  
    //var whichCode = (window.Event) ? e.which : e.keyCode;  
    
    if (event.keyCode == 13) return true;  
    key = String.fromCharCode(event.keyCode); // Valor para o código da Chave  
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida  
    len = objTextBox.value.length;  
    for(i = 0; i < len; i++)  
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;  
    aux = '';  
    for(; i < len; i++)  
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);  
    aux += key;  
    len = aux.length;  
    if (len == 0) objTextBox.value = '';  
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;  
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;  
    if (len > 2) {  
        aux2 = '';  
        for (j = 0, i = len - 3; i >= 0; i--) {  
            if (j == 3) {  
                aux2 += SeparadorMilesimo;  
                j = 0;  
            }  
            aux2 += aux.charAt(i);  
            j++;  
        }  
        objTextBox.value = '';  
        len2 = aux2.length;  
        for (i = len2 - 1; i >= 0; i--)  
        objTextBox.value += aux2.charAt(i);  
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);  
    }  
    return false;  
}

function filtraCampo(campo)
{
 var s = "";
 var cp = "";
 vr = campo.value;
 tam = vr.length;
 for (i = 0; i < tam; i++)
 {
  if (vr.substring(i, i + 1) != "/"
        && vr.substring(i, i + 1) != "-"
        && vr.substring(i, i + 1) != "."
        && vr.substring(i, i + 1) != "("
        && vr.substring(i, i + 1) != ")"
        && vr.substring(i, i + 1) != ":"
        && vr.substring(i, i + 1) != ",")
  {
   s = s + vr.substring(i, i + 1);
  }
 }
 return s;
}

function MascaraSaldo()
{        
    var texto = '0123456789';    
    
    $(document).ready(function()
    {
        $("input.apenasNum").keydown(function(event) 
        { 
            if ( frm_number_only_exc() ) 
            {             

            } 
            else 
            { 
                if ( event.keyCode < 48 || event.keyCode > 57 ) 
                { 
                    event.preventDefault();
                }        
            } 
        }); 

    });
    
//    $("#txtSaldo").keypress(function(e)
//    {
//        e.preventDefault();        
//        digito = String.fromCharCode(e.which);  
//    })   
//    
//    for(var i=0; i < texto.length; i++)
//    {              
//        if(digito == texto.charAt(i))
//        {
//            if($('#txtSaldo').val() == '')
//            {
//                $('#txtSaldo').val() = String.fromCharCode(e.which);
//            }
//            else
//            {
//                $('#txtSaldo').val() = $('#txtSaldo').val()+digito;
//            }
//        }
//    }      
}

function Valor(v)
{
    v = v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v = v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
    v = v.replace(/(\d)(\d{2})$/,"$1.$2"); //Coloca ponto antes dos 2 últimos digitos
    
    return v;
}        

function Area(v)
{
    v=v.replace(/\D/g,""); 
    v=v.replace(/(\d)(\d{2})$/,"$1.$2");
    
    return v;
}

function GravarForm(frm)
{            
    if($('#btnGravar').val() == 'Gravar')
    {
        acao = 'incluir';
    }
    else if($('#btnGravar').val() == 'Editar')
    {
        acao = 'alterar';
    }
    else if($('#btnGravar').val() == 'Excluir')
    {
        acao = 'excluir';
    }
    
    frm.action = "CadastroSaldoRecursoInicio.php?acao="+acao;
    frm.submit();
}