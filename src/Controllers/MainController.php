<?php

namespace ProBau\Controllers;

use ProBau\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController
{
    /** @var \Twig_Environment $twig */
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function index(){
        return $this->twig->render('index.twig', ['style' => 'style.css']);
    }

    public function services(){
        return $this->twig->render('services.twig', ['style' => 'services.css']);
    }

    public function projects(){
        return $this->twig->render('projects.twig', ['style' => 'projects.css']);
    }

    public function gallery(){
        return $this->twig->render('gallery.twig', ['style' => 'gallery.css']);
    }

    public function impressum(){
        return $this->twig->render('impressum.twig', ['style' => 'impressum.css']);
    }

    public function contact(){
        return $this->twig->render('contact.twig', ['style' => 'contact.css']);
    }
    
}