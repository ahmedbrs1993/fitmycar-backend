<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['name', 'model'], message: 'This generation already exists for this model.')]
#[ORM\Entity]
class Generation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'generations')]
    #[ORM\JoinColumn(nullable: false)]
    private Model $model;

    /**
     * @var Collection<int, FuelType>
     */
    #[ORM\OneToMany(targetEntity: FuelType::class, mappedBy: 'generation', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $fuelTypes;

    public function __construct()
    {
        $this->fuelTypes = new ArrayCollection();
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

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getBrandName(): ?string
    {
        return $this->model->getBrand()->getName();
    }

    /**
     * @return Collection<int, FuelType>
     */
    public function getFuelTypes(): Collection
    {
        return $this->fuelTypes;
    }

    public function addFuelType(FuelType $fuelType): static
    {
        if (!$this->fuelTypes->contains($fuelType)) {
            $this->fuelTypes->add($fuelType);
            $fuelType->setGeneration($this);
        }

        return $this;
    }

    public function removeFuelType(FuelType $fuelType): static
    {
        return $this;
    }

    public function __toString(): string
    {
        $modelName = $this->getModel()->getName();
        $brandName = $this->getModel()->getBrand()->getName();

        return sprintf('%s - %s - %s', $brandName, $modelName, $this->getName());
    }
}
