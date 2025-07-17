<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $em,UserPasswordHasherInterface $hasher): Response
    {
       /* $user=new User();
        $user->setEmail('mohamed@dridi')
             ->setUsername('mohamed')
             ->setPassword($hasher->hashPassword($user,'123'))
             ->setRoles([]);
        $em->persist($user);
        $em->flush(); used to add user data in the databse */
        return $this->render('home/index.html.twig');
    }
}
