<?php

namespace App\Controller;


use App\Form\PostType;
use App\Services\FileUploader;
use AppBundle\Entity\Product;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function create(Request $request,FileUploader $fileUploader){
        //each row in the database is treated as an object
        $post = new Post();

        //lets  use the form from our form helper
        $form = $this->createForm(PostType::class, $post);

        //to save data form to the database
        $form->handleRequest($request);
        //error display
        $form->getErrors();
        //the second parameter in the if statement is for form validity
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            //get the file...the commented code below gives you access to some functions used below
            /** @var UploadedFile $file */
            $file=$request->files->get('post')['attachment'];
            if ($file){
                //we created a service and used it here
                $filename=$fileUploader->uploadFile($file);

                $post->setImage($filename);
                //then use the em to save to the database
                $em->persist($post);
                //call the flush function to actually insert the query
                $em->flush();
            }

            //redirect after submission
            return $this->redirect($this->generateUrl('post.index'));
        }

        //entity manager is what connects and talks to the database


        //return a response, you can also return a view if you like
        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //create the route with th id of what you want to show

    /**
     * @Route("/show{id}", name="show")
     * @return Response
     */
    public function show(Post $post){
        //you can use the below function and add some repository methods above when you use a query builder
//        $post = $postRepository->findPostWithCategory()
        //return the view with the post
        return $this->render('post/show.html.twig',[
            'post'=>$post
        ]);
    }

    /**
     * @Route("/delete{id}", name="delete")
     * @return Response
     */
    public function remove(Post $post){
        //entity manager is what connects and talks to the database
        $em = $this->getDoctrine()->getManager();
        //then use the em to save to the database
        $em->remove($post);
        //call the flush function to actually insert the query
        $em->flush();

        //add flash message
        $this->addFlash('success', 'Post was removed successfully');

        return $this->redirect($this->generateUrl('post.index'));

    }
}
