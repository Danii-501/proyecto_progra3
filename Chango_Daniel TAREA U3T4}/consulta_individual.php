<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta Individual</title>
    <style>
        :root {
            --rojo-muy-oscuro: #4a0e0e;
            --rojo-oscuro: #7a1a1a;
            --rojo-medio: #a52a2a;
            --rojo-claro: #cd5c5c;
            --rojo-suave: #f5b2b2;
            --blanco-roto: #fefefe;
            --gris-claro: #f8f8f8;
        }
        body {
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, var(--gris-claro) 0%, var(--rojo-suave) 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--rojo-muy-oscuro);
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--blanco-roto);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(122, 26, 26, 0.2);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(45deg, var(--rojo-muy-oscuro), var(--rojo-oscuro));
            color: var(--blanco-roto);
            padding: 30px;
            text-align: center;
        }
        .form-container { padding: 40px; }
        .option-item {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid var(--rojo-suave);
            border-radius: 6px;
            font-family: 'Georgia', serif;
        }
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            width: 100%;
        }
        .btn-primary {
            background: linear-gradient(45deg, var(--rojo-medio), var(--rojo-oscuro));
            color: white;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .result-card {
            background: white;
            padding: 25px;
            border-left: 8px solid var(--rojo-oscuro);
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Búsqueda de Expediente</h1>
        <p>Consulta tus resultados del Test de Felder-Silverman</p>
    </div>

    <div class="form-container">
        <?php
        // Intentar incluir la base de datos con un supresor de errores para manejo personalizado
        if (!@include('config.php')) {
            echo "<div style='padding:20px; background:#ffeded; color:#a30000; border-radius:10px; border:1px solid #ffc1c1;'>
                    <strong>⚠️ Error de Sistema:</strong> El archivo de configuración <code>db.php</code> no fue encontrado. 
                    Por favor, asegúrate de que el archivo existe en la carpeta del proyecto.
                  </div>";
        } else {
        ?>
            <form method="POST" action="">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label>ID de Usuario:</label>
                        <input type="number" name="id" placeholder="Ej: 1" required class="option-item">
                    </div>
                    <div>
                        <label>Nombre del Estudiante:</label>
                        <input type="text" name="nombre" placeholder="Ej: Daniel Chango" required class="option-item">
                    </div>
                </div>
                <button type="submit" name="buscar" class="btn btn-primary">🔍 CONSULTAR RESULTADOS</button>
            </form>

            <?php
            if (isset($_POST['buscar'])) {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];

                // Consulta uniendo las dos tablas que definiste en el SQL
                $sql = "SELECT u.*, r.* FROM usuarios u 
                        LEFT JOIN resultados r ON u.id = r.usuario_id 
                        WHERE u.id = ? AND u.nombre LIKE ?";
                
                $stmt = $conn->prepare($sql);
                $search_nombre = "%$nombre%";
                $stmt->bind_param("is", $id, $search_nombre);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="result-card">
                        <h2 style="color: var(--rojo-oscuro); margin-bottom: 10px;">📄 Ficha Académica</h2>
                        <p><strong>Estudiante:</strong> <?php echo htmlspecialchars($row['nombre']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                        <p><strong>Carrera:</strong> <?php echo htmlspecialchars($row['carrera']); ?></p>
                        <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--rojo-suave);">
                        <h3 style="color: var(--rojo-medio);">Resultados del Test:</h3>
                        <p><strong>Estilo Dominante:</strong> <?php echo isset($row['estilo_dominante']) ? $row['estilo_dominante'] : 'No realizado'; ?></p>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px; font-size: 0.9em;">
                            <div>• Activo/Reflexivo: <?php echo $row['valor_activo_reflexivo']; ?></div>
                            <div>• Sensorial/Intuitivo: <?php echo $row['valor_sensorial_intuitivo']; ?></div>
                            <div>• Visual/Verbal: <?php echo $row['valor_visual_verbal']; ?></div>
                            <div>• Secuencial/Global: <?php echo $row['valor_secuencial_global']; ?></div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<p style='color:red; margin-top:20px; text-align:center;'>❌ No se encontró el registro con ID $id y nombre '$nombre'.</p>";
                }
                $stmt->close();
            }
        }
        ?>
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" style="color: var(--rojo-medio); text-decoration: none;">← Volver al Menú Principal</a>
        </div>
    </div>
</div>

</body>
</html>