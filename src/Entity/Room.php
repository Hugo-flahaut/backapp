<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\RoomEditImageController;
use App\Controller\RoomWithImageController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 * @ApiResource(
 *  normalizationContext = {"groups"={"room:read"}},
 *  denormalizationContext = {"groups"={"room:write"}},
 *  collectionOperations={
 *      "get",
 *      "postwithimage"={
 *          "method" = "post",
 *           "path" ="/rooms/with/image",
 *           "controller" =RoomWithImageController::class,
 *           "deserialize"= false,
 *                  "openapi_context" = {
 *                    "requestBody" = {
 *                          "content" = {
 *                              "multipart/form-data" = {
 *                                  "schema" = {
 *                                      "type" = "object",
 *                                      "properties" = {
 *                                          "imageFile" = {
 *                                              "type" = "string",
 *                                              "format" = "binary",
 *                                           },
 *                                          "number" = {
 *                                              "type" = "integer",
 *                                              
 *                                           },
 *                                           "type" = {
 *                                              "type" = "string",    
 *                                           },
 *                                            "price" = {
 *                                              "type" = "integer",
 *                                             
 *                                              
 *                                           },
 * 
 *                                          
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      },
 *                 }, 
 *      },
 * },
 *  itemOperations={
 *    "get" ,
 *    "delete" ,
  *   "put",
  *   "image" ={
  *             "method" = "post",
  *              "path" ="/rooms/{id}/add/or/edit/image",
  *              "controller" =RoomEditImageController::class,
  *               "deserialize"= false,
  *               "openapi_context" = {
  *                    "summary" = "Add or edit existe image in Room ressource",
  *                    "requestBody" = {
 *                          "content" = {
 *                              "multipart/form-data" = {
 *                                  "schema" = {
 *                                      "type" = "object",
 *                                      "properties" = {
 *                                          "imageFile" = {
 *                                              "type" = "string",
 *                                              "format" = "binary",
 *                                           },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      },
 *                 },
  *   }, 
  * }
  *
  *)
 *  @Vich\Uploadable
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer") 
     * @Groups("room:read")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",unique=true)
     * 
     * @Groups({"room:read","room:write"})
     * @Assert\NotBlank(message="Un numéro de chambre est obligatoire !")
     * @Assert\Positive(message="La valeur doit être positive !")
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"room:read","room:write"})
     * @Assert\NotBlank(message="Un type de chambre est obligatoire !")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le type de chambre doit contenir {{ limit }} caractères mini",
     *      maxMessage = "Le type de chambre ne doit pas excéder {{ limit }} caractères"
     * )
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups({"room:read","room:write"})
     * @Assert\NotBlank(message="Un prix est obligatoire !")
     * @Assert\Positive(message="La valeur doit être positive !")
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Booking::class, mappedBy="rooms")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    * @var string
    */
    private $image;

    /**
     * @Vich\UploadableField(mapping="room", fileNameProperty="image")
     * @Groups({"room:write"})
     * @var File |null
     */
    private $imageFile;

    /**
    * @ORM\Column(type="datetime")
    *@Groups("room:read")
    */
    private $createdAt;

    /** 
   * @Groups({"room:read"})
   */
    private $imageUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->addRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeRoom($this);
        }

        return $this;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
    $this->image = $image;
        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime();
        return $this;
    }
    public function getImageFile()
    {
        return $this->imageFile;
    }
        
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->createdAt = new \DateTime('now');
        }
    }


    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl):Room
    {
    $this->imageUrl = $imageUrl;
        return $this;
    }
}
