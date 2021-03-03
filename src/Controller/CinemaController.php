<?php

namespace App\Controller;

use App\Entity\Cinema;

use App\Form\CinemaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CinemaController extends AbstractController
{
    /**
     * @Route("/cinema", name="cinema")
     */
    public function index()
    {
        return $this->render('cinema/index.html.twig', [
            'controller_name' => 'CinemaController',
        ]);
    }
    /**
     * @Route("/afficher", name="afficher")
     */
    public function afficher()
    {
        $cinema = $this->getDoctrine()->getRepository(Cinema::class)->findAll();
        return $this->render('cinema/afficher.html.twig',array('liststudent'=>$cinema));

    }
    /**
     * @Route("/addCinema", name="addCinema")
     */
    public function addStudent(Request $request){
        $cinema= new Cinema();
        $form = $this->createForm(CinemaType::class,$cinema);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cinema);
            $em->flush();
            return $this->redirectToRoute('afficher');
        }
        return $this->render("cinema/add.html.twig",array("formCinema"=>$form->createView()));
    }
    /**
     * @Route("/updateCinema/{num}", name="updateCinema")
     */
    public function updateCinema(Request $request,$num){
        $cinema=  $this->getDoctrine()->getManager()->getRepository(Cinema::class)->find($num);

        $form = $this->createForm(CinemaType::class,$cinema);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $em = $this->getDoctrine()->getManager();
            $em->flush();//mise a jour
            return $this->redirectToRoute('afficher');
        }
        return $this->render("cinema/add.html.twig",array("formCinema"=>$form->createView()));
    }
    /**
     * @Route("/delete/{num}", name="delete")
     */
    public function delete($num)
    {
        $Classroom = $this->getDoctrine()->getRepository(Cinema::class)->find($num);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Classroom);
        $em->flush();
        return $this->redirectToRoute("afficher");
    }
}
