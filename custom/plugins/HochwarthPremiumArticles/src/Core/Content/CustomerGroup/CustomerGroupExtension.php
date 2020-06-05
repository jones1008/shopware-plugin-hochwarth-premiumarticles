<?php

namespace HochwarthPremiumArticles\Core\Content\CustomerGroup;

use HochwarthPremiumArticles\Core\Content\PremiumArticle\PremiumArticleDefinition;
use Shopware\Core\Checkout\Customer\Aggregate\CustomerGroup\CustomerGroupDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use HochwarthPremiumArticles\Core\Content\PremiumArticle\Aggregate\PremiumArticleCustomerGroup\PremiumArticleCustomerGroupDefinition;

class CustomerGroupExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new ManyToManyAssociationField(
                'PremiumArticles',
                PremiumArticleDefinition::class,
                PremiumArticleCustomerGroupDefinition::class,
                'premium_article_id',
                'customer_group_id')
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function getDefinitionClass(): string
    {
        return CustomerGroupDefinition::class;
    }
}