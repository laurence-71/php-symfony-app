<?php

namespace App\Entity;

use App\Repository\OperatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperatorRepository::class)
 */
class Operator
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity=Operation::class, inversedBy="operators")
     */
    private $operation;

    public function __construct()
    {
        $this->operation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperation(): Collection
    {
        return $this->operation;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operation->contains($operation)) {
            $this->operation[] = $operation;
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        $this->operation->removeElement($operation);

        return $this;
    }
}
