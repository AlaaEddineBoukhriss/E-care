<?php

namespace App\Controller;

use App\Entity\Pharmacie;
use App\Form\PharmacieType;
use App\Repository\PharmacieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pharmacie")
 */
class PharmacieController extends AbstractController
{
    /**
     * @Route("/", name="pharmacie_index", methods={"GET"})
     */
    public function index(PharmacieRepository $pharmacieRepository): Response
    {
        return $this->render('admin/pharmacie/index.html.twig', [
            'pharmacies' => $pharmacieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pharmacie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pharmacie = new Pharmacie();
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pharmacie);
            $entityManager->flush();

            return $this->redirectToRoute('pharmacie_index');
        }

        return $this->render('admin/pharmacie/new.html.twig', [
            'pharmacie' => $pharmacie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pharmacie_show", methods={"GET"})
     */
    public function show(Pharmacie $pharmacie): Response
    {
        return $this->render('admin/pharmacie/show.html.twig', [
            'pharmacie' => $pharmacie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pharmacie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pharmacie $pharmacie): Response
    {
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pharmacie_index');
        }

        return $this->render('admin/pharmacie/edit.html.twig', [
            'pharmacie' => $pharmacie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pharmacie_delete", methods={"POST"})
     */
    public function delete(Request $request, Pharmacie $pharmacie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pharmacie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pharmacie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pharmacie_index');
    }
}
