<!-- Conexión con la base de datos del restaurante-->
<?php
$servidor = "localhost";
$basedeDatos = "restaurante";
$usuario = "root";
$contrasenia = "";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$basedeDatos", $usuario, $contrasenia);
} catch (Exception $error) {
    echo $error->getMessage();
}
?>