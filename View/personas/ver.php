<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../Model/conexion.php";

if (!isset($_GET['id_persona'])) {
    die("ID de usuario no proporcionado.");
}

$id_persona = $_GET['id_persona'];

$conexionBD = new conexion();
$conexion = $conexionBD->conectado();

$consulta = $conexion->prepare("
    SELECT 
        p.*, 
        s.sexo, 
        td.tipo AS tipo_documento, 
        gs.grupo AS grupo_sanguineo, 
        pr.nombre_programa, 
        f.numero_ficha 
    FROM personas p
    LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
    LEFT JOIN tipo_documento td ON p.id_tipo_documento = td.id_tipo_documento
    LEFT JOIN grupo_sanguineo gs ON p.id_grupo_sanguineo = gs.id_grupo_sanguineo
    LEFT JOIN aprendices a ON p.id_persona = a.id_persona
    LEFT JOIN fichas f ON a.id_ficha = f.id_ficha
    LEFT JOIN programas pr ON f.id_programa = pr.id_programa
    WHERE p.id_persona = ?
");
$consulta->execute([$id_persona]);
$usuario = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ver Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Información del Usuario</h1>
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Detalles del Usuario
            </div>
            <div class="card-body">
                <?php
                $campos = [
                    'ID' => 'id_persona',
                    'Primer Nombre' => 'primer_nombre',
                    'Segundo Nombre' => 'segundo_nombre',
                    'Primer Apellido' => 'primer_apellido',
                    'Segundo Apellido' => 'segundo_apellido',
                    'Fecha de Nacimiento' => 'fecha_nacimiento',
                    'Tipo de Documento' => 'tipo_documento',
                    'Documento' => 'documento',
                    'Correo' => 'correo',
                    'Teléfono' => 'telefono',
                    'Dirección' => 'direccion',
                    'Sexo' => 'sexo',
                    'Grupo Sanguíneo' => 'grupo_sanguineo',
                    'Programa' => 'nombre_programa',
                    'Ficha' => 'numero_ficha'
                ];
                foreach ($campos as $label => $campo) {
                    $valor = htmlspecialchars($usuario[$campo] ?? 'No asignado');
                    echo "<p><strong>{$label}:</strong> {$valor}</p>";
                }
                ?>
            </div>
            <div class="card-footer text-end">
                <a href="../../index.php" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>