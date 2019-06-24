<?php
use Slim\Http\Message;
require_once ('Usuario.php');
require_once ('Media.php');

class MW{

/*Si el usuario(perfil) es encargado pasa al siguiente callable*/ 

    public static function VerificarPropietario($request,$response,$next){
            
        $retorno=new stdClass();
        $retorno->mensaje="No es propietario";
        $parametros=$request->getParsedBody();
        $usuario=json_decode($parametros['usuario']);
        //var_dump($usuario);
        
        
        if($usuario->perfil=='propietario'){

            $response=$next($request,$response);
            return $response;
        }else{
            if($usuario->perfil=='encargado'){
                $response=$next($request,$response);
                return $response;
            }else{
                $retorno->mensaje="No es propietario ni encargado";
                return $response->withJson($retorno,504);
            }
        }

        
        
        return $response;
        

    }

    
    
    /*Si el usuario(perfil) es encargado pasa al siguiente callable*/ 

    public  function VerificarEncargado($request,$response,$next){
            
        $retorno=new stdClass();
        $retorno->mensaje="No es encargado";
        $parametros=$request->getParsedBody();
        $usuario=json_decode($parametros['usuario']);

        
        if($usuario->perfil=='encargado'){

            $response=$next($request,$response);
            return $response;
        }

        if($request->IsPut()){
            $response=$next($request,$response);
            return $response;
        }

        
        return $response->withJson($retorno->mensaje,409);

    }

    public  function VerificarEmpleado($request,$response,$next){
            
        $retorno=new stdClass();
        $retorno->mensaje="No es empleado";
        $parametros=$request->getParsedBody();
        $usuario=json_decode($parametros['usuario']);

        
        if($usuario->perfil=='empleado'){

            $response=$next($request,$response);
            return $response;
        }

        return $response->withJson($retorno->mensaje,409);

    }
   
   
    


}

       





?>