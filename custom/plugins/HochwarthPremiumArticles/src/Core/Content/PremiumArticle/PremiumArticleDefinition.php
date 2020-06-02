<?php declare(strict_types=1);

namespace HochwarthPremiumArticles\Core\Content\PremiumArticle;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FloatField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;

class PremiumArticleDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'hochwarth_premium_article';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new BoolField('active', 'active'))->addFlags(new Required()),
            (new FloatField('min_price', 'minPrice')),
            (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(),
            (new ReferenceVersionField(ProductDefinition::class)),
            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class),
            (new BoolField('automatic_add', 'automaticAdd')),
        ]);
    }
}
