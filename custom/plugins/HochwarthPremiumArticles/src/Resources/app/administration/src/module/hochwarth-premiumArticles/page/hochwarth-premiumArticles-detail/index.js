import template from './hochwarth-premiumArticles-detail.html.twig';

const { Component, Mixin } = Shopware;

Component.register('hochwarth-premiumArticles-detail', {
    template,
    inject: [
        'repositoryFactory'
    ],
    mixins: [
        Mixin.getByName('notification')
    ],
    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },
    data() {
        return {
            premiumArticle: null,
            isLoading: false,
            processSuccess: false,
            repository: null
        };
    },

    created() {
        this.repository = this.repositoryFactory.create('hochwarth_premium_article');
        this.getPremiumArticle();
    },
    methods: {
        getPremiumArticle() {
            this.repository.get(this.$route.params.id, Shopware.Context.api).then((entity) => {
                this.premiumArticle = entity;
            });
        },
        onClickSave() {
            this.isLoading = true;
            this.repository.save(this.premiumArticle, Shopware.Context.api).then(() => {
                this.getPremiumArticle();
                this.isLoading = false;
                this.processSuccess = true;
            }).catch((exception) => {
                this.isLoading = false;
                this.createNotificationError({
                    title: this.$tc('hochwarth-premiumArticles.saveErrorText'),
                    message: exception
                });
            });
        },
        saveFinish() {
            this.processSuccess = false;
        },
    }
});