<?php

namespace App\Entity;

use App\Repository\RepairRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=BikeArticle::class, mappedBy="repair")
     */
    private $bikeArticles;

   

    

    public function __construct()
    {
        $this->bikeArticles = new ArrayCollection();
    }

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

    /**
     * @return Collection|BikeArticle[]
     */
    public function getBikeArticles(): Collection
    {
        return $this->bikeArticles;
    }

    public function addBikeArticle(BikeArticle $bikeArticle): self
    {
        if (!$this->bikeArticles->contains($bikeArticle)) {
            $this->bikeArticles[] = $bikeArticle;
            $bikeArticle->setRepair($this);
        }

        return $this;
    }

    public function removeBikeArticle(BikeArticle $bikeArticle): self
    {
        if ($this->bikeArticles->removeElement($bikeArticle)) {
            // set the owning side to null (unless already changed)
            if ($bikeArticle->getRepair() === $this) {
                $bikeArticle->setRepair(null);
            }
        }

        return $this;
    }

   

   
   
}
