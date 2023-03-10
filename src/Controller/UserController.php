<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'myres')]
    public function index(): Response
    {
        $myres = $this->getDoctrine()->getRepository(Reservation::class)->findBy(['user'=>$this->getUser()]);
        return $this->render('user/myres.html.twig', [
            'myres' => $myres,
        ]);
    }

    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        $user = $this->getUser();
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}', name: 'show_user')]
    public function finduser($id): Response
    {
        $user = $this->getdoctrine()->getrepository(User::class)->findOneById($id);
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
