<?php

namespace App\Controller;

use App\Repository\PharmacieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function index(PharmacieRepository $pharmacieRepository): Response
    {
        return $this->render('front/pharmacie/index.html.twig', [
            'pharmacies' => $pharmacieRepository->findAll(),
        ]);
    }
}
