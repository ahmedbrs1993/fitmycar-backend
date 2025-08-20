<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $brand;

    #[ORM\Column(length: 255)]
    private string $image;

    #[ORM\Column]
    private float $price;

    /**
     * @var list<string>
     */
    #[ORM\Column(type: 'json')]
    private array $specs = [];

    #[ORM\Column(length: 255)]
    private string $category;

    /**
     * @var Collection<int, ProductCompatibility>
     */
    #[ORM\OneToMany(targetEntity: ProductCompatibility::class, mappedBy: 'product')]
    private Collection $productCompatibilities;

    public function __construct()
    {
        $this->productCompatibilities = new ArrayCollection();
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

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return list<string>
     */
    public function getSpecs(): array
    {
        return $this->specs;
    }

    /**
     * @param list<string> $specs
     */
    public function setSpecs(array $specs): static
    {
        $this->specs = $specs;

        return $this;
    }

    public function getSpecsFormatted(): ?string
    {
        return implode("\n", $this->specs ?? []);
    }

    public function setSpecsFormatted(?string $value): static
    {
        $normalized = str_replace(["\r\n", "\r"], "\n", $value ?? '');
        $decoded = html_entity_decode($normalized, ENT_QUOTES | ENT_HTML5);
        $withLineBreaks = preg_replace('/<(br|div|\/p)[^>]*>/i', "\n", $decoded);
        $cleaned = strip_tags($withLineBreaks ?? '');
        $lines = array_values(array_filter(array_map('trim', explode("\n", $cleaned))));

        $this->specs = $lines;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ProductCompatibility>
     */
    public function getProductCompatibilities(): Collection
    {
        return $this->productCompatibilities;
    }

    public function addProductCompatibility(ProductCompatibility $productCompatibility): static
    {
        if (!$this->productCompatibilities->contains($productCompatibility)) {
            $this->productCompatibilities->add($productCompatibility);
            $productCompatibility->setProduct($this);
        }

        return $this;
    }

    public function removeProductCompatibility(ProductCompatibility $productCompatibility): static
    {
        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
