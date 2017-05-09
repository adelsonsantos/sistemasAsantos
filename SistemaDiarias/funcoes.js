function HabCoordenadoria() {

  if (document.getElementById('sede').checked) {
	  document.getElementById('campo_coordenadoria').style.display = "none";	
  }

  if (document.getElementById('coordenadoria').checked) {
	 document.getElementById('campo_coordenadoria').style.display = "";	      
  }    
}

function HabEstadoACPDiretor() {

  if (document.getElementById('ACP_SIM').checked) {
	  document.getElementById('RADIO_ESTADO_ACP_DIRETOR').style.display = "";	
  }

  if (document.getElementById('ACP_NAO').checked) {
	 document.getElementById('RADIO_ESTADO_ACP_DIRETOR').style.display = "none";	      
  }    
}


function HabTipoRelatorioDiaria() {

  if (document.getElementById('todos').checked) {
	  document.getElementById('campo_coordenadoria').style.display = "";	
  }

  if (document.getElementById('coordenadoria').checked) {
	 document.getElementById('campo_coordenadoria').style.display = "none";	      
  }    
}

function verificaNumeros(e) {
 // Código do Botão: onkeypress = "return verificaNumeros(event)";
	if(window.event) {
	// for IE, e.keyCode or window.event.keyCode can be used
		key = e.keyCode;
	}
	else if(e.which) {
	// netscape
		key = e.which;
	}
	if (key!=8 || key < 48 || key > 57) return (((key > 47) && (key < 58)) || (key==8));
	{
      return true;
    }
}

function formataData(campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace("/", "");
	vr = vr.replace("-", "");
	tam = vr.length + 1;
	if (tecla != 10){
		if (tam == 3)
			campo.value = vr.substr(0, 2) + '/';
		if (tam == 5)
			campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 3) + '/';					
	}				
}

function setData(){
	var f = document.forms['frmprocesso'];
	var f2 = document.forms['frmprocessoOrigem'];
	var f3 = document.forms['frmhomologacao'];
	var f4 = document.forms['frmtransferencia'];
	data = new Date();
	dia = data.getDate();
	mes = data.getMonth() + 1;
	ano = data.getFullYear();
	data = dia+"/"+mes+"/"+ano;
	f.tf_data_lancamento.value = data;
	f2.tf_data_lanc_origem.value = data;
	f3.tf_data_homo.value = data;
	f4.tf_data_trasnf.value = data;
}

function somenteLetras(e){
	var tecla=(window.event)?event.keyCode:e.which;
	if(((tecla >= 65) && (tecla <= 90))||((tecla >= 97) && (tecla <= 122))) return true; // if((tecla > 65 && tecla < 90)||(tecla > 97 && tecla < 122)) return true;
	else{
	if (tecla != 8) return false;
	else return true;
	}
}

function HabCampos() {

  if (document.getElementById('fonte').checked) {
	 document.getElementById('campo_fonte').style.display = "";
	 document.getElementById('campo_elemento').style.display = "none";	 
     document.getElementById('campo_projeto').style.display = "none";	
  }

  if (document.getElementById('elemento').checked) {
	 document.getElementById('campo_elemento').style.display = "";
	 document.getElementById('campo_projeto').style.display = "none";	
	 document.getElementById('campo_fonte').style.display = "none";	 
  }

  if (document.getElementById('projeto').checked) {
	 document.getElementById('campo_projeto').style.display = "";	
	 document.getElementById('campo_fonte').style.display = "none";
	 document.getElementById('campo_elemento').style.display = "none";		 
  }
  
}

function HabCamposProcesso() {

  if (document.getElementById('estado').checked) {
	 document.getElementById('campo_estado').style.display = "";
	 document.getElementById('campo_numero').style.display = "none";	 
     document.getElementById('campo_data').style.display = "none";	
  }

  if (document.getElementById('numero').checked) {
	 document.getElementById('campo_estado').style.display = "none";
	 document.getElementById('campo_numero').style.display = "";	 
     document.getElementById('campo_data').style.display = "none";	
  }

  if (document.getElementById('data').checked) {
	  document.getElementById('campo_estado').style.display = "none";
	 document.getElementById('campo_numero').style.display = "none";	 
     document.getElementById('campo_data').style.display = "";	 
  }
 
 }
 
  function HabCamposFm_Rs() {

  if (document.getElementById('fm').checked) {
	 document.getElementById('campo_fm').style.display = "";
	 document.getElementById('campo_rs').style.display = "none";	
  }

  if (document.getElementById('rs').checked) {
	 document.getElementById('campo_fm').style.display = "none";
	 document.getElementById('campo_rs').style.display = "";	      	       
  }  
  
  if (document.getElementById('fm_rs').checked) {
	 document.getElementById('campo_fm').style.display = "";
	 document.getElementById('campo_rs').style.display = "";	      
  } 
  
}

function chkData() {
  var data = document.getElementsByName('tf_data');  
  var mask ="";
  obj = data.value;
   if (designMode) return;
   if (!obj || obj == "") return;
   if (!mask || mask== "") mask = "dd/MM/yyyy"; 
   var st = cData(obj, mask);
   if (!msg) msg = "";
   if (st == -1) return msgErr(obj, msg + " Deve conter 6 ou 8 números");
   if (st == -2) return msgErr(obj, msg + " Mês inválido");
   if (st == -3) return msgErr(obj, msg + " Dia inválido");
   if (st == -4) return msgErr(obj, msg + " Ano inválido");
   obj =  st;
}

function Verifica_Data(obj){  
//Se o parâmetro obrigatório for igual à zero, significa que elepode estar vazio, caso contrário, não  
	//var f = document.forms['exemplo','frmpublicacao','frmprocesso','frmprocessoOrigem'];	
		//	document.getElementsByName('tf_data');
	    var data = obj.value;
	    var strdata = data;
        //Verifica a quantidade de digitos informada esta correta.  
        if (strdata.length != 10){  
            alert("Formato da data não é válido.Formato correto: dd/mm/aaaa.");  
         //   alert(strdata.length);  
            data.focus();  
            return false;  
        }  
          
        dia = strdata.substr(0,2);  
        mes = strdata.substr(3,2);  
        ano = strdata.substr(6,4);   
        //Verifica o dia  
        if (isNaN(dia) || dia > 31 || dia < 1){  
            alert("Formato do dia não é válido.");  
            data.focus();  
            return false; 
        }  
        if (mes == 4 || mes == 6 || mes == 9 || mes == 11){  
            if (dia == "31"){  
                alert("O mês informado não possui 31 dias.");  
                data.focus();  
                return false;  
            }  
        }  
        if (mes == "02"){  
            bissexto = ano % 4;  
            if (bissexto == 0){  
                if (dia > 29){  
                    alert("O mês informado possui somente 29 dias.");  
                    data.focus();  
                    return false; 
                }  
            }else{  
                if (dia > 28){  
                    alert("O mês informado possui somente 28 dias.");  
                    data.focus();  
                    return false; 
                }  
            }  
        }  
    //Verifica o mês  
        if (isNaN(mes) || mes > 12 || mes < 1){  
            alert("Formato do mês não é válido.");  
            data.focus();  
            return false; 
        }  
        //Verifica o ano  
        if (isNaN(ano)){  
            alert("Formato do ano não é válido.");  
            data.focus();  
            return false;  
        }  
    }   
	
function HabCamposProcessoOrigem() {
		   		
  if (document.getElementById('sim').checked) {
	 document.getElementById('campo_processo_origem').style.display = "";
		
  }else{
  //if (document.getElementById('nao').checked) {
	document.getElementById('campo_processo_origem').style.display = "none";		
	
  }   
  
}

function testeOrigem(){
	var f = document.forms['frmprocesso'];	
	var num = f.combo_processo_origem.value;
	var a = num;
//		alert(a);
	location.href="index.php?pagina=70&processo="+a;
}	

function setDataOrigem(){
	var f = document.forms['frmprocessoOrigem'];
	data = new Date();
	dia = data.getDate();
	mes = data.getMonth() + 1;
	ano = data.getFullYear();
	data = dia+"/"+mes+"/"+ano;
	f.tf_data_lanc_origem.value = data;
}

//HabCamposAFm_Aps
function HabCamposAFm_Aps() {

  if (document.getElementById('afm').checked) {
	 document.getElementById('campo_afm').style.display = "";
	 document.getElementById('campo_aps').style.display = "none";	
  }

  if (document.getElementById('aps').checked) {
	 document.getElementById('campo_afm').style.display = "none";
	 document.getElementById('campo_aps').style.display = "";	      
  }    
}
	
function data_Log(){
	
	var f = document.forms['frmFonte'];	
		
	data = new Date();
	data_time = new Date();
	dia = data.getDate();
	mes = data.getMonth() + 1;
	ano = data.getFullYear();
// Pegando o Horário	
	hora = data_time.getHours();
	min = data_time.getMinutes();
	seg = data_time.getSeconds();
	// 1999-01-08 04:05:06
	data = dia+"/"+mes+"/"+ano;
	data_time = hora+":"+min+":"+seg;
	data = data+" "+data_time;
	f.tf_data_time.value = data;				
}

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){    
       var sep = 0;    
       var key = '';    
       var i = j = 0;    
       var len = len2 = 0;    
       var strCheck = '0123456789';    
       var aux = aux2 = '';    
       var whichCode = (window.Event) ? e.which : e.keyCode;    
       if (whichCode == 13 || whichCode == 8) return true;    
       key = String.fromCharCode(whichCode); // Valor para o código da Chave    
       if (strCheck.indexOf(key) == -1) return false; // Chave inválida    
       len = objTextBox.value.length;    
       for(i = 0; i < len; i++)    
           if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;    
       aux = '';    
       for(; i < len; i++)    
           if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);    
       aux += key;    
       len = aux.length;    
       if (len == 0) objTextBox.value = '';    
       if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;    
       if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;    
       if (len > 2) {    
           aux2 = '';    
           for (j = 0, i = len - 3; i >= 0; i--) {    
               if (j == 3) {    
                   aux2 += SeparadorMilesimo;    
                   j = 0;    
               }    
               aux2 += aux.charAt(i);    
               j++;    
           }    
           objTextBox.value = '';    
           len2 = aux2.length;    
           for (i = len2 - 1; i >= 0; i--)    
           objTextBox.value += aux2.charAt(i);    
           objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);    
       }    
        return false;    
   }  	
   
function HabCampoOficio() {

  if (document.getElementById('oficio').checked) {
	 document.getElementById('campo_oficio').style.display = "";
	 document.getElementById('campo_ci').style.display = "none";	
  }

  if (document.getElementById('ci').checked) {
	 document.getElementById('campo_oficio').style.display = "none";
	 document.getElementById('campo_ci').style.display = "";	      
  }     
}

function popup(url, nwidth, nheight) {
			var width = nwidth;
			var height = nheight;
			var left = (screen.width - width)/2;
			var top = (screen.height - height)/2;
			var params = 'width='+width+', height='+height;
			params += ', top='+top+', left='+left;
			params += ', directories=no';
			params += ', location=no';
			params += ', menubar=no';
			params += ', resizable=yes';
			params += ', scrollbars=yes';
			params += ', status=no';
			params += ', toolbar=no';
			newwin = window.open(url, 'titulo', params);
			if(window.focus) {
				newwin.focus();
			}
			return false;
}  

function cadastroRM(){
var url = "cadastro_rm.php";
 popup(url, 800, 600);
}    

 function Telefone(objeto){ 
   if(objeto.value.length == 0)
     objeto.value = '(' + objeto.value;

   if(objeto.value.length == 3)
      objeto.value = objeto.value + ')';

 if(objeto.value.length == 8)
     objeto.value = objeto.value + '-';
}

function FormataCnpj(campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace("/", "");
	vr = vr.replace("-", "");
	tam = vr.length + 1;
	if (tecla != 14){
		if (tam == 3)
			campo.value = vr.substr(0, 2) + '.';
		if (tam == 6)
			campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 5) + '.';
		if (tam == 10)
			campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(6, 3) + '/';
		if (tam == 15)
			campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(6, 3) + '/' + vr.substr(9, 4) + '-' + vr.substr(13, 2);
	}
}