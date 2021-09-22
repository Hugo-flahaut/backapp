<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;


class BookingDataPersister implements ContextAwareDataPersisterInterface
{
    protected $security;
    protected $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security= $security;
        $this->em= $em;  
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Booking;
    }

    public function persist($data, array $context = [])
    {
        
        //add date and time of registration
            $data->setCreatedAt(new \DateTime());
        //passed status at false
            $data->setStatus(false);
        //add the totale price 
            $data->setTotalPrice(10);
        //get the user
            $user = $this->security->getUser() ;
            dump($user);
            die();
        //affect user at booking
        $data->setUser($user);
        $this->em->persist($data);
        $this->em->flush();

    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}