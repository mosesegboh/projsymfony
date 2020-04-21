<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            //you can use image below but to use a different name,pass in the second mapped parameter to show lyou are using something else
            ->add('attachment', FileType::class,[
                'mapped' => false
            ])
            ->add('category', EntityType::class,[
                //bring all the categories in the database here
                'class'=>Category::class
                ])
            ->add('save', SubmitType::class,
            //the 3rd parameter here can be a class
            ['attr' => [
                'class' => 'btn btn-primary float-right'
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
