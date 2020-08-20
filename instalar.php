<?php

include_once "config.php";
include_once "entidades/usuario.php";

$usuario = new Usuario();
$usuario->usuario = "gianfrancor";
$usuario->clave = $usuario->encriptarClave("admin123");
$usuario->nombre = "Gianfranco";
$usuario->apellido = "Rocco";
$usuario->correo = "gianfrancorocco.business@gmail.com";
$usuario->insertar();

?>