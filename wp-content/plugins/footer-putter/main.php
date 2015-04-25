<?php
/*
 * Plugin Name: Footer Putter
 * Plugin URI: http://www.diywebmastery.com/plugins/footer-putter/
 * Description: Put a footer on your site that boosts your credibility with both search engines and human visitors.
 * Version: 1.12
 * Author: Russell Jamieson
 * Author URI: http://www.diywebmastery.com/about/
 * License: GPLv2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
define('FOOTER_PUTTER_VERSION','1.12');
define('FOOTER_PUTTER_FRIENDLY_NAME', 'Footer Putter') ;
define('FOOTER_PUTTER_DOMAIN', 'FOOTER_PUTTER_DOMAIN') ;
define('FOOTER_PUTTER_PATH', plugin_basename(__FILE__)) ;
define('FOOTER_PUTTER_PLUGIN_NAME', plugin_basename(dirname(__FILE__))) ;
define('FOOTER_PUTTER_HOME_URL','http://www.diywebmastery.com/plugins/footer-putter/');
define('FOOTER_PUTTER_ICON','dashicons-arrow-down-alt');
define('FOOTER_PUTTER_NEWS', 'http://www.diywebmastery.com/tags/newsfeed/feed/?images=&featured_only');
require_once(dirname(__FILE__) . '/classes/class-plugin.php');
add_action ('init',  array('Footer_Putter_Plugin', 'init'), 0);
if (is_admin()) add_action ('init',  array('Footer_Putter_Plugin', 'admin_init'), 0);
?>