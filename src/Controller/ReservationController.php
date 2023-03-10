<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    #[Route('/reservation/add/{id}', name: 'add_reservation')]
    public function add(/* Ad $ad, */$id ,Request $request,EntityManagerInterface $em): Response
    {
        $reservation = new Reservation();
         $ad = $this->getDoctrine()->getRepository(Ad::class)->find($id); 
        $form = $this->createForm(ReservationType::class,$reservation);
        $form->handlerequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /* $reservation->setAd($ad);
            $reservation->setUser($this->getUser()); */
            $reservation->setUser($this->getUser())->setAd($ad);
            $data = $form->getData()->getNb();
            if ($data > $ad->getNbp()  )
            {
                $this->addFlash(
                    'warning',"pas de place"
                );
            }
            elseif ($ad->getNbp() >= $ad->getNbr() && (($ad->getNbp() - $ad->getNbr()) >= $data))
            {
                $s=$ad->getNbr();
                $sum=$data+$s;
                $ad->setNbr($sum);
                $mont=$data*$ad->getMontant();
                $reservation->setMontant($mont);
                $em->persist($reservation);
                $em->flush();
                $this->addFlash(
                    'success',"c est bon"
                );
                return $this->redirectToRoute('show_reservation',['id'=>$reservation->getId(),
                'withAlert'=>true]);
            } 
            else {
                $this->addFlash(
                    'warning',"pas de place"
                );

            }           
        }
        return $this->render('reservation/add.html.twig', [
            'form' => $form->createView(),'ad'=>$ad
        ]);
    }


     
    #[Route('/reservation/add/show/{id}', name: 'show_reservation')]
    public function show (Reservation $reservation,Request $request,EntityManagerInterface $manager): Response{

        $comment=new Comment();
        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()  ) {              
                 $comment->setAd($reservation->getAd());
                 $comment->setUser($this->getUser());
                 $comment->setCreatedAt(new \DateTime('now'));
            /*  $entityManager = $this->getDoctrine()->getManager(); */
             $manager->persist($comment);
             $manager->flush();
             $this->addFlash(
                'success',
                "Votre commentaire a bien été pris en compte !");
                return $this->redirectToRoute('show_reservation', ['id' => $reservation->getId()]);
                
             }
        return $this->render('reservation/show.html.twig',[
           'reservation'=>$reservation,
           'form'=>$form->createView()
        ]);
     }


     #[Route('/reservation/add/delete/{id}', name: 'delete_reservation')]
     public function delete ($id,Reservation $reservation,Request $request,EntityManagerInterface $manager): Response{
 
         
        $reservation= $this->getDoctrine()->getRepository(Reservation::class)->findOneById($id);
        $nb=$reservation->getNb();
        $ida= $reservation->getAd();
        $ad= $this->getDoctrine()->getRepository(Ad::class)->findOneById($ida);
        $nbr= $reservation->getAd()->getNbr();
        $s = $nbr - $nb;
        $reservation->getAd()->setNbr($s);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->persist($ad);
        $em->flush();
        
         return $this->render('ad/show.html.twig',[
            'reservation'=>$reservation,'ad'=>$ad
            
         ]);
      }
}
