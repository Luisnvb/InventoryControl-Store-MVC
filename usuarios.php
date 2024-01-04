<?php
include "funciones.php";

// Recupera el valor de la cookie 'tipoUsuario'
$tipoUsuario = $_COOKIE['tipoUsuario'] ?? '';

// Verifica si el usuario tiene permisos antes de mostrar la página
if ($tipoUsuario != 'superadmin') {
    // Redirige a a la página de inicio
	echo '<h2>Configuración de usuarios</h2>';	
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
	<title>Usuarios</title>
</head>
<body>
	<div class="container">
		<a href="index.php">Inicio</a>
		<h2>Configuración de usuarios</h2>
		<?php 			
			echo "\nLos permisos actuales están a: " . getPermisos();
			echo"\n";
		?>
		<br><br>
		<form action="consultas.php" method="post">
			<input type="hidden" name="accion" value="cambiarPermisos">
			<button type="submit">Cambiar Permisos</button>
		</form>
		<br>
		<?php 			
			echo pintaTablaUsuarios();
		?>
	</div>
</body>
</html>
	<!-- Comprueba mediante cookie si el usuario tiene permisos para acceder -->
	<!-- Muestra el valor de los permisos actuales -->
	<!-- Botón para modificar el valor de los permisos -->
	<!-- Muestra una tabla con los datos de todos los usuarios registrados en la
	aplicación con las siguientes columnas: Nombre, Email y Autorizado. -->
	<!-- En aquellos usuarios que estén autorizados, cambiará el color de fondo de la
	columna de Autorizado. -->