<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_banners` WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registros = $sentencia->fetch(PDO::FETCH_LAZY);

    $titulo = $registros["titulo"];
    $descripcion = $registros["descripcion"];
    $link = $registros["link"];
}


if ($_POST) {
    $titulo = (isset($_POST["titulo"])) ? $_POST["titulo"] : "";
    $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
    $link = (isset($_POST["link"])) ? $_POST["link"] : "";
    $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "";

    // Prepara la sentencia SQL
    $sentencia = $conexion->prepare("UPDATE `tbl_banners`
   SET titulo=:titulo, descripcion=:descripcion, link=:link
   WHERE ID=:id");


    // Vincula los parámetros a la sentencia preparada
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":link", $link);
    $sentencia->bindParam(":id", $txtID);

    $sentencia->execute();
    header("Location:index.php");
}
include("../../templates/header.php"); ?>


<br />
<div class="card">
    <div class="card-header"><strong>Banners</strong></div>
    <div class="card-body">

        <form action="" method="post">

            <div class="mb-3">
                <label for="" class="form-label">ID:</label>
                <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Título:</label>
                <input type="text" class="form-control" value="<?php echo $titulo; ?>" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Escriba el titulo del banner" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Descripción:</label>
                <input type="text" class="form-control" value="<?php echo $descripcion; ?>" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Escriba la descripción del banner" />

            </div>

            <div class="mb-3">
                <label for="" class="form-label">Link:</label>
                <input type="text" class="form-control" value="<?php echo $link; ?>" name="link" id="link" aria-describedby="helpId" placeholder="Escriba el enlace" />
            </div>


            <button type="submit" class="btn btn-success"><strong>Modificar banner</strong></button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Cancelar</strong></a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>
<?php include("../../templates/footer.php"); ?>