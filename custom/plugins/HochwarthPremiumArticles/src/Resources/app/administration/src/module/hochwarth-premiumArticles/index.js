import "./page/hochwarth-premiumArticles-list";
import "./page/hochwarth-premiumArticles-detail";
import "./page/hochwarth-premiumArticles-create";

// import deDE from '../snippet/de-DE';
// import enGB from '../snippet/en-GB';

Shopware.Module.register('hochwarth-premiumArticles', {
    // component configuration:

    color: '#ff3d58',
    name: 'Hochwarth-premiumArticles',
    type: 'plugin',
    icon: 'default-package-gift',
    title: "hochwarth-premiumArticles.general.pluginName",
    description: "hochwarth-premiumArticles.general.description",
    routes: {
        list: {
            component: 'hochwarth-premiumArticles-list',
            path: 'list'
        },
        detail: {
            component: 'hochwarth-premiumArticles-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'hochwarth.premiumArticles.list'
            }
        },
        create: {
            component: 'hochwarth-premiumArticles-create',
            path: 'create',
            meta: {
                parentPath: 'hochwarth.premiumArticles.list'
            }
        },
    },
    navigation: [{
        label: "hochwarth-premiumArticles.general.pluginName",
        // color: '#ff3d58',
        path: 'hochwarth.premiumArticles.list',
        icon: 'default-package-gift',
        // position: 100,
    }],
});