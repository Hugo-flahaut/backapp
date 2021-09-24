<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 * @ApiResource(
 *     normalizationContext={"groups"={"room:read"}},
 *     denormalizationContext={"groups"={"room:write"}}))
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
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
}
