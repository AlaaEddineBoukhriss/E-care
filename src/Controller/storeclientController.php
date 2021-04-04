<?php

namespace App\Controller;

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Store;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use App\Entity\User;
use App\Form\StoreType;
use App\Repository\StoreRepository;



use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator




class storeclientController extends AbstractController
{
    /**
     * @var StoreRepository
     */
    private $storeRepository;
    public function __construct(StoreRepository $storeRepository)
    { 
        $this->storeRepository = $storeRepository;
        
    }
    /**
     * @Route("/storeclient", name="storeclient")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, PaginatorInterface $paginator){

 // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
 $storee = $this->getDoctrine()->getRepository(Store::class)->findBy([],['name' => 'desc']);

 $store = $paginator->paginate(
     $storee, // Requête contenant les données à paginer (ici nos articles)
     $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
     1 // Nombre de résultats par page
 );


 return $this->render('storeclient.html.twig',  [
     'store' => $store,
 ]);
    }
    

}
