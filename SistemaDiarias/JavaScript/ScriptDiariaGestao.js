function Foco(frm)
{
    frm.txtFiltro.focus();
}

function FiltrarForm(frm)
{
    for(cont=0; cont < frm.elements.length; cont++)
        frm.elements[cont].style.backgroundColor = '';

    if (frm.txtFiltro.value == "")
    {
        alert("Digite filtro para busca.");
        frm.txtFiltro.focus();
        frm.txtFiltro.style.backgroundColor='#B9DCFF';
        return false;
    }

    frm.action = "SolicitacaoGestaoInicio.php?acao=buscar&txtFiltro="+$('#txtFiltro').val();
    frm.submit();
}

function TodosForm(frm)
{
    frm.txtFiltro.value = "";
    frm.action = "SolicitacaoGestaoInicio.php";
    frm.submit();
}

function AutorizarForm(frm, checkbox)
{
    cont = 0;
    for (i = 0 ; i < checkbox.length ; i++)
        if (checkbox[i].checked == true)
    {
        cont = cont + 1;
    }

    if (cont == 0)
    {
        alert("Escolha pelo menos uma\nSOLICITAÇÃO DE DIÁRIA.");
        return false;
    }

    var resposta = confirm('Tem certeza que deseja autorizar a(s) diária(s)?');

    if (resposta == true)
    {
        frm.action="SolicitacaoGestaoInicio.php?acao=autorizar";
        frm.submit();
    }

}

function ImprimirDiaria(codigo)
{
    window.open ("SolicitacaoImprimirPDF.php?acao=imprimir&cod="+codigo);
}

function ImprimirDiariasAgrupadas(codigo)
{
   window.open ("ImprimirDiariasAgrupadasEmpenhoPDF.php?cod="+codigo);
}

function ImprimirProcesso(codigo)
{
    window.open ("SolicitacaoProcessoPDF.php?acao=imprimir&cod="+codigo);
}

        function ImprimirProcessoDiariasAgrupadas(codigo)
{
    window.open ("CapaProcessoDiariasAgrupadasPDF.php?cod="+codigo);
}

function LiberarEmpenho (codigo)
{
    var resposta = confirm('Tem certeza que deseja LIBERAR o EMPENHO?');
    if (resposta == true)
    {
        window.location="SolicitacaoGestaoInicio.php?acao=empenharST&Cod="+codigo;
    }
}

function LiberarSegundoEmpenho (codigo)
{
    var resposta = confirm('Tem certeza que deseja LIBERAR o 2ª EMPENHO?');
    if (resposta == true)
    {
        window.location="SolicitacaoGestaoInicio.php?acao=SegundoEmpenharST&Cod="+codigo;
    }
}

function ExtratoEmpenho (checkbox)
{
    StringDiaria ='';

    if (!checkbox.length)
    {
        if (checkbox.checked == false)
        {
            StringDiaria = checkbox.value;
        }
    }
    else
    {
        for (i = 0 ; i < checkbox.length ; i++)
        {
            //Se o checkbox estiver marcado a diária já foi impressa
            if (checkbox[i].checked == false)
            {
                    StringDiaria = (checkbox[i].value)+','+StringDiaria ;
            }
        }
    }
    if (StringDiaria == "") 
    {
       alert("Todas as diárias já foram IMPRESSAS.\n\Para REIMPRIMIR alguma diária DESMARQUE a mesma!");
       return;
    }
    if (StringDiaria.length > 4)
    {
        StringDiaria = StringDiaria.substr(0,StringDiaria.length-1);//retira a virgula do final
    }
    document.Form.action="SolicitacaoImprimirEmpenhoPDF.php?Multiplos="+StringDiaria;
    document.Form.submit();
}

/* Função que Libera todos os Empenhos*/
function LiberarTodosEmpenho(checkboxLiberarEmpenho)
{
    CodigoDiarias ='';

    for (i=0; i < checkboxLiberarEmpenho.length; i++) 
    {
        if (checkboxLiberarEmpenho[i].checked) 
        {                    
            CodigoDiarias = (checkboxLiberarEmpenho[i].value)+','+CodigoDiarias ;
        }
    }

    if (CodigoDiarias == "")
    {
        alert("Todas os Empenhos já foram Liberados.\n\Para Liberar algum Empenho é Ncessário Empenhar Alguma Diária.!!!");
        return;
    }		

    if (CodigoDiarias.length > 4)
    {
        CodigoDiarias = CodigoDiarias.substr(0,CodigoDiarias.length-1);//retira a virgula do final							
    }

    var resposta = confirm('Tem certeza que deseja Liberar Todos os Empenhos ?');

    if (resposta == true)
    {
        Form.action = "SolicitacaoGestaoInicio.php?acao=EmpenhoLiberarTodos&Codigos="+CodigoDiarias;		  
        document.Form.submit();		  
    }		  
}

function PedidoDeEmpenho(codigo)
{    
    var ped;        
    if($('#pedEmp'+codigo).is(':checked') == true)
    {
        ped = 1;
    }
    else
    {
        ped = 2;
    }
    
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxPedidoDeEmpenho.php",
        data: "diariaID="+codigo+"&ped="+ped,
        success: function(result)
        {                              
            if(result == '1')
            {
                alert('Um pedido de empenho foi solicitado.');
                $('#liberarEmpenho'+codigo).css('background-color', '#ffff00');                
            }
            else
            {
                alert('O pedido de empenho foi cancelado.');                 
                $('#liberarEmpenho'+codigo).css('background-color', '#b22222');
            }                         
        },
        error: function()
        {
            
        }
    })
}

function DiariasAprovadas(frm)
{
    
}