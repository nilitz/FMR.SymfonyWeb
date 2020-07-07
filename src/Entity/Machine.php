<?php

namespace App\Entity;

use App\Repository\MachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=MachineRepository::class)
 * @Vich\Uploadable()
 * @UniqueEntity("name")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File
     * @Vich\UploadableField(mapping="machine_image", fileNameProperty="filename")
     */
    private $imageFile;


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

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

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

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Machine
     */
    public function setFilename(?string $filename): Machine
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     * @return Machine
     */
    public function setImageFile(?File $imageFile): Machine
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceOf UploadedFile)
        {
            $this->updated_at = new \DateTime('now');
        }
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
