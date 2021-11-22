<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#{AsController}
/**
 * 
 */

final class RoomWithImageController extends AbstractController
{
    public function __invoke(Request $request): Room
    {
    
     //get the file
        $uploadedFile = $request->files->get('imageFile');     
        $room= new Room();
      //  $room =$request->attributes->get('data');
        $requests = $request->request;
        foreach($requests as $request){
            $roomvalue[]=$request;
        }
       // $file = $request->files->get('file');
    
        $room-> setNumber($roomvalue[0]);
        //dd($roomvalue[0]);
        $room -> setType($roomvalue[1]);
    
        $room -> setPrice($roomvalue[2]);
       // dd($uploadedFile);
        $room->setImageFile($uploadedFile);

        //to do the persistance we have to change field
        $room->setcreatedAt(new \DateTime());
        return  $room;
    }
}