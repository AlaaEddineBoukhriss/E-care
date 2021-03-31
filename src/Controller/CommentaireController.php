<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
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
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }


    /**
     * @Route("/showc/{id}", name="commentaire_showc", methods={"GET"})
     */
    public function showc(Commentaire $commentaire): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);




        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commentaire/showc.html.twig', [
            'commentaire' => $commentaire,
        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => True
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



}
