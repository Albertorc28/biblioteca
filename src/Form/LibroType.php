<?php

namespace App\Form;

use App\Entity\Autor;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Libro;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('autor',EntityType::class,array(
                'class' => Autor::class,
                'choice_label' => function ($autor) {
                    return $autor->getNombre();
            }))
            ->add( 'save' , SubmitType::class , array (
                'attr' => array ( 'class' => 'btn btn-success' ),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}
