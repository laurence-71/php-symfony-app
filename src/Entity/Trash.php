<?php

namespace App\Entity;

use App\Repository\TrashRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrashRepository::class)
 */
class Trash
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nature;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity=Recycling::class, inversedBy="trashes")
     */
    private $recycling;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

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
}
