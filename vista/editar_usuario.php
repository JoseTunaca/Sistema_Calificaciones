<?php
session_start();
include '../includes/navbar.php';

$name = $_SESSION['usuario'];
$rol_db = $_SESSION['rol'];

// Para no ingresar al panel de forma local.
if (!isset($_SESSION['usuario'])) {
    header('location: index.html');
    exit();
}

if ($rol_db == 1) { // Rol Admin
    include '../includes/conexion.php'; // Incluye el archivo de conexión a la base de datos

  
}
if(empty($_GET['id']))
{
        header('location: usuario.php');
}
$iduser= $_GET['id'];

$sql= mysqli_query($conexion,"SELECT u.id, u.rut, u.user, u.apellido, u.rol FROM usuarios u WHERE id= $iduser ");

$result_sql = mysqli_num_rows($sql);
if($result_sql == 0){
    header('location: usuario.php');
}else{
    $option = '';
    while ($data =mysqli_fetch_array($sql)){
        $iduser=$data['id'];
        $rut=$data['rut'];
        $user=$data['user'];
        $apellido=$data['apellido'];
        $rol=$data['rol'];

        if($rol ==1){
            $option = '<option value="'.$rol.'" select>'.$rol.'</option>';
        }else if($rol ==2){
            $option = '<option value="'.$rol.'" select>'.$rol.'</option>';
        } 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #ffffff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 210px;
            transition: border-color 0.3s ease-in-out;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus {
            border-color: #3498db;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        input,select{
            display: block;
            width: 100%;
            font-size: 11pt;
            padding: 5px;
            border: 1px solid #85929e;
            border-radius: 5px;
        }
        button:hover {
            background-color: #2980b9;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Actualizar Usuario</h1>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo  $iduser; ?>">
        <label>RUT: <input type="text" name="rut" value= "<?php echo $rut; ?>"></label><br>
        <label>Usuario: <input type="text" name="user" value= "<?php echo $user; ?>"></label><br>
        <label>Apellido: <input type="text" name="apellido" value= "<?php echo $apellido; ?>"></label><br>
        <label>Contraseña: <input type="password" name="password" required></label><br>
        <label>Rol:
    <select name="rol" required>
        
        <option value="1">1</option>
        <option value="2">2</option>
    </select>
</label><br>
<div class="message-container">
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $id= $_POST["id"];
        $rut = $_POST["rut"];
        $user = $_POST["user"];
        $apellido = $_POST["apellido"];
        $password = $_POST["password"];
        $rol = $_POST["rol"]; // Asegúrate de sanear y validar los datos antes de usarlos en la consulta

        // Verificar si el nombre de usuario ya existe en la base de datos
        $query_check_user = "SELECT * FROM usuarios WHERE user = '$user'";
        $result_check_user = mysqli_query($conexion, $query_check_user);

        // Verificar si el RUT ya existe en la base de datos
        $query_check_rut = "SELECT * FROM usuarios WHERE rut = '$rut'";
        $result_check_rut = mysqli_query($conexion, $query_check_rut);

        if (mysqli_num_rows($result_check_user) > 0) {
            echo "<p class ='error-message'> El nombre de usuario ya existe en la base de datos.";
        } elseif (mysqli_num_rows($result_check_rut) > 0) {
            echo "<p class ='error-message'> El RUT ya existe en la base de datos.";
        } else {
            // Realiza la inserción en la base de datos
            if(empty($_POST['password']))
            { 
                $sql_update = mysqli_query($conexion, "UPDATE usuarios SET rut = '$rut', user = '$user', apellido = '$apellido', rol ='$rol' WHERE id =$id ");
                }else{
                    $sql_update = mysqli_query($conexion, "UPDATE usuarios SET rut = '$rut', user = '$user', apellido = '$apellido', password = '$password',
                     rol ='$rol' WHERE id =$id ");
                }
                
            if ($sql_update) {
                echo "<p class ='success-message'> Usuario actualizado exitosamente.";
            } else {
                echo "<p class ='error-message'> Error al agregar usuario: " . mysqli_error($conexion);
            }
        }
    }
    ?>

        <!-- Agrega más campos aquí si es necesario -->
        <button type="submit">Actualizar Usuario</button>
    </form>

   

    
    </div>

    </body>
</html>