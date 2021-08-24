<?php

namespace App\Entity;

use App\Repository\RequirementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequirementRepository::class)
 */
class Requirement
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
    private $requirementDate;

    /**
     * @ORM\OneToMany(targetEntity=NewStock::class, mappedBy="requirement")
     */
    private $newStocks;

    /**
     * @ORM\OneToMany(targetEntity=SecondHandStock::class, mappedBy="requirement")
     */
    private $secondHandStocks;

    public function __construct()
    {
        $this->newStocks = new ArrayCollection();
        $this->secondHandStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequirementDate(): ?\DateTimeInterface
    {
        return $this->requirementDate;
    }

    public function setRequirementDate(?\DateTimeInterface $requirementDate): self
    {
        $this->requirementDate = $requirementDate;

        return $this;
    }

    /**
     * @return Collection|NewStock[]
     */
    public function getNewStocks(): Collection
    {
        return $this->newStocks;
    }

    public function addNewStock(NewStock $newStock): self
    {
        if (!$this->newStocks->contains($newStock)) {
            $this->newStocks[] = $newStock;
            $newStock->setRequirement($this);
        }

        return $this;
    }

    public function removeNewStock(NewStock $newStock): self
    {
        if ($this->newStocks->removeElement($newStock)) {
            // set the owning side to null (unless already changed)
            if ($newStock->getRequirement() === $this) {
                $newStock->setRequirement(null);
            }
        }

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
            $secondHandStock->setRequirement($this);
        }

        return $this;
    }

    public function removeSecondHandStock(SecondHandStock $secondHandStock): self
    {
        if ($this->secondHandStocks->removeElement($secondHandStock)) {
            // set the owning side to null (unless already changed)
            if ($secondHandStock->getRequirement() === $this) {
                $secondHandStock->setRequirement(null);
            }
        }

        return $this;
    }
}
