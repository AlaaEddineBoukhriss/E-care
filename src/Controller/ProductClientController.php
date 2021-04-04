<?php

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




class ProductClientController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $ProductRepository;
    public function __construct(ProductRepository $productRepository)
    { 
        $this->productRepository = $productRepository;
        
    }
    /**
     * @Route("/productClient", name="productClient")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(){
        $productClient = $this->productRepository->findAll();
        return $this->render('productClient.html.twig', compact('productClient'));
    }
    

}
