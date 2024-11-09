<?php include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    $sentencia = $conexion->prepare("DELETE FROM tbl_pedidos WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    header("Location:index.php");
}

// Consulta
$sentencia = $conexion->prepare("SELECT * FROM `tbl_pedidos`");
$sentencia->execute();
$lista_pedidos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>
<br />
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <a href="crear.php" class="btn btn-primary"><strong>Agregar registros</strong></a>
        <!-- Boton para ver ventas diarias -->
        <form action="ventas.php" method="get" class="form-inline">
            <button type="submit" class="btn btn-success"><strong>Ver ventas diarias</strong></button>
            <div class="form-group ml-2">
                <input type="date" name="fecha" class="form-control" required>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Plato</th>
                        <th scope="col">Tipo cliente</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Observaciones</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Registros PHP -->
                    <?php foreach ($lista_pedidos as $key => $value) { ?>
                        <tr>
                            <td><?php echo $value['ID']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($value['fecha'])); ?></td>
                            <td><?php echo $value['nombre']; ?></td>
                            <td><?php echo $value['cliente']; ?></td>
                            <td><?php echo $value['precio']; ?></td>
                            <td><?php echo $value['observaciones']; ?></td>
                            <td>
                                <a href="editar.php?txtID=<?php echo $value['ID']; ?>" class="btn btn-info"><strong>Editar</strong></a>
                                <a href="index.php?txtID=<?php echo $value['ID']; ?>" class="btn btn-danger"><strong>Borrar</strong></a>
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