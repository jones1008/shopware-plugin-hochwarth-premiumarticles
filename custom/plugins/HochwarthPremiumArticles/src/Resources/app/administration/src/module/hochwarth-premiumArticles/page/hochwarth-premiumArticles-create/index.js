Shopware.Component.extend('hochwarth-premiumArticles-create', 'hochwarth-premiumArticles-detail', {
    methods: {
        getPremiumArticle() {
            this.premiumArticle = this.repository.create(Shopware.Context.api);
            this.premiumArticle.active = true;
            this.premiumArticle.automaticAdd = true;
        },
        onClickSave() {
            this.isLoading = true;
            this.repository.save(this.premiumArticle, Shopware.Context.api).then(() => {
                this.isLoading = false;
                this.$router.push({ name: 'hochwarth.premiumArticles.list'});
            }).catch((exception) => {
                this.isLoading = false;
                this.createNotificationError({
                    title: this.$tc('hochwarth-premiumArticles.saveErrorText'),
                    message: this.$tc(
                        'global.notification.notificationSaveErrorMessage', 0, { entityName: this.$tc("hochwarth-premiumArticles.general.pluginName") }
                    )
                });
            });
        }
    }
});