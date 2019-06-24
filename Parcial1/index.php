<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './clases/empleados.php';
require_once './clases/productos.php';
require_once './clases/mdw.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

//empleado

$app->post('[/]',\Empleado::class . '::AgregarEmpleadoBD');//Agrega empleado más foto
$app->get('/{email}/{clave}[/]',\Empleado::class . '::VerificarEmpleadoBD');//Verifica email y clave con parametros
$app->get('[/]',\Empleado::class . '::TraerTodosBD');//trae todos los emp de la bd

//producto
$app->group('/productos',function(){

    $this->post('[/]',\Producto::class . '::AgregarProductoBD')->add(\MiddleWare::class . '::RegistroDeEntradas');//Agrega producto a la bd
    $this->get('[/]',\Producto::class . '::TraerTodosBD');//trae todos los productos de la bd
    $this->put('[/]',\Producto::class . '::ModificarProductoBD');//modifica un producto de la bd
    $this->delete('[/]',\Producto::class . '::EliminarProductoBD');//elimina un producto de la bd
})->add(\MiddleWare::class . '::ContadorVisitas')->add(\MiddleWare::class . '::Verificar');
//login
$app->post('/Login[/]',\Empleado::class . '::LoginEmpleado');//Agrega empleado más foto


$app->run();

?>
