<?php
if ( ! class_exists( 'cmb2_bootstrap_202', false ) ) {

	/**
	 * Check for newest version of CMB
	 */
	class cmb2_bootstrap_202 {

		/**
		 * Current version number
		 * @var   string
		 * @since 1.0.0
		 */
		const VERSION = '2.0.2';

		/**
		 * Current version hook priority
		 * Will decrement with each release
		 *
		 * @var   int
		 * @since 2.0.0
		 */
		const PRIORITY = 9997;

		public static $single = null;

		public static function go() {
			if ( null === self::$single ) {
				self::$single = new self();
			}
			return self::$single;
		}

		private function __construct() {
			/**
			 * A constant you can use to check if CMB2 is loaded
			 * for your plugins/themes with CMB2 dependency
			 */
			if ( ! defined( 'CMB2_LOADED' ) ) {
				define( 'CMB2_LOADED', true );
			}
			add_action( 'init', array( $this, 'include_cmb' ), self::PRIORITY );
		}

		public function include_cmb() {
			if ( ! class_exists( 'CMB2', false ) ) {
				if ( ! defined( 'CMB2_VERSION' ) ) {
					define( 'CMB2_VERSION', self::VERSION );
				}
				$this->l10ni18n();
				require_once 'bootstrap.php';
			}
		}

		/**
		 * Load CMB text domain
		 * @since  2.0.0
		 */
		public function l10ni18n() {
			$loaded = load_plugin_textdomain( 'cmb2', false, '/languages/' );
			if ( ! $loaded ) {
				$loaded = load_muplugin_textdomain( 'cmb2', '/languages/' );
			}
			if ( ! $loaded ) {
				$loaded = load_theme_textdomain( 'cmb2', '/languages/' );
			}

			if ( ! $loaded ) {
				$locale = apply_filters( 'plugin_locale', get_locale(), 'cmb2' );
				$mofile = dirname( __FILE__ ) . '/languages/cmb2-' . $locale . '.mo';
				load_textdomain( 'cmb2', $mofile );
			}
		}

	}
	cmb2_bootstrap_202::go();

} // class exists check
