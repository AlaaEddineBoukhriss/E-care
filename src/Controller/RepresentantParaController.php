<?php

namespace App\Controller;

use App\Entity\RepresentantPara;
use App\Form\RepresentantParaType;
use App\Repository\RepresentantParaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/representant/para")
 */
class RepresentantParaController extends AbstractController
{
    /**
     * @Route("/", name="representant_para_index", methods={"GET"})
     */
    public function index(RepresentantParaRepository $representantParaRepository): Response
    {
        return $this->render('representant_para/index.html.twig', [
            'representant_paras' => $representantParaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="representant_para_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $representantPara = new RepresentantPara();
        $form = $this->createForm(RepresentantParaType::class, $representantPara);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($representantPara);
            $entityManager->flush();

            return $this->redirectToRoute('representant_para_index');
        }

        return $this->render('representant_para/new.html.twig', [
            'representant_para' => $representantPara,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="representant_para_show", methods={"GET"})
     */
    public function show(RepresentantPara $representantPara): Response
    {
        return $this->render('representant_para/show.html.twig', [
            'representant_para' => $representantPara,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="representant_para_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RepresentantPara $representantPara): Response
    {
        $form = $this->createForm(RepresentantParaType::class, $representantPara);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('representant_para_index');
        }

        return $this->render('representant_para/edit.html.twig', [
            'representant_para' => $representantPara,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="representant_para_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RepresentantPara $representantPara): Response
    {
        if ($this->isCsrfTokenValid('delete'.$representantPara->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($representantPara);
            $entityManager->flush();
        }

        return $this->redirectToRoute('representant_para_index');
    }
}
