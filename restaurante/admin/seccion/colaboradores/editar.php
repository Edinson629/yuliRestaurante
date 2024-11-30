<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registros = $sentencia->fetch(PDO::FETCH_LAZY);

    //Recuperación de datos (asignar al formulario)
    $nombre = $registros["nombre"];
    $foto = $registros["foto"];
    $descripcion = $registros["descripcion"];
    $linkfacebook = $registros["linkfacebook"];
    $linkinstagram = $registros["linkinstagram"];
    $linklinkedin = $registros["linklinkedin"];
}

if ($_POST) {

    $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "";
    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
    $linkfacebook = (isset($_POST['linkfacebook'])) ? $_POST['linkfacebook'] : "";
    $linkinstagram = (isset($_POST['linkinstagram'])) ? $_POST['linkinstagram'] : "";
    $linklinkedin = (isset($_POST['linklinkedin'])) ? $_POST['linklinkedin'] : "";

    $sentencia = $conexion->prepare("UPDATE `tbl_colaboradores`
    SET nombre=:nombre, 
    descripcion=:descripcion,
    linkfacebook=:linkfacebook,
    linkinstagram=:linkinstagram,
    linklinkedin=:linklinkedin
    WHERE ID=:id");

    // Vincula los parámetros a la sentencia preparada
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":linkfacebook", $linkfacebook);
    $sentencia->bindParam(":linkinstagram", $linkinstagram);
    $sentencia->bindParam(":linklinkedin", $linklinkedin);
    $sentencia->bindParam(":id", $txtID);

    $sentencia->execute();

    //Proceso de actualizción de foto
    $foto = (isset($_FILES['foto']["name"])) ? $_FILES['foto']["name"] : "";
    $tmp_foto = $_FILES["foto"]["tmp_name"];
    if ($foto != "") {

        $fecha_foto = new DateTime();
        $nombre_foto = $fecha_foto->getTimestamp() . "_" . $foto;
        move_uploaded_file($tmp_foto, "../../../images/colaboradores/" . $nombre_foto);

        $sentencia = $conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE ID=:id ");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_foto['foto'])) {
            if (file_exists("../../../images/colaboradores/" . $registro_foto['foto'])) {
                unlink("../../../images/colaboradores/" . $registro_foto['foto']);
            }
        }

        $sentencia = $conexion->prepare("UPDATE `tbl_colaboradores`  SET foto=:foto WHERE ID=:id");

        $sentencia->bindParam(":foto", $nombre_foto);
        $sentencia->bindParam(":id", $txtID);

        $sentencia->execute();
    }
    header("Location: index.php");
}

include("../../templates/header.php");
?>
<br />
<div class="card">
    <div class="card-header"><strong>Chefs</strong></div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">ID:</label>
                <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="Escriba el titulo del banner" />
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" value="<?php echo $nombre; ?>" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Foto:</label><br />
                <img src="../../../images/colaboradores/<?php echo $foto; ?>" width="100" alt="" srcset="">
                <input type="file" class="form-control" name="foto" id="" placeholder="" aria-describedby="fileHelpId" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" class="form-control" value="<?php echo $descripcion; ?>" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Escriba la descripción" />
            </div>

            <div class="mb-3">
                <label for="linkfacebook" class="form-label">Facebook:</label>
                <input type="text" class="form-control" value="<?php echo $linkfacebook; ?>" name="linkfacebook" id="linkfacebook" aria-describedby="helpId" placeholder="" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Instagram:</label>
                <input type="text" class="form-control" value="<?php echo $linkinstagram; ?>" name="linkinstagram" id="linkinstagram" aria-describedby="helpId" placeholder="" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Linkedin:</label>
                <input type="text" class="form-control" value="<?php echo $linklinkedin; ?>" name="linklinkedin" id="linklinkedin" aria-describedby="helpId" placeholder="" />
            </div>

            <button type="submit" class="btn btn-success"><strong>Modificar chef</strong></button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Cancelar</strong></a>
        </form>

    </div>
    <div class="card-footer text-muted">

    </div>
</div>
<br />

<?php
include("../../templates/footer.php");
?>