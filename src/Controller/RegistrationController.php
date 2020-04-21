<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */

    //the second paramter below helps us harsh our password.
    //its called dependency injection,it knows we are gonna need it so it injects it into our password,its a symphony thing
    public function register( Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //creating a form for the registration page remember this can take some parameters
        $form = $this->createFormBuilder()
            ->add('username')
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password']
            ])
            ->add('register', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $data = $form->getData();
            $user = new User();
            $user->setUsername($data['username']);
            //you need to harsh the password before you can use it
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $data['password'])
            );
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //redirect after form submission
            return $this->redirect($this->generateUrl('app_login'));

        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
