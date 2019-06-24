<?php
require_once ('conexion.php');
use \Firebase\JWT\JWT;

class Empleado{

    public static function AgregarEmpleadoBD($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar el empleado";
        $retorno->Estado=409;
        $retorno->Exito=false;

        $parametros=$request->getParsedBody();
        $objEmpleado=json_decode($parametros['empleado']);

        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();
        //extension
        $extension= explode(".", $foto);
        $extension=array_reverse($extension);
        $nombreFoto=date("d-m-Y").".".$objEmpleado->legajo.".".$extension[0];
        $destino="./fotos/usuariosAgregados/";


        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('INSERT INTO Empleados (nombre,apellido,email,foto,legajo,clave,perfil) VALUES (:nombre,:apellido,:email,:foto,:legajo,:clave,:perfil)');
        
        $sentencia->bindValue(':nombre',$objEmpleado->nombre,PDO::PARAM_STR);
        $sentencia->bindValue(':apellido',$objEmpleado->apellido,PDO::PARAM_STR);
        $sentencia->bindValue(':email',$objEmpleado->email,PDO::PARAM_STR);
        $sentencia->bindValue(':foto',$nombreFoto,PDO::PARAM_STR);
        $sentencia->bindValue(':legajo',$objEmpleado->legajo,PDO::PARAM_INT);
        $sentencia->bindValue(':clave',$objEmpleado->clave,PDO::PARAM_STR);
        $sentencia->bindValue(':perfil',$objEmpleado->perfil,PDO::PARAM_STR);
        
        $sentencia->execute();
        if($sentencia->rowCount()>0){
            try
            {
                $archivos["foto"]->moveTo($destino.$nombreFoto);
                $retorno->Mensaje="Se cargo el empleado";
                $retorno->Estado=200;
                $retorno->Exito=true;
            }
            catch(Exception $e)
            {
                $retorno->Mensaje=$e->getMessage();
               $newResponse= $response->withJson($retorno,$retorno->Estado); 
            }
            
        }

        return $response->withJson($retorno,$retorno->Estado);
    }

    public static function VerificarEmpleadoBD($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Valido=false;
        $retorno->Usuario="No se encontro";
       
        //tomo parametros por get
        $email=$args['email'];
        $clave=$args['clave'];
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM Empleados WHERE email=:email AND clave=:clave');
        $sentencia->bindValue(':email',$email,PDO::PARAM_STR);
        $sentencia->bindValue(':clave',$clave,PDO::PARAM_STR);

        $sentencia->execute();
        echo $sentencia->rowCount();
        if($sentencia->rowCount()>0){
            $retorno->Valido=true;
            $retorno->Usuario=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }

        return $response->withJson($retorno);
    }

    public static function TraerTodosBD($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Valido=false;
        $retorno->Usuario="No se encontraron usuarios";
       
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM Empleados');
        $sentencia->execute();

        
        if($sentencia->rowCount()>0){
            $retorno->Valido=true;
            $retorno->Usuario=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }

        return $response->withJson($retorno);
    }


    public static function LoginEmpleado($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Exito=false;
        $retorno->Usuario="El usuario no esta registrado.. no se pudo crear el token";
       
        $parametros=$request->getParsedBody();
        $email=$parametros['email'];
        $clave=$parametros['clave'];
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM Empleados WHERE email=:email AND clave=:clave');
        $sentencia->bindValue(':email',$email,PDO::PARAM_STR);
        $sentencia->bindValue(':clave',$clave,PDO::PARAM_STR);

        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            $retorno->Exito=true;
            $retorno->Usuario=$sentencia->fetchAll(PDO::FETCH_ASSOC);

            
            $payload=$retorno->Usuario;

            $token=JWT::encode($payload,"miClave");
            
            $retorno->Jwt=$token;
        }

        return $response->withJson($retorno);
    }










}



?>