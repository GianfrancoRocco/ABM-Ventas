<?php

class Venta {
    private $idventa;
    private $fecha;
    private $cantidad;
    private $preciounitario;
    private $total;
    private $fk_idproducto;
    private $fk_idcliente;

    public function __construct(){

    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }

    public function cargarFormulario($request){
        $this->idventa = isset($request["id"])? $request["id"] : "";
        $this->fecha = isset($request["txtFecha"])? $request["txtFecha"] . " " . $request["txtHora"] : "";
        $this->cantidad = isset($request["txtCantidad"])? $request["txtCantidad"]: "0";
        $this->preciounitario = isset($request["txtPrecioUnitario"])? $request["txtPrecioUnitario"]: "0.0";
        $this->total = isset($request["txtTotal"])? $request["txtTotal"] : "0.0";
        $this->fk_idproducto = isset($request["lstProducto"])? $request["lstProducto"] :"";
        $this->fk_idcliente = isset($request["lstCliente"])? $request["lstCliente"] : "";
    }

    public function insertar(){
        
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        
        $sql = "INSERT INTO ventas (
                    fecha, 
                    cantidad, 
                    preciounitario, 
                    total, 
                    fk_idproducto,
                    fk_idcliente
                ) VALUES (
                    '" . $this->fecha ."', 
                    " . $this->cantidad .", 
                    " . $this->preciounitario .", 
                    " . $this->total .", 
                    " . $this->fk_idproducto .",
                    " . $this->fk_idcliente . "
                );";
       
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        
        $this->idventa = $mysqli->insert_id;
        
        $mysqli->close();
    }

    public function actualizar(){

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE ventas SET
                fecha = '".$this->fecha."',
                cantidad = ".$this->cantidad.",
                preciounitario = ".$this->preciounitario.",
                total = ".$this->total.",
                fk_idproducto = ".$this->fk_idproducto.",
                fk_idcliente = ".$this->fk_idcliente."
                WHERE idventa = " . $this->idventa;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
       
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idventa, 
                        fecha, 
                        cantidad, 
                        preciounitario, 
                        total, 
                        fk_idproducto,
                        fk_idcliente 
                FROM ventas 
                WHERE idventa = " . $this->idventa;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
    
        if($fila = $resultado->fetch_assoc()){
            $this->idventa = $fila["idventa"];
            $this->fecha = $fila["fecha"];
            $this->cantidad = $fila["cantidad"];
            $this->preciounitario = $fila["preciounitario"];
            $this->total = $fila["total"];
            $this->fk_idproducto = $fila["fk_idproducto"];
            $this->fk_idcliente = $fila["fk_idcliente"];
        }  
        $mysqli->close();

    }

    public function obtenerTodos(){
            $aVenta = [];
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $resultado = $mysqli->query("SELECT
            A.idventa,
            A.fecha,
            A.cantidad,
            A.preciounitario,
            A.total,
            A.fk_idproducto,
            B.nombre AS nombre_producto,
            A.fk_idcliente,
            C.nombre AS nombre_cliente
            FROM
            ventas A
            INNER JOIN productos B
            ON A.fk_idproducto = B.idproducto
            INNER JOIN clientes C
            ON A.fk_idcliente = C.idcliente
            ORDER BY
            idventa DESC");

            if($resultado){
                while ($fila = $resultado->fetch_assoc()) {
                    $obj = new Venta();
                    $obj->idventa = $fila["idventa"];
                    $obj->fecha = $fila["fecha"];
                    $obj->cantidad = $fila["cantidad"];
                    $obj->preciounitario = $fila["preciounitario"];
                    $obj->total = $fila["total"];
                    $obj->fk_idproducto = $fila["fk_idproducto"];
                    $obj->nombre_producto = $fila["nombre_producto"];
                    $obj->fk_idcliente = $fila["fk_idcliente"];
                    $obj->nombre_cliente = $fila["nombre_cliente"];
                    $aVenta[] = $obj;
                }
                return $aVenta;
            }
        }

        public function obtenerFacturacionMensual($mes){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "SELECT SUM(total) AS total_mensual FROM ventas WHERE MONTH(fecha) = $mes;";

            if (!$resultado = $mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }

            if($fila = $resultado->fetch_assoc()){
                $total_mensual = $fila["total_mensual"];
            }
            
            return $total_mensual;
            
            $mysqli->close();
        }

        public function obtenerFacturacionAnual($anio){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "SELECT SUM(total) AS total_anual FROM ventas WHERE YEAR(fecha) = $anio;";

            if (!$resultado = $mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }

            if($fila = $resultado->fetch_assoc()){
                $total_anual = $fila["total_anual"];
            }
            
            return $total_anual;
            
            $mysqli->close();
        }

}


?>