<?php 
include ("../Controlador/Sesion/autenticar.php");
include ("../Modelo/Viaje.php");

$viaje = new Viaje();
$id = base64_decode($_GET['id']);
$datos = $viaje->listarSillasViajePorId($id);
$datos_viaje = $viaje->listarViajePorId($id);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Vista Sillas</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <link href="../Resources/css/styles_sillas.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    

    .barra-principal{
      background-color: #5e99b1;
      width: auto;
    }

    .botones_principal{
      display: flex;
      justify-content: flex-end;
    }

    .boton-registro{
      background-color: #fff; 
      height: 40px; 
      margin-top: 10px; 
      margin-bottom: 10px; 
      color: #00a0df;
    }

    .img-frontal{
      width: 100px;
    }

    .img-trasera{
      width: 100px;
    }

    .img-izq{
      width: 100px;
    }

    .img-der{
      width: 100px;
    }

    @media (max-width: 760px){
      
        .fa-plus{
           display: none;
        }

        .titulo_principal{
          text-align: center;
        }

        .botones_principal{
          display: flex;
          justify-content: center;
        }

        .img-frontal{
          width: 100%;
        }

        .img-trasera{
          width: 100%;
        }

        .img-izq{
          width: 100%;
        }

        .img-der{
          width: 100%;
        }
    }
    .sillas{
	width:100%; 
	max-width:55px;
	height: auto; 
	max-height: 75px;
    }
    .letras{
	max-width:30px;
	height: auto; 
	max-height: 40px;
    }
    @media (max-width: 400px) {
  	.sillas{
	width:100%; 
	max-width:24px;
	height: auto; 
	max-height: 75px;
    	}
	.letras{
	max-width:30px;
	height: auto; 
	max-height: 21px;
    }
    }
  </style>
  <!--fin  styles -->
</head>
<body>

    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

      <div class="mt-2 p-4 table-responsive">
	  <form action="listadoViajesDisponibles.php" method="POST">
	  <input type="hidden" name="fecha" value="<?php echo $datos_viaje[0]['fecha'];?>"/>
	  <input type="submit" class="btn btn-danger" value="Volver">
	  </form>
    	  <div id="background">
			<div id="layer_1"><img src="../Resources/images/layer_1_1.jpg" style="width: 100%; height: auto"></div>

			<div style="width: 100%; position: relative; float: left; height: auto">
				<div id="layer_21"><img src="../Resources/images/silla_disponible.png" style="width: 100%; height: auto"></div>
				<div id="DISPONIBLE"><img src="../Resources/images/DISPONIBLE.png" style="width: 100%; height: auto"></div>
			</div>
			
			<div style="width: 100%; position: relative; float: left; height: auto">
				<div id="layer_22"><img src="../Resources/images/silla_ocupada.png" style="width: 100%; height: auto"></div>
				<div id="OCUPADA"><img src="../Resources/images/OCUPADA.png" style="width: 100%; height: auto"></div>
			</div>
			
			<div style="width: 100%; position: relative; float: left; height: auto">
				<div id="layer_23"><img src="../Resources/images/silla_bioseguridad.png" style="width: 100%; height: auto"></div>
				<div id="DEAISLAMIENTO"><img src="../Resources/images/DEAISLAMIENTO.png" style="width: 100%; height: auto"></div>

				<div id="layer_4"><img src="../Resources/images/layer_1_0.png" class="letras"></div>
				<div id="layer_3"><img src="../Resources/images/layer_2.png"  class="letras"></div>
				<div id="layer_2"><img src="../Resources/images/layer_3.png"  class="letras"></div>
				<div id="layer_1_0"><img src="../Resources/images/layer_4.png"  class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'A1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'A2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'A3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'A4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="letra"><img src="../Resources/images/A.png" class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'B1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'B2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'B3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'B4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>			<div id="letra"><img src="../Resources/images/B.png"  class="letras" ></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'C1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'C2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'C3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'C4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>			<div id="letra"><img src="../Resources/images/C.png" class="letras" ></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'D1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'D2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'D3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'D4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="letra"><img src="../Resources/images/D.png"  class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'E1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'E2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'E3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'E4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>			<div id="letra"><img src="../Resources/images/E.png" class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'F1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'F2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'F3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'F4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="letra"><img src="../Resources/images/F.png" class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'G1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'G2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'G3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'G4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="letra"><img src="../Resources/images/G.png" class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'H1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'H2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'H3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'H4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="letra"><img src="../Resources/images/H.png" class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'I1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'I2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'I3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'I4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>			<div id="letra"><img src="../Resources/images/I.png" class="letras"></div>
			</div>

			<div style="width: 100%; position: relative; float: left; height: auto">
			<div id="fila1">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'J1');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila2">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'J2');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila3">
				<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'J3');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="fila4">
			<?php
				$estado_silla = $viaje->buscarEstadoSilla($id,'J4');
				?>
				<?php if($estado_silla[0]['estado'] == 'B'){ ?>
				<img src="../Resources/images/silla_bioseguridad.png" class="sillas">
				<?php } else if($estado_silla[0]['estado'] == 'O'){ ?>
				<img src="../Resources/images/silla_ocupada.png" class="sillas" >
				<?php } else if($estado_silla[0]['estado'] == 'D'){ ?>
				<?php $d = "'".$estado_silla[0]['id']."','".$estado_silla[0]['numero_silla']."'";?>
				<img src="../Resources/images/silla_disponible.png" class="sillas" onclick="silla(<?php echo $d;?>)">
				<?php } ?>
			</div>
			<div id="letra"><img src="../Resources/images/J.png" class="letras"></div>
			</div>
			
			
		</div>
      </div>

      <!-- Modal DOCUMENTACION -->
        <div class="modal fade" id="vehiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content f-flex justify-content-center">
              <div class="modal-header">
                  <h5 class="modal-title " id="exampleModalLabel">Documentación</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <section id="contenido_modal" name="contenido_modal">
			<p id="texto"></p>
                  </section>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
              <form action="../Controlador/reservar_silla.php" method="POST">
		  <input type="hidden" name="id_opcion" id="id_opcion" value="">
                  <button  type="submit" class="btn btn-outline-info">Confirmar</button>
              </form>
              </div>
            </div>
          </div>
        </div>

      
  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

function silla(id,silla){
	$("#vehiModal").modal("show");
	document.getElementById('texto').innerHTML = '\u00bfEsta seguro que desea reservar la silla '+silla+'?';
	document.getElementById('id_opcion').value = id;
}

</script>



  
</body>
</html>