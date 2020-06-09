<?php declare(strict_types=1);

namespace HochwarthPremiumArticles\Core\Content\PremiumArticle;

use HochwarthPremiumArticles\Core\Content\PremiumArticle\Aggregate\PremiumArticleCustomerGroup\PremiumArticleCustomerGroupDefinition;
use HochwarthPremiumArticles\Core\Content\PremiumArticle\Aggregate\PremiumArticleSalesChannel\PremiumArticleSalesChannelDefinition;
use Shopware\Core\Checkout\Customer\Aggregate\CustomerGroup\CustomerGroupDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FloatField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;

class PremiumArticleDefinition extends EntityDefinition
{
    public function getEntityName(): string
    {
        return 'hochwarth_premium_article';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new BoolField('active', 'active'))->addFlags(new Required()),
            (new FloatField('min_price', 'minPrice'))->addFlags(new Required()),
            (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new Required()),
            (new ReferenceVersionField(ProductDefinition::class)),
            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id', true),
            (new BoolField('automatic_add', 'automaticAdd')),
            new ManyToManyAssociationField('customerGroups', CustomerGroupDefinition::class, PremiumArticleCustomerGroupDefinition::class, 'premium_article_id', 'customer_group_id'),
            new ManyToManyAssociationField('salesChannels', SalesChannelDefinition::class, PremiumArticleSalesChannelDefinition::class, 'premium_article_id', 'sales_channel_id'),
        ]);
    }

    public function getEntityClass(): string
    {
        return PremiumArticleEntity::class;
    }

    public function getCollectionClass(): string
    {
        return PremiumArticleCollection::class;
    }
}
