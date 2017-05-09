/****************************************************************
	esconder objeto id
***************************************************************/

function esconde_obj_id(p_objname)
{   
    p_objname.style.display = 'none';
    //return true;
}

/****************************************************************
	mostra objeto id
***************************************************************/
function mostra_obj_id(p_objname)
{   
    p_objname.style.display = 'block';
    //return true
}

/****************************************************************
	conta os caracteres de um campo
***************************************************************/
function ContarJustificativaFeriado(Campo,Limite)
{
	if((Limite-Campo.value.length) <= 0)
	{
   		alert('Aten\u00E7\u00E3o! Voc\u00EA atingiu o limite m\u00E1ximo de caracteres!');
   		Campo.value = Campo.value.substr(0,Limite);
	}

	document.getElementById("QtdFeriado").value = Campo.value.length
}

function ContarJustificativaFimSemana(Campo,Limite)
{
	if((Limite-Campo.value.length) <= 0)
	{
   		alert('Aten\u00E7\u00E3o! Voc\u00EA atingiu o limite m\u00E1ximo de caracteres!');
   		Campo.value = Campo.value.substr(0,Limite);
	}

	document.getElementById("QtdFimSemana").value = Campo.value.length
}

function ContarComplemento(Campo,Limite)
{
	if((Limite-Campo.value.length) <= 0)
	{
   		alert('Aten\u00E7\u00E3o! Voc\u00EA atingiu o limite m\u00E1ximo de caracteres!');
   		Campo.value = Campo.value.substr(0,Limite);
	}

	document.getElementById("QtdeComplemento").value = Campo.value.length
}

function ContarDescricao(Campo,Limite)
{
	if((Limite-Campo.value.length) <= 0)
	{
   		alert('Aten\u00E7\u00E3o! Voc\u00EA atingiu o limite m\u00E1ximo de caracteres!');
   		Campo.value = Campo.value.substr(0,Limite);
	}

	document.getElementById("QtdDescricao").value = Campo.value.length
}

function ContarResumo(Campo,Limite)
{
	if((Limite-Campo.value.length) <= 0)
	{
   		alert('Aten\u00E7\u00E3o! Voc\u00EA atingiu o limite m\u00E1ximo de caracteres!');
   		Campo.value = Campo.value.substr(0,Limite);
	}

	document.getElementById("QtdResumo").value = Campo.value.length
}

function ContarResumoLinha(content)
{
	var i=0;
 	var numberofwords=1;

 	while(i<=content.length) 
 	{

  		if (content.substring(i,i+1) == "\n") 
		{
   			numberofwords++;
		   i++;
	 	}

  		i++;
		
		if (numberofwords == 26)
		{
			alert('Aten\u00E7\u00E3o! Voc\u00EA atingiu o limite m\u00E1ximo de linhas!');
			return false;
		}
	}
//	document.getElementById("QtdLinha").value = numberofwords;

}

/****************************************************************
	mascara de data
***************************************************************/
function mascaraData(data,frm){ 
	var mydata = '';
		mydata = mydata + data; 
	if (mydata.length == 2){ 
		mydata = mydata + '/'; 
		frm.value = mydata; 
	} 
	if (mydata.length == 5){ 
		mydata = mydata + '/'; 
		frm.value = mydata; 
	} 
	if (mydata.length == 10){ 
		verificaData(frm); 
	} 
} 

/****************************************************************
	mascara de hora
***************************************************************/
function mascaraHora(hora,frm){ 
	var myhora = '';
		myhora = myhora + hora; 
	if (myhora.length == 2){ 
		myhora = myhora + ':'; 
		frm.value = myhora; 
	} 
	if (myhora.length == 5){ 
		verificaHora(frm); 
	} 
} 

         
/****************************************************************
	verifica data
***************************************************************/		   
function verificaData (frm) 
{ 

	dia = (frm.value.substring(0,2)); 
	mes = (frm.value.substring(3,5)); 
	ano = (frm.value.substring(6,10)); 

	situacao = ""; 
	// verifica o dia valido para cada mes 
	if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31) { 
		situacao = "falsa"; 
	} 
	// verifica se o mes e valido 
	if (mes < 01 || mes > 12 ) { 
		situacao = "falsa"; 
	} 
	// verifica se e ano bissexto 
	if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
		situacao = "falsa"; 
	}     
	if (frm.value == "") { 
		situacao = "falsa"; 
	}     
	if (situacao == "falsa") { 
		alert("Data informada \u00E9 inv\u00E1lida!"); 
		frm.style.backgroundColor='#B9DCFF';		
		frm.focus(); 
	} 
} 
	

/****************************************************************
	verifica hora
***************************************************************/		   
function verificaHora (frm) 
{ 

	  hrs = (frm.value.substring(0,2)); 
	  min = (frm.value.substring(3,5)); 
	   
	  situacao = ""; 
	  // verifica data e hora 
	  if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59)){ 
		  situacao = "falsa"; 
	  } 
	   
	  if (frm.value == "") { 
		  situacao = "falsa"; 
	  } 

	if (situacao == "falsa") { 
		alert("Formato da HORA \u00E9 inv\u00E1lida!"); 
		frm.style.backgroundColor='#B9DCFF';		
		frm.focus(); 
	} 
 
} 

/****************************************************************
	mascara de cpf
***************************************************************/
function mascaraCPF(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);

	caracteres = '0123456789';
	separacao1 = '.';
	separacao2 = '-';
	conjunto1 = 3;
	conjunto2 = 7;
	conjunto3 = 11;
	
	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (14))
	{
		if (campo.value.length == conjunto1)
		campo.value = campo.value + separacao1;
		else if (campo.value.length == conjunto2)
		campo.value = campo.value + separacao1;
		else if (campo.value.length == conjunto3)
		campo.value = campo.value + separacao2;
	}
	else
		event.returnValue = false;

}

/****************************************************************
	mascara de cnpj
***************************************************************/
function mascaraCNPJ(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);

	caracteres = '0123456789';
	separacao1 = '.';
	separacao2 = '-';
	separacao3 = '/';	
	conjunto1 = 2;
	conjunto2 = 6;
	conjunto3 = 10;
	conjunto4 = 15;
	
	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (18))
	{
		if (campo.value.length == conjunto1 )
		campo.value = campo.value + separacao1;
		else if (campo.value.length == conjunto2)
		campo.value = campo.value + separacao1;
		else if (campo.value.length == conjunto3)
		campo.value = campo.value + separacao3;
		else if (campo.value.length == conjunto4)
		campo.value = campo.value + separacao2;		
	}
	else
		event.returnValue = false;

}

/****************************************************************
	mascara de cep
***************************************************************/
function mascaraCEP(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);

	caracteres = '0123456789';
	separacao1 = '-';
    conjunto1 = 5;
	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (14))
	{
		if (campo.value.length == conjunto1 )
		    campo.value = campo.value + separacao1;
	}
	else
		event.returnValue = false;
}

/****************************************************************
	mascara de telefone
***************************************************************/
function mascaraTelefone(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);
	caracteres = '0123456789';
	separacao1 = '-';
	conjunto1 = 4;
	
	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (9))
	{
		if (campo.value.length == conjunto1 )
		campo.value = campo.value + separacao1;
	}
	else
		event.returnValue = false;
}

/****************************************************************
	mascara que verifica documentos numericos
***************************************************************/
function mascaraNumero(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);

	caracteres = '0123456789';

	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (30))
	{
		campo.value = campo.value;
	}
	else
		event.returnValue = false;

}
/****************************************************************
	mascara aceita digitar apenas numeros
***************************************************************/
function mascaraDigitaApenasNumero(numero){
	var tecla=(window.event)?event.keyCode:numero.which;
	if((tecla > 47 && tecla < 58)) return true;
	else{
		if (tecla != 8) return false;
	else return true;
	}
}

/****************************************************************
	mascara que verifica documentos com valor
***************************************************************/
function mascaraValor(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);

	caracteres = ',.0123456789';

	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (11))
	{
		campo.value = campo.value;
	}
	else
		event.returnValue = false;

}

/****************************************************************
	mascara que verifica documentos com letra
***************************************************************/
function mascaraLetra(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);

	caracteres = 'ABCDEabcde';

	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (11))
	{
		campo.value = campo.value;
	}
	else
		event.returnValue = false;

}

/**************************************************************
 Funcao que marca ou desmarca todos os Checkbox do Formulario
 Parametros : pformulario --> Nome do Formulario 
              pmarca      --> Se true ele marca todos 
			                  Se false ele desmarca todos
*************************************************************/							  

function MarcaCheckbox(checkbox)
{ 
  if (typeof(checkbox.length)== 'undefined')
    checkbox.checked = true;
  else
  {
      for (i = 0 ; i < checkbox.length ; i++)
         checkbox[i].checked = true;
  }
}

function DesmarcaCheckbox(checkbox)
{ 
  if (typeof(checkbox.length)== 'undefined')
    checkbox.checked = false;
  else
  {
      for (i = 0 ; i < checkbox.length ; i++)
         checkbox[i].checked = false;
  }
}



/*********************************************************************************
    Muda cor da Linha na tabela para as listas
**********************************************************************************/

var marked_row = new Array;

function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function

/*
 * Sets/unsets the pointer and marker in vertical browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 *
 * @author Garvin Hicking <me@supergarv.de> (rewrite of setPointer.)
 */
function setVerticalPointer(theRow, theRowNum, theAction, theDefaultColor1, theDefaultColor2, thePointerColor, theMarkColor) {
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;

    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        domDetect    = false;
    } // end 3

    var c = null;
    // 5.1 ... with DOM compatible browsers except Opera
    for (c = 0; c < rowCellsCnt; c++) {
        if (domDetect) {
            currentColor = theCells[c].getAttribute('bgcolor');
        } else {
            currentColor = theCells[c].style.backgroundColor;
        }

        // 4. Defines the new color
        // 4.1 Current color is the default one
        if (currentColor == ''
            || currentColor.toLowerCase() == theDefaultColor1.toLowerCase() 
            || currentColor.toLowerCase() == theDefaultColor2.toLowerCase()) {
            if (theAction == 'over' && thePointerColor != '') {
                newColor              = thePointerColor;
            } else if (theAction == 'click' && theMarkColor != '') {
                newColor              = theMarkColor;
                marked_row[theRowNum] = true;
            }
        }
        // 4.1.2 Current color is the pointer one
        else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
                 && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
            if (theAction == 'out') {
                if (c % 2) {
                    newColor              = theDefaultColor1;
                } else {
                    newColor              = theDefaultColor2;
                }
            }
            else if (theAction == 'click' && theMarkColor != '') {
                newColor              = theMarkColor;
                marked_row[theRowNum] = true;
            }
        }
        // 4.1.3 Current color is the marker one
        else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
            if (theAction == 'click') {
                newColor              = (thePointerColor != '')
                                      ? thePointerColor
                                      : ((c % 2) ? theDefaultColor1 : theDefaultColor2);
                marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                      ? true
                                      : null;
            }
        } // end 4

        // 5. Sets the new color...
        if (newColor) {
            if (domDetect) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            }
            // 5.2 ... with other browsers
            else {
                theCells[c].style.backgroundColor = newColor;
            }
        } // end 5
    } // end for

     return true;
}

/**************************************************************
Valida CNPJ
***************************************************************/

function validaCNPJ(frm)
{ 

	 CNPJ = frm.value; 
	 erro = new String;
	 if (CNPJ.length < 18) erro += "\u00C9 necessario preencher corretamente o n\u00FAmero do CNPJ! \n\n"; 
	 if ((CNPJ.charAt(2) != ".") || (CNPJ.charAt(6) != ".") || (CNPJ.charAt(10) != "/") || (CNPJ.charAt(15) != "-")){
	 if (erro.length == 0) erro += "\u00C9 necessario preencher corretamente o n\u00FAmero do CNPJ! \n\n";
	 }
	 //substituir os caracteres que n�o s�o n�meros
   if(document.layers && parseInt(navigator.appVersion) == 4){
		   x = CNPJ.substring(0,2);
		   x += CNPJ. substring (3,6);
		   x += CNPJ. substring (7,10);
		   x += CNPJ. substring (11,15);
		   x += CNPJ. substring (16,18);
		   CNPJ = x; 
   } else {
		   CNPJ = CNPJ. replace (".","");
		   CNPJ = CNPJ. replace (".","");
		   CNPJ = CNPJ. replace ("-","");
		   CNPJ = CNPJ. replace ("/","");
   }
   var nonNumbers = /\D/;
   if (nonNumbers.test(CNPJ)) erro += "A verifica\u00E7\u00E3o de CNPJ suporta apenas n\u00FAmeros! \n\n"; 
   var a = [];
   var b = new Number;
   var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
   for (i=0; i<12; i++){
		   a[i] = CNPJ.charAt(i);
		   b += a[i] * c[i+1];
}
   if ((x = b % 11) < 2) {a[12] = 0} else {a[12] = 11-x}
   b = 0;
   for (y=0; y<13; y++) {
		   b += (a[y] * c[y]); 
   }
   if ((x = b % 11) < 2) {a[13] = 0;} else {a[13] = 11-x;}
   if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
		   erro +="CNPJ inv\u00E1lido!";
   }
   if (erro.length > 0){
		   alert(erro);
		   return false;
   } else {
		   alert("CNPJ v\u00E1lido!");
   }
   return true;
}

/**************************************************************
Verifica CPF
***************************************************************/

function Verifica_CPF(formulario) {
var CPF = formulario.txtCPF.value; // Recebe o valor digitado no campo

CPF = CPF. replace (".","");
CPF = CPF. replace (".","");
CPF = CPF. replace ("-","");

// Aqui come�a a checagem do CPF
var POSICAO, I, SOMA, DV, DV_INFORMADO;
var DIGITO = new Array(10);
DV_INFORMADO = CPF.substr(9, 2); // Retira os dois �ltimos d�gitos do n�mero informado

// Desemembra o n�mero do CPF na array DIGITO
for (I=0; I<=8; I++) {
  DIGITO[I] = CPF.substr( I, 1);
}

// Calcula o valor do 10� d�gito da verifica��o
POSICAO = 10;
SOMA = 0;
   for (I=0; I<=8; I++) {
      SOMA = SOMA + DIGITO[I] * POSICAO;
      POSICAO = POSICAO - 1;
   }
DIGITO[9] = SOMA % 11;
   if (DIGITO[9] < 2) {
        DIGITO[9] = 0;
}
   else{
       DIGITO[9] = 11 - DIGITO[9];
}

// Calcula o valor do 11� d�gito da verifica��o
POSICAO = 11;
SOMA = 0;
   for (I=0; I<=9; I++) {
      SOMA = SOMA + DIGITO[I] * POSICAO;
      POSICAO = POSICAO - 1;
   }
DIGITO[10] = SOMA % 11;
   if (DIGITO[10] < 2) {
        DIGITO[10] = 0;
   }
   else {
        DIGITO[10] = 11 - DIGITO[10];
   }

// Verifica se os valores dos d�gitos verificadores conferem
DV = DIGITO[9] * 10 + DIGITO[10];
  
  
  if ((CPF.length > 11)||(CPF.length < 11) ) {
      alert('CPF inv\u00E1lido');
      formulario.txtCPF.value = '';
      formulario.txtCPF.focus();
      return false;
   } 
  
  if (DV != DV_INFORMADO) {
      alert('CPF inv\u00E1lido');
      formulario.txtCPF.value = '';
      formulario.txtCPF.focus();
      return false;
   } 
   return true;
}

/**
 * Seleciona todos os checkbox cujo atributo <i>name</i> seja o valor recebido como parametro
 * 
 * @param check <p>Elemento HTML checkbox responsável por marcar/desmarcar os outros checkbox</p>
 * @param name <p>Valor do atributo <i>name</i> dos checkbox que devem ser selecionados</p>
 */

function selecionarTodos(check,name){
    
    var elementos = document.getElementsByName(name);
    
    if(check.checked){
        for(i=0; i< elementos.length; i++){
            elementos[i].checked = "checked";
        }
    } else {
        for(i=0; i< elementos.length; i++){
            elementos[i].checked = false;
        }
    }

}
