<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/ico" href="favicon/favicon.ico">

  <title>Restaurar de contraseña</title>

  <!-- CSS -->
  <?php include_once "bundle-config/bundle-css.php"; ?>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">¿Olvidaste la contraseña?</h1>
                    <p class="mb-4">Lo entendemos, suele pasar. Simplemente ingresa tu correo electrónico debajo y te enviaremos un mail para restaurar tu contraseña.</p>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Correo electrónico...">
                    </div>
                    <a href="login.php" class="btn btn-primary btn-user btn-block">
                      Restaurar contraseña
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="register.php">¡Crea una cuenta!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="login.php">¿Ya tienes una cuenta? ¡Ingresa!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Scripts -->
  <?php include_once "bundle-config/bundle-js.php"; ?>

</body>

</html>
