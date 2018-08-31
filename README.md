# Kntnt's Personalized Content

WordPress plugin that provides hooks that allows developers to inject personalized content.

## Description

This plugin provides two filter hooks that can be used to replace the content
of a `<div>`-element with content personalized for each visitor.

The first filter is `kntnt_personalized_content_selector` which filters the
selector that is used by jQuery to find the container(s) that will be replaced
with the personalized content. This filter has only the selector as argument.
Default is `.kntnt-personalized-content`. 

The second filter is `kntnt_personalized_content_output` which filters the
HTML-code of the personalized content before it is echoed back to the calling
JavaScript. This filter has three argument. The first is the HTML to be
filtered. Default is an empty string. The second argument is the visitors
profile returned by the CIP (see requirements). The profile is arranged as
an associative array with taxonomies as keys and indexed arrays of terms as
value. The third argument is an associative array of the container element's
attributes (e.g. id and class).

When WordPress runs in debug mode, i.e. WP_DEBUG is defined and true, the
plugin looks for the cookie `kntnt-personalized-content-profile`. If it exists
and is non-empty, its value is used as profile instead of fetching it from CIP.
By creating bookmarklets for various profiles, you can test their effect on
the personalized content. Following links are the trivial bookmarklets for
[an unknown user][unknown] (i.e. we haven't enough data to make a profile) and for
[restoring normal operations][restore].

[unknown]: javascript:%28function%28%29%7Bdocument.cookie%3D%27kntnt-personalized-content-profile%3D%7B%7D%3Bpath%3D%2F%27%3B%7D%29%28%29%3B
[restore]: javascript:%28function%28%29%7Bdocument.cookie%3D%27kntnt-personalized-content-profile%3D%3Bexpires%3DThu%2C01-Jan-197000%3A00%3A01GMT%3Bpath%3D%2F%27%3B%7D%29%28%29%3B

## Requirements

This plugin must connect to an installation of the Content Intelligence
Platform by Kntnt (a.k.a. CIP) configured to work with your site.

Currently, CIP is only available for Kntnt's customers.

## Installation

Install the plugin [the usually way](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

## Frequently Asked Questions

### Where is the setting page?

Look for `Personalized Content` in the Settings menu.

### How can I get help?

If you have a questions about the plugin, and cannot find an answer here, start by looking at [issues](https://github.com/Kntnt/kntnt-personalized-content/issues) and [pull requests](https://github.com/Kntnt/kntnt-personalized-content/pulls). If you still cannot find the answer, feel free to ask in the the plugin's [issue tracker](https://github.com/Kntnt/kntnt-personalized-content/issues) at Github.

### How can I report a bug?

If you have found a potential bug, please report it on the plugin's [issue tracker](https://github.com/Kntnt/kntnt-personalized-content/issues) at Github.

### How can I contribute?

Contributions to the code or documentation are much appreciated.

If you are unfamiliar with Git, please date it as a new issue on the plugin's [issue tracker](https://github.com/Kntnt/kntnt-personalized-content/issues) at Github.

If you are familiar with Git, please do a pull request.

## Changelog

### 1.0.0

Initial release. Fully functional plugin.
