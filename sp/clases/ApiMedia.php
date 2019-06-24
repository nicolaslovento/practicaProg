<?php
require_once ('Media.php');
use Firebase\JWT\JWT;

class ApiMedia{

/*Agrega una media a la BD*/
    public static function AgregarMedia($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar ";
        $retorno->Estado=409;
        $retorno->Exito=false;

        $param=$request->getParsedBody();
        
        $objMedia=json_decode($param['media']);
        
        $media=new Media(null,$objMedia->color,$objMedia->marca,$objMedia->precio,$objMedia->talle);

        if($media->Insertar()){

            $retorno->Mensaje="Se cargo";
            $retorno->Estado=200;
            $retorno->Exito=true;
        }
        
        return $response->withJson($retorno,$retorno->Estado);
    }

/*Muestra todas las medias cargadas en la BD*/
    public static function MostrarMedias($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No hay medias para mostrar ";
        $retorno->Estado=409;
        
        $medias=Media::TraerTodos();
        if($medias){//ver si devuelve false si no hay medias
            
            return $response->withJson($medias,200);
        }

        return $response->withJson($retorno,$retorno->Estado);
        
        
    }


    public static function VenderMedia($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo vender ";
        $retorno->Estado=504;
        $retorno->Exito=false;

        $param=$request->getParsedBody();

        $id_Usuario=$param['id_usuario'];
        $id_Media=$param['id_media'];
        $cantidad=$param['cantidad'];
        

        if(Media::InsertarVenta($id_Usuario,$id_Media,$cantidad)){

            $retorno->Mensaje="Se vendio";
            $retorno->Estado=200;
            $retorno->Exito=true;
        }
        
        return $response->withJson($retorno,$retorno->Estado);
    }

    public static function MostrarVentas($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No hay ventas para mostrar ";
        $retorno->Estado=409;
        
        $ventas=Media::TraerVentas();
        if($ventas){//ver si devuelve false si no hay medias
            
            return $response->withJson($ventas,200);
        }

        return $response->withJson($retorno,$retorno->Estado);
        
        
    }



/*Elimina una media por ID de la BD*/
    public static function EliminarMedia($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo borrar";
        

        $param=$request->getParsedBody();
        $id=$param['id_media'];
       
        if(Media::Eliminar($id)){
            $retorno->Mensaje="Se borro la media con id: ".$id.".";
            return $response->withJson($retorno,200);
        }else{
            $retorno->Mensaje="No se encuentra el id ".$id;
        }

        return $response->withJson($retorno,409);
        
        
    }

/*Modifica una media por ID de la bd*/
    public static function ModificarMedia($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo modificar. Verifique el ID ingresado";

        $param=$request->getParsedBody();
        $mediaTraida=json_decode($param['media']);
        
        $media=new Media($mediaTraida->id,$mediaTraida->color,$mediaTraida->marca,$mediaTraida->precio,$mediaTraida->talle);
        var_dump($media);
        //var_dump($media);
        
        if($media->Modificar()){
            $retorno->Mensaje="Se modifico la media con ID ".$media->id;
            return $response->withJson($retorno,200);
        }

        return $response->withJson($retorno,409);

    }

    public static function ModificarVenta($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo modificar. Verifique el ID ingresado";

        $param=$request->getParsedBody();
        $media=json_decode($param['media']);
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('UPDATE ventas_medias SET cantidad=:cantidad WHERE id=:id');
        $sentencia->bindValue(':id',$media->id,PDO::PARAM_INT);
        $sentencia->bindValue(':cantidad',$media->cantidad,PDO::PARAM_INT);
        
        
        $sentencia->execute();
        if($sentencia->rowCount()>0){

            $retorno->Mensaje="Se modifico la venta con ID ".$media->id;
            return $response->withJson($retorno,200);
        }


        return $response->withJson($retorno,409);

    }

    public static function EliminarVenta($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo eliminar la venta. Verifique el ID ingresado";

        $param=$request->getParsedBody();
        $id_media=$param['id_media'];
        $usuario=json_decode($param['usuario']);
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('DELETE FROM ventas_medias WHERE id_usuario=:id_usuario AND id_media=:id_media');
        $sentencia->bindValue(':id_media',$id_media,PDO::PARAM_INT);
        $sentencia->bindValue(':id_usuario',$usuario->id,PDO::PARAM_INT);
        
        
        $sentencia->execute();
        if($sentencia->rowCount()>0){

            $retorno->Mensaje="Se elimino la venta ";
            return $response->withJson($retorno,200);
        }


        return $response->withJson($retorno,409);

    }


    
}


?>