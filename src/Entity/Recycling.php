<?php

namespace App\Entity;

use App\Repository\RecyclingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=SecondHandStock::class, mappedBy="recycling")
     */
    private $secondHandStocks;

    public function __construct()
    {
        $this->secondHandStocks = new ArrayCollection();
    }

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

    /**
     * @return Collection|SecondHandStock[]
     */
    public function getSecondHandStocks(): Collection
    {
        return $this->secondHandStocks;
    }

    public function addSecondHandStock(SecondHandStock $secondHandStock): self
    {
        if (!$this->secondHandStocks->contains($secondHandStock)) {
            $this->secondHandStocks[] = $secondHandStock;
            $secondHandStock->setRecycling($this);
        }

        return $this;
    }

    public function removeSecondHandStock(SecondHandStock $secondHandStock): self
    {
        if ($this->secondHandStocks->removeElement($secondHandStock)) {
            // set the owning side to null (unless already changed)
            if ($secondHandStock->getRecycling() === $this) {
                $secondHandStock->setRecycling(null);
            }
        }

        return $this;
    }
}
