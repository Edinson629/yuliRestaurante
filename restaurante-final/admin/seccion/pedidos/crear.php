<?php
include("../../bd.php");

if ($_POST) {
    $fecha = (isset($_POST["fecha"])) ? $_POST["fecha"] : "";
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $tipo_cliente = (isset($_POST["tipo_cliente"])) ? $_POST["tipo_cliente"] : ""; // Cambiado de "cliente" a "tipo_cliente"
    $precio = (isset($_POST["precio"])) ? $_POST["precio"] : "";
    $observaciones = (isset($_POST["observaciones"])) ? $_POST["observaciones"] : "";

    // Prepara la sentencia SQL
    $sentencia = $conexion->prepare("INSERT INTO `tbl_pedidos`
     (`ID`,  `fecha`,`nombre`, `cliente`, `precio` , `observaciones`) 
     VALUES (NULL, :fecha, :nombre, :cliente, :precio, :observaciones);");

    // Vincula los parámetros a la sentencia preparada 
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":cliente", $tipo_cliente); // Cambiado de "cliente" a "tipo_cliente"
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":observaciones", $observaciones);

    // Ejecuta la sentencia
    $sentencia->execute();

    header("Location:index.php");
}
include("../../templates/header.php");
?>

<br />
<div class="card">
    <div class="card-header"><strong>Pedidos</strong></div>
    <div class="card-body">

        <form action="" method="post">
            <!--Fecha-->
            <div class="mb-3">
                <label for="" class="form-label">Fecha:</label>
                <input type="date" class="form-control" name="fecha" id="fecha" aria-describedby="helpId" placeholder="" />
                <small id="fechaHelp" class="form-text text-muted">Seleccione la fecha del pedido.</small>
            </div>

            <!--Platos-->
            <div class="mb-3">
                <label for="nombre" class="form-label">Plato:</label>
                <select class="form-select" name="nombre" id="nombre" aria-describedby="helpId">
                    <option value="" disabled selected>Seleccione plato</option>
                    <option value="Pechuga a la plancha con papas francesas">Pechuga a la plancha con papas francesas</option>
                    <option value="Carne a la plancha con papa criolla">Carne a la plancha con papa criolla</option>
                    <option value="Chuleta de cerdo ahumada con champiñones">Chuleta de cerdo ahumada con champiñones</option>
                    <option value="Lomo de cerdo con salsa vino tinto">Lomo de cerdo con salsa vino tinto</option>
                    <option value="Carne Guisada">Carne Guisada</option>
                    <option value="Pollo Guisado">Pollo Guisado</option>
                    <option value="Pollo Frito">Pollo Frito</option>
                    <option value="Sobrebarriga Guisada">Sobrebarriga Guisada</option>
                    <option value="Bandeja Paisa">Bandeja Paisa</option>
                    <option value="Arroz Mixto">Arroz Mixto</option>
                    <option value="Arroz con Pollo">Arroz con Pollo</option>
                    <option value="Lengua Guisada">Lengua Guisada</option>
                </select>
            </div>

            <!--Tipo cliente-->
            <div class="mb-3">
                <label for="tipo_cliente" class="form-label">Tipo cliente:</label>
                <select class="form-select" name="tipo_cliente" id="tipo_cliente" aria-describedby="helpId">
                    <option value="" disabled selected>Seleccione el tipo de cliente</option>
                    <option value="Conductor" data-precio="$ 10,000 pesos">Conductor</option>
                    <option value="Pasajero" data-precio="$ 15,000 pesos">Pasajero</option>
                    <option value="Particular" data-precio="$ 12,000 pesos">Particular</option>
                </select>
            </div>

            <!--Precio-->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" class="form-control" name="precio" id="precio" aria-describedby="helpId" placeholder="Precio" readonly />
            </div>
            <!-- Script que se utiliza para actualizar dinámicamente el valor del precio según el tipo del cliente-->
            <script>
                document.getElementById('tipo_cliente').addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var precio = selectedOption.getAttribute('data-precio');
                    document.getElementById('precio').value = precio;
                });
            </script>

            <div class="mb-3">
                <label for="" class="form-label">Observaciones:</label>
                <input type="text" class="form-control" name="observaciones" id="observaciones" aria-describedby="helpId" placeholder="Escriba las observaciones" />
            </div>

            <button type="submit" class="btn btn-success"><strong>Agregar pedido</strong></button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Cancelar</strong></a>

        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>