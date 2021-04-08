<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/medecin")
 */
class MedecinController extends AbstractController
{
    /**
     * @Route("/", name="medecin_index", methods={"GET"})
     */
    public function index(MedecinRepository $medecinRepository): Response
    {



        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/medecinindex", name="medecin_indexfront", methods={"GET"})
     */
    public function indexFront(MedecinRepository $medecinRepository): Response
    {
        return $this->render('medecin/indexfront.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }
    /**
     * @Route("/{id}/imprimer", name="medecin_imp", methods={"GET"})
     */

    public function showmed(Medecin $medecin): Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('medecin/imp.html.twig', [
            'medecin'=> $medecin
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        $options = new Options();

        $options->setIsRemoteEnabled(true);

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false


        ]);


    }




    /**
     * @Route("/new", name="medecin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medecin);
            $entityManager->flush();

            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/new.html.twig', [
            'medecin' => $medecin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medecin_show", methods={"GET"})
     */
    public function show(Medecin $medecin): Response
    {
        return $this->render('medecin/show.html.twig', [
            'medecin' => $medecin,
        ]);
    }



    /**
     * @Route("/{id}/edit", name="medecin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Medecin $medecin): Response
    {
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/edit.html.twig', [
            'medecin' => $medecin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medecin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Medecin $medecin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medecin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medecin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medecin_index');
    }

}
