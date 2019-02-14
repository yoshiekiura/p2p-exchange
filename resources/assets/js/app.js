/** Import Global Components **/
import AdminMenu from './admin/menu';
import AdminNavigation from './admin/nav';
import AdminFooter from './admin/footer';

import AdminHome from './pages/admin/home';
import AdminEarnings from './pages/admin/earnings';
import AdminUsers from './pages/admin/users';

import AdminSettingsGeneral from './pages/admin/settings/general';
import AdminSettingsTransaction from './pages/admin/settings/transaction';
import AdminSettingsNotification from './pages/admin/settings/notification';
import AdminSettingsOffer from './pages/admin/settings/offer';
import AdminPlatformCustomize from './pages/admin/platform/customize';
import AdminPlatformTranslation from './pages/admin/platform/translation';
import AdminPlatformIntegration from './pages/admin/platform/integration';
import AdminPlatformLicense from './pages/admin/platform/license';
import ModerationTrades from './pages/moderation/trades';

import Profile from './pages/profile';
import ProfileSettings from './pages/profile/settings';
import Wallet from './pages/wallet';
import MarketBuyCoin from './pages/market/buy_coin';
import MarketCreateOffer from './pages/market/create_offer';
import MarketSellCoin from './pages/market/sell_coin';
import Home from './pages/home';
import HomeOffers from './pages/home/offers';
import HomeTrades from './pages/home/trades';
import Auth from './pages/auth';

import Menu from './menu';
import Navigation from './nav';
import Footer from './footer';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Register Global Components
Vue.component('app-menu', Menu);
Vue.component('app-navigation', Navigation);
Vue.component('app-footer', Footer);

// Register Page components
Vue.component('admin-home-page', AdminHome);
Vue.component('admin-earnings-page', AdminEarnings);
Vue.component('admin-users-page', AdminUsers);

Vue.component('admin-settings-general-page', AdminSettingsGeneral);
Vue.component('admin-settings-notification-page', AdminSettingsNotification);
Vue.component('admin-settings-transaction-page', AdminSettingsTransaction);
Vue.component('admin-settings-offer-page', AdminSettingsOffer);
Vue.component('admin-platform-customize-page', AdminPlatformCustomize);
Vue.component('admin-platform-translation-page', AdminPlatformTranslation);
Vue.component('admin-platform-integration-page', AdminPlatformIntegration);
Vue.component('admin-platform-license-page', AdminPlatformLicense);

Vue.component('auth-page', Auth);
Vue.component('home-page', Home);
Vue.component('moderation-trades-page', ModerationTrades);
Vue.component('home-offers-page', HomeOffers);
Vue.component('home-trades-page', HomeTrades);
Vue.component('market-buy-coin-page', MarketBuyCoin);
Vue.component('market-create-offer-page', MarketCreateOffer);
Vue.component('market-sell-coin-page', MarketSellCoin);
Vue.component('profile-page', Profile);
Vue.component('profile-settings-page', ProfileSettings);
Vue.component('wallet-page', Wallet);

// Register App components
Vue.component('rating', require('./components/Rating'));
Vue.component('dropzone', require('./components/Dropzone'));
Vue.component('tinymce', require('./components/TinymceVue'));
Vue.component('user-tag', require('./components/UserTag'));
Vue.component('count-down', require('./components/CountDown'));
Vue.component('select2', require('./components/Select2'));
Vue.component('knob', require('./components/Knob'));


Vue.component('app-admin-menu', AdminMenu);
Vue.component('app-admin-navigation', AdminNavigation);
Vue.component('app-admin-footer', AdminFooter);

import global from './core/global';
import menu from './core/menu';

window.App = new Vue({
    el: '#app',
    data: {
        dataTable: {}
    },
    methods: {
        _disableAutoComplete() {

            document.querySelectorAll('[autocomplete="off"]')
                    .forEach(element => {
                        element.setAttribute('readonly', 'readonly');
                        element.style.backgroundColor = 'inherit';

                        window.addEventListener('load', () => {
                            setTimeout(() => {
                                element.removeAttribute('readonly');
                            }, 500);
                        });
                    });
        },

        _initValidation: function () {
            $("input, select, textarea")
                .not("[type=submit], [novalidate]")
                .jqBootstrapValidation();
        },

        _initFormElements: function () {
            this._disableAutoComplete();
            let check = $('.skin-square input');

            // Square Checkbox & Radio
            check.iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
            });
        },

        _initDataTable: function () {
            let vm = this;

            $.each(window._tableData, function (index, value) {
                let selector = value['selector'],
                    options  = value['options'];

                $(selector).on('processing.dt', function (e, s, processing) {
                    var card = $(this).closest('.card');

                    if (processing) {
                        if (card.is(':visible')) {
                            card.block({
                                overlayCSS: {
                                    backgroundColor: '#FFF',
                                    cursor: 'wait',
                                },
                                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                                css: {
                                    border: 0,
                                    padding: 0,
                                    backgroundColor: 'none'
                                }
                            });

                        }
                    } else {
                        card.unblock();
                    }
                });

                vm.dataTable[selector] = $(selector).DataTable(options);

                let searchBox = $('#search-table');

                if (searchBox && searchBox.length > 0) {
                    searchBox.on('keyup', function () {
                        vm.dataTable[selector].search(this.value).draw();
                    });
                }

                let card = $(selector).closest('.card');

                card.on('click', '[data-action="reload"]', function (e) {
                    vm.dataTable[selector].ajax.reload();
                });
            });
        },

        _reloadDataTable: function (id) {
            this.dataTable[id].ajax.reload();
        },

        _setAway: function (name) {
            axios.put(route('ajax.profile.setAway', {
                'user': name
            }))
        },

        _setOnline: function (name) {
            axios.put(route('ajax.profile.setOnline', {
                'user': name
            }))
        },

    },

    mounted: function () {
        menu(window, document, $);
        global(window, document, $);

        let user, vm = this;

        this.$nextTick(function () {
            this._initValidation();
            this._initFormElements();
            this._initDataTable();
        });

        if (user = window.Laravel.user) {
            vm._setOnline(user.name);

            $(document).idle({
                onIdle: function () {
                    vm._setAway(user.name);
                },
                onActive: function () {
                    vm._setOnline(user.name);
                },

                onShow: function () {
                    vm._setOnline(user.name);
                },
                onHide: function () {
                    vm._setAway(user.name);
                },
                idle: 1000 * 60,
            });
        }
    },
});
