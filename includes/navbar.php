<?php
// Asegúrate de que $rol_db se defina aquí
$rol_db = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Estilos para la barra de navegación */
        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            text-align: center;
        }
        
        .navbar a {
            display: inline-block;
            color: white;
            padding: 8px 12px; /* Ajusta los valores de padding para achicar los enlaces */
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .navbar a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="navbar">
    
    <?php
    if ($rol_db == 1) { // Rol Admin
        echo '<a href="panel.php">Inicio</a>';
        echo '<a href="usuario.php">Usuarios</a>';
        echo '<a href="ad_calificacion.php">Calificación</a>';
    }elseif($rol_db == 2) {
        echo '<a href="user.php">Inicio</a>';
        echo '<a href="calificacion.php">Calificación</a>';
    }
    
    ?>
   
   
    <a href="../logout.php">Salir</a>
   
</div>

</body>
</html>


