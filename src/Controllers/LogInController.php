<?php

namespace ProBau\Controllers;

use ProBau\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LogInController
{
    /** @var \Twig_Environment $twig */
    public $twig;

    private $mainService;
    
    public function __construct($twig, $mainService){
        $this->twig = $twig;
        $this->mainService = $mainService;
    }

    public function login(Application $app, Request $request){

        return $this->twig->render('login.twig', [ 'style' => 'login.css']);
    }

    public function checkCredentials(Application $app, Request $request){
        $pictures = $this->mainService->getGalleryPictures();
        $projects = $this->mainService->getProjects();
        return $this->twig->render('admin-pannel.twig', ['style' => 'admin-pannel.css', 
                                                         'pictures' => $pictures,
                                                         'projects' => $projects]);
    }

}