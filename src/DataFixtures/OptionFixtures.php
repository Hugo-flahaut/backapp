<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OptionFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $options = [
            [
                "name" => "wifi",
                "price" => 10
            ],
            [
                "name" => "parking",
                "price" => 15
            ],
            [
                "name" => "piscine",
                "price" => 30
            ],
            [
                "name" => "petit dej",
                "price" => 8
            ],
            [
                "name" => "diner",
                "price" => 20
            ],
        ];

        for($i = 0; $i < count($options); ++$i){
            $option = new Option();
            
            $option->setName($options[$i]['name']);
            $option->setPrice($options[$i]['price']);

            $manager->persist($option);  
        }
        $manager->flush();
    }
}