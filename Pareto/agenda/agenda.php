<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='../index.php';
	</SCRIPT>");
}
require('../bd/datos.php');
$querys = new consultas;

$perfil = $_SESSION['perfil'];
$ultimoingreso = date("Y-m-d H:i:s");
$horaingreso = date("H:i:s");
$creador = $_SESSION["idus"];
$consultor = $querys->usuarios();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta charset="iso-8859-1">
    <!-- TABS -->
	<link rel="stylesheet" href="base/jquery.ui.all.css">
	<script src="js/jquery-1.8.0.js"></script>
    <script src="js/jquery-1.7.2.js"></script>
	<script src="js/ui/jquery.ui.position.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.button.js"></script>
	<!-- TABS -->
    <script src="ui/jquery.ui.tabs.js"></script>
    <!-- TABS -->
	<script src="ui/jquery.ui.dialog.js"></script>
	<link rel="stylesheet" href="css/demos.css">
	<style>
	#dialog label, #dialog input { display:block; }
	#dialog label { margin-top: 0.5em; }
	#dialog input, #dialog textarea { width: 95%; }
	#tabs { margin-top: 1em; }
	#tabs li .ui-icon-close { float: left; margin: 0.4em 0.2em 0 0; cursor: pointer; }
	#newTab { cursor: pointer; }
	.button {
		margin: 0 0.5em;
		background-color: #d8d6d2;
		padding-top: 2px;
		padding-bottom: 2px;
		background-color: #f5f3ee;
		text-align: center;
		color: #a5a29b;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 9pt;
		border: solid 1px;
		cursor: pointer;
	}
	</style>
	<script>
	$(function() {
		var $tab_title_input = $( "#tab_title"),$tab_title_inputV = $( "#tab_titleV")
			$tab_content_input = $( "#tab_content" );
		var tab_counter = 2;

		// tabs init with a custom tab template and an "add" callback filling in the content
		var $tabs = $( "#tabs").tabs({
			tabTemplate: "<li><a href='#{href}' onclick=test('#{href}');>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
			add: function( event, ui ) {
				var id = tab_counter;
				
				var tab_title = $tab_title_input.val();
				var tab_titleV = $tab_title_inputV.val();
				
				var usuario = tab_title.split('-');
				var usuarioV = tab_titleV.split('-');
				
				var usu = usuario[0];
				var usuV = usuarioV[0];
				
				var tipo;
				var tab_content;
				
				if(usu != "0" && usuV == "0")
				{
					tipo = 'calendario';
				}
				
				if(usu == "0" && usuV != "0")
				{
					tipo = 'visitas';
				}
								
								
				if(tipo == 'calendario')
				{
					tab_content = "<iframe id='"+id+"' src='newcalen.php?user="+usu+"&espacio=' frameborder='0' style='width:100%; height:900px;'></iframe>";
					$( ui.panel ).append(tab_content);
				}
				
				if(tipo == 'visitas')
				{	
					tab_content = "<iframe id='"+id+"' src='visitas.php?user="+usuV+"' frameborder='0' style='width:100%; height:900px;'></iframe>";
					$( ui.panel ).append(tab_content);
				}
				
				
			}
		});
			
		// modal dialog init: custom buttons and a "close" callback reseting the form inside
		
		/* Calendario */
		var $dialog = $( "#dialog" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Agregar: function() {
					var tab_title = $tab_title_input.val() || "Tab " + tab_counter;
					var usuario = tab_title.split('-');
					
					if(usuario[0] != 0)
					{
						addTab();
						$( this ).dialog( "close" );
					}
					else
					{
						alert('debe seleccionar un consultor');	
					}
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
		
		// addTab form: calls addTab function on submit and closes the dialog
		var $form = $( "form", $dialog ).submit(function() {
			addTab();
			$dialog.dialog( "close" );
			return false;
		});

		// actual addTab function: adds new tab using the title input from the form above
		function addTab() {
			var tab_title = $tab_title_input.val() || "Tab " + tab_counter;
			var usuario = tab_title.split('-');
			$tabs.tabs( "add", "#tabs-" + tab_counter, usuario[1]);
			tab_counter++;
		}
		/* Calendario */
		
		/*visitas*/
		var $dialog1 = $( "#dialogV" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Agregar: function() {
					var tab_titleV = $tab_title_inputV.val() || "Tab " + tab_counter;
					var usuarioV = tab_titleV.split('-');
					
					if(usuarioV[0] != 0)
					{
						addTabV();
						$( this ).dialog( "close" );
					}
					else
					{
						alert('debe seleccionar un consultor');	
					}
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			},
			open: function() {
				$tab_title_inputV.focus();
			},
			close: function() {
				$form[ 0 ].reset();
			}
		});
		
		// addTab form: calls addTab function on submit and closes the dialog
		var $form = $( "form", $dialog ).submit(function() {
			addTabV();
			$dialogV.dialog( "close" );
			return false;
		});

		// actual addTab function: adds new tab using the title input from the form above
		function addTabV() {
			var tab_title = $tab_title_inputV.val() || "Tab " + tab_counter;
			var usuario = tab_title.split('-');
			$tabs.tabs( "add", "#tabs-" + tab_counter, usuario[1] );
			tab_counter++;
		}
		/*visitas*/

		// addTab button: just opens the dialog
		$( "#newTab" ).click(function() {
				$dialog.dialog( "open" );
			});
		
		$( "#newTabV" ).click(function() {
				$dialog1.dialog( "open" );
			});

		// close icon: removing the tab on click
		// note: closable tabs gonna be an option in the future - see http://dev.jqueryui.com/ticket/3924
		$( "#tabs span.ui-icon-close" ).live( "click", function() {
			var index = $( "li", $tabs ).index( $( this ).parent() );
			$tabs.tabs( "remove", index );
		});
	});
	</script>
    <script type="text/javascript" language="javascript">
	function test(id)
	{
		var idframe = id.split('-');
		
		document.getElementById(idframe[1]).contentDocument.location.reload(true);
	}
	</script>
<!-- TABS -->

<script type="text/javascript" language="javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>
<body>

<div class="demo">

	<div id="dialog" title="Agregar Calendario">
		<form>
			<fieldset class="ui-helper-reset">
				<label for="tab_title">Usuarios</label>
				<select name="tab_title" id="tab_title" value="" class="ui-widget-content ui-corner-all">
                	<option value="0-0-calen">Seleccione el usuario que desea consultar</option>
                	<?php
					foreach ($consultor as $Consul)
					{
						if($creador != $Consul["id"])
						{
					?>
                    	<option value="<?php echo $Consul["id"]."-".$Consul["nombre"]."-calen"; ?>"><?php echo $Consul["nombre"]; ?></option>
                    <?php
						}
					}
					?>
                </select>
			</fieldset>
		</form>
	</div>
    
    <div id="dialogV" title="Consultar Visitas">
		<form>
			<fieldset class="ui-helper-reset">
				<label for="tab_titleV">Usuario <?php echo $creador;?></label>
				<select name="tab_titleV" id="tab_titleV" value="" class="ui-widget-content ui-corner-all">
                	<option value="0-0-visit">Seleccione el consultor que desea invitar</option>
                	<?php
					foreach ($consultor as $Consul)
					{
						if($creador != $Consul["id"])
						{
					?>
                    	<option value="<?php echo $Consul["id"]."-".$Consul["nombre"]."-visit"; ?>"><?php echo $Consul["nombre"]; ?></option>
                    <?php
						}
					}
					?>
                </select>
			</fieldset>
		</form>
	</div>
	
    <!-- consultores -->
    <?php
	if(($perfil == "1")or($perfil == "2"))
	{
	?>
	<button id="newTab" class="button">Agregar Calendario</button>
    <?php
	}
	?>
	<a href="../pareto_activo.php"><button id="volver" class="button">Volver</button></a>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Mi Calendario</a></li>
		</ul>
		<div id="tabs-1">
        <iframe src="newcalen.php?user=<?php echo $creador; ?>&espacio=" frameborder="0" style="width:100%; height:900px;"></iframe>
		</div>
	</div>
</div><!-- End demo -->
</body>
</html>
