<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RoomFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $rooms = [
            [
                "number" => 1,
                "type" => "simple",
                "price" => 30
            ],
            [
                "number" => 2,
                "type" => "simple",
                "price" => 30
            ],
            [
                "number" => 3,
                "type" => "double",
                "price" => 50
            ],
            [
                "number" => 4,
                "type" => "double",
                "price" => 50
            ],
            [
                "number" => 5,
                "type" => "suite",
                "price" => 150
            ],
        ];

        for($i = 0; $i < count($rooms); ++$i){
            $room = new Room();
            
            $room->setNumber($rooms[$i]['number']);
            $room->setType($rooms[$i]['type']);
            $room->setPrice($rooms[$i]['price']);

            $manager->persist($room);  
        }
        $manager->flush();
    }
}