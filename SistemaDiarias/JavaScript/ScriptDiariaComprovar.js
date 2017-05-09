function HabilitaComplemento()
{    
    if(($('#txtSaldoTipo').val() == 'C')||($('#txtSaldoTotalTipo').val() == 'C'))
    {        
        if(($('#txtSaldo').val() > 0)||($('#totalReceber').val() > 0))
        {
            $('#ComplementoValor').attr('style','display:inline');
            document.Form.txtValorCampoComplemento.value = 1;
        }        
    }
    else
    {
        $('#ComplementoValor').html();
        $('#ComplementoValor').attr('style','display:none');
    }
}

function LimparDados(frm)
{
    frm.action = "SolicitacaoComprovar.php";
    frm.submit();
}

function PedeNovoCalculo(controle)
{        
    $('#txtAlterouCalculo'+controle).val('0');
    $('MostrarResumoBloqueio').attr('style','display: none');
    ConsultaBloqueioDiaria($('#hdBeneficiario').val(),$('#hdNumeroDiaria').val());
}

function ConsultaBloqueioDiaria(beneficiario,numero)
{
    
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxRegraBloqueio.php",
        data: "beneficiario="+beneficiario+"&diaria_id="+$('#txtCodigo').val()+"&dataPartida="+$('#dataPartida').val()+"&dataChegada="+$('#dataChegada').val()+"&numeroSd="+numero,
        success: function(result)
        {    
            $('#tableBloqueio').html(result);
            $('#tableBloqueio').attr('style','display:inline');
        },
        error: function()
        {
            
        }
    })
}

function ConsultaValorRef(cmbBeneficiario,dataPartida)
{
    if(cmbBeneficiario == '')
    {
        cmbBeneficiario = $('#cmbBeneficiario').val();
    }
    if(dataPartida == '')
    {
        dataPartida = $('#dataPartida').val();
    }
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxValorRef.php",
        data: "funcionario_id="+cmbBeneficiario+"&DataPartida="+dataPartida,
        success: function(result)
        {                       
            $('#ValorRef').html(result);             
        },
        error: function()
        {
            
        }
    })
}

function GravarFormComprovacao(frm)
{       
    for(cont=0; cont < frm.elements.length; cont++)
        frm.elements[cont].style.backgroundColor = '';
        
    if (($('#reCalcular').val() == "0")||($('#txtAlterouRoteiro').val() == '1'))
    {
        alert("Calcule a DIÁRIA.");
        return false;
    }
        
    if ($('#dataPartida').val() == "")
    {
        alert("Digite a DATA DE PARTIDA.");
        document.getElementById("formaba1").style.display = '';
        document.getElementById("formaba2").style.display = 'none';
        document.getElementById("formaba3").style.display = 'none';
        document.getElementById("aba1_on").style.display = '';
        document.getElementById("aba1_off").style.display = 'none';
        document.getElementById("aba2_on").style.display = 'none';
        document.getElementById("aba2_off").style.display = '';
        document.getElementById("aba3_on").style.display = 'none';
        document.getElementById("aba3_off").style.display = '';
        $('#dataPartida').focus();
        $('#dataPartida').css('backgroundColor', 'B9DCFF');
        return false;
    }   

    if ($('#horaPartida').val() == "")
    {
        alert("Digite a HORA DE PARTIDA.");
        document.getElementById("formaba1").style.display = '';
        document.getElementById("formaba2").style.display = 'none';
        document.getElementById("formaba3").style.display = 'none';
        document.getElementById("aba1_on").style.display = '';
        document.getElementById("aba1_off").style.display = 'none';
        document.getElementById("aba2_on").style.display = 'none';
        document.getElementById("aba2_off").style.display = '';
        document.getElementById("aba3_on").style.display = 'none';
        document.getElementById("aba3_off").style.display = '';

        $('#horaPartida').focus();
        $('#horaPartida').css('backgroundColor', 'B9DCFF');
        return false;
    }   

    if ($('#dataChegada').val() == "")
    {
        alert("Digite a DATA DE CHEGADA.");
        document.getElementById("formaba1").style.display = '';
        document.getElementById("formaba2").style.display = 'none';
        document.getElementById("formaba3").style.display = 'none';
        document.getElementById("aba1_on").style.display = '';
        document.getElementById("aba1_off").style.display = 'none';
        document.getElementById("aba2_on").style.display = 'none';
        document.getElementById("aba2_off").style.display = '';
        document.getElementById("aba3_on").style.display = 'none';
        document.getElementById("aba3_off").style.display = '';
        
        $('#dataChegada').focus();
        $('#dataChegada').css('backgroundColor', 'B9DCFF');
        return false;
    }    

    if ($('#horaChegada').val() == "")
    {
        alert("Digite a HORA DE CHEGADA.");
        document.getElementById("formaba1").style.display = '';
        document.getElementById("formaba2").style.display = 'none';
        document.getElementById("formaba3").style.display = 'none';
        document.getElementById("aba1_on").style.display = '';
        document.getElementById("aba1_off").style.display = 'none';
        document.getElementById("aba2_on").style.display = 'none';
        document.getElementById("aba2_off").style.display = '';
        document.getElementById("aba3_on").style.display = 'none';
        document.getElementById("aba3_off").style.display = '';
        
        $('#horaChegada').focus();
        $('#horaChegada').css('backgroundColor', 'B9DCFF');
        return false;
    }
    
    if (frm.Calculo.value != "0")
    {
        if ($('#dataPartida').val() != frm.txtConfDataPartida.value)
        {
            alert("Recalcule a Diária!");
            document.getElementById("formaba1").style.display = '';
            document.getElementById("formaba2").style.display = 'none';
            document.getElementById("formaba3").style.display = 'none';
            document.getElementById("aba1_on").style.display = '';
            document.getElementById("aba1_off").style.display = 'none';
            document.getElementById("aba2_on").style.display = 'none';
            document.getElementById("aba2_off").style.display = '';
            document.getElementById("aba3_on").style.display = 'none';
            document.getElementById("aba3_off").style.display = '';
            
            $('#calcular').focus();
            $('#dataPartida').css('backgroundColor', 'B9DCFF');
            return false;
        }
        
        if ($('#horaPartida').val() != frm.txtConfHoraPartida.value)
        {
            alert("Recalcule a Diária!");
            document.getElementById("formaba1").style.display = '';
            document.getElementById("formaba2").style.display = 'none';
            document.getElementById("formaba3").style.display = 'none';
            document.getElementById("aba1_on").style.display = '';
            document.getElementById("aba1_off").style.display = 'none';
            document.getElementById("aba2_on").style.display = 'none';
            document.getElementById("aba2_off").style.display = '';
            document.getElementById("aba3_on").style.display = 'none';
            document.getElementById("aba3_off").style.display = '';

            $('#calcular').focus();
            $('#horaPartida').css('backgroundColor', 'B9DCFF');
            return false;
        }
        
        if ($('#dataChegada').val() != frm.txtConfDataChegada.value)
        {
            alert("Recalcule a Diária!");
            document.getElementById("formaba1").style.display = '';
            document.getElementById("formaba2").style.display = 'none';
            document.getElementById("formaba3").style.display = 'none';
            document.getElementById("aba1_on").style.display = '';
            document.getElementById("aba1_off").style.display = 'none';
            document.getElementById("aba2_on").style.display = 'none';
            document.getElementById("aba2_off").style.display = '';
            document.getElementById("aba3_on").style.display = 'none';
            document.getElementById("aba3_off").style.display = '';
            
            $('#calcular').focus();
            $('#dataChegada').css('backgroundColor', 'B9DCFF');
            return false;
        }
        
        if ($('#horaChegada').val() != frm.txtConfHoraChegada.value)
        {
            alert("Recalcule a Diária!");
            document.getElementById("formaba1").style.display = '';
            document.getElementById("formaba2").style.display = 'none';
            document.getElementById("formaba3").style.display = 'none';
            document.getElementById("aba1_on").style.display = '';
            document.getElementById("aba1_off").style.display = 'none';
            document.getElementById("aba2_on").style.display = 'none';
            document.getElementById("aba2_off").style.display = '';
            document.getElementById("aba3_on").style.display = 'none';
            document.getElementById("aba3_off").style.display = '';

            $('#calcular').focus();
            $('#horaChegada').css('backgroundColor', 'B9DCFF');
            return false;
        }
        
        if (frm.PossuiFimSemana.value == 1)
        {
            if ($('#txtJustificativaFimSemana').val() == "")
            {
                alert("Digite a JUSTIFICATIVA DO FIM DE SEMANA.");
                document.getElementById("formaba1").style.display = '';
                document.getElementById("formaba2").style.display = 'none';
                document.getElementById("formaba3").style.display = 'none';
                document.getElementById("aba1_on").style.display = '';
                document.getElementById("aba1_off").style.display = 'none';
                document.getElementById("aba2_on").style.display = 'none';
                document.getElementById("aba2_off").style.display = '';
                document.getElementById("aba3_on").style.display = 'none';
                document.getElementById("aba3_off").style.display = '';
                
                $('#txtJustificativaFimSemana').focus();
                $('#txtJustificativaFimSemana').css('backgroundColor', 'B9DCFF');
                return false;
            }
        }
    
        if (frm.PossuiFeriado.value == 1)
        {
            if ($('#txtJustificativaFeriado').val() == "")
            {
                alert("Digite a JUSTIFICATIVA DO FERIADO.");
                document.getElementById("formaba1").style.display = '';
                document.getElementById("formaba2").style.display = 'none';
                document.getElementById("formaba3").style.display = 'none';
                document.getElementById("aba1_on").style.display = '';
                document.getElementById("aba1_off").style.display = 'none';
                document.getElementById("aba2_on").style.display = 'none';
                document.getElementById("aba2_off").style.display = '';
                document.getElementById("aba3_on").style.display = 'none';
                document.getElementById("aba3_off").style.display = '';

                $('#txtJustificativaFeriado').focus();
                $('#txtJustificativaFeriado').css('backgroundColor', 'B9DCFF');
                return false;
            }
        }                   

    }

    if (frm.txtValorCampoComplemento.value == 1)
    {
        if ($('#chkComplemento').is(':checked') == true)
        {
            if ($('#txtComplemento').val() == "")
            {
                alert("Digite a JUSTIFICATIVA DO COMPLEMENTO.");
                document.getElementById("formaba1").style.display = '';
                document.getElementById("formaba2").style.display = 'none';
                document.getElementById("formaba3").style.display = 'none';
                document.getElementById("aba1_on").style.display = '';
                document.getElementById("aba1_off").style.display = 'none';
                document.getElementById("aba2_on").style.display = 'none';
                document.getElementById("aba2_off").style.display = '';
                document.getElementById("aba3_on").style.display = 'none';
                document.getElementById("aba3_off").style.display = '';
                frm.txtComplemento.focus();
                frm.txtComplemento.style.backgroundColor='#B9DCFF';
                return false;
            }
        }
    }

    if($('#controleRoteiro').val() > 0)
    {
        roteiro = 0;
        cont = 0;
        
        while(cont < $('#controleRoteiro').val())
        {
            roteiro = parseInt(roteiro) + parseInt(1);
            
            if ($('#txtResumo'+cont).val() == "")
            {
                alert("Digite o RESUMO DA DIÁRIA no "+roteiro+"° roteiro!");                      
                $('#txtResumo').focus();                    
                return false;
            }            
            cont = parseInt(cont) + parseInt(1);
        }
        
        if($('#calculoTotalDiarias').val() == 0)
        {
            alert("Calcule o total de diárias!");
            return false;
        }
    }
    else
    {
        if ($('#txtResumo').val() == "")
        {
            alert("Digite o RESUMO DA DIÁRIA.");  
            document.getElementById("formaba1").style.display = 'none';
            document.getElementById("formaba2").style.display = 'none';
            document.getElementById("formaba3").style.display = 'inline';
            document.getElementById("aba1_on").style.display = 'none';
            document.getElementById("aba1_off").style.display = 'inline';
            document.getElementById("aba2_on").style.display = 'none';
            document.getElementById("aba2_off").style.display = 'inline';
            document.getElementById("aba3_on").style.display = 'inline';
            document.getElementById("aba3_off").style.display = 'none';
            $('#txtResumo').focus();
            $('#txtResumo').css('backgroundColor', 'B9DCFF');
            return false;
        }
    }        
    
    frm.action = "SolicitacaoComprovar.php?acao=comprovar";
    frm.submit();  
}

function AdicionarDadosRoteiro(controle)
{     
    var result              = '';                
    var dataPartida         = $('#dataPartida'+controle).val();
    var cmbMunicipioOrigem  = $('#cmbRoteiroOrigemMunicipio'+controle).val();
    var cmbMunicipioDestino = $('#cmbRoteiroDestinoMunicipio'+controle).val();
    var cmbUfOrigem         = $('#cmbRoteiroOrigemUF'+controle).val();    
    var cmbUfDestino        = $('#cmbRoteiroDestinoUF'+controle).val();
    var controleOrigem      = $('#hdnControleOrigem'+controle).val();    
    var controleDestino     = $('#hdnControleDestino'+controle).val();  
    
    if ($('#cmbRoteiroOrigemMunicipio'+controle).val() == $('#cmbRoteiroDestinoMunicipio'+controle).val())
    {
        alert("ORIGEM e DESTINO são iguais.");
        $('#cmbRoteiroDestinoMunicipio'+controle).focus();        
        $('#cmbRoteiroDestinoMunicipio'+controle).css('backgroundColor', 'B9DCFF');        
        return false;
    }
    
    if($('#cmbRoteiroOrigemMunicipio'+controle+' :selected').text() == 'SALVADOR')
    {
        if(($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'LAURO DE FREITAS')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'CAMACARI')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'ITAPARICA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'SAO FRANCISCO DO CONDE')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'SIMOES FILHO'||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'VERA CRUZ')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'CANDEIAS')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'DIAS D AVILA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'MADRE DE DEUS')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'MATA DE SAO JOAO')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'POJUCA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'SAO SEBASTIAO DO PASSE')))
        {
            alert("O município de destino faz parte da região metropolitana do município de origem!");
            $('#cmbRoteiroDestinoMunicipio'+controle).focus();        
            $('#cmbRoteiroDestinoMunicipio'+controle).css('backgroundColor', 'B9DCFF');        
            return false;
        }
    }
    else if($('#cmbRoteiroOrigemMunicipio'+controle+' :selected').text() == 'FEIRA DE SANTANA')
    {
        if(($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'ANGUERA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'ANTONIO CARDOSO')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'CANDEAL')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'CORACAO DE MARIA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'IPECAETA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'IRARA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'SANTA BARBARA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'SANTANOPOLIS')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'SERRA PRETA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'RIACHAO DO JACUIPE')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'AMELIA RODRIGUES')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'CONCEICAO DE FEIRA')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'CONCEICAO DO JACUIPE')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'SAO GONCALO DOS CAMPOS')||($('#cmbRoteiroDestinoMunicipio'+controle+' :selected').text() == 'TANQUINHO'))
        {
            alert("O município de destino faz parte da região metropolitana do município de origem!");
            $('#cmbRoteiroDestinoMunicipio'+controle).focus();        
            $('#cmbRoteiroDestinoMunicipio'+controle).css('backgroundColor', 'B9DCFF');        
            return false;
        }
    }
  
    $.ajax
    ({
        type: "POST",
        url : "Ajax/AjaxRoteiroAdicionar.php",
        data: "origem="+cmbMunicipioOrigem+"&destino="+cmbMunicipioDestino+"&dataPartida="+dataPartida+"&acao=adicionar&controleOrigem="+controleOrigem+"&controleDestino="+controleDestino+"&controle="+controle,        
        success: function(result)
        {                        
            if($('#cmbRoteiroOrigemUF'+controle).val()== $('#cmbRoteiroDestinoUF'+controle).val())
            {
                $('#cmbRoteiroOrigemMunicipio'+controle).attr('value',cmbMunicipioDestino);
                $('#cmbRoteiroDestinoMunicipio'+controle).attr('value',cmbMunicipioOrigem);
            }
            else if($('#cmbRoteiroOrigemUF'+controle).val()!= $('#cmbRoteiroDestinoUF'+controle).val())
            {
                $('#cmbRoteiroOrigemUF'+controle).attr('value',cmbUfDestino);
                $('#cmbRoteiroDestinoUF'+controle).attr('value',cmbUfOrigem);
                MudaComboCidadeOrigem(cmbMunicipioDestino,controle);               
                MudaComboCidadeDestino(cmbMunicipioOrigem,controle);               
            }  
            $('#RoteiroAdicionado'+controle).html(result);
            $('#RoteiroAdicionado'+controle).show();
        },
        error: function()
        {
            
        }
    })
}

function ExpandirRoteiro(controle)
{        
    $('#roteiroAdicional'+controle).show('slow','');
    $('#mostrar'+controle).hide('slow','');
    $('#minimizarRoteiro'+controle).show();
}

function EsconderRoteiro(controle)
{            
    $('#roteiroAdicional'+controle).hide('slow','');
    $('#mostrar'+controle).show('slow','');
    $('#minimizarRoteiro'+controle).hide();
}

function MudaComboCidadeOrigem(municipioIdOrigem,controle)
{    
    var estadoIdOrigem = $('#cmbRoteiroOrigemUF'+controle).val();
    
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxRoteiroOrigem.php",
        data: "estado_id="+estadoIdOrigem+"&municipio_id="+municipioIdOrigem+"&controle="+controle,
        success: function(result)
        {                       
            $('#RoteiroOrigem'+controle).html(result);                         
        },
        error: function()
        {
            
        }
    })
}

function MudaComboCidadeDestino(municipioIdDestino,controle)
{
    var estadoIdDestino = $('#cmbRoteiroDestinoUF'+controle).val();
    
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxRoteiroDestino.php",
        data: "estado_id="+estadoIdDestino+"&municipio_id="+municipioIdDestino+"&controle="+controle,
        success: function(result)
        {                       
            $('#RoteiroDestino'+controle).html(result);                         
        },
        error: function()
        {
            
        }
    })
}

function LimparDadosRoteiro(controle)
{          
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxLimparDadosOrigem.php",
        data: "acao=limpar&controle="+controle,
        success: function(result)
        {                    
            $('#RoteiroOrigem'+controle).html(result);            
            $('#cmbRoteiroOrigemUF'+controle).val('BA');   
        },
        error: function()
        {
            
        }
    })
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxLimparDadosDestino.php",
        data: "acao=limpar&controle="+controle,
        success: function(result)
        {                    
            $('#RoteiroDestino'+controle).html(result);            
            $('#cmbRoteiroDestinoUF'+controle).val('BA');   
            $('#txtAlterouRoteiro'+controle).val('1');
        },
        error: function()
        {
            
        }
    })
    $.ajax
    ({
        type: "POST",
        url : "Ajax/AjaxRoteiroAdicionar.php",
        data: "acao=limpar&controle="+controle,        
        success: function(result)
        {                   
            $('#RoteiroAdicionado'+controle).html(result);
            $('#RoteiroAdicionado'+controle).hide();            
        },
        error: function()
        {
            
        }
    })
}

function AlterarRoteiro(controle)
{    
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxAlterarRoteiro.php",
        data: "controle="+controle,
        success: function(result)
        {    
            $('#montarRoteiro'+controle).html('');                  
            $('#montarRoteiro'+controle).html(result);    
            $('#reCalcular'+controle).val(0);
            $('#alterarRoteiro'+controle).val(1);
        },
        error: function()
        {
            
        }
    })
}

$(document).ready(function()
{
    $("#calcular").click(function()
    {
        $.ajax
        ({
            type: 'POST',
            url: "acao.php",
            data: "dataPartida="+$("#dataPartida").val()+"&dataChegada="+$("#dataChegada").val(),
            success: function(result)
            {
                if(result == "true")
                    feriado = true;
                else
                    feriado = false;

                dataPartida = $("#dataPartida").val();
                dataChegada = $("#dataChegada").val();

                dataPartida = dataPartida.charAt(6)+dataPartida.charAt(7)+dataPartida.charAt(8)+dataPartida.charAt(9)+
                    dataPartida.charAt(3)+dataPartida.charAt(4)+dataPartida.charAt(0)+dataPartida.charAt(1);

                dataChegada = dataChegada.charAt(6)+dataChegada.charAt(7)+dataChegada.charAt(8)+dataChegada.charAt(9)+
                    dataChegada.charAt(3)+dataChegada.charAt(4)+
                    dataChegada.charAt(0)+dataChegada.charAt(1);

                dias = parseInt(dataChegada) - parseInt(dataPartida);

                if(($("#diaPartida").val() == "Sabado") || ($("#diaPartida").val() == "Domingo") || ($("#diaChegada").val() == "Sabado") || ($("#diaChegada").val() == "Domingo"))
                    final_de_semana = true;
                else
                    switch(dias) 
                    {
                        case 0:
                        case 1:
                            final_de_semana = false;
                            break;

                        case 2:
                            if(($("#diaPartida").val() == "Quinta-Feira") ||($("#diaPartida").val() == "Sexta-Feira"))
                                final_de_semana = true;
                            else
                                final_de_semana = false;
                            break;

                        case 3:
                            if(($("#diaPartida").val() == "Quarta-Feira") || ($("#diaPartida").val() == "Quinta-Feira") || ($("#diaPartida").val() == "Sexta-Feira"))
                                final_de_semana = true;
                            else
                                final_de_semana = false;
                            break;

                        case 4:
                            if(($("#diaPartida").val() == "Terca-Feira")  || ($("#diaPartida").val() == "Quarta-Feira") || ($("#diaPartida").val() == "Quinta-Feira") ||($("#diaPartida").val() == "Sexta-Feira"))
                                final_de_semana = true;
                            else
                                final_de_semana = false;
                            break;

                        case 5:
                            if($("#diaPartida").val() != "Segunda-Feira")
                                final_de_semana = true;
                            else
                                final_de_semana = false;
                            break;

                        default:
                            final_de_semana = true;
                            break;
                    }
            },
            error: function()
            {
                alert("Erro");
            }
        });
    });

    $('.testb').click(function()
    {
        $('#tabela tbody>tr:last').clone(true).insertAfter('#tabela tbody>tr:last');
    });

});        

function CalcularComprovacao(datasaida, datachegada, horasaida, horachegada, beneficiario, desconto, dataatual, valorOld, dataSolicitacao, controle)
{    
    $('#reCalcular'+controle).val('1');
    $('#txtAlterouRoteiro'+controle).val('0');
    
    var valor;   
    var ExisteCampo; 
    var percentual;
    var dataSaidaSolicitada = $('#txtDataSaidaSolicitada').val();
    
    if(desconto == true)
    {
        desconto = "on";
    }
    else
    {
        desconto = "";
    }
    
    $('#calculo').val(1);
    ExisteCampo = 0;
    document.Form.Calculo.value = 1;   
    
    if((($('#RoteiroAdicionado'+controle).html()!='')&&($('#RoteiroAdicionado'+controle).html()!= null))||(($('#roteiroCadastrado'+controle).html()!='')&&($('#roteiroCadastrado'+controle).html()!= null)))    
    {        
        ExisteCampo = 1;
        percentual = $('#txtPercentual'+controle).val();
    }        
    
    if (ExisteCampo == 0)
    {
        alert("Escolha o Roteiro.");
        $('#cmbRoteiroDestinoMunicipio'+controle).focus();
        return false;//2010 [ 07 ] 24 //0123 4 56 7 89
    }    
    
    data1 = datasaida.substring(0,2)+"/"+datasaida.substring(3,5)+"/"+datasaida.substring(6,10);
    data2 = datachegada.substring(0,2)+"/"+datachegada.substring(3,5)+"/"+datachegada.substring(6,10);
    data3 = dataatual.substring(0,2)+"/"+dataatual.substring(3,5)+"/"+dataatual.substring(6,10);
    
    dataSaidaSolicitada = dataSaidaSolicitada.substring(0,2)+"/"+dataSaidaSolicitada.substring(3,5)+"/"+dataSaidaSolicitada.substring(6,10);
    
    data1 = parseInt(data1.split("/")[2].toString()+data1.split("/")[1].toString()+data1.split("/")[0].toString());
    data2 = parseInt(data2.split("/")[2].toString()+data2.split("/")[1].toString()+data2.split("/")[0].toString());
    data3 = parseInt(data3.split("/")[2].toString()+data3.split("/")[1].toString()+data3.split("/")[0].toString());
    
    dataSaidaSolicitada = parseInt(dataSaidaSolicitada.split("/")[2].toString()+dataSaidaSolicitada.split("/")[1].toString()+dataSaidaSolicitada.split("/")[0].toString());
    
    if (data2<data1)
    {
        alert("Data de Chegada menor que a Data de Partida");
        $('#dataChegada'+controle).css('backgroundColor', 'B9DCFF');
        $('#dataPartida'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }
    
    if(data1 < dataSaidaSolicitada)
    {
        alert("Data de Saída efetiva não pode menor que a Data de Saída prevista");
        $('#dataPartida'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }

    if (datasaida == "")
    {
        alert("Escolha a Data de Partida.");
        $('#dataPartida'+controle).focus();
        $('#dataPartida'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }

    if (data2>data3)
    {
        alert("Data de Chegada efetiva não pode maior que a Data de hoje.");
        $('#dataChegada'+controle).css('backgroundColor', 'B9DCFF');
        $('#dataPartida'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }

    if (horasaida == "")
    {
        alert("Digite a Hora de Partida.");
        $('#horaPartida'+controle).focus();
        $('#horaPartida'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }
    else
    {
        hrs = (document.Form.txtHoraPartida.value.substring(0,2));
        min = (document.Form.txtHoraPartida.value.substring(3,5));
        // verifica hora
        if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59))
        {
            alert("Formato da Hora de Partida inexistente.");
            $('#horaPartida'+controle).focus();
            $('#horaPartida'+controle).css('backgroundColor', 'B9DCFF');
            return false;
        }
    }
    if (datachegada == "")
    {
        alert("Escolha a Data de Chegada.");
        $('#dataChegada'+controle).focus();
        $('#horaChegada'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }

    if (horachegada == "")
    {
        alert("Digite a Hora de Chegada.");
        $('#horaChegada'+controle).focus();
        $('#horaChegada'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }
    else
    {
        hrs = (document.Form.txtHoraChegada.value.substring(0,2));
        min = (document.Form.txtHoraChegada.value.substring(3,5));
        // verifica hora
        if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59))
        {
            alert("Formato da Hora de Chegada inexistente.");
            $('#horaChegada'+controle).focus();
            $('#horaChegada'+controle).css('backgroundColor', 'B9DCFF');
            return false;
        }
    }
    // O h�rario de Chegada n�o pode ser menor que o hor�rio de Partida quando tem a mesma data de chegada e partida.
    if ((data2==data1) && (horasaida > horachegada) )
    {
        alert("O horário de chegada menor que o horário de partida.");
        $('#horaPartida'+controle).css('backgroundColor', 'B9DCFF');
        $('#horaChegada'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }

    if (ExisteCampo == 0)
    {
        alert("Escolha o Roteiro.");
        return false;//2010 [ 07 ] 24 //0123 4 56 7 89
    }      
    
    if($('#controleRoteiro').val() > 0)
    {        
        cont = 0;
        while(cont < $('#controleRoteiro').val())
        {            
            if(cont != controle)
            {                      
                if(cont == 0)
                {                    
                    if(controle != '')
                    {
                        roteiro  = parseInt(cont)+parseInt(1);
                        if($('#dataPartida'+controle).val() == $('#dataPartida').val())
                        {                                                        
                            alert('Existe um conflito com a data de saída do roteiro '+roteiro); return false;
                        }
                        else if($('#dataChegada'+controle).val() == $('#dataChegada').val())
                        {                                                       
                            alert('Existe um conflito com a data de chegada do roteiro '+roteiro); return false;
                        }
                    }
                }
                else
                {   
                    roteiro  = parseInt(cont)+parseInt(1);                    
                    if($('#dataPartida'+controle).val() == $('#dataPartida'+cont).val())
                    {
                        alert('Existe um conflito com a data de saída do roteiro '+roteiro); return false;
                    }
                    else if($('#dataChegada'+controle).val() == $('#dataChegada'+cont).val())
                    {
                        alert('Existe um conflito com a data de chegada do roteiro '+roteiro); return false;
                    }
                }                
            }
            cont ++;
        }
    }
    
    $('#txtNovaSaida').val(datasaida);
    $('#txtNovaChegada').val(datachegada);
    $('#txtAlterouCalculo'+controle).val(1);
    
    valor = $('#txtValorReferencia').val();    
    
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxCalculoDiariaComprovacao.php",
        data: "datasaida="+datasaida+"&datachegada="+datachegada+"&horasaida="+horasaida+"&horachegada="+horachegada+"&beneficiario="+beneficiario+"&perc="+percentual+"&valor="+valor+"&desconto="+desconto+"&valorOld="+valorOld+"&dataSolicitacao="+dataSolicitacao+"&controle="+controle+"&totalRoterios="+$('#controleRoteiro').val(),        
        success: function(result)
        {                  
            arrayResult = result.split('__');       
            $('#QtdeDiariaAlterar'+controle).html(arrayResult[0]);              
            $('#diariaSaldo'+controle).html(arrayResult[1]);
            HabilitaComplemento();
            if(controle == '')
            {
                controle = 0;
            }  
            if($('#roteiroExcluido'+controle).val() == 1)
            {
                $('#roteiroExMsg'+controle).html('');
                $('#roteiroExcluido'+controle).val(0);
                $('#roteirosExcluidos').val(parseInt($('#roteirosExcluidos').val()) - parseInt(1));
                EsconderRoteiro(controle);
            }
        },
        error: function()
        {
            
        }
    })    
}

function CalcularTotalDiarias()
{       
    controle = parseInt($('#controleRoteiro').val()) - 1;
    valorTotalOld = $('#diariaValorOldTotal').val();
    valorTotal = 0;
    qtdeTotal  = 0;  
   
    while(controle >= 0)
    {                
        if($('#roteiroExcluido'+controle).val()!= 1)
        {            
            if(controle == 0)
            {                
                if ($('#txtAlterouCalculo').val() == "0")
                {
                    alert("Calcule a DIÁRIA do 1º roteiro.");
                    return false;
                }                                
                
                if($('#reCalcular').val() == "0")
                {                    
                    if($('#txtNovoValor').val() == undefined)
                    {
                        alert("Calcule a DIÁRIA do 1º roteiro.");
                        return false;
                    }
                    valorDiaria = $('#txtNovoValor').val();                    
                }
                else
                {
                    valorDiaria = $('#hdValorDiaria').val();                    
                }         
                EsconderRoteiro(controle);
                qtdeDiaria = $('#hdQtdeDiaria').val();                
            }
            else 
            { 
                roteiro = parseInt(controle) + parseInt(1); 
                if ($('#txtAlterouCalculo'+controle).val() == "0")
                {                                        
                    alert("Calcule a DIÁRIA do "+roteiro+"º roteiro.");
                    return false;
                }                
                
                if($('#reCalcular'+controle).val() == 0)
                {
                    if($('#txtNovoValor'+controle).val() == undefined)
                    {
                        alert("Calcule a DIÁRIA do "+roteiro+"º roteiro.");
                        return false;
                    }
                    valorDiaria = $('#txtNovoValor'+controle).val();
                }
                else
                {                                        
                    valorDiaria = $('#hdValorDiaria'+controle).val();                    
                } 
                EsconderRoteiro(controle);
                qtdeDiaria = $('#hdQtdeDiaria'+controle).val();                
            }
            qtdeTotal  = parseFloat(qtdeTotal) + parseFloat(qtdeDiaria);
            valorTotal = parseFloat(valorTotal) + parseFloat(valorDiaria);             
        } 
        controle = controle - 1;   
    }
    valorTotal = Math.round(valorTotal);
    
    if(valorTotalOld > valorTotal)
    {
        saldo = valorTotalOld - Math.round(valorTotal);
        if(saldo > 0)
        {
            saldoTipo = 'D';
            $('#totalRestituir').val(saldo);
            $('#spTotalRestituir').html('R$ '+Math.ceil(saldo)+',00');  
            $('#spTotalRestituir').attr('class', 'calculoDevolver');
            $('#totalReceber').val('');
            $('#spTotalReceber').html('R$ 0,00');  
            $('#spTotalReceber').attr('class', '');
        }
    }
    else if(valorTotalOld < valorTotal)
    {
        saldo = valorTotal - valorTotalOld;
        saldoTipo = 'C';
        $('#totalReceber').val(saldo);
        $('#spTotalReceber').html('R$ '+Math.ceil(saldo)+',00');
        $('#spTotalReceber').attr('class', 'calculoReceber');
        $('#totalRestituir').val('');
        $('#spTotalRestituir').html('R$ 0,00');  
        $('#spTotalRestituir').attr('class', '');        
    }
    else
    {
        saldoTipo = '';
        $('#totalRestituir').val('');
        $('#spTotalRestituir').html('R$ 0,00');  
        $('#spTotalRestituir').attr('class', '');
        $('#totalReceber').val('');
        $('#spTotalReceber').html('R$ 0,00');  
        $('#spTotalReceber').attr('class', '');
    }
    
    $('#txtSaldoTotalTipo').val(saldoTipo);    
    HabilitaComplemento();
    $('#qtdeTotal').val(qtdeTotal);
    $('#spQtde').html(qtdeTotal);
    $('#totalDiarias').val(valorTotal);
    $('#spValorTotal').html('R$ '+Math.ceil(valorTotal)+',00'); 
    $('#spValorTotal').attr('class', 'calculoSusesso');    
    $('#resultCalculoTotal').show();
    $('#alterarTotalDiarias').val(1);
    $('#calculoTotalDiarias').val(1);    
    $('#NovoValorTotalDiarias').val(Math.ceil(valorTotal)); 
}

function VerificaRoteirosAdicionais()
{    
    if($('#controleRoteiro').val() >= 1)
    {
        EsconderRoteiro(0);
        $('#btnRemover0').show();
        $('#calculoRoteiroAdicional').show();
        var controle = 1;
        while(controle < parseInt($('#controleRoteiro').val()))
        {            
            $('#btnRemover'+controle).show();          
            MontarRoteiros(controle);            
            controle ++;
        }
    }
}

function MontarRoteiros(controle)
{
    dados = "controle="+controle+"&alterarRoteiro"+controle+"=0&valorRef="+$('#ValorRef').html()+"&txtValorRef="+$('#txtValorReferencia').val()+"&codigo="+$('#txtCodigo').val()+"&beneficiario="+$('#cmbBeneficiario').val();                       
    $.ajax
    ({                 
        type: 'POST',
        url : "Ajax/AjaxRoteiroAdicionalComprovacao.php",
        data: dados,
        success: function(result)
        {                 
            resultado = result.split('¬');                      
            $('#mostrar'+controle).html(resultado[0]);                    
            $('#roteiroAdicional'+controle).html(resultado[1]);                       
            $('#espaco'+controle).html(resultado[2]);                     
            EsconderRoteiro(controle);
            $('#btnRemover'+controle).show();                                            
            $('#alterarTotalDiarias').val(0);                       
        },
        error: function()
        {

        }
    })
}

function RemoverRoteiro(controle)
{
    if(controle == '')
    {
        controle = 0;
    }
    $('#roteirosExcluidos').val(parseInt($('#roteirosExcluidos').val())+parseInt(1));
    $('#roteiroExMsg'+controle).html('Excluido');
    $('#roteiroExcluido'+controle).val(1);
    $('#alterarTotalDiarias').val(0);
    EsconderRoteiro(controle);
}

function ContarResumoComprovacao(Campo,Limite,controle)
{
	if((Limite-Campo.value.length) <= 0)
	{
   		alert('Aten\u00E7\u00E3o! Voc\u00EA atingiu o limite m\u00E1ximo de caracteres!');
   		Campo.value = Campo.value.substr(0,Limite);
	}

	document.getElementById("QtdResumo"+controle).value = Campo.value.length
}