<?php

namespace App\Controller;

use App\Entity\Clinique;
use App\Form\CliniqueType;
use App\Repository\CliniqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
class CliniqueController extends AbstractController
{
    /**
     * @Route("/clinique", name="clinique")
     */
    public function index(): Response
    {
        return $this->render('clinique/index.html.twig', [
            'controller_name' => 'CliniqueController',
        ]);
    }
    /**
     * @Route("/afficherC", name="afficherC")
     */
    public function afficherC()
    {
        $pharmacie = $this->getDoctrine()->getRepository(Clinique::class)->findAll();
        return $this->render('clinique/afficherclinique.html.twig', array('listclinique' => $pharmacie));
    }


    /**
     * @Route("/addclinique", name="addclinique")
     */
    public function addclinique(Request $request)
    {
        $clinique = new Clinique();
        $form = $this->createForm(CliniqueType::class, $clinique);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($clinique);
            $em->flush();
            return $this->redirectToRoute('afficherC');
        }
        return $this->render("clinique/addclinique.html.twig", array("formClinique" => $form->createView()));
    }
    /**
     * @Route("/updateclinique/{id}", name="updateclinique")
     */
    public function updateclinique(Request $request, $id)
    {
        $clinique =  $this->getDoctrine()->getManager()->getRepository(Clinique::class)->find($id);

        $form = $this->createForm(CliniqueType::class, $clinique);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); //mise a jour
            return $this->redirectToRoute('afficherC');
        }
        return $this->render("clinique/addclinique.html.twig", array("formClinique" => $form->createView()));
    }
    /**
     * @Route("/deleteC/{id}", name="deleteC")
     */
    public function deleteC($id)
    {
        $clinique = $this->getDoctrine()->getRepository(Clinique::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($clinique);
        $em->flush();
        return $this->redirectToRoute("afficherC");
    }
    /**
     * @Route ("/rechercheclinique",name="rechercheclinique")
     */
    public function rechercheclinique(CliniqueRepository $repository, Request $request)
    {
        $data = $request->get('search');
        $clinique = $repository->SearchName($data);
        return $this->render('clinique/afficherclinique.html.twig', array('listclinique' => $clinique));
    }
    
    /**
     * @Route ("/tri",name="tri")
     */
    public function tri(CliniqueRepository $repository, Request $request)
    {
        //$data=$request->get('search');
        $clinique = $repository->OrderByName();
        return $this->render('clinique/afficherfront.html.twig', array('listclinique' => $clinique));
    }
    // public function afficherCf()
    //{

    // return $this->render('clinique/afficherfront.html.twig',array('listclinique'=>$pharmacie));

    //}
    /**
     * @Route("/cli", name="afficherCf")
     */
    public function afficherCliniquesf(Request $request, DataTableFactory $dataTableFactory)
    {
        // $pharmacie = $this->getDoctrine()->getRepository(Clinique::class)->findAll();
        $table = $dataTableFactory->create()
            ->add('nomcl', TextColumn::class, ['label' => 'Nom clinique', 'className' => 'bold'])

            ->add('adressecl', TextColumn::class, ['label' => 'Adresse clinique', 'className' => 'bold'])
            ->add('numerocl', TextColumn::class, ['label' => 'Numéro clinique', 'className' => 'bold'])

            // ->add('numerocl', TextColumn::class)
            ->add('desccl', TextColumn::class, ['label' => 'Description clinique', 'className' => 'bold'])

            ->createAdapter(ORMAdapter::class, [
                'entity' => Clinique::class,

            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('clinique/afficherfront.html.twig', ['datatable' => $table]);
    }
}