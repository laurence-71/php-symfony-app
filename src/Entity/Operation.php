<?php

namespace App\Entity;

use App\Repository\OperationRepository;
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
}
