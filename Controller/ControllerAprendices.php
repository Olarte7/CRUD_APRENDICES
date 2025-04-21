<?php
include_once "Model/conexion.php";

if (isset($_POST['boton']) && $_POST['boton'] === 'ok') {
    $primerNombre = $_POST['primerNombre'];
    $segundoNombre = $_POST['segundoNombre'];
    $primerApellido = $_POST['primerApellido'];
    $segundoApellido = $_POST['segundoApellido'];
    $fechaNacimiento = $_POST['fecha'];
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $id_tipo_documento = $_POST['id_tipo_documento'];
    $id_grupo_sanguineo = $_POST['id_grupo_sanguineo'];
    $id_sexo = $_POST['id_sexo'];
    $id_programa = $_POST['id_programa'];

    try {
        $conexionBD = new conexion();
        $conexion = $conexionBD->conectado();

        $stmt = $conexion->prepare("INSERT INTO personas (documento, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, correo, telefono, direccion, id_tipo_documento, id_grupo_sanguineo, id_sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $documento,
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $fechaNacimiento,
            $correo,
            $telefono,
            $direccion,
            $id_tipo_documento,
            $id_grupo_sanguineo,
            $id_sexo
        ]);

        $id_persona = $conexion->lastInsertId();

        $stmtFicha = $conexion->prepare("SELECT id_ficha FROM fichas WHERE id_programa = ? LIMIT 1");
        $stmtFicha->execute([$id_programa]);
        $ficha = $stmtFicha->fetch(PDO::FETCH_ASSOC);

        if ($ficha) {
            $id_ficha = $ficha['id_ficha'];

            $stmtAprendiz = $conexion->prepare("INSERT INTO aprendices (id_persona, id_ficha, fecha_ingreso, estado) VALUES (?, ?, NOW(), 'Activo')");
            $stmtAprendiz->execute([$id_persona, $id_ficha]);
        }

    } catch (PDOException $e) {
        die("Error al registrar: " . $e->getMessage());
    }
}
