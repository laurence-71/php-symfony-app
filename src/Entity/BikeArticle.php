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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $main;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brake;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wheel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transmission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $crank;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $security;

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

    public function getMain(): ?string
    {
        return $this->main;
    }

    public function setMain(?string $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getBrake(): ?string
    {
        return $this->brake;
    }

    public function setBrake(?string $brake): self
    {
        $this->brake = $brake;

        return $this;
    }

    public function getWheel(): ?string
    {
        return $this->wheel;
    }

    public function setWheel(?string $wheel): self
    {
        $this->wheel = $wheel;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(?string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getCrank(): ?string
    {
        return $this->crank;
    }

    public function setCrank(?string $crank): self
    {
        $this->crank = $crank;

        return $this;
    }

    public function getSecurity(): ?string
    {
        return $this->security;
    }

    public function setSecurity(?string $security): self
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
