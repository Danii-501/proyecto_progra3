<?php 
// 1. CONEXIÓN (Cambiado de db.php a config.php)
include 'config.php'; 

$mensaje = "";

// 2. LÓGICA DE ELIMINACIÓN
if (isset($_POST['id_eliminar'])) {
    $id = intval($_POST['id_eliminar']);
    $nombre = $conn->real_escape_string($_POST['nombre_confirmar']);

    // Primero verificamos si existe para dar un mensaje preciso
    $check = $conn->query("SELECT * FROM usuarios WHERE id = $id AND nombre = '$nombre'");
    
    if ($check->num_rows > 0) {
        $sql = "DELETE FROM usuarios WHERE id = $id";
        if ($conn->query($sql)) {
            echo "<script>alert('Registro eliminado correctamente.'); window.location.href='index.php';</script>";
            exit;
        } else {
            $mensaje = "<div class='alerta-error'>Error al eliminar: " . $conn->error . "</div>";
        }
    } else {
        $mensaje = "<div class='alerta-error'>⚠️ Los datos no coinciden. Verifique el ID y el Nombre.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Registro - Sistema Académico</title>
    <style>
        :root {
            --rojo-muy-oscuro: #4a0e0e;
            --rojo-oscuro: #7a1a1a;
            --rojo-suave: #f5b2b2;
            --blanco: #ffffff;
        }
        body {
            font-family: 'Georgia', serif;
            background: #fdf2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            width: 90%;
            background: var(--blanco);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(74, 14, 14, 0.2);
            border-top: 8px solid var(--rojo-muy-oscuro);
            overflow: hidden;
        }
        .header {
            padding: 25px;
            text-align: center;
            background: #fffafa;
            border-bottom: 1px solid #eee;
        }
        .form-body { padding: 30px; }
        .label-style { display: block; margin-bottom: 8px; font-weight: bold; color: var(--rojo-muy-oscuro); }
        .input-style {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid var(--rojo-suave);
            border-radius: 6px;
            box-sizing: border-box;
            font-family: inherit;
        }
        .btn-danger {
            background: linear-gradient(45deg, #d32f2f, #b71c1c);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }
        .btn-danger:hover { background: #8e1414; transform: scale(1.02); }
        .alerta-error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2 style="margin:0; color: var(--rojo-muy-oscuro);">🗑️ Gestión de Bajas</h2>
        <p style="color: #666; font-size: 0.9em; margin-top: 10px;">Esta acción es irreversible</p>
    </div>

    <div class="form-body">
        <?php echo $mensaje; ?>

        <form id="deleteForm" method="POST" action="">
            <label class="label-style">ID del Registro:</label>
            <input type="number" name="id_eliminar" id="del_id" placeholder="Ej: 102" required class="input-style">

            <label class="label-style">Nombre de Confirmación:</label>
            <input type="text" name="nombre_confirmar" id="del_nombre" placeholder="Nombre completo del estudiante" required class="input-style">
            
            <button type="button" onclick="confirmarAccion()" class="btn-danger">
                ELIMINAR PERMANENTEMENTE
            </button>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php" style="color: #999; text-decoration: none; font-size: 0.8em;">← Cancelar y volver</a>
            </div>
        </form>
    </div>
</div>

<script>
function confirmarAccion() {
    var nombre = document.getElementById('del_nombre').value;
    var id = document.getElementById('del_id').value;
    
    if(nombre === "" || id === "") {
        alert("Por favor, complete ambos campos para continuar.");
        return;
    }

    // Ventana emergente de confirmación
    var respuesta = confirm("⚠️ ¡ADVERTENCIA CRÍTICA!\n\n¿Está seguro de que desea eliminar a '" + nombre + "'?\n\nAl confirmar, se borrarán todos sus datos personales y los resultados de sus test de la base de datos.");
    
    if (respuesta) {
        document.getElementById('deleteForm').submit();
    }
}
</script>

</body>
</html>