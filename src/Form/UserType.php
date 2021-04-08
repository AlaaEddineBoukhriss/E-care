<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('roles', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'label' => false,
                    'choices' => [
                        'Admin' => 'ROLE_ADMIN',
                        'Patient' => 'ROLE_PAT',
                        'Medecin' => 'ROLE_MED',
                        'Para' => 'ROLE_PARA',
                        'Pharmacie' => 'ROLE_PHAR',
                        'Clinique'=>'ROLE_CLI'

                    ],
                ],
            ])
            ->add('password')
            ->add('cin')
            ->add('sexe')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('num_tel')
            ->add('email')
            ->add('isVerified')
            ->add('store')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
