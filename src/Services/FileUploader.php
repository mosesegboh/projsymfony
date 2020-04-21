<?php

namespace App\Services;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader{

        /**
         * @var ContainerInterface
         */

        private $container;

        //container parameter below is basically an object that contains a lot of stuff we need in creating services
            public function __construct(ContainerInterface $container){
            $this->container = $container;
        }
            public function uploadFile(UploadedFile $file){
            //create a unique filename foreach
            $filename = md5(uniqid()) . '.' . $file->guessClientExtension();
            $file->move(
            //get the parameter to move our files we declared in services.yml
                $this->container->getParameter('uploads_dir'),
                //move the file to the correct directory
                $filename
            );
            return $filename;
    }
}