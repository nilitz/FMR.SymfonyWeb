<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=ToolType::class, inversedBy="inventories")
     */
    private $toolType;

    /**
     * @ORM\ManyToOne(targetEntity=Box::class, inversedBy="inventories")
     */
    private $box;

    /**
     * @ORM\OneToMany(targetEntity=RentTool::class, mappedBy="inventory", orphanRemoval=true)
     */
    private $rentTools;

    public function __construct()
    {
        $this->rentTools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getToolType(): ?ToolType
    {
        return $this->toolType;
    }

    public function setToolType(?ToolType $toolType): self
    {
        $this->toolType = $toolType;

        return $this;
    }

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): self
    {
        $this->box = $box;

        return $this;
    }

    /**
     * @return Collection|RentTool[]
     */
    public function getRentTools(): Collection
    {
        return $this->rentTools;
    }

    public function addRentTool(RentTool $rentTool): self
    {
        if (!$this->rentTools->contains($rentTool)) {
            $this->rentTools[] = $rentTool;
            $rentTool->setInventory($this);
        }

        return $this;
    }

    public function removeRentTool(RentTool $rentTool): self
    {
        if ($this->rentTools->contains($rentTool)) {
            $this->rentTools->removeElement($rentTool);
            // set the owning side to null (unless already changed)
            if ($rentTool->getInventory() === $this) {
                $rentTool->setInventory(null);
            }
        }

        return $this;
    }
}
