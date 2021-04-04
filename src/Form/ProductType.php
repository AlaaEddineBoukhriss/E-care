<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => false,
           
            'attr' => [
                'placeholder' => 'Nom'
            ]
            ])
            ->add('description', TextareaType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                'placeholder' => 'Commentaire'
                ]]
                )
            ->add('quantity', IntegerType::class, ['label' => false,
           
            'attr' => [
                'placeholder' => 'Quantité'
            ]
            ])
            ->add('price', NumberType::class, ['label' => false,
           
            'attr' => [
                'placeholder' => 'Prix'
            ]
            ])
            ->add('image', FileType::class, array('data_class' => null))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
