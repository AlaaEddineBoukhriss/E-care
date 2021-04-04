<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\SearchProduit1Type;
use App\Form\QuantityType;
use App\Form\SearchProduitType;
use App\Repository\ProduitRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    /**
     * @Route("/carte", name="carte")
     */
    public function index(SessionInterface $session ,ProduitRepository $produitRepository ,Request $request): Response
    {
        $panier=$session->get('panier',[]);
        $panierWithData=[];
        foreach ($panier as $id=>$quantite){
            $panierWithData[]=[
                'produit'=>$produitRepository->find($id),
                'quantite'=>$quantite
            ];
        }
        $total=0;
        foreach ($panierWithData as $item){
            $totalItem=$item['produit']->getPrix()*$item['produit']->getQuantite();
            $total+=$totalItem;
        }

        return $this->render('carte/index.html.twig', [
            'controller_name' => 'CarteController',
            'items'=>$panierWithData,
            'total'=>$total,
            'produitByPrix'=>'produitByPrix'
        ]);
    }
    /**
     * @Route("/carteBack", name="carteBack")
     */
    public function indexBack(SessionInterface $session ,ProduitRepository $produitRepository ,Request $request): Response
    {
        $panier=$session->get('panier',[]);
        $panierWithData=[];
        foreach ($panier as $id=>$quantite){
            $panierWithData[]=[
                'produit'=>$produitRepository->find($id),
                'quantite'=>$quantite
            ];
        }
        $total=0;
        foreach ($panierWithData as $item){
            $totalItem=$item['produit']->getPrix()*$item['produit']->getQuantite();
            $total+=$totalItem;
        }

        return $this->render('carte/indexBack.html.twig', [
            'controller_name' => 'CarteController',
            'items'=>$panierWithData,
            'total'=>$total,
            'produitByPrix'=>'produitByPrix'
        ]);
    }
    /**
     * @Route("/Panier/add{id}" ,name="cart_add")
     */
    public function add($id ,SessionInterface $session){

        $panier=$session->get('panier',[]);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        }else{

        $panier[$id]=1 ; }
        $session->set('panier',$panier);
      return $this->redirectToRoute("carte");
    }
    /**
     * @Route("/Panier/remove{id}" ,name="cart_remove")
     */
    public function remove($id,SessionInterface $session){
        $panier=$session->get('panier',[]);
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier',$panier);

        $this->addFlash('message','Le message a bien ete envoye');
        $this->addFlash(
            'info' ,' product deleted !');

        return $this->redirectToRoute("carte");

    }



    /**
     * @Route("/Panier/remove{id}" ,name="cart_remove1")
     */
    public function remove1($id,SessionInterface $session){
        $panier=$session->get('panier',[]);
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute("carteFront");

    }
    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carte = new Carte();
        $form = $this->createForm(ProduitType::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carte);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('carte/new.html.twig', [
            'produit' => $carte,
            'form' => $form->createView(),
        ]);

    }
    /**
     * @Route("/{id}/editQ", name="produit_editQ", methods={"GET","POST"})
     */
    public function editQ(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(QuantityType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('message','Le message a bien ete envoye');
            $this->addFlash(
                'info' ,' quantite modifie !');
            return $this->redirectToRoute('carte');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }
}
