<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<?php include("templates/header.php"); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="h-100 p-5 bg-light border rounded-3 shadow-sm" style="background-color: #f0f0f0;">
                <h2 class="mb-4 text-center text-primary">
                    <i class="bi bi-person-circle"></i> Bienvenid@ al administrador <?php echo $_SESSION["usuario"]; ?>
                </h2>
                </h2>
                <p class="lead text-center text-secondary">
                    Este espacio es para administrar su sitio web
                </p>
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-primary btn-lg" type="button" onclick="window.location.href ='index.php'">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar ahora</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("templates/footer.php"); ?>