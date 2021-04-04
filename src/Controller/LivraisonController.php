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
                ->setFrom('achrafzrig@gmail.com')

                // On attribue l'expéditeur
                ->setTo($livraison->getMail())


                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        '/livraison/emails/contact.html.twig', compact('livraison')
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);
            $this->addFlash('message','Le message a bien ete envoye');
            $this->addFlash(
                'info' ,'Commande Confirmer!');
            return $this->redirectToRoute('carte') ;


        }
        return $this->render('livraison/index.html.twig', [
            'controller_name' => 'LivraisonController',

            'form' => $form->createView(),
        ]);

    }

}

