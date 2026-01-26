<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='../index.php';
	</SCRIPT>");
}
require('../bd/datos.php');
$querys = new consultas;

if($_GET)
{
	if($_GET["espacio"] != "")
	{
		if ($_GET["espacio"] == "false")
		{
			echo "<script>alert('No puede utilizar este espacio puesto que ya esta designado para otro evento en el calendario de alguno de sus invitados.');</script>";
		}	
	}
}

$consultante = $_SESSION["idus"];
$perfil1 = $_SESSION["perfil"];
$creador = $_GET["user"];

/*EVENTOS*/
$eventos = array();
$sqlU = "SELECT * FROM pareto_actividades WHERE id_usuario = '$creador'";
$consU = new base_datos;
$consU->connect();
$resU = $consU->query($sqlU);
while($itemU = $consU->fetch_row($resU))	{
	array_push($eventos,$itemU);
}
/*EVENTOS*/


/*TIPOS DE EVENTOS*/
$tpevento = array();
$sqlTE = "SELECT * FROM tipo_actividad";
$consTE = new base_datos;
$consTE->connect();
$resTE = $consTE->query($sqlTE);
while($itemTE = $consTE->fetch_row($resTE))	{
	array_push($tpevento,$itemTE);
}
/*TIPOS DE EVENTOS*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>

	<link rel='stylesheet' type='text/css' href='css/reset.css' />
	<link rel='stylesheet' type='text/css' href='css/jquery-ui.css' />
	<link rel='stylesheet' type='text/css' href='css/jquery.weekcalendar.css' />
	<link rel='stylesheet' type='text/css' href='css/demo.css' />
	
    <style>
		.ver{display:block;}
		.nover{display:none;}
	</style>	
	<script type='text/javascript' src='js/jquery.min.js'></script>
	<script type='text/javascript' src='js/jquery-ui.min.js'></script>
	<script type='text/javascript' src='js/jquery.weekcalendar.js'></script>
<!-- calendario --> 
<script type="text/javascript" language="javascript">
(function($){
	$(document).ready(function() {
   var $calendar = $('#calendar');
   var id = 0;
   /*mis eventos*/
   var idmios = new Array();
   
   <?php
	for($i = 0; $i<count($eventos); $i++){
		echo 'idmios['. $i .'] = '. $eventos[$i]["id"] .';';
		
	}
	?>
   /*mis eventos*/

   $calendar.weekCalendar({
	  <?php
	  if($consultante != $creador)
	  {
	  ?>
	  readonly: true,
	  <?php
	  }
	  else
	  {
	  ?>
	  	readonly: false,
	  <?php
	  }
	  ?>
      timeslotsPerHour : 2,
      allowCalEventOverlap : true,
      overlapEventsSeparate: true,
      firstDayOfWeek : 1,
      businessHours :{start: 0, end: 24, limitDisplay: true },
      daysToShow : 7,
	  height : function($calendar) {
         return $(window).height() - $("h1").outerHeight() - 1;
      },
      eventRender : function(calEvent, $event) {
         if (calEvent.end.getTime() < new Date().getTime()) {
            $event.css("backgroundColor", "#aaa");
            $event.find(".wc-time").css({
               "backgroundColor" : "#999",
               "border" : "1px solid #888",
			   readOnly : true
            });
         }
      },
	  draggable : function(calEvent, $event) {
		  if($.inArray(calEvent.id, idmios) != -1)
		  {
			  return calEvent.readOnly != false;
		  }
		  else
		  {
			  return calEvent.readOnly == false;
		  }
		  
	  },
      resizable : function(calEvent, $event) {
		  if($.inArray(calEvent.id, idmios) != -1)
		  {
			  return calEvent.readOnly != true;
			  
		  }
		  else
		  {
			  return calEvent.readOnly == true;
		  }
      },
      eventNew : function(calEvent, $event) {
		 var f = new Date();
		 var fechahoy = (f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
		 var h2 = (f.getHours());
		 var m2 = (f.getMinutes());
		 var fechainicial = new Date(calEvent.start);
		 var s1 = fechainicial.toLocaleDateString("en-US");
		 var h1 = (new Date(calEvent.start)).getHours();
		 var m1 = (new Date(calEvent.start)).getMinutes();
		 var s2 = s1.split('/');
		 var fechainicio = s2[1]+'/'+s2[0]+'/'+s2[2]; 
		 var i = new Date(fechahoy).getTime();
		 var f = new Date(fechainicio).getTime();
		 
		 //alert(h2);
		 //alert(h1);
		 
		if(i > f){
		    alert('No es posible crear un evento con fecha anterior');
			location.reload();
		} else {
			if ((i > f)&&(parseInt(h2) > parseInt(h1))){
				alert('No es posible crear un evento con hora anterior');
				location.reload();
			} else if ((i > f)&&((parseInt(h2) === parseInt(h1))&&(parseInt(m2) >= parseInt(m1)))) {
				alert('No es posible crear un evento con hora anterior');
				location.reload();
			} else {
			 var $dialogContent = $("#event_edit_container");
			 resetForm($dialogContent);
			 var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
			 var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
			 var titleField = $dialogContent.find("input[name='title']");
			 var bodyField = $dialogContent.find("textarea[name='body']");
			 
			 var invitadoName = $dialogContent.find("textarea[name='invitados']");
			 var invitado = $dialogContent.find("textarea[name='invitadosid']");
			 
			 var entidad = $dialogContent.find("input[name='entidad']");
			 var nivelS = $dialogContent.find("select[name='nivelservicio']");
			 var tpevento = $dialogContent.find("select[name='tpevento']");
		
			 $("#invitados").css("display","block");
			 $dialogContent.dialog({
				modal: true,
				title: "Nuevo evento",
				close: function() {
				   $dialogContent.dialog("destroy");
				   $dialogContent.hide();
				   $('#calendar').weekCalendar("removeUnsavedEvents");
				},
				buttons: {
				   Guardar : function() {
					  calEvent.id = id;
					  id++;
					  calEvent.start = new Date(startField.val());
					  calEvent.end = new Date(endField.val());
					  calEvent.title = titleField.val();
					  calEvent.body = bodyField.val();
					  calEvent.invitadoName = invitadoName.val();
					  calEvent.invitado = invitado.val();
					  calEvent.nivelS = nivelS.val();
					  calEvent.entidad = entidad.val();
					  calEvent.tpevento = tpevento.val();
					  var navegador = navigator.appName;
					  
					  var datos = calEvent.id+'='+calEvent.start+'='+calEvent.end+'='+calEvent.title+'='+calEvent.body+'='+<?php echo $creador; ?>+'='+calEvent.invitado+'='+calEvent.entidad+'='+calEvent.tpevento+'='+calEvent.nivelS+'='+navegador;
					  
					  //alert('saveevent.php?datos='+datos);
					   
					  window.location = 'saveevent.php?datos='+datos;

					  $calendar.weekCalendar("removeUnsavedEvents");
					  $calendar.weekCalendar("updateEvent", calEvent);
					  $dialogContent.dialog("close");
				   },
				   Cancelar : function() {
					  $dialogContent.dialog("close");
				   }
				}
			 }).show();	
				
			 $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
			 setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
			 $dialogContent.find("select[name='nivelservicio']").val(calEvent.nivelS);
			 $dialogContent.find("input[name='entidad']").val(calEvent.entidad);
			}
		}
	  }, 
      eventDrop : function(calEvent, $event) {
			  /*var id = calEvent.id;
			  var start = calEvent.start; 
			  var end = calEvent.end;
			  var title = calEvent.title;
			  var content = calEvent.body;
			  var entidad = calEvent.entidad;
			  var ticket = calEvent.ticketid;
			  
		  		
		  
			  var datos = id+'='+start+'='+end+'='+title+'='+content+"="+entidad+"="+<?php echo $creador; ?>+"="+ticket;
		  		
		  	alert('dropevent.php?datos='+datos);
		  
		  	  window.location = 'dropevent.php?datos='+datos;*/
			  alert('Accion no valida');
			  window.location = 'newcalen.php?user=<?php echo $consultante;?>&espacio=';
      },
      eventResize : function(calEvent, $event) {
		  var id = calEvent.id;
		  var end = calEvent.end;
		  
		  var datosresize = id+'='+end;
		  
		  window.location = 'resizeevent.php?datosresize='+datosresize;
      },
      eventClick : function(calEvent, $event) {
		  var id = calEvent.id;
		  //alert (id);
		  var respuesta = 0;
		  if(id != ''){
			//CONFIRMA SI AUN ESTA ACTIVO POR FECHA//
			var parametros = {
                "id" : id,
			};
			//alert(parametros);
			$.ajax({
				data:  parametros, //datos que se envian a traves de ajax
				url:   'verificar_evento.php', //archivo que recibe la peticion
				type:  'post', //método de envio
				success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
						var respuesta = response;
						//alert (respuesta);
				}
			});
		  }	
		
		<?php if($consultante == $creador) { ?>
	     var opcion = confirm('El evento debe ser editado desde el pareto actual');
			if (opcion == true) {
				window.top.location.href = '../editar_actividad.php?id='+id;;
			} else {
				location.reload();
			}	
		 <?php } else { ?>
		 alert('No puede editar evento diferentes a los propios');
		 <?php } ?>
      },
      eventMouseover : function(calEvent, $event) {
      },
      eventMouseout : function(calEvent, $event) {
      },
      noEvents : function() {
      },
      data : function(start, end, callback) {
         callback(getEventData());
      }
   });

   function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
   }
   
      function getEventData() {
	  return {
         events : [
		 	
			
			<?php
			foreach ($eventos as $E)
			{
			$fecha_inicio = date('Y,m,d',strtotime("-1 month",strtotime($E["fecha"])));
			//$fecha_inicio = str_replace('-',', ',$f_i);
			$h_i = substr($E["hora"],0,-3);
			$hora_inicio = str_replace(':',', ',$h_i);
			$fecha_final = date('Y,m,d',strtotime("-1 month",strtotime($E["fecha_fin"])));
			//$fecha_final = str_replace('-',', ',$E["fecha_fin"]);
			$h_f = substr($E["hora_fin"],0,-3);
			$hora_final = str_replace(':',', ',$h_f);
			
			?>
				{
				   "id":<?php echo $E["id"]; ?>,
				   "start": new Date(<?php echo $fecha_inicio.", ".$hora_inicio;?>),
				   "end": new Date(<?php echo $fecha_final.", ".$hora_final;?>),
				   "title":"<?php echo $E["descripcion"]; ?>",
				   "body":"<?php echo $E["descripcion"]; ?>",
				   "entidad":"",
				   "invitadosname":"",
				   "invitadosid":"",
					"ticketid":"",
					"nivelS":"",
					"tpevento":"",
					"creador":"<?php echo $E["id_usuario"]?>"
				},
			<?php
	  		}
			?>
         ]
      };
   }


   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

      }

      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $(this).find(":selected").val();
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $(this).val();
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });
   
   /* dialogo de invitados */
	$( "#invitados" ).click(function() {
		$dialoginv.dialog( "open" );
	});
   
   var $dialoginv = $( "#dialoginv" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Agregar: function() {
					$('#listInvitados').empty();
					$('#listInvitadosId').empty();
					var invitados = '';
					var invit = invitados.split('-');
					
					var countInv = invit.length - 1;
					
					var names = '';
					var ids = '';
 					
					for(var i = 0; i < countInv; i++)
					{	
						var nameInv = invit[i].split(':');
						names += nameInv[1]+'\n';
						ids += nameInv[0]+'-\n';
					}
					
					$('#listInvitados').attr('value', names);
					$('#listInvitadosId').attr('value', ids);
					
					$( this ).dialog( "close" );
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			},
			open: function() {
				$tab_title_input.focus();
			},
			close: function() {
				$form[ 0 ].reset();
			}
		});
   /* dialogo de invitados */
   
   /*dialogo mensajes*/
   
   /*dialogo de mensajes*/
});
})(jQuery);
</script>
<!-- calendario -->
<title>Calendario HS</title>
</head>
<body>
<input type="hidden" id="consultante" value="<?php echo $consultante; ?>" />
	<div id='calendar'></div>
	<div id="event_edit_container">
		<form method="post" action="saveevent.php">
			<input type="hidden" name="idticket" />
			<table id="tabla_evento">
				<tr>
                	<td colspan="2">
						<span>Fecha: </span><span class="date_holder"></span>
                    </td>
				</tr>
				<tr>
                	<td align="left">
					<label for="start">Hora Inicio: </label>
					</td>
				</tr>
				<tr>
					<td align="center">
						<select name="start"><option value="">Seleccione la Hora de inicio del evento</option></select>
                    </td>
				</tr>
				<tr>
                	<td>
					<label for="end">Hora Final: </label>
                    </td>
				</tr>
				<tr>
					<td align="center">
						<select name="end"><option value="">Seleccione la hora final del evento</option></select>
                    </td>
				</tr>
				<tr>
                	<td>
					<label for="body">Descripcion: </label>
                    </td>
				</tr>
				<tr>
					<td align="center">
						<textarea name="body"></textarea>
                    </td>
				</tr>
                <tr>
                	<td>
					<label for="tpevento" id="tpevento">Tipo de Actividad: </label>
					</td>
				</tr>
				<tr>
					<td align="center">
                    <select name="tpevento">
                    	<?php
						foreach($tpevento as $TE)
						{
						?>
                        	<option value="<?php echo $TE["id"]; ?>"><?php echo $TE["detalle"]; ?></option>
                        <?php
						}
						?>
                    </select>
                    </td>
				</tr>
			</table>
		</form>
	</div>
    
    
</body>
</html>
