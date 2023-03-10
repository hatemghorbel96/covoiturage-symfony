<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Search;
use App\Form\TestType;
use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        $ads = $this->getDoctrine()->getRepository(Ad::class)->findAll();
        if($form->isSubmitted() && $form->isValid()) {
            $ville = $search->getVille(); 
            $destination = $search->getDestination();
            $nbp = $search->getNbp();
            $date = $search->getDate(); 
            if ($ville!="" or $destination!="" or $date!="" or $nbp!="")

            $ads= $this->getDoctrine()->getRepository(Ad::class)->findAd($ville,$destination,$date,$nbp);
            
            else 

            $ads = $this->getDoctrine()->getRepository(Ad::class)->findAll();
        }
        
        return $this->render('home/index.html.twig', [
            'ads' => $ads,'form'=>$form->createView()
        ]);
 
 
    }


  
}
