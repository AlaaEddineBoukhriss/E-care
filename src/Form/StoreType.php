<?php

namespace App\Form;

use App\Entity\Store;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;


class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => false,
           
            'attr' => [
                'placeholder' => 'Nom'
            ]
            ])
            ->add('phone', TextType::class, ['label' => false,
       
            'attr' => [
                'placeholder' => 'Téléphone'
            ]
            ])
            ->add('email', TextType::class, ['label' => false,
         
            'attr' => [
                'placeholder' => 'Email'
            ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Store::class,
        ]);
    }
}
