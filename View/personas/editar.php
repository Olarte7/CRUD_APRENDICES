<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../Model/conexion.php";

if (isset($_GET['id_persona'])) {
    $id_persona = $_GET['id_persona'];

    $conexionBD = new conexion();
    $conexion = $conexionBD->conectado();

    $consulta = $conexion->prepare("SELECT * FROM personas WHERE id_persona = ?");
    $consulta->execute([$id_persona]);
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuario no encontrado.");
    }

    $tiposDocumento = $conexion->query("SELECT * FROM tipo_documento")->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("ID de usuario no proporcionado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $primerNombre = $_POST['primer_nombre'];
    $segundoNombre = $_POST['segundo_nombre'];
    $primerApellido = $_POST['primer_apellido'];
    $segundoApellido = $_POST['segundo_apellido'];
    $idTipoDocumento = $_POST['id_tipo_documento'];
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $actualizar = $conexion->prepare("UPDATE personas SET 
        primer_nombre = ?, 
        segundo_nombre = ?, 
        primer_apellido = ?, 
        segundo_apellido = ?, 
        id_tipo_documento = ?, 
        documento = ?, 
        correo = ?, 
        telefono = ?, 
        direccion = ? 
        WHERE id_persona = ?");
    $resultado=$actualizar->execute([
        $primerNombre,
        $segundoNombre,
        $primerApellido,
        $segundoApellido,
        $idTipoDocumento,
        $documento,
        $correo,
        $telefono,
        $direccion,
        $id_persona
    ]);

    if ($resultado) {
        header("Location: ../../index.php?status=success&action=edit");
    } else {
        header("Location: ../../index.php?status=error&action=edit");
    }
    exit;
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Usuario</h1>
        <div class="card mt-4">
            <div class="card-header bg-warning text-white">
                Formulario de Edición
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="primer_nombre" class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" value="<?= htmlspecialchars($usuario['primer_nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segundo_apellido" id="segundoApellido" value="<?= htmlspecialchars($usuario['segundo_apellido'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="primer_apellido" class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" value="<?= htmlspecialchars($usuario['primer_apellido']) ?>" required>
                    </div>
                    <div class="col-3">
                        <label for="segundoApellido" class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segundoApellido" id="segundoApellido">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Documento</label>
                        <select name="id_tipo_documento" class="form-select" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($tiposDocumento as $tipo): ?>
                                <option value="<?= htmlspecialchars($tipo['id_tipo_documento']) ?>" <?= $tipo['id_tipo_documento'] == $usuario['id_tipo_documento'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tipo['tipo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" value="<?= htmlspecialchars($usuario['documento']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>">
                    </div>
                    <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                    <a href="../../index.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>