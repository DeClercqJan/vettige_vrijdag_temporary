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
class Category implements JsonSerializable
{
    use IdTrait;
    use NameTrait;
    use CreatedOnTrait;
    use UpdatedOnTrait;

    /**
     * @ORM\Column(type="string")
     */
    private string $icon;

    /**
     * @ORM\Column(type="string")
     */
    private string $image;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category",  orphanRemoval=true)
     */
    private Collection $products;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isHistorical;

    /**
     * @ORM\ManyToMany (targetEntity="Category", inversedBy="isHistoricalVersionOf")
     * @ORM\JoinTable(name="category_versions",
     *      joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_old_id", referencedColumnName="id")}
     *      )
     */
    private ?Collection $historicalVersions;

    /**
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="historicalVersions", cascade={"persist"})
     */
    private ?Collection $isHistoricalVersionOf;

    public function __construct(
        string $name,
        string $icon,
        string $image
    ) {
        $this->name = $name;
        $this->icon = $icon;
        $this->image = $image;
        $this->products = new ArrayCollection();
        $this->isHistorical = false;
        $this->historicalVersions = new ArrayCollection();
        $this->isHistoricalVersionOf = new ArrayCollection();
    }

    public function archive(): void
    {
        $this->isHistorical = true;
    }

    public function addToHistoricalVersion(Category $category): void
    {
//        dd($category);
//        if (!($category === $this) && (!$this->historicalVersions->contains($category))) {
        if (!$this->historicalVersions->contains($category)) {
            $this->historicalVersions->add($category);
            $category->addToIsHistoricalVersionOf($this);
        }
    }

    public function getHistoricalVersions(): ?Collection
    {
        return $this->historicalVersions;
    }

    public function addToIsHistoricalVersionOf(Category $category): void
    {
//        dd("$this is historical version of $category");
//        if (!($category === $this) && (!$this->isHistoricalVersionOf->contains($category))) {
        if (!$this->isHistoricalVersionOf->contains($category)) {
            $this->isHistoricalVersionOf->add($category);
        }
    }

    public function getIsHistoricalVersionOf(): ?Collection
    {
        return $this->isHistoricalVersionOf;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getProducts(): Collection
    {
        return $this->products;
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
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->icon,
            'image' => $this->image,
            'products' => $this->products->toArray(),
        ];
    }
}
