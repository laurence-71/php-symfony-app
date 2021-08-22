<?php

namespace App\Entity;

use App\Repository\RepairRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepairRepository::class)
 */
class Repair
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $takingCareDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $doneDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $laborCost;

   

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $validation;

    /**
     * @ORM\OneToOne(targetEntity=Operation::class, mappedBy="repair", cascade={"persist", "remove"})
     */
    private $operation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTakingCareDate(): ?\DateTimeInterface
    {
        return $this->takingCareDate;
    }

    public function setTakingCareDate(\DateTimeInterface $takingCareDate): self
    {
        $this->takingCareDate = $takingCareDate;

        return $this;
    }

    public function getDoneDate(): ?\DateTimeInterface
    {
        return $this->doneDate;
    }

    public function setDoneDate(?\DateTimeInterface $doneDate): self
    {
        $this->doneDate = $doneDate;

        return $this;
    }

    public function getLaborCost(): ?float
    {
        return $this->laborCost;
    }

    public function setLaborCost(?float $laborCost): self
    {
        $this->laborCost = $laborCost;

        return $this;
    }

   

  
    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(?bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        // unset the owning side of the relation if necessary
        if ($operation === null && $this->operation !== null) {
            $this->operation->setRepair(null);
        }

        // set the owning side of the relation if necessary
        if ($operation !== null && $operation->getRepair() !== $this) {
            $operation->setRepair($this);
        }

        $this->operation = $operation;

        return $this;
    }
}
