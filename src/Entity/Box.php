<?php

namespace App\Entity;

use App\Repository\BoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoxRepository::class)
 */
class Box
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=ToolType::class, mappedBy="box")
     */
    private $toolTypes;

    /**
     * @ORM\OneToMany(targetEntity=Inventory::class, mappedBy="box")
     */
    private $inventories;

    public function __construct()
    {
        $this->toolTypes = new ArrayCollection();
        $this->inventories = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ToolType[]
     */
    public function getToolTypes(): Collection
    {
        return $this->toolTypes;
    }

    public function addToolType(ToolType $toolType): self
    {
        if (!$this->toolTypes->contains($toolType)) {
            $this->toolTypes[] = $toolType;
            $toolType->addBox($this);
        }

        return $this;
    }

    public function removeToolType(ToolType $toolType): self
    {
        if ($this->toolTypes->contains($toolType)) {
            $this->toolTypes->removeElement($toolType);
            $toolType->removeBox($this);
        }

        return $this;
    }

    /**
     * @return Collection|Inventory[]
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setBox($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->contains($inventory)) {
            $this->inventories->removeElement($inventory);
            // set the owning side to null (unless already changed)
            if ($inventory->getBox() === $this) {
                $inventory->setBox(null);
            }
        }

        return $this;
    }
}
