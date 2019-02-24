=== GA Google Analytics ===

Plugin Name: GA Google Analytics
Plugin URI: https://perishablepress.com/google-analytics-plugin/
Description: Adds your Google Analytics Tracking Code to your WordPress site.
Tags: analytics, ga, google, google analytics, tracking, statistics, stats
Author: Jeff Starr
Author URI: https://plugin-planet.com/
Donate link: https://monzillamedia.com/donate.html
Contributors: specialk
Requires at least: 4.1
Tested up to: 5.1
Stable tag: 20190220
Version: 20190220
Requires PHP: 5.2
Text Domain: ga-google-analytics
Domain Path: /languages
License: GPL v2 or later

Adds your Google Analytics Tracking Code to your WordPress site.



== Description ==

> Supports Global Site Tag / gtag.js
> GDPR compliant: does not collect any user data

This plugin enables Google Analytics for your entire WordPress site. Lightweight and fast with plenty of great features.

**Features**

* Blazing fast performance
* Does one thing and does it well
* Drop-dead simple and easy to use
* Regularly updated and "future proof"
* Stays current with the latest tracking code
* Includes tracking code in header or footer
* Includes tracking code on all WordPress web pages
* Includes option to add your own custom markup
* Sleek plugin Settings page with toggling panels
* Option to disable tracking of admin-level users
* Option to enable page tracking in the Admin Area
* Easy to customize the tracking code

This is a lightweight plugin that inserts the required GA tracking code. To view your site statistics, visit your Google Analytics account.

**GA Tracking Options**

* [Universal Analytics](https://developers.google.com/analytics/devguides/collection/analyticsjs/) / analytics.js
* [Global Site Tag](https://developers.google.com/analytics/devguides/collection/gtagjs/) / gtag.js
* [Legacy](https://developers.google.com/analytics/devguides/collection/gajs/) / ga.js

**GA Feature Support**

* Supports [Display Advertising](https://support.google.com/analytics/answer/2444872)
* Supports [Enhanced Link Attribution](https://developers.google.com/analytics/devguides/collection/analyticsjs/enhanced-link-attribution)
* Supports [IP Anonymization](https://developers.google.com/analytics/devguides/collection/analyticsjs/ip-anonymization)
* Supports [Force SSL](https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference#forceSSL)
* Supports [Tracker Objects](https://developers.google.com/analytics/devguides/collection/analyticsjs/creating-trackers)
* Supports [Google Optimize](https://support.google.com/360suite/optimize/)

Learn more about [Google Analytics](http://www.google.com/analytics/)!

**GDPR**

This plugin does not collect any user data. Even so, the tracking code added by this plugin is used by Google to collect all sorts of user data. So this plugin does _not_ do anything to make your site _less_ compliant with GDPR. I have done my best to ensure that this plugin is 100% GDPR compliant, but I'm not a lawyer so can't guarantee anything. To ensure that your site is compliant with GDPR, please consult an attorney, and also check with Google and/or configure your Google account settings and/or tracking code as required by GDPR.

> Works perfectly with or without Gutenberg



== Installation ==

**Installation**

1. Upload the plugin to your blog and activate
2. Visit the settings to configure your options

After configuring your settings, you can verify that GA tracking code is included by viewing the source code of your web pages.

__Note:__ this plugin adds the required GA code to your web pages. In order for the code to do anything, it must correspond to an active, properly configured Google Analytics account. Learn more at the [Google Analytics Help Center](https://support.google.com/analytics/?hl=en#topic=3544906).

[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)


**Usage**

To enable Google Analytics tracking on your site, follow these steps:

1. Visit the "Plugin Settings" panel
2. Enter your GA Tracking ID
3. Choose either [Universal Analytics](https://developers.google.com/analytics/devguides/collection/analyticsjs/) or [Global Site Tag](https://developers.google.com/analytics/devguides/collection/gtagjs/)
4. Configure any other plugin settings as desired (optional)

Save changes and done. After 24-48 hours, you can log into your Google Analytics account to view your stats.

Note that it can take 24-48 hours after adding the tracking code before any analytical data appears in your [Google Analytics account](https://developers.google.com/analytics/). To check that the GA tacking code is included, look at the source code of your web page(s). Learn more at the [Google Analytics Help Center](https://support.google.com/analytics/?hl=en#topic=3544906).


**Upgrading Analytics**

Google Analytics tracking methods change over time. First there was `urchin.js`, then `ga.js`, and now `analytics.js`, soon to be replaced officially by `gtag.js`. If you are using an older version and want to upgrade, check out these Google docs:

* [Universal Analytics Upgrade Center](https://developers.google.com/analytics/devguides/collection/upgrade/)
* [Migrate from analytics.js to gtag.js](https://developers.google.com/analytics/devguides/collection/gtagjs/migration)


**Plugin Upgrades**

To upgrade GA Google Analytics, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 

For more information, visit the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).


**Restore Default Options**

To restore default plugin options, either uninstall/reinstall the plugin, or visit the plugin settings &gt; Restore Default Options.


**Uninstalling**

GA Google Analytics cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen. Your collected GA data will remain in your Google account.



== Screenshots ==

1. GA Google Analytics: Plugin Settings (default)
2. GA Google Analytics: Plugin Settings (expanded)

More screenshots available at the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).



== Upgrade Notice ==

To upgrade GA Google Analytics, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 

For more information, visit the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).



== Frequently Asked Questions ==

**Tracking code is not displayed in source code?**

If you check the source code of your pages and don't see the GA tracking code, check the following:

* Check that your theme includes the hooks, `wp_head` and `wp_footer`
* If you are using a caching plugin, try clearing the cache

If the GA tracking code still is not displayed, most likely there is interference from another plugin or theme. In this case, the best way to resolve the issue is to do some basic [WordPress troubleshooting](https://perishablepress.com/how-to-troubleshoot-wordpress/).


**Google Analytic says tracking code is not detected?**

You need to wait awhile for Google to collect some data, like at least a day or whatever. Standard stuff for Google Analytics. For more information, check out the [Google Analytics Help Center](https://support.google.com/analytics/?hl=en#topic=3544906).


**Can I filter the output of the "Custom GA Code" setting?**

Yes, you can use the `gap_custom_code` filter hook.


**How to implement Google Optimize?**

Here are the steps:

1. Enable Universal Analytics in the plugin settings
2. Add the Optimize plugin (e.g., `ga('require', 'GTM-XXXXXX');`) to the setting, "Custom GA Code"
3. Add the Page Hiding (flicker) snippet to the setting, "Custom &lt;head&gt; Code"
4. Enable the setting, "Custom &lt;head&gt; Location"

Done! You can view the source code of your web pages to verify the results.


**Got a question?**

To ask a question, suggest a feature, or provide feedback, [contact me directly](https://perishablepress.com/contact/). Learn more about [Google Analytics](http://www.google.com/analytics/) and [GA tracking methods](https://perishablepress.com/3-ways-track-google-analytics/).



== Support development of this plugin ==

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a donation](https://monzillamedia.com/donate.html) or purchase one of my books: 

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Super fast WordPress firewall
* [Blackhole Pro](https://plugin-planet.com/blackhole-pro/) - Automatically block bad bots
* [Banhammer Pro](https://plugin-planet.com/banhammer-pro/) - Monitor traffic and ban the bad guys
* [USP Pro](https://plugin-planet.com/usp-pro/) - Unlimited front-end forms

Links, tweets and likes also appreciated. Thanks! :)



== Changelog ==

*Thank you to everyone who shares feedback for GA Google Analytics!*

**20190220**

* Just a version bump for compat with WP 5.1
* Full update coming soon :)

**20180828**

* Corrects incorrect syntax for gtag tacking code
* Further tests on WP versions 4.9 and 5.0 (alpha)

**20180816**

* Adds `rel="noopener noreferrer"` to all [blank-target links](https://perishablepress.com/wordpress-blank-target-vulnerability/)
* Updates GDPR blurb and donate link
* Improves support for WP-CLI ([details](https://wordpress.org/support/topic/php-fatal-error-in-wp-cli/))
* Refines some option descriptions on the settings page
* Enables display of Custom Code when tracking is disabled
* Updates plugin screenshots for WordPress Plugin Directory
* Regenerates default translation template
* Further tests on WP versions 4.9 and 5.0 (alpha)

**20180506**

* Bugfix: changes `anonymizeIP` to `anonymizeIp` for analytics.js
* Tests on WordPress 5.0 (alpha)

**20180303**

* Refactors code base
* Removes deprecated notice
* Simplifies plugin settings
* Adds support for Global Site Tag (`gtag.js`)
* Makes it easier to reset default plugin options
* Changes Text Domain from `gap` to `ga-google-analytics`
* Generates new translation template
* Improves plugin settings page UI
* Updates plugin settings images
* Tests on WordPress 5.0 (alpha)

**20171103**

* Removes extra `manage_options` check for plugin settings
* Tests on WordPress 4.9

**20171021**

* Adds setting to display Custom head code before or after the GA tracking code
* Updates tracking URL from `//` to `https://` for Universal Analytics
* Updates default/example tracking ID from `UA-XXXXX-Y` to `UA-XXXXX-X`
* Adds `%%userid%%` shortcode for "Custom GA Code" setting
* Adds filter hook `gap_custom_code` for "Custom GA Code" setting
* Fixes PHP warning for "extract() expects parameter 1 to be array"
* Fixes code escaping bug for custom code and tracker settings
* Adds extra `manage_options` capability check to modify settings
* Streamlines Support panel in plugin settings
* Regenerates default translation template
* Improves display of plugin settings
* Tests on WordPress 4.9

**20170731**

* Updates GPL license blurb
* Adds GPL license text file
* Tests on WordPress 4.9 (alpha)

**20170324**

* Updates the show support panel
* Tweaks settings UI panel display
* Edits some plugin settings for clarity
* Replaces global `$wp_version` with `get_bloginfo('version')`
* Generates new default translation template
* Tests on WordPress version 4.8

**20161116**

* Adds info to deprecation nag on plugin settings page
* Adds info to the Overview panel on plugin settings page
* Changes stable tag from trunk to latest version
* Adds translation support for some missing strings
* Updates plugin author URL
* Updates Twitter link URL
* Refactors `add_gap_links()` function
* Updates URL for rate this plugin links
* Regenerates new default translation template
* Tests on WordPress version 4.7 (beta)

**20160831**

* Renamed the plugin back to its original name, GA Google Analytics
* Revised labels for first two "enable-GA" settings for clarity
* Regenerated translation template

**20160810**

* Renamed menu link from "GA Plugin" to "Google Analytics"
* Renamed plugin from "GA Google Analytics" to "(GA) Google Analytics"
* Replaced `_e()` with `esc_html_e()` or `esc_attr_e()`
* Replaced `__()` with `esc_html__()` or `esc_attr__()`
* Streamlined and optimized plugin settings page
* Added plugin icons and larger banner image
* Improved translation support
* Tested on WordPress 4.6

**20160331**

* Replaced GA Logo with retina version
* Added screenshot to readme/docs
* Added retina version of plugin banner
* Updated readme.txt with fresh infos
* Tested on WordPress version 4.5 beta

**20151109**

* Tested on WordPress 4.4 (beta)
* Updated minimum version requirement
* Updated heading hierarchy on settings page
* Added option to disable GA for admin users (Thanks to [Daniele Raimondi](http://w3b.it/))
* Added support for IP anonymization (Thanks to [Daniele Raimondi](http://w3b.it/))
* Added support for Force SSL (Thanks to [Česlav Przywara](http://www.bluechip.at/))
* Cleaned up some "Undefined index" Notices
* Removed 404 link from Important Notice panel
* Updated Google links in the Overview panel
* Refined google_analytics_tracking_code()
* Updated default GA ID, UA-XXXXX-Y
* Added default tracker object, "auto"
* Updated Google URLs in the readme.txt
* Updated Google URLs in the Options panel
* Updated info about adding custom trackers
* Added support for custom GA code
* General code cleanup and testing

**20150808**

* Tested on WordPress 4.3
* Updated minimum version requirement

**20150507**

* Tested with WP 4.2 + 4.3 (alpha)
* Changed a few "http" links to "https"
* Added isset() to eliminate some PHP warnings

**20150314**

* Tested with latest version of WP (4.1)
* Increased minimum version to WP 3.8
* Added Text Domain and Domain Path to file header
* Streamline/fine-tune plugin code
* Removed valign="top" from settings page
* Added option to enable GA reporting in Admin Area
* Added alert/notice on settings page about Universal Analytics
* Removed deprecated screen_icon()
* Replaced default .mo/.po templates with .pot template

**20140922**

* Tested with latest version of WP (4.0)
* Increased minimum version to WP 3.7
* Added conditional check for min-version function
* Added optional field to display any other codes
* Improved layout and terminology of settings page
* Updated GA code for Display Advertising
* Added support for Enhanced Link Attribution
* Added support for Tracker Objects
* Refactored google_analytics_tracking_code()
* Updated mo/po translation files

**20140123**

* Tested with latest WordPress (3.8)
* Added trailing slash to load_plugin_textdomain()

**20131107**

* Added uninstall.php file
* Added "rate this plugin" links
* Added support for i18n

**Version 20131104**

* Added line to check for WP, prevent direct loading of script
* Added support for [Display Advertising](https://support.google.com/analytics/answer/2444872)
* Added support for [Universal Analytics/Analytics.js](https://developers.google.com/analytics/devguides/collection/analyticsjs/)
* Removed closing "?>" from ga-google-analytics.php
* Tested with the latest version of WordPress (3.7)

**Version 20130705**

* Added option to display in header or footer
* Overview and Updates admin panels toggled open by default
* Implemented translation support
* Added info to settings page
* General plugin check and code tuning

**Version 20130103**

* Added margins to submit buttons (now required in WP 3.5)

**Version 20121102**

* Revamped plugin settings page
* Fine-tuned and further tested
* Fleshed out documentation
* New graphics and copy

**Version 20120409**

* Initial release.
