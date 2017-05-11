<?php

namespace ProBau\Controllers;

use ProBau\Application;
use ProBau\Services\AdminService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController
{
    public $adminService;

    public function __construct($adminService){
        $this->adminService = $adminService;
    }

    public function uploadPicture(Application $app, Request $request, $foldername){
        $pictures = $request->files->all();
        $urls = $this->adminService->uploadPictures($pictures,$foldername);
        return new JsonResponse($urls);
    }

    public function storeGalleryToDb(Application $app, Request $request){
        $data = $request->request->all();
        $pictures = $this->adminService->storeGalleryPictures($data);
        
        return new JsonResponse($pictures);
    }
    
    public function storeProjectToDb(Application $app, Request $request){
        $title = $request->request->get('title');
        $about = $request->request->get('about');
        $url = $request->request->get('url-0');
        $proj = $this->adminService->storeProject($title, $about, $url);
        
        return new JsonResponse($proj);
    }

    public function deletePicture(Application $app, Request $request){
        $url = $request->request->get('url');
        $this->adminService->removeFromStorage($url);
    }

    public function deleteStoredPicture(Application $app, Request $request, $pictureId){
        $this->adminService->deletePicture($pictureId);
    }

    public function deleteProject(Application $app, Request $request, $projectId){
        $this->adminService->deleteProject($projectId);
    }

    public function editProject(Application $app, Request $request, $projectId){
        $name = $request->request->get("name");
        $about = $request->request->get("about");
        $this->adminService->editProject($projectId, $name, $about);
    }
    
}