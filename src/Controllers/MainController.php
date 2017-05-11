<?php

namespace ProBau\Controllers;

use ProBau\Application;
use ProBau\Services\MainService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController
{
    /** @var \Twig_Environment $twig */
    private $twig;

    public $mainservice;

    public function __construct($twig, $mainService)
    {
        $this->twig = $twig;
        $this->mainService = $mainService;
    }

    public function index(){
        $pictures = $this->mainService->getGalleryPictures();
        return $this->twig->render('index.twig', ['style' => 'style.css', 'pictures' => $pictures]);
    }

    public function services(){
        return $this->twig->render('services.twig', ['style' => 'services.css']);
    }

    public function projects(){
        $projects = $this->mainService->getProjects();
        return $this->twig->render('projects.twig', ['style' => 'projects.css', 'projects' => $projects]);
    }

    public function gallery(){
        $pictures = $this->mainService->getGalleryPictures();
        return $this->twig->render('gallery.twig', ['style' => 'gallery.css', 'pictures' => $pictures]);
    }

    public function impressum(){
        return $this->twig->render('impressum.twig', ['style' => 'impressum.css']);
    }

    public function contact(){
        return $this->twig->render('contact.twig', ['style' => 'contact.css']);
    }

}