<?php

namespace App\Entity;

use App\Repository\RecyclingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecyclingRepository::class)
 */
class Recycling
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
    private $recyclingDate;

    /**
     * @ORM\OneToOne(targetEntity=Operation::class, mappedBy="recycling", cascade={"persist", "remove"})
     */
    private $operation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecyclingDate(): ?\DateTimeInterface
    {
        return $this->recyclingDate;
    }

    public function setRecyclingDate(\DateTimeInterface $recyclingDate): self
    {
        $this->recyclingDate = $recyclingDate;

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
            $this->operation->setRecycling(null);
        }

        // set the owning side of the relation if necessary
        if ($operation !== null && $operation->getRecycling() !== $this) {
            $operation->setRecycling($this);
        }

        $this->operation = $operation;

        return $this;
    }
}
