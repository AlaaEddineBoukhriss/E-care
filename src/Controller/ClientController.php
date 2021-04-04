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




class ClientController extends AbstractController
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
     * @Route("/client", name="client")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(){
        $store = $this->storeRepository->findAll();
        return $this->render('client.html.twig', compact('store'));
    }
    

}
