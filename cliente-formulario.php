<?php

include_once "config.php";
include_once "entidades/cliente.php";

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);

$aMensaje = ["mensaje" => "", "codigo" => ""];

$accion = "Carga";

if($_POST){

  $nombre = trim($_POST["txtNombre"]);
  $cuit = trim($_POST["txtCuit"]);
  $fecha_nac = trim($_POST["txtFechaNac"]);
  $telefono = trim($_POST["txtTelefono"]);
  $correo = trim($_POST["txtCorreo"]);
  
    if(isset($_POST["btnGuardar"])){
      if($nombre == "" || $cuit == "" || $fecha_nac == "" || $telefono == "" || $correo == ""){
        $aMensaje = ["mensaje" => "Complete todos los campos.", "codigo" => "danger"];
      } else if (isset($_GET["id"]) && $_GET["id"] > 0) {
        $cliente->actualizar();
        $aMensaje = ["mensaje" => "Cliente modificado con éxito.", "codigo" => "primary"];
      }else{
        $cliente->insertar();

        $cliente = new Cliente();

        $aMensaje = ["mensaje" => "Cliente cargado con éxito.", "codigo" => "success"];
      }
    }else if(isset($_POST["btnBorrar"])){
      $cliente->eliminar();

      $cliente = new Cliente();

      $aMensaje = ["mensaje" => "Cliente borrado con éxito.", "codigo" => "info"];
    }
}

if(isset($_GET["id"]) && $_GET["id"] > 0 && !isset($_POST["btnBorrar"])){
  $accion = "Edición";
  $cliente->obtenerPorId();
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

  <title>Cliente</title>

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
                <div class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </div>
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
            <h1 class="h3 mb-0 text-gray-800"><?php echo $accion; ?> de Cliente</h1>
          </div>

        <form action="" method="post">
            <div class="row">    
              <div class="col-xs-12 mb-3 mx-2">
                <a href="clientes-listado.php" class="btn btn-primary mx-1">Listado</a>
                <a href="cliente-formulario.php" class="btn btn-primary mx-1">Nuevo</a>
                <input type="submit" class="btn btn-success mx-1" id="btnGuardar" name="btnGuardar" value="Guardar">
                <input type="submit" class="btn btn-danger mx-1" id="btnEliminar" name="btnBorrar" value="Borrar"></input>
              </div>                           
            </div>

            <?php if($aMensaje["mensaje"] != ""): ?>
            
            <div class="row">
              <div class="col-12">
                <div class = "alert alert-<?php echo $aMensaje["codigo"]; ?>" role="alert">
                  <?php echo $aMensaje["mensaje"]; ?>
                </div>
              </div>
            </div>

            <?php endif;?>

            <div class="row">
              <div class="col-6">
              <div class="form-group">
                <label for="txtNombre">Nombre:</label>
                <input class="form-control" type="text" name="txtNombre" id="txtNombre" value="<?php echo $cliente->nombre; ?>">    
              </div>
              </div> 
              <div class="col-6">
              <div class="form-group">
                <label for="txtCuit">CUIT:</label>
                <input class="form-control" type="text" name="txtCuit" id="txtCuit" value="<?php echo $cliente->cuit; ?>">    
              </div>
              </div>   
            </div>

            <div class="row">
              <div class="col-6">
              <div class="form-group">
                <label for="txtFechaNac">Fecha de nacimiento:</label>
                <input class="form-control" type="date" name="txtFechaNac" id="txtFechaNac" value="<?php echo $cliente->fecha_nac; ?>">    
              </div>
              </div> 
              <div class="col-6">
              <div class="form-group">
                <label for="txtTelefono">Teléfono:</label>
                <input class="form-control" type="text" name="txtTelefono" id="txtTelefono" value="<?php echo $cliente->telefono; ?>">    
              </div>
              </div>   
            </div>

            <div class="row">
              <div class="col-6">
              <div class="form-group">
                <label for="txtCorreo">Correo:</label>
                <input class="form-control" type="email" name="txtCorreo" id="txtCorreo" value="<?php echo $cliente->correo ?>">    
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
