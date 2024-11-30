<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_testimonios` WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registros = $sentencia->fetch(PDO::FETCH_LAZY);

    $opinion = $registros["opinion"];
    $nombre = $registros["nombre"];
}

if ($_POST) {
    $opinion = (isset($_POST["opinion"])) ? $_POST["opinion"] : "";
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $txtID = (isset($_GET["txtID"])) ? $_POST["txtID"] : "";

    $sentencia = $conexion->prepare("UPDATE tbl_testimonios SET
    opinion=:opinion,
    nombre=:nombre
    WHERE ID=:id");

    $sentencia->bindParam(":opinion", $opinion);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":id", $txtID);

    $sentencia->execute();
    header("Location:index.php");
}

include("../../templates/header.php"); ?>

<br />
<div class="card">
    <div class="card-header">
        <strong>Testimonios</strong>
    </div>
    <div class="card-body">
        <form action="" method="POST">

            <div class="mb-3">
                <label for="" class="form-label">ID:</label>
                <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Opinión:</label>
                <input type="text" class="form-control" value="<?php echo $opinion; ?>" name="opinion" id="opinion" aria-describedby="helpId" placeholder="Opinión" />
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" value="<?php echo $nombre; ?>" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre" />
            </div>

            <button type="submit" class="btn btn-success"><strong>Modificar testimonio</strong></button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Cancelar</strong></a>
        </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>