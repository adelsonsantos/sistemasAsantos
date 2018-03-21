function HabCombo()
{                
    if($('#radioAnual').is(":checked")== true)
    {                    
        $('#spPeriodo').hide();
        $('#spAno').show();
    }
    else if($('#radioPeriodo').is(":checked")== true)
    {
        $('#spAno').hide();
        $('#spPeriodo').show();
    }
}
function HabComboCoordenadoria()
{
    if($("#coordenadoria").is(":checked")==true)
    {
        $("#campo_coordenadoria").show();
    }
    else
    {
        $("#campo_coordenadoria").hide();
    }
}
function GerarRelatorio(frm)
{        
    if ($('#cmbBeneficiario').val() == '0')
    {
        if($('#radioPeriodo').is(":checked")== true)
        {
            if(($('#dataInicio').val() != '')&&($('#dataFim').val() != ''))
            {
                if($("#coordenadoria").is(":checked")==true)
                {
                    window.open("RelatorioAnualDiariaPDF.php?dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val()+"&tipoRelatorio=coordenadoria&local="+$('#combo_coordenadoria :selected').text()+"&comboCoordenadoria="+$('#combo_coordenadoria').val());                    
                    frm.submit();
                }
                else if($("#todos").is(":checked")==true)
                {        
                    window.open("RelatorioAnualDiariaPDF.php?dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val()+"&tipoRelatorio=todas");
                    frm.submit();                                            
                }
                else
                {
                    alert("Escolha um tipo de relatório!");
                    return false;
                }                
            }
            else
            {
                alert("Informe o período!");
                return false;
            }
            
        }
        else if($('#radioAnual').is(":checked")== true)
        {
            if($("#coordenadoria").is(":checked")==true)
            {
                window.open("RelatorioAnualDiariaPDF.php?cmbAno="+$('#comboAno').val()+"&tipoRelatorio=coordenadoria&local="+$('#combo_coordenadoria :selected').text()+"&comboCoordenadoria="+$('#combo_coordenadoria').val());                    
                frm.submit();
            }
            else if($("#todos").is(":checked")==true)
            {        
                window.open("RelatorioAnualDiariaPDF.php?cmbAno="+$('#comboAno').val()+"&tipoRelatorio=todas");
                frm.submit();                                            
            }
            else
            {
                alert("Escolha um tipo de relatório!");
                return false;
            }            
        }
    }
    else
    {
        if($('#radioAnual').is(":checked")== true)
        {
            window.open("RelatorioFuncionarioPDF.php?cmbBeneficiario="+$('#cmbBeneficiario').val()+"&cmbAno="+$('#comboAno').val());
            frm.submit();
        }
        else if($('#radioPeriodo').is(":checked")== true)
        {
            window.open("RelatorioFuncionarioPDF.php?cmbBeneficiario="+$('#cmbBeneficiario').val()+"&dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val());
            frm.submit();
        }                    
    }
}

function GerarRelatorioDesconto(frm)
{
    if ($('#cmbBeneficiario').val() == '0')
    {
        if(($('#dataInicio').val() != '')&&($('#dataFim').val() != ''))
        {
            console.log($("#coordenadoria").is(":checked"));
            if($("#coordenadoria").is(":checked")==true)
            {
                window.open("RelatorioDiariaDescontoPDF.php?dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val()+"&tipoRelatorio=coordenadoria&local="+$('#combo_coordenadoria :selected').text()+"&comboCoordenadoria="+$('#combo_coordenadoria').val());
                frm.submit();
            }
            else if($("#todos").is(":checked")==true)
            {
                window.open("RelatorioDiariaDescontoPDF.php?dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val()+"&tipoRelatorio=todas");
                frm.submit();
            }
            else
            {
                alert("Escolha um tipo de relatório!");
                return false;
            }
        }
        else
        {
            alert("Informe o período!");
            return false;
        }
    }
    else
    {
        if(($('#dataInicio').val() != '')&&($('#dataFim').val() != ''))
        {
            console.log($("#coordenadoria").is(":checked"));
            if($("#coordenadoria").is(":checked")==true)
            {
                window.open("RelatorioDiariaDescontoPDF.php?cmbBeneficiario="+$('#cmbBeneficiario').val()+"&dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val()+"&tipoRelatorio=coordenadoria&local="+$('#combo_coordenadoria :selected').text()+"&comboCoordenadoria="+$('#combo_coordenadoria').val());
                frm.submit();
            }
            else if($("#todos").is(":checked")==true)
            {
                window.open("RelatorioDiariaDescontoPDF.php?cmbBeneficiario="+$('#cmbBeneficiario').val()+"&dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val()+"&tipoRelatorio=todas");
                frm.submit();
            }
            else
            {
                alert("Escolha um tipo de relatório!");
                return false;
            }
        }
        else
        {
            alert("Informe o período!");
            return false;
        }
    }
}