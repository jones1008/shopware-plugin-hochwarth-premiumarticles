<?php

namespace HochwarthPremiumArticles\Core\Checkout\PremiumArticle\Cart;

use HochwarthPremiumArticles\Core\Checkout\PremiumArticle\Cart\Error\TooManyPremiumArticlesError;
use HochwarthPremiumArticles\Core\Content\PremiumArticle\PremiumArticleCollection;
use HochwarthPremiumArticles\Core\Content\PremiumArticle\PremiumArticleEntity;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\CartBehavior;
use Shopware\Core\Checkout\Cart\CartProcessorInterface;
use Shopware\Core\Checkout\Cart\CartDataCollectorInterface;
use Shopware\Core\Checkout\Cart\Delivery\Struct\DeliveryInformation;
use Shopware\Core\Checkout\Cart\Delivery\Struct\DeliveryTime;
use Shopware\Core\Checkout\Cart\LineItem\CartDataCollection;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\LineItem\LineItemCollection;
use Shopware\Core\Checkout\Cart\LineItem\QuantityInformation;
use Shopware\Core\Checkout\Cart\Price\QuantityPriceCalculator;
use Shopware\Core\Checkout\Cart\Price\Struct\CalculatedPrice;
use Shopware\Core\Checkout\Cart\Price\Struct\QuantityPriceDefinition;
use Shopware\Core\Checkout\Cart\Tax\Struct\CalculatedTaxCollection;
use Shopware\Core\Checkout\Cart\Tax\Struct\TaxRuleCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PremiumArticleCartProcessor implements CartProcessorInterface, CartDataCollectorInterface
{
    public const TYPE = 'premiumArticle';
    public const DATA_KEY = 'hochwarth_premium_articles-';

    // TODO: aus Datenbank für Admin konfigurierbar machen
    public const MAX_PREMIUM_ARTICLES = 2;

    /**
     * @var EntityRepositoryInterface
     */
    private $premiumArticleRepository;
    /**
     * @var QuantityPriceCalculator
     */
    private $calculator;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * PremiumArticleCartProcessor constructor.
     */
    public function __construct(EntityRepositoryInterface $premiumArticleRepository, QuantityPriceCalculator $calculator, ContainerInterface $container)
    {
        $this->premiumArticleRepository = $premiumArticleRepository;
        $this->calculator = $calculator;
        $this->container = $container;
    }


    public function collect(CartDataCollection $data, Cart $original, SalesChannelContext $context, CartBehavior $behavior): void
    {
        /** @var LineItemCollection $premiumArticleLineItems */
        $premiumArticleLineItems = $original->getLineItems()->filterType(self::TYPE);

        if (\count($premiumArticleLineItems) === 0) {
            return;
        }

        $premiumArticles = $this->fetchPremiumArticles($premiumArticleLineItems, $data, $context);

        foreach ($premiumArticles as $premiumArticle) {
            // ensure all line items have a data entry
            $data->set(self::DATA_KEY . $premiumArticle->getId(), $premiumArticle);
        }

        $counter = 1;
        foreach ($premiumArticleLineItems as $premiumArticleLineItem) {
            $premiumArticle = $data->get(self::DATA_KEY . $premiumArticleLineItem->getReferencedId());
            if ($counter > self::MAX_PREMIUM_ARTICLES) {
                $product = $premiumArticle->getProduct();
                $original->addErrors(
                    new TooManyPremiumArticlesError($product->getId(), (string) $product->getTranslation('name'))
                );
//                $this->container->get('session')->getFlashBag()->add('danger', "You can't insert more than 1 premium article");
                break;
            }

            // enrich premiumArticle information with quantity and delivery information
            $this->enrichPremiumArticle($premiumArticleLineItem, $premiumArticle);
            $counter++;
        }
    }

    public function process(CartDataCollection $data, Cart $original, Cart $toCalculate, SalesChannelContext $context, CartBehavior $behavior): void
    {
        $premiumArticleLineItems = $original->getLineItems()->filterType(self::TYPE);

        if (\count($premiumArticleLineItems) === 0) {
            return;
        }

        /** @var LineItem $premiumArticleLineItem */
        foreach ($premiumArticleLineItems as $premiumArticleLineItem) {

            /** @var LineItem $product */
//            $children = $premiumArticleLineItem->getChildren();
//            $product = $premiumArticleLineItem->getChildren()->filterType(LineItem::PRODUCT_LINE_ITEM_TYPE)->first();
//            $price = $product->getPrice();
//            $lineItems = $original->getLineItems();
//            $product = $premiumArticleLineItem->getChildren()->filterType(LineItem::PRODUCT_LINE_ITEM_TYPE);

            $definition = new QuantityPriceDefinition(
                0,
                new TaxRuleCollection(),
                $context->getCurrency()->getDecimalPrecision(),
                1,
                true
            );
            // build CalculatedPrice over calculator class for overwitten price
            $calculated = $this->calculator->calculate($definition, $context);
            // set new price into line item
            $premiumArticleLineItem->setPrice($calculated)->setPriceDefinition($definition);

            // afterwards we can move the premiumArticle to the new cart
            $toCalculate->add($premiumArticleLineItem);
        }
    }

    /**
     * Fetches all premiumArticles that are not already stored in data
     */
    private function fetchPremiumArticles(LineItemCollection $premiumArticleLineItems, CartDataCollection $data, SalesChannelContext $context): PremiumArticleCollection
    {
        $premiumArticleIds = $premiumArticleLineItems->getReferenceIds();

        $filtered = [];
        foreach ($premiumArticleIds as $premiumArticleId) {
            // If data already contains the premiumArticle we don't need to fetch it again
            if ($data->has(self::DATA_KEY . $premiumArticleId)) {
                continue;
            }
            $filtered[] = $premiumArticleId;
        }

        $criteria = new Criteria($filtered);
        $criteria->addAssociation('product.cover');
        /** @var PremiumArticleCollection $premiumArticles */
        $premiumArticles = $this->premiumArticleRepository->search($criteria, $context->getContext())->getEntities();

        return $premiumArticles;
    }

    private function enrichPremiumArticle(LineItem $premiumArticleLineItem, PremiumArticleEntity $premiumArticle): void
    {
        $premiumArticleProduct = $premiumArticle->getProduct();
        if ($premiumArticleProduct === null) {
            throw new \RuntimeException(sprintf('PremiumArticle "%s" ain\'t got no product', $premiumArticle->getId()));
        }

        if (!$premiumArticleLineItem->getLabel()) {
            $premiumArticleLineItem->setLabel($premiumArticleProduct->getName() . " (GRATIS)");
        }

        if ($premiumArticleProduct->getCover()) {
            $premiumArticleLineItem->setCover($premiumArticleProduct->getCover()->getMedia());
        }

        $premiumArticleProductDeliveryTime = $premiumArticleProduct->getDeliveryTime();
        if ($premiumArticleProductDeliveryTime !== null) {
            $premiumArticleProductDeliveryTime = DeliveryTime::createFromEntity($premiumArticleProductDeliveryTime);
        }

        $premiumArticleLineItem->setRemovable(true)
            ->setStackable(false)
            ->setDeliveryInformation(
                new DeliveryInformation(
                    $premiumArticleProduct->getStock(),
                    (float)$premiumArticleProduct->getWeight(),
                    (bool)$premiumArticleProduct->getShippingFree(),
                    $premiumArticleProduct->getRestockTime(),
                    $premiumArticleProductDeliveryTime
                )
            )
            ->setQuantityInformation(new QuantityInformation());
    }
}