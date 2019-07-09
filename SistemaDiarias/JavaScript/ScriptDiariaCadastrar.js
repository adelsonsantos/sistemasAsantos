var feriado = false;
var final_de_semana = false;

function Foco(frm)
{
    frm.cmbBeneficiario.focus();

    if (frm.txtCodigo.value != "")
    {
        document.getElementById("QtdeDiariaAlterar").style.display = '';
    }
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

function ConsultaBloqueioDiaria(beneficiario)
{
    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxRegraBloqueio.php",
        data: "beneficiario="+beneficiario+"&diaria_id="+$('#txtCodigo').val()+"&dataPartida="+$('#dataPartida').val()+"&dataChegada="+$('#dataChegada').val(),
        success: function(result)
        {
            $('#tableBloqueio').html(result);
        },
        error: function()
        {

        }
    })
}

function PedeNovoCalculo(controle)
{
    $('#txtAlterouCalculo'+controle).val('0');
    $('MostrarResumoBloqueio').attr('style','display: none');
    ConsultaBloqueioDiaria($('#cmbBeneficiario').val());
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

    if($('#cmbRoteiroOrigemMunicipio'+controle).val() == $('#cmbRoteiroDestinoMunicipio'+controle).val())
    {
        alert("ORIGEM e DESTINO são iguais.");
        $('#cmbRoteiroDestinoMunicipio'+controle).focus();
        $('#cmbRoteiroDestinoMunicipio'+controle).css('backgroundColor', 'B9DCFF');
        return false;
    }

    //Alteração 24 de julho 2015 decreto Nº 16.220
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
            if($('#cmbRoteiroOrigemUF'+controle).val() == $('#cmbRoteiroDestinoUF'+controle).val())
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

function GravarFormDiaria(frm)
{
    for(cont=0; cont < frm.elements.length; cont++)
        frm.elements[cont].style.backgroundColor = '';

    hora         = (frm.txtHoraCriacao.value.substring(0,2));
    minuto       = (frm.txtHoraCriacao.value.substring(3,5));
    horaAcesso   = (frm.txthorasAcesso.value.substring(0,2));
    minutoAcesso = (frm.txthorasAcesso.value.substring(3,5));
    totalDiarias = parseFloat($('#QtdDiaria').val())+parseFloat($('#txtQtdDiarias').val());

    var totalDiariasMensal = parseFloat($('#QtdDiariaMes').val())+parseFloat($('#txtQtdDiarias').val());

    if ($('#txtBloqueio').val() == "1")
    {
        alert("BENEFICIÁRIO BLOQUEADO.");
        $('#cmbBeneficiario').css('backgroundColor', 'B9DCFF');
        return false;
    }

    if(totalDiariasMensal > 15)
    {
        if($('#cmbBeneficiario').val() == 5894)
        {
            var dateInicio = "01/08/2018";
            var dateFim = "30/09/2018";
            var periodoInicio = $('#dataPartida').val();
            var periodoFim = $('#dataChegada').val();
            var d1 = dateInicio.split("/");
            var d2 = dateFim.split("/");
            var ci = periodoInicio.split("/");
            var cf = periodoFim.split("/");

            var from = new Date(d1[2], parseInt(d1[1])-1, d1[0]);  // -1 because months are from 0 to 11
            var to   = new Date(d2[2], parseInt(d2[1])-1, d2[0]);
            var checkInicio = new Date(ci[2], parseInt(ci[1])-1, ci[0]);
            var checkFim = new Date(cf[2], parseInt(cf[1])-1, cf[0]);
            if((checkInicio > from && checkInicio < to) && (checkFim > from && checkFim < to)){
                if(totalDiariasMensal > 20){

                    if($('#cmbBeneficiario').val() == 5894 ){
                        if(totalDiariasMensal > 23){
                            var qtdRestanteMes = 23 - parseFloat($('#QtdDiariaMes').val());
                            qtdRestanteMes = qtdRestanteMes.toFixed(1);
                            alert("BENEFICIÁRIO BLOQUEADO. Restando apenas "+qtdRestanteMes+" Diárias para atingir o limite total mensal.0");
                            $('#cmbBeneficiario').css('backgroundColor', 'B9DCFF');
                            return false;
                        }
                    }else{
                        var qtdRestanteMes = 20 - parseFloat($('#QtdDiariaMes').val());
                        qtdRestanteMes = qtdRestanteMes.toFixed(1);
                        alert("BENEFICIÁRIO BLOQUEADO. Restando apenas "+qtdRestanteMes+" Diárias para atingir o limite total mensal.1");
                        $('#cmbBeneficiario').css('backgroundColor', 'B9DCFF');
                        return false;
                    }
                }

            }else {

                    var qtdRestanteMes = 15 - parseFloat($('#QtdDiariaMes').val());
                    qtdRestanteMes = qtdRestanteMes.toFixed(1);
                    alert("BENEFICIÁRIO BLOQUEADO. Restando apenas " + qtdRestanteMes + " Diárias para atingir o limite total mensal.2");
                    $('#cmbBeneficiario').css('backgroundColor', 'B9DCFF');
                    return false;

            }
        }
        else {
            if($('#cmbBeneficiario').val() == 2178 ){
                } else {
                var qtdRestanteMes = 15 - parseFloat($('#QtdDiariaMes').val());
                qtdRestanteMes = qtdRestanteMes.toFixed(1);
                alert("BENEFICIÁRIO BLOQUEADO. Restando apenas " + qtdRestanteMes + " Diárias para atingir o limite total mensal.3");
                $('#cmbBeneficiario').css('backgroundColor', 'B9DCFF');
                return false;
            }
        }
    }

    if(parseFloat(totalDiarias) > 180)
    {
        qtdRestante = 179 - parseFloat($('#QtdDiaria').val());
        alert("BENEFICIÁRIO BLOQUEADO. Restando apenas "+qtdRestante.toFixed(1)+" Diárias para atingir o limite total anual.");
        $('#cmbBeneficiario').css('backgroundColor', 'B9DCFF');
        return false;
    }

    if (($('#radioInterior').is(':checked') == false) && ($('#radioCapital').is(':checked') == false))
    {
        alert("Escolha o Local de Solicitação da Diária.");
        $('#radioCapital').focus();
        $('#radioCapital').css('backgroundColor', 'B9DCFF');
        return false;
    }

    if (($('#radioInterior').is(':checked') == true) && ($('#comboCordenadoriaInterior').val() == 0))
    {
        alert("Escolha a Coordenadoria.");
        $('#comboCordenadoriaInterior').focus();
        $('#comboCordenadoriaInterior').css('backgroundColor', 'B9DCFF');
        return false;
    }

    if(($('#controleRoteiro').val() > 0)&&($('#controleRoteiro').val()!= ''))
    {
        if(($('#calculoTotalDiarias').val() == '0')||($('#alterarTotalDiarias').val() == '0'))
        {
            alert("Calcule o total das diárias.");
            return false;
        }
    }
    else
    {
        if(($('#txtAlterouCalculo').val() == "0")||($('#txtAlterouCalculo').val()== ''))
        {
            alert("Calcule a DIÁRIA.");
            return false;
        }
    }


    if ((horaAcesso >= 17 ) && (minutoAcesso > 30))
    {
        alert("A SOLICITAÇÃO DE DIARIA foi emitida após ás 17:30. \n Seu processamento será realizado no próximo dia \n útil.");
    }

    if ($('#cmbBeneficiario').val() == "0")
    {
        alert("Escolha o BENEFICIÁRIO.");
        $('#cmbBeneficiario').focus();
        return false;
    }

    if ($('#dataPartida').val() == "")
    {
        alert("Digite a DATA DE PARTIDA.");
        $('#dataPartida').focus();
        return false;
    }

    if ($('#calculo').val() == "0")
    {
        if ($('#dataPartida').val() != $('$txtConfDataPartida').val())
        {
            alert("A DATA DE PARTIDA calculada é diferente da DATA DE PARTIDA informada.");
            $('#dataPartida').focus();
            return false;
        }
    }

    if ($('#horaPartida').val() == "")
    {
        alert("Digite a HORA DE PARTIDA.");
        $('#horaPartida').focus();
        return false;
    }

    if ($('#dataChegada').val() == "")
    {
        alert("Digite a DATA DE CHEGADA.");
        $('#dataChegada').focus();
        $('#dataChegada').css('backgroundColor', 'B9DCFF');
        return false;
    }

    if ($('#horaChegada').val() == "")
    {
        alert("Digite a HORA DE CHEGADA.");
        $('#horaChegada').focus();
        return false;
    }

    if ($('#calculo').val() == "0")
    {
        if ($('#horaChegada').val() != $('#txtConfHoraChegada').val())
        {
            alert("A HORA DE CHEGADA calculada é diferente da HORA DE CHEGADA informada.");
            $('#horaChegada').focus();
            return false;
        }
    }

    if ($('#calculo').val() == "0")
    {
        alert("Calcule a Diária.");
        return false;
    }

    if ((feriado == true) && ($('#txtJustificativaFeriado').val() == ""))
    {
        alert("Digite a JUSTIFICATIVA DO FÉRIADO.");
        $('#txtJustificativaFeriado').focus();
        return false;
    }

    if ((final_de_semana == true) && ($('#txtJustificativaFimSemana').val() == ""))
    {
        alert("Digite a JUSTIFICATIVA DO FIM DE SEMANA.");
        $('#txtJustificativaFimSemana').focus();
        return false;
    }

    if ($('#cmbMeioTransporte').val() == "0")
    {
        alert("Escolha o MEIO DE TRANSPORTE.");
        $('#cmbMeioTransporte').focus();
        return false;
    }

    if ($('#cmbMotivoDiaria').val() == "0")
    {
        alert("Escolha o MOTIVO.");
        $('#cmbMotivoDiaria').focus();
        return false;
    }

    if ($('#txtDescricao').val() == "")
    {
        alert("Digite a DESCRIÇÃO.");
        $('#txtDescricao').focus();
        return false;
    }

    if ($('#cmbUnidadeCusto').val() == "0")
    {
        alert("Escolha a UNIDADE DE CUSTO.");
        $('#cmbUnidadeCusto').focus();
        return false;
    }

    if ($('#cmbProjeto').val() == "0")
    {
        alert("Selecione um PROJETO.");
        $('#cmbProjeto').focus();
        return false;
    }

    if ($('#cmbAcao').val() == "0")
    {
        alert("Selecione um PRODUTO.");
        $('#cmbAcao').focus();
        return false;
    }

    if ($('cmbTerritorio').val() == "0")
    {
        alert("Selecione um TERRITÓRIO.");
        $('cmbTerritorio').focus();
        return false;
    }

    if ($('#cmbFonte').val() == "0")
    {
        alert("Selecione uma FONTE.");
        $('#cmbFonte').focus();
        return false;
    }

    if ($('#cmbEtapa').val() == "0")
    {
        alert("Selecione uma ETAPA.");
        $('#cmbEtapa').focus();
        return false;
    }

    if (($('#txtCodigo').val() == "")||($('#txtCodigo').val() == 'undefined'))
    {
        frm.action = "SolicitacaoInicio.php?acao=incluir&pagina="+$('#pagina').val();
    }
    else
    {
        frm.action = "SolicitacaoInicio.php?acao=alterar&pagina="+$('#pagina').val();
    }

    frm.submit();
}

function CalcularDiaria(datasaida, datachegada, horasaida, horachegada, beneficiario, desconto, dataatual, controle)
{
    $('#reCalcular'+controle).val('1');
    var valor;
    var ExisteCampo;
    var percentual;

    if(desconto == true)
    {
        desconto = "on";
    }
    else
    {
        desconto = "";
    }

    if(beneficiario == 0)
    {
        alert("Escolha o Beneficiário.");
        $('#cmbBeneficiario').focus();
        return false;
    }

    $('#calculo').val(1);
    ExisteCampo = 0;

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

    data1 = datasaida.substring(0,2)   + "/" + datasaida.substring(3,5)   + "/" + datasaida.substring(6,10);
    data2 = datachegada.substring(0,2) + "/" + datachegada.substring(3,5) + "/" + datachegada.substring(6,10);
    data3 = dataatual.substring(0,2)  + "/" + dataatual.substring(3,5)   + "/" + dataatual.substring(6,10);

    data1 = parseInt(data1.split("/")[2].toString()+data1.split("/")[1].toString()+data1.split("/")[0].toString());
    data2 = parseInt(data2.split("/")[2].toString()+data2.split("/")[1].toString()+data2.split("/")[0].toString());
    data3 = parseInt(data3.split("/")[2].toString()+data3.split("/")[1].toString()+data3.split("/")[0].toString());

    if (data2<data1)
    {
        alert("Data de Chegada menor que a Data de Partida");
        return false;
    }

    if (datasaida == "")
    {
        alert("Escolha a Data de Partida.");
        $('#dataPartida'+controle).focus();
        return false;
    }

    if (data1<data3)
    {
        alert("Data de Saída não pode menor que a Data Atual");
        $('#dataPartida'+controle).focus();
        return false;
    }

    if (horasaida == "")
    {
        alert("Digite a Hora de Partida.");
        $('#horaPartida'+controle).focus();
        return false;
    }
    else
    {
        hrs = ($('#horaPartida'+controle).val().substring(0,2));
        min = ($('#horaPartida'+controle).val().substring(3,5));
        // verifica hora
        if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59))
        {
            alert("Formato da Hora de Partida inexistente.");
            $('#horaPartida'+controle).focus();
            return false;
        }
    }

    if (datachegada == "")
    {
        alert("Escolha a Data de Chegada.");
        $('#dataChegada'+controle).focus();
        return false;
    }

    if (horachegada == "")
    {
        alert("Digite a Hora de Chegada.");
        $('#horaChegada'+controle).focus();
        return false;
    }
    else
    {
        hrs = ($('#horaChegada'+controle).val().substring(0,2));
        min = ($('#horaChegada'+controle).val().substring(3,5));
        // verifica hora
        if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59))
        {
            alert("Formato da Hora de Chegada inexistente.");
            $('#horaChegada'+controle).focus();
            return false;
        }
    }
    // O hor�rio de Chegada n�o pode ser menor que o hor�rio de Partida quando tem a mesma data de chegada e partida.
    if ((data2==data1) && (horasaida > horachegada) )
    {
        alert("O horário de chegada menor que o horário de partida.");
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
    ConsultaBloqueioDiaria(beneficiario);

    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxCalculoDiaria.php",
        data: "datasaida="+datasaida+"&datachegada="+datachegada+"&horasaida="+horasaida+"&horachegada="+horachegada+"&beneficiario="+beneficiario+"&perc="+percentual+"&valor="+valor+"&desconto="+desconto+"&dataSolocitada="+dataatual+"&controle="+controle+"&totalRoterios="+$('#controleRoteiro').val(),
        success: function(result)
        {
            $('#QtdeDiariaAlterar'+controle).html();
            $('#QtdeDiariaAlterar'+controle).show();
            $('#QtdeDiariaAlterar'+controle).html(result);
//            $('#QtdeDiaria'+controle).html(result);
//            $('#QtdeDiaria'+controle).show();
//            $('#QtdeDiariaAlterar'+controle).hide();
            $('#alterarTotalDiarias').val(0);
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
            else
            {
                if($('#controleRoteiro').val() > 0)
                {
                    EsconderRoteiro(controle);
                    $('#calculoRoteiroAdicional').show();
                }
            }

            if(($('#cmbEtapa').val() == '0')||(typeof $('#cmbEtapa').val() == 'undefined'))
            {
                VerificaSaldo();
            }
            else
            {
                VerificaSaldoEtapa();
            }
        },
        error: function()
        {

        }
    })
}

function MostrarBloqueio()
{
    document.getElementById("divBloqueio").style.display = '';
}

function HabCoordenadoria()
{
    if($('#radioInterior').is(':checked') == true)
    {
        $('#campoCordenadoria').attr('style','display:inline');
    }
    else if($('#radioCapital').is(':checked') == true)
    {
        $('#comboCordenadoriaInterior').attr('value','0');
        $('#campoCordenadoria').attr('style','display:none');
    }
}

function myTrim(x)
{
    return x.replace(/^\s+|\s+$/gm,'');
}

function VerificaSaldo()
{
    fonte = myTrim($('#cmbFonte').val().toUpperCase());

    if(($('#txtProjeto').val() != $('#cmbProjeto').val())||(myTrim($('#txtFonte').val().toUpperCase()) != fonte))
    {
        projetoAnt = $('#txtProjeto').val();
        fonteAnt   = myTrim($('#txtFonte').val().toUpperCase());

        if($('#controleRoteiro').val() > 0)
        {
            valorAnt = $('#valorTotalDiarias').val();

            if(($('#calculoTotalDiarias').val() == 0)||($('#alterarTotalDiarias').val() == '0'))
            {
                valorDiaria = $('#valorTotalDiarias').val();
            }
            else
            {
                valorDiaria = $('#NovoValorTotalDiarias').val();
            }
        }
        else
        {
            valorAnt = $('#txtValor').val();
            if($('#reCalcular').val() == 0)
            {
                valorDiaria = $('#txtValor').val();
            }
            else
            {
                if(($('#txtNovoValor').val() == '')||($('#txtNovoValor').val() == '0'))
                {
                    valorDiaria = $('#txtValor').val();
                }
                else
                {
                    valorDiaria = $('#txtNovoValor').val();
                }
            }
        }
    }

    if(((fonte != 'XX')&&(fonte != '0'))&&($('#cmbProjeto').val() != 0 && $('#cmbProjeto').val() != 1000))
    {
        $.ajax
        ({
            type: 'POST',
            url : "Ajax/AjaxConsultaSaldo.php",
            data: "fonteId="+fonte+"&projetoId="+$('#cmbProjeto').val()+"&dataPartida="+$('#dataPartida').val()+"&valorDiaria="+valorDiaria+"&projetoAnt="+projetoAnt+"&fonteAnt="+fonteAnt+"&valorAnt="+valorAnt+"&dataPartAnt="+$('#dtDiariaAnt').val(),
            success: function(result)
            {
                comboEtapa = result.substring(1,7);
                resultado = result.split('¬');

                if(resultado[0] == '1')
                {
                    $('#saldoResultado').html(resultado[1]);
                    $('#btnGravar').attr("disabled",true);
                    $('#desEtapa').attr("style","display: none");
                    $('#spEtapa').html('');
                }
                else if(comboEtapa == 'select')
                {
                    $('#desEtapa').attr("style","display: inline");
                    $('#spEtapa').attr("style","display: inline");
                    $('#spEtapa').html(result);
                    $('#saldoResultado').html('');
                    $('#btnGravar').attr("disabled",true);
                }
                else if((resultado[0] != '1')&&(resultado[0] != '')&&(comboEtapa != 'select'))
                {
                    $('#saldoResultado').html(resultado[0]);
                    $('#btnGravar').attr("disabled",false);
                    $('#desEtapa').attr("style","display: none");
                    $('#spEtapa').html('');
                }
                else if(resultado[0] == '')
                {
                    $('#saldoResultado').html('');
                    $('#btnGravar').attr("disabled",false);
                    $('#desEtapa').attr("style","display: none");
                    $('#spEtapa').html('');
                }
            },
            error: function()
            {

            }
        })
    }
    else
    {
        $('#saldoResultado').html('');
        $('#btnGravar').attr("disabled",false);
        $('#desEtapa').attr("style","display: none");
        $('#spEtapa').html('');
    }
}

function VerificaSaldoEtapa()
{
    valorAnt       = $('#txtValor').val();
    etapaAnt       = $('#txtEtapa').val();
    diariaId       = $('#txtCodigo').val();
    valorRefAnt    = $('#txtValorRefAnt').val();

    if($('#controleRoteiro').val() > 0)
    {
        valorAnt = $('#valorTotalDiarias').val();

        if(($('#calculoTotalDiarias').val() == 0)||($('#alterarTotalDiarias').val() == '0'))
        {
            valorDiaria = $('#valorTotalDiarias').val();
        }
        else
        {
            valorDiaria = $('#NovoValorTotalDiarias').val();
        }
    }
    else
    {
        if($('#reCalcular').val() == 0)
        {
            valorDiaria = $('#txtValor').val();
        }
        else
        {
            if(($('#txtNovoValor').val() == '')||($('#txtNovoValor').val() == '0'))
            {
                valorDiaria = $('#txtValor').val();
            }
            else
            {
                valorDiaria = $('#txtNovoValor').val();
            }
        }
    }

    if((typeof $('#txtNovoValorRef').val() == 'undefined'))
    {
        valorRef = valorRefAnt;
    }
    else
    {
        valorRef = $('#txtNovoValorRef').val();
    }

    if(($('#cmbEtapa').val() != '0') && ($('#cmbEtapa').val() != 0))
    {
        $.ajax
        ({
            type: 'POST',
            url : "Ajax/AjaxConsultaSaldoEtapa.php",
            data: "etapaId="+$('#cmbEtapa').val()+"&valorReferencia="+valorRef+"&valorDiaria="+valorDiaria+"&etapaAnt="+etapaAnt+"&diariaId="+diariaId+"&valorAnt="+valorAnt+"&valorRefAnt="+valorRefAnt,
            success: function(result)
            {
                resultado = result.split('¬');
                if(resultado[0] == '1')
                {
                    $('#saldoResultado').html(resultado[1]);
                    $('#btnGravar').attr("disabled",true);
                }
                else
                {
                    $('#saldoResultado').html(resultado[0]);
                    $('#btnGravar').attr("disabled",false);
                }
            },
            error: function()
            {

            }
        })
    }
}

function ChecaEtapa()
{
    if(($('#txtEtapa').val() != '')&&($('#txtEtapa').val() != 0))
    {
        $('#spEtapa').attr("style","display: inline");
        $('#desEtapa').attr("style","display: inline");
    }
    else
    {
        $('#spEtapa').html('');
        $('#desEtapa').attr("style","display: none");
    }
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

function RoteiroAdicional(cont)
{
    var dados;

    if($('#controleRoteiro').val() == 4)
    {
        alert('Não é possível adicionar mais roteiros!');
        $('#btnAdicionarRoteiro'+cont).hide();
        return false;
    }

    if($('#reCalcular'+cont).val() == 0)
    {
        alert("Calcule a diária!"); return false;
    }

    if($('#txtCodigo').val() != '')
    {
        controle = parseInt($('#controleRoteiro').val()) + parseInt(1);
        dados = "controle="+controle+"&alterarRoteiro"+controle+"=1&valorRef="+$('#ValorRef').html()+"&txtValorRef="+$('#txtValorReferencia').val()+"&codigo="+$('#txtCodigo').val()+"&beneficiario="+$('#cmbBeneficiario').val();
    }
    else
    {
        if($('#controleRoteiro').val() == 0)
        {
            controle = 1;
        }
        else
        {
            controle = cont + 1;
        }
        dados = "controle="+controle+"&alterarRoteiro"+controle+"=1&valorRef="+$('#ValorRef').html()+"&txtValorRef="+$('#txtValorReferencia').val();
    }

    $.ajax
    ({
        type: 'POST',
        url : "Ajax/AjaxRoteiroAdicional.php",
        data: dados,
        success: function(result)
        {
            resultado = result.split('¬');
            $('#mostrar'+controle).html(resultado[0]);
            $('#roteiroAdicional'+controle).html(resultado[1]);
            $('#roteiroAdicional'+controle).show();
            $('#espaco'+controle).html(resultado[2]);
            $('#btnAdicionarRoteiro'+cont).hide();
            $('#controleRoteiro').val(controle);
            if(cont == '')
            {
                EsconderRoteiro(0);
                $('#btnRemover0').show();
                CalcularDiaria($('#dataPartida').val(), $('#dataChegada').val(), $('#horaPartida').val(), $('#horaChegada').val(), $('#cmbBeneficiario').val(), $('#chkDesconto').is(':checked'), $('#txtDataAtual').val(), '');
            }
            else
            {
                EsconderRoteiro(cont);
                $('#btnRemover'+cont).show();
            }
            $('#alterarTotalDiarias').val(0);
            if($('#txtCodigo').val() != '')
            {
                ExpandirRoteiro(controle);
            }
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

function VerificaRoteirosAdicionais()
{
    if($('#controleRoteiro').val() >= 1)
    {
        EsconderRoteiro(0);
        $('#btnRemover0').show();
        $('#calculoRoteiroAdicional').show();
        var controle = 1;
        while(controle <= parseInt($('#controleRoteiro').val()))
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
        url : "Ajax/AjaxRoteiroAdicional.php",
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

function CalcularTotalDiarias()
{
    controle = $('#controleRoteiro').val();

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

                if($('#reCalcular').val() == 1)
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
                if ($('#txtAlterouCalculo'+controle).val() == "0")
                {
                    roteiro = parseInt(controle) + parseInt(1);
                    alert("Calcule a DIÁRIA do "+roteiro+"º roteiro.");
                    return false;
                }

                if($('#reCalcular'+controle).val() == 1)
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

            if(qtdeTotal > 15){
                alert('A quantidade de diárias não pode ultrapassar 15 diárias, quantidate atual: '+qtdeTotal);
                return false;
            }
        }
        controle = controle - 1;
    }

    //console.log(valorTotal);
    function formatReal( int )
    {
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
            tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
    }

    var str =  valorTotal.toString();
    str = str.charAt(str.length-1);
    var totalNumInteiro = parseInt(str);
    if(totalNumInteiro === 5){
        $('#totalDiarias').val('R$ '+formatReal(valorTotal*100));
    }
    else{
        $('#totalDiarias').val('R$ '+formatReal(valorTotal*100));
    }
    $('#qtdeTotal').val(qtdeTotal);
    $('#resultCalculoTotal').show();
    $('#alterarTotalDiarias').val(1);
    $('#calculoTotalDiarias').val(1);
    $('#NovoValorTotalDiarias').val(valorTotal);

    //$('#qtdeTotal').val(qtdeTotal);
    //$('#totalDiarias').val('R$ '+Math.ceil(valorTotal)+',00');
    //$('#resultCalculoTotal').show();
    //$('#alterarTotalDiarias').val(1);
    //$('#calculoTotalDiarias').val(1);
    //$('#NovoValorTotalDiarias').val(Math.ceil(valorTotal));
}

$(document).ready(function()
{
    $("#calcular").click(function()
    {
        $.ajax
        ({
            type: 'POST',
            url: "acao.php",
            data: "dataPartida="  +$("#dataPartida").val() + "&dataChegada=" +$("#dataChegada").val(),
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
                if(($("#diaPartida").val() == "Sábado") || ($("#diaPartida").val() == "Domingo") || ($("#diaChegada").val() == "Sábado") || ($("#diaChegada").val() == "Domingo"))
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