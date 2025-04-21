<?php
include_once "Model/conexion.php";

$conexionBD = new conexion();
$conexion = $conexionBD->conectado();

$consulta = $conexion->prepare("SELECT p.id_persona, p.primer_nombre, p.segundo_nombre, p.primer_apellido, p.segundo_apellido, s.sexo, 
    MAX(pr.nombre_programa) AS nombre_programa, 
    MAX(f.numero_ficha) AS numero_ficha
    FROM personas p
    LEFT JOIN aprendices a ON p.id_persona = a.id_persona
    LEFT JOIN fichas f ON a.id_ficha = f.id_ficha
    LEFT JOIN programas pr ON f.id_programa = pr.id_programa
    LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
    GROUP BY 
        p.id_persona, 
        p.primer_nombre, 
        p.segundo_nombre, 
        p.primer_apellido, 
        p.segundo_apellido, 
        s.sexo
");
$consulta->execute();
$resultados = $consulta->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SENA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <h1 class="text-center p-3">Lista de Aprendices</h1>
    <div class="container-fluid row">
        <div class="col-12 p-4">
            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">#</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Género</th>
                        <th scope="col">Programa</th>
                        <th scope="col">Ficha</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 1;
                    foreach ($resultados as $persona) {
                        $numeroFicha = $persona->numero_ficha ?? "No asignada";
                        $programaNombre = $persona->nombre_programa ?? "No asignado";

                        echo "<tr>
                            <td>{$contador}</td>
                            <td>{$persona->primer_nombre} {$persona->segundo_nombre}</td>
                            <td>{$persona->primer_apellido} {$persona->segundo_apellido}</td>
                            <td>{$persona->sexo}</td>
                            <td>{$programaNombre}</td>
                            <td>{$numeroFicha}</td>
                            <td>
                                <a href='View/personas/ver.php?id_persona=" . $persona->id_persona . "' class='btn btn-primary btn-sm'>
                                    <i class='fa fa-eye'></i>
                                </a>
                                <a href='#' class='btn btn-danger btn-sm' onclick='confirmarEliminacion(" . $persona->id_persona . ")'>
                                    <i class='fa fa-trash'></i>
                                </a>
                                <a href='View/personas/editar.php?id_persona=" . $persona->id_persona . "' class='btn btn-warning btn-sm'>
                                    <i class='fa fa-edit'></i>
                                </a>
                            </td>
                        </tr>";
                        $contador++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-12 p-3 text-start">
            <a href="View/personas/create.php" class="btn btn-success">
                <i class="fa-solid fa-circle-plus"></i> Crear Aprendiz
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script>
        // Función para confirmar eliminación
        function confirmarEliminacion(idPersona) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `View/personas/delete.php?id_persona=${idPersona}`;
                }
            });
        }

        // Mostrar alertas según los parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const action = urlParams.get('action');

        if (status && action) {
            const messages = {
                create: {
                    success: 'El aprendiz ha sido registrado correctamente.',
                    error: 'Hubo un problema al registrar el aprendiz.'
                },
                edit: {
                    success: 'El aprendiz ha sido editado correctamente.',
                    error: 'Hubo un problema al editar el aprendiz.'
                }
            };

            const message = messages[action]?.[status];
            if (message) {
                Swal.fire({
                    icon: status === 'success' ? 'success' : 'error',
                    title: status === 'success' ? '¡Éxito!' : 'Error',
                    text: message,
                    confirmButtonColor: status === 'success' ? '#3085d6' : '#d33',
                });
            }
        }
    </script>
</body>

</html>