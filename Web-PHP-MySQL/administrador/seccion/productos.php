<?php include("../template/cabecera.php"); ?>
<?php include("../config/bd.php"); ?>
<?php 
// Recepcionando los datos
$txtID = (isset($_POST["txtID"]))? $_POST["txtID"] : "";
$txtNombre = (isset($_POST["txtNombre"]))? $_POST["txtNombre"] : "";
$txtImagen = (isset($_FILES["txtImagen"]["name"]))? $_FILES["txtImagen"]["name"] : "";
$accion = (isset($_POST["accion"]))? $_POST["accion"] : "";

// ------------------------------
// Evaluando las acciones
switch($accion){
    case "Agregar":
        $sentenciaSQL = $conexion -> prepare("INSERT INTO `libros` (nombre, imagen) VALUES (:nombre, :imagen)");
        $sentenciaSQL -> bindParam(':nombre', $txtNombre);
        
        // Agregar la imagen a la carpeta img
        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "")? $fecha -> getTimestamp()."_".$_FILES["txtImagen"]["name"] : "imagen.png";
        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
        
        if($tmpImagen != ""){
            move_uploaded_file($tmpImagen, "../../img/".$nombreArchivo);
        }
        $sentenciaSQL -> bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL -> execute();
        header("location:productos.php");
        break;
    case "Modificar":
        $sentenciaSQL = $conexion -> prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL -> bindParam(":nombre", $txtNombre);
        $sentenciaSQL -> bindParam(":id", $txtID);
        $sentenciaSQL -> execute();

        if($txtImagen!=""){
            // cambiar la imagen
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "")? $fecha -> getTimestamp()."_".$_FILES["txtImagen"]["name"] : "imagen.png";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../../img/".$nombreArchivo);
            // Borrar la imagen anterior de la carpeta img
            $sentenciaSQL = $conexion -> prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL -> bindParam(":id", $txtID);
            $sentenciaSQL -> execute();
            $libro = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);

            if(isset($libro["imagen"]) && ($libro["imagen"] != "imagen.png")){
                if(file_exists("../../img/".$libro["imagen"])){
                    unlink("../../img/".$libro["imagen"]);
                }
            }
            // Actualizamos
            $sentenciaSQL = $conexion -> prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL -> bindParam(":imagen", $nombreArchivo);
            $sentenciaSQL -> bindParam(":id", $txtID);
            $sentenciaSQL -> execute();
        }
        header("location:productos.php");
        break;
    case "Cancelar":
        header("location:productos.php");
        break;
    case "Seleccionar":
        $sentenciaSQL = $conexion -> prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL -> bindParam(":id", $txtID);
        $sentenciaSQL -> execute();
        $libro = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);
        // Almacenar los valores para mostrar
        $txtNombre = $libro["nombre"];
        $txtImagen = $libro["imagen"];
        break;
    case "Borrar":
        // Borrar la imagen de la carpeta img
        $sentenciaSQL = $conexion -> prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL -> bindParam(":id", $txtID);
        $sentenciaSQL -> execute();
        $libro = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);

        if(isset($libro["imagen"]) && ($libro["imagen"] != "imagen.png")){
            if(file_exists("../../img/".$libro["imagen"])){
                unlink("../../img/".$libro["imagen"]);
            }
        }
        // Borrar solo los registros
        $sentenciaSQL = $conexion -> prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL -> bindParam(":id", $txtID);
        $sentenciaSQL -> execute();
        header("location:productos.php");
        break;
}
$sentenciaSQL = $conexion -> prepare("SELECT * FROM libros");
$sentenciaSQL -> execute();
$listaLibros = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);

?>
<div class="col-12 col-md-5">
    <div class="card">
        <div class="card-header">
            Datos de libro
        </div>
        <div class="card-body">
            <form method="post" action="productos.php" class="formulario_productos" enctype="multipart/form-data">
                <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <!-- readonly: solo lectura -->
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID">
                </div>
                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del libro" required>
                </div>
                <div class = "form-group">
                    <label for="txtImagen">Imagen:</label> <?php //echo $txtImagen; ?>
                    <!-- Mostrar la imagen Inicio --> <br>
                    <?php if($txtImagen!=""){ ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="40" alt="">
                    <?php } ?>
                    <!-- Mostrar la imagen Final -->
                    <input type="file" class="form-control" value="<?php echo $txtID; ?>" name="txtImagen" id="txtImagen">
                </div>
                <div class="btn-group"s role="group" aria-label="Button group name">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar")? "disabled":""; ?> value="Agregar" class="btn btn-primary">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar")? "disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar")? "disabled":""; ?> value="Cancelar" class="btn btn-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-12 col-md-7">
    <div class="table-responsive">
        <table class="table table-primary table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- fila libros Inicio -->
            <?php foreach($listaLibros as $libro){ ?>
                <tr>
                    <td><?php echo $libro["id"]; ?></td>
                    <td><?php echo $libro["nombre"]; ?></td>
                    <td>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $libro["imagen"]; ?>" width="50" alt="">
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro["id"]; ?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
                <!-- fila libros Final -->
            <?php } ?>
            </tbody>
        </table>
    </div>
    
</div>
<?php include("../template/pie.php"); ?>