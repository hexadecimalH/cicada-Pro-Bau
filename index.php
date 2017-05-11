<?php

require "vendor/autoload.php";

use ProBau\Application;
use ProBau\Controllers\MainController;
use ProBau\Controllers\LogInController;
use ProBau\Controllers\AdminController;
use Symfony\Component\HttpFoundation\Request;

function getProtocol()
{
    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $isSecure = true;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        $isSecure = true;
    }
    return $isSecure ? 'https' : 'http';
}
$app = new Application($_SERVER['HOME'], $_SERVER['HTTP_HOST'], getProtocol().'://');

$logInController = new LogInController($app['twig'], $app['mainService']);
$mainController = new MainController($app['twig'], $app['mainService']);
$adminController = new AdminController($app['adminService']);

$app->get('/',                  [ $mainController, 'index']);
$app->get('/projecten',         [ $mainController, 'projects']);
$app->get('/leistungen',        [ $mainController, 'services']);
$app->get('/galerie',           [ $mainController, 'gallery']);
$app->get('/kontakt',           [ $mainController, 'contact']);
$app->get('/impressum',         [ $mainController, 'impressum']);


//Login Controller Routes
$app->get('/login',             [ $logInController, 'login']);
$app->post('/login',            [ $logInController, 'checkCredentials']);


//Admin Controller Routes
$app->post('/upload-pictures/{foldername}',             [ $adminController, 'uploadPicture']);
$app->post('/store/gallery-picture',                    [ $adminController, 'storeGalleryToDb']);
$app->post('/store/projects',                           [ $adminController, 'storeProjectToDb']);
$app->post('/delete/stored-picture',                    [ $adminController, 'deletePicture']);
$app->post('/delete/picture/{pictureId}',               [ $adminController, 'deleteStoredPicture']);
$app->post('/delete/project/{projectId}',               [ $adminController, 'deleteProject']);
$app->post('/edit/project/{projectId}',                 [ $adminController, 'editProject']);
// $app->get('/log-out', [ $mainController, 'logOut']);
$app->exception(function(Exception $e, Request $request) {
    print_r($e->getMessage());
    throw $e;
});


$app->run();