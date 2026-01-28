<?php 
include 'config.php'; 

// 1. OBTENER EL ID (Compatible con PHP 5.3)
$id_reporte = 0;
if (isset($_GET['id'])) {
    $id_reporte = intval($_GET['id']);
} elseif (isset($_POST['id_busqueda'])) {
    $id_reporte = intval($_POST['id_busqueda']);
}

$user = null;
if ($id_reporte > 0) {
    // Unimos usuarios con resultados para traer toda la ficha técnica
    $sql = "SELECT u.*, r.* FROM usuarios u 
            INNER JOIN resultados r ON u.id = r.usuario_id 
            WHERE u.id = $id_reporte";
    $res = $conn->query($sql);
    if ($res) {
        $user = $res->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Resultados - Sistema de Aprendizaje</title>
    <style>
        :root {
            --rojo-oscuro: #7a1a1a;
            --rojo-muy-oscuro: #4a0e0e;
            --gris-texto: #333;
        }
        body { font-family: 'Georgia', serif; background: #f0f0f0; margin: 0; padding: 20px; color: var(--gris-texto); }
        
        /* Contenedor del Reporte */
        .report-paper {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 50px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-top: 15px solid var(--rojo-muy-oscuro);
            position: relative;
        }

        .header-report { text-align: center; border-bottom: 2px solid var(--rojo-oscuro); padding-bottom: 20px; margin-bottom: 30px; }
        .header-report h1 { color: var(--rojo-muy-oscuro); text-transform: uppercase; letter-spacing: 2px; margin: 0; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-item { border-bottom: 1px solid #eee; padding: 10px 0; }
        .info-item strong { color: var(--rojo-oscuro); }

        /* Estilo de la Tabla de Resultados */
        .results-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .results-table th { background: #f8f8f8; color: var(--rojo-muy-oscuro); border: 1px solid #ddd; padding: 12px; text-align: left; }
        .results-table td { border: 1px solid #ddd; padding: 12px; }
        
        .dominante-box {
            background: #fff5f5;
            border: 2px dashed var(--rojo-oscuro);
            padding: 20px;
            text-align: center;
            margin-top: 30px;
            border-radius: 8px;
        }

        .btn-print {
            background: var(--rojo-oscuro);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Estilos para impresión */
        @media print {
            body { background: white; padding: 0; }
            .report-paper { box-shadow: none; border-top: 5px solid var(--rojo-muy-oscuro); width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="no-print" style="max-width: 850px; margin: 0 auto 20px auto; text-align: right;">
    <button onclick="window.print()" class="btn-print">🖨️ IMPRIMIR REPORTE OFICIAL</button>
    <a href="index.php" style="margin-left: 10px; color: var(--rojo-oscuro);">Volver al Inicio</a>
</div>

<div class="report-paper">
    <?php if ($user): ?>
        <div class="header-report">
            <h1>Informe de Perfil de Aprendizaje</h1>
            <p>Modelo de Felder-Silverman | Registro Académico</p>
        </div>

        <div class="info-grid">
            <div class="info-item"><strong>Estudiante:</strong> <?php echo $user['nombre']; ?></div>
            <div class="info-item"><strong>ID Registro:</strong> <?php echo $user['id']; ?></div>
            <div class="info-item"><strong>Email:</strong> <?php echo $user['email']; ?></div>
            <div class="info-item"><strong>Carrera:</strong> <?php echo $user['carrera']; ?></div>
            <div class="info-item"><strong>Fecha de Registro:</strong> <?php echo $user['fecha_registro']; ?></div>
            <div class="info-item"><strong>Género:</strong> <?php echo ($user['genero']=='M'?'Masculino':'Femenino'); ?></div>
        </div>

        <h3 style="color: var(--rojo-muy-oscuro); border-bottom: 1px solid #ddd; padding-bottom: 5px;">Resultados Cuantitativos</h3>
        <table class="results-table">
            <thead>
                <tr>
                    <th>Dimensión del Aprendizaje</th>
                    <th>Valor Obtenido</th>
                    <th>Interpretación Técnica</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Activo - Reflexivo</td>
                    <td><?php echo $user['valor_activo_reflexivo']; ?></td>
                    <td>Equilibrio en procesamiento</td>
                </tr>
                <tr>
                    <td>Sensorial - Intuitivo</td>
                    <td><?php echo $user['valor_sensorial_intuitivo']; ?></td>
                    <td>Percepción de información</td>
                </tr>
                <tr>
                    <td>Visual - Verbal</td>
                    <td><?php echo $user['valor_visual_verbal']; ?></td>
                    <td>Representación cognitiva</td>
                </tr>
                <tr>
                    <td>Secuencial - Global</td>
                    <td><?php echo $user['valor_secuencial_global']; ?></td>
                    <td>Comprensión del entorno</td>
                </tr>
            </tbody>
        </table>

        <div class="dominante-box">
            <h2 style="margin:0; color: var(--rojo-muy-oscuro);">ESTILO DOMINANTE:</h2>
            <p style="font-size: 1.5em; font-weight: bold; margin: 10px 0; color: var(--rojo-oscuro);">
                <?php echo $user['estilo_dominante']; ?>
            </p>
        </div>

        <div style="margin-top: 50px; text-align: center; font-size: 0.8em; color: #888;">
            <p>Este documento es una representación lógica de los datos almacenados en el sistema de Ignis Aprendizaje.</p> <break>
            <p>Marlon Daniel C.</p> <br>
            <p>Licenciado en la Pedagogìa de las Ciencias Experimentales, Informatica<br>Firma Digital del Sistema</p>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h2 style="color: var(--rojo-oscuro);">🔍 Generar Reporte</h2>
            <p>Por favor, ingrese el ID del estudiante para generar el informe oficial.</p>
            <form method="POST" action="reporte.php">
                <input type="number" name="id_busqueda" placeholder="ID del registro" required 
                       style="padding: 10px; width: 200px; border: 1px solid var(--rojo-oscuro); border-radius: 5px;">
                <button type="submit" class="btn-print" style="margin-bottom:0;">GENERAR</button>
            </form>
        </div>
    <?php endif; ?>
</div>

</body>
</html>