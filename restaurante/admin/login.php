<?php
session_start();
if ($_POST) {
    include("bd.php"); //Esta en el mismo directorio

    $usuario = (isset($_POST["usuario"])) ? $_POST["usuario"] : "";
    $password = (isset($_POST["password"])) ? $_POST["password"] : "";
    //Encriptar la contraseña
    $password = md5($password);

    $sentencia = $conexion->prepare("SELECT *, count(*) as n_usuario
    FROM tbl_usuarios
    WHERE usuario=:usuario
    AND password=:password");

    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->execute();
    $lista_usuarios = $sentencia->fetch(PDO::FETCH_LAZY);
    $n_usuario = $lista_usuarios["n_usuario"];

    if ($n_usuario == 1) {
        $_SESSION["usuario"] = $lista_usuarios["usuario"];
        $_SESSION["logueado"] = true;

        header("Location:index.php");
    } else {
        $mensaje = " Usuario o contraseña incorrectos..";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .input-group-text {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <?php if (isset($mensaje)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Error:</strong><?php echo $mensaje; ?>
                    </div>
                <?php } ?>
                <div class="card ">
                    <div class="card-header text-center "> <strong>Login</strong></div>
                    <div class="card-body">
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="usuario" class="form-label"><strong>Usuario</strong></label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingrese su usuario...">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"> <strong>Contraseña</strong></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese su contraseña...">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><strong>Ingresar</strong></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- codigo  JS para poder ver y ocultar la contraseña -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            // Alternar el atributo de tipo
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Alternar el icono del ojo
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>