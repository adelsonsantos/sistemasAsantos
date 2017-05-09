var xmlHttp,xmlHttp1, layer, filter

// Alterado por Rodolfo em 15/10/2008
//fun��o em ajax que vai buscar as informa��es das di�rias bloqueadas .
//Lembrando que deve criar um novo objeto .. erro na chamado com objetos sobrepostos..
// **********************************************************************************************
function VerificabloqueiaDiaria()
 {
    xmlHttp1=GetXmlHttpObject()
    xmlHttp1.open("post", "Ajax/AjaxRegraBloqueio.php", true);
    xmlHttp1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlHttp1.onreadystatechange=function()
    {
        if (xmlHttp1.readyState==4)
        {// abaixo o texto gerado no arquivo executa.php e colocado no div
            document.all.divBloqueio.innerHTML = xmlHttp1.responseText;
        }
    }
    xmlHttp1.send("beneficiario=" + document.Form.cmbBeneficiario.value);
}
// **********************************************************************************************

function MandaID(str,layer,filter)
{
    xmlHttp=GetXmlHttpObject()

    if (xmlHttp==null)
    {
        alert ("Este browser n\u00E3o suporta HTTP Request.");
        return
    }

    var url= "Ajax/" + layer +".php";
    url=url+"?"+filter+"="+str;    
    switch(layer)
    {
        case "AjaxProjeto":
                xmlHttp.onreadystatechange = stateChangedProjeto
        break;
        case "AjaxAcao":
                xmlHttp.onreadystatechange = stateChangedAcao
        break;
        case "AjaxFonte":
                xmlHttp.onreadystatechange = stateChangedFonte
        break;
        case "AjaxTerritorio":
                xmlHttp.onreadystatechange = stateChangedTerritorio
        break;
        case "AjaxRoteiroOrigem":
                xmlHttp.onreadystatechange = stateChangedRoteiroOrigem
        break;
        case "AjaxRoteiroDestino":
                xmlHttp.onreadystatechange = stateChangedRoteiroDestino
        break;
        case "AjaxSubMotivo":
                xmlHttp.onreadystatechange = stateChangedSubMotivo
        break;
        case "AjaxTipoParticipante":
                xmlHttp.onreadystatechange = stateChangedTipoParticipante
        break;
        case "AjaxNaturalidade":
                xmlHttp.onreadystatechange = stateChangedNaturalidade;
        break;
        case "AjaxTituloEleitor":
                xmlHttp.onreadystatechange = stateChangedTituloEleitor;
        break;
        case "AjaxEndereco":
                xmlHttp.onreadystatechange = stateChangedEndereco;
        break;
    }
    
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)

}
function MandaValorRef(str,str2,layer,filter,filter2)
{
    xmlHttp=GetXmlHttpObject()

    if (xmlHttp==null)
    {
            alert ("Este browser n\u00E3o suporta HTTP Request")
            return
    }

    var url= "Ajax/" + layer +".php"
    url=url+"?"+filter+"="+str+"&"+filter2+"="+str2
    
    switch(layer){
            case "AjaxValorRef":
                    xmlHttp.onreadystatechange = stateChangedValorRef
            break;
    }

    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)

}
function RefazResumo(datasaida,datachegada)
{
    xmlHttp=GetXmlHttpObject()

    var url
    url = "Ajax/AjaxRefazResumo.php?datasaida="+datasaida+"&datachegada="+datachegada;

    xmlHttp.onreadystatechange = stateRefazResumo

    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)

}

function stateRefazResumo()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Resumo").innerHTML=xmlHttp.responseText
}

function stateChangedSubMotivo()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("SubMotivo").innerHTML=xmlHttp.responseText
}

function stateChangedProjeto()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Projeto").innerHTML=xmlHttp.responseText
}

function stateChangedAcao()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Acao").innerHTML=xmlHttp.responseText
}

function stateChangedFonte()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Fonte").innerHTML=xmlHttp.responseText
}

function stateChangedTerritorio()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Territorio").innerHTML=xmlHttp.responseText
}

function stateChangedValorRef()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("ValorRef").innerHTML=xmlHttp.responseText;
}

function stateChangedRoteiroOrigem()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("RoteiroOrigem").innerHTML=xmlHttp.responseText
}

function stateChangedRoteiroDestino()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("RoteiroDestino").innerHTML=xmlHttp.responseText
}

function stateAddRoteiro()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Roteiro").innerHTML=xmlHttp.responseText
}

function stateChangedNaturalidade()
{    
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("NaturalidadeCidade").innerHTML=xmlHttp.responseText    
}

function stateChangedTituloEleitor()
{    
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Titulo").innerHTML=xmlHttp.responseText    
}

function stateChangedEndereco()
{    
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Endereco").innerHTML=xmlHttp.responseText    
}
function GetXmlHttpObject()
{
    var objXMLHttp=null

    if (window.XMLHttpRequest)
    {
        objXMLHttp=new XMLHttpRequest()
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
    }
    return objXMLHttp
}