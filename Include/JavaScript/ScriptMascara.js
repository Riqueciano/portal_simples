/************************************************************************************************************/
/***************************************MASCARAS DE VALORES  PARA FORMULARIOS********************************/
/************************************************************************************************************/
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function soNumerosM(v){
    return v.replace(/\D/g,"")
}

function dataM(v){
	v=v.replace(/\D/g,"") //Remove tudo o que n�o � d�gito
	v=v.replace(/(\d{2})(\d)/,"$1/$2") //Coloca barra entre o segundo e o terceiro digito
	v=v.replace(/(\d{2})(\d)/,"$1/$2") //Coloca barra entre o quinto e o sexto digito
	return v
}

function moneyM(v){
	v=v.replace(/\D/g,"") //Remove tudo o que n�o � d�gito
	v=v.replace(/(\d)(\d{2})$/,"$1,$2") //Coloca ponto antes dos 2 �ltimos digitos
	return v
}

function telefoneM(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que n�o � d�gito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca par�nteses em volta dos dois primeiros d�gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca h�fen entre o quarto e o quinto d�gitos
    return v
}

function cpfM(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que n�o � d�gito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
                                             //de novo (para o segundo bloco de n�meros)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um h�fen entre o terceiro e o quarto d�gitos
    return v
}

function cepM(v){
    v=v.replace(/D/g,"")                //Remove tudo o que n�o � d�gito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2") //Esse � t�o f�cil que n�o merece explica��es
    return v
}

function cnpjM(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que n�o � d�gito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro d�gitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto d�gitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono d�gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um h�fen depois do bloco de quatro d�gitos
    return v
}

