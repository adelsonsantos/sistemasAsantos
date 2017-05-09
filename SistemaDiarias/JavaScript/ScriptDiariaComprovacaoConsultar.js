function VerificaRoteirosAdicionais()
{        
    if($('#controleRoteiro').val() >= 1)
    {        
        var controle = 1;
        while(controle < parseInt($('#controleRoteiro').val()))
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
        url : "Ajax/AjaxConsultaRoteiroAdicionalComprovacao.php",
        data: dados,
        success: function(result)
        {   
            $('#roteiroAdicional'+controle).html(result);              
        },
        error: function()
        {

        }
    })
}
