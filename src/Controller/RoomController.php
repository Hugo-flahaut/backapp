<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{
    /**
     * @Route("/api/room/notbooking/{datestart}/{dateend}/{type}" , methods={"GET"})
     */
    public function index(RoomRepository $roomRepository ,$datestart,$dateend,$type): Response

    {
        $date1 = new \DateTime($datestart);
        $date2 = new \DateTime($dateend);
        $typer = $type;
        $rooms = $roomRepository->findNotBookingRoomsId( $date1, $date2,$typer);
        $roomsjson =json_encode( $rooms);
       // dd( $tablejson );
        return new Response( $roomsjson,200,[
            "Content-Type" => "application/json"
        ]);
    }
}
