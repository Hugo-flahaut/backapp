<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"booking:read"}},
 *  denormalizationContext={"groups"={"booking:write"}}
 * )
 * @ORM\Entity(repositoryClass=BookingRepository::class) 
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("booking:read")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"booking:read", "booking:write"})
     * @Assert\NotBlank(message ="ce champs  est obligatoire")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date")
     * @Groups({"booking:read", "booking:write"})
     * @Assert\NotBlank(message ="ce champs  est obligatoire")
     */
    private $endDate;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("booking:read")
     * @Assert\NotBlank(message ="ce champs  est obligatoire")
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     * @Groups({"booking:read"})
     * @Assert\NotBlank(message ="ce champs est obligatoire")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("booking:read")
     * @Assert\NotBlank(message ="ce champs est obligatoire")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message ="ce champs  est obligatoire")
     * @Groups({"read"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Room::class, inversedBy="bookings")
     * @Assert\NotBlank(message ="ce champs  est obligatoire")
     */
    private $rooms;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="bookings")
     * @Assert\NotBlank(message ="ce champs  est obligatoire")
     */
    private $options;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $rooms): self
    {
        if (!$this->rooms->contains($rooms)) {
            $this->rooms[] = $rooms;
        }

        return $this;
    }

    public function removeRoom(Room $rooms): self
    {
        $this->rooms->removeElement($rooms);

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }
}
