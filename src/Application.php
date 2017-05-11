<?php

namespace ProBau;

// use ShopwooDashboard\Services\LogInService;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;
use ProBau\Services\MainService;
use ProBau\Services\AdminService;
use ProBau\Services\ImageStorageService;
use ProBau\Libraries\ImageManipulationLibrary;

class Application extends \Cicada\Application
{
    public $domain;
    public $protocol;
    public $basePath;

    public function __construct($configPath, $domain, $protocol)
    {

        parent::__construct();
        $this->domain = $domain;
        $this->protocol = $protocol;
        $this->basePath = $configPath;
        // session_start();
        $this->setupEnvironment($domain);
        $this->configure($configPath.'/config/pro-bau/');
        $this->setupLibraries();
        $this->setupServices();
        $this->setupTwig();
        $this->configureDatabase();
        // $this->setupSessionContainer();

//        $this->registerRaven();
    }

    private function setupSessionContainer(){
        $this['user_id'] = null;
    }
    
    protected function setupLibraries(){
        $this['imageManipualtionLibrary'] = function () {
            return new ImageManipulationLibrary();
        };
    }

    private function setupServices() {
        $this['imageStorageService'] = function () {
            return new ImageStorageService($this->domain, $this->protocol, $this->basePath, $this['imageManipualtionLibrary']);
        };
        $this['mainService'] = function () {
            return new MainService();
        };
        $this['adminService'] = function () {
            return new AdminService($this['imageStorageService']);
        };
        // $this['logInService'] = function () {
        //     return new LogInService();
        // };
    }

    protected function configure($configPath) {
        $this['config'] = function () use ($configPath) {
            return new Configuration($configPath);
        };
    }

    private function setupEnvironment($domain) {
        $this['domain'] = $domain;
    }

    protected function configureDatabase()
    {
        $dbConfig = $this['config']->getDbConfig();
        \ActiveRecord\Config::initialize(function (\ActiveRecord\Config $cfg) use ($dbConfig) {
            $cfg->set_model_directory('src/Models');
            $cfg->set_connections([
                'main' => sprintf('mysql://%s:%s@%s/%s',
                    $dbConfig['user'], $dbConfig['password'], $dbConfig['host'], $dbConfig['name']
                )
            ]);
            $cfg->set_default_connection('main');
        });
    }
    private function setupTwig() {
        $this['twig'] = function() {
            $loader = new \Twig_Loader_Filesystem('front-end/');
            $twig = new  \Twig_Environment($loader, array(
//                'cache' => 'cache',
            ));

            $pathFunction = function ($name, $params = []) {
                /** @var Route $route */
                $route = $this['router']->getRoute($name);
                return $route->getRealPath($params);
            };
            $twig->addFunction(new Twig_SimpleFunction('path', $pathFunction));

            return $twig;
        };
    }

    private function registerRaven() {
        $client = new Raven_Client('https://817637e1ebf740c3b33a22c32fdfda0f:1e154f585ce94634b04a1ac6099b6635@sentry.io/152299');
        $this['raven'] = function() use ($client) {
            return $client;
        };
        $error_handler = new Raven_ErrorHandler($client);
        $error_handler->registerExceptionHandler();
        $error_handler->registerErrorHandler();
        $error_handler->registerShutdownFunction();
        $this['raven']->install();
    }
}