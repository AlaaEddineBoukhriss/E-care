<?php

namespace App\Controller;

use App\Entity\Patients;
use App\Form\PatientsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PatientsRepository;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;

use Dompdf\Dompdf;
use Dompdf\Options;


class PatientsController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index(): Response
    {
        return $this->render('patients/index.html.twig', [
            'controller_name' => 'PatientsController',
        ]);
    }

    /**
     * @Route("/addPatient", name="addPatient")
     */
    public function addPatient(Request $request)
    {
        $patient = new Patients();
        $form = $this->createForm(PatientsType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('afficherPatientfront');
        }
        return $this->render("patients/addPatient.html.twig", array("formPatients" => $form->createView()));
    }
        /**
     * @Route("/addPatientFront", name="addPatientFront")
     */
    public function addPatientFront(Request $request)
    {
        $patient = new Patients();
        $form = $this->createForm(PatientsType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();
            $this->addFlash('success', 'Merci de choisir notre clinique , Veuillez patienter l\'arrivage de l\'ambulance' );

            return $this->redirectToRoute('afficherPatientfront');
        }
        return $this->render("patients/addPatientFront.html.twig", array("formPatients" => $form->createView()));
    }
    /**
     * @Route("/afficherPatient", name="afficherPatient")
     */
    public function afficherPatient()
    {
        $patient = $this->getDoctrine()->getRepository(Patients::class)->findAll();
        return $this->render('patients/afficherPatient.html.twig', array('listPatient' => $patient));
    }
   /**
     * @Route("/afficherPatientfront", name="afficherPatientfront")
     */
    public function afficherPatientfront()
    {
        $patient = $this->getDoctrine()->getRepository(Patients::class)->findAll();
        return $this->render('patients/afficherPatientfront.html.twig', array('listPatient' => $patient));
    }
    /**
     * @Route("/deletePatient/{id}", name="deletePatient")
     */
    public function deletePatient($id)
    {
        $patient = $this->getDoctrine()->getRepository(Patients::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($patient);
        $em->flush();
        return $this->redirectToRoute("afficherPatient");
    }

    /**
     * @Route("/updatePatient/{id}", name="updatePatient")
     */
    public function updatePatient(Request $request, $id)
    {
        $patient =  $this->getDoctrine()->getManager()->getRepository(Patients::class)->find($id);

        $form = $this->createForm(PatientsType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficherPatient');
        }
        return $this->render("patients/addPatient.html.twig", array("formPatient" => $form->createView()));
    }
       /**
     * @Route("/updatePatientFront/{id}", name="updatePatientFront")
     */
    public function updatePatientFront(Request $request, $id)
    {
        $patient =  $this->getDoctrine()->getManager()->getRepository(Patients::class)->find($id);

        $form = $this->createForm(PatientsType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficherPatientfront');
        }
        return $this->render("patients/addPatientFront.html.twig", array("formPatient" => $form->createView()));
    }
/**
     * @Route ("/tri",name="tri")
     */
    public function tri(PatientsRepository $repository, Request $request)
    {
        $patient = $repository->OrderByName();
        return $this->render('patients/affichageFront.html.twig', array('listPatient' => $patient));
    }

    /**
     * @Route ("/recherchepatient",name="recherchepatient")
     */
    public function recherchepatient(PatientsRepository $repository, Request $request)
    {
        
        $data = $request->get('search');
        $patient = $repository->SearchName($data);
        return $this->render('patients/afficherPatient.html.twig', array('listPatient' => $patient));
    }
   


    /**
     * @Route("/ListPatientPDF", name="ListPatientPDF")
     */
    public function ListPatientPDF()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $patient = $this->getDoctrine()->getRepository(Patients::class)->findAll();
        //return $this->render('patients/ListPatientPDF.html.twig', array('listPatient' => $patients));
        
        // Instantiate Dompdf with our options
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('patients/ListPatientPDF.html.twig', [
            'listPatient' => $patients
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("ListPatientPDF.pdf", [
            "Attachment" => true
        ]);
        
        
     }


}
