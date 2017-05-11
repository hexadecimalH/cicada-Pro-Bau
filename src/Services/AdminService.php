<?php

namespace ProBau\Services;

use ProBau\Models\User;
use ProBau\Models\Project;
use ProBau\Models\GalleryPicture;

class AdminService
{
    private $imageStorageService;

    public function __construct($imageStorageService){

        $this->imageStorageService = $imageStorageService;
    }

    public function uploadPictures($pictures, $foldername){
        $urls = $this->imageStorageService->storePictures($pictures, $foldername);

        return $urls;
    }

    public function storeGalleryPictures($pictures){
        $pics = [];
        foreach($pictures as $picture){
            $pic = GalleryPicture::create([
                'url' => $picture
            ]);
            $pics[] = $pic->to_array();
        }
        return $pics;
    }

    public function storeProject($title, $about, $url){
        $proj = Project::create([
            'name' => $title,
            'about' => $about,
            'url'   => $url
        ]);

        return $proj->to_array();
    }

    public function removeFromStorage($url){
        $this->imageStorageService->removeContent($url);
    }

    public function deletePicture($id){
        $picture = GalleryPicture::find($id);
        $picture->delete();
    }

    public function deleteProject($id){
        $project = Project::find($id);
        $this->imageStorageService->removeContent($project->url);
        $project->delete();
    }

    public function editProject($id, $name, $about){
        $project = Project::find($id);
        $project->name = $name;
        $project->about = $about;
        $project->save();
    }

}