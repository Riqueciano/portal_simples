/*******************************************************************************
        FUNÇÕES QUE RETORNAM O DIA DA SEMANA REFERENTE A DATA PASSADA.
*******************************************************************************/
function MakeArray(n)
{
    this.length = n;
    for (var i = 1; i <=n; i++) 
    {
        this[i] = 0;
    }
}

var days = new MakeArray(7);
days[0] = "Sábado"
days[1] = "Domingo"
days[2] = "Segunda-Feira"
days[3] = "Terça-Feira"
days[4] = "Quarta-Feira"
days[5] = "Quinta-Feira"
days[6] = "Sexta-Feira"

function RetornaDiaSemana(id, id_retorno) 
{
    var val1  = parseInt($('#'+id).val().substring(0,2), 10);
    var val2  = parseInt($('#'+id).val().substring(3,5), 10);
    var val2x = parseInt($('#'+id).val().substring(3,5), 10);
    var val3  = parseInt($('#'+id).val().substring(6,10), 10);

    if (val2 == 1) 
    {
        val2x = 13;
        val3 = val3-1;
    }
    if (val2 == 2) 
    {
        val2x = 14;
        val3 = val3-1;
    }
    
    var val4 = parseInt(((val2x+1)*3)/5, 10);
    var val5 = parseInt(val3/4, 10);
    var val6 = parseInt(val3/100, 10);
    var val7 = parseInt(val3/400, 10);
    var val8 = val1+(val2x*2)+val4+val3+val5-val6+val7+2;
    var val9 = parseInt(val8/7, 10);
    var val0 = val8-(val9*7);
	
    $('#'+id_retorno).attr('value',days[val0]);
}
/*******************************************************************************
                    FUNÇÃO QUE ESCONDE O OBJETO
*******************************************************************************/
function esconde_obj_id(p_objname)
{   
    p_objname.style.display = 'none';
}
/*******************************************************************************
                    FUNÇÃO QUE MOSTRA O OBJETO
*******************************************************************************/
function mostra_obj_id(p_objname)
{   
    p_objname.style.display = 'block';
}
/*******************************************************************************
                    FUNÇÃO QUE CONTA OS CARACTERES
*******************************************************************************/
function ContarCaracteres(Campo,Limite, Mensagem, ObjID)
{
    if((Limite-Campo.value.length) <= 0)
    {
        alert(Mensagem);
        Campo.value = Campo.value.substr(0,Limite);
    }
    document.getElementById(ObjID).value = Campo.value.length
}
/*******************************************************************************
            FUNÇÃO QUE CONTA A QUANTIDADE DE LINHAS DO RESUMO
*******************************************************************************/
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
            alert('Atenção! Você atingiu o limite máximo de linhas!');
            return false;
        }
    }
    document.getElementById("QtdLinha").value = numberofwords;
    return true;

}
/*******************************************************************************
                    FUNÇÃO QUE CRIA A MÁSCARA DA DATA
*******************************************************************************/
function mascaraData(data,frm)
{ 
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
/*******************************************************************************
                    FUNÇÃO QUE CRIA A MÁSCARA DA HORA
*******************************************************************************/
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
/*******************************************************************************
                    FUNÇÃO QUE REALIZA A VERIFICAÇÃO DA DATA
*******************************************************************************/
function verificaData (frm) 
{ 
    dia = (frm.value.substring(0,2));
    mes = (frm.value.substring(3,5));
    ano = (frm.value.substring(6,10));

    situacao = "";
    // verifica o dia valido para cada mes
    if ((dia < 01) || (dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || (dia > 31)) {
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
        alert("Data informada é inválida!");
        frm.style.backgroundColor='#B9DCFF';
        frm.focus();
    }
} 
/*******************************************************************************
                    FUNÇÃO QUE REALIZA A VERIFICAÇÃO DA HORA
*******************************************************************************/
function verificaHora (frm) 
{
    if (frm.value != '__:__')
    {
        var hrs = frm.value.substring(0,2);
        var min = frm.value.substring(3,5);
        var situacao = true;
        // verifica data e hora
        if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59))
        {
            situacao = false;
        }
        if (frm.value == "")
        {
            situacao = false;
        }
        if (situacao == false)
        {
            alert("Formato da HORA é inválida!");
            frm.style.backgroundColor='#B9DCFF';
            frm.value = '';
            frm.focus();
        }
    }
} 
/*******************************************************************************
                    FUNÇÃO UTILIZAR UMA MÁCARA PARA O CPF
*******************************************************************************/
function mascaraCPF(evento, objeto)
{
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
//FUNÇÃO QUE REMOVE OS CARACTERES INVÁLIDOS PASSADOS PELA SUA CHAMADA
function LimparCaracteresInvalidos(valor, validos)
{
    // retira caracteres invalidos da string
    var result = "";
    var aux;
    for (var i=0; i < valor.length; i++)
    {
        aux = validos.indexOf(valor.substring(i, i+1));
        if (aux>=0)
        {
            result += aux;
        }
    }
    return result;
}
//Formata número tipo moeda usando o evento onKeyDown
function Formata(campo,tammax,teclapres,decimal)
{
    var tecla = teclapres.keyCode;
    var vr = LimparCaracteresInvalidos(campo.value,"0123456789");
    var tam = vr.length;
    var dec=decimal

    if (tam < tammax && tecla != 8)
    {
        tam = vr.length + 1 ;
    }
    if (tecla == 8 )
    {
        tam = tam - 1 ;
    }

    if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
    {
        if ( tam <= dec )
        {
            campo.value = vr ;
        }

        if (tam > dec)// && (tam <= 5))
        {
            campo.value = vr.substr( 0, tam - 2 ) + "." +
            vr.substr( tam - dec, tam ) ;
        }
        //COMO ESTÁ FUNÇÃO ESTA SENDO APENAS USADA PARA COTAÇÃO DO DOLAR E O BANCO
        //ESTÁ SENDO GRAVADO COM VALOR REAL VOU MODIFICAR A VÍRGULA ACIMA POR UM PONTO.
    //    if ( (tam >= 6) && (tam <= 8) ){
    //    campo.value = vr.substr( 0, tam - 5 ) + "." +
    //    vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;
    //    }
    //    if ( (tam >= 9) && (tam <= 11) ){
    //    campo.value = vr.substr( 0, tam - 8 ) + "." +
    //    vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," +
    //    vr.substr( tam - dec, tam ) ; }
    //    if ( (tam >= 12) && (tam <= 14) ){
    //    campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) +
    //     "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," +
    //     vr.substr( tam - dec, tam ) ; }
    //    if ( (tam >= 15) && (tam <= 17) ){
    //    campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) +
    //     "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." +
    //     vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
    }
}
/*******************************************************************************
                    FUNÇÃO UTILIZAR UMA MÁCARA PARA O CNPJ
*******************************************************************************/
function mascaraCNPJ(evento, objeto)
{
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
/*******************************************************************************
                    FUNÇÃO UTILIZAR UMA MÁCARA PARA O CEP
*******************************************************************************/
function mascaraCEP(evento, objeto)
{
    var keypress=(window.event)?event.keyCode:evento.which;
    campo = eval (objeto);

    caracteres = '0123456789';
    separacao1 = '-';
    conjunto1 = 5;
    if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (14))
    {
        if (campo.value.length == conjunto1 )
        {campo.value = campo.value + separacao1;}
    }
    else{event.returnValue = false;}
}
/*******************************************************************************
                    FUNÇÃO UTILIZAR UMA MÁCARA PARA O TELEFONE
*******************************************************************************/
function mascaraTelefone(evento, objeto)
{
    var keypress=(window.event)?event.keyCode:evento.which;
    campo = eval (objeto);
    caracteres = '0123456789';
    separacao1 = '-';
    conjunto1 = 4;
	
    if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (9))
    {
        if (campo.value.length == conjunto1 )
        {campo.value = campo.value + separacao1;}
    }
    else{event.returnValue = false;}
}
/*******************************************************************************
                    FUNÇÃO PARA DIGITAR APENAS NÚMEROS
*******************************************************************************/
function mascaraNumero(evento, objeto)
{
    var keypress=(window.event)?event.keyCode:evento.which;
    campo = eval (objeto);

    caracteres = '0123456789';

    if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (30))
    {campo.value = campo.value;}
    else
    {event.returnValue = false;}

}
/*******************************************************************************
                    FUNÇÃO PARA DIGITAR APENAS NÚMEROS
*******************************************************************************/
function mascaraDigitaApenasNumero(numero)
{
    var tecla=(window.event)?event.keyCode:numero.which;
    if((tecla > 47 && tecla < 58)) return true;
    else
    {
        if (tecla != 8) return false;
        else return true;
    }
}
/*******************************************************************************
                FUNÇÃO QUE CRIA UMA MÁSCARA PARA VALORES
*******************************************************************************/
function mascaraValor(evento, objeto)
{
    var keypress=(window.event)?event.keyCode:evento.which;
    campo = eval (objeto);

    caracteres = ',.0123456789';

    if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (11))
    {campo.value = campo.value;}
    else
    {event.returnValue = false;}
}
/*******************************************************************************
                    FUNÇÃO PARA PERMITIR APENAS LETRAS
*******************************************************************************/
function mascaraLetra(evento, objeto)
{
    var keypress=(window.event)?event.keyCode:evento.which;
    campo = eval (objeto);

    caracteres = 'ABCDEabcde';

    if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (11))
    {campo.value = campo.value;}
    else
    {event.returnValue = false;}
}
/*******************************************************************************
                    FUNÇÃO PARA MARCAR TODOS OS CHECKBOX
*******************************************************************************/
function MarcaCheckbox(checkbox)
{ 
    if (checkbox != undefined)
    {        
        if (typeof(checkbox.length)== 'undefined')
        {
            checkbox.checked = true;
        }
        else 
        {
            for (i = 0 ; i < checkbox.length ; i++)
            {
                checkbox[i].checked = true;
            }
        }
    }
}
/*******************************************************************************
                    FUNÇÃO PARA DESMARCAR TODOS OS CHECKBOX
*******************************************************************************/
function DesmarcaCheckbox(checkbox)
{ 
    if (checkbox != undefined)
    {
        if (typeof(checkbox.length)== 'undefined')
        {
            checkbox.checked = false;
        }
        else
        {
            for (i = 0 ; i < checkbox.length ; i++)
            {
                checkbox[i].checked = false;
            }
        }
    }
}
/*******************************************************************************
    FUNÇÃO PARA EXCLUSÃO DE MULTIPLOS CAMPOS PERMITE QUE OS REGISTROS 
    QUE FORAM MARCADOS PARA SEREM EXCLUÍDOS SEJAM EXIBIDOS NA PÁGINA 
                            DE EXCLUSÃO
*******************************************************************************/
function ExcluirMultiplo(frm, checkbox, pagina)
{
    //VARIAVEIS PARA EXECUÇÃO DA FUNÇÃO
    var cont = 0, multiplos = "", qtdcheckbox = "", qtdElementosCheckbox = 0;

    //VERIFICA SE O USUARIO SETOU APENAS UM CHECK BOX
    if (checkbox.length == undefined)
    {
        //DEFINE A QUANTIDADE DE ELEMENTOS COMO 1
        qtdElementosCheckbox = 1;

        //VERIRIFCA SE REALMENTE ESTA CHECADO
        if (checkbox.checked == true)
        {
            //INICIA A CRIAÇÃO DA URL
            multiplos += "&checkbox="+checkbox.value;

            //CAPTURA QUE FOI SETADO UM CHECKBOX
            cont = cont + 1;
        }
    }
    //VERIFICA SE O USUARIO SETOU MAIS DE UM CHECK BOX
    else if (checkbox.length >= 2)
    {
        //CAPTURA A QUANTIDADE TOTAL DE ELEMENTOS CHECKBOX DO FORM
        qtdElementosCheckbox = checkbox.length;

        //VERIFICA TODOS OS ELEMENTOS CHECKBOX DO FORM
        for (i = 0 ; i < qtdElementosCheckbox ; i++)
        {
            //VERIFICA SE O ELEMENTO ESTÁ MARCADO
            if (checkbox[i].checked == true)
            {
                //CRIA A URL DE DELEÇÃO
                multiplos += "&checkbox"+i+"="+checkbox[i].value;

                //INCREMENTE A QUANTIDADE DE BOX ENCONTRADOS
                cont = cont + 1;
            }
        }
    }

    //SE NÃO FOR ENCONTRADO NENHUM CHEKBOX MARCADO
    if (cont == 0)
    {
        //APRESENTA MENSAGEM AO USUARIO
        alert("Escolha pelo menos um Registro.");
    }
    else
    {
        //CAPTURA A QUANTIDADE DE ELEMENTOS MARCADOS
        qtdcheckbox = "&qtdcheckbox"+"="+qtdElementosCheckbox;

        //ATRIBUI A AÇÃO DO FORMULARIO
        frm.action = pagina+"Excluir.php?excluirMultiplo=1"+multiplos+qtdcheckbox;

        //SUBMETE O FORMULARIO
        frm.submit();
    }
}
/*******************************************************************************
                FUNÇÃO PARA REALIZAR A VALIDAÇÃO DO CNPJ
*******************************************************************************/
function validaCNPJ(frm)
{ 

    CNPJ = frm.value;
    erro = new String;
    if (CNPJ.length < 18) erro += "É necessario preencher corretamente o número do CNPJ! \n\n";
    if ((CNPJ.charAt(2) != ".") || (CNPJ.charAt(6) != ".") || (CNPJ.charAt(10) != "/") || (CNPJ.charAt(15) != "-")){
        if (erro.length == 0) erro += "É necessário preencher corretamente o número do CNPJ! \n\n";
    }

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
    if (nonNumbers.test(CNPJ)) erro += "A verificação de CNPJ suporta apenas números! \n\n";
    var a = [];
    var b = new Number;
    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
    for (i=0; i<12; i++){
        a[i] = CNPJ.charAt(i);
        b += a[i] * c[i+1];
    }
    if ((x = b % 11) < 2) {
        a[12] = 0
    } else {
        a[12] = 11-x
    }
    b = 0;
    for (y=0; y<13; y++) {
        b += (a[y] * c[y]);
    }
    if ((x = b % 11) < 2) {
        a[13] = 0;
    } else {
        a[13] = 11-x;
    }
    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
        erro +="CNPJ invalido!";
    }
    if (erro.length > 0){
        alert(erro);
        return false;
    } 
    return true;
}
/*******************************************************************************
                    FUNÇÃO PARA REALIZAR A VERIFICAÇÃO DO CEP
*******************************************************************************/
function Verifica_CPF(formulario) {
    var CPF = formulario.txtCPF.value; 

    CPF = CPF. replace (".","");
    CPF = CPF. replace (".","");
    CPF = CPF. replace ("-","");

    var POSICAO, I, SOMA, DV, DV_INFORMADO;
    var DIGITO = new Array(10);
    DV_INFORMADO = CPF.substr(9, 2);

    for (I=0; I<=8; I++) {
        DIGITO[I] = CPF.substr( I, 1);
    }


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

    DV = DIGITO[9] * 10 + DIGITO[10];
  
  
    if ((CPF.length > 11)||(CPF.length < 11) ) {
        alert('CPF inválido');
        formulario.txtCPF.value = '';
        formulario.txtCPF.focus();
        return false;
    }
  
    if (DV != DV_INFORMADO) {
        alert('CPF inválido');
        formulario.txtCPF.value = '';
        formulario.txtCPF.focus();
        return false;
    }
    return true;
}
/*******************************************************************************
        FUNÇÃO PARA REMOVER OS ESPAÇOS DO COMEÇO E DO FIM DA STRING
*******************************************************************************/
function Trim(str)
{
    return str.replace(/^\s+|\s+$/g,"");
}
/*******************************************************************************
            FUNÇÃO PARA CRIAR UMA MÁSCARA PARA VALORES (MOEDA)
*******************************************************************************/
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e)
{
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
	
    if (whichCode == 13) return true;
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
            if (j == 3) 
            {
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
/*******************************************************************************
                FUNÇÃO QUE EXIBE AS MENSAGENS DE ERRO DOS SISTEMAS.
 *******************************************************************************/
function MsgErro (Mensagem)
{
    //SETANDO O ATRIBUTO STYLE NO SPAN COM ID #ERRO
    $("#erro").attr('style', 'display: inline');
    //SETANDO O ATRIBUTO CLASS NO SPAN COM ID #ERRO
    $("#erro").attr('class', 'MensagemErro');
    //SETANDO A MENSAGEM NO SPAN COM ID #ERRO
    $("#erro").html(Mensagem);
}
/*******************************************************************************
            FUNÇÃO QUE EXIBE A DIV DO POPUP E SUAS INFORMAÇÕES.
*******************************************************************************/
function MostrarDivPopUp (StringRetorno, Display)
{
    if (Display == "")
    {
        Display = 'none;';
    }
    var id = '#Informacoes';
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    $('#DivModalPreta').css({'width':maskWidth,'height':maskHeight});

    $('#DivModalPreta').fadeTo(100,0.3);  

    //Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();

    $(id).css('top',  winH/2);
    $(id).css('left', winW/2-$(id).width()/2);

    $(id).fadeIn(200); 
    
    //EXIBIR OU OCULTAR O BOTÃO DE FECHAR O POPUP
    $('#BotaoFechar').attr('style','display: '+Display+';');
    //RETORNO QUE SERÁ EXIBIDO NO POPUP;
    $('#InformacoesRetorno').html(StringRetorno);

    $('.Janela .Fechar').click(function (e) 
    {
        e.preventDefault();
        $('#DivModalPreta').hide();
        $('.Janela').hide();
    });
    $(id).focus();
}