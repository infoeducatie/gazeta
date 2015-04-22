=== Custom Facebook Feed Pro ===
Author: Smash Balloon
Support Website: http://smashballoon/custom-facebook-feed/
Requires at least: 3.0
Tested up to: 3.9.1
Version: 1.9.1.1
License: Non-distributable, Not for resale

The Custom Facebook Feed allows you to display a completely customizable Facebook feed of any public Facebook page or group on your website.

== Description ==
Display a **completely customizable**, **responsive** and **search engine crawlable** version of your Facebook feed on your website. Completely match the look and feel of the site with tons of customization options!

* **Completely Customizable** - by default inherits your theme's styles
* **Feed content is crawlable by search engines adding SEO value to your site** - other Facebook plugins embed the feed using iframes which are not crawlable
* **Completely responsive and mobile optimized** - works on any screen size
* Display statuses, photos, videos, events, links and offers from your Facebook page or group
* Choose which post types are displayed. Only want to show photos, videos or events? No problem
* Display multiple feeds from different Facebook pages on the same page or throughout your site
* Show likes, shares and comments for each post
* Automatically embeds YouTube and Vimeo videos right in your feed
* Show event information - such as the name, time/date, location, link to a map, description and a link to buy tickets
* Filter posts by string or #hashtag
* Post tags - creates links when using the @ symbol to tag other people in your posts
* Post caching means that your feed is load lightning fast
* Fully internationalized and translatable into any language
* Enter your own custom CSS for even deeper customization

== Installation ==
1. Install the Custom Facebook Feed either via the WordPress plugin directory, or by uploading the files to your web server (in the /wp-content/plugins/ directory).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the 'Facebook Feed' settings page to configure your feed.
4. Use the shortcode [custom-facebook-feed] in your page, post or widget to display your feed.
5. You can display multiple feeds of different Facebook pages by specifying a Page ID directly in the shortcode: [custom-facebook-feed id=smashballoon num=5].

== Changelog ==
= 1.9.1.1 =
* Fix: Fixed an issue with hashtags in inline CSS being linked inadvertently

= 1.9.1 =
* New: Added support for the new 'Album' extension, which allows you to embed an album and display its photos
* New: Added a Facebook icon to the admin menu
* New: When only displaying the albums post type you can now choose whether to display albums from your timeline or Photos page
* Tweak: Featured Post extension - You can now use the 'type' shortcode option to set the type of the post you are featuring
* Fix: Fixed an issue with hashtags with punctuation immediately following them not being linked
* Fix: Corrected the left side margin on the "Like" box so that it aligns with posts

= 1.9.0 =
* New: Display a list of your albums directly from your Facebook Albums page
* New: Display albums in a single column or in a grid
* New: Hashtags in your posts are now linked to the hashtag search on Facebook. This can be disabled in the 'Post Text' section on the Typography setting page.
* Tweak: Added an HTML wrapper element around the feed
* Tweak: Added a few stricter CSS styles to help minimize the chance of theme stylesheets distorting post formatting
* Tweak: Vertically centered the header text
* Tweak: Added a span to the header text to allow CSS to be applied
* Tweak: Updated the license key activation script to be more reliable
* Fix: Fixed an issue with some photos displaying at a small size due to a change in Facebook's API
* Fix: Fixed an occasional issue affecting the thumbnail and half-width layouts
* Fix: Fixed an issue with link colors not being applied to all links
* Fix: Fixed a rare connection issue when trying to retrieve the number of likes and comments for posts
* Fix: Corrected an occasional issue with shared link information not being displayed
* Fix: Fixed an issue with a generic function name which was occasionally causing an error

= 1.8.3 =
* Fix: If a Vimeo link doesn't have an embedable video accompanying it then don't show the 'Sorry video is not available text'

= 1.8.2 =
* Fix: Fixed a bug with the post author text bumping down below the author image in the Firefox browser

= 1.8.1 =
* New: Added an option to set a height on the Like box. This allows you to display more faces of your fans if you have that option selected.
* Fix: Automatically strips the 'autoplay' parameter from the end of YouTube videos so that they don't autoplay in the feed
* Fix: Fixed a minor issue with post author text width in IE8

= 1.8.0 =
* New: You can now use the Filter feature to exclude posts containing a certain string or hashtag
* New: Added an option to display the photo/video above the post text when using the Full-width layout
* New: Added background and border styling options to shared links
* New: The post layout now defaults to Full-width in narrow columns or on mobile. This can be disabled on the Post Layout tab.
* Tweak: Embedded videos now use the same layout as non-embedded videos
* Tweak: Improved the reliability of the post tags linking
* Tweak: Changed the CSS clearing method to be more reliable
* Tweak: The Filter feature now only strips whitespace from the beginning of strings to allow you to add a space to the end of words
* Tweak: Reduced the clickable area of the post author
* Fix: Added title and alt tags to post author image
* Fix: Fixed issue with &amp; and &quot; symbols
* Fix: Fixed an issue with line breaks not being respected in IE8
* Fix: Fixed an issue with some video titles not appearing when post text is linked
* Fix: Corrected a bug where icon fonts were sometimes rendered italicized
* Compatible with WordPress 3.9

= 1.7.0.2 =
* Fix: Fixed a bug with post text sometimes being duplicated when linked
* Fix: Now adds a 'http' protocol to links starting with 'www'

= 1.7.0.1 =
* Fix: Fixed an issue with likes and comment counts loading in 1.7.0

= 1.7.0 =
* New: Added the ability to change the text size and color of the post author
* New: Define the format, size and color of the shared link title
* New: You can now define the color of the links in your post text, descriptions and events
* Tweak: The icon that appears on album photos now contains the number of photos in the album
* Tweak: Changed the loader for the like and comment counts
* Tweak: Improved the likes, share and comment icons to work better with different background colors
* Tweak: Moved the Feed Header options to the Typography page
* Tweak: Moved the Ajax setting to the Misc page
* Tweak: Now removes any query strings attached to the Page ID
* Tweak: The plugin now uses a built-in shared Access Token
* Fix: Fixed an issue with HTML characters not rendering correctly when linking the post text
* Fix: Fixed an issue with some themes causing the clear element to prevent links being clickable
* Fix: The photo in an album post now links to the album post again. Accommodates the change in Facebook's photo link structure.

= 1.6.2 =
* New: Added support for the 'music' post type
* Fix: Fixed minor issue with link replacement method introduced in 1.6.1

= 1.6.1 =
* Tweak: Event timeline images are now higher quality and the same size as thumbnail photos
* Tweak: Now display the video name above the post text when displaying non-embedded video posts
* Tweak: Changed the method used for link replacement in posts
* Tweak: Changed author and event timeline images back to loading via PHP rather than JavaScript due to issues with certain WordPress themes
* Fix: Disabled post tag linking when the post text is linked to the Facebook post
* Fix: Use a fallback JSON string if unable to find the cached version in the database

= 1.6.0 =
* New: Now supports post tags - creates links when using the @ symbol to tag other people or pages in your posts
* New: Added an 'exclude' shortcode option to allow you to easily exclude specific parts of the post
* New: Timeline events are now cached to help reduce page load time
* New: Added a new post type option for 'album' posts
* New: Choose to show the full event image or the square cropped version when displaying only events
* New: Added an option for when the WordPress theme is loading the feed via AJAX so that the JavaScript runs after the feed has been loaded into the page
* New: Added an 'accesstoken' shortcode option
* Tweak: Timeline event images are now loaded in via JavaScript after page load
* Tweak: The Filter option now also applies to events displayed from the Events page
* Tweak: Improvements to the show/hide option for customizing events from the Events page
* Tweak: Made the 'Link to Facebook video post' the default action for non-embedded video
* Tweak: Featured Post extension now utilizes caching
* Tweak: Featured Post extension improvements to photo posts
* Fix: Added a fix for the Facebook API 'Ticket URL' bug. Ticket URLs have been removed from events.
* Fix: Fixed a color picker JavaScript conflict that was occuring on rare occasions
* Fix: Reset the timezone after the shortcode has run
* Fix: When dark icons are selected then they now also apply to the icons within the dropdown comments box
* Fix: Fixed an issue with the shared link descriptions not being hidden when specified
* Fix: Fixed a rare issue with the 'textlink' shortcode option
* Fix: Added a WPAUTOP fix for album posts
* Fix: Fixed some minor IE quirks mode bugs

= 1.5.0 =
* New: Added a built-in color picker
* New: Added an Extensions page which displays available extensions for the plugin
* New: Added integration with the 'Multifeed' extension
* New: Added integration with the 'Date Range' extension
* New: Added integration with the 'Featured Post' extension
* Tweak: Now automatically set the post limit based on the number of posts to be displayed
* Tweak: Added class to posts based on the author so allow for independent styling
* Tweak: Now loads the author avatar image in using JavaScript to help speed up load times
* Tweak: Links in the post text now open in a new tab by default
* Tweak: Improved the Post Layout UI
* Tweak: Moved the License page to a tab on the Settings page
* Tweak: Created a Support tab on the Settings page
* Tweak: Improved the 'Test connection to Facebook API' function
* Tweak: Core improvements to the way posts are output
* Fix: Fixed an issue with photo captions not displaying under some circumstances

= 1.4.3 =
* New: Choose to display events from your Events page for up to 1 week after the start time has passed
* Tweak: Changed 'Layout & Style' page name to 'Customize'
* Fix: Added CSS box-sizing property to feed header so that padding doesn't increase its width
* Fix: Fixed showheader=false and headeroutside=false shortcode options
* Fix: Fixed include=author shortcode option
* Fix: More robust method for stripping the URL when user enters Facebook page URL instead of their Page ID
* Fix: Encode URLs so that they pass HTML validation

= 1.4.2 =
* New: Set your timezone so that dates/times are displayed in your local time
* Tweak: Description character limit now also applies to embedded video descriptions
* Fix: Fixed issue with linking the post text to the Facebook post
* Fix: Comments box styling now applies to the 'View previous comments' and 'Comment on Facebook' links
* Fix: Fixed the 'showauthor' shortcode option
* Fix: Added the ability to show or hide the author to the 'include' shortcode option
* Fix: Fixed issue with the comments box not expanding when there were no comments
* Fix: Now using HTML encoding to parse any raw HTML tags in the post text, descriptions or comments
* Fix: Fixed date width issue in IE7
* Fix: Added http protocol to the beginning of links which don't include it
* Fix: Fixed an issue with the venue link when showing events from the Events page
* Fix: Removed stray PHP notices
* Fix: Numerous other minor bug fixes

= 1.4.1 =
* Fix: Fixed some minor bugs introduced in 1.4.0
* Fix: Fixed issue with album names not always displaying
* Fix: Added cURL option to handle gzip compression

= 1.4.0 =
* New: Redesigned comment area to better match Facebook
* New: Now displays the number of likes a comment has
* New: Now shows 4 most recent comments and add a 'View older comments' button to show more
* New: Shows the names of who likes the post at the top of the comments section
* New: Added a 'Comment on Facebook' button at the bottom of the comments section
* New: Can now choose to show posts only by other people
* New: Added ability to add a customizable header to your feed
* New: Added a 'Custom Text / Translate' tab to house all customizable text
* New: Added an icon and CSS class to posts with multiple images
* New: When posting multiple images it states the number of photos after the post text
* New: When sharing photos or links it now states who you shared them from
* Tweak: String/hastag filtering now also applies to the description
* Tweak: Updated video play button to display more consistently across video sizes
* Tweak: Events will now still appear for 6 hours after their start time has passed
* Tweak: Added a button to test the connection to Facebook's API for easier troubleshooting
* Tweak: Plugin now detects whether the page is using SSL and pulls https resources
* Tweak: Post with multiple images now link to the album instead of the individual photo
* Tweak: WordPress 3.8 UI updates
* Fix: Fixed Vimeo embed issue
* Fix: Fixed issue with some event links due to a Facebook API change
* Fix: Fixed an issue with certain photos not displaying correctly

= 1.3.8 =
* New: Added a 'Custom JavaScript' section to allow you to add your own custom JavaScript or jQuery scripts

= 1.3.7.2 =
* Tweak: Changed site_url to plugins_url
* Fix: Fixed issue with enqueueing JavaScript file

= 1.3.7.1 =
* Tweak: Added option to remove border from the Like box when showing faces
* Tweak: Added ability to manually translate the '2 weeks ago' text
* Tweak: Checks whether the Access Token is inputted in the correct format
* Tweak: Replaced 'View Link' with 'View on Facebook' so that shared links now link to the Facebook post
* Fix: Fixed issue with certain embedded YouTube videos not playing correctly
* Fix: Fixed bug in the 'Show posts on my page by others' option

= 1.3.7 =
* New: Improved shared link and shared video layouts
* New: When only showing events you can now choose to display them from your Events page or timeline
* New: Set "Like" box text color to either blue or white
* Tweak: Displays image caption if no description is available
* Tweak: "Like" box is now responsive
* Tweak: Vertically center multi-line author names rather than bumping them down below the avatar
* Tweak: Various CSS formatting improvements
* Fix: If displaying a group then automatically hide the "Like" box
* Fix: 'others=false' shortcode option now working correctly
* Fix: Fixed formatting issue for videos without poster images
* Fix: Strip any white space characters from beginning or end of Access Token and Page ID

= 1.3.6 =
* Tweak: Embedded videos are now completely responsive
* Tweak: Now displays loading gif while loading in likes and comments counts
* Tweak: Improved documentation within the plugin
* Tweak: Changed order of methods used to retrieve feed data
* Fix: Corrected bug which caused the loading of likes and comments counts to sometimes fail

= 1.3.5 =
* New: Feed is now fully translatable into any language - added i18n support for date translation
* New: Now works with groups
* New: Added support for group events
* Fix: Resolved jQuery UI draggable bug which was causing issues in certain cases with drag and drop
* Fix: Fixed full-width event layout bug
* Fix: Fixed video play button positioning on videos with small poster images

= 1.3.4 =
* New: Added localization support. Full support for various languages coming soon.
* Fix: Fixed an issue regarding statuses linking to the wrong page ID

= 1.3.3 =
* New: Post filtering by string: Ability to display posts based on whether they contain a particular string or #hashtag
* New: Option to link statuses to either the status post itself or the directly to the page/timeline
* New: Added CSS classes to different post types to allow for different styling based on post type
* New: Added option to added thumbnail faces of fans to the Like box
* New: Define your own width for the Like box
* Tweak: Added separate classes to 'View on Facebook' and 'View Link' links so that they can be targeted with CSS
* Tweak: Prefixed every CSS class to prevent styling conflicts with theme stylesheets
* Tweak: Automatically deactivates license key when plugin is uninstalled

= 1.3.2 =
* New: Added support for Facebook 'Offers'
* Fix: Fixes an issue with the 'others' shortcode caused by caching introduced in 1.3.1
* Fix: Prefixed the 'clear' class to prevent conflicts

= 1.3.1 =
* New: Post caching now temporarily stores your post data in your WordPress database to allow for super quick load times
* New: Define your own caching time. Check for new posts every few seconds, minutes, hours or days. You decide.
* New: Display events directly from your Events page
* New: Display event image, customize the date, link to a map of the event location and show a 'Buy tickets' link
* Tweak: Improved layout of admin pages for easier customization
* Fix: Provided a fix for the Facebook API duplicate post bug

= 1.3.0 =
* New: Define your own custom text for the 'See More' and 'See Less' buttons
* New: Add your own CSS class to your feeds with the new shortcode 'class' option
* New: Show actual number of comments when there is more than 25, rather than just '25+'
* New: Define a post limit which is higher or lower than the default 25
* New: Include the Like box inside or outside of the feed's container
* Tweak: Made changes to the plugin to accomodate the October Facebook API changes
* Fix: Fixed bug which ocurred when multiple feeds are displayed on the same page with different text lengths defined

= 1.2.9 =
* New: Added a 'See More' link to expand any text which is longer than the character limit defined
* New: Choose to show posts by other people in your feed
* New: Option to show the post author's profile picture and name above each post
* New: Specify the format of the Event date
* Tweak: Default date format is less specific and better mimics Facebook's - credit Mark Bebbington
* Fix: When a photo album is shared it now links to the album itself and not just the cover photo
* Fix: Fixed issue with hyperlinks in post text which don't have a space before them not being converted to links
* Minor fixes

= 1.2.8 =
* Tweak: Added links to statuses which link to the Facebook page
* Tweak: Added classes to event date, location and description to allow custom styling
* Tweak: Removed 'Where' and 'When' text from events and made bold instead
* Tweak: Added custom stripos function for users who aren't running PHP5+

= 1.2.7 =
* Fix: Fixes the ability to hide the 'View on Facebook/View Link' text displayed with posts

= 1.2.6 =
* Fix: Prevents the WordPress wpautop bug from breaking some of the post layouts
* Fix: Event timezone fix when timezone migration is enabled

= 1.2.5 =
* Tweak: Replaced jQuery 'on' function with jQuery 'click' function to allow for compatibilty with older jQuery versions
* Minor bug fix regarding hyperlinking the post text

= 1.2.4 =
* New: Added a ton more shortcode options
* New: Added options to customize and format the date
* New: Add your own text before and after the date and in place of the 'View on Facebook' and 'View Link' links
* New: If there are no comments on a post then choose whether to hide the comment box or use your own custom text
* Tweak: Separated the video/photo descriptions and link descriptions into separate checkboxes in the Post Layout section
* Tweak: Changed the layout of the Typography section to allow for the additional options
* Tweak: Added a System Info section to the Settings page to allow for simpler debugging of issues related to PHP settings

= 1.2.3 =
* New: Choose to only show certain types of posts (eg. events, photos, videos, links)
* New: Add your own custom CSS to allow for even deeper customization
* New: Optionally link your post text to the Facebook post
* New: Optionally link your event title to the Facebook event page
* Fix: Only show the name of a photo or video if there is no accompanying text
* Some minor modifications

= 1.2.2 =
* Fix: Set all parts of the feed to display by default

= 1.2.1 =
* Select whether to hide or show certain parts of the posts
* Minor bug fixes

= 1.2.0 =
* Major Update!
* New: Loads of customization, layout and styling options for your feed
* New: Define feed width, height, padding and background color
* New: Choose from 3 preset post layouts; thumbnail, half-width, and full-width
* New: Change the font-size, font-weight and color of the post text, description, date, links and event details
* New: Style the comments text and background color
* New: Choose from light or dark icons
* New: Select whether the Like box is shown at the top of bottom of the feed
* New: Choose Like box background color
* New: Define the height of the video (if required)

= 1.1.1 =
* New: Shared events now display event details (name, location, date/time, description) directly in the feed

= 1.1.0 =
* New: Added embedded video support for youtu.be URLs
* New: Email addresses within the post text are now hyperlinked
* Fix: Links beginning with 'www' are now also hyperlinked

= 1.0.9 =
* Bug fixes

= 1.0.8 =
* New: Most recent comments are displayed directly below each post using the 'View Comments' button
* New: Added support for events - display the event details (name, location, date/time, description) directly in the feed
* Fix: Links within the post text are now hyperlinked

= 1.0.7 =
* Fix: Fixed issue with certain statuses not displaying correctly
* Fix: Now using the built-in WordPress HTTP API to get retrieve the Facebook data

= 1.0.6 =
* Fix: Now using cURL instead of file_get_contents to prevent issues with php.ini configuration on some web servers

= 1.0.5 =
* Fix: Fixed bug caused in previous update when specifying the number of posts to display

= 1.0.4 =
* Tweak: Prevented likes and comments by the page author showing up in the feed

= 1.0.3 =
* Tweak: Open links to Facebook in a new tab/window by default
* Fix: Added clear fix
* Fix: CSS image sizing fix

= 1.0.2 =
* New: Added ability to set a maximum length on both title and body text either on the plugin settings screen or directly in the shortcode

= 1.0.1 =
* Fix: Minor bug fixes.

= 1.0 =
* Launch!