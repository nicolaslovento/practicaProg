<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './clases/ApiMedia.php';
require_once './clases/ApiUsuario.php';
require_once './clases/Middelware.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$app = new \Slim\App(["settings" => $config]);


$app->post('[/]',ApiMedia::class . '::AgregarMedia');

$app->get('/medias[/]',ApiMedia::class . '::MostrarMedias');

$app->post('/usuarios[/]',ApiUsuario::class . '::AgregarUsuario');

$app->get('/',ApiUsuario::class . '::MostrarUsuarios');

$app->group('/ventas[/]',function(){
    $this->post('',ApiMedia::class . '::VenderMedia');
    $this->get('',ApiMedia::class . '::MostrarVentas');
    $this->put('',ApiMedia::class . '::ModificarVenta')->add(\MW::class . '::VerificarEmpleado');
    $this->delete('',ApiMedia::class . '::EliminarVenta')->add(\MW::class . '::VerificarEmpleado');
});


$app->delete('[/]',ApiMedia::class . '::EliminarMedia')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarEncargado');
$app->put('[/]',ApiMedia::class . '::ModificarMedia')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarEncargado');

$app->get('/{listadoFotos}[/]',ApiUsuario::class . '::MostrarUsuarios');



$app->run();


?>