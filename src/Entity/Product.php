<?php

namespace App\Entity;

use App\Traits\CreatedOnTrait;
use App\Traits\IdTrait;
use App\Traits\NameTrait;
use App\Traits\UpdatedOnTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Product implements JsonSerializable
{
    use IdTrait;
    use NameTrait;
    use CreatedOnTrait;
    use UpdatedOnTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products", cascade={"persist"})
     */
    private Category $category;

    /**
     * @ORM\OneToMany(targetEntity="OrderLine", mappedBy="product", orphanRemoval=true )
     */
    private Collection $orderLines;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isHistorical;

    /**
     * @ORM\ManyToMany (targetEntity="Product", inversedBy="isHistoricalVersionOf")
     * @ORM\JoinTable(name="product_versions",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_old_id", referencedColumnName="id")}
     *      )
     */
    private ?Collection $historicalVersions;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="historicalVersions", cascade={"persist"})
     */
    private ?Collection $isHistoricalVersionOf;

    public function __construct(
        string $name,
        Category $category
    ) {
        $this->name = $name;
        $this->category = $category;
        $this->orderLines = new ArrayCollection();
        $this->isHistorical = false;
        $this->historicalVersions = new ArrayCollection();
        $this->isHistoricalVersionOf = new ArrayCollection();
    }

    public function archive(): void
    {
        $this->isHistorical = true;
    }

    public function addToHistoricalVersion(Product $product): void
    {
//        dd($product);
//        if (!($product === $this) && (!$this->historicalVersions->contains($product))) {
        if (!$this->historicalVersions->contains($product)) {
            $this->historicalVersions->add($product);
            $product->addToIsHistoricalVersionOf($this);
        }
    }

    public function getHistoricalVersions(): ?Collection
    {
        return $this->historicalVersions;
    }

    public function addToIsHistoricalVersionOf(Product $product): void
    {
//        dd("$this is historical version of $product");
//        if (!($product === $this) && (!$this->isHistoricalVersionOf->contains($product))) {
        if (!$this->isHistoricalVersionOf->contains($product)) {
            $this->isHistoricalVersionOf->add($product);
        }
    }

    public function getIsHistoricalVersionOf(): ?Collection
    {
        return $this->isHistoricalVersionOf;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getIshistorical(): bool
    {
        return $this->isHistorical;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}

