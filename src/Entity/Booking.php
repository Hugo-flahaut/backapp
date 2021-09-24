<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"booking:read"}},
 *  denormalizationContext={"groups"={"booking:write"}},
 *  attributes={
 *   "order"={"createdAt":"DESC"}
 *  },
 * itemOperations={
 *  "get" = { "security" = "is_granted('show', object)" ,"security_message"="Sorry,you are not the adding of this booking. "},
 *  "delete" = { "security" = "is_granted('delete', object)","security_message"="Sorry,you are not the adding of this booking. "},
 *  "put" = { "security" = "is_granted('edit', object)",
 *             "security_message"="Sorry,you are not the adding of this booking so you can not editing",
 *             "denormalization_context"={"groups"={"update:booking"}}
 *  }
*  }
 * )
 * @ApiFilter(SearchFilter::class,properties={"user":"exact"})
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
     * @Assert\GreaterThan(propertyPath="dateStart", message="la date de fin doit  être supèrieure à la date de début")
     */
    private $endDate;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"booking:read"})
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     * @Groups({"booking:read", "booking:write"})
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"booking:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"booking:read","booking:write"})
     * @Assert\NotBlank(message ="ce champs  est obligatoire") 
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Room::class, inversedBy="bookings")
     * @Groups({"booking:read", "booking:write"})
     * @Assert\NotBlank(message ="ce champs est obligatoire")
     * 
     */
    private $rooms;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="bookings")
     * @Groups({"booking:read", "booking:write"})
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
