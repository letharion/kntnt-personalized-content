let kntntCIP = new class {

    constructor() {
        this._cipURL = null;
        this._profile = null;
    }

    set url(cipURL) {
        if (this._cipURL !== cipURL) {
            this._profile = null;
        }
        this._cipURL = cipURL;
    }

    get profile() {
        if (null === this._profile) {
            this.loadProfile();
        }
        return this._profile;
    }

    loadProfile() {
        let cookie;
        if (kntnt_cip.debug && (cookie = this._getCookie('kntnt-cip-profile'))) {
            this._profile = JSON.parse(cookie)
        }
        else if (null === this._cipURL) {
            this._profile = {};
        }
        else {
            this._profile = this._loadProfile();
        }
    }

    _loadProfile() {
        // TODO CLAES: Contact CIP at this.url to load this.profile
        return {
            'strategy_interest': [],
            'strategy_step': [],
            'strategy_personality': []
        };
    }

    _getCookie(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
    }

};

jQuery(document).ready(function ($) {

    $(kntnt_cip.selector).each(function (index, element) {

        const $element = $(element);

        kntntCIP.url = kntnt_cip.cip_url;

        let attributes = {};
        for (let i = 0; i < element.attributes.length; ++i) {
            attributes[element.attributes[i].name] = element.attributes[i].value;
        }

        const data = {
            'action': kntnt_cip.action,
            'nonce': kntnt_cip.nonce,
            'profile': kntntCIP.profile,
            'attributes': attributes
        };

        jQuery.post(kntnt_cip.ajax_url, data, function (content) {
            $element.html(content);
            $element.show();
            $(document.body).trigger('post-load');
        });

    })

});