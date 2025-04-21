<?php
include_once "../../Model/conexion.php";

$conexionBD = new conexion();
$conexion = $conexionBD->conectado();

$tiposDocumento = $conexion->query("SELECT * FROM tipo_documento")->fetchAll(PDO::FETCH_ASSOC);
$gruposSanguineos = $conexion->query("SELECT * FROM grupo_sanguineo")->fetchAll(PDO::FETCH_ASSOC);
$sexos = $conexion->query("SELECT * FROM sexo")->fetchAll(PDO::FETCH_ASSOC);
$programas = $conexion->query("SELECT * FROM programas")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $primerNombre = $_POST['primerNombre'];
    $segundoNombre = $_POST['segundoNombre'];
    $primerApellido = $_POST['primerApellido'];
    $segundoApellido = $_POST['segundoApellido'];
    $fechaNacimiento = $_POST['fecha'];
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $idTipoDocumento = $_POST['id_tipo_documento'];
    $idGrupoSanguineo = $_POST['id_grupo_sanguineo'];
    $idSexo = $_POST['id_sexo'];
    $idPrograma = $_POST['id_programa'];

    try {
        $consultaFicha = $conexion->prepare("SELECT id_ficha FROM fichas WHERE id_programa = ?");
        $consultaFicha->execute([$idPrograma]);
        $ficha = $consultaFicha->fetch(PDO::FETCH_ASSOC);

        if (!$ficha) {
            throw new Exception("No se encontró una ficha asociada al programa seleccionado.");
        }

        $idFicha = $ficha['id_ficha'];

        $conexion->beginTransaction();

        $insertarPersona = $conexion->prepare("INSERT INTO personas (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, documento, correo, telefono, direccion, id_tipo_documento, id_grupo_sanguineo, id_sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $resultado = $insertarPersona->execute([
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $fechaNacimiento,
            $documento,
            $correo,
            $telefono,
            $direccion,
            $idTipoDocumento,
            $idGrupoSanguineo,
            $idSexo
        ]);

        $idPersona = $conexion->lastInsertId();

        $insertarAprendiz = $conexion->prepare("INSERT INTO aprendices (id_persona, id_ficha) VALUES (?, ?)");
        $insertarAprendiz->execute([$idPersona, $idFicha]);

        $conexion->commit();

        header("Location: ../../index.php?status=success&action=create");
        exit;
    } catch (Exception $e) {
        $conexion->rollBack();
        header("Location: ../../index.php?status=error&action=create");
        exit;
    }
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Registrar Aprendiz</h1>
        <form method="POST">
            <div class="row mb-3">
                <div class="col-3">
                    <label for="primerNombre" class="form-label">Primer Nombre</label>
                    <input type="text" class="form-control" name="primerNombre" id="primerNombre" required>
                </div>
                <div class="col-3">
                    <label for="segundoNombre" class="form-label">Segundo Nombre</label>
                    <input type="text" class="form-control" name="segundoNombre" id="segundoNombre">
                </div>
                <div class="col-3">
                    <label for="primerApellido" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" name="primerApellido" id="primerApellido" required>
                </div>
                <div class="col-3">
                    <label for="segundoApellido" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" name="segundoApellido" id="segundoApellido">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha" id="fecha" required>
                </div>
                <div class="col-4">
                    <label for="documento" class="form-label">Número de Documento</label>
                    <input type="text" class="form-control" name="documento" id="documento" required>
                </div>
                <div class="col-4">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" name="correo" id="correo">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" name="telefono" id="telefono">
                </div>
                <div class="col-6">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" id="direccion">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <label class="form-label">Tipo de Documento</label>
                    <select name="id_tipo_documento" class="form-select" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($tiposDocumento as $tipo): ?>
                            <option value="<?= htmlspecialchars($tipo['id_tipo_documento']) ?>"><?= htmlspecialchars($tipo['tipo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-3">
                    <label class="form-label">Grupo Sanguíneo</label>
                    <select name="id_grupo_sanguineo" class="form-select" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($gruposSanguineos as $grupo): ?>
                            <option value="<?= htmlspecialchars($grupo['id_grupo_sanguineo']) ?>"><?= htmlspecialchars($grupo['grupo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-3">
                    <label class="form-label">Sexo</label>
                    <select name="id_sexo" class="form-select" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($sexos as $sexo): ?>
                            <option value="<?= htmlspecialchars($sexo['id_sexo']) ?>"><?= htmlspecialchars($sexo['sexo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-3">
                    <label class="form-label">Programa</label>
                    <select name="id_programa" class="form-select" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($programas as $programa): ?>
                            <option value="<?= htmlspecialchars($programa['id_programa']) ?>"><?= htmlspecialchars($programa['nombre_programa']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="../../index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>