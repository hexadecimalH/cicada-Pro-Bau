<?php

namespace ProBau\Services;

use ProBau\Models\User;
use ProBau\Models\Project;
use ProBau\Models\GalleryPicture;

class ImageStorageService{

    private $domain;
    private $protocol;
    private $basePath;
    /** @var  ImageManipulationLibrary $imageManipulationLibrary */
    private $imageManipulationLibrary;

    public function __construct($domain, $protocol, $basePath, $imageManipulationLibrary){
        $this->domain = $domain;
        $this->protocol = $protocol;
        $this->basePath = $basePath.'Pro-Bau';
        $this->imageManipulationLibrary = $imageManipulationLibrary;
    }

    public function storePictures($pictures,$folderName){
        $urls = [];
        foreach($pictures as $picture){
            // Compose image name
            // until I come up with algorithm that generates unique names
            $pictureName = str_replace("_", " ", $picture->getClientOriginalName());

            // Resize
            // $image = $this->imageManipulationLibrary->resizePostImage(file_get_contents($image->getRealPath()));

            // Store to disk
            $path = $this->storeImageContents('/uploads'.'/'.$folderName.'/'.$pictureName, file_get_contents($picture->getRealPath()));
            $urls[] = $path;
            // Add resized image to result set
        }

        return $urls;
    }
    private function storeImageContents($path, $content){
        file_put_contents($this->basePath.$path, $content);
        return $path;
    }

    public function removeContent($url){
        $deleted = unlink($this->basePath.$url);
    }
}