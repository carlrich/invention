<?php include("template/cabecera.php"); ?>
<?php
include("administrador/config/bd.php");
$sentenciaSQL = $conexion -> prepare("SELECT * FROM libros");
$sentenciaSQL -> execute();
$listaLibros = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Bucle de mostrar libros Inicio -->
<?php foreach($listaLibros as $libro){ ?>
<div class="col-md-3">
    <div class="card">
        <img class="card-img-top imagen_libro" src="./img/<?php echo $libro["imagen"]; ?>" alt="libro javascript">
        <div class="card-body">
            <h4 class="card-title"><?php echo $libro["nombre"]; ?></h4>
            <a name="" id="" class="btn btn-primary" href="https://goalkicker.com/" role="button">Ver más</a>
        </div>
    </div>
</div>
<?php } ?>
<!-- Bucle de mostrar libros Final -->
<?php include("template/pie.php");?>