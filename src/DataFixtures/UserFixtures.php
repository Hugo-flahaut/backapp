<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $mdp = 'mdpmdp';
        $users = [
            [
                "email" => "h.flahaut@gmail.com",
                "roles"=> ['ROLE_ADMIN'],
                "password" => $mdp,
                "firstName" => "Hugo",
                "lastName" => "Flahaut",
            ],
            [
                "email" => "a.davroult@gmail.com",
                "roles"=> ['ROLE_ADMIN'],
                "password" => $mdp,
                "firstName" => "Armand",
                "lastName" => "Davroult",
            ],
            [
                "email" => "a.djoudi@gmail.com",
                "roles"=> ['ROLE_ADMIN'],
                "password" => $mdp,
                "firstName" => "Aida",
                "lastName" => "Djoudi",
            ]
        ];

        for($i = 0; $i < count($users); ++$i){
            $user = new User();
            
            $user->setEmail($users[$i]['email']);
            $user->setRoles($users[$i]['roles']);
            $user->setPassword($this->encoder->hashPassword($user, $users[$i]['password']));
            $user->setFirstName($users[$i]['firstName']);
            $user->setLastName($users[$i]['lastName']);
            $user->setPhone('00.00.00.00.00');
            $manager->persist($user);  
        }
        $manager->flush();
    }
}