# Kntnt's Content Integration Platform

WordPress plugin that integrates WordPress with Kntnt's Content Intelligence
Platform.

## Description

This plugin provides two filter hooks that can be used to replace the content
of a `<div>`-element with content personalized for each visitor.

The first filter is `kntnt_cip_selector` which filters the
selector that is used by jQuery to find the container(s) that will be replaced
with the personalized content. This filter has only the selector as argument.
Default is `.kntnt-cip`. 

The second filter is `kntnt_cip_output` which filters the
HTML-code of the personalized content before it is echoed back to the calling
JavaScript. This filter has three argument. The first is the HTML to be
filtered. Default is an empty string. The second argument is the visitors
profile returned by the CIP (see requirements). The profile is arranged as
an associative array with taxonomies as keys and indexed arrays of terms as
value. The third argument is an associative array of the container element's
attributes (e.g. id and class).

When WordPress runs in debug mode, i.e. WP_DEBUG is defined and true, the
plugin looks for the cookie `kntnt-cip-profile`. If it exists
and is non-empty, its value is used as profile instead of fetching it from CIP.
By creating bookmarklets for various profiles, you can test their effect on
the personalized content. This is an example how such bookmarklet looks like
before it is [url-encoded](https://en.wikipedia.org/wiki/Percent-encoding): 

    (function(){document.cookie='kntnt-personalized-content-profile={"strategy_step": ["unaware","doubts"],"strategy_interest": ["business-managers"]};path=/';})();

Following are bookmarklets for an unknown user] (i.e. we haven't enough data to
make a profile) and for restoring normal operations before url-encoding:

    (function(){document.cookie='kntnt-personalized-content-profile=;expires=Thu,01-Jan-197000:00:01GMT;path=/';})();

    (function(){document.cookie='kntnt-personalized-content-profile={};path=/';})();

## Requirements

This plugin must connect to an installation of the Content Intelligence
Platform by Kntnt (a.k.a. CIP) configured to work with your site. Currently,
CIP is only available for Kntnt's customers.

## Installation

Install the plugin [the usually way](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

## Frequently Asked Questions

### Where is the setting page?

Look for `KNTNT CIP` in the Settings menu.

### How can I get help?

If you have a questions about the plugin, and cannot find an answer here, start
by looking at [issues](https://github.com/Kntnt/kntnt-cip/issues) and
[pull requests](https://github.com/Kntnt/kntnt-cip/pulls). If you still cannot
find the answer, feel free to ask in the the plugin's
[issue tracker](https://github.com/Kntnt/kntnt-cip/issues) at Github.

### How can I report a bug?

If you have found a potential bug, please report it on the plugin's
[issue tracker](https://github.com/Kntnt/kntnt-cip/issues) at Github.

### How can I contribute?

Contributions to the code or documentation are much appreciated.

If you are unfamiliar with Git, please date it as a new issue on the plugin's
[issue tracker](https://github.com/Kntnt/kntnt-cip/issues) at Github.

If you are familiar with Git, please do a pull request.

## Changelog

### 1.0.0

Initial release. Fully functional plugin.
