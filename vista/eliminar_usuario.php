<?php
session_start();
include '../includes/navbar.php';
include '../includes/conexion.php';

if(!empty($_POST))
{
    $id=$_POST['id'];

    //$query_delete=mysqli_query($conexion, "DELETE FROM usuarios WHERE id=$id");
    $query_delete=mysqli_query($conexion, "UPDATE usuarios SET status = 0 WHERE id=$id");
    if($query_delete){
        header("location: usuario.php");

    }else{
        echo "Error al Eliminar";
    }


}

if (empty($_REQUEST['id'])) {
    header("location: usuario.php");
} else {
   

    $id = $_REQUEST['id'];

    $query = mysqli_query($conexion, "SELECT u.rut, u.user, u.apellido, u.rol FROM usuarios u WHERE u.id = $id");

    $result = mysqli_num_rows($query);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $rut = $data['rut'];
            $user = $data['user'];
            $apellido = $data['apellido'];
            $rol = $data['rol'];
        }
    } else {
        header("location: usuario.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="../css/styles_eliminar.css">
</head>
<body>
    <section id="container">
        <div class="data_delete">
            <h2>¿Está seguro de eliminar el siguiente usuario?</h2>
            <p>Usario: <span><?php echo $user; ?></span></p>
            <p>Apellido: <span><?php echo $apellido; ?></span></p>
            <p>Rol: <span><?php echo $rol; ?></span></p>

            <form method ="post" action="">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <a href="usuario.php" class="btn_cancel">Cancelar</a>
                <input type="Submit" value="Aceptar" class= "btn_ok">
            </form>

        </div>

    </section>
</body>
</html>

