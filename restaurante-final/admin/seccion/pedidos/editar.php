<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_pedidos` WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registros = $sentencia->fetch(PDO::FETCH_LAZY);

    $fecha =  $registros["fecha"];
    $nombre =  $registros["nombre"];
    $cliente = $registros["cliente"];
    $precio =  $registros["precio"];
    $observaciones = $registros["observaciones"];
}


if ($_POST) {
    $fecha = (isset($_POST["fecha"])) ? $_POST["fecha"] : "";
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $cliente = (isset($_POST["cliente"])) ? $_POST["cliente"] : "";
    $precio = (isset($_POST["precio"])) ? $_POST["precio"] : "";
    $observaciones = (isset($_POST["observaciones"])) ? $_POST["observaciones"] : "";

    // Prepara la sentencia SQL
    $sentencia = $conexion->prepare("UPDATE `tbl_pedidos`
   SET fecha=:fecha, nombre=:nombre, cliente=:cliente, precio=:precio, observaciones=:observaciones 
   WHERE ID=:id");

    // Vincula los parámetros a la sentencia preparada 
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":cliente", $cliente);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":observaciones", $observaciones);
    $sentencia->bindParam(":id", $txtID);

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

            <div class="mb-3">
                <label for="" class="form-label">ID:</label>
                <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="" />
            </div>

            <!--fecha-->
            <div class="mb-3">
                <label for="" class="form-label">Fecha:</label>
                <input type="date" class="form-control" value="<?php echo $fecha; ?>" name="fecha" id="fecha" aria-describedby="helpId" placeholder="" />
                <small id="fechaHelp" class="form-text text-muted">Modifique la fecha del pedido.</small>
            </div>

            <!--platos-->
            <div class="mb-3">
                <label for="nombre" class="form-label">Plato:</label>
                <select class="form-select" name="nombre" id="nombre" aria-describedby="helpId" value="<?php echo $nombre; ?>">
                    <option value="Pechuga a la plancha con papas francesas" <?php if ($nombre == "Pechuga a la plancha con papas francesas") echo "selected"; ?>>Pechuga a la plancha con papas francesas</option>
                    <option value="Carne a la plancha con papa criolla" <?php if ($nombre == "Carne a la plancha con papa criolla") echo "selected"; ?>>Carne a la plancha con papa criolla</option>
                    <option value="Chuleta de cerdo ahumada con champiñones" <?php if ($nombre == "Chuleta de cerdo ahumada con champiñones") echo "selected"; ?>>Chuleta de cerdo ahumada con champiñones</option>
                    <option value="Lomo de cerdo con salsa vino tinto" <?php if ($nombre == "Lomo de cerdo con salsa vino tinto") echo "selected"; ?>>Lomo de cerdo con salsa vino tinto</option>
                    <option value="Carne Guisada" <?php if ($nombre == "Carne Guisada") echo "selected"; ?>>Carne Guisada</option>
                    <option value="Pollo Guisado" <?php if ($nombre == "Pollo Guisado") echo "selected"; ?>>Pollo Guisado</option>
                    <option value="Pollo Frito" <?php if ($nombre == "Pollo Frito") echo "selected"; ?>>Pollo Frito</option>
                    <option value="Sobrebarriga Guisada" <?php if ($nombre == "Sobrebarriga Guisada") echo "selected"; ?>>Sobrebarriga Guisada</option>
                    <option value="Bandeja Paisa" <?php if ($nombre == "Bandeja Paisa") echo "selected"; ?>>Bandeja Paisa</option>
                    <option value="Arroz Mixto" <?php if ($nombre == "Arroz Mixto") echo "selected"; ?>>Arroz Mixto</option>
                    <option value="Arroz con Pollo" <?php if ($nombre == "Arroz con Pollo") echo "Arroz con Pollo"; ?>>Arroz con Pollo</option>
                    <option value="Lengua Guisada" <?php if ($nombre == "Lengua Guisada") echo "selected"; ?>>Lengua Guisada</option>
                </select>
                <small id="helpId" class="form-text text-muted">Seleccione el plato.</small>
                <input type="text" class="form-control" value="<?php echo $nombre; ?>" name="nombre_texto" id="nombre_texto" placeholder="Escriba aquí" <?php if (!empty($nombre)) echo "style='display:none;'"; ?> />
            </div>

            <!--Tipo cliente-->
            <div class="mb-3">
                <label for="cliente" class="form-label">Tipo cliente:</label>
                <select class="form-select" name="cliente" id="cliente" aria-describedby="helpId">
                    <option value="" disabled <?php if (empty($cliente)) echo "selected"; ?>>Seleccione el tipo de cliente</option>
                    <option value="Conductor" <?php if ($cliente == "Conductor") echo "selected"; ?>>Conductor</option>
                    <option value="Pasajero" <?php if ($cliente == "Pasajero") echo "selected"; ?>>Pasajero</option>
                    <option value="Particular" <?php if ($cliente == "Particular") echo "selected"; ?>>Particular</option>
                </select>
                <small id="helpId" class="form-text text-muted">Seleccione el tipo del cliente.</small>
                <input type="text" class="form-control" value="<?php echo $cliente; ?>" name="cliente_texto" id="cliente_texto" placeholder="Escriba aquí" <?php if (!empty($cliente)) echo "style='display:none;'"; ?> />
            </div>

            <!--Precio (readonly) el usuario no puede editar el precio por teclado.-->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" class="form-control" value="<?php echo $precio; ?>" name="precio" id="precio" aria-describedby="helpId" placeholder="" readonly />
            </div>

            <!--Script para actualizar el campo de precio según la opción seleccionada en el campo "Tipo cliente".-->
            <script>
                document.getElementById('cliente').addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var precioInput = document.getElementById('precio');
                    if (selectedOption.value === "Conductor") {
                        precioInput.value = "$ 10,000 pesos";
                    } else if (selectedOption.value === "Pasajero") {
                        precioInput.value = "$ 15,000 pesos";
                    } else if (selectedOption.value === "Particular") {
                        precioInput.value = "$ 12,000 pesos";
                    }

                });
            </script>

            <!--Observaciones-->
            <div class="mb-3">
                <label for="" class="form-label">Observaciones:</label>
                <input type="text" class="form-control" value="<?php echo $observaciones; ?>" name="observaciones" id="observaciones" aria-describedby="helpId" placeholder=" " />
            </div>


            <button type="submit" class="btn btn-success"><strong>Modificar pedido</strong></button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><strong>Cancelar</strong></a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>
<?php include("../../templates/footer.php"); ?>