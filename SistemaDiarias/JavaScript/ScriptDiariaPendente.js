function GerarRelatorio()
{
    $('#diariaPendente').html('');

    if(($('#saldoNegativo').is(':checked') == false)&&($('#saldoPositivo').is(':checked') == false))
    {
        alert('Favor informe o tipo do relatório!');
    }
    else if(($('#dataInicio').val() == '')||($('#dataFim').val() == ''))
    {
        alert('Favor informe o período!');
    }
    else
    {
        $.ajax
        ({
            type: 'POST',
            url : "Ajax/AjaxDiariaPendente.php",
            data: "beneficiario="+$('#cmbBeneficiario').val()+"&tipoPositivo="+$('#saldoPositivo').is(':checked')+"&tipoNegativo="+$('#saldoNegativo').is(':checked')+"&dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val(),
            success: function(result)
            {    
                $('#diariaPendente').html(result);
            },
            error: function()
            {

            }
        })
    }                                
}

function BloqueiaPessoa(codigoPessoa)
{
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxBloqueio.php",
        data: "pessoa_id="+codigoPessoa,
        success: function(result)
        {   
            alert(result); return false;            
        },
        error: function()
        {

        }
    })
}