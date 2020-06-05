<?php

namespace HochwarthPremiumArticles\Core\Content\SalesChannel;

use HochwarthPremiumArticles\Core\Content\PremiumArticle\Aggregate\PremiumArticleSalesChannel\PremiumArticleSalesChannelDefinition;
use HochwarthPremiumArticles\Core\Content\PremiumArticle\PremiumArticleDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;

class SalesChannelExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new ManyToManyAssociationField(
                'PremiumArticles',
                PremiumArticleDefinition::class,
                PremiumArticleSalesChannelDefinition::class,
                'premium_article_id',
                'sales_channel_id')
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function getDefinitionClass(): string
    {
        return SalesChannelDefinition::class;
    }
}