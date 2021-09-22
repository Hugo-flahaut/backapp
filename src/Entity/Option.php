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
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 *  @ApiResource(
 *     normalizationContext={"groups"={"option:read"}},
 *     denormalizationContext={"groups"={"option:write"}})
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("option:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"option:read","option:write"})
     * @Assert\NotBlank(message="Un nom d'option est obligatoire !")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom de l'option doit contenir {{ limit }} caractères mini",
     *      maxMessage = "Le nom de l'option ne doit pas excéder {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"option:read","option:write"})
     * @Assert\NotBlank(message="Un prix est obligatoire !")
     * @Assert\Positive(message="La valeur doit être positive !")
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Booking::class, mappedBy="options")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $booking->addOption($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeOption($this);
        }

        return $this;
    }
}
