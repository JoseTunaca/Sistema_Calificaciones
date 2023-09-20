<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <title>Inicio de Sesión</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: #373b40; /* Color de fondo si la imagen no carga */
        }

        .login-container {
            background-color: rgb(68, 184, 213);
            background-image: url('imagenes/compos.gif'); /* Reemplaza 'ruta_de_la_imagen.jpg' con la URL de tu imagen */
            background-size: auto;
            background-position: center bottom;
            background-repeat: no-repeat;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 80%; /* Ancho del contenedor del formulario */
            max-width: 400px; /* Ancho máximo del contenedor del formulario */
            margin-bottom: 20px; /* Espacio debajo del contenedor del formulario */
            height: 750px;
        }

        .login-form {
            text-align: center;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1 class="text-primary">Login</h1>
            
            <!-- Mostrar mensaje de error aquí -->
            <?php
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            session_start();
            if (isset($_SESSION['error_message'])) {
                echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']); // Limpia la variable de sesión del mensaje de error
            }
            ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="user" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="rut" name="rut"> 
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
