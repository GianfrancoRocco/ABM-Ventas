<?php

class TipoProducto{
 private $idtipoproducto;
 private $nombre;

 public function __construct(){

 }

 public function __get($atributo){
  return $this->$atributo;
 }

 public function __set($atributo, $valor){
  $this->$atributo = $valor;
  return $this;
 }

 public function cargarFormulario($request){
  $this->idtipoproducto = isset($request["id"])? $request["id"] : "";
  $this->nombre = isset($request["txtNombre"])? $request["txtNombre"] : "";
 }

 public function insertar(){
  $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
  $sql = "INSERT INTO tiposproductos (
          nombre
          ) VALUES (
           '" . $this->nombre . "'
          );";

   if(!$mysqli->query($sql)){
    printf("Error en query: %s\n", $mysqli->error . " " . $sql);
   }

   $this->idtipoproducto = $mysqli->insert_id;

   $mysqli->close();
 }

 public function actualizar(){
  $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
  $sql = "UPDATE tiposproductos SET 
          nombre = '". $this->nombre ."'
          WHERE idtipoproducto = ". $this->idtipoproducto;

  if(!$mysqli->query($sql)){
   printf("Error en query: %s\n", $mysqli->error . " " . $sql);
  }

  $mysqli->close();
 }

 public function eliminar(){
  $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
  $sql = "DELETE FROM tiposproductos WHERE idtipoproducto = " . $this->idtipoproducto;

  if(!$mysqli->query($sql)){
   printf("Error en query: %s\n", $mysqli->error . " " . $sql);
  }

  $mysqli->close();
 }

 public function obtenerPorId(){
  $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
  $sql = "SELECT idtipoproducto,
                 nombre
          FROM tiposproductos
          WHERE idtipoproducto = " . $this->idtipoproducto;

  if(!$resultado = $mysqli->query($sql)){
   printf("Error en query: %s\n", $mysqli->error . " " . $sql);
  }

  if($fila = $resultado->fetch_assoc()){
        $this->idtipoproducto = $fila["idtipoproducto"];
        $this->nombre = $fila["nombre"];
  }

  $mysqli->close();

 }

 public function obtenerTodos(){
  $aTipoProducto = null;
  $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
  $resultado = $mysqli->query("SELECT
  A.idtipoproducto,
  A.nombre
  FROM 
  tiposproductos A
  ORDER BY
  idtipoproducto DESC");

  if($resultado){
   while($fila = $resultado->fetch_assoc()){
    $obj = new TipoProducto();
    $obj->idtipoproducto = $fila["idtipoproducto"];
    $obj->nombre = $fila["nombre"];
    $aTipoProducto[] = $obj;
   }

   return $aTipoProducto;
  }
 }

}

?>