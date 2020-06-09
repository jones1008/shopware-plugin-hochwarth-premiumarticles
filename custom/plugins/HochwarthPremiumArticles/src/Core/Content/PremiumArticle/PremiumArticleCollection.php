<?php

namespace HochwarthPremiumArticles\Core\Content\PremiumArticle;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void               add(PremiumArticleEntity $entity)
 * @method void               set(string $key, PremiumArticleEntity $entity)
 * @method PremiumArticleEntity[]    getIterator()
 * @method PremiumArticleEntity[]    getElements()
 * @method PremiumArticleEntity|null get(string $key)
 * @method PremiumArticleEntity|null first()
 * @method PremiumArticleEntity|null last()
 */
class PremiumArticleCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return PremiumArticleEntity::class;
    }
}