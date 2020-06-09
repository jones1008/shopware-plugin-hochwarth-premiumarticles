<?php

namespace HochwarthPremiumArticles\Resources\snippet\de_DE;

use Shopware\Core\System\Snippet\Files\SnippetFileInterface;

class SnippetFile_de_DE implements SnippetFileInterface
{

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'storefront.de-DE';
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return __DIR__ . '/storefront.de-DE.json';
    }

    /**
     * @inheritDoc
     */
    public function getIso(): string
    {
        return 'de-DE';
    }

    /**
     * @inheritDoc
     */
    public function getAuthor(): string
    {
        return 'Hochwarth IT';
    }

    /**
     * @inheritDoc
     */
    public function isBase(): bool
    {
        return false;
    }
}