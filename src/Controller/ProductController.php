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


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Knp\Snappy;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/{store}", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository,Store $store, $order = "ASC", $by = "id"): Response
    {

        $em = $this->getDoctrine()->getManager();
        $p = $productRepository->findAll();
        foreach ($p as $item) {
            if($item->getQuantity() < 1)
                $em->remove($item);
        }
        $em->flush();
        $products = $productRepository->findProductByStore($store,$order,$by);
        //dd($products);
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'store'=> $store->getId(),
        ]);
    }
    /**
     * @Route("/search/{store}/{order}/{by}", name="product_search", methods={"GET"})
     */
    public function search(ProductRepository $productRepository,Store $store, $order = "ASC", $by = "id"): Response
    {
        $products = $productRepository->findProductByStore($store,$order,$by);
        //dd($products);
        $resp = "";
        foreach ($products as $product) {
            $resp .= '<tr>
                <td>'. $product->getId().'</td>
                <td>'. $product->getName().'</td>
                <td>'. $product->getDescription().'</td>
                <td>'. $product->getQuantity().'</td>
                <td>'. $product->getPrice().'</td>
                <td>'. $product->getImage().'</td>
                <td>
                    <a href="/product/show/'. $product->getId().'">show</a>
                    <a href="/product/'. $product->getId().'/edit">edit</a>
                </td>
            </tr>';
        }

        return new Response($resp);
    }

    /**
     * @Route("/{store}/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request,Store $store ): Response
    {

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

         /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
         $file = $form->get('image')->getData();
    
         $name = $this->generateUniqueFileName().'.'.$file->guessExtension();

         // moves the file to the directory where brochures are stored
         /* $file->move(
             $this->getParameter('image_directory'),
             $name
         ); */

         // updates the 'brochure' property to store the PDF file name
         // instead of its contents
         $product->setImage($name);
         // dump($name);
         // dump($file);
         dump($product);
            $entityManager = $this->getDoctrine()->getManager();
            $product->setStore($store);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index',['store'=>$product->getStore()->getId()]);

        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

   /**
    * @return string
    */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/show/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        // permet d'afficher les produits qui appartiennent a deux stores ou plus qui vendent ce meme produit triés par les plus utilisés
        // suggestion pour ajouter ce produit au store
        $em = $this->getDoctrine()->getManager();
        //liste des produits qui portent le meme nom
        $prods = $em->getRepository(Product::class)->findBy(['name'=>$product->getName()]);
        // les stores qui vendent le meme produit
        $stores= '(';
        foreach ($prods as $prod) {
            $stores .= $prod->getStore()->getId();
            $stores .= ',';
        }

        $stores = substr($stores,0,-1);
        $stores.=")";

        //la liste finale des suggestions
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App:Product', 'p');
        $rsm->addFieldResult('p','id','id');
        $rsm->addFieldResult('p','name','name');
        $rsm->addFieldResult('p','description','description');
        $rsm->addFieldResult('p','quantity','quantity');
        $rsm->addFieldResult('p','price','price');
        $rsm->addFieldResult('p','image','image');
        $val = $em->createNativeQuery("SELECT p.* FROM product p where store_id in ".$stores." and name <> '".$product->getName()."' group by name having count(*)>1 order by count(*) desc", $rsm)->getResult();;



        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $val,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('image')->getData();
           
 $name = $this->generateUniqueFileName().'.'.$file->guessExtension();

         // moves the file to the directory where brochures are stored
         $file->move(
             $this->getParameter('image_directory'),
             $name
         );

         // updates the 'brochure' property to store the PDF file name
         // instead of its contents
         $product->setImage($name);
     


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('store_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('store_index');
    }


    /**
     * @Route("/pdf/{store}", name="product_show_pdf", methods={"GET"})
     */

    public function pdfAction(ProductRepository $productRepository,Store $store, $order = "ASC", $by = "id")
    {
        $products = $productRepository->findProductByStore($store,$order,$by);
        $html = $this->renderView('product/pdf.html.twig', array(
            'products'  => $products
        ));

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}