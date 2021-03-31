<?php

namespace App\Form;

use App\Entity\Livraison;

use Grafikart\RecaptchaBundle\Type\RecaptchaSubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom' ,TextType::class, ['constraints' => [
                new NotBlank([
                    'message' => 'Please enter your name',
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Your name should be at least {{3}} carectere',
                    // max length allowed by Symfony for security reasons
                    'max' => 8,
                ]),]])
            ->add('adresse',TextType::class, ['constraints' => [
        new NotBlank([
            'message' => 'Please enter your adress',
        ]),]])
            ->add('numero', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, ['constraints' => [
        new NotBlank([
            'message' => 'Please enter a number',
        ]),
        new Length([
            'min' => 8,
            'minMessage' => 'Your nuumber should be at least {{ 8}} number',
            // max length allowed by Symfony for security reasons
            'max' => 8,
        ]),]])


            ->add('mail',EmailType::class, ['constraints' => [
                new NotBlank([
                    'message' => 'Please enter your mail',
                ]),]])

            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))

            // ... ///
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
