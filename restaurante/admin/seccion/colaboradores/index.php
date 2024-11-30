<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {

    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    //Proceso de borrado que busqye la imagen y la pueda borrar
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE ID=:id ");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registro_foto['foto'])) {
        if (file_exists("../../../images/colaboradores/" . $registro_foto['foto'])) {
            unlink("../../../images/colaboradores/" . $registro_foto['foto']);
        }
    }
//Borra en la base de datos
    $sentencia = $conexion->prepare("DELETE FROM tbl_colaboradores WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    header("Location:index.php");
}

//Consulta
$sentencia = $conexion->prepare("SELECT * FROM `tbl_colaboradores`");
$sentencia->execute();
$lista_colaboradores = $sentencia->fetchAll(PDO::FETCH_ASSOC);


include("../../templates/header.php");
?>

<br />
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button"><strong>Agregar registros</strong></a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Información</th>
                        <th scope="col">Redes sociales</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_colaboradores as $key => $value) { ?>
                        <tr class="">
                            <td scope="row"><?php echo ($value['ID']); ?></td>
                            <td><?php echo ($value['nombre']); ?></td>
                            <td>
                                <img src="../../../images/colaboradores/<?php echo ($value['foto']); ?>" width="100" alt="" srcset="">
                            </td>
                            <td><?php echo ($value['descripcion']); ?></td>
                            <td>
                                <?php echo ($value['linkfacebook']); ?><br />
                                <?php echo ($value['linkinstagram']); ?><br />
                                <?php echo ($value['linklinkedin']); ?></td>

                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo ($value['ID']); ?>" role="button"><strong> Editar</strong></a>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo ($value['ID']); ?>" role="button"><strong> Borrar</strong></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include("../../templates/footer.php"); ?>