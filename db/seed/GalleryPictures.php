<?php

use Phinx\Seed\AbstractSeed;

class GalleryPictures extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = array(
            array(
                'url'    => '/uploads/gallerypictures/photo1.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo2.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo3.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo4.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo5.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo6.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo7.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo8.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo9.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo10.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo11.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo12.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo13.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo14.jpg',
            ),
            array(
                'url'    => '/uploads/gallerypictures/photo15.jpg',
            )
        );

        $users = $this->table('gallery_pictures');
        $users->insert($data)
              ->save();
    }
}
