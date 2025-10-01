<?php
	require_once($path_inc."/classes/action/AcessoAction.php");
	
	/*******************************************************************************************
	Navegação
	********************************************************************************************/
	$link				= str_replace("".strtolower($caminho)."","",strtolower($_SERVER ['REQUEST_URI']));
	$paramNaveg			= array("link"=>$link);
	$navegacao			= new AcessoAction("geraNavegacao",$paramNaveg);
	echo $navegacao->retorno; 

	//Paramentros de entrada

	if(isset($_REQUEST["tipo"]) && $_REQUEST["tipo"] == "eventos"){
		$param	= "and il.ide_local in (3,7)";
		$title	= "Calendário SEPLAN (Auditório e Externo)";

	}elseif(isset($_REQUEST["tipo"]) && $_REQUEST["tipo"] == "ucs"){
		$param	= "and il.ide_local = 8";
		$title	= "Calendário SEPLAN (UCS)";

	}elseif(isset($_REQUEST["tipo"]) && $_REQUEST["tipo"] == "spf"){
		$param	= "and il.ide_local = 10";
		$title	= "Calendário SEPLAN (SPF)";

	}elseif(isset($_REQUEST["tipo"]) && $_REQUEST["tipo"] == "nlcc"){
		$param	= "and il.ide_local = 11";
		$title	= "Calendário SEPLAN (NLCC)";

	}else{
		header( 'Location: '.XOOPS_URL.'') ;
	}


?>


	<script type="text/javascript">
	/*function isEmpty(obj) {
		for(var prop in obj) {
			if(obj.hasOwnProperty(prop))
				return false;
		}

		return true;
	}*/

	var dateArr = []; 
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			theme: true,

			/*viewDisplay: function(view){
				 dateArr = [];                    
				 var today = view.start;
				 var viewData = $('#calendar').fullCalendar('getView');
				 cMonth = today.getMonth();
				 cYear = today.getFullYear();

				 $('td.ui-widget-content').each(function(){ // NEED TO MAKE SURE TO use ui-widget-content
					if( $(this).hasClass('fc-today') ) {
						// Let's not change anything... leave the default color for Today
					} else {
						$(this).css({ 'background':'none', 'background-color' : '#99FF66' }); // making default green notice that I need to make the background:none to remove the jQueryUI image bg
					}
				 });


				 $('.fc-day-number').each(function(){
					lDay = parseInt($(this).text());
					//check if it is another month date
					if($(this).parents('td').hasClass('fc-other-month'))
					{
						lYear = parseInt(cYear);
						//if it is belong to the previous month
						if(lDay>15)
						{
							lMonth = parseInt(cMonth) - 1;
							lDate = new Date(lYear,lMonth,lDay);
							dateArr.push(lDate);
						}
						else //belong to the next month
						{
							lMonth = parseInt(cMonth) + 1;
							lDate = new Date(lYear,lMonth,lDay);
							dateArr.push(lDate);
						}
					}
					else
					{
						lMonth = parseInt(cMonth);
						lDate = new Date(lYear,lMonth,lDay);
						dateArr.push(lDate);
					}
					
				});
				
				var m_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
				// using m_names to allow us to add text in the header based on month
				var thisMonthText = m_names[cMonth];
				var h2Text;
				if( thisMonthText == 'March' ) {
					h2Text = 'March Specials Here, and Best Fishing Species for this Month';
				} else {
					h2Text = 'Other Specials Here, and Best Fishing Species for this Month';
				}
				var cTD = $('<h2>').attr('id','h2added').css('color','red').text( h2Text );
				$('#h2added').remove();
				$('#calendar').before(cTD);
			},*/


			lazyFetching: true,
			editable: false,
			allDaySlot: false,
			//firstHour: 8,
			minTime: 8,
			maxTime: '22:00',


			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			},            
			eventRender: function(event,element){
				//rendering q-TIP WE can
				qtipContent = '<span class="qtipDesc">'+event.description+'</span>';
				
				//rendering color
				//foreach event check each day on the calendar
				for(var i in dateArr) {
					if(event.end == null) {
						event.end = event.start;
					}
					if( (dateArr[i].getTime() >= event.start.getTime())&&(dateArr[i].getTime() <= event.end.getTime()) ) {
						$('.fc-day'+i).css({ 'background':'none', 'background-color' : '#FFCCCC' }).addClass('red');
						// I'm adding the class of red so that we can use the event click option..
					}
				}                    
			},

			/*dayClick: function(date, allDay, jsEvent, view) {
				if( $(this).hasClass('red') ) {
					alert('Sorry this date is already taken.. :( ');
				} else {
					alert('Sweet, now we can take your info... :) ');
				}
			},*/
			dayClick: function(date, allDay, jsEvent, view) {
					$('#calendar').fullCalendar( 'changeView', 'agendaDay' );
					$('#calendar').fullCalendar( 'gotoDate', date );
			},

			eventClick: function(calEvent, jsEvent, view) {
				
	//			var dataBrasil = calEvent.start.getDate()+"/"+(calEvent.start.getMonth()+1)+"/"+calEvent.start.getFullYear();
				var horaBrasil = calEvent.hor_inicio+"-"+calEvent.hor_fim;
				var dia, mes;
				if(calEvent.start.getDate()<10){dia='0'+calEvent.start.getDate();}else{dia = calEvent.start.getDate();} 
				if((calEvent.start.getMonth()+1)<10){mes='0'+(calEvent.start.getMonth()+1);}else{dia = (calEvent.start.getMonth()+1);} 
				var dataBrasil = dia+'/'+mes+'/'+calEvent.start.getFullYear();

				/*alert('Evento: ' + calEvent.title +"\n"+ 'Descrição: ' + calEvent.detEvento +"\n"+ 'Data: ' + dataBrasil +"\n"+'Horário: ' + horaBrasil +"\n"+ 'Local: '+calEvent.desLocal +"\n"+ 'Setor: ' + calEvent.desSetor
					+"\n"+ 'Demandante: ' + calEvent.des_responsavel+"\n"+ 'Telefone: ' + calEvent.num_tel+"\n"+ 'Email: ' + calEvent.des_email);*/

				var localEvento;
				var descrEvento;

				//Se for Calendário Seplan ou UCS
				if (calEvent.ideLocal == 7 || calEvent.ideLocal == 8 || calEvent.ideLocal == 10 || calEvent.ideLocal == 11){
					localEvento = calEvent.localEvento;
				}else{
					localEvento = calEvent.desLocal;
				}
				//Detalhe do local do evento, principalmente para Calendário SEPLAN
				if (calEvent.detEvento != ""){
					descrEvento = '<strong style="color:#000000;"><b>Descrição:</b></strong> ' +calEvent.detEvento+ '<br>';
				}else{
					descrEvento = '';
				}


				var conteudo = '<strong style="color:#000000;"><b>Evento:</b></strong> ' +calEvent.title+'<br>' +descrEvento+ '<strong style="color:#000000;"><b>Data:</b></strong> ' +dataBrasil +'&nbsp&nbsp<strong style="color:#000000;"><b>Horário:</b></strong> ' +horaBrasil+'<br><strong style="color:#000000;"><b>Local:</b></strong> '+localEvento +'<br><strong style="color:#000000;"><b>Setor:</b></strong> ' +calEvent.desSetor+'<br><strong style="color:#000000;"><b>Demandante:</b></strong> ' +calEvent.des_responsavel+'<br><strong style="color:#000000;"><b>Telefone:</b></strong> ' +calEvent.num_tel+'<br><strong style="color:#000000;"><b>Email:</b></strong> ' +calEvent.des_email;

				//$('#popup').innerHTML = conteudo;
				document.getElementById('popup').innerHTML = conteudo;
				
				$("#popup").dialog();

				//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
				//alert('View: ' + view.name);
		
				// change the border color just for fun
				$(this).css('border-color', 'red');
		
			},

			events: "json-events.php"
			//events: "<?=$caminho?>classes/action/actionAux.php?acao=intraCalendarioListagem&param=<?=$param?>&crud=IntraCalendario"
		});


	});

	</script>
	<style type='text/css'>

		/*body {
			margin-top: 0px;
			text-align: center;
			font-size: 12px;
			font-family: "Trebuchet MS", sans-serif;
			}*/
			
		#loading {
			position: absolute;
			top: 200px;
			right: 300px;
			}

		#calendar {
			width: 590px;
			margin: 2 auto;
			margin-top:30px;
			}

		#popup{
			font-size: 12px;
			/*font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;*/
			font-family: "Trebuchet MS", sans-serif;
			text-align: left;
			
		}
	</style>



<!--Título-->
<div class="tituloPag">
	<!--img src="<?XOOPS_URL?>/uploads/img4f68835ba3ee5.png" width="30"-->
	<?=$title?>
</div>

<div id='loading' style='display:none'>Carregando...</div>
<div id='calendar'>

	<?php //include ("json-events.php"); ?>

	<div id='popup'></div>
</div>



