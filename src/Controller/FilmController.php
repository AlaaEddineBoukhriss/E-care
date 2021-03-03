<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @Route("/film", name="film")
     */
    public function index()
    {
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);
    }
    /**
     * @Route("/afficherf", name="afficherf")
     */
    public function afficherFilm()
    {
        $film= $this->getDoctrine()->getRepository(Film::class)->findAll();
        return $this->render('film/afficherf.html.twig',array('listfilm'=>$film));

    }

    /**
     * @Route("/addFilm", name="addFilm")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addFilm(Request $request){
        $film= new Film();
        $form = $this->createForm(FilmType::class,$film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()  ){
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('afficherf');
        }
        return $this->render("film/addFilm.html.twig",array("formFilm"=>$form->createView()));
    }

    /**
     * @Route("/updateFilm/{idfilm}", name="updateFilm")
     * @param Request $request
     * @param $idfilm
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateFilm(Request $request,$idfilm){
        $film=  $this->getDoctrine()->getManager()->getRepository(Film::class)->find($idfilm);

        $form = $this->createForm(FilmType::class,$film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()  ){
            $em = $this->getDoctrine()->getManager();

            $em->flush();//mise a jour
            return $this->redirectToRoute('afficherf');
        }
        return $this->render("film/addFilm.html.twig",array("formFilm"=>$form->createView()));
    }
    /**
     * @Route("/deletef/{idfilm}", name="deletef")
     */
    public function deleteFilm($idfilm)
    {
        $film = $this->getDoctrine()->getRepository(Film::class)->find($idfilm);
        $em=$this->getDoctrine()->getManager();
        $em->remove($film);
        $em->flush();
        return $this->redirectToRoute("afficherf");
    }
}
