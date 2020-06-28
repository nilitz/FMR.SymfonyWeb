<?php

namespace App\Entity;

use App\Repository\ToolTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToolTypeRepository::class)
 */
class ToolType
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
     * @ORM\ManyToMany(targetEntity=Box::class, inversedBy="toolTypes")
     */
    private $box;

    /**
     * @ORM\OneToMany(targetEntity=Inventory::class, mappedBy="toolType")
     */
    private $inventories;

    public function __construct()
    {
        $this->box = new ArrayCollection();
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

    /**
     * @return Collection|Box[]
     */
    public function getBox(): Collection
    {
        return $this->box;
    }

    public function addBox(Box $box): self
    {
        if (!$this->box->contains($box)) {
            $this->box[] = $box;
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        if ($this->box->contains($box)) {
            $this->box->removeElement($box);
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
            $inventory->setToolType($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->contains($inventory)) {
            $this->inventories->removeElement($inventory);
            // set the owning side to null (unless already changed)
            if ($inventory->getToolType() === $this) {
                $inventory->setToolType(null);
            }
        }

        return $this;
    }
}
