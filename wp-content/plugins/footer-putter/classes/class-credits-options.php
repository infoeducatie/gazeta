<?php
class Footer_Credits_Options  {

	const OPTIONS_NAME = 'footer_credits_options';

	protected static $options = null;	
	
	protected static $defaults = array(
		'terms' => array(
		'site' => '',
		'owner' => '',
		'address' => '',
      'street_address' => '',
      'locality' => '',
      'region' => '',
      'postal_code' => '',
		'country' => '',
      'latitude' => '',
      'longitude' => '',
      'map' => '',
		'email' => '',
		'telephone' => '',
		'copyright' => '',
		'copyright_start_year' => '',
		'copyright_preamble' => '',
		'courts' => '',
      'updated' => '',
		'privacy_contact' => '',
		'terms_contact' => ''),
		'nav_menu' => 0,
		'center' => true,
		'two_lines' => true,
		'separator' => '&nbsp;&middot;&nbsp;',
		'item_separator' => '&nbsp;',		
		'section_separator' => '<br/>',
		'show_copyright' => true,
		'show_telephone' => true,
		'show_email' => false,
		'show_address' => true,
		'show_return' => true,
		'return_text' => 'Return To Top',
		'return_class' => '',
		'footer_class' => '',
		'footer_hook' => '',
		'footer_remove' => true,
 		'footer_filter_hook' => '',
 		'visibility' => '' ,
      'use_microdata' => false
	);
	
	public static function init() {
		self::theme_specific_defaults();
		self::$options = new Footer_Putter_DIY_Options(self::OPTIONS_NAME, self::$defaults);	
	}

	public static function get_defaults() {
    	return self::$defaults;
    }

	public static function is_terms_key($key) {
		return array_key_exists($key, self::$defaults['terms']);
	}

	public static function get_option($option_name) {
    	$options = self::get_options();
    	if ($option_name && $options && array_key_exists($option_name,$options))
        	return $options[$option_name];
    	else
        	return false;
    }

	public static function get_options() {
    	return self::$options->get_options();
    }
	
	public static function save_options($new_options) {
		$new_options['terms'] = self::sanitize_terms($new_options['terms']);
   		return self::$options->save_options( $new_options) ;
	}

	private static function sanitize_terms($new_terms) {
		$new_terms = wp_parse_args($new_terms, self::$defaults['terms']); //ensure terms are complete		
		$new_terms['site'] = self::get_default_site();
		$new_terms['copyright'] = self::get_copyright($new_terms['copyright_start_year']); //generate copyright
		return $new_terms;
	}
	
	private static function get_default_site() { 
		$domain = strtolower(parse_url(site_url(),PHP_URL_HOST));
		$p = strpos($domain,'www.') ;
		if (($p !== FALSE) && ($p == 0)) $domain = substr($domain,4);
		return $domain; 
	}
	
	public static function get_copyright($startyear='') {
  		$thisyear = date("Y");
		$format = (empty( $startyear) || ($startyear==$thisyear)) ? '%1$s %3$s' : '%1$s %2$s-%3$s';
  		return sprintf($format, self::get_term('copyright_preamble'), $startyear, $thisyear);
	}
	
 	public static function get_terms() {
    	return self::get_option('terms');
    }   
	
	public static function get_term($term_name) {
    	$options = self::get_options();
    	$terms = is_array($options) && array_key_exists('terms',$options) ? $options['terms'] : false;
    	if ($term_name && $terms && array_key_exists($term_name,$terms) && $terms[$term_name])
        	return $terms[$term_name];
    	else
        	return self::get_default_term($term_name);    		
    }	
	
    private static function get_default_term($key) {
		$default='';
    	switch ($key) {
         case 'owner' : $default = self::get_term('site'); break;
   		case 'copyright' : $default = self::get_copyright(self::get_term('copyright_start_year')); break;
   		case 'copyright_start_year': $default = date('Y'); break;
			case 'copyright_preamble': $default = 'Copyright &copy;'; break;
   		case 'country' : $default = 'The United States'; break;
   		case 'courts' : $default = ucwords(sprintf('the courts of %1$s',self::get_term('country'))); break;
   		case 'email' : $default = 'privacy@'.strtolower(self::get_term('site')); break;
   		case 'site' : $default = self::get_default_site(); break;
   		case 'updated' : $default = date('d M Y'); break;
 			default: $default='';  //default is blank for others
   		}
   	return $default;
    }
	
	private static function theme_specific_defaults() {
		switch (basename( TEMPLATEPATH ) ) {  
			case 'twentyten': 
				self::$defaults['footer_hook'] = 'twentyten_credits'; break;
			case 'twentyeleven': 
				self::$defaults['footer_hook'] = 'twentyeleven_credits'; break;
			case 'twentytwelve': 
				self::$defaults['footer_hook'] = 'twentytwelve_credits'; break;
			case 'twentythirteen': 
				self::$defaults['footer_hook'] = 'twentythirteen_credits'; break;
			case 'twentyfourteen': 
				self::$defaults['footer_hook'] = 'twentyfourteen_credits'; break;
			case 'delicate': 
				self::$defaults['footer_hook'] = 'get_footer'; break;
			case 'genesis': 
				self::$defaults['footer_hook'] = 'genesis_footer';
				self::$defaults['footer_filter_hook'] = 'genesis_footer_output';
				break;
			case 'graphene': 
				self::$defaults['footer_hook'] = 'graphene_footer'; break;
			case 'pagelines': 
				self::$defaults['footer_hook'] = 'pagelines_leaf'; break;
			default: 
				self::$defaults['footer_hook'] = 'wp_footer';
				self::$defaults['footer_remove'] = false;				
				break;
		}
	}

}
