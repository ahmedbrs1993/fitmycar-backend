<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['name', 'brand'], message: 'This model already exists.')]
#[ORM\Entity]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'models')]
    #[ORM\JoinColumn(nullable: false)]
    private Brand $brand;

    /**
     * @var Collection<int, Generation>
     */
    #[ORM\OneToMany(targetEntity: Generation::class, mappedBy: 'model', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $generations;

    public function __construct()
    {
        $this->generations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, Generation>
     */
    public function getGenerations(): Collection
    {
        return $this->generations;
    }

    public function addGeneration(Generation $generation): static
    {
        if (!$this->generations->contains($generation)) {
            $this->generations->add($generation);
            $generation->setModel($this);
        }

        return $this;
    }

    public function removeGeneration(Generation $generation): static
    {
        return $this;
    }

    public function __toString(): string
    {
        $brandName = $this->getBrand()->getName();

        return sprintf('%s - %s', $brandName, $this->getName());
    }
}
