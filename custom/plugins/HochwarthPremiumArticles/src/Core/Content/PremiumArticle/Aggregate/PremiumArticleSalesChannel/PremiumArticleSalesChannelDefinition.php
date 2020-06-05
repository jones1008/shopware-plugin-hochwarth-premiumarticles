<?php

namespace HochwarthPremiumArticles\Core\Content\PremiumArticle\Aggregate\PremiumArticleSalesChannel;

use HochwarthPremiumArticles\Core\Content\PremiumArticle\PremiumArticleDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;

class PremiumArticleSalesChannelDefinition extends MappingEntityDefinition
{

    public function getEntityName(): string
    {
        return 'hochwarth_premium_article_sales_channel';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('premium_article_id', 'premiumArticleId', PremiumArticleDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('sales_channel_id', 'salesChannelId', SalesChannelDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new ManyToOneAssociationField('premiumArticle', 'premium_article_id', PremiumArticleDefinition::class),
            new ManyToOneAssociationField('salesChannel', 'sales_channel_id', SalesChannelDefinition::class),
            new CreatedAtField()
        ]);
    }
}