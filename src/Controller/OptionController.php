<?php

namespace App\Controller;

use App\Repository\OptionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OptionController extends AbstractController
{
    /**
     * @Route("/api/option/getid/{option}",methods={"GET"})
     */
    public function index(OptionRepository $optionRepository ,$option): Response
    {
        $this->optionRepository=$optionRepository;
        $optionc = $option;
        $optionsid =$optionRepository->findOptionId($optionc)->getid();
        return $this->json([
            'status' => '200',
            'id' => $optionsid
        ], 200);
    }
}
