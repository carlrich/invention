<?php include("template/cabecera.php"); ?>
<div class="col-md-12">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bienvenido al administrador: <?php echo $nombreUsuario; ?></h1>
        <p class="col-md-8 fs-4">Bamos a administrar nuestros libros en el sitio Web</p>
        <a href="seccion/productos.php"><button class="btn btn-primary btn-lg" type="button">Administrar libros</button></a>
        </div>
    </div>
</div>
<?php include("template/pie.php"); ?>