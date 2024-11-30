<?php
include("../../bd.php");

$fecha = (isset($_GET['fecha'])) ? $_GET['fecha'] : "";

// Verificar si se ha recibido la fecha
if ($fecha) {
    // Consulta para obtener las ventas diarias
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_pedidos` WHERE DATE(fecha) = :fecha");
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->execute();
    $ventas_diarias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // Inicializar el total de dinero de las ventas del día
    $total_dinero = 0;

    // Calcular el total de dinero de las ventas del día
    foreach ($ventas_diarias as $venta) {
        // Limpiar el valor de precio
        $precio_limpio = preg_replace('/[^0-9.]/', '', $venta['precio']);

        // Convertir precio a float
        $precio = floatval($precio_limpio);

        // Sumar al total
        $total_dinero += $precio;
    }
} else {
    $ventas_diarias = [];
    $total_dinero = 0;
}

include("../../templates/header.php");
?>

<br />
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Volver</strong></a>
    </div>
    <div class="card-body">
        <?php if ($fecha) { ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mr-auto">Ventas del día: <?php echo date('d/m/Y', strtotime($fecha)); ?></h6>
                <h6>Total de dinero: $ <?php echo number_format($total_dinero, 0, ',', ','); ?> pesos</h6>
            </div>
        <?php } else { ?>
            <h5>Por favor, seleccione una fecha válida.</h5>
        <?php } ?>
        <div class="table-responsive-sm">
            <table class="table table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Plato</th>
                        <th scope="col">Tipo cliente</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas_diarias as $venta) { ?>
                        <tr class="">
                            <td scope="row"><?php echo htmlspecialchars($venta['ID']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($venta['fecha'])); ?></td>
                            <td><?php echo htmlspecialchars($venta['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($venta['cliente']); ?></td>
                            <td>$ <?php echo number_format(floatval(preg_replace('/[^0-9.]/', '', $venta['precio'])), 0, ',', ','); ?> pesos</td>
                            <td><?php echo htmlspecialchars($venta['observaciones']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>