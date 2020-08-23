<?php

include_once "config.php";
include_once "entidades/tipoproducto.php";

$tipoproducto = new TipoProducto();
$tipoproducto->cargarFormulario($_REQUEST);

$aMensaje = ["mensaje" => "", "codigo" => ""];

$accion = "Carga";

if($_POST){

  $nombre = trim($_POST["txtNombre"]);

  if(isset($_POST["btnGuardar"])){
    if($nombre == ""){
      $aMensaje = ["mensaje" => "Complete el campo.", "codigo" => "danger"];
    } else if(isset($_GET["id"]) && $_GET["id"] > 0){
      $tipoproducto->actualizar();
      $aMensaje = ["mensaje" => "Tipo de producto modificado con éxito.", "codigo" => "primary"];
    }else{
      $tipoproducto->insertar();
      $tipoproducto = new TipoProducto();
      $aMensaje = ["mensaje" => "Tipo de producto cargado con éxito.", "codigo" => "success"];
    }
  }else if(isset($_POST["btnBorrar"])){
    $tipoproducto->eliminar();

    $tipoproducto = new TipoProducto();

    $aMensaje = ["mensaje" => "Tipo de producto borrado con éxito.", "codigo" => "danger"];
  }
}

if(isset($_GET["id"]) && $_GET["id"] > 0 && !isset($_POST["btnBorrar"])){
  $accion = "Edición";
  $tipoproducto->obtenerPorId();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Tipo de producto</title>

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
            <h1 class="h3 mb-0 text-gray-800"><?php echo $accion; ?> de Tipo de producto</h1>
          </div>

          <!-- Content Row -->
          <form action="" method="post">
            <div class="row">    
           <div class="col-xs-12 mb-3 mx-2">
            <a href="tipo-productos.php" class="btn btn-primary mx-1">Listado</a>
            <a href="tipo-producto-formulario.php" class="btn btn-primary mx-1">Nuevo</a>
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

          <div class="row">
            <div class="col-12">
             <div class="form-group">
              <label for="txtNombre">Nombre:</label>
              <input class="form-control" type="text" name="txtNombre" id="txtNombre" value="<?php echo $tipoproducto->nombre;  ?>">    
             </div>
            </div>  
           </div>
          </form>
                   
        </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Footer -->
  <?php include_once("footer.php") ?>
  <!-- End of Footer -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php include_once("modal-logout.php") ?>

  <!-- Scripts -->
  <?php include_once "bundle-config/bundle-js.php"; ?>

</body>

</html>
