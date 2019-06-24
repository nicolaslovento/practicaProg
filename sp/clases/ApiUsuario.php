<?php
use Firebase\JWT\JWT;

require_once ('Usuario.php');
//require_once ('AutenticadorJWT.php');

class ApiUsuario{

/*Agrega un usuario a la bd */
    public static function AgregarUsuario($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar el usuario";
        $retorno->Estado=409;
        
        $parametros=$request->getParsedBody();
        $objUsuario=json_decode($parametros['usuario']);
        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();
        //extension
        
        

        $usuario=new Usuario(null,$objUsuario->correo,$objUsuario->clave,$objUsuario->nombre,$objUsuario->apellido,$objUsuario->perfil,$foto);
        
        if($usuario->Insertar()){

            $archivos["foto"]->moveTo("./fotos/".$foto);
            $retorno->Mensaje="Se cargo el usuario";
            $retorno->Estado=200;
        }

        return $response->withJson($retorno,$retorno->Estado);

    }


/*Muestra todos los usuarios*/
    public static function MostrarUsuarios($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No hay usuarios para mostrar ";
        

        $usuarios=Usuario::TraerTodos();
        if($usuarios){
            
            if(isset($args['listadoFotos'])){

                $tabla="<table border='1'><tr><td>ID</td><td>FOTO</td></tr>";
                foreach($usuarios as $usuario){

                    $tabla.="<tr><td>".$usuario['id']."</td><td><img src='fotos/".$usuario['foto']."' width=100 height=100></img></td></tr>";
                    
                }

                $tabla.="</table>";
                return $tabla;
            }else{
                return $response->withJson($usuarios,200);
            }
            
        }

        return $response->withJson($retorno,409);
    }








    
}

?>