<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PatientRepository;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;

use Dompdf\Dompdf;
use Dompdf\Options;


class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    /**
     * @Route("/addPatient", name="addPatient")
     */
    public function addPatient(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('afficherPatientfront');
        }
        return $this->render("patient/addPatient.html.twig", array("formPatient" => $form->createView()));
    }
        /**
     * @Route("/addPatientFront", name="addPatientFront")
     */
    public function addPatientFront(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();
            $this->addFlash('success', 'Merci de choisir notre clinique , Veuillez patienter l\'arrivage de l\'ambulance' );

            return $this->redirectToRoute('afficherPatientfront');
        }
        return $this->render("patient/addPatientFront.html.twig", array("formPatient1" => $form->createView()));
    }
    /**
     * @Route("/afficherPatient", name="afficherPatient")
     */
    public function afficherPatient()
    {
        $patient = $this->getDoctrine()->getRepository(Patient::class)->findAll();
        return $this->render('patient/afficherPatient.html.twig', array('listPatient' => $patient));
    }
   /**
     * @Route("/afficherPatientfront", name="afficherPatientfront")
     */
    public function afficherPatientfront1()
    {
        $patient = $this->getDoctrine()->getRepository(Patient::class)->findAll();
        return $this->render('patient/afficherPatientfront.html.twig', array('listPatient' => $patient));
    }
    /**
     * @Route("/deletePatient/{id}", name="deletePatient")
     */
    public function deletePatient($id)
    {
        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($id);
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
        $patient =  $this->getDoctrine()->getManager()->getRepository(Patient::class)->find($id);

        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficherPatient');
        }
        return $this->render("patient/addPatient.html.twig", array("formPatient" => $form->createView()));
    }
       /**
     * @Route("/updatePatientFront/{id}", name="updatePatientFront")
     */
    public function updatePatientFront(Request $request, $id)
    {
        $patient =  $this->getDoctrine()->getManager()->getRepository(Patient::class)->find($id);

        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficherPatientfront');
        }
        return $this->render("patient/addPatientFront.html.twig", array("formPatient1" => $form->createView()));
    }
/**
     * @Route ("/tri",name="tri")
     */
    public function tri(PatientRepository $repository, Request $request)
    {
        $patient = $repository->OrderByName();
        return $this->render('patient/affichageFront.html.twig', array('listPatient' => $patient));
    }

    /**
     * @Route ("/recherchepatient",name="recherchepatient")
     */
    public function recherchepatient(PatientRepository $repository, Request $request)
    {
        
        $data = $request->get('search');
        $patient = $repository->SearchName($data);
        return $this->render('patient/afficherPatient.html.twig', array('listPatient' => $patient));
    }
   

/**
     * @Route("/", name="afficherPatientFront")
     */
    public function afficherPatientFront(Request $request, DataTableFactory $dataTableFactory)
    {
        // $pharmacie = $this->getDoctrine()->getRepository(Clinique::class)->findAll();
        $table = $dataTableFactory->create()
            ->add('name', TextColumn::class, ['label' => 'Nom   Patient', 'className' => 'bold'])
            ->add('email', TextColumn::class, ['label' => 'Email Patient', 'className' => 'bold'])
            ->add('phone', TextColumn::class, ['label' => 'Numéro Patient', 'className' => 'bold'])
            ->add('adresse', TextColumn::class, ['label' => 'Adresse Patient', 'className' => 'bold'])
            //->add('clinique', TextColumn::class, ['label' => 'Description clinique', 'className' => 'bold'])

            ->createAdapter(ORMAdapter::class, [
                'entity' => Patient::class,

            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('patient/affichageFront.html.twig', ['datatable' => $table]);
    }

    /**
     * @Route("/ListPatientPDF", name="ListPatientPDF")
     */
    public function ListPatientPDF()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $patient1 = $this->getDoctrine()->getRepository(Patient::class)->findAll();
        //return $this->render('patient/ListPatientPDF.html.twig', array('listPatient' => $patient1));
        
        // Instantiate Dompdf with our options
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('patient/ListPatientPDF.html.twig', [
            'listPatient' => $patient1
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
