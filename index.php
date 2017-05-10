<?php

require "vendor/autoload.php";

use ProBau\Application;
use ProBau\Controllers\MainController;
use Symfony\Component\HttpFoundation\Request;

// function getProtocol()
// {
//     $isSecure = false;
//     if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
//         $isSecure = true;
//     } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
//         $isSecure = true;
//     }
//     return $isSecure ? 'https' : 'http';
// }
// $app = new Application($_SERVER['HOME'], 'main', getProtocol().'://'.$_SERVER['HTTP_HOST'])
$app = new Application();


// $logInController = new LogInController($app['twig'], $app['logInService']);
$mainController = new MainController($app['twig']);

$app->get('/', [ $mainController, 'index']);

$app->get('/projecten',         [ $mainController, 'projects']);
$app->get('/leistungen',        [ $mainController, 'services']);
$app->get('/galerie',           [ $mainController, 'gallery']);
$app->get('/kontakt',           [ $mainController, 'contact']);
$app->get('/impressum',         [ $mainController, 'impressum']);
// $app->post('/log-in', [ $logInController, 'login']);

// $app->get('/log-out', [ $mainController, 'logOut']);
$app->exception(function(Exception $e, Request $request) {
    print_r($e->getMessage());
    throw $e;
});


$app->run();