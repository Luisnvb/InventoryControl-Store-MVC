<?php
include "funciones.php";

// Recupera el valor de la cookie 'tipoUsuario'
$tipoUsuario = $_COOKIE['tipoUsuario'] ?? '';

// Verifica si el usuario tiene permisos antes de mostrar la página
if ($tipoUsuario != 'autorizado') {
    // Redirige a la página de inicio
	echo '<h2>Formulario artículo</h2>';
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
	<title>Formulario de artículos</title>
</head>
<body>
	<div class="container">
	<a href="articulos.php">Volver a edición de artículos</a><br><br>

	<?php 
		// Obtener el parámetro de acción de la URL
		$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

		// Lógica para mostrar el formulario EDITAR
		if ($accion == 'editar') {
			// Obtener el ID del producto a editar desde la URL
			$id = isset($_GET['id']) ? $_GET['id'] : '';

			// Obtener los datos del producto por su ID
			$producto = getProduct($id);

			// Verificar si se encontró el producto
			if ($producto) {
				// Mostrar el formulario de edición con los datos del producto
				echo "<h2>Editar artículo</h2>
					<form action='?accion=editar&id={$producto['ProductID']}' method='post'>
						<label for='nombre'>Nombre:</label>
						<input type='text' name='nombre' value='{$producto['Name']}' required><br>
						<label for='coste'>Coste:</label>
						<input type='text' name='coste' value='{$producto['Cost']}' required><br>
						<label for='precio'>Precio:</label>
						<input type='text' name='precio' value='{$producto['Price']}' required><br>
						<label for='categoria'>Categoría:</label>
						<select name='categoria' required>";
				// Llamada a la función pintaCategorias con la categoría por defecto
				pintaCategorias($producto['CategoryID']);
				echo "</select><br><br>
						<input type='submit' name='editar' value='Editar'>						
					</form><br>";

				// Verificar si se ha enviado el formulario de edición
				if (isset($_POST['editar'])) {
					// Obtener los datos del formulario
					$nombre = $_POST['nombre'];
					$coste = $_POST['coste'];
					$precio = $_POST['precio'];
					$categoriaID = $_POST['categoria'];

					// Actualizar el producto en la base de datos
					editarProducto($producto['ProductID'], $nombre, $coste, $precio, $categoriaID);
				}
			} else {
				// Producto no encontrado, mostrar mensaje de error
				echo "Producto no encontrado.";
			}
		} 	

		// Lógica para mostrar el formulario BORRAR
		if ($accion == 'borrar') {
			// Obtener el ID del producto a borrar desde la URL
			$id = isset($_GET['id']) ? $_GET['id'] : '';

			// Obtener los datos del producto por su ID
			$producto = getProduct($id);

			// Verificar si se encontró el producto
			if ($producto) {
				// Mostrar el formulario de borrado con los datos del producto
				echo "<h2>Borrar artículo</h2>
					<form action='?accion=borrar&id={$producto['ProductID']}' method='post'>
						<label for='id'>ID:</label>
						<input type='text' name='id' value='{$producto['ProductID']}' readonly><br>
						<label for='nombre'>Nombre:</label>
						<input type='text' name='nombre' value='{$producto['Name']}' readonly><br>
						<label for='coste'>Coste:</label>
						<input type='text' name='coste' value='{$producto['Cost']}' readonly><br>
						<label for='precio'>Precio:</label>
						<input type='text' name='precio' value='{$producto['Price']}' readonly><br>
						<label for='categoria'>Categoría:</label>
						<select name='categoria' disabled>";
				// Llamada a la función pintaCategorias con la categoría por defecto
				pintaCategorias($producto['CategoryID']);
				echo "</select><br><br>
						<input type='submit' name='borrar' value='Borrar'>
					</form><br>";

				// Verificar si se ha enviado el formulario de borrado
				if (isset($_POST['borrar'])) {
					// Borrar el producto en la base de datos
					borrarProducto($producto['ProductID']);
				}
			} else {
				// Producto no encontrado, mostrar mensaje de error
				echo "Producto no encontrado.";
			}
		} 
		// Lógica para mostrar el formulario AÑADIR
		if ($accion == 'anadir') {
			// Verificar si se ha enviado el formulario de añadir
			if (isset($_POST['anadir'])) {
				// Obtener los datos del formulario
				$nombre = $_POST['nombre'];
				$coste = $_POST['coste'];
				$precio = $_POST['precio'];
				$categoria = $_POST['categoria'];

				// Añadir el producto a la base de datos
				$productoID = anadirProducto($nombre, $coste, $precio, $categoria);

				// Mostrar el mensaje después de enviar el formulario
				if ($productoID !== false) {
					echo 'Se ha añadido el producto.';
				}
			}

			// Mostrar el formulario de añadir
				echo "<h2>Añadir artículo</h2>
					<form action='?accion=anadir' method='post'>
						<label for='nombre'>Nombre:</label>
						<input type='text' name='nombre' required><br>
						<label for='coste'>Coste:</label>
						<input type='text' name='coste' required><br>
						<label for='precio'>Precio:</label>
						<input type='text' name='precio' required><br>
						<label for='categoria'>Categoría:</label>
						<select name='categoria' required>";
				// Llamada a la función pintaCategorias sin categoría por defecto
				pintaCategorias(null);
				echo "</select><br><br>
						<input type='submit' name='anadir' value='Añadir'>
					</form><br>";
		} 
	?>
	</div>
</body>
</html>