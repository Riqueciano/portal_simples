var xmlHttp, xmlHttp1, layer, filter;

/*******************************************************************************
                Alterado por Danillo 06/07/2012 às 11:21
        Função em ajax que vai buscar as informações das diárias bloqueadas.
        Lembrando que deve criar um novo objeto para cada chamada se não um
                            objeto sobrescreve o outro.
*******************************************************************************/
/*******************************************************************************
        FUNÇÃO MANDAID, ESTA É A FUNÇÃO QUE CONTROLA O AJAX E SEU RETORNO
*******************************************************************************/
function MandaID(str,layer,filter)
{
    xmlHttp=GetXmlHttpObject()

    if (xmlHttp==null)
    {
        alert ("Este browser no suporta HTTP Request")
        return
    }

    var url= "Ajax/" + layer +".php"
    url=url+"?"+filter+"="+str
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
        case "AjaxSubMotivo":
                xmlHttp.onreadystatechange = stateChangedSubMotivo
        break;
        case "AjaxTipoParticipante":
                xmlHttp.onreadystatechange = stateChangedTipoParticipante
        break;
        case "AjaxTituloEleitor":
                xmlHttp.onreadystatechange = stateChangedTituloEleitor
        break;
        case "AjaxRoteiroOrigem":
                xmlHttp.onreadystatechange = stateChangedRoteiroOrigem
        break;
        case "AjaxRoteiroDestino":
                xmlHttp.onreadystatechange = stateChangedRoteiroDestino
        break;      
        
        //NOVO 30/10/2013
		case "AjaxTipoPassagemSolicitacaoIda":
			xmlHttp.onreadystatechange = stateChangedTipoPassagemIda
		break;
		case "AjaxTipoPassagemSolicitacaoVolta":
			xmlHttp.onreadystatechange = stateChangedTipoPassagemVolta
		break;

		/*case "AjaxTipoPassagemAquisicao":
			xmlHttp.onreadystatechange = stateChangedTipoPassagem
		break;*/
		case "AjaxDiariaPassagem":
			xmlHttp.onreadystatechange = stateChangedDiariaPassagem
		break;
		case "AjaxLocalizacaoEmpresa":
			xmlHttp.onreadystatechange = stateChangedLocalizacaoEmpresa
		break;
		case "AjaxTipoUsuarioAcao":
			xmlHttp.onreadystatechange = stateChangedTipoUsuarioAcao
		break;
		case "AjaxTipoUsuarioModulo":
			xmlHttp.onreadystatechange = stateChangedTipoUsuarioModulo
		break;
                
    }
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

/*******************************************************************************
                FUNÇÃO AJAX QUE CARREGA AS FONTES DO PROJ/AÇÃO/TERRITÓRIO
*******************************************************************************/
function MandaPAOE(projeto,acao,territorio,beneficiario,layer)
{
	xmlHttp=GetXmlHttpObject()

    if (xmlHttp==null)
    {
        alert ("Este browser no suporta HTTP Request")
        return
    }
	
	
	var url= "Ajax/"+layer+".php"
    url=url+"?projeto_cd="+projeto+"&acao_cd="+acao+"&territorio_cd="+territorio+"&beneficiario="+beneficiario

	switch(layer)
    {
        case "AjaxProjetoPAOE":
                xmlHttp.onreadystatechange = stateChangedProjetoPAOE
        break;
        case "AjaxAcaoPAOE":
                xmlHttp.onreadystatechange = stateChangedAcaoPAOE
        break;
        case "AjaxTerritorioPAOE":

                xmlHttp.onreadystatechange = stateChangedTerritorioPAOE
        break;
        case "AjaxFontePAOE":
                xmlHttp.onreadystatechange = stateChangedFontePAOE
        break;
	}

    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}

/*******************************************************************************
                FUNÇÃO AJAX QUE REFAZ O RESUMO DA DIÁRIA
*******************************************************************************/
function RefazResumo(datasaida,datachegada)
{
    xmlHttp=GetXmlHttpObject()

    var url
    url = "Ajax/AjaxRefazResumo.php?datasaida="+datasaida+"&datachegada="+datachegada;

    xmlHttp.onreadystatechange = stateRefazResumo

    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)

}
/*******************************************************************************
      FUNÇÕES QUE ATRIBUEM O RETORNO DO AJAX AO OBJETO CUJO O ID É PASSADO
*******************************************************************************/

function stateChangedProjetoPAOE()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Projeto").innerHTML=xmlHttp.responseText
}
function stateChangedAcaoPAOE()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Acao").innerHTML=xmlHttp.responseText
		
		$('#cmbTerritorio').remove();
		$('#cmbFonte').remove();
		$('#cmbTerritorio').attr('style', 'display: none;');
		$('#cmbFonte').attr('style', 'display: none;');

}
function stateChangedTerritorioPAOE()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Territorio").innerHTML=xmlHttp.responseText

		$('#cmbFonte').remove();
		$('#cmbFonte').attr('style', 'display: none;');
}
function stateChangedFontePAOE()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Fonte").innerHTML=xmlHttp.responseText
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
function stateChangedTituloEleitor()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        document.getElementById("Titulo").innerHTML=xmlHttp.responseText
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

//NOVO 30/10/2013
function stateChangedTipoPassagemIda()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("EmpresaIda").innerHTML=xmlHttp.responseText
}
function stateChangedTipoPassagemVolta()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("EmpresaVolta").innerHTML=xmlHttp.responseText
}

function stateChangedDiariaPassagem()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("Diaria").innerHTML=xmlHttp.responseText
}

function stateChangedLocalizacaoEmpresa()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("LocalizacaoEmpresa").innerHTML=xmlHttp.responseText
}

function stateChangedTipoUsuarioAcao()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("InformacoesTipoUsuarioAcao").innerHTML=xmlHttp.responseText
}
function stateChangedTipoUsuarioModulo()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("TipoUsuarioModulo").innerHTML=xmlHttp.responseText
}


/*******************************************************************************
                FUNÇÃO QUE RETORNA O OBJETO PARA O AJAX
*******************************************************************************/
function GetXmlHttpObject()
{
    var objXMLHttp=null

    if (window.XMLHttpRequest)
    {
        objXMLHttp = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return objXMLHttp
}