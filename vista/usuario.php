<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../css/styles_usuario.css">
    <?php 
session_start();


$name = $_SESSION['usuario'];
$rol_db = $_SESSION['rol'];

// Para no ingresar al panel de forma local.
if (!isset($_SESSION['usuario'])) {
    header('location: index.html');
    exit();
}

include '../includes/conexion.php'; // Incluye el archivo de conexión a la base de datos

$usuarios = []; // Aquí almacenaremos los usuarios obtenidos de la base de datos

$query = "SELECT * FROM usuarios";
$result = mysqli_query($conexion, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usuarios[] = $row;
    }
}
?>
</head>
<body>
<?php include '../includes/navbar.php';
 ?>

    <section id="container">

<h1>Listado de Usuarios</h1>
   <a href="agregar_usuario.php" class= "btn_new">Crear Usuario</a>
    <table>
    <tr>
        <th>ID</th>
        <th>RUT</th>
        <th>USER</th>
        <th>APELLIDO</th>
        <th>ROL</th>
        <th>ACCIONES</th>
    <tr>
        <?php
    $query = mysqli_query($conexion, "SELECT u.id, u.user, u.apellido, u.rut, u.rol FROM usuarios u WHERE status = 1");
$result=mysqli_num_rows($query);
if($result > 0){
    while($data =mysqli_fetch_array($query)){

  ?>
  <tr>
        <td><?php echo $data["id"];?></td>
        <td><?php echo $data["rut"];?></td>
        <td><?php echo $data["user"];?></td>
        <td><?php echo $data["apellido"];?></td>
        <td><?php echo $data["rol"];?></td>
        <td>
        <a class ="link_edit" href="editar_usuario.php?id=<?php echo $data["id"];?>">Editar</a>
        <a class= "link_delete" href="eliminar_usuario.php?id=<?php echo $data["id"];?>">Eliminar</a>
        </td>
    </tr>
    <?php
    }
}
?>
    </table>
    </section>
</body>
</html>






