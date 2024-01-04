<?php
include "funciones.php";

// Recupera el valor de la cookie 'tipoUsuario'
$tipoUsuario = $_COOKIE['tipoUsuario'] ?? '';

// Verifica si el usuario tiene permisos antes de mostrar la página
if ($tipoUsuario != 'autorizado') {
    // Redirige a la página de inicio
	echo '<h2>Lista de artículos</h2>';
    echo '<p>No tienes permisos para estar aquí. <a href="index.php">Volver al inicio</a></p>';
    exit();
}
?>	
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<title>Articulos</title>
</head>
<body>
	<div class="container">	
		<a href="index.php">Inicio</a><br>
		<h2>Lista de artículos</h2>
		<?php 		
			// Obtener el parámetro de orden de la URL
			$orden = isset($_GET['orden']) ? $_GET['orden'] : 'ProductID';

			echo pintaProductos($orden);			 
		?>
		<br>
		<br>
	</div>
</body>
</html>
	<!-- Comprobará si el acceso a esta página se ha hecho por un usuario que tiene
	los permisos suficientes, comprobando la cookie creada en index.php. -->
	<!-- Mostrará una tabla con los datos de todos los productos almacenados con las
	siguientes columnas: ID, Nombre, Coste, Precio, Categoría y Acciones. -->
	<!-- Al pulsar sobre el título de cada columna (excepto Acciones), permitirá ordenar 
	de menor a mayor el contenido de la tabla basándose en el parámetro que se ha pulsado -->
	<!-- En el caso de que estén los permisos de la aplicación activados, aparecerán
	también las siguientes opciones: -->