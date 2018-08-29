let kntntCIP = new class {

    constructor() {
        this._cipURL = null;
        this._profile = null;
    }

    set cipURL(cipURL) {
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
        if (null === this._cipURL) {
            this._profile = {};
        }
        else {
            this._profile = this._loadProfile();
        }
    }

    // TODO CLAES: Contact CIP at this.cipURL to load this.profile
    _loadProfile() {
        return {
            'strategy_interest': ['business_managers', 'project_managers'],
            'strategy_step': ['unaware', 'experiencing'],
            'strategy_personality': []
        };
    }

};

jQuery(document).ready(function ($) {

    $(kntnt_personalized_content.selector).each(function (index, element) {

        const $element = $(element);

        kntntCIP.cipURL = kntnt_personalized_content.cip_url;

        let attributes = {};
        for (let i = 0; i < element.attributes.length; ++i) {
            attributes[element.attributes[i].name] = element.attributes[i].value;
        }

        const data = {
            'action': kntnt_personalized_content.action,
            'nonce': kntnt_personalized_content.nonce,
            'profile': kntntCIP.profile,
            'attributes': attributes
        };

        jQuery.post(kntnt_personalized_content.ajax_url, data, function (content) {
            $element.html(content);
            $element.show();
            $(document.body).trigger('post-load');
        });

    })

});