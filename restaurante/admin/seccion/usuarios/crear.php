<?php
include("../../bd.php");
if($_POST){
    $usuario=(isset($_POST["usuario"]))?$_POST["usuario"]:"";
    $password=(isset($_POST["password"]))?$_POST["password"]:"";
    //Encriptar la contraseña
    $password=md5($password);
    $correo=(isset($_POST["correo"]))?$_POST["correo"]:"";

    $sentencia = $conexion->prepare("INSERT INTO 
    `tbl_usuarios` (ID,usuario,password,correo)
     VALUES (NULL,:usuario,:password,:correo);");

    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);

    $sentencia->execute();
   header("Location:index.php");
}
include("../../templates/header.php");
?>
<br />
<div class="card">
    <div class="card-header">Usuarios</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="" class="form-label">Nombre de usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Correo:</label>
                <input type="email" class="form-control" name="correo" id="correo" aria-describedby="emailHelpId" placeholder="Correo" />
            </div>

            <button type="submit" class="btn btn-success"><strong>Agregar usuario</strong></button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Cancelar</strong></a>
        </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php
include("../../templates/footer.php");
?>