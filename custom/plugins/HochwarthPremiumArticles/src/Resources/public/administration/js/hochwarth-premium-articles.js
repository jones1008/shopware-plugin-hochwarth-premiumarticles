(this.webpackJsonp=this.webpackJsonp||[]).push([["hochwarth-premium-articles"],{"+0P0":function(e,t){e.exports='{% block hochwarth_premiumArticles_detail %}\n    <sw-page class="hochwarth-premiumArticles-detail">\n        <template slot="smart-bar-actions">\n            <sw-button :routerLink="{ name: \'hochwarth.premiumArticles.list\' }">\n                {{ $t(\'hochwarth-premiumArticles.cancelButtonText\') }}\n            </sw-button>\n\n            <sw-button-process\n                    :isLoading="isLoading"\n                    :processSuccess="processSuccess"\n                    variant="primary"\n                    @process-finish="saveFinish"\n                    @click="onClickSave"\n            >\n                {{ $t(\'hochwarth-premiumArticles.saveButtonText\') }}\n            </sw-button-process>\n        </template>\n        <template slot="content">\n            <sw-card-view>\n                <sw-card v-if="premiumArticle">\n                    <sw-checkbox-field\n                            :label="$t(\'hochwarth-premiumArticles.entity.active\')"\n                            v-model="premiumArticle.active"\n                    ></sw-checkbox-field>\n                    <sw-field\n                            :label="$t(\'hochwarth-premiumArticles.entity.minPrice\')"\n                            v-model="premiumArticle.minPrice"\n                            validation="required"\n                            type="number"\n                            :step="0.1"\n                    ></sw-field>\n                    <sw-entity-single-select\n                            :label="$t(\'hochwarth-premiumArticles.entity.product\')"\n                            entity="product"\n                            v-model="premiumArticle.productId"\n                    ></sw-entity-single-select>\n                    <sw-checkbox-field\n                            :label="$t(\'hochwarth-premiumArticles.entity.automaticAdd\')"\n                            v-model="premiumArticle.automaticAdd"\n                    ></sw-checkbox-field>\n                </sw-card>\n            </sw-card-view>\n        </template>\n    </sw-page>\n{% endblock %}'},"5vlC":function(e,t){e.exports='{% block hochwarth_premiumArticles_list %}\n    <sw-page class="hochwarth-premiumArticles-list">\n        {% block hochwarth_premiumArticles_list_smart_bar_actions %}\n            <template slot="smart-bar-actions">\n                <sw-button variant="primary" :routerLink="{ name: \'hochwarth.premiumArticles.create\' }">\n                    {{ $t(\'hochwarth-premiumArticles.list.addButtonText\') }}\n                </sw-button>\n            </template>\n        {% endblock %}\n        <template slot="content">\n            {% block hochwarth_premiumArticles_list_content %}\n                <sw-entity-listing\n                        v-if="premiumArticles"\n                        :items="premiumArticles"\n                        :repository="repository"\n                        :showSelection="false"\n                        :columns="columns"\n                        detailRoute="hochwarth.premiumArticles.detail"\n                >\n                    {% block hochwarth_premiumArticles_list_grid_columns_active %}\n                        <template #column-active="{ item, isInlineEdit }">\n                            {% block hochwarth_premiumArticles_list_grid_columns_active_inline_edit %}\n                                <template v-if="isInlineEdit">\n                                    <sw-checkbox-field v-model="item.active"></sw-checkbox-field>\n                                </template>\n                            {% endblock %}\n\n                            {% block hochwarth_premiumArticles_list_grid_columns_active_content %}\n                                <template v-else>\n                                    <sw-icon v-if="item.active" name="small-default-checkmark-line-medium" small class="is--active"></sw-icon>\n                                    <sw-icon v-else name="small-default-x-line-medium" small class="is--inactive"></sw-icon>\n                                </template>\n                            {% endblock %}\n                        </template>\n                    {% endblock %}\n                </sw-entity-listing>\n            {% endblock %}\n        </template>\n    </sw-page>\n{% endblock %}'},RB0N:function(e){e.exports=JSON.parse("{}")},W6yk:function(e,t,i){"use strict";i.r(t);var r=i("5vlC"),c=i.n(r);const s=Shopware.Data.Criteria;Shopware.Component.register("hochwarth-premiumArticles-list",{template:c.a,inject:["repositoryFactory"],metaInfo(){return{title:this.$createTitle()}},data:()=>({repository:null,premiumArticles:null}),created(){console.log("test"),this.repository=this.repositoryFactory.create("hochwarth_premium_article"),this.repository.search(new s,Shopware.Context.api).then(e=>{this.premiumArticles=e})},computed:{columns(){return[{property:"minPrice",label:this.$tc("hochwarth-premiumArticles.entity.minPrice"),inlineEdit:"number",allowResize:!0},{property:"active",label:this.$tc("hochwarth-premiumArticles.entity.active"),inlineEdit:"boolean",allowResize:!0,align:"center"},{property:"product.name",label:this.$tc("hochwarth-premiumArticles.entity.product"),allowResize:!0},{property:"automaticAdd",label:this.$tc("hochwarth-premiumArticles.entity.automaticAdd"),inlineEdit:"boolean",allowResize:!0,align:"center"}]}}});var n=i("+0P0"),a=i.n(n);const{Component:o,Mixin:l}=Shopware;o.register("hochwarth-premiumArticles-detail",{template:a.a,inject:["repositoryFactory"],mixins:[l.getByName("notification")],metaInfo(){return{title:this.$createTitle()}},data:()=>({premiumArticle:null,isLoading:!1,processSuccess:!1,repository:null}),created(){this.repository=this.repositoryFactory.create("hochwarth_premium_article"),this.getPremiumArticle()},methods:{getPremiumArticle(){this.repository.get(this.$route.params.id,Shopware.Context.api).then(e=>{this.premiumArticle=e})},onClickSave(){this.isLoading=!0,this.repository.save(this.premiumArticle,Shopware.Context.api).then(()=>{this.getPremiumArticle(),this.isLoading=!1,this.processSuccess=!0}).catch(e=>{this.isLoading=!1,this.createNotificationError({title:this.$tc("hochwarth-premiumArticles.saveErrorText"),message:e})})},saveFinish(){this.processSuccess=!1}}});i("i381"),i("tNXj"),i("RB0N");Shopware.Module.register("hochwarth-premiumArticles",{color:"#ff3d58",name:"Hochwarth-premiumArticles",type:"plugin",icon:"default-package-gift",title:"hochwarth-premiumArticles.general.pluginName",description:"hochwarth-premiumArticles.general.description",routes:{list:{component:"hochwarth-premiumArticles-list",path:"list"},detail:{component:"hochwarth-premiumArticles-detail",path:"detail/:id",meta:{parentPath:"hochwarth.premiumArticles.list"}},create:{component:"hochwarth-premiumArticles-create",path:"create",meta:{parentPath:"hochwarth.premiumArticles.list"}}},navigation:[{label:"hochwarth-premiumArticles.general.pluginName",path:"hochwarth.premiumArticles.list",icon:"default-package-gift"}]})},i381:function(e,t){Shopware.Component.extend("hochwarth-premiumArticles-create","hochwarth-premiumArticles-detail",{methods:{getPremiumArticle(){this.premiumArticle=this.repository.create(Shopware.Context.api)},onClickSave(){this.isLoading=!0,this.repository.save(this.premiumArticle,Shopware.Context.api).then(()=>{this.isLoading=!1,this.$router.push({name:"hochwarth.premiumArticles.list"})}).catch(e=>{this.isLoading=!1,this.createNotificationError({title:this.$tc("hochwarth.premiumArticles.saveErrorText"),message:e})})}}})},tNXj:function(e){e.exports=JSON.parse("{}")}},[["W6yk","runtime"]]]);