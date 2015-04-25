<?php
class Footer_Putter_Plugin {

	protected static $links = array();

	public static function get_link_url($key) {
		if (array_key_exists($key, self::$links))
			return self::$links[$key];
		else
			return ('#');
	}

 	public static function init() {
		$dir = dirname(__FILE__) . '/';
		require_once($dir . 'class-utils.php');
		require_once($dir . 'class-diy-options.php');
		require_once($dir . 'class-credits-options.php');
		require_once($dir . 'class-credits.php');
		require_once($dir . 'class-credits-widgets.php');
		require_once($dir . 'class-trademarks-widgets.php');
		Footer_Credits_Options::init();
		Footer_Credits::init();
	}
	
	public static function admin_init() {
		$dir = dirname(__FILE__) . '/';
		require_once($dir . 'class-tooltip.php');
		require_once($dir . 'class-admin.php');
		require_once($dir . 'class-feed-widget.php');
      require_once($dir . 'class-dashboard.php');
		require_once($dir . 'class-credits-admin.php');
		require_once($dir . 'class-trademarks-admin.php');		
		$intro = new Footer_Putter_Dashboard(FOOTER_PUTTER_VERSION, FOOTER_PUTTER_PATH, FOOTER_PUTTER_PLUGIN_NAME);
		self::$links['intro'] = $intro->get_url();
		$credits = new Footer_Credits_Admin(FOOTER_PUTTER_VERSION, FOOTER_PUTTER_PATH, FOOTER_PUTTER_PLUGIN_NAME,'credits');	
		self::$links['credits'] = $credits->get_url();
		$trademarks = new Footer_Trademarks_Admin(FOOTER_PUTTER_VERSION, FOOTER_PUTTER_PATH, FOOTER_PUTTER_PLUGIN_NAME,'trademarks');	
		self::$links['trademarks'] = $trademarks->get_url();
	}	

}
