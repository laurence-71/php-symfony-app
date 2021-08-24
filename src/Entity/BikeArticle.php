<?php

namespace App\Entity;

use App\Repository\BikeArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BikeArticleRepository::class)
 */
class BikeArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $main = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $brake = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $wheel = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $transmission = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $crank = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $security = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Repair::class, inversedBy="bikeArticles")
     */
    private $repair;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMain(): ?array
    {
        return $this->main;
    }

    public function setMain(?array $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getBrake(): ?array
    {
        return $this->brake;
    }

    public function setBrake(?array $brake): self
    {
        $this->brake = $brake;

        return $this;
    }

    public function getWheel(): ?array
    {
        return $this->wheel;
    }

    public function setWheel(?array $wheel): self
    {
        $this->wheel = $wheel;

        return $this;
    }

    public function getTransmission(): ?array
    {
        return $this->transmission;
    }

    public function setTransmission(?array $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getCrank(): ?array
    {
        return $this->crank;
    }

    public function setCrank(?array $crank): self
    {
        $this->crank = $crank;

        return $this;
    }

    public function getSecurity(): ?array
    {
        return $this->security;
    }

    public function setSecurity(?array $security): self
    {
        $this->security = $security;

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

    public function getRepair(): ?Repair
    {
        return $this->repair;
    }

    public function setRepair(?Repair $repair): self
    {
        $this->repair = $repair;

        return $this;
    }
}
