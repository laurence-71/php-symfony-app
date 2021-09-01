<?php

namespace App\Entity;

use App\Repository\NewStockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewStockRepository::class)
 */
class NewStock
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
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $unit_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Requirement::class, inversedBy="newStocks")
     */
    private $requirement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $requirement_quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(?float $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRequirement(): ?Requirement
    {
        return $this->requirement;
    }

    public function setRequirement(?Requirement $requirement): self
    {
        $this->requirement = $requirement;

        return $this;
    }

    public function getRequirementQuantity(): ?int
    {
        return $this->requirement_quantity;
    }

    public function setRequirementQuantity(?int $requirement_quantity): self
    {
        $this->requirement_quantity = $requirement_quantity;

        return $this;
    }
}
