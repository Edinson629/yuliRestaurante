<?php
include("../../bd.php");
if ($_POST) {
    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
    $linkfacebook = (isset($_POST['linkfacebook'])) ? $_POST['linkfacebook'] : "";
    $linkinstagram = (isset($_POST['linkinstagram'])) ? $_POST['linkinstagram'] : "";
    $linklinkedin = (isset($_POST['linklinkedin'])) ? $_POST['linklinkedin'] : "";

    // Prepara la sentencia SQL
    $sentencia = $conexion->prepare("INSERT INTO `tbl_colaboradores` (`ID`, `nombre`, `descripcion`, `linkfacebook`, `linkinstagram`, `linklinkedin`, `foto`)
        VALUES (NULL, :nombre, :descripcion, :linkfacebook, :linkinstagram, :linklinkedin, :foto);");

    $foto = (isset($_FILES['foto']["name"])) ? $_FILES['foto']["name"] : "";
    $fecha_foto = new DateTime();
    $nombre_foto =$fecha_foto->getTimestamp() . "_" . $foto;
    $tmp_foto=$_FILES["foto"]["tmp_name"];

    if($tmp_foto!=""){
        move_uploaded_file($tmp_foto,"../../../images/colaboradores/".$nombre_foto);
    }
   
    // Vincula los parámetros a la sentencia preparada
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":foto", $nombre_foto);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":linkfacebook", $linkfacebook);
    $sentencia->bindParam(":linkinstagram", $linkinstagram);
    $sentencia->bindParam(":linklinkedin", $linklinkedin);

    // Ejecuta la sentencia
    $sentencia->execute();
    header("Location:index.php");
}
include("../../templates/header.php");
?>
<br />
<div class="card">
    <div class="card-header"><strong>Chefs</strong></div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="" placeholder="" aria-describedby="fileHelpId" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Escriba la descripción" />
            </div>

            <div class="mb-3">
                <label for="linkfacebook" class="form-label">Facebook:</label>
                <input type="text" class="form-control" name="linkfacebook" id="linkfacebook" aria-describedby="helpId" placeholder="" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Instagram:</label>
                <input type="text" class="form-control" name="linkinstagram" id="linkinstagram" aria-describedby="helpId" placeholder="" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Linkedin:</label>
                <input type="text" class="form-control" name="linklinkedin" id="linklinkedin" aria-describedby="helpId" placeholder="" />
            </div>

            <button type="submit" class="btn btn-success"><strong>Agregar chef</strong></button>
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