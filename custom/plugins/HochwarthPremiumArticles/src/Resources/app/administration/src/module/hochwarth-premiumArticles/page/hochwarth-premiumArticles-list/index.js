import template from './hochwarth-premiumArticles-list.html.twig';
const Criteria = Shopware.Data.Criteria;

Shopware.Component.register('hochwarth-premiumArticles-list', {
    template,
    inject: [
        'repositoryFactory'
    ],
    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },
    data() {
        return {
            repository: null,
            premiumArticles: null
        };
    },
    created() {
        this.repository = this.repositoryFactory.create('hochwarth_premium_article');
        this.repository.search(new Criteria(), Shopware.Context.api).then((result) => {
            this.premiumArticles = result;
        });
    },
    computed: {
        columns() {
            return [
                {
                    property: 'product.name',
                    label: this.$tc('hochwarth-premiumArticles.list.product'),
                    allowResize: true,
                },
                {
                    property: 'minPrice',
                    label: this.$tc('hochwarth-premiumArticles.list.minPrice'),
                    inlineEdit: 'number',
                    allowResize: true,
                },
                {
                    property: 'active',
                    label: this.$tc('hochwarth-premiumArticles.list.active'),
                    inlineEdit: 'boolean',
                    allowResize: true,
                },
                {
                    property: 'automaticAdd',
                    label: this.$tc('hochwarth-premiumArticles.list.automaticAdd'),
                    inlineEdit: 'boolean',
                    allowResize: true,
                },
            ]
        }
    }
});