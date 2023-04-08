<?php
session_start();
if($_POST){
    if(($_POST["usuario"] == "admin") && ($_POST["contrasenia"] = "admin")){
        $_SESSION["usuario"] = "ok";
        $_SESSION["nombreUsuario"] = $_POST["usuario"];
        header("location:inicio.php");
    }else{
        $mensaje = "Error: El usuario o contraseña son incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador del sitio Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="row centrar">
            <!-- <div class="col-md-4"></div> -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <!-- mensaje de error Inicio -->
                        <?php if(isset($mensaje)){ ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $mensaje; ?></strong>
                        </div>
                        <?php }?>
                        <!-- mensaje de error Final -->
                        <form class="formulario_administrador" action="index.php" method="post">
                            <div class="form-group">
                                <label for="InputUser">Usuario:</label>
                                <input type="text" class="form-control" name="usuario" id="InputUser" placeholder="Nombre de usuario" required>
                            </div>
                            <div class="form-group">
                                <label for="InputPassword">Contraseña:</label>
                                <input type="password" class="form-control" id="InputPassword" name="contrasenia" placeholder="Contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar como administrador</button>
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        Ingresar al administrador
                    </div>
                </div>
            </div>            
        </div>
    </div>
</body>
</html>