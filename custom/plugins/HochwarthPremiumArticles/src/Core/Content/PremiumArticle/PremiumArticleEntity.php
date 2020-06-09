<?php declare(strict_types=1);

namespace HochwarthPremiumArticles\Core\Content\PremiumArticle;

use Shopware\Core\Checkout\Customer\Aggregate\CustomerGroup\CustomerGroupEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;

class PremiumArticleEntity extends Entity
{
    use EntityIdTrait;

    /** @var bool */
    protected $active;

    /** @var double */
    protected $minPrice;

    /** @var string */
    protected $productId;

    /** @var ProductEntity */
    protected $product;

    /** @var boolean */
    protected $automaticAdd;

    /** @var CustomerGroupEntity */
    protected $customerGroups;

    /** @var SalesChannelEntity */
    protected $salesChannels;

    /** @return bool */
    public function isActive(): bool
    {
        return $this->active;
    }

    /** @param bool $active */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /** @return float */
    public function getMinPrice(): float
    {
        return $this->minPrice;
    }

    /** @param float $minPrice */
    public function setMinPrice(float $minPrice): void
    {
        $this->minPrice = $minPrice;
    }

    /** @return bool */
    public function isAutomaticAdd(): bool
    {
        return $this->automaticAdd;
    }

    /** @param bool $automaticAdd */
    public function setAutomaticAdd(bool $automaticAdd): void
    {
        $this->automaticAdd = $automaticAdd;
    }

    /** @return ProductEntity */
    public function getProduct(): ?ProductEntity
    {
        return $this->product;
    }

    /** @param ProductEntity $product */
    public function setProduct(ProductEntity $product): void
    {
        $this->product = $product;
    }

    /** @return string */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /** @param string $productId */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    /** @return CustomerGroupEntity */
    public function getCustomerGroups(): ?CustomerGroupEntity
    {
        return $this->customerGroups;
    }

    /** @param CustomerGroupEntity $customerGroups */
    public function setCustomerGroups(CustomerGroupEntity $customerGroups): void
    {
        $this->customerGroups = $customerGroups;
    }

    /** @return SalesChannelEntity */
    public function getSalesChannels(): ?SalesChannelEntity
    {
        return $this->salesChannels;
    }

    /** @param SalesChannelEntity $salesChannels */
    public function setSalesChannels(SalesChannelEntity $salesChannels): void
    {
        $this->salesChannels = $salesChannels;
    }
}
