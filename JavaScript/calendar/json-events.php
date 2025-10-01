<?php

	//include ("../../../../mainfile.php");
/*
	$query = "	SELECT	ia.ide_auditorio, il.des_local, ia.des_setor, ia.des_responsavel, ia.des_email, 
						date_format(ia.dtc_evento,'%d/%m/%Y'), ia.des_evento, date_format(ia.hor_inicio,'%H:%i'), date_format(ia.hor_fim,'%H:%i'), ia.num_tel,
						ia.det_evento, 
						ia.ide_local, ia.outros
				FROM 	intra_auditorio ia, intra_local_evento il
				WHERE	ia.ide_local = il.ide_local and
						il.ide_local in (3,7) 
				ORDER BY ia.dtc_evento;";

	$result = $xoopsDB->query($query);
	$total = mysql_num_rows($result);

	while ( list($id, $des_local, $des_setor, $des_responsavel, $des_email, $dtc_evento,
					$des_evento, $hor_inicio, $hor_fim, $num_tel, $det_evento, $ideLocal, $outros) = $xoopsDB->fetchRow($result) ) {
	
		//$year = date('Y');
		//$month = date('m');
		$data_aux	= explode("/", $dtc_evento);
		$data		= $data_aux[2]."-".$data_aux[1]."-".$data_aux[0];

		$even_array[] = array(
					'id' => "$id",
					'title' => utf8_encode("$des_evento"),
					//'start' => "2012-03-19 10:30:00Z",
					//'end' => "2012-03-21 14:30",

					'start' => $data.'T'.$hor_inicio,
					'end' => $data.'T'.$hor_fim,

					'detEvento' => utf8_encode("$det_evento"),
					'desLocal' => utf8_encode("$des_local"),
					'ideLocal'=> "$ideLocal",
					'localEvento' => utf8_encode("$outros"),
					'desSetor' => utf8_encode("$des_setor"),
					'des_responsavel' => utf8_encode("$des_responsavel"),
					'hor_inicio'=> "$hor_inicio",
					'hor_fim'=> "$hor_fim",
					'des_email' => "$des_email",
					'num_tel' => "$num_tel",
					'allDay' => false		//exibir ou não horário

					//'end' => "$year-$month-22",
					//'url' => "https://yahoo.com/"
				);
	}*/

		$even_array[] = array(
					'id' => "1",
					'title' => utf8_encode("des_evento"),
					'start' => "2015-05-19 10:30:00",
					'end' => "2015-05-21 14:30",

					//'start' => $data.'T'.$hor_inicio,
					//'end' => $data.'T'.$hor_fim,

					'detEvento' => utf8_encode('detevento'),
					'desLocal' => utf8_encode("des_local"),
					'ideLocal'=> "ideLocal",
					'localEvento' => utf8_encode("outros"),
					'desSetor' => utf8_encode("des_setor"),
					'des_responsavel' => utf8_encode("des_responsavel"),
					'hor_inicio'=> "hor_inicio",
					'hor_fim'=> "hor_fim",
					'des_email' => "des_email",
					'num_tel' => "num_tel",
					'allDay' => false		//exibir ou não horário

					//'end' => "$year-$month-22",
					//'url' => "https://yahoo.com/"
				);
	echo json_encode($even_array);


	/*echo json_encode(array(
	
		array(
			'id' => 222,
					'title' => "Event2",
					'start' => "2012-03-19T10:30:00Z",
					'end' => "2012-03-21T14:30:00Z",
					'allDay' => false
		)
	
	));*/

?>
