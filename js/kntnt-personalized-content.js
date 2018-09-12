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
        if (kntnt_personalized_content.debug && (cookie = this._getCookie('kntnt-personalized-content-profile'))) {
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
        const visitorID = Piwik.getTracker().getVisitorId();
        fetch('/index.php?module=API&method=RecommendedTagAPI.getRecommendations&format=JSON&visitorID=e48f668579a7fab7')
          .then(response => response.json())
          .then(tags => {
            console.log(JSON.stringify(tags));
        });
        return {
            'strategy_interest': ['business_managers'],
            'strategy_step': ['unaware', 'experiencing'],
            'strategy_personality': []
        };
    }

    _getCookie(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
    }

};

jQuery(document).ready(function ($) {

    $(kntnt_personalized_content.selector).each(function (index, element) {

        const $element = $(element);

        kntntCIP.url = kntnt_personalized_content.cip_url;

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
