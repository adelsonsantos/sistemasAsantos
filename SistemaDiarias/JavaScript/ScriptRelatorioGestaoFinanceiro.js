function GerarRelatorio()
{
    if($('#comboStatus').val() == 0)
    {
        alert('Informe a situação!');
        return false;
    }
    
    if($('#dataInicio').val() == '')
    {
        alert('Informe a data de inicio da busca!');
        return false;
    }
    
    if($('#dataFim').val() == '')
    {
        alert('Informe a data limite para a busca!');
        return false;
    }
    
    window.open("RelatorioGestaoFinanceiroPDF.php?diretoria="+$('#comboDiretoria').val()+"&status="+$('#comboStatus').val()+"&dataInicio="+$('#dataInicio').val()+"&dataFim="+$('#dataFim').val()+"&dsDiretoria="+$('#comboDiretoria option:selected').text());
}