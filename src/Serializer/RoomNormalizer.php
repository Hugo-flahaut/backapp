<?php
namespace App\Serializer;

use App\Entity\Room;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class RoomNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;
//to get unique key and no do boucle
    private const ALREADY_CALLED = 'ROOM_NORMALIZER_ALREADY_CALLED';   

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }  
    /**
     *
     * @param Room $object
     */

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return !isset($context[self ::ALREADY_CALLED]) && $data instanceof Room; 
    }
    public function normalize($object, string $format = null, array $context = [])
    {
        $object->setImageUrl($this->storage->resolveUri($object, 'imageFile'));
        //to add if not take empty value value we add ?? " "
     //   dd($this->storage->resolveUri($object, 'imageFile'));
        $context[self::ALREADY_CALLED] = true;
        return $this->normalizer->normalize($object, $format, $context);
        
    }
}