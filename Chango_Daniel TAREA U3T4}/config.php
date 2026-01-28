<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistema_aprendizaje";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error Lógico: La base de datos '$db' no existe o los datos de acceso son incorrectos. Verifique en phpMyAdmin.");
}

$conn->set_charset("utf8");

function guardarResultado($datos, $totales) {
    global $conn;
    
    try {
        
        $conn->autocommit(FALSE);

        $email_limpio = $conn->real_escape_string($datos['email']);
        $check = $conn->query("SELECT id FROM usuarios WHERE email = '$email_limpio'");
        
        if($check && $check->num_rows > 0) {
            throw new Exception("El correo electrónico '{$datos['email']}' ya tiene un test registrado.");
        }

        $nombre  = $conn->real_escape_string($datos['nombre']);
        $f_nac   = $conn->real_escape_string($datos['fecha_nac']);
        $genero  = $conn->real_escape_string($datos['genero']);
        $carrera = $conn->real_escape_string($datos['carrera']);

        $sqlU = "INSERT INTO usuarios (nombre, email, fecha_nac, genero, carrera) 
                 VALUES ('$nombre', '$email_limpio', '$f_nac', '$genero', '$carrera')";
        
        if (!$conn->query($sqlU)) throw new Exception("Error al registrar usuario: " . $conn->error);
        
        $u_id = $conn->insert_id; 

        $sqlR = "INSERT INTO resultados (usuario_id, estilo_dominante, valor_activo_reflexivo, valor_sensorial_intuitivo, valor_visual_verbal, valor_secuencial_global) 
                 VALUES ($u_id, '{$totales['dominante']}', {$totales['AR']}, {$totales['SI']}, {$totales['VV']}, {$totales['SG']})";
        
        if (!$conn->query($sqlR)) throw new Exception("Error al guardar resultados técnicos.");

        $conn->commit();
        $conn->autocommit(TRUE);
        return "Éxito: Datos agregados y procesados correctamente.";

    } catch (Exception $e) {

        $conn->rollback();
        $conn->autocommit(TRUE);
        return "Excepción Capturada: " . $e->getMessage();
    }
}
?>