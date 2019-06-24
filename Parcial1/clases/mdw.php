<?php
use \Firebase\JWT\JWT;

class MiddleWare{

    public static function Verificar($request,$response,$next){
        
        if($request->IsGet()){
            $token=$_GET['token'];
            try{
                $objToken=JWT::decode($token,"miClave",['HS256']);
                
                $response=$next($request,$response);
                return $response;
                
            }catch(Exception $e){
                throw new Exception("Token no valido!!");
            }

        }

        $parametros=$request->getParsedBody();
        $token=$parametros['token'];

        try{

            $objToken=JWT::decode($token,"miClave",['HS256']);
            //var_dump($objToken);
            if($objToken[0]->perfil=="admin"){

                $response=$next($request,$response);
                return $response;
            }else{
                $response->getBody()->write("No tiene permiso para realizar esta accion.");
            }  
            
                
        }catch(Exception $e){
            throw new Exception("Token no valido!!");
        }

        return $response;
    
    }



    public static function ContadorVisitas($request,$response,$next){
        
        $file=fopen("./contador.txt","r");
        $num=fread($file,filesize('./contador.txt'));
        $num=trim($num);
        fclose($file);
        if($num==""){
            $num=1;
        }else{
            $num=(integer)$num;
            $num=$num+1;
        }
        echo $num;
        $file=fopen('./contador.txt',"w");
        fwrite($file,$num);
        fclose($file);

        $response=$next($request,$response);
        return $response;
        
    }

    public static function RegistroDeEntradas($request,$response,$next){

        $parametros=$request->getParsedBody();
        $token=$parametros['token'];

        try{

            $objToken=JWT::decode($token,"miClave",['HS256']);
            //var_dump($objToken);
            $nombre=$objToken[0]->nombre;
            $apellido=$objToken[0]->apellido;
            $fecha=date("j-n-y");
            
            $hora=date("H-i-s");

            $file=fopen('./registro.txt',"a");
            fwrite($file,$fecha."-".$hora."-".$nombre."-".$apellido."\r\n");
            fclose($file);

            $response=$next($request,$response);
            
                
        }catch(Exception $e){
            throw new Exception("Token no valido!!");
        }

        return $response;

        
        
    }


}
?>

    


