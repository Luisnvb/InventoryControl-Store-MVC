<?php 

	include "conexion.php";


	function tipoUsuario($nombre, $correo) {
		// Verificar si el usuario es 'superadmin'
		if (esSuperadmin($nombre, $correo)) {
			return "superadmin";
		}

		// Obtener la conexión
		$conexion = crearConexion();

		// Consulta SQL para obtener el tipo de usuario y verificar autorización
		$consulta = "SELECT UserID, Enabled FROM user WHERE FullName = '$nombre' AND Email = '$correo'";
		$resultado = $conexion->query($consulta);

		// Verificar si se encontró algún resultado
		if ($resultado && $resultado->num_rows > 0) {
			// Obtener datos del usuario
			$fila = $resultado->fetch_assoc();
			$enabled = $fila['Enabled'];

			// Verificar autorización
			if ($enabled == 1) {
				// Cerrar la conexión a la base de datos
				$conexion->close();
				return "autorizado";
			} else {
				// Cerrar la conexión a la base de datos
				$conexion->close();
				return "registrado";
			}
		} else {
			// Cerrar la conexión a la base de datos si no se encontraron resultados
			$conexion->close();
			return "no registrado";
		}
	}



	function esSuperadmin($nombre, $correo) {
		$conexion = crearConexion();

		// Consulta SQL para obtener el UserID del usuario
		$consultaUserID = "SELECT UserID FROM user WHERE Fullname = '$nombre' AND Email = '$correo'";
		$resultadoUserID = $conexion->query($consultaUserID);

		// Verificar si se encontró algún resultado
		if ($resultadoUserID && $resultadoUserID->num_rows > 0) {
			// Obtener el UserID del usuario
			$filaUserID = $resultadoUserID->fetch_assoc();
			$userID = $filaUserID['UserID'];

			// Consulta SQL para obtener el SuperAdmin de la tabla setup
			$consultaSetup = "SELECT SuperAdmin FROM setup";
			$resultadoSetup = $conexion->query($consultaSetup);

			// Verificar si se encontró algún resultado en 'setup'
			if ($resultadoSetup && $resultadoSetup->num_rows > 0) {
				// Obtener el valor de 'SuperAdmin' en 'setup'
				$filaSetup = $resultadoSetup->fetch_assoc();
				$superAdminID = $filaSetup['SuperAdmin'];

				// Comparar 'UserID' con 'SuperAdmin' para determinar si es 'superadmin'
				if ($userID == $superAdminID) {
					// Cerrar la conexión a la base de datos
					$conexion->close();
					return true;
				}
			}
		}

		// Cerrar la conexión a la base de datos si no es 'superadmin'
		$conexion->close();
		return false;
	}



	function getPermisos() {
		$conexion = crearConexion();

		// Consulta SQL para obtener el valor de Autenticación en la tabla setup
		$consulta = "SELECT Autenticación FROM setup";
		$resultado = $conexion->query($consulta);

		// Verificar si se encontró algún resultado
		if ($resultado && $resultado->num_rows > 0) {
			// Obtener el valor de Autenticación en setup
			$fila = $resultado->fetch_assoc();
			$permisos = $fila['Autenticación'];

			// Cerrar la conexión a la base de datos
			$conexion->close();

			// Devolver el valor de Autenticación
			return $permisos;
		} else {
			// Cerrar la conexión a la base de datos si no se encontraron resultados
			$conexion->close();
			return "No se encontró el valor de Autenticación.";
		}
	}

	// Cambiar permisos
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['accion']) && $_POST['accion'] === 'cambiarPermisos') {
			cambiarPermisos();
		} else {
			echo " ";
		}
	}


	function cambiarPermisos() {
		$conexion = crearConexion();

		// Consulta SQL para obtener y actualizar el valor de Autenticación en la tabla setup
		$consulta = "SELECT Autenticación FROM setup";
		$resultado = $conexion->query($consulta);

		// Verificar si se encontró algún resultado
		if ($resultado && $resultado->num_rows > 0) {
			// Obtener el valor actual de Autenticación en setup
			$fila = $resultado->fetch_assoc();
			$permisosActual = $fila['Autenticación'];

			// Cambiar el valor de Autenticación (alternando entre 0 y 1)
			$nuevosPermisos = $permisosActual == 0 ? 1 : 0;

			// Actualizar el valor en la tabla setup
			$actualizarConsulta = "UPDATE setup SET Autenticación = $nuevosPermisos";
			$conexion->query($actualizarConsulta);

			// Cerrar la conexión a la base de datos
			$conexion->close();

			// Redirigir a usuarios.php después de realizar la acción
			header('Location: usuarios.php');
			exit;
		} else {
			// Cerrar la conexión a la base de datos si no se encontraron resultados
			$conexion->close();
			return "No se encontró el valor de Autenticación.";
		}
	}


	function getCategorias() {			
		$conexion = crearConexion();

		// Array para almacenar las categorías
		$categorias = array();

		// Consulta SQL para obtener los datos de la tabla category
		$consulta = "SELECT CategoryID, Name FROM category";

		$resultado = mysqli_query($conexion, $consulta);

		// Verificar si la consulta fue exitosa
		if ($resultado) {
			// Recorrer los resultados y agregarlos al array de categorías
			while ($fila = mysqli_fetch_assoc($resultado)) {
				$categorias[] = $fila;
			}

			// Liberar el conjunto de resultados
			mysqli_free_result($resultado);
		} else {
			// Manejar el error si la consulta falla
			echo "Error en la consulta: " . mysqli_error($conexion);
		}

		// Devolver el array de categorías
		return $categorias;
	}


	function getListaUsuarios() {
		$conexion = crearConexion();

		// Consulta SQL para obtener los datos de todos los usuarios
		$consulta = "SELECT FullName, Email, Enabled FROM user";
		$resultado = $conexion->query($consulta);

		// Verificar si se encontró algún resultado
		if ($resultado && $resultado->num_rows > 0) {
			// Construir array de usuarios
			$usuarios = [];
			while ($fila = $resultado->fetch_assoc()) {
				$usuarios[] = $fila;
			}

			// Cerrar la conexión a la base de datos
			$conexion->close();

			// Devolver la representación en HTML utilizando pintaTablaUsuarios
			return $usuarios;
		} else {
			// Cerrar la conexión a la base de datos si no se encontraron resultados
			$conexion->close();
			return "No hay usuarios registrados.";
		}
	}



	function getProduct($ID) {
		$conexion = crearConexion();

		// Consulta SQL para obtener los datos del producto por ID
		$consulta = "SELECT ProductID, Name, Cost, Price, CategoryID FROM product WHERE ProductID = $ID";

		// Ejecutar la consulta
		$resultado = mysqli_query($conexion, $consulta);

		// Verificar si la consulta fue exitosa
		if ($resultado) {
			// Obtener el resultado como un array asociativo
			$producto = mysqli_fetch_assoc($resultado);

			// Liberar el resultado de la memoria
			mysqli_free_result($resultado);

			// Cerrar la conexión a la base de datos
			mysqli_close($conexion);

			// Devolver el array con los datos del producto
			return $producto;
		} else {
			// Si la consulta falla, mostrar un mensaje de error y devolver un array vacío
			echo "Error en la consulta: " . mysqli_error($conexion);
			mysqli_close($conexion);
			return array();
		}
	}



	function getProductos($orden) {
		$conexion = crearConexion();

		// Consulta SQL para obtener productos ordenados por $orden
		$sql = "SELECT product.ProductID, product.Name AS ProductName, product.Cost, product.Price, category.Name AS CategoryName
				FROM product
				JOIN category ON product.CategoryID = category.CategoryID
				ORDER BY $orden";

		// Ejecutar la consulta
		$resultado = $conexion->query($sql);

		// Verificar si hay resultados
		if ($resultado->num_rows > 0) {
			// Iniciar el array para los datos de la tabla
			$datosTabla = array();

			// Iterar sobre los resultados y agregar cada fila al array
			while ($fila = $resultado->fetch_assoc()) {
				$datosTabla[] = array(
					'ProductID' => $fila['ProductID'],
					'ProductName' => $fila['ProductName'],
					'Cost' => $fila['Cost'],
					'Price' => $fila['Price'],
					'CategoryName' => $fila['CategoryName']
				);
			}

			// Cerrar la conexión
			cerrarConexion($conexion);

			// Devolver el array con los datos de la tabla
			return $datosTabla;
		} else {
			// Cerrar la conexión
			cerrarConexion($conexion);

			// Devolver un array vacío si no se encontraron productos
			return array();
		}
	}


	function anadirProducto($nombre, $coste, $precio, $categoria) {
		$conexion = crearConexion();

		// Consulta SQL para insertar un nuevo producto
		$consulta = "INSERT INTO product (Name, Cost, Price, CategoryID) VALUES ('$nombre', $coste, $precio, $categoria)";

		// Ejecutar la consulta
		$resultado = mysqli_query($conexion, $consulta);

		// Verificar si la consulta fue exitosa
		if ($resultado) {
			// Obtener el ID del producto recién insertado
			$productoID = mysqli_insert_id($conexion);

			// Cerrar la conexión a la base de datos
			mysqli_close($conexion);

			// Devolver el ID del producto insertado
			return $productoID;
		} else {
			// Si la consulta falla, mostrar un mensaje de error y devolver false
			echo "Error en la consulta: " . mysqli_error($conexion);
			mysqli_close($conexion);
			return false;
		}
	}


	function borrarProducto($id) {
		$conexion = crearConexion();

		// Consulta SQL para eliminar un producto por ID
		$consulta = "DELETE FROM product WHERE ProductID = $id";

		// Ejecutar la consulta
		$resultado = mysqli_query($conexion, $consulta);

		// Verificar si la consulta fue exitosa
		if ($resultado) {
			echo 'Artículo borrado correctamente.';
			// Cerrar la conexión a la base de datos
			mysqli_close($conexion);

			// Devolver true indicando que la eliminación fue exitosa
			return true;
		} else {
			// Si la consulta falla, mostrar un mensaje de error y devolver false
			echo "Error en la consulta: " . mysqli_error($conexion);
			mysqli_close($conexion);
			return false;
		}
	}


	function editarProducto($id, $nombre, $coste, $precio, $categoria) {
		// Crear la conexión
		$conexion = crearConexion();

		// Consulta SQL para actualizar la información de un producto por ID
		$consulta = "UPDATE product SET Name = '$nombre', Cost = $coste, Price = $precio, CategoryID = $categoria WHERE ProductID = $id";

		// Ejecutar la consulta
		$resultado = mysqli_query($conexion, $consulta);

		// Verificar si la consulta fue exitosa
		if ($resultado) {
			echo 'Artículo modificado';
			// Cerrar la conexión a la base de datos
			mysqli_close($conexion);

			// Devolver true indicando que la actualización fue exitosa
			return true;
		} else {
			// Si la consulta falla, mostrar un mensaje de error y devolver false
			echo "Error en la consulta: " . mysqli_error($conexion);
			mysqli_close($conexion);
			return false;
		}
	}

?>