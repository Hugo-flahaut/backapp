<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Room;
use App\Entity\Option;
use App\Entity\Booking;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class BookingDataPersister implements ContextAwareDataPersisterInterface
{
    protected $security;
    protected $em;

    public function __construct(UserRepository $userRepository, RoomRepository $roomRepository, OptionRepository $optionRepository, Security $security, EntityManagerInterface $em)
    {
        $this->security= $security;
        $this->em= $em;  
        $this->roomRepository=$roomRepository;
        $this->optionRepository=$optionRepository;
        $this->userRepository=$userRepository;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Booking;
    }

    public function persist( $data, array $context = [])
    {
        
        //add date and time of registration
            $data->setCreatedAt(new \DateTime());
        //get the userid and convert it to integer
        $userid = intval( $this->security->getUser()->getUserIdentifier());
        $user = $this->userRepository->find($userid);
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