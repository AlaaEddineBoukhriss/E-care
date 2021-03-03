<?php

namespace App\Controller;

use App\Entity\RepresentantClinique;
use App\Form\RepresentantCliniqueType;
use App\Repository\RepresentantCliniqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/representant/clinique")
 */
class RepresentantCliniqueController extends AbstractController
{
    /**
     * @Route("/", name="representant_clinique_index", methods={"GET"})
     */
    public function index(RepresentantCliniqueRepository $representantCliniqueRepository): Response
    {
        return $this->render('representant_clinique/index.html.twig', [
            'representant_cliniques' => $representantCliniqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="representant_clinique_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $representantClinique = new RepresentantClinique();
        $form = $this->createForm(RepresentantCliniqueType::class, $representantClinique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($representantClinique);
            $entityManager->flush();

            return $this->redirectToRoute('representant_clinique_index');
        }

        return $this->render('representant_clinique/new.html.twig', [
            'representant_clinique' => $representantClinique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="representant_clinique_show", methods={"GET"})
     */
    public function show(RepresentantClinique $representantClinique): Response
    {
        return $this->render('representant_clinique/show.html.twig', [
            'representant_clinique' => $representantClinique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="representant_clinique_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RepresentantClinique $representantClinique): Response
    {
        $form = $this->createForm(RepresentantCliniqueType::class, $representantClinique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('representant_clinique_index');
        }

        return $this->render('representant_clinique/edit.html.twig', [
            'representant_clinique' => $representantClinique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="representant_clinique_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RepresentantClinique $representantClinique): Response
    {
        if ($this->isCsrfTokenValid('delete'.$representantClinique->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($representantClinique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('representant_clinique_index');
    }
}
