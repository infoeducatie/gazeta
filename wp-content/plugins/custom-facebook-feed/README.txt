=== Custom Facebook Feed ===
Contributors: smashballoon
Tags: Facebook, Facebook feed, Facebook posts, Facebook wall, Facebook group
Requires at least: 3.0
Tested up to: 4.8
Stable tag: 2.4.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Custom Facebook Feed allows you to display completely customizable Facebook feeds of any public Facebook page or group on your website

== Description ==

Display a **completely customizable**, **responsive** and **search engine crawlable** version of your Facebook feed on your website. Completely match the look and feel of the site with tons of customization options!

*"The perfect plugin with amazing support! What else do you want? Get it!"* - [JoeJeffries](http://wordpress.org/support/topic/you-dont-already-have-this)

*"I honestly cannot recommend this plugin enough. The plugin itself is gorgeous and super customizable, and if you run into trouble...support will get you out of it. Five Stars across the board."* - [pamsavoybarnett](http://wordpress.org/support/topic/love-this-plugin-w-awesome-support?replies=2)

*"The positive reviews here say it all. John and SmashBalloon are delivering top-notch products and service -- something us website developers value greatly. If I could give them 10 Stars across the board I wouldn't hesitate. Cheers!"* - [AME Network](http://wordpress.org/support/topic/excellent-plugin-superior-support?replies=1)

= Features =

* **Completely Customizable** - By default the Facebook feed will adopt the style of your website, but can be completely customized to look however you like - with tons of styling and customization options!
* Facebook feed content is **crawlable by search engines** adding SEO value to your site - other Facebook plugins embed the feed using iframes which are not crawlable
* Completely **responsive** and mobile optimized - layout looks great on any screen size and in any container width
* Display **feeds from multiple different Facebook pages/groups** and use the shortcode to embed them into a page, post or widget anywhere on your site
* Show **events** from your Facebook feed with name, date/time, location and description
* Add your own **custom CSS**
* **Caching** means that your Facebook posts load lightning fast. Set your own caching time - check for new posts on Facebook every few seconds, minutes, hours or days. You decide.
* **Super simple to set up**. Just enter your Facebook page ID and you're done.
* Show and hide certain parts of each Facebook post
* Show or hide the Facebook profile picture and name of the author above each post
* Display Facebook posts by just the page owner, everyone who posts on your Facebook page, or only other people
* Control the width, height, padding and background color of your Facebook feed
* Customize the size, weight and color of text
* Choose to set a background color and rounded corners on your Facebook posts
* Supports Facebook tags - creates links when using the @ symbol to tag people in your Facebook posts
* Automatically links hashtags used in posts to the hashtag page on Facebook
* Select the number of Facebook posts to display
* Select from a range of date formats or enter your own
* Use your own custom link text in place of the defaults
* Use the shortcode options to style multiple Facebook feeds in completely different ways
* Set a maximum character length for both the text and descriptions of your Facebook posts
* Create a customizable header with a range of icons for your Custom Facebook Feed
* Localization/i18n support to allow every part of the feed to be displayed in your language

= Pro Version =

In order to maintain the free version of the plugin on an ongoing basis, and to provide quick and effective support for free, we offer a Pro version of the plugin. The Pro version allows you to display photos, videos, the number of likes, shares, reactions and comments for each Facebook post, choose from multiple layout options, filter posts by type or #hashtag/string, load more posts into your feed, and more. [Click here](https://smashballoon.com/differences-between-the-free-version-and-pro-version-of-the-custom-facebook-feed-plugin/ "Differences between free and Pro version of Custom Facebook Feed plugin") for a full list of all differences between the free version and Pro version.

* [Find out more about the Pro version](https://smashballoon.com/custom-facebook-feed/ "Custom Facebook Feed Pro")
* [Try out the Pro demo](https://smashballoon.com/custom-facebook-feed/demo "Custom Facebook Feed Pro Demo").

= Benefits of the Custom Facebook Feed plugin =

* **Increase social engagement** between you and your users, customers, fans or group members
* **Save time** by using the Custom Facebook Feed to generate dynamic, search engine crawlable content on your website
* **Get more likes** by displaying your Facebook content directly on your site
* **Improve your SEO** as all of that quality keyword-rich Facebook content from posts and comments is directly embedded into your website
* Display your Facebook content your way to perfectly match your website's style
* **No Coding Required** - choose from tons of built-in customization options to create a truly unique feed of your Facebook content.
* The plugin is **updated regularly** with new features, bug-fixes and Facebook API changes
* Support is quick and effective
* We're dedicated to providing the **most customizable**, **robust** and **well supported** Facebook feed plugin in the world!

== Installation ==

1. Install the Custom Facebook Feed either via the WordPress plugin directory, or by uploading the files to your web server (in the `/wp-content/plugins/` directory).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the 'Facebook Feed' settings page to configure your feed.
4. Use the shortcode `[custom-facebook-feed]` in your page, post or widget to display your feed.
5. You can display multiple feeds of different Facebook pages by specifying a Page ID directly in the shortcode: `[custom-facebook-feed id=smashballoon num=5]`.

== Frequently Asked Questions ==

For a full list of FAQs and help with troubleshooting please visit the **[FAQ & Troubleshooting](https://smashballoon.com/custom-facebook-feed/faq/)** section of the Smash Balloon website

= How do I find the Page ID of my Facebook page or group? =

If you have a Facebook **page** with a URL like this: `https://www.facebook.com/smashballoon` then the Page ID is just `smashballoon`. If your page URL is structured like this: `https://www.facebook.com/pages/smashballoon/123654123654123` then the Page ID is actually the number at the end, so in this case `123654123654123`.

If you have a Facebook **group** then use [this tool](http://lookup-id.com/ "Look Up my ID") to find your Group ID.

Copy and paste the ID into the [Pro demo](https://smashballoon.com/custom-facebook-feed/demo/) to test it.

= Are there any limitations on which Facebook page or group feeds I can display? =

The Facebook feed you're trying to display has to be from a publicly accessible Facebook page or group. This means that you can't display the feed from your own personal Facebook profile or private Facebook group. This is to do with Facebook's privacy policies. You can't display a non-public Facebook feed publicly.

If your Facebook page has any restrictions on it (age, for example) then it means that people have to be signed into Facebook in order to view your page. This isn't desirable for most Facebook pages as it means that it isn't accessible by people who don't have a Facebook account and that your Facebook page can't be crawled and indexed by search engines.

An easy way to determine whether your Facebook page is set to public is to sign out of your Facebook account and try to visit your page. If Facebook forces you to sign in to view your page then it isn't public. You can change your Facebook page to public in your Facebook page settings simply by removing any age or location restrictions you have on it ([screenshot](https://smashballoon.com/wp-content/uploads/2013/06/facebook-page-restrictions.png)), which will then allow the Custom Facebook Feed plugin to access and display your feed.

= Can I display feeds from multiple Facebook pages or groups? =

You can set your default Facebook Page ID on the Custom Facebook Feed settings page within the WordPress admin, you can then define different page IDs in the shortcodes you use to show multiple feeds from different Facebook pages. Just use the id option in your shortcode like so: [custom-facebook-feed id=another_page_id]. You can use as many shortcodes as you like with as many different IDs as you like.

= Can I display the feed from a personal Facebook profile? =

Due to Facebook's privacy policy you're not able to use the plugin to display all of your posts from a personal profile, only from a public page or group, as posts from a personal profile are protected for privacy reasons. You may have limited success in displaying certain posts from a personal profile but most posts are not able to be displayed.

If you're using the profile to represent a business, organization, product, public figure or the like, then we'd advise converting your profile to a page per [Facebook's recommendation](http://www.facebook.com/help/175644189234902/), as there are many advantages to using pages over profiles.

Once you've done so, the plugin will be able to retrieve and display all of your posts.

= Can I show photos and videos in my Custom Facebook feed? =

This free plugin only allows you to display text from your Facebook posts. To display photos and videos in your feed you would need to upgrade to the Pro version of the plugin. Try out a demo of the Pro version on the [Custom Facebook Feed website](https://smashballoon.com/custom-facebook-feed/demo "Custom Facebook Feed Demo"), and find out more about the Pro version [here](https://smashballoon.com/custom-facebook-feed/ "Custom Facebook Feed Pro"). [Click here](https://smashballoon.com/differences-between-the-free-version-and-pro-version-of-the-custom-facebook-feed-plugin/ "Differences between free and Pro version of Custom Facebook Feed plugin") for a full list of all differences between the free version and Pro version.

= Can I show the comments, shares and likes associated with each Facebook post? =

This is a feature of the [Pro version of the plugin](https://smashballoon.com/custom-facebook-feed/ "Custom Facebook Feed Pro"). To display comments, shares and likes you would need to upgrade from the free version to the Pro version.

= Is the content of my Custom Facebook Feed crawlable by search engines? =

It sure is. Unlike other Facebook plugins which use iframes to embed your Facebook feed into your page once it's loaded, the Custom Facebook Feed uses PHP to embed your Facebook feed content directly into your page. This adds dynamic, search engine crawlable content to your site.

= How do I embed the Custom Facebook Feed directly into a WordPress page template? =

You can embed your Facebook feed directly into a template file by using the WordPress [do_shortcode](http://codex.wordpress.org/Function_Reference/do_shortcode "WordPress.org do_shortcode reference") function: `<?php echo do_shortcode('[custom-facebook-feed]'); ?>`.

= My Facebook feed posts are not showing up, or all I can see is the Facebook Like box but no posts =

Please refer to [this FAQ](https://smashballoon.com/facebook-feed-doesnt-show-can-see-like-box-posts-gives/ "My Facebook feed posts are not showing up, or all I can see is the Facebook Like box but no posts") for potential solutions on how to resolve this issue.

= Create a basic slideshow from your Facebook posts =

The Custom Facebook Feed plugin doesn't currently have a slideshow feature built into it, but it's possible to achieve a basic slideshow by doing the following:

1) Add a class to the shortcode of the Facebook feed that you want to convert into a slideshow:

`[custom-facebook-feed class="slideshow"]`

2) Set the number of posts to display to be the number of Facebook posts you want to include in the slideshow (10 for example). You can do this by using the `num` shortcode option:

`[custom-facebook-feed class="slideshow" num=10]`

3) Add the following to the plugin's **Custom JavaScript** section, which is under the 'Misc' tab on the plugin's 'Customize' page. Please note, if you change the class option in the shortcode above to be anything but "slideshow" then make sure to change that on the first line of the snippet below:

`var shortcodeClass = 'slideshow',
    cffSpeed = 5000, 
    $cff = $('#cff.'+ shortcodeClass);
    $cffItem = $cff.find('.cff-item'),
    cffNum = $cffItem.length,
    cffCur = 0;
$cffItem.hide();
setTimeout(function(){ $cff.find('.cff-item').eq(0).show(); }, 200);
setInterval(function(){
    $cff.find('.cff-item').eq(cffCur).fadeOut( "fast", function() {
        if( cffCur == cffNum-1 ) cffCur = -1;
        cffCur++;
        $cff.find('.cff-item').eq(cffCur).fadeIn();
    });
}, cffSpeed);`

4) You can change the speed of the transition by editing the **cffSpeed = 5000** value at the top of the snippet. 5000 is equal to 5 seconds (5000ms).

= Changing the font in your Facebook feed and using Google Fonts =

Please refer to [this FAQ](https://smashballoon.com/changing-the-font-in-your-facebook-feed-using-google-fonts/ "Changing the font in your Facebook feed and using Google Fonts") for directions on how to use Google fonts in your Facebook posts.

= Can I display my Facebook posts horizontally or in multiple columns? =

Please refer to [this FAQ](https://smashballoon.com/can-display-facebook-post-horizontally-multiple-columns/ "Can I display my Facebook posts horizontally or in multiple columns?") for directions on how to display your Facebook posts in multiple columns.

= My Facebook feed appears to have stopped updating / working =

If your Facebook feed doesn't appear to be showing the most recent Facebook posts then the most likely explanation is that the recent Facebook posts in your feed may be shared from a user's personal Facebook profile. Facebook's privacy policy doesn't allow posts that you share from personal Facebook profiles to be shared outside of Facebook as the posts don't technically belong to your Facebook page, they belong to the user who posted it to their personal Facebook profile. There's an example of a post shared from a user's personal Facebook profile [here](https://smashballoon.com/wp-content/uploads/2014/11/sharing-photo-facebook-profile.jpg "Example of Facebook post shared from personal Faceboo profile").

Please note, this isn't a limitation of our plugin, it's a restriction which Facebook places on it's content in order to protect the privacy of their Facebook users.

**Potential solutions**

* You could re-post the Facebook post to your page rather than sharing it to your Facebook page. If you re-post the content as your own post on your Facebook page then the content now originates from your Facebook page and will be displayed in the Facebook feed on your website.

* If you were to share a post from another Facebook page or public source, rather than sharing it from someone's personal Facebook profile, then it would show up in your feed outside of Facebook, but by default any posts that originate from a personal Facebook profile are protected by Facebook's privacy policy and is the private content of that Facebook profile owner.

= I'm receiving an error message when trying to display my Facebook posts =

Please refer to our [Error Message Reference page](https://smashballoon.com/custom-facebook-feed/docs/errors/ "I'm receiving an error message when trying to display my Facebook posts") for information on how to resolve common error messages.

= Creating a Masonry grid layout from your Facebook posts =

Please refer to [this FAQ](https://smashballoon.com/creating-a-masonry-grid-layout-from-your-facebook-posts/ "Creating a Masonry grid layout from your Facebook posts") for directions on how to create a Masonry grid layout from your Facebook feed posts.

= How do I customize my Facebook feed? =

You can customize the Facebook feed by setting the options on the Customize page, which can be found under the Facebook Feed menu in your left hand WordPress admin menu. If you need even deeper customization than the built in options allow then you can add your own CSS to the plugin in the Custom CSS section under the Misc tab to further customize your Facebook feed.

You can also override these styles for individual Facebook feeds by setting options within the shortcode. For example, you can change the height of a specific Facebook feed like so: `[custom-facebook-feed height=500px]`.

= The Custom Facebook Feed shortcode options aren't working =

The most common causes of this are:

1) There's HTML tags within the [custom-facebook-feed] shortcode which are preventing it from working correctly

If you copied and pasted the shortcode into the Visual editor on your WordPress page/post editor then it may have inadvertently included some HTML tags from the page that you copied it from. The easiest way to check this is to view the 'Text' view in your WordPress editor and see whether there are any stray HTML tags in the shortcode itself.

2) The shortcode includes curly single quote characters

If your shortcode includes single quotes then check that they are the standard single quotes and not the curly kind.

3) Typo in the shortcode option

Ensure that there aren't any spelling errors in the shortcode options that you're using and that the format is consistent with that demonstrated on the [Shortcode Options reference page](https://smashballoon.com/custom-facebook-feed/docs/shortcodes/ "The shortcode options aren't working").

= Facebook avatar pictures aren't showing up in my Facebook feed =

The most common reason for this is that an add-on or extension you have installed in your web browser is blocking the pictures being loaded from Facebook. Try checking to see whether you have any add-ons or extensions installed in your browser and, if so, try disabling them to see whether that solves the problem and displays the pictures from Facebook.

= How to get a Facebook Access Token =

**For step-by-step instructions and screenshots on how to get a Facebook Access Token just follow the [Facebook Access Token instructions](https://smashballoon.com/custom-facebook-feed/access-token/ "Facebook Access Token instructions") on the Smash Balloon website.**

You no longer need your own Access Token to use the Custom Facebook Feed Plugin, but if you'd like to use your own then you will need to obtain one from Facebook.  Don't worry though, this is really easy to do.  Just follow the steps below:

**1)** Go to [developers.facebook.com](http://developers.facebook.com "Facebook developers website") and click on Log In in the top right.  Log in using your personal Facebook credentials.

**Note:** The personal Facebook account that you use to register as a Facebook developer does not need to be associated in any way with the Facebook page or Facebook group whose posts you want to display. You can use the Facebook Access Token you receive to display the Facebook posts from any public Facebook page or open Facebook group.

**Note:** You cannot log in to the Facebook Developer site using a Facebook Page or Facebook Business account. You must use the username and password from your personal Facebook profile. Facebook doesn't allow businesses to register as Facebook developers, only individuals.

**2)** If this is your first time signing in to the Facebook Developer portal then click on Register Now. Registering is a quick an easy process which will take less than a couple of minutes.  If you're already registered as a Facebook developer then you can skip ahead to step 9.

**3)** Accept the Facebook terms and click Continue.

**4)** Enter your phone number to confirm your account.

**5)** Facebook will send you an automated text message containing a confirmation code. Enter it in the box and click Confirm.

**6)** Choose to share your phone number with Only Me (unless you wish to share it with publicly or with Facebook friends).

**7)** You can skip the next step by clicking Skip.

**8)** Click Done.
 
**9)** Now click on Create New App.

**10)** Enter your Facebook App Name. This can be anything you like. Click Continue.

**11)** Fill in Facebook's Security Check and click Continue.

**12)** Your Facebook App should now be set up. Copy and paste your Facebook App ID and Facebook App Secret into the fields in the last step of the [Access Token instructions](https://smashballoon.com/custom-facebook-feed/access-token/ "How to get a Facebook Access Token") to retrieve your Facebook Access Token.

== Other Notes ==

= At Smash Balloon we have two goals: =

1. Creating and maintaining the most useful, functional, customizable, robust and down-right awesomist Facebook feed plugin your website has ever seen.
2. To provide the quickest, friendliest and most mind-blowingly amazing product support you have ever experienced.

== Screenshots ==

1. By default the Facebook feed inherits your theme's default styles and is completely responsive
2. Completely customize the way your Facebook feed looks to perfectly match your site
3. Use custom CSS to customize every part of the Facebook feed
4. Display Facebook events
5. Configuring the Custom Facebook Feed plugin
6. General options - Custom Facebook Feed Layout & Style page
7. Typography options - Custom Facebook Feed Layout & Style page
8. Misc options - Custom Facebook FeedLayout & Style page
9. It's super easy to display your Facebook feed in any page or post

== Changelog ==

= 2.4.6 =
* Compatible with WordPress 4.8

= 2.4.5 =
* Tweak: Updated plugin links for new WordPress.org repo
* Fix: Minor bug fixes

= 2.4.4 =
* New: If your Facebook posts have been created in more than one language on Facebook then it's now possible to display each language by using the `locale` setting in the shortcode. Eg: English: `[custom-facebook-feed locale=en_EN]`, German: `[custom-facebook-feed locale=de_DE]`
* Fix: Fixed an issue with the order of group posts in some feeds

= 2.4.3 =
* Fix: Fixed a potential security vulnerability
* Tested with upcoming WordPress 4.6 update

= 2.4.2 =
* Tweak: Group wall feed posts are now ordered based on recent activity, rather than by the date they were created, to better reflect the order on the Facebook Group wall.
* Tweak: The "5 hours ago" date text strings can now be translated directly in the shortcode if you're displaying different feeds in different languages. See the bottom of the [Shortcode Options table](https://smashballoon.com/custom-facebook-feed/docs/shortcodes/) for more information.
* Tweak: Created some specific [setup directions](https://smashballoon.com/custom-facebook-feed/docs/free/) for the free version.
* Fix: Minor bug fixes

= 2.4.1.2 =
* Updated to be compatible with Facebook API version 2.6

= 2.4.1.1 =
* Fix: Fixed a JavaScript error in the admin area when using WordPress 4.5

= 2.4.1 =
* New: If a post contains either a photo or video then an icon and link are now added to view it on Facebook. You can disable this by unchecking the "Media Link" option in the following location: Customize > Post Layout > Show/Hide. You can also remove it by using the "exclude" shortcode option: exclude="medialink". You can translate or change the text for this link on the "Custom Text / Translate" settings page.
* Tweak: Tested with WordPress 4.5
* Fix: Fixed an issue where the "Share" button in the plugin Like Box wasn't working correctly
* Fix: Added support for wp-config proxy settings. Credit to [@usrlocaldick](https://wordpress.org/support/topic/proxy-support-1) for the patch.

= 2.4 =
* New: Added a setting to allow you to use a fixed pixel width for the Facebook feed on desktop but switch to a 100% width responsive layout on mobile
* New: You can now click on the name of a setting on the admin pages to reveal the corresponding shortcode for that setting
* New: Added quick links to the top of the Customize settings pages to make it easier to find certain settings
* New: Added a setting to allow you to disable the default plugin text and link styles (Customize > Misc > Disable default styles)
* New: Added a setting which allows you to manually change the request method used to fetch Facebook posts which is necessary for some server setups
* Tweak: Updated the Font Awesome icon font to version 4.5
* Tweak: Moved the 'Show Header' setting to the 'General' tab on the Customize page
* Fix: Hashtag linking now works with all languages and character sets
* Fix: Fixed an error that occurred when trying to activate the Pro version with the free version still activated
* Fix: Fixed a rare error which occurred when the Facebook post contained no text and no story
* Fix: Fixed an issue when trying to display Facebook posts by only visitors to your Facebook page caused by a recent Facebook API update

= 2.3.10 =
* Fix: If you're experiencing an issue with your Facebook feed not automatically updating successfully then please update the plugin and enable the following setting: Custom Facebook Feed > Customize > Misc > Misc Settings > Force cache to clear on interval. If you set this setting to 'Yes' then it should force your plugin cache to clear either every hour, 12 hours, or 24 hours, depending on how often you have the plugin set to check Facebook for new posts.

= 2.3.9 =
* Fix: Fixed an issue caused by the recent Facebook API 2.5 update where the posts wouldn't display when using a brand new Access Token

= 2.3.8 =
* Fix: Fixed a positioning issue with the Facebook "Like Box / Page Plugin" widget caused by a recent Facebook update which was causing it to overlap on top of other content
* Fix: Hashtags containing Chinese characters are now linked
* Fix: Fixed a minor issue in shared link posts where the post text linked to the shared link URL instead of the post on Facebook
* Tweak: Added a timezone for Sydney, Australia

= 2.3.7 =
* Fix: Fixed an issue caused by the WordPress 4.3 update where feeds from very long page IDs wouldn't update correctly due to the cache not clearing when expired
* Fix: Removed specific encoding parameters from the cURL request method to prevent encoding issues on some servers

= 2.3.6 =
* New: Added a couple of new customization options for the Facebook Like Box/Page Plugin which allow you to select a small/slim header for the Like Box and hide the call-to-action button (if available)
* Fix: The plugin now works with Access Tokens which use the new recently-released version 2.4 of the Facebook API

= 2.3.5 =
* New: Replace the Facebook 'Like Box' with the new Facebook 'Page Plugin' as the Facebook Like Box will be deprecated on June 23rd, 2015. Settings can be found under the Misc tab on the plugin's Customize page.
* Fix: Hashtags which contain foreign characters are now correctly linked to the hashtag on Facebook
* Fix: Links within Facebook post descriptions weren't opening in a new tab
* Fix: Removed empty style tags from some elements
* Fix: The URLs used for the 'Share' icons are now encoded to prevent any HTML validation errors
* Fix: Shared Facebook posts now link to the new shared post and not to the original post that was shared on Facebook
* Fix: Corrected a minor issue with the plugin caching string
* Fix: Fixed a minor issue with tags in the Facebook post text when creating/sharing an event
* Tweak: Add some stricter CSS to some parts of the feed to prevent theme conflicts
* Tweak: Automatically link the Facebook event name to the event now rather than it having to be enabled on the plugin's 'Typography' settings page

= 2.3.4 =
* Fix: The Facebook event description is no longer shown twice in event posts. It was previously shown in the post text itself and in the Facebook event details.
* Fix: Fixed a rare bug which would occur if your Facebook page or Facebook group name contained a number

= 2.3.3 =
* Fix: Removed a PHP notice which was missed in the last update. Apologies for the two updates in quick succession.

= 2.3.2 =
* Fix: Fixed some stray PHP notices which were inadvertently introduced in a recent update
* Tweak: Added an option to not load the icon font included in the plugin

= 2.3.1 =
* New: Added a shortcode option to allow you to offset the number of posts to be shown. Eg: offset=2
* New: Added an email link to the sharing icons
* New: Added a setting to load a local copy of the icon font instead of the CDN version. This can be found at the bottom of the 'Misc' settings page.
* Tweak: Added a prefix to the IDs on all Facebook posts so that they can now be targeted via CSS
* Tweak: Added "nofollow" to all links by default. This can be disabled by using `nofollow=false` in the shortcode.
* Tweak: Added some missing settings to the System Info section
* Tweak: Added the 'Timezone' setting to the main Settings page so that it's easier to find
* Fix: Added a workaround for Facebook changing the event URLs in their API from absolute to relative URLs
* Fix: Facebook removed the 'relevant_count' parameter from their API so added a workaround to get the number of photos attached to a Facebook post
* Fix: Fixed a minor bug in the WP_Http fallback method
* Fix: Removed duplicate IDs on the share icons and replaced with classes
* Fix: Added a check to the file_get_contents data retrieval method to check whether the Open SSL wrapper is enabled
* Fix: The `eventtitlelink` shortcode option now works correctly
* Fix: Added a workaround for 'story_tags' which Facebook deprecated from their API
* Fix: Removed query string from the end of CSS and JavaScript file references and replaced it with the wp_enqueue_script 'ver' parameter instead

= 2.3 =
* Happy New Year!
* New: Added a share link which allows you to share posts to Facebook, Twitter, Google+ or LinkedIn. This can be disabled at the very bottom of the Typography tab, or by using `showsharelink=false` in the [custom-facebook-feed] shortcode.
* Tweak: Using your own Facebook Access Token in the plugin is still optional but is now recommended in order to protect yourself against future Access Token related issues
* Tweak: Increased the accuracy of the character count when links are included in the Facebook text
* Tweak: Improved the efficiency of the Facebook post caching
* Tweak: Replaced the rel attribute with the HTML5 data attribute when storing data on an element
* Tweak: Added HTTPS stream wrapper check to the System Info to aid in troubleshooting
* Tweak: Updated the plugin's icon font to the latest version
* Tweak: Added the Smash Balloon logo to the credit link which can be optionally displayed at the bottom of your feed. The setting for this is at the bottom of the Misc tab on the Customize page.
* Tweak: Added a shortcode option to only show the Smash Balloon credit link on certain feeds: `[custom-facebook-feed credit=true]`
* Fix: Fixed an issue with quotes being escaped in custom/translated text
* Fix: Display an error message if WPHTTP function isn't working correctly
* Fix: The `postbgcolor` shortcode option is now working correctly

= 2.2.1 =
* Fix: Fixed a minor JavaScript error which occurs if a Facebook post doesn't contain any text

= 2.2 =
* New: Added a text area to the Support tab which contains all of the plugin settings and site info for easier troubleshooting
* New: You can now set the number of Facebook posts to '0' if you just want to show the Facebook Like box widget and no posts
* Tweak: If the user doesn't add a unit to the width, height or padding then automatically add 'px'
* Tweak: Added social media sharing links to the bottom of the settings page and an option to add a credit link to the bottom of the feed
* Fix: Fixed an issue with Facebook hashtags not being linked when followed immediately by punctuation
* Fix: When displaying a shared link if the caption is the same as the link URL then don't display it
* Fix: Added a space before the feed header's style attribute to remove HTML validation error
* Fix: Prefixed the 'top' and 'bottom' classes used on the Facebook Like box to prevent CSS conflicts
* Fix: Fixed an issue with the link color not being applied to Facebook hashtag links

= 2.1.3 =
* Fix: Fixed an issue with the Facebook Access Token used in the plugin hitting its request limit

= 2.1.2 =
* Fix: Added in a missing closing div tag to the Facebook feed when an error is being displayed

= 2.1.1 =
* Fix: Fixed an issue with the date not being hidden when unchecked in the Show/Hide section
* Fix: Fixed an issue with the date not being displayed below event posts when the date position was set to 'At the bottom of the post'

= 2.1 =
* New: Added an option to preserve/save your plugin options after uninstalling the plugin. This makes manually updating the plugin much easier.
* New: Added a 'Settings' link to the plugin on the Plugins page
* New: Added a field to the Misc settings page which allows users to enter their Facebook App ID in order to remove a couple of browser console warnings caused by the Facebook Like box widget
* Tweak: Reduced the size of the author's Facebook profile picture from 50px to 40px to match Facebook
* Tweak: The link description text is now 12px in size by default
* Tweak: Added some default character limits to the post text and descriptions
* Tweak: If the post author is being hidden then change the default date position to be the bottom of the post
* Fix: The post author link is no longer the full width of the post and is only wrapped around the author image and name which helps prevent inadvertently clicking on the post author
* Fix: Added a fb-root element to the Like box to prevent a browser console warning
* Fix: Renamed the ShowError function to prevent conflicts
* Fix: Fixed an issue with the 'seconds' custom text string not being saved correctly
* Fix: When linking the post text to the Facebook post the correct text color is now applied

= 2.0.1 =
* Tweak: Improved error handling and added an [Error Message reference](https://smashballoon.com/custom-facebook-feed/docs/errors/) to the website

= 2.0 =
* New: Added an option to display the post date immediately below the author name - as it is on Facebook. This is now the default date position.
* New: Added options to add a background color and rounded corners to your posts
* New: If your Facebook event has an end date then it will now be displayed after the start date
* New: Hashtags in the post descriptions are now also linked
* New: Tested and approved for the upcoming WordPress 4.0 release
* Tweak: Moved the 'View on Facebook' link to the left side
* Tweak: Added error handling to improve user experience
* Tweak: If the Facebook API can't be reached by the plugin for some reason then it no longer caches the empty response and instead keeps trying to retrieve the posts from Facebook until it is successful
* Fix: Removed some redundant inline CSS used on the posts
* Fix: If there is a token in the 'Access Token' field but the 'Enter my own Access Token' box is unchecked then the plugin will no longer use it
* Fix: Added the trim() function to the 'Test connection to Facebook API' function to improve reliability
* Fix: Fixed an occasional JavaScript error which occurred when the post text was hidden

= 1.9.9.3 =
* New: Hashtags in link, photo and video descriptions are now also linked
* Fix: Fixed an issue with hashtags being linked when the post text is also linked, which interfered with the text formatting

= 1.9.9.2 =
* Fix: Removed a couple of stray PHP notices

= 1.9.9.1 =
* Fix: Fixed an occasional issue with hashtags in inline CSS inadvertently being linked

= 1.9.9 =
* New: Hashtags in your posts are now linked to the hashtag search on Facebook. This can be disabled in the 'Post Text' section on the Typography settings page.
* New: Added a Facebook icon to the Custom Facebook Feed admin menu
* Fix: Corrected the left side margin on the "Like" box so that it aligns correctly with posts

= 1.9.8.1 =
* Fix: Fixed an admin JavaScript error introduced by the last update

= 1.9.8 =
* Tweak: The Access Token field is now hidden by default and is revealed by a checkbox
* Fix: Fixed an issue with link colors not being applied to all links
* Fix: Removed the link box container from posts which contain non-youtube/vimeo links
* Fix: Links which don't contain a 'http://' protocol are now linked correctly

= 1.9.7 =
* Fix: Fixed an issue with a generic function name which was occasionally causing an error

= 1.9.6 =
* Tweak: Added an HTML wrapper element around the feed

= 1.9.5 =
* New: Added an option to set a height on the Like box. This allows you to display more faces of your fans if you have that option selected.
* Tweak: Added a few stricter CSS styles to help minimize the chance of theme stylesheets distorting post formatting
* Tweak: Added a span to the header text to allow CSS to be applied
* Fix: Fixed a bug with the post author text bumping down below the author image in the Firefox browser
* Fix: Corrected a bug which caused some links not to have the color applied
* Fix: Fixed a float issue in Firefox which sometimes caused the feed to be pushed off the page

= 1.9.4 =
* New: Added background and border styling options to shared links
* Tweak: Reduced the clickable area of the post author
* Tweak: Added a 'Customize' tab to the Settings page
* Fix: Fixed an issue with post tag linking not working correctly in some languages
* Fix: Fixed an issue with line breaks not being respected in IE8

= 1.9.2 =
* Fix: Added title and alt attributes to the post author's Facebook profile picture
* Fix: Improved the reliability of the post tag linking
* Fix: Fixed an issue with HTML characters not rendering correctly when linking the post text
* Fix: Improved the reliability of the CSS clearing method used on the feed container
* Compatible with WordPress 3.9

= 1.9.1 =
* Fix: Fixed an issue with the 'textlink' shortcode option
* Fix: Fixed an bug with post text sometimes being duplicated when linked
* Fix: Removed error_reporting(0);

= 1.9.0 =
* New: Added the ability to change the text size and color of the post author
* New: Define the format, size and color of shared link titles
* New: You can now define the color of the links in your post text, descriptions and Facebook events
* Tweak: Moved the Feed Header options to the Typography page
* Tweak: Moved the Ajax setting to the Misc page
* Tweak: Now removes any query strings attached to the Facebook Page ID
* Fix: Fixed an issue with some themes causing the clear element to prevent links being clickable
* Fix: Some minor bug fixes

= 1.8.2.3 =
* New: Now supports Facebook tags - creates links when using the @ symbol to tag other people or Facebook pages in your posts
* Tweak: Changed the method used for link replacement in posts
* Fix: Fixed issue with php include

= 1.8.1 =
* New: Added an 'exclude' shortcode option to allow you to easily exclude specific parts of the post
* New: Timeline events are now cached to help reduce page load time
* New: Added an option for when the WordPress theme is loading the feed via AJAX so that the JavaScript runs after the feed has been loaded into the page
* Tweak: Changed author images back to loading via PHP rather than JavaScript due to issues with certain WordPress themes
* Fix: Reset the timezone after the shortcode has run
* Fix: Fixed an issue with the shared link descriptions not being hidden when specified
* Fix: Fixed a rare issue with the 'textlink' shortcode option
* Fix: Use a fallback JSON string if unable to find the cached version in the database

= 1.8.0 =
* New: Added a built-in color picker
* New: Added class to posts based on the author to allow for independent styling
* Tweak: Now loads the author's Facebook profile picture in using JavaScript to help speed up load times
* Tweak: Now automatically set the Facebook post limit based on the number of Facebook posts to be displayed
* Tweak: Core improvements to the way Facebook posts are output
* Tweak: Changed 'Layout & Style' page name to 'Customize'
* Tweak: Moved the Support information to a tab on the Settings page
* Tweak: Improved the 'Test connection to Facebook API' function
* Fix: Encode Facebook URLs so that they pass HTML validation
* Fix: Fixed an issue with Facebook post captions not displaying under some circumstances
* Fix: More robust method for stripping the URL when a user enters Facebook page URL instead of their Facebook Page ID

= 1.7.2 =
* Tweak: Moved the 'Show post author' option from the General settings tab to the Post Layout tab
* Tweak: Added the ability to show or hide the author to the 'include' shortcode option
* Fix: Added CSS box-sizing property to feed header so that padding doesn't increase its width
* Fix: Fixed showheader=false and headeroutside=false shortcode options
* Fix: Now allows users to enter their Facebook page URL as their Facebook Page ID

= 1.7.0 =
* New: Added ability to add a customizable header to your feed
* New: Added a Custom JavaScript section to allow you to add your own JS or jQuery functionality to the feed
* New: Added a 'Custom Text / Translate' tab to house all customizable text
* New: You can now choose to show posts only by other people on your Facebook page
* New: Set your timezone so that dates/times are displayed in your local time
* New: When a Facebook post contains a link to multiple images it now states the number of photos after the post text and links to the Facebook album
* Tweak: Plugin now detects whether the page is using SSL and pulls https resources
* Tweak: Added a button to test the connection to Facebook's API for easier troubleshooting
* Fix: Now using HTML encoding to parse any raw HTML tags in the Facebook post text or descriptions
* Fix: Added a protocol to the beginning of links which don't include one
* Fix: Fixed date width issue in IE7
* Fix: Removed stray PHP notices
* Fix: Added a space between the Like Box attributes

= 1.6.8.2 =
* Fix: Fixed a CSS bug in Firefox which was causing the page author name to bump down below the avatar

= 1.6.8.1 =
* Tweak: Moved 'View on Facebook' link up to be level with the date rather than on the line below it
* Fix: Don't show the caption when it is the same as the Facebook post text
* Fix: Fixed issue with enqueueing JavaScript file

= 1.6.8 =
* New: Added option to remove border from the Facebook Like box when showing faces
* New: Set Facebook "Like" box text color to either blue or white
* Tweak: Moved descripion below video or link title and added link source
* Tweak: Added ability to manually translate the '2 weeks ago' text
* Tweak: Replaced 'View Link' with 'View on Facebook' so that shared links now link to the Facebook post
* Tweak: Facebook "Like" box is now responsive
* Tweak: Displays Facebook post caption if no description is available
* Tweak: Vertically center multi-line author names rather than bumping them down below the Facebook profile picture
* Tweak: Checks whether the Access Token is inputted in the correct format
* Fix: Fixed bug in the 'Show posts on my page by others' option
* Fix: If displaying a Facebook group then automatically hides the Facebook "Like" box
* Fix: 'others=false' shortcode option now working correctly
* Fix: Strip any white space characters from beginning or end of Access Token and Facebook Page ID

= 1.6.7.1 =
* Fix: Fixed a bug in 1.6.7 which was causing an issue displaying the Facebook feed in some circumstances

= 1.6.7 =
* New: Your Facebook feed can now be completely displayed in any language - added i18n support for date translation
* Tweak: Improved documentation within the plugin
* Tweak: Changed order of methods used to retrieve Facebook feed data

= 1.6.6.3 =
* New: Added support for Facebook group events

= 1.6.6.1 =
* Fix: Resolved jQuery UI draggable bug which was causing issues with drag and drop

= 1.6.6 =
* New: Now works with Facebook groups
* Fix: Fixed an issue with the 'Show posts by others' option not working correctly in the previous version

= 1.6.4 =
* New: Added localization support. Full support for various languages coming soon
* New: Added CSS classes to different Facebook post types to allow for different styling based on post type
* New: Option to link statuses to either the status post itself or the directly to the Facebook page/timeline
* New: Added option to add thumbnail faces of fans to the Facebook Like box and define a width
* Tweak: Added separate classes to 'View on Facebook' and 'View Link' links so that they can be targeted with CSS
* Tweak: Prefixed every CSS class to prevent styling conflicts with theme stylesheets. Please note that if you used custom CSS to style parts of the feed that the CSS classes are now prefixed with 'cff-' to prevent theme conflicts. Eg. '.more' is now '.cff-more'.

= 1.6.3 =
* New: Added support for Facebook 'Offers'
* Fix: Fixed an issue with the 'others' shortcode option not working correctly
* Fix: Prefixed the 'clear' class to prevent conflicts

= 1.6.2 =
* New: Post caching now temporarily stores your Facebook post data in your WordPress database to allow for super quick load times
* New: Define your own caching time. Check for new Facebook posts every few seconds, minutes, hours or days. You decide.
* New: Define your own custom text for the 'See More' and 'See Less' buttons
* New: Add your own CSS class to your Custom Facebook Feeds
* New: Define a Facebook post limit which is higher or lower than the default 25
* New: Include the Facebook Like box inside or outside of the Facebook feed's container
* New: Customize the Facebook event date independently
* New: Improved layout of admin pages for easier navigation and customization
* Fix: Provided a fix for the Facebook API duplicate post bug
* Fix: Fixed bug which ocurred when multiple Facebook feeds are displayed on the same page with different text lengths defined

= 1.5.2 =
* Fix: Fixed JavaScript error in previous update

= 1.5.1 =
* New: Added a 'See More' link to expand any text which is longer than the character limit defined
* New: Choose to show Facebook posts by other people in your feed
* New: Option to show the post author's Facebook profile picture and name above each post
* New: Added options to customize and format the Facebook post date
* New: Add your own text before and after the date and in place of the 'View on Facebook' and 'View Link' text links
* New: Specify the format of the Facebook Event date
* Tweak: Default date format is less specific and better mimics Facebook's - credit Mark Bebbington
* Tweak: Changed the layout of the Typography section to allow for the additional options
* Fix: When a Facebook photo album is shared it now links to the album itself on Facebook and not just the cover photo
* Fix: Fixed issue with hyperlinks in post text which don't have a space before them not being converted to links

= 1.4.8 =
* Minor fixes

= 1.4.7 =
* Tweak: Added links to statuses which link to the Facebook page
* Tweak: Added classes to Facebook event date, location and description to allow custom styling
* Tweak: Removed 'Where' and 'When' text from Facebook events and made bold instead

= 1.4.6 =
* Fix: Fixed 'num' option in shortcode

= 1.4.4 =
* New: Added more shortcode options
* Minor tweaks

= 1.4.2 =
* New: Add your own custom CSS to allow for even deeper customization
* New: Optionally link your post text to the Facebook post
* New: Optionally link your event title to the Facebook event page
* Some minor modifications

= 1.4.1 =
* Fix: Set all parts of the Facebook feed to display by default on activation

= 1.4.0 =
* Major Update!
* New: Loads of new customization options for your Custom Facebook Feed
* New: Define Facebook feed width, height, padding and background color
* New: Change the font-size, font-weight and color of the Facebook post text, description, date, links and event details
* New: Choose whether to show or hide certain parts of the Facebook posts
* New: Select whether the Facebook Like box is shown at the top of bottom of the Facebook feed
* New: Choose Facebook Like box background color

= 1.3.6 =
* Minor modifications

= 1.3.5 =
* New: Shared Facebook events now display event details (name, location, date/time, description) directly in the Facebook feed

= 1.3.4 =
* New: Email addresses within the Facebook post text are now hyperlinked
* Fix: Links beginning with 'www' are now also hyperlinked

= 1.3.3 =
* New: Added support for Facebook events - display the Facebook event details (name, location, date/time, description) directly in the Facebook feed
* Fix: Links within the Facebook post text are now hyperlinked
* Tweak: Added additional methods for retrieving Facebook feed data

= 1.3.2 =
* Fix: Now using the built-in WordPress HTTP API to get retrieve the Facebook data

= 1.3.1 =
* Fix: Fixed issue with certain Facebook statuses not displaying correctly

= 1.3.0 =
* Tweak: If 'Number of Posts to show' is not set then default to 10 Facebook posts

= 1.2.9 =
* Fix: Now using cURL instead of file_get_contents to prevent issues with php.ini configuration on some web servers

= 1.2.8 =
* Fix: Fixed bug in specifying the number of Facebook posts to display

= 1.2.7 =
* Tweak: Prevented likes and comments by the page author showing up in the Facebook feed

= 1.2.6 =
* Tweak: Added help link to Custom Facebook Feed settings page

= 1.2.5 =
* Fix: Added clear fix

= 1.2.1 =
* Fix: Minor bug fixes

= 1.2 =
* New: Added the ability to define a maximum length for both the Facebook post text and description

= 1.0 =
* Launch!