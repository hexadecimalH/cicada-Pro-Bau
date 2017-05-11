<?php

namespace ProBau\Services;

use ProBau\Models\User;
use ProBau\Models\Project;
use ProBau\Models\GalleryPicture;

class MainService
{

    public function __construct(){

    }

    public function getGalleryPictures(){
        $galleryPictures = GalleryPicture::all();

        return $galleryPictures;
    }

    public function getProjects(){
        $projects = Project::all();

        return $projects;
    }
}