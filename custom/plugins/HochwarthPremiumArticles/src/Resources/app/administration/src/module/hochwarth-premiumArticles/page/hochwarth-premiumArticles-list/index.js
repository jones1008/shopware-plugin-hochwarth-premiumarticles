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
        console.log("test");
        this.repository = this.repositoryFactory.create('hochwarth_premium_article');
        this.repository.search(new Criteria(), Shopware.Context.api).then((result) => {
            this.premiumArticles = result;
        });
    },
    computed: {
        columns() {
            return [{
                property: 'active',
                dataIndex: 'active',
                label: this.$tc('hochwarth-premiumArticles.list.minPrice'),
                routerLink: 'hochwarth.premiumArticles.detail',
                inlineEdit: 'boolean',
                allowResize: true,
            }]
        }
    }
});