=== GA Google Analytics ===

Plugin Name: GA Google Analytics
Plugin URI: https://perishablepress.com/google-analytics-plugin/
Description: Adds your Google Analytics Tracking Code to your WordPress site.
Tags: analytics, ga, google, google analytics, tracking, statistics, stats
Author: Jeff Starr
Author URI: http://monzilla.biz/
Donate link: http://m0n.co/donate
Contributors: specialk
Requires at least: 3.9
Tested up to: 4.2
Stable tag: trunk
Version: 20150507
Text Domain: gap
Domain Path: /languages/
License: GPL v2 or later

GA Google Analytics adds your Google Analytics Tracking Code to your WordPress site.

== Description ==

Inserts tracking code only, view your stats in your Google account.

**Features**

* Drop-dead simple and easy to use
* Uses latest version of GA Tracking Code
* Include GA Tracking Code in header or footer
* Inserts your tracking code on all theme pages
* Includes option to add your own custom markup
* Sleek plugin Settings page with toggling panels
* Lightweight, and born of simplicity, no frills
* New! Option to include GA in the Admin Area

**Support**

* Supports [Classic Analytics/ga.js](https://developers.google.com/analytics/devguides/collection/gajs/)
* Supports [Universal Analytics/analytics.js](https://developers.google.com/analytics/devguides/collection/analyticsjs/)
* Supports [Display Advertising](https://support.google.com/analytics/answer/2444872)
* Supports [Enhanced Link Attribution](https://support.google.com/analytics/answer/2558867)
* Supports [Tracker Objects](https://developers.google.com/analytics/devguides/collection/analyticsjs/advanced#creation)

Learn more about [Google Analytics](http://www.google.com/analytics/)!

== Installation ==

**Installation**

1. Unzip, Upload, activate
2. Visit the "Google Analytics" options page, enter your GA ID, and done.
3. Optionally configure other settings for advanced functionality.

[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

**Upgrade Notice**

To upgrade: 

1. Remove old version and replace with new version.
2. Visit the GA Plugin Options panel and choose where to include the code (via the header or footer).
3. Save changes and view the source code of your page(s) to verify that the code is included properly.

For more information, visit the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).

== Screenshots ==

Screenshots available at the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/).

== Changelog ==

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

== Frequently Asked Questions ==

To ask a question, visit the [GA Plugin Homepage](https://perishablepress.com/google-analytics-plugin/) or [contact me](https://perishablepress.com/contact/).

Learn more about [Google Analytics](http://www.google.com/analytics/) and [GA tracking methods](https://perishablepress.com/3-ways-track-google-analytics/).

== Donations ==

I created this plugin with love for the WP community. To show support, you can [make a donation](http://m0n.co/donate) or purchase one of my books: 

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)

Links, tweets and likes also appreciated. Thanks! :)
