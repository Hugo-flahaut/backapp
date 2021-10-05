<?php

namespace App\Controller;



use App\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Exception\RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;



#{AsController}
/**
 * 
 */

final class RoomEditImageController extends AbstractController
{
    public function __invoke(Request $request)
    {
        //i get my room
        $room =$request->attributes->get('data');
        if(!($room instanceof Room)){
            throw new \RuntimeException('room entendu');
        }
        $uploadedFile = $request->files->get('imageFile');  
        $room->setImageFile($uploadedFile);
        //to do the persistance we have to change field
        $room->setcreatedAt(new \DateTime());
        return $room;
    }
}
