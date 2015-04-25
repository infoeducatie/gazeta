<?php

class Footer_Credits  {

    const CODE = 'footer-credits'; //element prefix
	const SIDEBAR_ID = 'last-footer';

	public static function init() {
		add_action('widgets_init',array(__CLASS__,'register'),20);
		add_filter( 'wp_nav_menu_items', array(__CLASS__, 'fix_home_link'), 10, 2 );
		if (!is_admin()) add_action('wp',array(__CLASS__,'prepare'));
	}

	public static function register() {
		self::register_sidebars();
		self::register_widgets();
	}

    private static function register_sidebars() {
    	if (Footer_Credits_Options::get_option('footer_hook')) {
			$tag = self::is_html5() ? 'section' : 'div';
			register_sidebar( array(
				'id' => self::SIDEBAR_ID,
				'name'	=> __( 'Credibility Footer', __CLASS__ ),
				'description' => __( 'Custom footer section for copyright, trademarks, etc', __CLASS__),
				'before_widget' => '<'.$tag.' id="%1$s" class="widget %2$s"><div class="widget-wrap">',
				'after_widget'  => '</div></'.$tag.'>'				
			) );
		}
    }
	
	private static function register_widgets() {
		if (class_exists('Footer_Putter_Copyright_Widget')) register_widget('Footer_Putter_Copyright_Widget');
		if (class_exists('Footer_Putter_Trademark_Widget')) register_widget('Footer_Putter_Trademark_Widget');
	}	

	public static function is_html5() {
		return Footer_Putter_Utils::is_html5();
	}
	
	public static function prepare() {
		add_shortcode(self::CODE, array(__CLASS__, 'footer' ) );
		add_shortcode(self::CODE.'-contact', array(__CLASS__, 'contact' ) );
		add_shortcode(self::CODE.'-copyright', array(__CLASS__, 'copyright' ) );
		add_shortcode(self::CODE.'-menu', array(__CLASS__, 'footer_menu' ) );
		add_filter('widget_text', 'do_shortcode', 11);
		add_action('wp_enqueue_scripts',array(__CLASS__, 'enqueue_styles' ));

		$options = Footer_Credits_Options::get_options();
			
		//insert custom footer at specified hook
		if ($footer_hook = $options['footer_hook'])  {
			if ($options['footer_remove']) remove_all_actions( $footer_hook); 
			add_action( $footer_hook, array(__CLASS__, 'custom_footer')); 
		}
	
 		//suppress footer output
 		if ($ffs = $options['footer_filter_hook']) 
 			add_filter($ffs, array(__CLASS__, 'no_footer'),100); 

		if (is_page('privacy') && Footer_Credits_Options::get_term('privacy_contact'))
			add_filter('the_content', array(__CLASS__, 'add_privacy_footer'),9 );	

		if (is_page('terms') && Footer_Credits_Options::get_term('terms_contact'))
			add_filter('the_content', array(__CLASS__, 'add_terms_footer'),9 );	

		if (is_page('terms') || is_page('privacy') || is_page('affiliates') || is_page('disclaimer'))
			add_filter('the_content', array(__CLASS__, 'terms_filter') );	
				
	}
	
	public static function enqueue_styles() {
		wp_enqueue_style('footer-credits', plugins_url('styles/footer-credits.css',dirname(__FILE__)), array(), FOOTER_PUTTER_VERSION);
    }

	public static function register_admin_styles() {
		wp_register_style('footer-credits-admin', plugins_url('styles/admin.css',dirname(__FILE__)), array(), FOOTER_PUTTER_VERSION);
	}

	public static function enqueue_admin_styles() {
		wp_enqueue_style('footer-credits-admin');
 	}

	
	public static function return_to_top( $text, $class) {
		return sprintf( '<div id="footer-return" class="%1$s"><a rel="nofollow" href="#" onclick="window.scrollTo(0,0); return false;" >%2$s</a></div>', trim($class), $text);
	}

    private static function contact_info($params) {
        $org ='';
        if ($address = self::contact_address($params['show_address'], $params['use_microdata'], $params['separator'], $params['section_separator'])) $org .= $address;
        if ($telephone = self::contact_telephone($params['show_telephone'], $params['use_microdata'],  $params['item_separator'])) $org .= $telephone;
        if ($email = self::contact_email($params['show_email'], $params['use_microdata'], $params['item_separator'])) $org .= $email;
		$format = '<span' . ($params['use_microdata'] ? ' itemscope="itemscope" itemtype="http://schema.org/Organization"' : '') . '>%1$s</span>';
        return sprintf($format, $org);
    }

    private static function contact_telephone($show_telephone, $microdata, $prefix) {
      if  ($show_telephone && ($telephone = Footer_Credits_Options::get_term('telephone')))
        if ($microdata)
            return sprintf('%1$s<span itemprop="telephone" class="telephone">%2$s</span>', $prefix, $telephone) ;
        else
            return sprintf('%1$s<span class="telephone">%2$s</span>', $prefix, $telephone) ;
      else
            return '';
    }

    private static function contact_email($show_email, $microdata, $prefix) {
      if  ($show_email && ($email = Footer_Credits_Options::get_term('email')))
            return sprintf('%1$s<a href="mailto:%2$s" class="email"%3$s>%2$s</a>', $prefix, $email, $microdata ? ' itemprop="email"' : '') ;
      else
            return '';
    }

    private static function contact_address($show_address, $microdata, $separator, $prefix) {
      if  ($show_address)
        if ($microdata) {
            return self::org_location($separator, $prefix);
        } elseif ($address = Footer_Credits_Options::get_term('address'))
            return sprintf('%1$s<span class="address">%2$s%3$s</span>', $prefix, self::format_address($address, $separator), Footer_Credits_Options::get_term('country'));
      return '';
    }

    private static function format_address ($address, $separator) {
		$s='';
		$addlines = explode(',', trim($address));
		foreach ($addlines as $a) {
			$a = trim($a);
			if (!empty($a)) $s .= $a . $separator;
		}
		return $s;
    }	
	
    private static function org_location($separator, $prefix) {
        $location = '';
        if ($loc_address = self::location_address( $separator)) $location .=  $loc_address;
        if ($loc_geo = self::location_geo()) $location .= $loc_geo;
        if ($loc_map = self::location_map()) $location .= $loc_map;
        if ($location)
            return sprintf('%1$s<span itemprop="location" itemscope="itemscope" itemtype="http://schema.org/Place">%2$s</span>', $prefix, $location) ;
        else
            return '';
    }

    private static function location_address($separator) {
        $address = '';
        if ( $street_address = Footer_Credits_Options::get_term('street_address'))
            $address .=  sprintf('<span itemprop="streetAddress">%1$s</span>', self::format_address($street_address, $separator)) ;
        if ( $locality = Footer_Credits_Options::get_term('locality'))
                $address .=  sprintf('<span itemprop="addressLocality">%1$s</span>', self::format_address($locality, $separator)) ;
        if ( $region = Footer_Credits_Options::get_term('region'))
                $address .=  sprintf('<span itemprop="addressRegion">%1$s</span>', self::format_address($region, $separator)) ;
        if ( $postal_code = Footer_Credits_Options::get_term('postal_code'))
                $address .=  sprintf('<span itemprop="postalCode">%1$s</span>', self::format_address($postal_code, $separator)) ;
        if ( $country = Footer_Credits_Options::get_term('country'))
                $address .=  sprintf('<span itemprop="addressCountry">%1$s</span>', $country) ;

        if ($address)
            return sprintf('<span class="address" itemprop="address" itemscope="itemscope" itemtype="http://schema.org/PostalAddress">%1$s</span>',$address) ;
        else
            return '';
    }

    private static function location_geo() {
        $geo = '';
        if ( $latitude = Footer_Credits_Options::get_term('latitude')) $geo .=  sprintf('<meta itemprop="latitude" content="%1$s" />', $latitude) ;
        if ( $longitude = Footer_Credits_Options::get_term('longitude')) $geo .=  sprintf('<meta itemprop="longitude" content="%1$s" />', $longitude) ;
        return $geo ? sprintf('<span itemprop="geo" itemscope="itemscope" itemtype="http://schema.org/GeoCoordinates">%1$s</span>', $geo) : '';
    }

    private static function location_map() {
        if ( $map = Footer_Credits_Options::get_term('map'))
            return sprintf('<a rel="nofollow external" target="_blank" class="map" itemprop="map" href="%1$s">%2$s</a>', $map, __('Map')) ;
        else
            return '';
    }

	public static function copyright_owner($params){
  		return sprintf('<span class="copyright">%1$s %2$s</span>', 
  			Footer_Credits_Options::get_copyright($params['copyright_start_year']), $params['owner']);
	}	
	
    public static function contact($atts = array()) {
    	$all_defaults = Footer_Credits_Options::get_defaults();
		$defaults = array();
		$defaults['show_telephone'] = $all_defaults['show_telephone'];
		$defaults['show_email'] = $all_defaults['show_email'];
		$defaults['show_address'] = $all_defaults['show_address'];
		$defaults['use_microdata'] = $all_defaults['use_microdata'];
		$defaults['separator'] = $all_defaults['separator'];
		$defaults['item_separator'] = $all_defaults['item_separator'];
		$defaults['section_separator'] = $all_defaults['section_separator'];
		$defaults['footer_class'] = self::CODE;	
  		$params = shortcode_atts( $defaults, $atts ); //apply plugin defaults  		
        return sprintf ('<span class="%1$s">%2$s</span>', $params['footer_class'], self::contact_info($params));
    }

	public static function copyright($atts = array()){
		$defaults = array();
		$defaults['owner'] = Footer_Credits_Options::get_term('owner');
		$defaults['copyright_start_year'] = Footer_Credits_Options::get_term('copyright_start_year');	
		$defaults['footer_class'] = self::CODE;	
  		$params = shortcode_atts( $defaults, $atts ); //apply plugin defaults  		
        return sprintf ('<span class="%1$s">%2$s</span>', $params['footer_class'], self::copyright_owner($params));
	}	

	public static function footer_menu($atts = array()) {
 		$defaults = array('menu' => 'Footer Menu', 'echo' => false, 'container' => false, 'footer_class' => self::CODE);
   		$params = shortcode_atts( $defaults, $atts ); //apply plugin defaults	
        return sprintf ('<span class="%1$s">%2$s</span>', $params['footer_class'], wp_nav_menu($params));
	}

	public static function footer($atts = array()) {
  		$params = shortcode_atts( Footer_Credits_Options::get_options(), $atts ); //apply plugin defaults

		if ($params['center']) {
			if (! $params['two_lines']) $params['section_separator'] = $params['item_separator'];
			$params['return_class'] .= ' return-center';
			$params['footer_class'] .= ' footer-center';
			$clear = '';
		} else {
			if (! $params['two_lines']) $params['item_separator'] = $params['section_separator'] ;
			$params['return_class'] .= ' return-left';
			$params['footer_class'] .= ' footer-right';
			$clear = '<div class="clear"></div>';
		}	
		$format = '<div id="%1$s" class="%2$s">%3$s%4$s%5$s</div>%6$s';
		return (empty($params['show_return']) ? '' :
			self::return_to_top($params['return_text'], $params['return_class'])) . 
			sprintf($format,
				self::CODE,
				$params['footer_class'], 	
				(empty($params['nav_menu']) ? '' : self::footer_menu(array('menu' => $params['nav_menu']))),
				(empty($params['show_copyright']) ? '' : sprintf('%1$s%2$s', $params['item_separator'], self::copyright_owner(Footer_Credits_Options::get_terms()))),
				self::contact_info($params),
				$clear
			);				
	}

	public static function terms_filter($content) {
		if ($terms = Footer_Credits_Options::get_terms()) {
			$from = array();
			$to = array();
			foreach ($terms as $term => $value) {
				$from[] = '%%'.$term.'%%';
				$to[] = $value;
			}
			return str_replace($from,$to,$content);
		}
		return $content;
	}

	public static function custom_footer() {
		if ( is_active_sidebar( self::SIDEBAR_ID) ) {
			if (self::is_html5()) {
				echo '<footer class="custom-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">';
				dynamic_sidebar( self::SIDEBAR_ID );
				echo '</footer><!-- end .custom-footer -->';
			} else {
				echo '<div class="custom-footer">';
				dynamic_sidebar( self::SIDEBAR_ID );
				echo '</div><!-- end .custom-footer -->';
			}
		}
	}

    public static function no_footer($content) { return ''; }  		

	public static function add_privacy_footer($content) {
		$terms = Footer_Credits_Options::get_terms();		
		$email = $terms['email'];	
		$contact = <<< PRIVACY
<h2>How to Contact Us</h2> 
<p>Questions about this statement or about our handling of your information may be sent by email to <a href="mailto:{$email}">{$email}</a>, or by post to {$terms['owner']} Privacy Office, {$terms['address']} {$terms['country']}. </p>
PRIVACY;
		return (strpos($content,'%%') == FALSE) ? ($content . $contact) : $content;
	}

	public static function add_terms_footer($content) {
		$terms = Footer_Credits_Options::get_terms();	
		$disputes = <<< DISPUTES
<h2>Dispute Resolution</h2>
<p>These terms, and any dispute arising from the use of this site, will be governed by {$terms['courts']} without regard to its conflicts of laws provisions.</p>
DISPUTES;
		$feedback = <<< FEEDBACK
<h2>Feedback And Information</h2> 
<p>Any feedback you provide at this site shall be deemed to be non-confidential. {$terms['owner']} shall be free to use such information on an unrestricted basis.</p>
<p>The terms and conditions for this web site are subject to change without notice.<p>
<p>{$terms['copyright']} {$terms['owner']} All rights reserved.<br/> {$terms['owner']}, {$terms['address']} {$terms['country']}</p>
<p>Updated by The {$terms['owner']} Legal Team on {$terms['updated']}</p>
FEEDBACK;
		if (strpos($content,'%%') == FALSE) {
			$content .= $terms['courts'] ? $disputes : '';
			$content .= $terms['address'] ? $feedback : '';
		}
		return $content ;
	}

	public static function fix_home_link( $content, $args) {
		$class =  is_front_page()? ' class="current_page_item"' : '';
		$home_linktexts = array('Home','<span>Home</span>');
		foreach ($home_linktexts as $home_linktext) {
			$home_link = sprintf('<a>%1$s</a>',$home_linktext);
			if (strpos($content, $home_link) !== FALSE) 
				$content = str_replace ($home_link,sprintf('<a href="%1$s"%2$s>%3$s</a>',home_url(),$class,$home_linktext),$content); 
		} 
		return $content;
	}

}

