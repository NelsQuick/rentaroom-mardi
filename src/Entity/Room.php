<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\ManyToMany(targetEntity: software::class, inversedBy: 'rooms')]
    private Collection $software;

    #[ORM\ManyToMany(targetEntity: ergonomics::class, inversedBy: 'rooms')]
    private Collection $ergonomics;

    #[ORM\ManyToMany(targetEntity: material::class, inversedBy: 'rooms')]
    private Collection $material;

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->reservations = new ArrayCollection();
        $this->software = new ArrayCollection();
        $this->ergonomics = new ArrayCollection();
        $this->material = new ArrayCollection();
        $this->entityManager = $entityManager;
    }

    public function __toString(): string
    {
        return $this->getName();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRoom($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRoom() === $this) {
                $reservation->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, software>
     */
    public function getSoftware(): Collection
    {
        return $this->software;
    }

    public function addSoftware(software $software): self
    {
        if (!$this->software->contains($software)) {
            $this->software->add($software);
        }

        return $this;
    }

    public function removeSoftware(software $software): self
    {
        $this->software->removeElement($software);

        return $this;
    }

    /**
     * @return Collection<int, ergonomics>
     */
    public function getErgonomics(): Collection
    {
        return $this->ergonomics;
    }

    public function addErgonomic(ergonomics $ergonomic): self
    {
        if (!$this->ergonomics->contains($ergonomic)) {
            $this->ergonomics->add($ergonomic);
        }

        return $this;
    }

    public function removeErgonomic(ergonomics $ergonomic): self
    {
        $this->ergonomics->removeElement($ergonomic);

        return $this;
    }

    /**
     * @return Collection<int, material>
     */
    public function getMaterial(): Collection
    {
        return $this->material;
    }

    public function addMaterial(material $material): self
    {
        if (!$this->material->contains($material)) {
            $this->material->add($material);
        }

        return $this;
    }

    public function removeMaterial(material $material): self
    {
        $this->material->removeElement($material);

        return $this;
    }
}