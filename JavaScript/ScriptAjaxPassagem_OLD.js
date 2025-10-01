var xmlHttp,xmlHttp1, layer, filter


function AdicionaRoteiroPassagem(str1,str2,layer){
	xmlHttp=GetXmlHttpObject()

	if (document.Form.cmbRoteiroOrigemMunicipio.value == document.Form.cmbRoteiroDestinoMunicipio.value){
		alert("ORIGEM e DESTINO são iguais.")
		document.Form.cmbRoteiroDestinoMunicipio.focus();
		return false;
	}
	
	var url= "Ajax/" + layer +".php"
	url=url+"?origem="+str1+"&destino="+str2
	switch(layer){
		case "AjaxRoteiroAdicionarPassagem":
			xmlHttp.onreadystatechange = stateAddRoteiroPassagem
		break;
	}

	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

}

function MandaIDPassagem(str,layer,filter)
{//alert('MandaID');

	xmlHttp=GetXmlHttpObject()

	if (xmlHttp==null)
	{
		alert ("Este browser no suporta HTTP Request")
		return
	}

	var url= "Ajax/" + layer +".php"
	url=url+"?"+filter+"="+str

	switch(layer){
		
		case "AjaxRoteiroOrigemPassagem":
			xmlHttp.onreadystatechange = stateChangedRoteiroOrigemPassagem
		break;
		case "AjaxRoteiroDestinoPassagem":
			xmlHttp.onreadystatechange = stateChangedRoteiroDestinoPassagem
		break;
		
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

	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

}



function stateChangedRoteiroOrigemPassagem()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("RoteiroOrigemPassagem").innerHTML=xmlHttp.responseText
}

function stateChangedRoteiroDestinoPassagem()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("RoteiroDestinoPassagem").innerHTML=xmlHttp.responseText
}


function stateAddRoteiroPassagem()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		document.getElementById("RoteiroPassagem").innerHTML=xmlHttp.responseText
		document.getElementById("txtRoteiroSts").value = document.getElementById("txtRoteiroAdd").value
}

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

