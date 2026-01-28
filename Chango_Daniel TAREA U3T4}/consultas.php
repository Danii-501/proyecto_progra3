<?php
require_once 'config.php';

// 1. CAPTURA DE FILTROS (Compatible con PHP 5.3)
$filtro_carrera = isset($_GET['f_carrera']) ? $_GET['f_carrera'] : '';
$filtro_estilo = isset($_GET['f_estilo']) ? $_GET['f_estilo'] : '';

// 2. CONSTRUCCIÓN DE LA CONSULTA SQL (Agregamos u.id)
$sql = "SELECT u.id, u.nombre, u.email, u.carrera, u.fecha_registro, r.estilo_dominante 
        FROM usuarios u 
        INNER JOIN resultados r ON u.id = r.usuario_id 
        WHERE 1=1";

if (!empty($filtro_carrera)) {
    $sql .= " AND u.carrera = '$filtro_carrera'";
}
if (!empty($filtro_estilo)) {
    $sql .= " AND r.estilo_dominante = '$filtro_estilo'";
}

$sql .= " ORDER BY u.id DESC"; // Ordenamos por el más reciente
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Académico de Estilos</title>
    <style>
        :root {
            --rojo-oscuro: #7a1a1a;
            --rojo-medio: #a52a2a;
            --gris-fondo: #f4f4f4;
        }
        body { font-family: 'Georgia', serif; background-color: var(--gris-fondo); padding: 20px; color: #333; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 8px solid var(--rojo-oscuro); }
        h2 { color: var(--rojo-oscuro); text-align: center; margin-top: 0; }
        
        /* Estilo de los filtros */
        .filtros-box { background: #fff1f1; padding: 20px; border-radius: 5px; margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-end; border: 1px solid var(--rojo-medio); }
        .filter-group { display: flex; flex-direction: column; flex: 1; }
        .filter-group label { font-weight: bold; font-size: 14px; margin-bottom: 5px; color: var(--rojo-oscuro); }
        .input-filter { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }
        
        /* Tabla */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: var(--rojo-oscuro); color: white; padding: 12px; text-align: left; font-size: 15px; }
        td { padding: 12px; border-bottom: 1px solid #ddd; font-size: 14px; }
        tr:hover { background-color: #fff9f9; }
        .id-badge { background: #eee; padding: 2px 8px; border-radius: 4px; font-weight: bold; color: #555; }
        
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: bold; }
        .btn-search { background: var(--rojo-medio); color: white; height: 40px; }
        .btn-back { background: #666; color: white; margin-bottom: 20px; font-size: 13px; }
        .btn-action { font-size: 12px; padding: 5px 10px; margin-right: 5px; border: 1px solid #ccc; background: white; color: var(--rojo-oscuro); border-radius: 3px; }
        .btn-action:hover { background: var(--rojo-oscuro); color: white; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="btn btn-back">⬅ Volver al Menú</a>
    <h2>Historial de Estudiantes y Estilos</h2>

    <form method="GET" class="filtros-box">
        <div class="filter-group">
            <label>Filtrar por Carrera:</label>
            <select name="f_carrera" class="input-filter">
                <option value="">-- Todas las carreras --</option>
                <option value="Sistemas" <?php if($filtro_carrera=='Sistemas') echo 'selected'; ?>>Sistemas</option>
                <option value="Psicologia" <?php if($filtro_carrera=='Psicologia') echo 'selected'; ?>>Psicología</option>
                <option value="Diseno" <?php if($filtro_carrera=='Diseno') echo 'selected'; ?>>Diseño</option>
                <option value="Administracion" <?php if($filtro_carrera=='Administracion') echo 'selected'; ?>>Administración</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label>Filtrar por Estilo Detectado:</label>
            <select name="f_estilo" class="input-filter">
                <option value="">-- Todos los estilos --</option>
                <option value="Activo" <?php if($filtro_estilo=='Activo') echo 'selected'; ?>>Activo</option>
                <option value="Reflexivo" <?php if($filtro_estilo=='Reflexivo') echo 'selected'; ?>>Reflexivo</option>
                <option value="Sensorial" <?php if($filtro_estilo=='Sensorial') echo 'selected'; ?>>Sensorial</option>
                <option value="Visual" <?php if($filtro_estilo=='Visual') echo 'selected'; ?>>Visual</option>
                <option value="Secuencial" <?php if($filtro_estilo=='Secuencial') echo 'selected'; ?>>Secuencial</option>
            </select>
        </div>

        <button type="submit" class="btn btn-search">🔍 Aplicar Filtros</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante / Email</th>
                <th>Carrera</th>
                <th>Estilo Dominante</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><span class="id-badge"><?php echo $row['id']; ?></span></td>
                        <td>
                            <strong><?php echo $row['nombre']; ?></strong><br>
                            <small style="color: #666;"><?php echo $row['email']; ?></small>
                        </td>
                        <td><?php echo $row['carrera']; ?></td>
                        <td>
                            <span style="color:var(--rojo-medio); font-weight:bold;">
                                <?php echo $row['estilo_dominante']; ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($row['fecha_registro'])); ?></td>
                        <td>
                            <a href="reporte.php?id=<?php echo $row['id']; ?>" class="btn-action">Ver Reporte</a>
                            <a href="actualizar.php?id=<?php echo $row['id']; ?>" class="btn-action">Editar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 40px;">No se encontraron registros que coincidan con los criterios de búsqueda.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>