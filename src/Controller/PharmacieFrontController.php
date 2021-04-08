<?php

namespace App\Controller;
use App\Form\AvisClientType;
use App\Entity\AvisClient;
use App\Entity\Pharmacie;
use App\Repository\PharmacieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PharmacieFrontController extends AbstractController
{
    /**
     * @Route("/pharmacies", name="pharmacie_front")
     */
    public function index(PharmacieRepository $pharmacieRepository): Response
    {
        return $this->render('front/pharmacie/index.html.twig', [
            'pharmacies' => $pharmacieRepository->findAll(),
        ]);
    }



    /**
     * @Route("/AvisAdd", name="AvisAdd")
     */
    public function AvisAdd(Request $request){
        $avis= new AvisClient();
        $form = $this->createForm(AvisclientType::class,$avis);
        $form->handleRequest($request);
        $description = $form->get('descR')->getData();
        $abonne = $form->get('idRclient')->getData();


        if ($form->isSubmitted()){

            $servername = "localhost";//Server Name
            $username = "root";//Server User Name
            $password = "";//Server Password
            $dbname = "happy";//Database Name

//Create DB Connection
            $conn = mysqli_connect($servername,$username,$password,$dbname);

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $rating = $_POST["rating"];

                $sql = "INSERT INTO avisclient (idRclient_id,rating,desc_r) VALUES ('$abonne','$rating','$description')";

                if (mysqli_query($conn, $sql))
                {
                    echo "New Rate added successfully";

                }
                else
                {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                mysqli_close($conn);
            }


            return $this->redirectToRoute("pharmacie_front");
        }
        return $this->render("avisclient/addRating.html.twig",array("form"=>$form->createView()));
    }
}
