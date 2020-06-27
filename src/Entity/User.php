<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_admin;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user", orphanRemoval=true)
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, mappedBy="user")
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity=RentMachine::class, mappedBy="user", orphanRemoval=true)
     */
    private $rentMachines;

    /**
     * @ORM\OneToMany(targetEntity=RentTool::class, mappedBy="user", orphanRemoval=true)
     */
    private $rentTools;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->rentMachines = new ArrayCollection();
        $this->rentTools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addUser($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            $skill->removeUser($this);
        }

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
            $rentMachine->setUser($this);
        }

        return $this;
    }

    public function removeRentMachine(RentMachine $rentMachine): self
    {
        if ($this->rentMachines->contains($rentMachine)) {
            $this->rentMachines->removeElement($rentMachine);
            // set the owning side to null (unless already changed)
            if ($rentMachine->getUser() === $this) {
                $rentMachine->setUser(null);
            }
        }

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
            $rentTool->setUser($this);
        }

        return $this;
    }

    public function removeRentTool(RentTool $rentTool): self
    {
        if ($this->rentTools->contains($rentTool)) {
            $this->rentTools->removeElement($rentTool);
            // set the owning side to null (unless already changed)
            if ($rentTool->getUser() === $this) {
                $rentTool->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        if ($this->is_admin == false)
        {
            return ['ROLE_USER'];
        }
        else if ($this->is_admin == true)
        {
            return ['ROLE_ADMIN'];
        }
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
