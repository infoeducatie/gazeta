=== Creative Commons Configurator ===
Contributors: gnotaras
Donate link: http://bit.ly/1aoPaow
Tags: cc, cc0, license, public domain, metadata, legal, creative, commons, seo, attribution, copyright, cc license, creative commons, cc zero, rights, copyright
Requires at least: 2.7
Tested up to: 4.2
Stable tag: 1.8.7
License: Apache License v2
License URI: http://www.apache.org/licenses/LICENSE-2.0.txt


Helps you publish your content under the terms of Creative Commons and other licenses.


== Description ==

[Creative-Commons-Configurator](http://www.g-loaded.eu/2006/01/14/creative-commons-configurator-wordpress-plugin/ "Official Creative-Commons-Configurator Homepage") is the only tool a user will ever need in order to license the contents of WordPress powered web site under the terms of a [Creative Commons](http://creativecommons.org/) or other license. Configuration of the plugin is possible through its configuration panel. Advanced users can further customize the plugin and extend its functionality through filters. It is actively maintained since 2006 (historical [Creative-Commons-Configurator home](http://www.g-loaded.eu/2006/01/14/creative-commons-configurator-wordpress-plugin/ "Official historical Creative-Commons-Configurator Homepage")).

The following licenses are built-in:

- All [Creative Commons](http://creativecommons.org/licenses/) 4.0 licenses.
- The <a href="http://creativecommons.org/about/cc0">CC0</a> rights waiver by Creative Commons.
- Although not a license and not recommended, the *All Rights Reserved* clause.

= Quick Start =

Making all your content available under the terms of a single license is as easy as selecting a default global license in the plugin's configuration screen. In the same screen you can customize various details of the license text and also the looks of the displayed license block.

For those who license their content under various licenses, it is possible to customize the license on a per post basis from the *License* box in the post editing screen. If this is still not enough, the `[license]` shortcode is available, which can be used to generate quick license badges to easily add licensing information to parts of a single post.

The built-in licenses can be customized via filters and also the plugin can be extended in order to support custom licences.

The features at a glance:

- Configuration screen in the WordPress administration panel under the path `Settings->License`.
- Custom license on a per post basis.
- Shortcode that generates license badges. See the dedicated section below for usage information.
- A license widget is available to add to your sidebars.
- Licensing meta information can be added to:
 - The HTML head area (Not visible to human visitors).
 - The Atom, RSS 2.0 and RDF (RSS 1.0) feeds through the Creative Commons RSS module, which validates properly. This option is compatible only with WordPress 2 or newer due to technical reasons.
 - A block with licensing information under the published content.
- Some template tags are provided for use in your theme templates.
- The text generated for each of the built-in licenses can be easily customized.
- The plugin is ready for localization.
- The plugin can be extended to support custom licenses.


= Translations =

There is an ongoing effort to translate Creative-Commons-Configurator to as many languages as possible. The easiest way to contribute translations is to register to the [translations project](https://www.transifex.com/projects/p/cc-configurator "Creative-Commons-Configurator translations project") at the Transifex service.

Once registered, join the team of the language translation you wish to contribute to. If a team does not exist for your language, be the first to create a translation team by requesting the language and start translating.


= Free License and Donations =

*Creative-Commons-Configurator* is released under the terms of the <a href="http://www.apache.org/licenses/LICENSE-2.0.html">Apache License version 2</a> and, therefore, is **Free software**.

However, a significant amount of **time** and **energy** has been put into developing this plugin, so, its production has not been free from cost. If you find this plugin useful and, if it has made your life easier, you can show your appreciation by making a small <a href="http://bit.ly/1aoPaow">donation</a>.

Thank you in advance for **donating**!


= Code Contributions =

If you are interested in contributing code to this project, please make sure you read the [special section](http://wordpress.org/plugins/creative-commons-configurator-1/other_notes/#How-to-contribute-code "How to contribute code") for this purpose, which contains all the details.


= Support and Feedback =

Please post your questions and provide general feedback and requests at the [Creative-Commons-Configurator Community Support Forum](http://wordpress.org/support/plugin/creative-commons-configurator-1/).

To avoid duplicate effort, please do some research on the forum before asking a question, just in case the same or similar question has already been answered.

Also, make sure you read the [FAQ](http://wordpress.org/plugins/creative-commons-configurator-1/faq/ "Creative-Commons-Configurator FAQ").


= License Shortcode =

The `License` shortcode allows you quickly generate license badges. These can be used to indicate that parts of your post have a different license. The shortcode can be used like this:

`[license]`

The following parameters are supported:

- `type`: (string) (required): The type of the license. This has to be one of the license types supported by the plugin. If the parameter is missing, it will print the supported types. For instance: `cc__by, cc__by-nd, cc__by-sa, cc__by-nc, cc__by-nc-nd, cc__by-nc-sa, cc0`. There is no default.
- `compact`: (string) (0|1): Whether to use the compact license images or not. The default is "1".
- `link`: (string) (0|1): Whether to create an image link to the license page or output just the `<img>` element. The default is "1".

Examples:

`
[license type="cc__by-sa"]
[license type="cc__by-sa compact="0"]
[license type="cc__by-sa compact="0" link="0"]
`

= Template Tags =

This plugin provides some *Template Tags*, which can be used in your theme templates. These are the following:

**NOTE**: Template tags will be revised in upcoming versions.

TODO


= Advanced Customization =

Creative-Commons-Configurator allows filtering of some of the generated metadata and also of some core functionality through filters. This way advanced customization of the plugin is possible.

TODO: update the filter list.

The available filters are:

1. `bccl_cc_license_text` - applied to the text that is generated for the Creative Commons License. The hooked function should accept and return 1 argument: a string.
1. `bccl_cc0_license_text` - applied to the text that is generated for the CC0 rights waiver. The hooked function should accept and return 1 argument: a string.
1. `bccl_arr_license_text` - applied to the text that is generated for All Rights Reserved clause. The hooked function should accept and return 1 argument: a string.
1. `bccl_widget_html` - applied to the HTML code that is generated for the widget. The hooked function should accept and return 1 argument: a string.
1. `widget_title` - applied to the title of the license widget. The hooked function should accept and return 1 argument: a string.
1. `bccl_license_metabox_permission` - applied to the metabox permission. The hooked function should accept and return 1 argument: a string. By default, the `edit_posts` is used.
1. `bccl_licenses` - applied to the array of the supported licenses. The hooked function should accept and return 1 argument: an array of licenses (see `bccl-licenses.php` for details).
1. `bccl_default_license` - applied to the license slug that will be used for the current post. The hooked function should accept and return 1 argument: a string (see `bccl-licenses.php` for details).
1. `bccl_supported_post_types` - applied to the array of the supported post types. The hooked function should accept and return 1 argument: an array of post types.


**Example 1**: you want to append a copyright notice under any CC license text.

This can easily be done by hooking a custom function to the `bccl_full_license_block_cc` filter:

`
function append_copyright_notice_to_cc_text( $license_text ) {
    $extra_text = '<br />Copyright &copy; ' . get_the_date('Y') . ' - Some Rights Reserved';
    return $license_text . $extra_text;
}
add_filter( 'bccl_full_license_block_cc', 'append_copyright_notice_to_cc_text', 10, 1 );
`
This code can be placed inside your theme's `functions.php` file.


**Example 2**: You would like to add support for another license, for example the WTFPL.

This can easily be done by hooking a custom generator function to the `bccl_licenses` filter:

`
// Example WTFPL generator.
function bccl_wtfpl_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {
    // Here we use exactly the same templates as the CC licenses,
    // which should be suitable for any kind of permissive copyright based license.
    $templates = bccl_default_license_templates();
    // In case we need to customize the default templates, here is how to do it:
    //$templates = array_merge( bccl_default_license_templates(), array(
    //    // Supported template tags: #work#, #creator#, #license#, #year#
    //    'license_text_long' => __('#work#, written by #creator# in #year#, has been published under the terms of the #license#.', 'cc-configurator'),
    //    // Supported template tags: #license#, #year#
    //    'license_text_short' => __('This article is published under a #license#.', 'cc-configurator'),
    //    // Supported template tags: #page#
    //    'extra_perms' => __('More information about how to reuse or republish this work may be available in our #page# section.', 'cc-configurator')
    //));
    // Finally we use the base generator to build and return the HTML content.
    // The base generator should be suitable for any type of license.
    return bccl_base_generator( $license_slug, $license_data, $post, $options, $minimal, $templates );
}
// Add the WTFPL license to the array of available licenses.
function bccl_add_wtfpl_license( $licenses ) {
    $licenses['wtfpl'] = array(         // slug (unique for each license)
        'url' => 'http://www.wtfpl.net/about/',    // URL to license page
        'name' => 'WTFPL International License',   // Name of the license
        'name_short' => 'WTFPL',
        'button_url' => 'http://www.wtfpl.net/wp-content/uploads/2012/12/wtfpl-badge-1.png', // URL to license button
        'button_compact_url' => 'http://www.wtfpl.net/wp-content/uploads/2012/12/wtfpl-badge-2.png', // URL to a small license button
        'generator_func' => 'bccl_wtfpl_generator'
    );
    return $licenses;
}
add_filter( 'bccl_licenses', 'bccl_add_wtfpl_license' );
`
This code can be placed inside your theme's `functions.php` file or in a custom plugin.


== Installation ==

1. Extract the compressed (zip) package in the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the plugin's administration panel at `Options->License` to read the detailed instructions about customizing the display of license information.

Read more information about the [Creative-Commons-Configurator](http://www.g-loaded.eu/2006/01/14/creative-commons-configurator-wordpress-plugin/ "Official Creative-Commons-Configurator Homepage").


== Upgrade Notice ==

No special requirements when upgrading.


== Frequently Asked Questions ==

= There is no amount set in the donation form! How much should I donate? =

The amount of the donation is totally up to you. You can think of it like this: Are you happy with the plugin? Do you think it makes your life easier or adds value to your web site? If this is a yes and, if you feel like showing your appreciation, you could imagine buying me a cup of coffee at your favorite Cafe and <a href="http://bit.ly/1aoPaow">make a donation</a> accordingly.

= Will this plugin support other licenses apart from Creative-Commons licenses? =

Currently there are no plans to support other licenses.

= Where can I get support? =

You can get first class support from the [community of users](http://wordpress.org/support/plugin/creative-commons-configurator-1 "Creative-Commons-Configurator Users"). Please post your questions, feature requests and general feedback in the forums.

Keep in mind that in order to get helpful answers and eventually solve any problem you encounter with the plugin, it is essential to provide as much information as possible about the problem and the configuration of the plugin. If you use a customized installation of WordPress, please make sure you provide the general details of your setup.

Also, my email can be found in the `cc-configurator.php` file. If possible, I'll help. Please note that it may take a while to get back to you.

= Is there a bug tracker? =

You can find the bug tracker at the [Creative-Commons-Configurator Development web site](http://www.codetrax.org/projects/wp-cc-configurator).


== Screenshots ==

1. Creative-Commons-Configurator administration interface.


== Changelog ==

In the following list there are links to the changelog of each release:

- [1.8.7](http://www.codetrax.org/versions/248)
 - Improved the license generator engine with string based templates and implemented advanced filtering of the generated HTML code for easy customizations via filters.
 - The shortcode now returns an empty string instead of an error message if an invalid type has been set. The error message indicating the supported license types is still being printed, but only if the `type` parameter (required) is missing.
- [1.8.6](http://www.codetrax.org/versions/247)
 - Minor code improvements.
 - Updated features in readme.txt.
 - Updated translations.
- [1.8.5](http://www.codetrax.org/versions/234)
 - Added extra permissions clause in the CC0 generator.
 - Option for "No License" has been added.
 - Added the License Shortcode for quick license badge generation. These badges can be used to indicate different licensing for specific parts of the post.
- [1.8.4](http://www.codetrax.org/versions/233)
- [1.8.3](http://www.codetrax.org/versions/201)
 - Various minor improvements.
 - Updated translations.
- [1.8.2](http://www.codetrax.org/versions/241)
 - Improved the way admin styles and scripts are enqueued.
 - Added filters for the customization of the extra permissions clause in CC and ARR.
- [1.8.1](http://www.codetrax.org/versions/240)
- [1.8.0](http://www.codetrax.org/versions/239)
 - IMPORTANT: Major changes in functionality. Backwards incompatible default license. Reset the default license.
 - Hard coded licenses instead of online license selectors.
 - Full customization via filters.
- [1.5.3](http://www.codetrax.org/versions/195)
 - Updated translations.
- [1.5.2](http://www.codetrax.org/versions/200)
 - Updated translations (thanks: Jani Uusitalo, bzg, Matthias Heil, alvaroto, bizover)
- [1.5.1](http://www.codetrax.org/versions/133)
 - Some license customization on a per post basis has been implemented (options: use default, opt-out, CC0, ARR)
 - Refactoring.
- [1.5.0](http://www.codetrax.org/versions/181)
 - Refactoring.
 - Re-designed mechanism that manages the settings.
 - Full support for SSL admin panel.
 - A Creative Commons widget is now available.
- [1.4.1](http://www.codetrax.org/versions/134)
- [1.4.0](http://www.codetrax.org/versions/128)
- [1.3.2](http://www.codetrax.org/versions/131)
- [1.3.1](http://www.codetrax.org/versions/129)
- [1.3.0](http://www.codetrax.org/versions/127)
- [1.2](http://www.codetrax.org/versions/7)
- [1.1](http://www.codetrax.org/versions/5)
- [1.0](http://www.codetrax.org/versions/22)
- [0.6](http://www.codetrax.org/versions/45)
- [0.5](http://www.codetrax.org/versions/44)
- [0.4](http://www.codetrax.org/versions/43)
- [0.2](http://www.codetrax.org/versions/42)
- [0.1](http://www.codetrax.org/versions/41)



== How to contribute code ==

This section contains information about how to contribute code to this project.

Creative-Commons-Configurator is released under the Apache License v2.0 and is free open-source software. Therefore, code contributions are more than welcome!

But, please, note that not all code contributions will finally make it to the main branch. Patches which fix bugs or improve the current features are very likely to be included. On the contrary, patches which add too complicated or sophisticated features, extra administration options or transform the general character of the plugin are unlikely to be included.

= Source Code =

The repository with the most up-to-date source code can be found on Bitbucket (Mercurial). This is where development takes place:

`https://bitbucket.org/gnotaras/wordpress-creative-commons-configurator`

The main repository is very frequently mirrored to Github (Git):

`https://github.com/gnotaras/wordpress-creative-commons-configurator`

The Subversion repository on WordPress.org is only used for releases. The trunk contains the latest stable release:

`http://plugins.svn.wordpress.org/creative-commons-configurator-1/`

= Creating a patch =

Using Mercurial:

`
hg clone https://bitbucket.org/gnotaras/wordpress-creative-commons-configurator
cd wordpress-creative-commons-configurator
# ... make changes ...
hg commit -m "fix for bug"
# create a patch for the last commit
hg export --git tip > bug-fix.patch
`

Using Git:

`
git clone https://github.com/gnotaras/wordpress-creative-commons-configurator
cd wordpress-creative-commons-configurator
# ... make changes to cc-configurator.php or other file ...
git add cc-configurator.php
git commit -m "my fix"
git show > bug-fix.patch
`

Using SVN:

`
svn co http://plugins.svn.wordpress.org/creative-commons-configurator-1/trunk/ creative-commons-configurator-trunk
cd creative-commons-configurator-trunk
# ... make changes ...
svn diff > bug-fix.patch
`

= Patch Submission =

Here are some ways in which you can submit a patch:

* submit to the [bug tracker](http://www.codetrax.org/projects/wp-cc-configurator/issues) of the development website.
* create a pull request on Bitbucket or Github.
* email it to me directly (my email address can be found in `cc-configurator.php`).
* post it in the WordPress forums.

Please note that it may take a while before I get back to you regarding the patch.

Last, but not least, all code contributions are governed by the terms of the Apache License v2.0.


