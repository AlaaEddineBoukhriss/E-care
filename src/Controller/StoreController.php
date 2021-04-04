<?php

namespace App\Controller;

use App\Entity\Store;
use App\Entity\User;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/store")
 */
class StoreController extends AbstractController
{

  /**
     * @var StoreRepository
     */
    private $clientRepository;
    public function __construct(StoreRepository $StoreRepository)
    { 
        $this->StoreRepository = $StoreRepository;
        
    }

    /**
     * @Route("/", name="store_index", methods={"GET"})
     */
    public function index(StoreRepository $storeRepository, UserInterface $users): Response
    {
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser();
        $user  = $em->getRepository(User::class)->findOneBy(array('id' => $idUser));
        $query= $em->createQuery("SELECT u FROM  App:Store  u
        LEFT JOIN  App:User  cm WITH cm.id = u.user
        WHERE
         cm.id =  :Z " )
         -> setParameter('Z' , $idUser ) 
         ;
        $stores= $query->getResult();

        return $this->render('store/index.html.twig', array('stores'=>$stores));
    }

    /**
     * @Route("/search/{data}", name="store_search", methods={"GET"})
     */
    public function searchAction($data)
    {
        $repo = $this->getDoctrine()
            ->getRepository(Store::class);
        $query = $repo->createQueryBuilder('a')
            ->where('a.name LIKE :title')
            ->setParameter('title', '%'.$data.'%')
            ->getQuery();
        $results = $query->getResult();
        $resp = '';
        foreach ($results as $result) {
            $resp .= '<tr>
                <td>'.$result->getId().'</td>
                <td>'.$result->getName().'</td>
                <td>'.$result->getPhone().'</td>
                <td>'.$result->getEmail().'</td>
                <td>
                    <a href="/store/'.$result->getId().'">show</a>
                    <a href="/store/'.$result->getId().'/edit">edit</a>
                </td>
            </tr>';
        }
        return new Response($resp);

    }

    /**
     * @Route("/new", name="store_new", methods={"GET","POST"})
     */

    public function new(Request $request)
    {
        $user = $this->getUser();
        $store = new Store();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $store->setUser($user);
            $entityManager->persist($store);
            $entityManager->flush();

            return $this->redirectToRoute('store_index');
        }

        return $this->render('store/new.html.twig', [
            'store' => $store,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="store_show", methods={"GET"})
     */
    public function show(Store $store): Response
    {
        return $this->render('store/show.html.twig', [
            'store' => $store,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="store_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Store $store): Response
    {
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('store_index');
        }

        return $this->render('store/edit.html.twig', [
            'store' => $store,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="store_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Store $store): Response
    {
        if ($this->isCsrfTokenValid('delete'.$store->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($store);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }


}
