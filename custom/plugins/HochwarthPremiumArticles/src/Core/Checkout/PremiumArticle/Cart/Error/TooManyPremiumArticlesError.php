<?php

namespace HochwarthPremiumArticles\Core\Checkout\PremiumArticle\Cart\Error;

use Shopware\Core\Checkout\Cart\Error\Error;

class TooManyPremiumArticlesError extends Error
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * TooManyPremiumArticlesError constructor.
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;

        $this->message = sprintf('The premium article %s can\'t be added to cart', $name);

        parent::__construct($this->message);
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->getMessageKey() . $this->id;
    }

    public function getMessageKey(): string
    {
        return 'too-many-premium-articles';
    }

    public function getLevel(): int
    {
        return self::LEVEL_ERROR;
    }

    public function blockOrder(): bool
    {
        return true;
    }

    public function getParameters(): array
    {
        return ['name' => $this->name];
    }
}