<?php

include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/producto.php";
include_once "entidades/cliente.php";

$venta = new Venta();
$venta->cargarFormulario($_REQUEST);

$producto = new Producto();
$aProductos = $producto->obtenerTodos();

$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();

$aMensaje = ["mensaje" => "", "codigo" => ""];

$accion = "Carga";

if($_POST){

  $fecha = $_POST["txtFecha"];
  $hora = $_POST["txtHora"];
  $cliente = isset($_POST["lstCliente"]) ? $_POST["lstCliente"] : "";
  $list_producto = isset($_POST["lstProducto"]) ? $_POST["lstProducto"] : "";
  $precio = trim($_POST["txtPrecio"]);
  $cantidad = trim($_POST["txtCantidad"]);
  $total = trim($_POST["txtTotal"]);

  if(isset($_POST["btnGuardar"])){
    if($fecha == "" || $hora == "" || $cliente == "" || $list_producto == "" || $precio == "" || $cantidad == "" || $total == ""){
      $aMensaje = ["mensaje" => "Complete todos los campos.", "codigo" => "danger"];
    } else if (isset($_GET["id"]) && $_GET["id"] > 0){
      $venta->actualizar();
      $aMensaje = ["mensaje" => "Venta modificada con éxito.", "codigo" => "primary"];
    }else{
      $venta->insertar();
      $venta = new Venta();
      $aMensaje = ["mensaje" => "Venta cargada con éxito.", "codigo" => "success"];
    }
  }else if($_POST["btnBorrar"]){
    $venta->eliminar();

    $venta = new Venta();

    $aMensaje = ["mensaje" => "Venta borrada con éxito.", "codigo" => "info"];
  }
}

if(isset($_GET["id"]) && $_GET["id"] > 0 && !isset($_POST["btnBorrar"])){
  $accion = "Edición";
  $venta->obtenerPorId();
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

  <title>Venta</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <link href="css/bootstrap-select.min.css" >

  <script src="js/bootstrap-select.min.js" ></script>

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
            <h1 class="h3 mb-0 text-gray-800"><?php echo $accion; ?> de Venta</h1>
          </div>
        <form action="" method="post">
          <div class="row">    
           <div class="col-xs-12 mb-3 mx-2">
            <a href="ventas.php" class="btn btn-primary mx-1">Listado</a>
            <a href="venta-formulario.php" class="btn btn-primary mx-1">Nuevo</a>
            <input type="submit" class="btn btn-success mx-1" id="btnGuardar" name="btnGuardar" value="Guardar"></input>
            <input type="submit" class="btn btn-danger mx-1" id="btnBorrar" name="btnBorrar" value="Borrar"></input>
           </div>                           
          </div>

          <?php if($aMensaje != ""): ?>
            <div class="row">
              <div class="col-12">
                <div class="alert alert-<?php echo $aMensaje["codigo"]; ?>">
                  <?php echo $aMensaje["mensaje"]; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <div class="row mb-3">
           <div class="col-6">
            <label for="txFecha">Fecha:</label>
            <?php $fecha = date_create($venta->fecha); ?>
            <input type="date" class="form-control" name="txtFecha" id="txtFecha" value="<?php echo date_format($fecha, 'Y-m-d'); ?>">
           </div>
           <div class="col-6">
            <label for="txtHora">Hora:</label>
            <input type="time" class="form-control" name="txtHora" id="txtHora" value="<?php echo date_format($fecha, 'H:i'); ?>">
           </div>
          </div>
          <div class="row mb-3">
           <div class="col-6">
            <label for="txtCantidad">Cliente:</label>
            <select class="form-control selectpicker" name="lstCliente" id="lstCliente" data-live-search="true">
             <option selected disabled>Seleccionar</option>
             <?php foreach($aClientes as $cliente): ?>
              <?php if($cliente->idcliente == $venta->fk_idcliente): ?>
                <option selected value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
              <?php else: ?>
                <option value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
              <?php endif; ?>
             <?php endforeach;?>
            </select>
           </div>
           <div class="col-6">
            <label for="lstPrecio">Producto:</label>
            <select class="form-control selectpicker" name="lstProducto" id="lstProducto" data-live-search="true">
             <option selected disabled>Seleccionar</option>
             <?php foreach($aProductos as $producto): ?>
              <?php if($producto->idproducto == $venta->fk_idproducto): ?>
                <option selected value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
              <?php else:?>
                <option value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
              <?php endif; ?>
             <?php endforeach; ?>
            </select>
           </div>
          </div>
          <div class="row mb-3">
           <div class="col-6">
            <label for="txtPrecio">Precio unitario:</label>
            <input class="form-control" type="number" name="txtPrecio" id="txtPrecio" value="0.0">
           </div>
           <div class="col-6">
            <label for="txtCantidad">Cantidad:</label>
            <input class="form-control" type="number" name="txtCantidad" id="txtCantidad" value="<?php echo $venta->cantidad; ?>">
           </div>
          </div>
          <div class="row">
           <div class="col-6">
            <label for="txtPrecio">Total:</label>
            <input class="form-control" type="number" name="txtTotal" id="txtTotal" value="<?php echo $venta->total; ?>">
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

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

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
