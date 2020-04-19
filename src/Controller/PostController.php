<?php

namespace App\Controller;


use AppBundle\Entity\Product;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository;



//bring the prefix for your routes above here so that you dont keep repeating yourself

 /**
 * @Route("/post", name="post.")
 */

class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *  @param PostRepository $postRepository
     *  @return Response
     */

     //the post repository is what gets our values from our entities
    public function index(Repository\PostRepository $postRepository)
    {
        //find all will get us all the values in our repo
        $posts = $postRepository->findAll();


        //return view with the posts
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

     /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request){
        //each row in the database is treated as an object
        $post = new Post();
        $post ->setTitle('First Title');

        //entity manager is what connects and talks to the database
        $em = $this->getDoctrine()->getManager();
        //then use the em to save to the database
        $em->persist($post);
        //call the flush function to actually insert the query
        $em->flush();

        //return a response, you can also return a view if you like
        return new Response('post was created');
    }

    //create the route with th id of what you want to show

    /**
     * @Route("/show{id}", name="show")
     * @return Response
     */
    public function show(Post $post){
        //return the view with the post
        return $this->render('post/show.html.twig',[
            'post'=>$post
        ]);
    }
}
