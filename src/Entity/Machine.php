<?php

namespace App\Entity;

use App\Repository\MachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MachineRepository::class)
 */
class Machine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_rentable;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_hours_per_use;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="machines")
     * @ORM\JoinColumn(nullable=true)
     */
    private $skill;

    /**
     * @ORM\OneToMany(targetEntity=RentMachine::class, mappedBy="machine", orphanRemoval=true)
     */
    private $rentMachines;

    public function __construct()
    {
        $this->rentMachines = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->name = $color;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIsRentable(): ?bool
    {
        return $this->is_rentable;
    }

    public function setIsRentable(bool $is_rentable): self
    {
        $this->is_rentable = $is_rentable;

        return $this;
    }

    public function getMaxHoursPerUse(): ?int
    {
        return $this->max_hours_per_use;
    }

    public function setMaxHoursPerUse(int $max_hours_per_use): self
    {
        $this->max_hours_per_use = $max_hours_per_use;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection|RentMachine[]
     */
    public function getRentMachines(): Collection
    {
        return $this->rentMachines;
    }

    public function addRentMachine(RentMachine $rentMachine): self
    {
        if (!$this->rentMachines->contains($rentMachine)) {
            $this->rentMachines[] = $rentMachine;
            $rentMachine->setMachine($this);
        }

        return $this;
    }

    public function removeRentMachine(RentMachine $rentMachine): self
    {
        if ($this->rentMachines->contains($rentMachine)) {
            $this->rentMachines->removeElement($rentMachine);
            // set the owning side to null (unless already changed)
            if ($rentMachine->getMachine() === $this) {
                $rentMachine->setMachine(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
