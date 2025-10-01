
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function txtBoxFormat(strField, sMask, evtKeyPress) {
    /*
     * Descrição.: formata um campo do formulário de
     * acordo com a máscara informada...
     * Parâmetros: - objForm (o Objeto Form)
     * - strField (string contendo o nome
     * do textbox)
     * - sMask (mascara que define o
     * formato que o dado será apresentado,
     * usando o algarismo "9" para
     * definir números e o símbolo "!" para
     * qualquer caracter...
     * - evtKeyPress (evento)
     * Uso.......: <input type="textbox"
     * name="xxx".....
     * onkeypress="return txtBoxFormat(document.rcfDownload, 'str_cep', '99999-999', event);">
     * Observação: As máscaras podem ser representadas como os exemplos abaixo:
     * CEP -> 99.999-999
     * CPF -> 999.999.999-99
     * CNPJ -> 99.999.999/9999-99
     * Data -> 99/99/9999
     * Tel Resid -> (99) 999-9999
     * Tel Cel -> (99) 9999-9999
     * Processo -> 99.999999999/999-99
     * C/C -> 999999-!
     * E por aí vai...
     */

    var i, nCount, sValue, fldLen, mskLen, bolMask, sCod, nTecla;


    if (window.event) { // Internet Explorer
        nTecla = evtKeyPress.keyCode;
    } else if (evtKeyPress.which) { // Nestcape / firefox
        nTecla = evtKeyPress.which;
    }

    //se for backspace não faz nada
    if (nTecla != 8) {
        sValue = document.getElementById(strField).value;
        // alert(sValue);
        // Limpa todos os caracteres de formatação que
        // já estiverem no campo.
        sValue = sValue.toString().replace("-", "");
        sValue = sValue.toString().replace("-", "");
        sValue = sValue.toString().replace(".", "");
        sValue = sValue.toString().replace(".", "");
        sValue = sValue.toString().replace("/", "");
        sValue = sValue.toString().replace("/", "");
        sValue = sValue.toString().replace("(", "");
        sValue = sValue.toString().replace("(", "");
        sValue = sValue.toString().replace(")", "");
        sValue = sValue.toString().replace(")", "");
        sValue = sValue.toString().replace(" ", "");
        sValue = sValue.toString().replace(" ", "");
        sValue = sValue.toString().replace(":", "");
        sValue = sValue.toString().replace(":", "");
        sValue = sValue.toString().replace(",", "");
        sValue = sValue.toString().replace(",", "");
        fldLen = sValue.length;
        mskLen = sMask.length;

        i = 0;
        nCount = 0;
        sCod = "";
        mskLen = fldLen;

        while (i <= mskLen) {
            bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":") || (sMask.charAt(i) == ","))
            bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

            if (bolMask) {
                sCod += sMask.charAt(i);
                mskLen++;
            } else {
                sCod += sValue.charAt(nCount);
                nCount++;
            }
            i++;
        }
        if (nTecla <= 58 && nTecla >= 47) {
            document.getElementById(strField).value = sCod;
            var limpa = 1
        } else {
            //alert('Valor digitado é inválido');
            document.getElementById(strField).value = '';
            var limpa = 0
        }

        if (nTecla != 8) { // backspace
            if (sMask.charAt(i - 1) == "9") { // apenas números...
                return ((nTecla > 47) && (nTecla < 58));
            } // números de 0 a 9
            else { // qualquer caracter...
                return true;
            }
        } else {
            return true;
        }
    }//fim do if que verifica se é backspace
}

function isNum(event) {
    var nTecla;
    if (window.event) { // Internet Explorer
        nTecla = event.keyCode;
    } else if (event.which) { // Nestcape / firefox
        nTecla = event.which;
    }

    if ((nTecla >= 48 && nTecla <= 57) || (nTecla == 44)) {
        event.returnValue = true;
    } else {
        event.returnValue = false;
    }
}

function editaExcluiCRUD(acao, action, valor, form, flag_confirmacao) {
    var aux;
    var aux2;
    var aux3;
    var continua = false;
    if (flag_confirmacao) {
        if (confirm(fwAcoes[acao])) {
            //if (confirm("Deseja realmente executar a ação? [Ação: "+acao+"]")) {
            continua = true;
        } else {
            continua = false;
        }
    } else {
        continua = true;
    }

    if (continua) {
        if (action != "") {
            form.action = action;
            form.target = "";
        }
        if (acao == 'detalhe') {
            form.pagina.value = "publicas/" + form.crud.value + "Detalhe.php";
        }
        form.acao.value = acao;
        aux = valor.split("#");
        for (x = 0; x < (aux.length); x++) {
            aux2 = aux[x].split("%");
            aux3 = aux2[0];
            if (aux3 != "") {
                document.getElementById(aux3).value = aux2[1];
            }
        }
        form.submit();
    }
}

function data() {
    vDay = new Date();
    datatual = vDay.getDay();
    if (datatual == 0)
        strdata = "Domingo, ";
    if (datatual == 1)
        strdata = "Segunda-feira, ";
    if (datatual == 2)
        strdata = "Terça-feira, ";
    if (datatual == 3)
        strdata = "Quarta-feira, ";
    if (datatual == 4)
        strdata = "Quinta-feira, ";
    if (datatual == 5)
        strdata = "Sexta-feira, ";
    if (datatual == 6)
        strdata = "Sábado, ";
    vMes = vDay.getMonth()
    if (vMes == 0)
        strmes = "Janeiro ";
    if (vMes == 1)
        strmes = "Fevereiro ";
    if (vMes == 2)
        strmes = "Março ";
    if (vMes == 3)
        strmes = "Abril ";
    if (vMes == 4)
        strmes = "Maio ";
    if (vMes == 5)
        strmes = "Junho ";
    if (vMes == 6)
        strmes = "Julho ";
    if (vMes == 7)
        strmes = "Agosto ";
    if (vMes == 8)
        strmes = "Setembro ";
    if (vMes == 9)
        strmes = "Outubro ";
    if (vMes == 10)
        strmes = "Novembro ";
    if (vMes == 11)
        strmes = "Dezembro ";
    strlinha = "" + strdata + vDay.getDate() + " de " + strmes + " de " + vDay.getYear();
    document.write("" + strlinha + "&nbsp;&nbsp;&nbsp;");
}


/************************************************************************************************************/
/***************************************MASCARAS DE VALORES  PARA FORMULARIOS********************************/
/************************************************************************************************************/
function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}

function leech(v) {
    v = v.replace(/o/gi, "0")
    v = v.replace(/i/gi, "1")
    v = v.replace(/z/gi, "2")
    v = v.replace(/e/gi, "3")
    v = v.replace(/a/gi, "4")
    v = v.replace(/s/gi, "5")
    v = v.replace(/t/gi, "7")
    return v
}

function soNumeros(v) {
    return v.replace(/\D/g, "")
}

function dataM(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1/$2") //Coloca barra entre o segundo e o terceiro digito
    v = v.replace(/(\d{2})(\d)/, "$1/$2") //Coloca barra entre o quinto e o sexto digito
    return v
}

function mesReff(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1/$2") //Coloca barra entre o segundo e o terceiro digito
    v = v.replace(/(\d{4})(\d)/, "$1/$2") //Coloca barra entre o quinto e o sexto digito
    return v
}

function elementoM(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca barra entre o segundo e o terceiro digito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca barra entre o quinto e o sexto digito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca barra entre o quinto e o sexto digito
    return v
}
function subElementoM(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca barra entre o segundo e o terceiro digito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca barra entre o quinto e o sexto digito

    return v
}

function horaM(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1:$2") //Coloca : entre o segundo e o terceiro digito
    return v
}

function mesM(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1/$2") //Coloca barra entre o segundo e o terceiro digito
    return v
}




function numCaixaM(v) {


    alert(v.substring(i, i + 1));

    v = v.replace(/[^-?(0-9)]/g, "") //Remove tudo o que não é dígito e "-"
    //v=v.replace(/(\d{2})(\d)/,"$1-$2") //Coloca barra entre o segundo e o terceiro digito
    return v
}







function money(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{2})$/, "$1.$2") //Coloca ponto antes dos 2 últimos digitos
    return v
}




function moneyMinus(v) {
    var c = "";
    var vAux = "";
    var existeNoPrimeiro = false;
    for (i = 0; i < v.length; i++) {
        if (i == 0) {
            if (v.charAt(i) == "-") {
                existeNoPrimeiro = true;
            }
            vAux = vAux + v.charAt(i);
        } else {
            if (v.charAt(i) != "-") {
                vAux = vAux + v.charAt(i);
            }
        }
    }
    vAux = vAux.replace(/[^-?(0-9)]/g, "") //Remove tudo o que não é dígito
    vAux = vAux.replace(/(\d)(\d{2})$/, "$1.$2") //Coloca ponto antes dos 2 últimos digitos
    return vAux
}
function decimal4(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{4})$/, "$1.$2") //Coloca ponto antes dos 4 últimos digitos
    return v
}
function decimal2(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{2})$/, "$1.$2") //Coloca ponto antes dos 4 últimos digitos
    return v
}

function telefoneM(v) {
    v = v.replace(/\D/g, "")                 //Remove tudo o que não é dígito
    v = v.replace(/^(\d\d)(\d)/g, "($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}

function cpfM(v) {
    v = v.replace(/\D/g, "")                    //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function cepM(v) {
    v = v.replace(/D/g, "")                //Remove tudo o que não é dígito
    v = v.replace(/^(\d{5})(\d)/, "$1-$2") //Esse é tão fácil que não merece explicações
    return v
}

function cnpjM(v) {
    v = v.replace(/\D/g, "")                           //Remove tudo o que não é dígito
    v = v.replace(/^(\d{2})(\d)/, "$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")           //Coloca uma barra entre o oitavo e o nono dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")              //Coloca um hífen depois do bloco de quatro dígitos
    return v
}

function romanos(v) {
    v = v.toUpperCase()             //Maiúsculas
    v = v.replace(/[^IVXLCDM]/g, "") //Remove tudo o que não for I, V, X, L, C, D ou M
    //Essa é complicada! Copiei daqui: https://www.diveintopython.org/refactoring/refactoring.html
    while (v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/, "") != "")
        v = v.replace(/.$/, "")
    return v
}

function siteM(v) {
    //Esse sem comentarios para que você entenda sozinho ;-)
    v = v.replace(/^http:\/\/?/, "")
    dominio = v
    caminho = ""
    if (v.indexOf("/") > -1)
        dominio = v.split("/")[0]
    caminho = v.replace(/[^\/]*/, "")
    dominio = dominio.replace(/[^\w\.\+-:@]/g, "")
    caminho = caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g, "")
    caminho = caminho.replace(/([\?&])=/, "$1")
    if (caminho != "")
        dominio = dominio.replace(/\.+$/, "")
    v = "https://" + dominio + caminho
    return v
}

//

function moedaBR(money) {

    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(money)
}
//function formataMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
function formataMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e) {

    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    // 13=enter, 8=backspace as demais retornam 0(zero)
    // whichCode==0 faz com que seja possivel usar todas as teclas como delete, setas, etc
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave


    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida
    len = objTextBox.value.length;
    for (i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal))
            break;
    aux = '';
    for (; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1)
            aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0)
        objTextBox.value = '';
    if (len == 1)
        objTextBox.value = '0' + SeparadorDecimal + '0' + aux;
    if (len == 2)
        objTextBox.value = '0' + SeparadorDecimal + aux;
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


function validarEmail(email) {

    var arroba = "@",
        ponto = ".",
        posponto = 0,
        posarroba = 0;

    if (email == "")
        return false;
    validos = 'qazwsxedcrfvtgbyhnujmikolp1234567890@._-';
    pos = 0;
    email = email.toLowerCase();
    for (var i = 0; i < email.length; i++) {
        pos = 0;
        for (var j = 0; j < validos.length; j++) {
            if (email.charAt(i) == validos.charAt(j)) {
                pos++;
            }
        }

        if (pos == 0) {
            //return false;
            alert('E-mail Inválido');
        }
    }
    // Verifica se existe o simbolo '@' e sua posi??o
    for (var indice = 0; indice < email.length; indice++) {
        if (email.charAt(indice) == arroba) {
            posarroba = indice;
            break;
        }
    }

    // Verifica se existe o simbolo '.' e sua posi??o
    for (var indice = posarroba; indice < email.length; indice++) {
        if (email.charAt(indice) == ponto) {
            posponto = indice;
            break;
        }
    }

    // Verifica a posic?o do simbolo '@' em rela??o  ao simbolo '.'
    if (posponto == 0 || posarroba == 0)
        alert('E-mail Inválido');
    if (posponto == (posarroba + 1))
        alert('E-mail Inválido');
    if ((posponto + 1) == email.length)
        alert('E-mail Inválido');

    return true;
}

/************************************************************************************************************/
/*********************************************VALIDAR CAMPO DATA E HORA**************************************/
/************************************************************************************************************/
//mascada data hora => 12/12/1979 12:10
function filtroDataHora(campo, event) {
    if (navigator.appName.indexOf("Netscape") != -1)
        tecla = event.which;
    else
        tecla = event.keyCode;

    if (tecla != 9 && tecla != 8 && tecla != 47) {
        if (campo.value.length == 2)
            campo.value += "/";
        if (campo.value.length == 5)
            campo.value += "/";
        if (campo.value.length == 10)
            campo.value += " ";
        if (campo.value.length == 13)
            campo.value += ":";
    }
}


/*valida se a data e valida*/
function doDate(pStr) {
    var bissexto = 0;
    var data = pStr;
    var tam = data.length;
    if (tam == 10) {
        var dia = data.substr(0, 2)
        var mes = data.substr(3, 2)
        var ano = data.substr(6, 4)
        if ((ano > 1900) || (ano < 2100)) {
            switch (mes) {
                case '01':
                case '03':
                case '05':
                case '07':
                case '08':
                case '10':
                case '12':
                    if (dia <= 31) {
                        return true;
                    }
                    break

                case '04':
                case '06':
                case '09':
                case '11':
                    if (dia <= 30) {
                        return true;
                    }
                    break
                case '02':
                    /* Validando ano Bissexto / fevereiro / dia */
                    if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) {
                        bissexto = 1;
                    }
                    if ((bissexto == 1) && (dia <= 29)) {
                        return true;
                    }
                    if ((bissexto != 1) && (dia <= 28)) {
                        return true;
                    }
                    break
            }
        }
    }
    return false;
}

/*valida se a hora e valida*/
function doHora(pStr) {
    var hora = pStr.split(":");
    if (hora.length > 1) {
        if (hora[0] > 24 || hora[0] < 0 || hora[1] > 60 || hora[1] < 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

/*pega campo com data e hora e separa a data da hora*/
function validaDataHora(pStr) {
    var dataHora = pStr.value.split(" ");
    if (dataHora.length > 1) {
        if ((dataHora[0].length != 10) || (dataHora[1].length != 5)) {
            alert('Formato de data e hora diferente de: [dd/mm/yyyy hh:mm]!');
            pStr.focus();
            return false;
        } else if (!doDate(dataHora[0])) {
            alert('Data [' + dataHora[0] + '] inválida!');
            pStr.focus();
            return false;
        } else if (!doHora(dataHora[1])) {
            alert('Hora [' + dataHora[1] + '] inválida!');
            pStr.focus();
            return false;
        } else {
            return true;
        }
    } else {
        alert('Formato de data e hora diferente de: [dd/mm/yyyy hh:mm]!');
        return false;
    }
}

/*pega campo com data e hora e separa a data da hora*/
function validaSoData(pStr) {
    var dataHora = pStr.value;
    if (dataHora == "") {
        return true;
    } else {
        if ((dataHora.length != 10)) {
            alert('Formato de data diferente de: [dd/mm/yyyy]!');
            pStr.focus();
            return false;
        } else if (!doDate(dataHora)) {
            alert('Data [' + dataHora + '] inválida!');
            pStr.focus();
            return false;
        } else {
            return true;
        }
    }
}

/**
 * Checks/unchecks all checkbox in given conainer (f.e. a form, fieldset or div)
 *
 * @param   string   container_id  the container id
 * @param   boolean  state         new value for checkbox (true or false)
 * @return  boolean  always true
 */
function setCheckboxes(container_id, state) {
    var checkboxes = document.getElementById(container_id).getElementsByTagName('input');

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
            checkboxes[i].checked = state;
        }
    }

    return true;
} // end of the 'setCheckboxes()' function

/**
 * Checks/unchecks all options of a <select> element
 *
 * @param   string   the form name
 * @param   string   the element name
 * @param   boolean  whether to check or to uncheck the element
 *
 * @return  boolean  always true
 */
function setSelectOptions(the_form, the_select, do_check) {
    var selectObject = document.forms[the_form].elements[the_select];
    var selectCount = selectObject.length;
    for (var i = 0; i < selectCount; i++) {
        selectObject.options[i].selected = do_check;
    } // end for

    return true;
} // end of the 'setSelectOptions()' function

/**
 * Checks/unchecks all checkbox por nome
 *
 * @param   string   nome do formulario
 * @param   string   nome do campo
 * @param   boolean  whether to check or to uncheck the element
 *
 * @return  boolean  always true
 */
function setCheckRadioPorNome(the_form, the_check, do_check) {
    var selectObject = document.forms[the_form].elements[the_check];
    var selectCount = selectObject.length;
    for (var i = 0; i < selectCount; i++) {
        selectObject[i].checked = do_check;
    } // end for

    return true;
} // end of the 'setSelectOptions()' function

/**
 * Checks radio bottom
 *
 * @param	campo    radio do formulario
 * @param   valor	 o valor do radio bottom
 * @return  boolean  always true
 */
function setCheckRadio(campo, valor) {
    var checkRadio = campo;
    //alert(checkRadio.length);
    for (var i = 0; i < checkRadio.length; i++) {
        if (checkRadio[i].value == valor) {
            checkRadio[i].checked = true;
        }
    }
    return true;
} // end of the 'setCheckRadio()' function


//Matricula
function setCheckDiaTurma(valor, idQuadra) {
    var elem = document.matriculaListagem.elements;
    for (var i = 0; i < elem.length; i++) {
        if (elem[i].type == 'checkbox') {
            if (elem[i].value == valor) {
                elem[i].checked = true;
            }
        }
    }
    dias = desabilitaQuadraDiferente(elem, idQuadra);
    return true;
} // end of the 'setCheckDiaTurma()' function

function validaCheckboxesDiaQuadra(container_id, idQuadra, caminho, form) {
    var checkboxes = document.getElementById(container_id).getElementsByTagName('input');
    var aux;
    var dias = "";
    var conTcheck = 0;
    if (form.idHorario.value == "") {
        alert("Informe o horário.");
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                if (checkboxes[i].checked)
                    conTcheck = conTcheck + 1;
            }
        }
        if (conTcheck > 0) {
            dias = desabilitaQuadraDiferente(checkboxes, idQuadra);
            param = form.idHorario.value + "|" + idQuadra + "|" + dias;
            pegaTurmasPorDiaQuadra(caminho, param, f);
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].disabled = false;
                }
            }
            document.getElementById("dadosTurma").innerHTML = "";
        }
    }
    return true;
} // end of the 'validaCheckboxesDiaQuadra()' function

function desabilitaQuadraDiferente(checkboxes, idQuadra) {
    var primeiro = true;
    var dias = "";
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
            valor = checkboxes[i].value;
            aux = checkboxes[i].value.split("#");
            if (aux[1] == idQuadra) {
                checkboxes[i].disabled = false;
                if (checkboxes[i].checked) {
                    if (primeiro) {
                        dias = dias + aux[0] + "";
                        primeiro = false;
                    } else {
                        dias = dias + "," + aux[0] + "";
                    }
                }
            } else {
                checkboxes[i].checked = false;
                checkboxes[i].disabled = true;
            }
        }
    }
    return dias;
}

//TABELAS DINAMICAS
/*
 function insRowDinamica(nmTabela, linha, caminho, qtdRows, gatilho){
 // alert();
 
 var i		 = linha.parentNode.parentNode.rowIndex;
 var tabela	 = document.getElementById(''+nmTabela+'');
 
 var y = new Array();
 var x = new Array();
 for ( var w = 0; w < qtdRows; w++ ) {
 y[w]		 = tabela.rows[i].cells[w];
 }
 var l		 = tabela.insertRow(i+1);
 for ( var w = 0; w < qtdRows; w++ ) {
 x[w]		 = l.insertCell(w);
 }
 for ( var w = 0; w < (qtdRows-1); w++ ) {
 x[w].innerHTML = y[w].innerHTML;
 }
 var ultimaCell = qtdRows-1;
 x[ultimaCell].innerHTML = "<img src='"+caminho+"imagens/icones/excluir.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";
 if (gatilho!=""){
 setTimeout(""+gatilho+"()",1);
 }
 }
 */
function insRowDinamica(nmTabela, linha, caminho, qtdRows, gatilho) {

    var i = linha.parentNode.parentNode.rowIndex;
    var tabela = document.getElementById('' + nmTabela + '');
    var y = new Array();
    var x = new Array();
    for (var w = 0; w < qtdRows; w++) {
        y[w] = tabela.rows[i].cells[w];
    }
    var l = tabela.insertRow(i + 1);
    for (var w = 0; w < qtdRows; w++) {
        x[w] = l.insertCell(w);
    }
    for (var w = 0; w < (qtdRows - 1); w++) {
        x[w].innerHTML = y[w].innerHTML;
    }
    var ultimaCell = qtdRows - 1;
    /*x[ultimaCell].innerHTML = "<img src='"+caminho+"imagens/icones/excluir.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";*/
    y[ultimaCell].innerHTML = "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_cancelar.png' style='cursor:pointer;' onclick='delRowDinamica(this,\"" + nmTabela + "\",\"" + gatilho + "\");' />";
    x[ultimaCell].innerHTML = "<img style='cursor:pointer;' height='20' onclick=\"insRowDinamica('" + nmTabela + "',this,'" + caminho + "'," + qtdRows + ",'" + gatilho + "');\" src='" + "https://www.portalsema.ba.gov.br/_portal/Icones/ico_adicionar.png' />";
    if (gatilho != "") {
        //setTimeout(""+gatilho+"()",1);
        setTimeout("" + gatilho, 1);
    }
}

function insRowDinamicaButtonNF(nmTabela, linha, caminho, qtdRows, gatilho) {
    if ($('#processo_pag_id').val() == '') {
        alert('N° do processo de pagamento em branco!');
        $('#processo_pag_id').focus();
        return false;
    }

    var i = linha.parentNode.parentNode.rowIndex;
    var tabela = document.getElementById('' + nmTabela + '');
    var y = new Array();
    var x = new Array();
    for (var w = 0; w < qtdRows; w++) {
        y[w] = tabela.rows[i].cells[w];
    }
    var l = tabela.insertRow(i + 1);
    for (var w = 0; w < qtdRows; w++) {
        x[w] = l.insertCell(w);
    }
    for (var w = 0; w < (qtdRows - 1); w++) {
        x[w].innerHTML = y[w].innerHTML;
    }
    var ultimaCell = qtdRows - 1;
    /*x[ultimaCell].innerHTML = "<img src='"+caminho+"imagens/icones/excluir.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";*/
    //y[ultimaCell].innerHTML = "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_cancelar.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";
    y[ultimaCell].innerHTML = "<input type=\"button\" class=\"btn-mini btn-danger\" value=\"Excluir\"  onclick='delRowDinamica(this,\"" + nmTabela + "\",\"" + gatilho + "\");'  style='width:45px'>";

    x[ultimaCell].innerHTML = "<input type=\"button\" class=\"btn-mini btn-success\" value=\"Novo\"  onclick=\"insRowDinamicaButtonNF('" + nmTabela + "',this,'" + caminho + "'," + qtdRows + ",'" + gatilho + "');\" style='width:45px'>";

    //x[ultimaCell].innerHTML = "<img style='cursor:pointer;' height='20' onclick=\"insRowDinamica('"+nmTabela+"',this,'"+caminho+"',"+qtdRows+",'"+gatilho+"');\" src='"+"https://www.portalsema.ba.gov.br/_portal/Icones/ico_adicionar.png' />";
    if (gatilho != "") {
        //setTimeout(""+gatilho+"()",1);
        setTimeout("" + gatilho, 1);
    }
}
function insRowDinamicaCadastroCompromisso(nmTabela, linha, caminho, qtdRows, gatilho, classeAdd, classRemov) {


    //valida se o dia existe algum evento confirmado
    if (validaDiasReserva() === false) {
        return false;
    }

    var i = linha.parentNode.parentNode.rowIndex;
    var tabela = document.getElementById('' + nmTabela + '');
    var y = new Array();
    var x = new Array();
    for (var w = 0; w < qtdRows; w++) {
        y[w] = tabela.rows[i].cells[w];
    }
    var l = tabela.insertRow(i + 1);
    for (var w = 0; w < qtdRows; w++) {
        x[w] = l.insertCell(w);
    }
    for (var w = 0; w < (qtdRows - 1); w++) {
        x[w].innerHTML = y[w].innerHTML;
    }
    var ultimaCell = qtdRows - 1;
    /*x[ultimaCell].innerHTML = "<img src='"+caminho+"imagens/icones/excluir.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";*/
    y[ultimaCell].innerHTML = "<img class=" + classRemov + " src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_cancelar.png' style='cursor:pointer;' onclick='delRowDinamica(this,\"" + nmTabela + "\",\"" + gatilho + "\");' />";
    x[ultimaCell].innerHTML = "<img class=" + classeAdd + " style='cursor:pointer;' height='20' onclick=\"insRowDinamicaCadastroCompromisso('" + nmTabela + "',this,'" + caminho + "'," + qtdRows + ",'" + gatilho + "');\" src='" + "https://www.portalsema.ba.gov.br/_portal/Icones/ico_adicionar.png' />";
    if (gatilho != "") {
        //setTimeout(""+gatilho+"()",1);
        setTimeout("" + gatilho, 1);
    }
}

function delRowDinamica(r, tabela, gatilho) {

    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById('' + tabela + '').deleteRow(i);
    if (gatilho != "") {
        setTimeout("" + gatilho + "()", 1);
    }
}

//Matricula
function marcaCheckboxPorValoreNome(form, nome, valor) {
    var elem = document.forms[form].elements;
    for (var i = 0; i < elem.length; i++) {
        //alert(elem[i].type+' - '+elem[i].name+' - '+elem[i].value+' - '+valor);
        if (elem[i].type == 'checkbox' && elem[i].name == nome && elem[i].value == valor) {
            elem[i].checked = true;
        }
    }
    return true;
} // end of the 'setCheckDiaTurma()' function


//retorna string no formato money
function getMoney(str) {
    return parseInt(str.replace(/[\D]+/g, ''));
}


//função que abre o contrato ou modificação
function openPDF(caminho, nomePDF, forma) {
    if (forma == '') {
        forma = '_blank';
    }
    if (caminho == '') {
        alert('Caminho do Arquivo em Branco!');
        return false;
    }


    //existe o pdf
    if (nomePDF !== '') {
        window.open(caminho + nomePDF, forma);
    } else {//não existe o pdf
        alert('Contrato não anexado');
        return false;
    }

}

function verificarCPF(c) {
    //alert(c)
    var i;
    s = c;
    var c = s.substr(0, 9);
    var dv = s.substr(9, 2);
    var d1 = 0;
    var v = false;

    for (i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (10 - i);
    }
    if (d1 == 0) {
        //alert("CPF Inválido")
        v = true;
        return false;
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(0) != d1) {
        //alert("CPF Inválido")
        v = true;
        return false;
    }

    d1 *= 2;
    for (i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (11 - i);
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(1) != d1) {
        v = true;
        return false;
    }
    if (!v) {
        return true;
    }
}

function verificaCnpj(str) {
    //alert(str)
    str = str.replace('.', '');
    str = str.replace('.', '');
    str = str.replace('.', '');
    str = str.replace('-', '');
    str = str.replace('/', '');
    cnpj = str;
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;
    if (cnpj.length < 14 && cnpj.length < 15)
        return false;
    for (i = 0; i < cnpj.length - 1; i++)
        if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais) {
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    } else
        return false;
}

function arredondar(str, casas) {
    str = str + '';
    if (str.indexOf(',') != -1)
        str = str.replace(',', '.');
    if (!casas)
        casas = 0;
    casas = Math.pow(10, casas);
    str = parseFloat(str) * casas;
    return Math.floor(str) / casas;
}



function insRowDinamicaButton(nmTabela, linha, caminho, qtdRows, gatilho) {

    var i = linha.parentNode.parentNode.rowIndex;
    var tabela = document.getElementById('' + nmTabela + '');
    var y = new Array();
    var x = new Array();
    for (var w = 0; w < qtdRows; w++) {
        y[w] = tabela.rows[i].cells[w];
    }
    var l = tabela.insertRow(i + 1);
    for (var w = 0; w < qtdRows; w++) {
        x[w] = l.insertCell(w);
    }
    for (var w = 0; w < (qtdRows - 1); w++) {
        x[w].innerHTML = y[w].innerHTML;
    }
    var ultimaCell = qtdRows - 1;
    /*x[ultimaCell].innerHTML = "<img src='"+caminho+"imagens/icones/excluir.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";*/
    //y[ultimaCell].innerHTML = "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_cancelar.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";
    y[ultimaCell].innerHTML = "<input type=\"button\" class=\"btn btn-danger\" value=\"Excluir\"  onclick='delRowDinamica(this,\"" + nmTabela + "\",\"" + gatilho + "\");'  style='width:60px'>";

    x[ultimaCell].innerHTML = "<input type=\"button\" class=\"btn btn-success\" value=\"Novo\"  onclick=\"insRowDinamicaButton('" + nmTabela + "',this,'" + caminho + "'," + qtdRows + ",'" + gatilho + "');\" style='width:60px'>";

    //x[ultimaCell].innerHTML = "<img style='cursor:pointer;' height='20' onclick=\"insRowDinamica('"+nmTabela+"',this,'"+caminho+"',"+qtdRows+",'"+gatilho+"');\" src='"+"https://www.portalsema.ba.gov.br/_portal/Icones/ico_adicionar.png' />";
    if (gatilho != "") {
        //setTimeout(""+gatilho+"()",1);
        setTimeout("" + gatilho, 1);
    }
}


function insRowDinamicaCi(nmTabela, linha, caminho, qtdRows, gatilho) {

    var i = linha.parentNode.parentNode.rowIndex;
    var tabela = document.getElementById('' + nmTabela + '');
    var y = new Array();
    var x = new Array();
    for (var w = 0; w < qtdRows; w++) {
        y[w] = tabela.rows[i].cells[w];
    }
    var l = tabela.insertRow(i + 1);
    for (var w = 0; w < qtdRows; w++) {
        x[w] = l.insertCell(w);
    }
    for (var w = 0; w < (qtdRows - 1); w++) {
        x[w].innerHTML = y[w].innerHTML;
    }
    var ultimaCell = qtdRows - 1;
    /*x[ultimaCell].innerHTML = "<img src='"+caminho+"imagens/icones/excluir.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";*/
    //y[ultimaCell].innerHTML = "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_cancelar.png' style='cursor:pointer;' onclick='delRowDinamica(this,\""+nmTabela+"\",\""+gatilho+"\");' />";
    y[ultimaCell].innerHTML = "<input type=\"button\" class=\"btn btn-danger\" value=\"Excluir\"  onclick='delRowDinamica(this,\"" + nmTabela + "\",\"" + gatilho + "\");'  style='width:60px'>";

    x[ultimaCell].innerHTML = "<input type=\"button\" class=\"btn btn-success\" value=\"Novo\"  onclick=\"insRowDinamicaCi('" + nmTabela + "',this,'" + caminho + "'," + qtdRows + ",'" + gatilho + "');\" style='width:60px'>";

    //x[ultimaCell].innerHTML = "<img style='cursor:pointer;' height='20' onclick=\"insRowDinamica('"+nmTabela+"',this,'"+caminho+"',"+qtdRows+",'"+gatilho+"');\" src='"+"https://www.portalsema.ba.gov.br/_portal/Icones/ico_adicionar.png' />";
    if (gatilho != "") {
        //setTimeout(""+gatilho+"()",1);
        setTimeout("" + gatilho, 1);
    }
    /*
     ///adiciona a consulta por texto no select
     $(".select2_single").select2({
     placeholder: ".:Selecione:.",
     allowClear: true
     });
     $(".select2_group").select2({});
     $(".select2_multiple").select2({
     maximumSelectionLength: 4,
     placeholder: "With Max Selection limit 4",
     allowClear: true
     });
     */
}

function clonaTR() {
    alert()
    $('#dynamic_field').append('<tr id=""><td><input type="text" name="name[]" placeholder="Digite aqui" class="form-control name_list" /></td><td><button type="button" name="remove" id="" class="btn btn-danger btn_remove">X</button></td></tr>');

}

function apagaTR(campo) {

    var button_id = $(campo).attr("id");
    $('#row' + button_id + '').remove();
}

function checkRadio(name, msg_erro) {
    var isChecked = jQuery("input[name=" + name + "]:checked").val();
    var booleanVlaueIsChecked = false;
    if (!isChecked) {
        booleanVlaueIsChecked = true;
        alert(msg_erro);
        return false;
    }
}

function RemoveTableRow(item) {
    var tr = $(item).closest('tr');
    tr.fadeOut(0, function () {
        tr.remove();
    });
}


function dataToBR(dataEn) {
    if (dataEn == '' || dataEn === null ) {
        return '';
    }

    let dt = dataEn.split(' ');
    return dt[0].split('-').reverse().join('/');
}
function dataToBRcomHora(dataEn) {

    if (dataEn == '') {
        return '';
    }

    let dt = dataEn.split(' ');
    return dt[0].split('-').reverse().join('/') + ' - ' + dt[1].substring(0, 5);
}

// function dbToData(dataEn) {
//     if (dataEn == '') {
//         return '';
//     }

//     return dataEn.split('-').reverse().join('/');
// }

function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}

//acho q nao funciona
function TestaCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    // Elimina CPFs invalidos conhecidos	
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito	
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito	
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}
 function mascararCPF(valor) {
    // Remover caracteres não numéricos
    let cpf = valor.replace(/\D/g, '');

    // Adicionar a máscara
    if (cpf.length > 3 && cpf.length <= 6) {
        cpf = cpf.replace(/(\d{3})(\d{1,3})/, '$1.$2');
    } else if (cpf.length > 6 && cpf.length <= 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
    } else if (cpf.length > 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    }

    // Atualizar o valor do v-model
    return cpf;
    // if (this.responsavel_cpf.length == 14) {
    //     alert(this.validarCPF(this.responsavel_cpf))
    // }
}

//esse funcionar
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    // Elimina CPFs invalidos conhecidos	
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito	
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito	
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

function validoFormatoDoc(arquivo) {
    var extensoes, ext, valido;
    extensoes = new Array('.png', '.pdf', '.doc', '.jpg', '.jpeg', '.gif');

    ext = arquivo.substring(arquivo.lastIndexOf(".")).toLowerCase();
    valido = false;

    for (var i = 0; i <= arquivo.length; i++) {
        if (extensoes[i] == ext) {
            valido = true;
            break;
        }
    }

    if (valido) {
        return true;
    }
    return false;
}


function checkDevice() {
    if (navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
    ) {
        return 's'; // está utilizando celular
    }
    else {
        return 'n'; // não é celular
    }
}