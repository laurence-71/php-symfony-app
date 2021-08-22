<?php

namespace App\Entity;

use App\Repository\BillingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BillingRepository::class)
 */
class Billing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $billingDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Operation::class, mappedBy="billing", cascade={"persist", "remove"})
     */
    private $operation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillingDate(): ?\DateTimeInterface
    {
        return $this->billingDate;
    }

    public function setBillingDate(?\DateTimeInterface $billingDate): self
    {
        $this->billingDate = $billingDate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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
            $this->operation->setBilling(null);
        }

        // set the owning side of the relation if necessary
        if ($operation !== null && $operation->getBilling() !== $this) {
            $operation->setBilling($this);
        }

        $this->operation = $operation;

        return $this;
    }
}
