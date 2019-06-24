<?php

require_once ('conexion.php');

class Producto{

    public static function AgregarProductoBD($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar el producto";
        $retorno->Estado=409;
        $retorno->Exito=false;

        $parametros=$request->getParsedBody();
        $objProducto=json_decode($parametros['producto']);

        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('INSERT INTO Productos (nombre,precio) VALUES (:nombre,:precio)');
        
        $sentencia->bindValue(':nombre',$objProducto->nombre,PDO::PARAM_STR);
        $sentencia->bindValue(':precio',$objProducto->precio,PDO::PARAM_INT);
        
        
        $sentencia->execute();
        if($sentencia->rowCount()>0){

            $retorno->Mensaje="Se cargo el producto";
            $retorno->Estado=200;
            $retorno->Exito=true;

        }

        return $response->withJson($retorno,$retorno->Estado);
    }

    public static function TraerTodosBD($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Valido=false;
        $retorno->Productos="No se encontraron productos";
       
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM Productos');
        $sentencia->execute();

        
        if($sentencia->rowCount()>0){
            $retorno->Valido=true;
            $retorno->Productos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }

        return $response->withJson($retorno);
    }

    public static function EliminarProductoBD($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Exito=false;
        $retorno->Mensaje="No se borro el producto";

        $parametros=$request->getParsedBody();
        $id=$parametros['id'];
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('DELETE FROM Productos WHERE id=:id');
        $sentencia->bindValue(':id',$id,PDO::PARAM_INT);
        $sentencia->execute();

        
        if($sentencia->rowCount()>0){
            $retorno->Exito=true;
            $retorno->Mensaje="Se elimino el producto";
        }

        return $response->withJson($retorno);
    }

    public static function ModificarProductoBD($request,$response){

        $retorno=new stdClass();
        $retorno->Exito=false;
        $retorno->Mensaje="No se modifico el producto";

        $parametros=$request->getParsedBody();
        $id=$parametros['id'];
        $nombre=$parametros['nombre'];
        $precio=$parametros['precio'];

        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('UPDATE Productos SET nombre=:nombre,precio=:precio WHERE id=:id');
        $sentencia->bindValue(':id',$id,PDO::PARAM_INT);
        $sentencia->bindValue(':nombre',$nombre,PDO::PARAM_STR);
        $sentencia->bindValue(':precio',$precio,PDO::PARAM_INT);
        $sentencia->execute();

        
        if($sentencia->rowCount()>0){
            $retorno->Exito=true;
            $retorno->Mensaje="Se modifico el producto";
        }

        return $response->withJson($retorno);
    }

    

}

?>