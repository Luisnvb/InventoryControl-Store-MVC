<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilo.css"/>
	<title>Index.php</title>
</head>
<body>
<?php
include "consultas.php";
?>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <input type="submit" value="Verificar usuario">
        </form>        
        <?php
        // Verifica si se han enviado datos mediante el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener el tipo de usuario
            $nombreUsuario = $_POST['nombre'] ?? '';
            $correoUsuario = $_POST['email'] ?? '';
            $tipoUsuario = tipoUsuario($nombreUsuario, $correoUsuario);
            // Crear la cookie
            setcookie('tipoUsuario', $tipoUsuario, time() + 3600, '/'); // La cookie expirará en 1 hora (3600 segundos)
            // Muestra un enlaces según el tipo de usuario
            switch ($tipoUsuario) {
                case 'superadmin':
                    echo '<p>Bienvenido '.$nombreUsuario.' , pulsa <a href="usuarios.php">AQUÍ</a> para entrar en el panel de usuarios.</p><br>';
                    break;
                case 'autorizado':
                    echo '<p>Bienvenido '.$nombreUsuario.' , pulsa <a href="articulos.php">AQUÍ</a> para entrar en el panel de artículos.</p><br>';
                    break;
                case 'registrado':
                    echo '<p>Bienvenido '.$nombreUsuario.'. No tienes permisos para acceder.</p>';
                    break;
                case 'no registrado':
                    echo '<p>Usuario no registrado.</p>';
                    break;
                default:
                    break;
            }
        }
        ?>
    </div>
</body>
</html>