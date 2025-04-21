<?php

include_once "../../Model/conexion.php";

if (isset($_GET['id_persona'])) {
    $id_persona = $_GET['id_persona'];

    try {
        $conexionBD = new conexion();
        $conexion = $conexionBD->conectado();

        $stmtAprendices = $conexion->prepare("DELETE FROM aprendices WHERE id_persona = ?");
        $stmtAprendices->execute([$id_persona]);

        $stmtPersonas = $conexion->prepare("DELETE FROM personas WHERE id_persona = ?");
        $stmtPersonas->execute([$id_persona]);

        $_SESSION['mensaje'] = "<div class='alert alert-success'>Registro eliminado correctamente.</div>";
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "<div class='alert alert-danger'>Error al eliminar el registro: " . $e->getMessage() . "</div>";
    }
} else {
    $_SESSION['mensaje'] = "<div class='alert alert-danger'>ID de persona no proporcionado.</div>";
}

header("Location: ../../index.php");
exit;