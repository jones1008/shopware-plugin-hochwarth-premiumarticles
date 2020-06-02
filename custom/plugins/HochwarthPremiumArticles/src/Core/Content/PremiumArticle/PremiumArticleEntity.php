<?php declare(strict_types=1);

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\Content\Product\ProductDefinition;

class PremiumArticleEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @var double
     */
    protected $minPrice;

    /**
     * @var ProductDefinition
     */
    protected $product;

    /**
     * @var boolean
     */
    protected $automaticAdd;


    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return float
     */
    public function getMinPrice(): float
    {
        return $this->minPrice;
    }

    /**
     * @param float $minPrice
     */
    public function setMinPrice(float $minPrice): void
    {
        $this->minPrice = $minPrice;
    }

    /**
     * @return bool
     */
    public function isAutomaticAdd(): bool
    {
        return $this->automaticAdd;
    }

    /**
     * @param bool $automaticAdd
     */
    public function setAutomaticAdd(bool $automaticAdd): void
    {
        $this->automaticAdd = $automaticAdd;
    }

    /**
     * @return ProductDefinition
     */
    public function getProduct(): ProductDefinition
    {
        return $this->product;
    }

    /**
     * @param ProductDefinition $product
     */
    public function setProduct(ProductDefinition $product): void
    {
        $this->product = $product;
    }
}
