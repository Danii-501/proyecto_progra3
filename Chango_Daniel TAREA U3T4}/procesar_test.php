<?php
// 1. Incluir la conexión y funciones lógicas
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // 2. Captura de datos del Perfil (Sanitización básica para PHP 5.3)
        $datos_usuario = array(
            'nombre'    => $_POST['nombre'],
            'email'     => $_POST['email'],
            'fecha_nac' => $_POST['fecha_nac'],
            'genero'    => $_POST['genero'],
            'carrera'   => $_POST['carrera']
        );

        // 3. Lógica de cálculo del Test (Felder-Silverman)
        // Inicializamos las dimensiones
        $AR = 0; // Activo (a) vs Reflexivo (b)
        $SI = 0; // Sensorial (a) vs Intuitivo (b)
        $VV = 0; // Visual (a) vs Verbal (b)
        $SG = 0; // Secuencial (a) vs Global (b)

        // Mapeo lógico de preguntas a dimensiones
        // P1, P5, P7 -> Activo/Reflexivo
        if($_POST['q1'] == 'a') $AR++; else $AR--;
        if($_POST['q5'] == 'a') $AR++; else $AR--;
        if($_POST['q7'] == 'a') $AR++; else $AR--;

        // P2 -> Sensorial/Intuitivo
        if($_POST['q2'] == 'a') $SI++; else $SI--;

        // P4, P8 -> Visual/Verbal
        if($_POST['q4'] == 'a') $VV++; else $VV--;
        if($_POST['q8'] == 'a') $VV++; else $VV--;

        // P3, P6 -> Secuencial/Global
        if($_POST['q3'] == 'a') $SG++; else $SG--;
        if($_POST['q6'] == 'a') $SG++; else $SG--;

        // DETERMINAR ESTILO DOMINANTE (El valor más alto)
        $valores = array('Activo/Reflexivo' => abs($AR), 'Sensorial/Intuitivo' => abs($SI), 'Visual/Verbal' => abs($VV), 'Secuencial/Global' => abs($SG));
        asort($valores);
        $estilo_dominante = key($valores);

        // Preparar array de totales para la función guardar
        $totales = array(
            'dominante' => $estilo_dominante,
            'AR' => $AR,
            'SI' => $SI,
            'VV' => $VV,
            'SG' => $SG
        );

        // 4. Llamar a la función de guardado definida en config.php
        $resultado_db = guardarResultado($datos_usuario, $totales);

        // 5. Interfaz de confirmación pulcra
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Procesando Resultados</title>
            <style>
                body { font-family: 'Georgia', serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
                .card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); text-align: center; border-top: 8px solid #7a1a1a; max-width: 500px; }
                h2 { color: #7a1a1a; }
                .mensaje { margin: 20px 0; padding: 15px; border-radius: 5px; background: #fff5f5; border: 1px solid #f5b2b2; }
                .btn { background: #7a1a1a; color: white; padding: 10px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 10px; }
            </style>
        </head>
        <body>
            <div class="card">
                <h2>¡Procesamiento Completado!</h2>
                <div class="mensaje">
                    <?php echo $resultado_db; ?>
                    <br><br>
                    <strong>Estilo Predominante:</strong> <?php echo $estilo_dominante; ?>
                </div>
                <a href="index.php" class="btn">Volver al Inicio</a>
                <a href="consultas.php" class="btn" style="background: #4a0e0e;">Ver Historial</a>
            </div>
        </body>
        </html>
        <?php

    } catch (Exception $e) {
        die("Excepción técnica en el procesamiento: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
}
?>