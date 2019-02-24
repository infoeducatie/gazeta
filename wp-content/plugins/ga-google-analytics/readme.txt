=== GA Google Analytics ===

Plugin Name: GA Google Analytics
Plugin URI: https://perishablepress.com/google-analytics-plugin/
Description: Adds your Google Analytics Tracking Code to your WordPress site.
Tags: analytics, ga, google, google analytics, tracking, statistics, stats
Author: Jeff Starr
Author URI: https://plugin-planet.com/
Donate link: https://m0n.co/donate
Contributors: specialk
Requires at least: 4.1
Tested up to: 4.8
Stable tag: 20170731
Version: 20170731
Text Domain: gap
Domain Path: /languages
License: GPL v2 or later

Adds your Google Analytics Tracking Code to your WordPress site.



== Description ==

This plugin enables Google Analytics for your entire WordPress site. Lightweight and fast with plenty of great features.

**Features**

* Blazing fast performance
* Does one thing and does it well
* Drop-dead simple and easy to use
* Uses latest version of tracking code
* Includes tracking code in header or footer
* Inserts tracking code on all WordPress web pages
* Includes option to add your own custom markup
* Sleek plugin Settings page with toggling panels
* Lightweight, and born of simplicity, no frills
* Option to disable GA on the frontend for admin users
* Option to include or exclude GA in the Admin Area
* Add custom directives to your GA code

This is a lightweight plugin that inserts the required GA tracking code. To view your site statistics, visit your Google Analytics account.

**GA Support**

* Supports [Classic Analytics/ga.js](https://developers.google.com/analytics/devguides/collection/gajs/)
* Supports [Universal Analytics/analytics.js](https://developers.google.com/analytics/devguides/collection/analyticsjs/)
* Supports [Display Advertising](https://support.google.com/analytics/answer/2444872)
* Supports [Enhanced Link Attribution](https://support.google.com/analytics/answer/2558867)
* Supports [Tracker Objects](https://developers.google.com/analytics/devguides/collection/analyticsjs/creating-trackers)
* Supports [IP Anonymization](https://developers.google.com/analytics/devguides/collection/analyticsjs/ip-anonymization)
* Supports [Force SSL](https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference#forceSSL)

Learn more about [Google Analytics](http://www.google.com/analytics/)!



== Installation ==

**Installation**

1. Upload the plugin to your blog and activate
2. Visit the settings to configure your options

After configuring your settings, you can verify that GA code is included by viewing the source code of your web pages.

__Note:__ this plugin adds the required GA code to your web pages. In order for the code to do anything, it must correspond to an active, properly configured Google Analytics account. Learn more at the [Google Analytics Help Center](https://support.google.com/analytics/?hl=en#topic=3544906).

[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)


**Usage**

After entering your GA Property ID, enable the setting "Enable Google Analytics". This enables the legacy tracking method, which is deprecated and soon to be replaced by the new tracking method, "Universal Analytics". To go ahead and start using Universal Analytics right now, also enable the next setting, "Enable Universal Analytics". 

Then from there you can enable advanced tracking functionality such as "Display Advertising" and "Link Attribution", depending on your own statistical strategy. If ever in doubt, consult the official [Google Analytics site](https://developers.google.com/analytics/) and [Help Center](https://support.google.com/analytics/?hl=en#topic=3544906).



**Upgrades**

To upgrade GA Google Analytics, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 

For more information, visit the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).


**Restore Default Options**

To restore default plugin options, either uninstall/reinstall the plugin, or visit the plugin settings &gt; Restore Default Options.


**Uninstalling**

GA Google Analytics cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen.



== Screenshots ==

1. GA Google Analytics: Plugin Settings (panels toggle open/closed)

More screenshots available at the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).



== Upgrade Notice ==

To upgrade GA Google Analytics, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 

For more information, visit the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).



== Frequently Asked Questions ==

**Google Analytic says tracking code is not detected?**

You need to wait awhile for Google to collect some data, like at least a day or whatever. Standard stuff for Google Analytics. For more information, check out the [Google Analytics Help Center](https://support.google.com/analytics/?hl=en#topic=3544906).

**Got a question?**

To ask a question, suggest a feature, or provide feedback, [contact me directly](https://perishablepress.com/contact/). Learn more about [Google Analytics](http://www.google.com/analytics/) and [GA tracking methods](https://perishablepress.com/3-ways-track-google-analytics/).



== Support development of this plugin ==

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a cash donation](https://m0n.co/donate), [bitcoin donation](https://m0n.co/bitcoin), or purchase one of my books:  

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Pro version of Block Bad Queries
* [Blackhole Pro](https://plugin-planet.com/blackhole-pro/) - Pro version of Blackhole for Bad Bots
* [SES Pro](https://plugin-planet.com/ses-pro/) - Super-simple &amp; flexible email signup forms
* [USP Pro](https://plugin-planet.com/usp-pro/) - Pro version of User Submitted Posts

Links, tweets and likes also appreciated. Thanks! :)



== Changelog ==

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
