<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Produit;
use App\Form\DisponibleType;
use App\Form\EnabledClubType;
use App\Form\ProduitType;
use App\Form\SearchProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator


/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET","POST"})
     */
    public function index(Request $request ,ProduitRepository $produitRepository, PaginatorInterface $paginator): Response
    {


// Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(produit::class)->findBy([],['prix' => 'desc']);

        $produit= $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        return $this->render('produit/index.html.twig', [
            'produits' =>$produit,

        ]);
    }

    /**
     *@Route("/dispo", name="produitDispo", methods={"GET","POST"})
     */
     public function list(ProduitRepository $produitRepository ,Request $request){
      $form=$this->createForm(DisponibleType::class);
      $form->handleRequest($request);
       if($form->isSubmitted()) {
      $disponible = $form->getData()->getDisponible();
      $produitResult1 = $this->getDoctrine()->getRepository(Produit::class)->listDispo($disponible);
       return $this->render('produit/Disponible.html.twig', [
       'produits' => $produitResult1,
       'produitOrderByPrix'=>'produitOrderByPrix',
       'form'=>$form->createView(),
 ]);
 }
         return $this->render('produit/Disponible.html.twig', [
             'produits' =>$produitRepository->findAll(),
             'form'=>$form->createView(),
         ]);}

    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index');
    }


    /*public function ajouterAction(Request $request, $id)
    {
        $request = Request::createFromGlobals();
        $session = new Session();


        if(!$session->has('panier')) $session->set('panier', array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            if ($request->query->get('qte') != null)
            {
                $panier[$id] = $request->query->get('qte');
            }else{
                if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
                else
                    $panier[$id] = 1;
            }
        }
        $session->set('panier', $panier);

        return new RedirectResponse($this->generateUrl('panier'));
    }*/

}
