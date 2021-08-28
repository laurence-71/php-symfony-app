<?php

namespace App\Entity;

use App\Repository\TransformationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransformationRepository::class)
 */
class Transformation
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
    private $article_label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $destination;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Recycling::class, inversedBy="transformations")
     */
    private $recycling;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleLabel(): ?string
    {
        return $this->article_label;
    }

    public function setArticleLabel(?string $article_label): self
    {
        $this->article_label = $article_label;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
    {
        $this->destination = $destination;

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
