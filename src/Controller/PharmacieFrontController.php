<?php

namespace App\Controller;

use App\Entity\Pharmacie;
use App\Repository\PharmacieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PharmacieFrontController extends AbstractController
{
    /**
     * @Route("/pharmacies", name="pharmacie_front")
     */
    public function index(PharmacieRepository $pharmacieRepository): Response
    {
        return $this->render('front/pharmacie/index.html.twig', [
            'pharmacies' => $pharmacieRepository->findAll(),
        ]);
    }
}
