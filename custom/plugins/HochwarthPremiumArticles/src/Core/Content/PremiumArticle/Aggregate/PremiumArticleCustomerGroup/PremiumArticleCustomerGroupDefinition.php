<?php

namespace HochwarthPremiumArticles\Core\Content\PremiumArticle\Aggregate\PremiumArticleCustomerGroup;

use HochwarthPremiumArticles\Core\Content\PremiumArticle\PremiumArticleDefinition;
use Shopware\Core\Checkout\Customer\Aggregate\CustomerGroup\CustomerGroupDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;

class PremiumArticleCustomerGroupDefinition extends MappingEntityDefinition
{

    public function getEntityName(): string
    {
        return 'hochwarth_premium_article_customer_group';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('premium_article_id', 'premiumArticleId', PremiumArticleDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('customer_group_id', 'customerGroupId', CustomerGroupDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new ManyToOneAssociationField('premiumArticle', 'premium_article_id', PremiumArticleDefinition::class),
            new ManyToOneAssociationField('customerGroup', 'customer_group_id', CustomerGroupDefinition::class),
            new CreatedAtField()
        ]);
    }
}