<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $receptionDate;

    /**
     * @ORM\ManyToOne(targetEntity=Bike::class, inversedBy="operations")
     */
    private $bike;

    /**
     * @ORM\ManyToMany(targetEntity=Operator::class, mappedBy="operation")
     */
    private $operators;

    /**
     * @ORM\OneToOne(targetEntity=Recycling::class, inversedBy="operation", cascade={"persist", "remove"})
     */
    private $recycling;

    /**
     * @ORM\OneToOne(targetEntity=Repair::class, inversedBy="operation", cascade={"persist", "remove"})
     */
    private $repair;

    /**
     * @ORM\OneToOne(targetEntity=Billing::class, inversedBy="operation", cascade={"persist", "remove"})
     */
    private $billing;

    public function __construct()
    {
        $this->operators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceptionDate(): ?\DateTimeInterface
    {
        return $this->receptionDate;
    }

    public function setReceptionDate(?\DateTimeInterface $receptionDate): self
    {
        $this->receptionDate = $receptionDate;

        return $this;
    }

    public function getBike(): ?Bike
    {
        return $this->bike;
    }

    public function setBike(?Bike $bike): self
    {
        $this->bike = $bike;

        return $this;
    }

    /**
     * @return Collection|Operator[]
     */
    public function getOperators(): Collection
    {
        return $this->operators;
    }

    public function addOperator(Operator $operator): self
    {
        if (!$this->operators->contains($operator)) {
            $this->operators[] = $operator;
            $operator->addOperation($this);
        }

        return $this;
    }

    public function removeOperator(Operator $operator): self
    {
        if ($this->operators->removeElement($operator)) {
            $operator->removeOperation($this);
        }

        return $this;
    }

    public function getRecycling(): ?Recycling
    {
        return $this->recycling;
    }

    public function setRecycling(?Recycling $recycling): self
    {
        $this->recycling = $recycling;

        return $this;
    }

    public function getRepair(): ?Repair
    {
        return $this->repair;
    }

    public function setRepair(?Repair $repair): self
    {
        $this->repair = $repair;

        return $this;
    }

    public function getBilling(): ?Billing
    {
        return $this->billing;
    }

    public function setBilling(?Billing $billing): self
    {
        $this->billing = $billing;

        return $this;
    }
}
