<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdController extends AbstractController
{
    #[Route('/ad', name: 'ads')]
    public function index(): Response
    {
        $ads = $this->getDoctrine()->getRepository(Ad::class)->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }


    #[Route('/ad/add', name: 'add_ad')]
    public function add(Request $request): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ad->setUser($this->getuser());
           /*  $data = $form->getData()->getNbp();
            $ad->setNbr($data); */
            $file = $form->get('image')->getData();
            /* $file = $post->getPhoto(); */
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) { }
            $ad->setImage($fileName);
            $em = $this->getDoctrine()->getManager();

            $em->persist($ad);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('ad/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
    #[Route('/ad/show/{id}', name: 'show_ad')]
    public function show($id): Response
    {
        $ad = $this->getDoctrine()->getRepository(Ad::class)->findOneById($id);
       
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

}
