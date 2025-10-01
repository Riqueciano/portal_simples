<?php

Class Convert {

	public function converteDataParaBanco($data){
		$_data = split("/",$data);
		$data = $_data[2]."-".$_data[1]."-".$_data[0];
		return $data;
	}
	public function converteDataDoBanco($data){
		$_data = split("-",$data);
		$data = $_data[2]."/".$_data[1]."/".$_data[0];
		return $data;
	}
	public function converteDataDoBancoMesAno($data){
		$_data = split("-",$data);
		$data = $_data[1]."/".$_data[0];
		return $data;
	}
	public function converteDataParaBancoComHora($data){
		$__data = split(" ",$data);
		$_data = split("/",$__data[0]);
		$data = $_data[2]."-".$_data[1]."-".$_data[0]." ".$__data[1];
		return $data;
	}
	public function converteDataDoBancoComHora($data){
		$__data = split(" ",$data);
		$_data = split("-",$__data[0]);
		$data = $_data[2]."/".$_data[1]."/".$_data[0]." ".$__data[1];
		return $data;
	}

	public function converteDataDoBancoSemHora($data){
		$__data = split(" ",$data);
		$_data = split("/",$__data[0]);
		$data = $_data[0]."/".$_data[1]."/".$_data[2];
		return $data;
	}

	/**
	 * Função que dimenciona a foto no tamanho desejado
	 * @author Fabricio Silva
	 * @descrição	recebe uma data no formato YYYY-mm-dd hh:mm:ss e particiona
					em  dd/mm/YYYY e hh:mm
	 * @return vetor de tamanho dois com data e hora separados
	 * @contact https://www.geniuns.com.br
	**/
	public function retornaDataDoBancoParticionada($data,$formato){
		//quebra a data em data e hora
		$__data = split(" ",$data);
		$_data = split("-",$__data[0]);
		$_hora = split(":",$__data[1]);
		if ($formato=="dd/mm/yyyy"){
			$dataAux[0] = $_data[2]."/".$_data[1]."/".$_data[0];
		} elseif($formato=="dd/mm") {
			$dataAux[0] = $_data[2]."/".$_data[1];
		} elseif($formato=="mm/yyyy") {
			$dataAux[0] = $_data[1]."/".$_data[0];
		} elseif($formato=="dd/yyyy") {
			$dataAux[0] = $_data[2]."/".$_data[0];
		} elseif($formato=="mm") {
			$dataAux[0] = $_data[1];
		} elseif($formato=="dd") {
			$dataAux[0] = $_data[2];
		} elseif($formato=="yyyy") {
			$dataAux[0] = $_data[0];
		} else {
			$dataAux[0] = "formato inexistente";
		}
		$dataAux[1] = $_hora[0].":".$_hora[1].":".$_hora[2];
		return $dataAux;
	}

	/**
	 * Função que dimenciona a foto no tamanho desejado
	 * @author Fabricio Silva
	 * @descrição	recebe uma data no formato YYYY-mm-dd hh:mm:ss e particiona
					em  dd/mm/YYYY e hh:mm
	 * @return vetor de tamanho dois com data e hora separados
	 * @contact https://www.geniuns.com.br
	**/
	public function retornaDataBrasileiraParticionada($data,$formato){
		//quebra a data em data e hora
		$__data = split(" ",$data);
		//quebra a data em dia mes e ano
		$_data = split("/",$__data[0]);
		//quebra a hora em hora, minuto e segundo
		$_hora = split(":",$__data[1]);

		if ($formato=="dd/mm/yyyy"){
			$dataAux = $__data[0];
		} elseif($formato=="dd/mm") {
			$dataAux = $_data[0]."/".$_data[1];
		} elseif($formato=="mm/yyyy") {
			$dataAux = $_data[1]."/".$_data[2];
		} elseif($formato=="dd/yyyy") {
			$dataAux = $_data[0]."/".$_data[2];
		} elseif($formato=="mm") {
			$dataAux = $_data[1];
		} elseif($formato=="dd") {
			$dataAux = $_data[1];
		} elseif($formato=="yyyy") {
			$dataAux = $_data[2];
		} elseif($formato=="hh") {
			$dataAux = $_hora[0];
		} elseif($formato=="mm") {
			$dataAux = $_hora[1];
		} elseif($formato=="ss") {
			$dataAux = $_hora[2];
		} elseif($formato=="dd/mm/yyyy hh") {
			$dataAux = $__data[0]." ".$_hora[0];
		} elseif($formato=="dd/mm/yyyy hh:mm") {
			$dataAux = $__data[0]." ".$_hora[0].":".$_hora[1];
		} else {
			$dataAux = "formato inexistente";
		}
		return $dataAux;
	}

	/**
	 * Função que retorna o mês por extenso
	 * @author Fabricio Silva
	 * @descrição	recebe uma data no formato YYYY-mm-dd hh:mm:ss e particiona
					em  dd/mm/YYYY e hh:mm
	 * @return o mês por extenso
	 * @contact https://www.geniuns.com.br
	**/
	public function retornaMesDeDataDoBanco($data){
		//quebra a data em data e hora
		$__data = split(" ",$data);
		$_data = split("-",$__data[0]);
		$_hora = split(":",$__data[1]);
		$dataAux = $this->retornaDiaMesPorMesAno($_data[1]."/".$_data[0],false);
		return $dataAux;
	}


	public function converteDataParaAnos($data){
		$__data = split(" ",$data);
		$_data = split("-",$__data[0]);
		$ano = date("Y");
		$mes = date("m");
		$dia = date("d");
		$idade = $ano-$_data[0];
		if ($_data[1]>$mes) {
			$idade = $idade - 1;
		} else if ($_data[1]==$mes) {
			if ($_data[2]>$dia) {
				$idade = $idade - 1;
			} //else if ($_data[2]=$dia)
		}
		return $idade;
	}

	public function converteNumero($num){

		$num = str_replace('.','',$num);
		$num = str_replace(',','.',$num);
		return $num;
	}

	public function retornaDiaDaSemanaPornumero($num){
		if ($num == 7 or $num == 0){
			return "Domingo";
		}elseif($num == 1){
			return "Segunda";
		}elseif($num == 2){
			return "Terça";
		}elseif($num == 3){
			return "Quarta";
		}elseif($num == 4){
			return "Quinta";
		}elseif($num == 5){
			return "Sexta";
		}elseif($num == 6){
			return "Sábado";
		}
	}


	/**
	 * Função que dimenciona a foto no tamanho desejado
	 * @author Fabricio Silva
	 * @descrição recebe uma data no formato mm/YYYY
	 * @return o mês por extenso
	 * @contact https://www.geniuns.com.br
	**/
	public function retornaDiaMesPorMesAno($mesAno,$flagAno=false){

		$aux = explode("/",$mesAno);
		$mes = intval($aux[0]);
		$ano = intval($aux[1]);

		if($mes==1)			{ $strmes = "Janeiro "; }
		elseif($mes==2)		{ $strmes = "Fevereiro "; }
		elseif($mes==3)		{ $strmes = "Março "; }
		elseif($mes==4)		{ $strmes = "Abril "; }
		elseif($mes==5)		{ $strmes = "Maio "; }
		elseif($mes==6)		{ $strmes = "Junho "; }
		elseif($mes==7)		{ $strmes = "Julho "; }
		elseif($mes==8)		{ $strmes = "Agosto "; }
		elseif($mes==9)		{ $strmes = "Setembro "; }
		elseif($mes==10)	{ $strmes = "Outubro "; }
		elseif($mes==11)	{ $strmes = "Novembro "; }
		elseif($mes==12)	{ $strmes = "Dezembro "; }
		
		if ($flagAno){
			return $strmes." de ".$ano;
		} else {
			return $strmes;
		}
		
	}

	public function geraTextoLimpo($texto,$caixa = 'B'){
		/* função que gera uma texto limpo pra virar URL:
		   - limpa acentos e transforma em letra normal
		   - limpa cedilha e transforma em c normal, o mesmo com o ñ
		   - transforma espaços em hifen (-)
		   - tira caracteres invalidos
		  by Micox - elmicox.blogspot.com - www.ievolutionweb.com
		*/
		//desconvertendo do padrão entitie (tipo &aacute; para á)
		//$texto = html_entity_decode($texto);
		//tirando os acentos
		$texto = eregi_replace('[aáàãâä]','a',$texto);
		$texto = eregi_replace('[eéèêë]','e',$texto);
		$texto = eregi_replace('[iíìîï]','i',$texto);
		$texto = eregi_replace('[oóòõôö]','o',$texto);
		$texto = eregi_replace('[uúùûü]','u',$texto);
		$texto = eregi_replace('[AÁÀÃÂÄ]','A',$texto);
		$texto = eregi_replace('[EÉÈÊË]','E',$texto);
		$texto = eregi_replace('[IÍÌÎÏ]','I',$texto);
		$texto = eregi_replace('[OÓÒÕÔÖ]','O',$texto);
		$texto = eregi_replace('[UÚÙÛÜ]','U',$texto);
		//parte que tira o cedilha e o ñ
		$texto = eregi_replace('[ç]','c',$texto);
		$texto = eregi_replace('[Ç]','C',$texto);
		$texto = eregi_replace('[Ñ]','N',$texto);
		$texto = eregi_replace('[ñ]','n',$texto);
		//trocando espaço em branco por underline
		if ($caixa!='N') { 
			$texto = eregi_replace('( )','-',$texto);
			$texto = eregi_replace('--','-',$texto);
			$texto = eregi_replace('--','-',$texto);
		}
		$texto = eregi_replace('["]','',$texto);
		$texto = eregi_replace("[']","",$texto);
		//tirando outros caracteres invalidos manstendo os espaços
		$texto = eregi_replace('[^( )a-z0-9\-]','',$texto);

		if ($caixa=='A') {
			return strtoupper($texto);
		} else  {
			return strtolower($texto);
		}

	}

	/* Converte formato TIMESTAMP do Unix para o humano
	   1072834230 -> 30/12/2003 23:30:59 */
	public function timestamp_para_humano($ts) {
		$d=getdate($ts);
		$yr=$d["year"];
		$mo=$d["mon"];
		$da=$d["mday"];
		$hr=$d["hours"];
		$mi=$d["minutes"];
		$se=$d["seconds"];
		return date('d/m/Y H:i', mktime($hr,$mi,$se,$mo,$da,$yr));
	}

	/* Converte formato TIMESTAMP do Unix para o humano
	   1072834230 -> 30/12/2003 */
	public function timestamp_para_humano_sem_hora($ts) {
		$d=getdate($ts);
		$yr=$d["year"];
		$mo=$d["mon"];
		$da=$d["mday"];
		$hr=$d["hours"];
		$mi=$d["minutes"];
		$se=$d["seconds"];
		return date('d/m/Y', mktime($hr,$mi,$se,$mo,$da,$yr));
	}

	/* Converte formato DATETIME do MySQL para o TIMESTAMP do Unix
	   30/12/2008 23:30 -> 1072834230 */
	public function datetime_bra_para_timestamp($dt) {

		$yr=strval(substr($dt,6,4));
		$mo=strval(substr($dt,3,2));
		$da=strval(substr($dt,0,2));
		$hr=strval(substr($dt,11,2));
		$mi=strval(substr($dt,14,2));
		$se=strval(substr($dt,17,2));

		return mktime($hr,$mi,$se,$mo,$da,$yr);
	}

	/* Converte formato DATETIME do MySQL para o TIMESTAMP do Unix
	   30/12/2008 -> 1072834230  */
	public function date_bra_para_timestamp($dt) {

		$yr=strval(substr($dt,6,4));
		$mo=strval(substr($dt,3,2));
		$da=strval(substr($dt,0,2));

		$retorno = mktime(0,0,0,$mo,$da,$yr);
		return $retorno;
	}

	/**
	 * Função que uma data por extenso (Salvador, xx de mês de XXXX)
	 * @author Fabricio Silva
	 * @descrição recebe uma data no formato dd/mm/YYYY
	 * @contact https://www.geniuns.com.br
	**/
	public function retornaDataPorExtenso($data){
		$aux = explode(" ",$data);
		$aux1 = explode("/",$aux[0]);
		//$diaSemana = $this->retornaDiaDaSemanaPornumero($aux[0]);
		$mes = $this->retornaDiaMesPorMesAno($aux1[1]."/".$aux1[2]);
		
		return "Salvador, ".$aux1[0]." de ".$mes." de ".$aux1[2];
	}

	/**
	 * Função que uma data por extenso (Salvador, xx de mês de XXXX)
	 * @author Fabricio Silva
	 * @descrição recebe uma data no formato dd/mm/YYYY
	 * @contact https://www.geniuns.com.br
	**/
	public function retornaDataPorExtensoComHora($data){
		$aux = explode(" ",$data);
		$aux1 = explode("/",$aux[0]);
		//$diaSemana = $this->retornaDiaDaSemanaPornumero($aux[0]);
		$mes = $this->retornaDiaMesPorMesAno($aux1[1]."/".$aux1[2]);
		
		return "Salvador, ".$aux1[0]." de ".$mes." de ".$aux1[2]." às ".$aux[1];
	}

	public function valorPorExtenso($valor=0) {
		/*
		valorPorExtenso - ? :)
		Copyright (C) 2000 andre camargo

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

		Andr&eacute;) Ribeiro Camargo (acamargo@atlas.ucpel.tche.br)
		Rua Silveira Martins, 592/102
		Canguçu-RS-Brasil
		CEP 96.600-000
		*/

		// funcao............: valorPorExtenso
		// ---------------------------------------------------------------------------
		// desenvolvido por..: andré camargo
		// versoes...........: 0.1 19:00 14/02/2000
		//                     1.0 12:06 16/02/2000
		// descricao.........: esta função recebe um valor numérico e retorna uma 
		//                     string contendo o valor de entrada por extenso
		// parametros entrada: $valor (formato que a função number_format entenda :)
		// parametros saída..: string com $valor por extenso

		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
	"quatrilhões");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
	"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
	"sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
	"dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
	"sete", "oito", "nove");

		$z=0;

		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];

		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
		
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
	$ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
	($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		return($rt ? $rt : "zero");
	}

	/**
	 * Função que retorna o valor ITN com base na seguinte tabela
	 *   Homem:
	 *		75-104  : ITN 10
	 *		105-139 : ITN 9
	 *		140-175 : ITN 8
	 *		176-209 : ITN 7
	 *		210-244 : ITN 6
	 *		245-268 : ITN 5
	 *		269-293 : ITN 4
	 *		294-337 : ITN 3	
	 *		338-362 : ITN 2
	 *		363-430 : ITN 1
	 *
	 *	Mulheres:
	 *		57-79   : ITN 10
	 *		80-108  : ITN 9
	 *		109-140 : ITN 8
	 *		141-171 : ITN 7
	 *		172-205 : ITN 6
	 *		206-230 : ITN 5
	 *		231-258 : ITN 4
	 *		259-303 : ITN 3
	 *		304-344 : ITN 2
	 *		345-430 : ITN 1

	 * @author Fabricio Silva
	 * @valor -> valor total da avalizacao
  	 * @sexo ->  sexo do aluno
	 * @contact https://www.geniuns.com.br
	**/
	function retornaValorITNAluno($valor,$sexo){
		
		if ($valor=="" or ($sexo!="F" and $sexo!="M")){
			$itn = 10;	
		} else {
			if ($sexo == "F"){
				if ($valor >= 57 and $valor <= 79 ) { $itn = 10; } 
				else if ($valor >= 80 and $valor <= 108 ) { $itn = 9; }
				else if ($valor >= 109 and $valor <= 140 ) { $itn = 8; }
				else if ($valor >= 141 and $valor <= 171 ) { $itn = 7; }
				else if ($valor >= 172 and $valor <= 205 ) { $itn = 6; }
				else if ($valor >= 206 and $valor <= 230 ) { $itn = 5; }
				else if ($valor >= 231 and $valor <= 258 ) { $itn = 4; }
				else if ($valor >= 259 and $valor <= 303 ) { $itn = 3; }
				else if ($valor >= 304 and $valor <= 344 ) { $itn = 2; }
				else if ($valor >= 345 and $valor <= 430 ) { $itn = 1; }
				else { $itn = 10; }
			} else {
				if ($valor >= 75 and $valor <= 104 ) { $itn = 10; }
				else if ($valor >= 105 and $valor <= 139 ) { $itn = 9; }
				else if ($valor >= 140 and $valor <= 175 ) { $itn = 8; }
				else if ($valor >= 176 and $valor <= 209 ) { $itn = 7; }
				else if ($valor >= 210 and $valor <= 244 ) { $itn = 6; }
				else if ($valor >= 245 and $valor <= 268 ) { $itn = 5; }
				else if ($valor >= 269 and $valor <= 293 ) { $itn = 4; }
				else if ($valor >= 294 and $valor <= 337 ) { $itn = 3; }
				else if ($valor >= 338 and $valor <= 362 ) { $itn = 2; }
				else if ($valor >= 363 and $valor <= 430 ) { $itn = 1; }
				else { $itn = 10; }
			}
		}
		//echo $valor." - ".$sexo." - ".$itn; exit;
		return $itn;
	}

	public function retornaDiasAtrasoPgto($dataVenc,$dataPgto){

		$umDia = 84600;

		$dtPgto = $this->date_bra_para_timestamp($dataVenc);
		$dtVenc = $this->date_bra_para_timestamp($dataPgto);
		$diaVenc = date("N",$dtVenc);
		if ($diaVenc == 6){
			$dtVenc = $dtVenc + ($umDia*2);
		} else if ($diaVenc == 7){
			$dtVenc = $dtVenc + $umDia;
		}

		$retorno = intval(($dtVenc - $dtPgto)/$umDia);
		return $retorno;
	}


	public function calculaDayIntoDate($date,$days, $op=null) {

		$thisyear	= substr ( $date, 0, 4 );
		$thismonth	= substr ( $date, 4, 2 );
		$thisday	= substr ( $date, 6, 2 );

		if($op == null || $op == '+'){
			$nextdate	= mktime ( 0, 0, 0, $thismonth, $thisday + $days, $thisyear );
		}elseif($op == '-'){
			$nextdate	= mktime ( 0, 0, 0, $thismonth, $thisday - $days, $thisyear );
		}
				
		return strftime("%Y%m%d", $nextdate);
	}


}

?>