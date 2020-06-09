<?php

namespace HochwarthPremiumArticles\Storefront\Page\Checkout\Cart\Subscriber;

use HochwarthPremiumArticles\Core\Checkout\PremiumArticle\Cart\PremiumArticleCartProcessor;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Storefront\Page\Checkout\Cart\CheckoutCartPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CheckoutCartPageLoadedSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityRepositoryInterface
     */
    private $premiumArticleRepository;

    public static function getSubscribedEvents()
    {
        return [
            CheckoutCartPageLoadedEvent::class => 'onCheckoutCartPageLoaded'
        ];
    }

    public function __construct(EntityRepositoryInterface $premiumArticleRepository)
    {
        $this->premiumArticleRepository = $premiumArticleRepository;
    }

    public function onCheckoutCartPageLoaded(CheckoutCartPageLoadedEvent $event): void
    {
        $page = $event->getPage();
        $criteria = (new Criteria())->addAssociation("product.cover")->addSorting(new FieldSorting("minPrice"));
        $premiumArticles = $this->premiumArticleRepository->search($criteria, $event->getSalesChannelContext()->getContext());
        $premiumArticlesInCart = $page->getCart()->getLineItems()->filterType(PremiumArticleCartProcessor::TYPE);
        $maxPremiumArticlesReached = count($premiumArticlesInCart->getElements()) >= PremiumArticleCartProcessor::MAX_PREMIUM_ARTICLES;
        $page->addExtension("premiumArticles", $premiumArticles);
        $page->addExtension("maxPremiumArticlesReached", new ArrayEntity(["value" => $maxPremiumArticlesReached]));
    }
}