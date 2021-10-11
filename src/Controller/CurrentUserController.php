<?php

namespace App\Controller;

use stdClass;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CurrentUserController extends AbstractController
{
    /**
     * @Route("/api/current/user" , methods={"GET"})
     */
    public function index(Security $security,UserRepository $userRepository ): Response

    {
        $this->security= $security;
        $this->userRepositoty= $userRepository;
        $userid =  intval( $security->getUser()->getUserIdentifier());  
        $currentuser =$userRepository->find($userid);
        $currentuserEmail = $currentuser->getEmail();
        $currentuserFirstName= $currentuser->getFirstName();
        $currentuserLastName= $currentuser->getLastName();
    //    dd( $currentuserEmail, $currentuserFirstName, $currentuserLastName);
        return $this->json([
            'status' => '200',
            'email'=> $currentuserEmail,
            'firstName'=> $currentuserFirstName,
            'lastName'=> $currentuserLastName
        ], 200);
    }
}
