<!-- Conexion base de datos banners-->
<?php
include("admin/bd.php");
//Base de datos banners
$sentencia = $conexion->prepare("SELECT * FROM tbl_banners ORDER BY id DESC limit 1 ");
$sentencia->execute();
$lista_banners = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//Base de datos colaboradores(chefs)
$sentencia = $conexion->prepare("SELECT * FROM tbl_colaboradores ORDER BY id DESC ");
$sentencia->execute();
$lista_colaboradores = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//Base de datos menú
$sentencia = $conexion->prepare("SELECT * FROM tbl_menu ORDER BY id DESC limit 4 ");
$sentencia->execute();
$lista_menu = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//Base de datos testimonios
$sentencia = $conexion->prepare("SELECT * FROM tbl_testimonios ORDER BY id DESC limit 2 ");
$sentencia->execute();
$lista_testimonios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//Insertar las sugerencias a la base de datos
if ($_POST) {

    // Sanitizar y validar entradas
    $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_SPECIAL_CHARS);
    $correo = filter_var($_POST["correo"], FILTER_VALIDATE_EMAIL);
    $mensaje = filter_var($_POST["mensaje"], FILTER_SANITIZE_SPECIAL_CHARS);
    $mensaje = htmlspecialchars($_POST["mensaje"], ENT_QUOTES, 'UTF-8');

    if ($nombre && $correo && $mensaje) {
        $sql = "INSERT INTO tbl_comentarios (nombre, correo, mensaje)
                VALUES (:nombre, :correo, :mensaje)";
        $resultado = $conexion->prepare($sql);
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $resultado->bindParam(':correo', $correo, PDO::PARAM_STR);
        $resultado->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($resultado->execute()) {
            echo "<script>alert(' Sugerencia enviada con éxito.');</script>";
            echo "<script>window.location.href = '/Restaurante/index.php';</script>";
        } else {
            echo "<script>alert(' Error al enviar la sugerencia');</script>";
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos correctamente.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<head>
    <title>Restaurante Yuli</title>
    <link rel="shortcut icon" href="images/Logo_Restaurante_Yuli_.jpg" type="image/x-icon">
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Coodigo css-->
    <link rel="stylesheet" href="style.css">
</head>


<body>

    <!-- pagina de inicio (Estatico)-->
    <nav id="inicio" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand" href="#"><i class="fas fa-utensils"></i> Restaurante Yuli</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="platos.html">Menú</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#chefs">Chefs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#testimonios">Testimonios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sugerencias">Sugerencias</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#horario">Horario</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner del restaurante (Dinamico)-->
    <section class="container-fluid p-0">
        <div class="banner-img" style="position:relative; background:url('images/slider-image1.jpeg') center/cover no-repeat; height:400px;">
            <div class="banner-text" style="position:absolute; top:50%; left:50%; transform: translate(-50%, -50%); text-align:center; color:#fff;">
                <?php
                foreach ($lista_banners as $banner) { ?>
                    <h1><?php echo $banner['titulo']; ?></h1>
                    <p><?php echo $banner['descripcion']; ?></p>
                    <a href="<?php echo $banner['link']; ?>" class="btn btn-primary"><strong>Menú Top</strong></a>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Mensaje de bienvenida (Estatico)-->
    <section id="id" class="container mt-4 text-center">
        <div class="jumbotron bg-dark text-white">
            <br />
            <h2>¡Bienvenid@ al Restaurante Yuli!</h2>
            <p> Descubre una experiencia culinaria única </p>
            <br />
        </div>
    </section>

    <!-- Sección de chefs (Dinamico)-->
    <section id="chefs" class="container mt-4 text-center">
        <h2>Nuestros Chefs</h2>
        <div class="row">
            <?php foreach ($lista_colaboradores as $colaborador) { ?>
                <!--chef  -->
                <div class="col-md-4">

                    <div class="card mb-4">
                        <img src="images/colaboradores/<?php echo $colaborador["foto"]; ?>" class="card-img-top" alt="Chef 1" />

                        <div class="card-body">
                            <h5 class="card-title"><?php echo $colaborador["nombre"]; ?></h5>
                            <p class="card-text"><?php echo $colaborador["descripcion"]; ?></p>
                            <div class="social-icons mt-3">
                                <a href="<?php echo $colaborador["linkfacebook"]; ?>" class="text-dark me-2"><i class="fab fa-facebook"></i></a>
                                <a href="<?php echo $colaborador["linkinstagram"]; ?>" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                                <a href="<?php echo $colaborador["linklinkedin"]; ?>" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!--Sección de menú recomendado (Dinamico)-->
    <section id="menu" class="container mt-4">
        <h2 class="text-center">Menú recomendado </h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">

            <?php foreach ($lista_menu as $registro) { ?>
                <div class="col d-flex mb-4">
                    <div class="card ">
                        <img src="images/menu/<?php echo $registro["foto"]; ?>" alt="Plato 1" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $registro["nombre"]; ?></h5>
                            <p class="card-text small"><strong>Ingredientes: </strong><?php echo $registro["ingredientes"]; ?> </p>
                            <p class="card-text"><strong>Precio: </strong><?php echo $registro["precio"]; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </section>

    <!--Sección de testimonios (Dinamico)-->
    <section id="testimonios" class="bg-light py-5">

        <div class="container">
            <h2 class=" mb-4">Testimonios </h2>
            <div class="row">
                <?php foreach ($lista_testimonios as $testimonio) { ?>
                    <div class="col-md-6 mb-4 d-flex">
                        <div class="card md-4 w-100">
                            <div class="card-body">
                                <p class="card-text"><?php echo $testimonio["opinion"]; ?></p>
                            </div>
                            <div class="card-footer text-muted">
                                <?php echo $testimonio["nombre"]; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Sección de Sugerencias (Dinamico)-->
    <section id="sugerencias" class="container mt-4">
        <h2>Sugerencias</h2>
        <p>¡Juntos hagamos que todo sea aún más increíble!</p>
        <form action="?" method="post">
            <div class="mb-3">
                <label for="name">Nombre:</label><br />
                <input type="text" class="form-control" name="nombre" placeholder="Escribe tu nombre..." required><br />
            </div>
            <div class="mb-3">
                <label for="email">Correo electrónico:</label><br />
                <input type="email" class="form-control" name="correo" placeholder="Escribe tu correo electrónico..." required>
                <br />
            </div>
            <div class="mb-3">
                <label for="message">Mensaje:</label><br />
                <textarea id="message" class="form-control" name="mensaje" rows="6" cols="50"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><strong>Enviar mensaje</strong></button>
        </form>
    </section>

    <!-- Ícono flotante con número de teléfono -->
    <div id="phone-icon" style="background-color: #1976d2;">
        <i class="fas fa-phone-alt call-symbol"></i>
        <span id="phone-number">3152861376</span>
    </div>


    <!-- Script para guardar el contacto -->
    <script src="contacto.js">
    </script>

    <br />

    <!-- Sección de horarios (Estatico)-->
    <div id="horario" class=" text-center bg-light p-4">
        <h3 class="mb-4">Horario de atención </h3>
        <div>
            <p> <strong>Lunes a Viernes</strong></p>
            <p> <strong>8:00 am - 6:00 pm</strong></p>
        </div>

        <div>
            <p><strong>Sábados y Domingos</strong></p>
            <p><strong>9:00 am - 04:00 pm</strong></p>
        </div>
    </div>


    <footer class="bg-dark text-light text-center py-3">
        <!-- place footer here -->
        <p> &copy; 2024 Restaurante Yuli, todos los derechos reservados.</p>
    </footer>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>



</body>

</html>