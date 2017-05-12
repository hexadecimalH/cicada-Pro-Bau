<?php

namespace ProBau\Services;

use PHPMailer;
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

    public function sendMail($clientName, $clientMail, $content){
        $this->mail = new PHPMailer();
        $this->mail->SMTPDebug = 5;
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Host = 'smtp.gmail.com';

        $this->mail->Username = 'zenovicharis@gmail.com';
        $this->mail->Password = 'Bostonseltiks';
        $this->mail->Port = 587;

        $this->mail->setFrom($clientMail, $clientName);
        $this->mail->addReplyTo($clientMail, $clientName);
        $this->mail->CharSet = 'UTF-8';

        $this->mail->isHTML();                                  // Set email format to HTML
        $mailContent = '<p style="text-align:center">'.htmlentities($content).'</p><br/><p> This mail has been sent from pro-bau.de contact form</p>';
        $this->mail->Subject = 'Mail from Form';
        $this->mail->Body    = $mailContent;
        $this->mail->AltBody = htmlentities($content);
        $this->mail->addAddress('zenovicharis@gmail.com', "Haris Zenovic");     // Add a recipient
        $isSent = $this->mail->Send();
         if(!$isSent) {
            return false;
         }
         return true;
    }
}