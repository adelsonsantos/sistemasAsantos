function VerificaRoteirosAdicionais()
{          
    if($('#controleRoteiro').val() >= 1)
    {        
        var controle = 1;
        while(controle <= parseInt($('#controleRoteiro').val()))
        {                   
            MontarRoteiros(controle);            
            controle ++;
        }
    }
}

function MontarRoteiros(controle)
{
    dados = "controle="+controle+"&valorRef="+$('#ValorRef').html()+"&txtValorRef="+$('#txtValorReferencia').val()+"&codigo="+$('#txtCodigo').val()+"&beneficiario="+$('#cmbBeneficiario').val();                       
    $.ajax
    ({                 
        type: 'POST',
        url : "Ajax/AjaxConsultaRoteiroAdicional.php",
        data: dados,
        success: function(result)
        {   
            $('#roteiroAdicional'+controle).html(result);  
            CalcularTotalDiarias();
        },
        error: function()
        {

        }
    })
}

function CalcularTotalDiarias()
{    
    controle = $('#controleRoteiro').val();        
    valorTotal = 0;
    qtdeTotal  = 0;        
    while(controle >= 0)
    {                             
        if(controle == 0)
        {                                                                                              
            valorDiaria = $('#hdValor').val();                                                             
            qtdeDiaria = $('#hdQtde').val();                
        }
        else 
        {                                          
            valorDiaria = $('#hdValor'+controle).val();                                                     
            qtdeDiaria = $('#hdQtde'+controle).val();                
        }
        qtdeTotal  = parseFloat(qtdeTotal) + parseFloat(qtdeDiaria);
        valorTotal = parseFloat(valorTotal) + parseFloat(valorDiaria);    
        controle = controle - 1;
    }        
    $('#qtdeTotal').html(qtdeTotal);
    $('#totalDiarias').html('R$ '+Math.ceil(valorTotal)+',00'); 
    $('#resultCalculoTotal').show();
}
