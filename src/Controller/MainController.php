<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //this below is called annotations, as you can see below,it defines the route you can allso use the routes.yaml file
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        //in symfony all actions should return a response. and take account of the namespacing
        return $this->render('home/index.html.twig');
    }

     /**
     * @Route("/custom/{name?}", name="custom")
     * @param Request $request
     * @return Response
     */
    public function custom(Request $request)
    {
        $name = $request->get('name');
        $fname = 'moses';
        //in symfony all actions should return a response. and take account of the namespacing
        //send all the data variable as a second variable in your twig request which is an array with the info you need
        return $this->render('home/custom.html.twig', 
        ['name' => $name , 'fname'=>$fname ]
    );
    } 
}
