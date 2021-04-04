<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Reponse;
use App\Form\CommentaireType;
use App\Form\ReponseType;
use App\Repository\CommentaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="commentaire_index", methods={"GET","POST"})
     */
    public function index(Request $request,CommentaireRepository $commentaireRepository, PaginatorInterface $paginator): Response
    {




        $donnees = $this->getDoctrine()->getRepository(Commentaire::class)->findBy([],['sujet' => 'desc']);
        $commentaireRepository = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2// Nombre de résultats par page
        );
     return $this->render('commentaire/index.html.twig', [
     'commentaires' => $commentaireRepository,

        ]);
    }

    /**
     * @Route("/new", name="commentaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash(
                'info' ,'Added successfully!');

            return $this->redirectToRoute('commentaire_index');
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire , $id): Response
    {

        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }







    /**
     * @Route("/{id}/edit", name="commentaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'info' ,'Updated successfully!');

            return $this->redirectToRoute('commentaire_index');
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commentaire $commentaire): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();

            $this->addFlash(
                'info' ,'Deleted successfully!');
        }

        return $this->redirectToRoute('commentaire_index');
    }

    /**
     * @Route("/searchSujet ", name="searchSujet" , methods={"GET"})
     */
    public function searchSujet(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        $requestString = $request->get('searchValue');
        $sujet = $repository->findCommentaireBySujet($requestString);
        $jsonContent = $Normalizer->normalize($sujet, 'json',['groups'=>'sujet']);
        $retour = json_encode();
        return new Response($retour);
    }





    /**
     * @Route("/reponse/{id}", name="reponse", methods={"GET","POST"})
     */
    public function reponse(Request $request ,$id): Response
    {
        $rep = new Reponse();
        $comm = $this->getDoctrine()->getRepository(Reponse::class)->find($id);
        $rep->setCommentaire($comm);
        $form = $this->createForm(ReponseType::class, $rep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $rep->setDateRep(new \DateTime('now'));
            $entityManager->persist($rep);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire_index');
        }
        return $this->render('reponse/reponse.html.twig', [
            'reponse'=>$rep,
            'form' => $form->createView(),
        ]);




    }
    /**
     * @Route("/showreponse/{id}", name="showreponse", methods={"GET","POST"})
     */
    public function showreponse(Request $request ,$id): Response {
        $comm = $this->getDoctrine()->getRepository(Commentaire::class)->find($id);
        $rep = $comm->getReponse();

        return $this->render('reponse/showreponse.html.twig', [
            'reponse'=>$rep,
        ]);


    }

}
