<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

function autoloader($class_name) {
    $directories = ['', '/controllers', '/views', '/src/engine', '/src'];
    foreach ($directories as $dir) {
        $file = __DIR__ . $dir . '/' . $class_name . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
}
spl_autoload_register('autoloader');

$app = AppFactory::create();
$app->addRoutingMiddleware();

$app->get('/', 'Controller_Get:getLogin');
$app->post('/', 'Controller_Post:postLogin');
$app->get('/Signin', 'Controller_Get:getSignin');
$app->post('/Signin', 'Controller_Post:postSignin');
$app->get('/Playlist', 'Controller_Get:getPlaylist');
$app->post('/Playlist', 'Controller_Post:postPlaylist');

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

session_start();

$app->run();
