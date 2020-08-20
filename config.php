<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

class Config{
 const BBDD_HOST = "localhost";
 const BBDD_USUARIO = "root";
 const BBDD_CLAVE = "";
 const BBDD_NOMBRE = "abmventas";
}

?>