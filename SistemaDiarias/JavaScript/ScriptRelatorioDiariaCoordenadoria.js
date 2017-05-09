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
    var desEtapa = $('#cmbEtapa option:selected').text();
    desEtapa = desEtapa.substring(0,3);    
    
    if(($('#dataInicio').val() != '')&&($('#dataFim').val() != ''))
    {                                        
        if($("#coordenadoria").is(":checked")==true)
        {
            window.open("RelatorioDiariaCoordenadoriaPDF.php?tipoRelatorio=coordenadoria&local="+$('#combo_coordenadoria :selected').text()+"&comboCoordenadoria="+$('#combo_coordenadoria').val()+"&dsDiretoria="+$('#comboDiretoria :selected').text()+"&txtDataInicio="+$('#dataInicio').val()+"&txtDataFim="+$('#dataFim').val()+"&comboDiretoria="+$('#comboDiretoria').val()+"&comboProjeto="+$('#cmbProjeto').val()+"&comboFonte="+$('#cmbFonte').val()+"&comboStatus="+$('#comboStatus').val()+"&cmbEtapa="+$('#cmbEtapa').val()+"&desEtapa="+desEtapa);
        }
        else if($("#todos").is(":checked")==true)
        {                                                 
            window.open("RelatorioDiariaCoordenadoriaPDF.php?tipoRelatorio=todas&txtDataInicio="+$('#dataInicio').val()+"&txtDataFim="+$('#dataFim').val()+"&comboDiretoria="+$('#comboDiretoria').val()+"&dsDiretoria="+$('#comboDiretoria :selected').text()+"&comboProjeto="+$('#cmbProjeto').val()+"&comboFonte="+$('#cmbFonte').val()+"&comboStatus="+$('#comboStatus').val()+"&cmbEtapa="+$('#cmbEtapa').val()+"&desEtapa="+desEtapa);                        
        }
        else
        {
            alert("Escolha um tipo de relatório!");
            return false;
        }
        frm.submit();
    }
    else
    {
        alert("Informe o período!");
    }
}  

function habilitaGrafico()
{   
    if((($('#dataInicio').val() != '')&&($('#dataFim').val() != ''))&&($('#todos').is(":checked")==true))
    {
        $('#spanGrafico').show();
    }
    else
    {
        $('#spanGrafico').hide();
    }
}

function GerarGrafico(frm)
{
    if(($('#dataInicio').val() != '')&&($('#dataFim').val() != ''))
    {
        if($("#todos").is(":checked")==true)
        {                                                 
            window.open("RelatorioDiariaCoordenadoriaGrafico.php?tipoRelatorio=todas&txtDataInicio="+$('#dataInicio').val()+"&txtDataFim="+$('#dataFim').val()+"&comboDiretoria="+$('#comboDiretoria').val()+"&dsDiretoria="+$('#comboDiretoria :selected').text()+"&comboProjeto="+$('#cmbProjeto').val()+"&comboFonte="+$('#cmbFonte').val()+"&comboStatus="+$('#comboStatus').val()+"&cmbEtapa="+$('#cmbEtapa').val()+"&desEtapa="+desEtapa);                        
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
    }
}

function VerificaEtapa()
{       
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxVerificaEtapa.php",
        data: "projetoId="+$('#cmbProjeto').val()+"&fonteId="+$('#cmbFonte').val(),
        success: function(result)
        {
            if(result != '')
            {
                $('#desEtapa').attr("style","display: inline"); 
                $('#spEtapa').attr("style","display: inline");
                $('#spEtapa').html(result);
            }
            else
            {
                $('#desEtapa').attr("style","display: none"); 
                $('#spEtapa').attr("style","display: none");
            }
        },
        error: function()
        {

        }
    }) 
}