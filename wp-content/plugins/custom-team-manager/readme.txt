=== Custom Team Manager ===
Contributors: Ibnul
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=9PTQZ4R2SP7FS&lc=MY&item_name=WebSpider&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: Add Team Member, custom team manager, team manager, team management, custom team management, responsive team manager, team members, staff manager, wordpress team manager, team member, ajax team manager
Requires at least: 3.5
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will display team members using shortcode on your page. You just need to post members details same way as you add a new post.

== Description ==

This plugin will display team members of your company using shortcode on your post or page. You just need to post members details same way as you add a new post. And everything will be there automatically. Use Team Management menu to add new member and see team-members page. It's shortcode enabled, responsive and easy to use. You can change to Gridview display of members from Settings page. There are few other options too.

Live Demo: http://webdevsbd.com/team-members/

= Custom Team Manager Needs Your Support =

A little donation is really inspiring and helpful to develop free plugins, in fact it's hard to continue development and support for this free plugin without contributions from users like you. If you enjoy using Custom Team Manager and find it useful, please consider making a donation.

= Recommended Plugins =
* [Post Types Order](https://wordpress.org/plugins/post-types-order/) - With Post Types Order, you can reorder your team members easily, it's just drag and drop.

= Plugin Features =
* You can add/edit member detail same way as post add/edit.
* Responsive layout.
* Shortcode enabled.
* Settings page with Ajax save.
* Members pagination with ajax loading.
* Excellent CSS3 modern effects.
* Easy to customize (if needed).
* Automatic members page creation.
* Option to specify number of team members to display.
* Custom CSS option. 

= How To Use =
1. Install / Activate the plugin
2. Add Team Members from `Management Team` menu on Dashboard.
3. See Team Members page.
4. Use Settings page to changes settings and custom CSS
5. Use `[cmt-content]`your content here`[/cmt-content]` to show some content before or after shortcode `[team-members]` or `[team-members-profile]` - it'll position the content correctly.
6. If you use single profile on single page and get `404 Not Found` for single full profile page, you need to flush permalink. Just go to Dashboard->Settings->Permalink , then click on Save button. You don't need anything to change.
  
  = THAT'S ALL ! ENJOY ! =

== Installation ==
1. Search `custom team manager` from Plugins->Add New page or download from here.
2. If you download, upload plugin to the `/wp-content/plugins/` directory on your server.
3. Activate the plugin through the 'Plugins' page in WordPress


= How to Use =
1. If you activated the plugin successfully you'll see a new menu item `Management Team` is added on Dashboard and you can add New Member same way like adding a post.
2. View `yousite.com/team-members/` page and click to any member to view detail page.
3. If you want to show team members to any other page just add the shortcode `[team-members]`
	And `[team-members-profile]` for members detail page.
4. Use Settings page to changes settings.
5. Use `[cmt-content]`your content here`[/cmt-content]` to show some content before or after shortcode `[team-members]` or `[team-members-profile]` - it'll position the content correctly.
6. If you use single profile on single page and get `404 Not Found` for single full profile page, you need to flush permalink. Just go to Dashboard->Settings->Permalink , then click on Save button. You don't need anything to change.

== Frequently asked questions ==

= What shortcode to use to show members on a page? =

Shortcode `[team-members]` to show all members on a page
And `[team-members-profile]` for members detail page.

= Show members according to category =
Use `[team-members category="your-category"]` and if you want to show all members full profile on a single page while you are using category, you've to use `[team-members category="your-category" pageid="full-profile-pageid"]` and on the full profile page use shortcode `[team-members-profile category="your-category"]` but if you want to show each member full profile on separate page then you no need to worry about full profile page.

= What if you get 404 Not Found for single profile on single page = 

Just go to Dashboard->Settings->Permalink , then click on Save button. You don't need anything to change.

= Is there any page creating automatically when activating the plugin? =

Yes, two pages are creating when activating the plugin. One is to show all members and another is to show member's detail. 
	1. Team Members
	2. Team Members Profile.

= Is there any options/settings page for the plugin? =

Yes, you can change few options there from plugin Settings page.

= Do you need to use any supporting plugin for best use of this plugin? =

Yes, if you want to reorder your members, please install and activate 'Post Types Order' plugin.

= I want to add text and images before the [team-members] And [team-members-profile], but it load the plugin infor then the information that I add before the plugin. How to position correctly ? =

Use `[cmt-content]`your content here`[/cmt-content]` to show some content before or after shortcode `[team-members]` or `[team-members-profile]` - it'll position the content correctly.


== Screenshots ==

1. Team Members page view.
2. Team Members Profile page view.
3. Settings Page view.

== Changelog ==

= ver 2.4.1 - 13.01.2015 =
* Added Category option
* Added slug input option

= ver 2.3.2 - 24.11.2014 =
* Added options to select page for members full profile.
* Added two types of full profile view.

= ver 2.1.1 - 28.10.2014 =
* Fixed - Position of some text before/after Team Members

= ver 2.1.0 - 27.10.2014 = 
* Added Settings page.
* Fixed some style problem.

= ver 1.0.0 - 20.10.2014 =
* Initial release

== Upgrade Notice ==
Soon will update to 2.4.2 with some style change.