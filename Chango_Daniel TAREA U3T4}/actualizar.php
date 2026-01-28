<?php 
include 'config.php'; 

// 1. LÓGICA DE ACTUALIZACIÓN (Solo ocurre si presionas el botón de guardar)
$mensaje = "";
if (isset($_POST['btn_actualizar'])) {
    $id_a_cambiar = intval($_POST['id_real']); // ID oculto para asegurar que editamos el correcto
    $nombre  = $conn->real_escape_string($_POST['nombre']);
    $email   = $conn->real_escape_string($_POST['email']);
    $carrera = $conn->real_escape_string($_POST['carrera']);
    $genero  = $conn->real_escape_string($_POST['genero']);

    // IMPORTANTE: Usamos WHERE id = $id_a_cambiar para que no cree uno nuevo
    $sql = "UPDATE usuarios SET 
            nombre = '$nombre', 
            email = '$email', 
            carrera = '$carrera', 
            genero = '$genero' 
            WHERE id = $id_a_cambiar";
    
    if ($conn->query($sql)) {
        $mensaje = "<div class='alerta-exito'>✅ ¡Registro #$id_a_cambiar actualizado con éxito!</div>";
    } else {
        $mensaje = "<div class='alerta-error'>❌ Error al actualizar: " . $conn->error . "</div>";
    }
}

// 2. LÓGICA DE BÚSQUEDA (Para cargar los datos en el formulario)
$user = null;
if (isset($_POST['btn_buscar']) || isset($_GET['id'])) {
    $id_buscado = isset($_POST['id_busqueda']) ? intval($_POST['id_busqueda']) : intval($_GET['id']);
    $res = $conn->query("SELECT * FROM usuarios WHERE id = $id_buscado");
    if ($res) {
        $user = $res->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización Académica</title>
    <style>
        :root { --rojo-oscuro: #7a1a1a; --rojo-muy-oscuro: #4a0e0e; --rojo-suave: #f5b2b2; }
        body { font-family: 'Georgia', serif; background: #f4f4f4; padding: 30px; }
        .container { max-width: 800px; margin: auto; background: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); overflow: hidden; }
        .header { background: var(--rojo-muy-oscuro); color: white; padding: 20px; text-align: center; }
        .form-content { padding: 30px; }
        .input-estilo { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-update { background: var(--rojo-oscuro); color: white; border: none; padding: 15px; width: 100%; border-radius: 25px; font-weight: bold; cursor: pointer; font-size: 16px; }
        .btn-update:hover { background: #900; }
        .alerta-exito { background: #d4edda; color: #155724; padding: 15px; border-left: 5px solid #28a745; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>✏️ Modificar Registro de Usuario</h1>
    </div>

    <div class="form-content">
        <?php echo $mensaje; ?>

        <form method="POST" action="actualizar.php" style="background: #fff5f5; padding: 15px; border: 1px solid var(--rojo-suave); border-radius: 8px; margin-bottom: 25px;">
            <label style="font-weight: bold;">1. Ingrese ID del estudiante a editar:</label>
            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <input type="number" name="id_busqueda" placeholder="Ej: 5" required style="flex:1; padding: 8px;">
                <button type="submit" name="btn_buscar" style="background: #444; color: white; border: none; padding: 0 20px; border-radius: 4px; cursor: pointer;">BUSCAR</button>
            </div>
        </form>

        <?php if ($user): ?>
            <form method="POST" action="actualizar.php">
                <input type="hidden" name="id_real" value="<?php echo $user['id']; ?>">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label>Nombre Completo:</label>
                        <input type="text" name="nombre" value="<?php echo $user['nombre']; ?>" class="input-estilo" required>
                    </div>
                    <div>
                        <label>Email Institucional:</label>
                        <input type="email" name="email" value="<?php echo $user['email']; ?>" class="input-estilo" required>
                    </div>
                    <div>
                        <label>Carrera:</label>
                        <select name="carrera" class="input-estilo">
                            <option value="Sistemas" <?php echo ($user['carrera']=='Sistemas'?'selected':''); ?>>Sistemas</option>
                            <option value="Psicologia" <?php echo ($user['carrera']=='Psicologia'?'selected':''); ?>>Psicología</option>
                            <option value="Diseno" <?php echo ($user['carrera']=='Diseno'?'selected':''); ?>>Diseño</option>
                            <option value="Administracion" <?php echo ($user['carrera']=='Administracion'?'selected':''); ?>>Administración</option>
                        </select>
                    </div>
                    <div>
                        <label>Género:</label>
                        <select name="genero" class="input-estilo">
                            <option value="M" <?php echo ($user['genero']=='M'?'selected':''); ?>>Masculino</option>
                            <option value="F" <?php echo ($user['genero']=='F'?'selected':''); ?>>Femenino</option>
                            <option value="Otro" <?php echo ($user['genero']=='Otro'?'selected':''); ?>>Otro</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" name="btn_actualizar" class="btn-update">
                        💾 APLICAR CAMBIOS PERMANENTES
                    </button>
                </div>
            </form>
        <?php elseif(isset($_POST['btn_buscar'])): ?>
            <p style="color: red; text-align: center;">⚠️ El ID no existe en la base de datos.</p>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 20px;">
            <a href="index.php" style="color: #666; text-decoration: none; font-size: 14px;">← Volver al inicio</a>
        </div>
    </div>
</div>

</body>
</html>