<?php

include_once "config.php";
include_once "entidades/producto.php";
include_once "entidades/tipoproducto.php";

$producto = new Producto();
$producto->cargarFormulario($_REQUEST);

$tipoproducto = new TipoProducto();

$aTiposProductos = $tipoproducto->obtenerTodos();

$aMensaje = ["mensaje" => "", "codigo" => ""];

$accion = "Carga";

if($_POST){

  $nombre = trim($_POST["txtNombre"]);
  $tipo_producto = isset($_POST["lstTipoProducto"]) ? $_POST["lstTipoProducto"] : "";
  $cantidad = trim($_POST["txtCantidad"]);
  $precio = trim($_POST["txtPrecio"]);
  $nombreImagen = "";

  if(isset($_POST["btnGuardar"])){

    if($_FILES["imagen"]["error"] === UPLOAD_ERR_OK){
      $nombreAleatorio = date("Ymdhmsi");
      $archivoTmp = $_FILES["imagen"]["tmp_name"];
      $nombreArchivo = $_FILES["imagen"]["name"];
      $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
      $nombreImagen = "$nombreAleatorio.$extension";
      move_uploaded_file($archivoTmp, "files/$nombreImagen");
    }

    if($nombre == "" || $tipo_producto == "" || $cantidad == "" || $precio == ""){

      $aMensaje = ["mensaje" => "Complete todos los campos.", "codigo" => "danger"];

    } else if (isset($_GET["id"]) && $_GET["id"] > 0){

        $productoAnterior = new Producto();
        $productoAnterior->idproducto = $_GET["id"];
        $productoAnterior->obtenerPorId();
        $imagenAnterior = $productoAnterior->imagen;

        if($_FILES["imagen"]["error"] === UPLOAD_ERR_OK){
          if($imagenAnterior != ""){
            unlink("files/$imagenAnterior"); //Borra imagen si sube una nueva 
          }
        } else { //Conseva la imagen si no se sube una nueva
          $nombreImagen = $imagenAnterior;
        }
  
        $producto->imagen = $nombreImagen;
        $producto->actualizar();
        $aMensaje = ["mensaje" => "Producto modificado con éxito.", "codigo" => "primary"];

      }else{

        $producto->imagen = $nombreImagen;
        $producto->insertar();
        $producto = new Producto();
        $aMensaje = ["mensaje" => "Producto cargado con éxito.", "codigo" => "success"];

      }

  } else if(isset($_POST["btnBorrar"])){

    $producto->idproducto = $_GET["id"]; //Define id del producto con el id de la url

    $producto->obtenerPorId(); //Obtiene el producto del id obtenido

    if($producto->imagen != ""){
      unlink("files/" . $producto->imagen); //Borra la imagen del producto siendo eliminado
    }

    $producto->eliminar();

    $producto = new Producto();

    $aMensaje = ["mensaje" => "Producto borrado con éxito.", "codigo" => "info"];

  }
}

if(isset($_GET["id"]) && $_GET["id"] > 0 && !isset($_POST["btnBorrar"])){
  $accion = "Edición";
  $producto->obtenerPorId();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/ico" href="favicon/favicon.ico">

  <title>Producto</title>

  <!-- CSS -->
  <?php include_once "bundle-config/bundle-css.php"; ?>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include_once("navbar.php") ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <?php include_once("nav-item-alerts.php") ?>

            <!-- Nav Item - Messages -->
            <?php include_once("nav-item-messages.php") ?>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Gianfranco Rocco</span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Perfil
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ajustes
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Actividad
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar sesión
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
      <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?php echo $accion; ?> de Producto</h1>
          </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="row">    
           <div class="col-xs-12 mb-3 mx-2">
            <a href="productos-listado.php" class="btn btn-primary mx-1">Listado</a>
            <a href="producto-formulario.php" class="btn btn-primary mx-1">Nuevo</a>
            <input type="submit" class="btn btn-success mx-1" id="btnGuardar" name="btnGuardar" value="Guardar"></input>
            <input type="submit" class="btn btn-danger mx-1" id="btnBorrar" name="btnBorrar" value="Borrar"></input>
           </div>                           
          </div>

          <?php if($aMensaje["mensaje"] != ""): ?>

            <div class="row">
              <div class="col-12">
                <div class="alert alert-<?php echo $aMensaje["codigo"]; ?>" role="alert">
                  <?php echo $aMensaje["mensaje"]; ?>
                </div>
              </div>
            </div>

          <?php endif; ?>
          <div class="row mb-3">
           <div class="col-6">
            <label for="txtNombre">Nombre:</label>
            <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $producto->nombre; ?>">
           </div>
           <div class="col-6">
            <label for="lstTipoProducto">Tipo de producto:</label>
            <select class="form-control selectpicker" name="lstTipoProducto" id="lstTipoProducto" data-live-search="true">
             <option selected disabled>Seleccionar</option>
             <?php foreach($aTiposProductos as $tipoproducto): ?>
              <?php if($tipoproducto->idtipoproducto == $producto->fk_idtipoproducto): ?>
                <option selected value="<?php echo $tipoproducto->idtipoproducto; ?>"><?php echo $tipoproducto->nombre; ?></option>
              <?php else: ?>
              <option value="<?php echo $tipoproducto->idtipoproducto; ?>"><?php echo $tipoproducto->nombre; ?></option>
              <?php endif;?>
             <?php endforeach; ?>
            </select>
           </div>
          </div>
          <div class="row mb-3">
           <div class="col-6">
            <label for="txtCantidad">Cantidad:</label>
            <input type="number" class="form-control" name="txtCantidad" id="txtCantidad" value="<?php echo $producto->cantidad; ?>">
           </div>
           <div class="col-6">
            <label for="txtPrecio">Precio:</label>
            <input type="number" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $producto->precio; ?>">
           </div>
          </div>
          <div class="row">
           <div class="col-12">
            <label for="txtDescripcion">Descripción:</label>
            <textarea class="form-control" name="txtDescripcion" id="txtDescripcion"><?php echo $producto->descripcion; ?></textarea>
           </div>
          </div>
          <div class="row">
            <div class="col-12 mt-3">
              <label for="imagen">Imágen:</label><br>
              <?php if($producto->imagen != ""): ?>
                <img class="mb-3" src="files/<?php echo $producto->imagen; ?>" alt="" width="100px;"><br>
              <?php endif; ?>
              <input type="file" name="imagen" id="imagen">
            </div>
          </div>
         
        </form>
          
      </div>
      
    </div>
    <!-- End of Content Wrapper -->
      <!-- Footer -->
      <?php include_once("footer.php") ?>
      <!-- End of Footer -->
  </div>
  <!-- End of Page Wrapper -->


  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php include_once("modal-logout.php") ?>

  <!-- Scripts -->
  <?php include_once "bundle-config/bundle-js.php"; ?>

  <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

  <script>
   ClassicEditor
     .create(document.querySelector("#txtDescripcion"))
     .catch(error => {
      console.error(error);
     });
  </script>

</body>

</html>
