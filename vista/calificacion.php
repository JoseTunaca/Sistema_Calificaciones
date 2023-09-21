<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', '/ruta/al/archivo_de_registro_de_errores.log');
session_start();
include '../includes/navbar.php';
include '../includes/conexion.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$name = $_SESSION['usuario'];
$apellido = $_SESSION['apellido'];
$rol_db = $_SESSION['rol'];

if (!isset($_SESSION['usuario'])) {
    header('location: index.html');
    exit();
}

$consulta_alumnos = "SELECT id, user, apellido FROM usuarios WHERE rol = 3";
$result = mysqli_query($conexion, $consulta_alumnos);

// Cargar los datos del archivo JSON (ajusta la ruta según tu estructura de archivos)
$jsonData = file_get_contents('../datos/misiones/trb/mision1.json');
$items = json_decode($jsonData, true);

// Variable para almacenar las sumas de cada categoría
$sumaS = 0;
$sumaL = 0;
$sumaNL = 0;
$sumaI = 0;
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificación de Vuelo</title>
    <link rel="stylesheet" href="../css/styles_calificacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container">
    <h1>Calificación de Vuelo</h1>
    <?php 
    if ($rol_db == 1) {
        echo "<h2>Bienvenido señor $name $apellido (Admin)</h2>";
    } elseif ($rol_db == 2) {
        echo "<h2>Bienvenido $name $apellido (Instructor)</h2>";
    }
    ?>

    <form>
        <div class="form-row">
            <div class="form-group">
                <label for="alumno">Selecciona al alumno:</label>
                <select name="alumno" id="alumno" style="width:150px" >
                    <option value="" selected></option>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $alumno_id = $row['id'];
                            $nombre = $row['user'];
                            $apellido = $row['apellido'];
                            echo "<option value='$alumno_id'>$nombre $apellido</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="mision">Seleccionar Misión:</label>
                <select id="mision" name="mision" required>
                    <option value="" selected></option>
                    <option value="1">Misión 1</option>
                    <option value="2">Misión 2</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tiempo_vuelo">Tiempo de Vuelo:</label>
                <select id="tiempo_vuelo" name="tiempo_vuelo" required>
                    <option value="" selected>--</option>
                    <?php
                    // Generar opciones desde 0.1 hasta 3.0 con incrementos de 0.1
                    for ($i = 1; $i <= 30; $i++) {
                        $valor = number_format($i * 0.1, 1); // Genera valores desde 0.1 hasta 3.0
                        echo "<option value='$valor'>$valor</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group custom-date">
                <label for="fecha">Seleccione Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
        </div>

        <!-- Resto de tu formulario aquí -->

        <div id="calificacion">
                Calificación: <span id="porcentajePerfecto">0.00</span> 
                <span id="estadoCalificacion">
                 <span id="estado-texto"></span>
                </span>
            </div>
            <br><br>
            <input type="hidden" id="calificacionFinal" name="calificacionFinal" value="">

            <br><br>
                <button type="button" id="calcularCalificacion" style="display: none;">Calcular Calificación</button>
                <button  id="guardarCalificacion" style="display: none;">Guardar Calificación</button>
                <button  id="generarPdfform">Generar PDF</button> <!-- Botón para generar el PDF -->
                </form>
              <!-- Resto de tus campos y elementos de formulario aquí -->


</div>
<br><br>
<br><br>
<br><br>
<br><br>
<div id="mensaje-guardado" style="display: none;">
    <p>Su calificación se ha guardado correctamente</p>
    <button id="boton-aceptar">Aceptar</button>
</div>
<div id="calificacion-container" style="display: none;">
    <table border="1">
        <thead>
            <tr>
                <th>NAP</th>
                <th>MANIOBRA U OPERACIÓN</th>
                <th>S</th>
                <th>L</th>
                <th>NL</th>
                <th>I</th>
                <th>Eliminar</th>
                <th>OBSERVACIONES Y ACCIONES CORRECTIVAS</th>
            </tr>
        </thead>
        <tbody>
            <!-- Los datos de la tabla se generarán dinámicamente aquí -->
            <!-- Ejemplo de generación de radio buttons en PHP -->
            <?php
            foreach ($items['categorias'] as $categoria) {
                echo '<tr>' .
                    '<td colspan="7" class="categoria">' . $categoria['nombre'] . '</td>' .
                    '</tr>';
                foreach ($categoria['items'] as $item) {
                    $item_id = $item['id'];
                    echo '<tr>' .
                        '<td>' . $item['tipo'] . '</td>' .
                        '<td>' . $item['nombre'] . '</td>' .
                        '<td><input type="radio" data-categoria="S" name="radios[' . $item_id . ']" value="4"></td>' . // S
                        '<td><input type="radio" data-categoria="L" name="radios[' . $item_id . ']" value="3"></td>' . // L
                        '<td><input type="radio" data-categoria="NL" name="radios[' . $item_id . ']" value="2"></td>' . // NL
                        '<td><input type="radio" data-categoria="I" name="radios[' . $item_id . ']" value="1"></td>' . // I
                        '<td class="text-center"><span class="eliminar-seleccion"><i class="fas fa-trash-alt"></i></span></td>' .
                        '<td><textarea name="comentario_R' . $item_id . '" rows="2"></textarea></td>' .
                        '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>


            <!-- Resto del formulario para ingresar la calificación -->
            <!-- Agrega aquí los campos necesarios para ingresar la información de la calificación -->
                       
                               
             </form>
       

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>

// Función para calcular el porcentaje de calificación
function calcularCalificacion() {
    var sumaS = 0;
    var sumaL = 0;
    var sumaNL = 0;
    var sumaI = 0;
    var calificacionFinal; // Declarar la variable antes de usarla

    // Iterar a través de los radio buttons y calcular las sumas
    $("input[type='radio']:checked").each(function() {
        var value = parseInt($(this).val());
        var categoria = $(this).data("categoria");
        if (categoria === "S") {
            sumaS += 1;
        } else if (categoria === "L") {
            sumaL += 1;
        } else if (categoria === "NL") {
            sumaNL += 1;
        } else if (categoria === "I") {
            sumaI += value;
        }
    });

    if (sumaI > 0) {
        // Si se seleccionó al menos un ítem con "I", la calificación es 0%
        calificacionFinal = 0;
    } else {
        // Calcular el porcentaje de calificación según tus requisitos
        var puntuacionTotal = (sumaS * 4) + (sumaL * 3) + (sumaNL * 2);
        var totalRadiosSeleccionados = sumaS + sumaL + sumaNL;
        var valorMaximoPorRadio = 4; // Valor máximo por radio en este caso
        calificacionFinal = (puntuacionTotal * 100) / (totalRadiosSeleccionados * valorMaximoPorRadio);
    }
 // Obtener el estado de calificación (Aprobado, Reprobado, Inseguro)
 var estadoTexto = '';
    if (parseFloat(calificacionFinal) === 0) {
        estadoTexto = 'Inseguro';
    } else if (parseFloat(calificacionFinal) >= 75) {
        estadoTexto = 'Aprobado';
    } else {
        estadoTexto = 'Reprobado';
    }
    //Almacena el valor calculado en el campo oculto
    $('#calificacionFinal').val(calificacionFinal.toFixed(2));
    // Actualizar el estado de calificación en el cuadro de estado
    actualizarEstadoCalificacion(estadoTexto);
    return calificacionFinal.toFixed(2);
}

// Manejador de eventos cuando se selecciona un alumno
$('#alumno').change(function() {
    var alumnoSeleccionado = $(this).val();
    console.log('Valor de alumnoSeleccionado:', alumnoSeleccionado);
    if (alumnoSeleccionado !== '') {
        // Mostrar la selección de misión
        $('#mision-container').show();
    } else {
        // Ocultar la selección de misión y la calificación si no se ha seleccionado un alumno
        $('#mision-container').hide();
        $('#calificacion-container').hide();
        // Ocultar el botón "Calcular Calificación" y "Guardar Calificación"
        $('#calcularCalificacion').hide();
        $('#guardarCalificacion').hide();
    }
});

// Manejador de eventos cuando se selecciona una misión
$('#mision').change(function() {
    var misionSeleccionada = $(this).val();
    if (misionSeleccionada !== '') {
        // Mostrar la tabla de calificación
        $('#calificacion-container').show();
        // Mostrar el botón "Calcular Calificación"
        $('#calcularCalificacion').show();
    } else {
        // Ocultar la tabla de calificación si no se ha seleccionado una misión
        $('#calificacion-container').hide();
        // Ocultar el botón "Calcular Calificación" y "Guardar Calificación"
        $('#calcularCalificacion').hide();
        $('#guardarCalificacion').hide();
    }
});

// Manejador de eventos para el botón "Calcular Calificación"
$('#calcularCalificacion').click(function () {
    // Obtener los radios seleccionados
    var radiosSeleccionados = obtenerRadiosSeleccionados();

    // Verificar si al menos un radio button está marcado y una misión está seleccionada
    var misionSeleccionada = $('#mision').val();
    if (misionSeleccionada !== '' && Object.keys(radiosSeleccionados).length > 0) {
        // Realizar el cálculo de la calificación aquí
        var resultadoCalificacion = calcularCalificacion(radiosSeleccionados);

        // Mostrar las sumatorias de cada columna
       // mostrarSumatorias(radiosSeleccionados);

        // Actualizar la calificación en la página
        $('#porcentajePerfecto').text(resultadoCalificacion);

        // Mostrar el estado de la calificación
        var estadoTexto = '';
        if (parseFloat(resultadoCalificacion) === 0) {
            estadoTexto = 'Inseguro';
        } else if (parseFloat(resultadoCalificacion) >= 75) {
            estadoTexto = 'Aprobado';
        } else {
            estadoTexto = 'Reprobado';
        }
        $('#estado-texto').text(estadoTexto);

        // Mostrar el botón "Guardar Calificación"
        $('#guardarCalificacion').show();
    } else {
        alert('Por favor, selecciona una misión y marca al menos un radio button.');
    }
});

$(document).ready(function () {
    // Manejador de eventos para el botón "Guardar Calificación"
    $('#guardarCalificacion').click(function () {
        // Obtener los datos del formulario
        var alumno_id = $('#alumno').val();
        var mision = $('#mision').val();
        var tiempo_vuelo = $('#tiempo_vuelo').val();
        var fecha = $('#fecha').val();
        var calificacionFinal = $('#calificacionFinal').val();

        // Validar que se hayan seleccionado valores
        if (alumno_id === '' || mision === '' || tiempo_vuelo === '' || fecha === '') {
            alert('Por favor, completa todos los campos antes de guardar la calificación.');
            return;
        }

        // Crear un objeto de datos para enviar al servidor
        var datos = {
            alumno: alumno_id,
            mision: mision,
            tiempo_vuelo: tiempo_vuelo,
            fecha: fecha,
            calificacionFinal: calificacionFinal

        };

        // Realizar la solicitud POST al servidor para guardar la calificación
        // En tu código JavaScript
$.ajax({
    type: 'POST',
    url: 'guardar_calificacion.php',
    data: datos,
    success: function (response) {
        console.log('exito al guardar');
        if (response.success) {
            // Éxito al guardar la calificación
            $('#mensaje-guardado').css('display', 'block');
            alert(response.message);
            //agregar cambio de color de boton guardar
            // También puedes realizar otras acciones después de guardar
        } else {
            // Error al guardar la calificación
            alert('Error al guardar la calificación: ' + response.message);
        }
    },
});

});
// Manejador de eventos para los botones "Eliminar Selección"
$('table').on('click', '.eliminar-seleccion', function() {
        var fila = $(this).closest('tr'); // Obtener la fila actual
        fila.find('input[type="radio"]').prop('checked', false); // Desmarcar todos los radios en esa fila
    });

 // Manejador de eventos para el botón "Generar PDF"
 $('#generarPdfform').click(function (e) {
        console.log('Generando PDF...');
        // Obtener los datos del formulario para el PDF
         // Obtener los datos del formulario
        var alumno_id = $('#alumno').val();
        var mision = $('#mision').val();
        var tiempo_vuelo = $('#tiempo_vuelo').val();
        var fecha = $('#fecha').val();
        var calificacionFinal = $('#calificacionFinal').val();

        // Validar que se hayan seleccionado valores
        if (alumno_id === '' || mision === '' || tiempo_vuelo === '' || fecha === '') {
            alert('Por favor, completa todos los campos antes de guardar la calificación.');
            return;
        }

        // Crear un objeto de datos para enviar al servidor
        var datosPdf = {
            alumno: alumno_id,
            mision: mision,
            tiempo_vuelo: tiempo_vuelo,
            fecha: fecha,
            calificacionFinal: calificacionFinal

        };
console.log(datosPdf);
       //  Realizar la solicitud POST al servidor para generar el PDF
        //Agrega esta parte a tu código JavaScript en el archivo HTML
$.ajax({
    type: 'POST',
   url: 'generar_pdf.php',
   data: datosPdf,
    success: function (response) {
    console.log(response); 
 //Muestra la respuesta en la consola del navegador
    },
    error: function (xhr, status, error) {
        console.error(xhr.responseText); // En caso de un error, muestra los detalles en la consola
    }
});
    });

    });



// Función para mostrar las sumatorias de cada columna
function mostrarSumatorias(radiosSeleccionados) {
    var sumas = {
        'S': 0,
        'L': 0,
        'NL': 0,
        'I': 0
    };

    // Iterar a través de los radio buttons seleccionados y sumar los valores por categoría
    for (var categoria in radiosSeleccionados) {
        var valores = radiosSeleccionados[categoria];
        for (var i = 0; i < valores.length; i++) {
            sumas[categoria] += parseInt(valores[i]);
        }
    }

    // Actualizar las sumatorias en la página
    $('#sumaS').text(sumas['S']);
    $('#sumaL').text(sumas['L']);
    $('#sumaNL').text(sumas['NL']);
    $('#sumaI').text(sumas['I']);
}
// Función para actualizar el estado de calificación (Aprobado, Reprobado, Inseguro)
function actualizarEstadoCalificacion(estado) {
    var estadoCalificacion = $('#estadoCalificacion');
    
    // Quita todas las clases de fondo del elemento
    estadoCalificacion.removeClass('verde rojo amarillo');
    
    // Establece la clase de fondo en función del estado
    if (estado === 'Aprobado') {
        estadoCalificacion.addClass('verde');
    } else if (estado === 'Reprobado') {
        estadoCalificacion.addClass('rojo');
    } else if (estado === 'Inseguro') {
        estadoCalificacion.addClass('amarillo');
    }
}


// Función para obtener los radios seleccionados
function obtenerRadiosSeleccionados() {
    var radiosSeleccionados = {};
    $('input[type="radio"]:checked').each(function () {
        var name = $(this).attr('name');
        var value = $(this).val();
        // Modificamos el formato de name para que incluya la categoría
        var categoria = $(this).data('categoria');
        if (!radiosSeleccionados[categoria]) {
            radiosSeleccionados[categoria] = [];
        }
        radiosSeleccionados[categoria].push(value);
    });
    return radiosSeleccionados;
}


 </script>
    </div>
</body>
</html>










