<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PaiementType;
use App\Form\SearchPanierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivraisonController extends AbstractController
{
    /**
     * @Route("/livraison", name="livraison")
     */
    public function index(Request $request ,\Swift_Mailer $mailer): Response
    {


        $form = $this->createForm(PaiementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $livraison=$form->getData();
            $message = (new \Swift_Message('Nouveau livraison'))
                // On attribue le destinataire
                ->setFrom($livraison('mail'))

                // On attribue l'expéditeur
                ->setTo('achrafzrig@gmail.com')


                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', compact('livraison')
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);
            $this->addFlash('message','Le message a bien ete envoye');
            return $this->redirectToRoute('home');

        }
        return $this->render('livraison/index.html.twig', [
            'controller_name' => 'LivraisonController',

            'form' => $form->createView(),
        ]);

    }

}

