<?php
include("../../bd.php");

if ($_POST) {

    $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "";
    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
    $ingredientes = (isset($_POST['ingredientes'])) ? $_POST['ingredientes'] : "";
    $precio = (isset($_POST['precio'])) ? $_POST['precio'] : "";


    $sentencia = $conexion->prepare("UPDATE `tbl_menu`
    SET nombre=:nombre,
    ingredientes=:ingredientes,
    precio=:precio
    WHERE ID=:id");

    // Vincula los parámetros a la sentencia preparada
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":ingredientes", $ingredientes);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":id", $txtID);

    $sentencia->execute();

    //Proceso de actualizción de foto
    $foto = (isset($_FILES['foto']["name"])) ? $_FILES['foto']["name"] : "";
    $tmp_foto = $_FILES["foto"]["tmp_name"];
    if ($foto != "") {
        $fecha_foto = new DateTime();
        $nombre_foto = $fecha_foto->getTimestamp() . "_" . $foto;
        move_uploaded_file($tmp_foto, "../../../images/menu/" . $nombre_foto);

        $sentencia = $conexion->prepare("SELECT * FROM `tbl_menu` WHERE ID=:id ");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_foto['foto'])) {
            if (file_exists("../../../images/menu/" . $registro_foto['foto'])) {
                unlink("../../../images/menu/" . $registro_foto['foto']);
            }
        }

        $sentencia = $conexion->prepare("UPDATE `tbl_menu` 
         SET foto=:foto 
         WHERE ID=:id");

        $sentencia->bindParam(":foto", $nombre_foto);
        $sentencia->bindParam(":id", $txtID);

        $sentencia->execute();
    }
    header("Location: index.php");
}

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_menu` WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registros = $sentencia->fetch(PDO::FETCH_LAZY);

    //Recuperación de datos (asignar al formulario)
    $nombre = $registros["nombre"];
    $ingredientes = $registros["ingredientes"];
    $foto = $registros["foto"];
    $precio = $registros["precio"];
}

include("../../templates/header.php"); ?>

<br />
<div class="card">
    <div class="card-header">Menú de comida</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">ID</label>
                <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="" />
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" value="<?php echo $nombre; ?>" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre comida" />

            </div>

            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes (separados por comas):</label>
                <input type="text" class="form-control" value="<?php echo $ingredientes; ?>" name="ingredientes" id="ingredientes" aria-describedby="helpId" placeholder="Ingredientes" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label"> Foto:</label><br />
                <img src="../../../images/menu/<?php echo $foto; ?>" width="100">
                <input type="file" class="form-control" name="foto" id="foto" placeholder="" aria-describedby="fileHelpId" />
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" class="form-control" value="<?php echo $precio; ?>" name="precio" id="precio" aria-describedby="helpId" placeholder="Precio" />

            </div>

            <button type="submit" class="btn btn-success"><strong>Editar comida</strong></button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Cancelar</strong></a>


        </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>



<?php
include("../../templates/footer.php"); ?>