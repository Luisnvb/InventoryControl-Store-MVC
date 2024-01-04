<?php 

	include "consultas.php";


	function pintaCategorias($defecto) {
		$categorias = getCategorias();

		// Generar las opciones HTML
		foreach ($categorias as $categoria) {
			$categoriaID = $categoria['CategoryID'];
			$nombre = $categoria['Name'];
			$selected = ($defecto == $categoriaID) ? 'selected' : '';

			echo "<option value='$categoriaID' $selected>$nombre</option>";
		}
	}
	

	function pintaTablaUsuarios() {
		$usuarios = getListaUsuarios();

		$html = '<table border="1">
					<tr>
						<th>FullName</th>
						<th>Email</th>
						<th>Enabled</th>
					</tr>';

		foreach ($usuarios as $usuario) {
			$html .= "<tr>
						<td>{$usuario['FullName']}</td>
						<td>{$usuario['Email']}</td>
						<td class='" . ($usuario['Enabled'] == 1 ? 'rojo' : '') . "'>{$usuario['Enabled']}</td>
					</tr>";
		}

		$html .= '</table>';
		return $html;
	}

		
	function pintaProductos($orden) {
		// Obtener los datos de los productos
		$datosProductos = getProductos($orden);

		// Obtener los permisos
		$permisos = getPermisos();

		// Verificar si hay productos
		if (!empty($datosProductos)) {
			if ($permisos == 1) {
				echo "<a href='formArticulos.php?accion=anadir'>Añadir producto</a><br><br>";
			}			
			// Iniciar la tabla HTML con encabezados clicables para ordenación
			$htmlTabla = "
				<table border='1'>
					<thead>
						<tr>
							<th><a href='?orden=ProductID'>ID</a></th>
							<th><a href='?orden=ProductName'>Nombre</a></th>
							<th><a href='?orden=Cost'>Coste</a></th>
							<th><a href='?orden=Price'>Precio</a></th>
							<th><a href='?orden=CategoryName'>Categoría</a></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>";

			// Iterar sobre los datos de los productos y agregar cada fila al cuerpo de la tabla
			foreach ($datosProductos as $producto) {
				$htmlTabla .= "
					<tr>
						<td>{$producto['ProductID']}</td>
						<td>{$producto['ProductName']}</td>
						<td>{$producto['Cost']}</td>
						<td>{$producto['Price']}</td>
						<td>{$producto['CategoryName']}</td>
						<td>";

				// Agregar enlace de edición condicional
				if ($permisos == 1) {
					$htmlTabla .= "<a href='formArticulos.php?accion=editar&id={$producto['ProductID']}'>Editar</a> |
								<a href='formArticulos.php?accion=borrar&id={$producto['ProductID']}'>Borrar</a>";
				}

				$htmlTabla .= "</td></tr>";
			}

			// Cerrar la tabla HTML
			$htmlTabla .= "</tbody></table>";

			// Imprimir la tabla HTML
			echo $htmlTabla;
		} else {
			// Mostrar mensaje si no hay productos
			echo "No se encontraron productos.";
		}
	}
?>