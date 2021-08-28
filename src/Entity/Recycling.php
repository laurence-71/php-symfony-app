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

    /**
     * @ORM\OneToMany(targetEntity=Transformation::class, mappedBy="recycling")
     */
    private $transformations;

    /**
     * @ORM\OneToMany(targetEntity=Trash::class, mappedBy="recycling")
     */
    private $trashes;

    public function __construct()
    {
        $this->secondHandStocks = new ArrayCollection();
        $this->transformations = new ArrayCollection();
        $this->trashes = new ArrayCollection();
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

    /**
     * @return Collection|Transformation[]
     */
    public function getTransformations(): Collection
    {
        return $this->transformations;
    }

    public function addTransformation(Transformation $transformation): self
    {
        if (!$this->transformations->contains($transformation)) {
            $this->transformations[] = $transformation;
            $transformation->setRecycling($this);
        }

        return $this;
    }

    public function removeTransformation(Transformation $transformation): self
    {
        if ($this->transformations->removeElement($transformation)) {
            // set the owning side to null (unless already changed)
            if ($transformation->getRecycling() === $this) {
                $transformation->setRecycling(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trash[]
     */
    public function getTrashes(): Collection
    {
        return $this->trashes;
    }

    public function addTrash(Trash $trash): self
    {
        if (!$this->trashes->contains($trash)) {
            $this->trashes[] = $trash;
            $trash->setRecycling($this);
        }

        return $this;
    }

    public function removeTrash(Trash $trash): self
    {
        if ($this->trashes->removeElement($trash)) {
            // set the owning side to null (unless already changed)
            if ($trash->getRecycling() === $this) {
                $trash->setRecycling(null);
            }
        }

        return $this;
    }
}
