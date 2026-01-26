<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pagos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 97%; /* El contenedor se extenderá de lado a lado de la pantalla */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .table-container {
            max-width: 100%; /* Establecer un ancho máximo para el contenedor de la tabla */
            overflow-x: auto; /* Agregar barra de desplazamiento horizontal si es necesario */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        /* Media queries para dispositivos móviles */
        @media screen and (max-width: 600px) {
            h2 {
                font-size: 20px;
               
            }
            .container{

                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Consulta de Pagos</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <label for="termino_busqueda">Buscar por Placa:</label>
            <input type="text" id="termino_busqueda" name="termino_busqueda" required>
            <input type="submit" value="Buscar">
        </form>

        
        <div class="table-container"> <!-- Contenedor adicional para la tabla -->
        <?php
        $conexion =mysqli_connect("localhost", "desarrollo", "AvzTMjVrQ?x&", "wwsist_sistemakv");

        if ($conexion === false) {
            die("Error de conexión: " . mysqli_connect_error());
        }
        // PHP para realizar la consulta y mostrar los resultados aquí
        if (isset($_GET['termino_busqueda'])) {
            $termino_busqueda = $_GET['termino_busqueda'];
            // Construir la consulta SQL dinámica
            $sql = "SELECT * FROM afiliados WHERE placa LIKE '%$termino_busqueda%'";
            // Ejecutar la consulta
            $result = $conexion->query($sql);
            if ($result->num_rows > 0) {
                echo "<h3>Resultados de la búsqueda:</h3>";
                echo "<table>";
                echo "<tr><th>Placa</th><th>Nompre Propie</th><th>Email Propie</th><th>Telefono 1</th><th>Telefono 2</th><th>Cedula</th><th>Modelo</th><th>Cilindraje</th><th>Marca</th><th>Tipologia</th>
                <th>Linea</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    
                    echo "<td>" . $row['placa'] . "</td>";
                    echo "<td>" . $row['nombrep'] . "</td>";
                    echo "<td>" . $row['emailp'] . "</td>";
                    echo "<td>" . $row['telefono1'] . "</td>";
                    echo "<td>" . $row['telefono2'] . "</td>";
                    echo "<td>" . $row['cedula'] . "</td>";
                    echo "<td>" . $row['modelo'] . "</td>";
                    echo "<td>" . $row['cilindraje'] . "</td>";
                    echo "<td>" . $row['marca'] . "</td>";
                    echo "<td>" . $row['tipologia'] . "</td>";
                    echo "<td>" . $row['linea'] . "</td>";
                 
                    }
                }

                    $sql = "SELECT * FROM pagos WHERE  placa LIKE '%$termino_busqueda%'";
            // Ejecutar la consulta
            $result = $conexion->query($sql);
            if ($result->num_rows > 0) {
                //echo "<h3>Resultados de la búsqueda:</h3>";
                echo "<table>";
                echo "<tr><th>Movil</th><th>Placa</th><th>Fecha pago</th><th>Valor recaudado</th><th>Responsable recaudo</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    
                    echo "<td>" . $row['movil'] . "</td>";
                    echo "<td>" . $row['placa'] . "</td>";
                    echo "<td>" . $row['fechapago'] . "</td>";
                    echo "<td>" . $row['valorrecaudado'] . "</td>";
                    echo "<td>" . $row['responsablerecaudo'] . "</td>";
                  
                 
                    }
                
                echo "</table>";
                
            } else {
                echo "No se encontraron resultados.";
            }
        
        }
        ?>
        </div>
        <h3><a href="pagos.php">regresar al fomulario</a></h3>
    </div>
</body>
</html>