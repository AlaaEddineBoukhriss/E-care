<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AvisRepository;
use App\Repository\PatientRepository;
use App\Repository\PharmacieRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(AvisRepository $avisRepository,
    PatientRepository $patientRepository,
    PharmacieRepository $pharmacieRepository): Response
    {
        $pharmacies= $pharmacieRepository->findAll();
        $patients= $patientRepository->findAll();
        $avis= $avisRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'pharmacies' => count($pharmacies) ,
            'avis' => count($avis),
            'patients' => count($patients),
        ]);
    }
}
