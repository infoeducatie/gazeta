<?php
class Footer_Credits_Admin extends Footer_Putter_Admin{

	private $tips = array(
			'owner' => array('heading' => 'Owner or Business Name', 'tip' => 'Enter the name of the legal entity that owns and operates the site.'),
            'microdata' => array('heading' => 'Use Microdata', 'tip' => 'Markup the organization details with HTML5 microdata.'),
			'address' => array('heading' => 'Full Address', 'tip' => 'Enter the full address that you want to appear in the footer and the privacy and terms pages.'),
	        'street_address' => array('heading' => 'Street Address', 'tip' => 'Enter the firat line of the address that you want to appear in the footer and the privacy and terms pages.'),
			'locality' => array('heading' => 'Locality (City)', 'tip' => 'Enter the town or city.'),
			'region' => array('heading' => 'State (Region)', 'tip' => 'Enter the state, province, region or county.'),
			'postal_code' => array('heading' => 'Postal Code', 'tip' => 'Enter the postal code.'),
			'country' => array('heading' => 'Country', 'tip' => 'Enter the country where the legal entity is domiciled.'),
			'latitude' => array('heading' => 'Latitude', 'tip' => 'Enter the latitude of the organization&#39;s location - maybe be used by Google or local search.'),
			'longitude' => array('heading' => 'Longitude', 'tip' => 'Enter the longitude of the organization&#39;s location - maybe be used by Google or local search.'),
			'map' => array('heading' => 'Map URL', 'tip' => 'Enter the URL of a map that shows the organization&#39;s location.'),
			'telephone' => array('heading' => 'Telephone Number', 'tip' => 'Enter a telephone number here if you want it to appear in the footer of the installed site.'),
			'email' => array('heading' => 'Email Address', 'tip' => 'Enter the email address here if you want it to appear in the footer and in the privacy statement.'),
			'courts' => array('heading' => 'Legal Jurisdiction' , 'tip' => 'The Courts that have jurisdiction over any legal disputes regarding this site. For example: <i>the state and federal courts in Santa Clara County, California</i>, or <i>the Law Courts of England and Wales</i>'),
			'updated' => array('heading' => 'Last Updated' , 'tip' => 'This will be defaulted as today. For example, Oct 23rd, 2012'),
			'copyright_preamble' => array('heading' => 'Copyright Text' , 'tip' => 'Something like:<br/> Copyright &copy; All Rights Reserved.'),
			'copyright_start_year' => array('heading' => 'Copyright Start' , 'tip' => 'The start year of the business appears in the copyright statement in the footer and an on the Terms and Conditions page.'),
			'return_text' => array('heading' => 'Link Text' , 'tip' => 'The text of the Return To Top link. For example, <i>Return To Top</i> or <i>Back To Top</i>.'),
			'return_class' => array('heading' => 'Return To Top Class' , 'tip' => 'Add any custom class you want to apply to the Return To Top link.'),
			'footer_class' => array('heading' => 'Footer Class' , 'tip' => 'Add any custom class you want to apply to the footer. The plugin comes with a class <i>white</i> that marks the text in the footer white. This is useful where the footer background is a dark color.'),
			'footer_hook' => array('heading' => 'Footer Action Hook' , 'tip' => 'The hook where the footer widget area is added to the page. This field is only required if the theme does not already provide a suitable widget area where the footer widgets can be added.'),
			'footer_remove' => array('heading' => 'Remove Existing Actions?' , 'tip' => 'Click the checkbox to remove any other actions at the above footer hook. This may stop you getting two footers; one created by your theme and another created by this plugin. For some themes you will check this option as you will typically want to replace the theme footer by the plugin footer.'),
			'footer_filter_hook' => array('heading' => 'Footer Filter Hook' , 'tip' => 'If you want to kill off the footer created by your theme, and your theme allows you to filter the content of the footer, then enter the hook where the theme filters the footer. This may stop you getting two footers; one created by your theme and another created by this plugin.'),
			'privacy_contact' => array('heading' => 'Add Privacy Contact?', 'tip' => 'Add a section to the end of the Privacy page with contact information'),
			'terms_contact' => array('heading' => 'Add Terms Contact?', 'tip' => 'Add a section to the end of the Terms page with contact and legal information'),
	);
		
	function init() {
		add_action('admin_menu',array($this, 'admin_menu'));
	}

	function admin_menu() {
		$this->screen_id = add_submenu_page($this->get_parent_slug(), __('Footer Credits'), __('Footer Credits'), 'manage_options', 
			$this->get_slug(), array($this,'page_content'));
		add_action('load-'.$this->get_screen_id(), array($this, 'load_page'));
	}

	function page_content() {
		$title = $this->admin_heading('Footer Credits',FOOTER_PUTTER_ICON);				
		$this->print_admin_form_with_sidebar_start($title); 
		do_meta_boxes($this->get_screen_id(), 'side', null); 
		$this->print_admin_form_with_sidebar_middle();
		do_meta_boxes($this->get_screen_id(), 'normal', null); 
		$this->print_admin_form_end(__CLASS__, $this->get_keys());
	}   

	function load_page() {
 		$message = isset($_POST['options_update']) ? $this->save_credits() : '';	
		$options = Footer_Credits_Options::get_options();
		$callback_params = array ('options' => $options, 'message' => $message);
		$this->add_meta_box('introduction',  'Introduction' , 'intro_panel', $callback_params);
		$this->add_meta_box('owner',  'Site Owner Details' , 'owner_panel', $callback_params);
		$this->add_meta_box('contact',  'Contact Details' , 'contact_panel', $callback_params);
		$this->add_meta_box('legal',  'Legal Details' , 'legal_panel', $callback_params);
		$this->add_meta_box('return',  'Return To Top' , 'return_panel', $callback_params);
		$this->add_meta_box('example',  'Preview Footer Content' , 'preview_panel', $callback_params);
		$this->add_meta_box('advanced',  'Advanced' , 'advanced_panel', $callback_params);
		$this->add_meta_box('news', 'DIY Webmastery News', 'news_panel',$callback_params, 'side');

	    $this->set_tooltips($this->tips);	
		add_action('admin_enqueue_scripts', array($this, 'enqueue_credits_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
 		add_action('admin_enqueue_scripts',array($this, 'enqueue_postbox_scripts'));	
	}

	function enqueue_credits_styles() {
		wp_enqueue_style($this->get_code(), plugins_url('styles/footer-credits.css', dirname(__FILE__)), array(),$this->get_version());		
}		

 	function news_panel($post,$metabox){	
		Footer_Putter_Feed_Widget::display_feeds();
	}

	function intro_panel($post,$metabox) {	
		$message = $metabox['args']['message'];	 	
		print <<< INTRO_PANEL
<p>The following information is used in the Footer Copyright Widget and optionally at the end of the Privacy Statement and Terms and Conditions pages.</p>
{$message}
INTRO_PANEL;
	}
	
	function owner_panel($post,$metabox) {	
		$terms = $metabox['args']['options']['terms'];	 	
		$this->print_text_field('owner', $terms['owner'], array('size' =>30));		
		$this->print_text_field('country', $terms['country'], array('size' => 30));		
		$this->print_text_field('address', $terms['address'], array('size' => 80));		
		if (Footer_Credits::is_html5()) {
			print('<p>Leave the above address field blank and fill in the various parts of the organization address below if you want to be able to use HTML5 microdata.</p>');
			print('<h4>Organization Address</h4>');
			$this->print_text_field('street_address', $terms['street_address'],  array('size' => 30));	
			$this->print_text_field('locality', $terms['locality'],  array('size' => 30));	
			$this->print_text_field('region', $terms['region'],  array('size' => 30));	
			$this->print_text_field('postal_code', $terms['postal_code'],  array('size' => 12));	
			print('<h4>Geographical Co-ordinates</h4>');
			print('<p>The geographical co-ordinates are optional and are visible only to the search engines.</p>');
			$this->print_text_field('latitude', $terms['latitude'], array('size' => 12));	
			$this->print_text_field('longitude', $terms['longitude'], array('size' => 12));	
			$this->print_text_field('map', $terms['map'],  array('size' =>30));	
		}
	}

	function contact_panel($post,$metabox) {
		$terms = $metabox['args']['options']['terms'];
		$this->print_text_field('email', $terms['email'],  array('size' => 30));		
		$this->print_text_field('telephone', $terms['telephone'],  array('size' => 30));		
		$this->print_form_field('privacy_contact', $terms['privacy_contact'], 'checkbox');
		$this->print_form_field('terms_contact', $terms['terms_contact'], 'checkbox');
	}

 	function legal_panel($post,$metabox) {
		$terms = $metabox['args']['options']['terms'];
		$this->print_text_field('courts', $terms['courts'],  array('size' => 80));		
		$this->print_text_field('updated', $terms['updated'],  array('size' => 30));		
		$this->print_text_field('copyright_preamble', $terms['copyright_preamble'],  array('size' => 30));		
		$this->print_text_field('copyright_start_year', $terms['copyright_start_year'],  array('size' => 5));		
	}

 	function return_panel($post,$metabox) {		
		$options = $metabox['args']['options'];	 	
		$this->print_text_field('return_text', $options['return_text'], array('size' => 20));		
	}

 	function preview_panel($post,$metabox) {		
		$options = $metabox['args']['options'];	 	
		echo Footer_Credits::footer(array('nav_menu' => 'Footer Menu'));
	}

 	function advanced_panel($post,$metabox) {		
		$options = $metabox['args']['options'];	 	
		$url = 'http://www.diywebmastery.com/footer-credits-compatible-themes-and-hooks';
		print <<< ADVANCED_PANEL
<p>You can place the Copyright and Trademark widgets in any existing widget area. However, if your theme does not have a suitably located widget area in the footer then you can create one by specifying the hook
where the Widget Area will be located.</p>
<p>You may use a standard WordPress hook like <i>get_footer</i> or <i>wp_footer</i> or choose a hook that is theme-specific such as <i>twentyten_credits</i>, 
<i>twentyeleven_credits</i>, <i>twentytwelve_credits</i>,<i>twentythirteen_credits</i> or <i>twentyfourteen_credits</i>. If you using a Genesis child theme and the theme does not have a suitable widget area then use 
the hook <i>genesis_footer</i> or maybe <i>genesis_after</i>. See what looks best. Click for <a href="{$url}">suggestions of which hook to use for common WordPress themes</a>.</p> 
ADVANCED_PANEL;
		$this->print_text_field('footer_hook', $options['footer_hook'],  array('size' => 30));		
		$this->print_form_field('footer_remove', $options['footer_remove'], 'checkbox');
		print <<< REMOVE_PANEL
<p>If your WordPress theme supplies a filter hook rather than an action hook where it generates the footer, and you want to suppress the theme footer,
then specify the hook below. For example, entering <i>genesis_footer_output</i> will suppress the standard Genesis child theme footer.</p>
REMOVE_PANEL;
		$this->print_text_field('footer_filter_hook', $options['footer_filter_hook'],  array('size' => 30));		
	} 

	function save_credits() {
		check_admin_referer(__CLASS__);
  		$page_options = explode(',', stripslashes($_POST['page_options']));
  		if ($page_options) {
  			$options = Footer_Credits_Options::get_options();
    		foreach ($page_options as $option) {
       			$val = array_key_exists($option, $_POST) ? trim(stripslashes($_POST[$option])) : '';
				if (Footer_Credits_Options::is_terms_key($option))
					$options['terms'][$option] = $val;
 				else switch($option) {
					case 'footer_remove' : $options[$option] = !empty($val); break;
 					case 'footer_hook': 
 					case 'footer_filter_hook': $options[$option] = preg_replace('/\W/','',$val); break;
					default: $options[$option] = trim($val); 				
					}
    		} //end for	
    		$class='updated fade';
   			$saved =  Footer_Credits_Options::save_options($options) ;
   			if ($saved)  {
       			$message = 'Footer Settings saved.';
   			} else
       			$message = 'Footer Settings have not been changed.';
  		} else {
  		    $class='error';
       		$message= 'Footer Settings not found!';
  		}
  		return sprintf('<div id="message" class="%1$s "><p>%2$s</p></div>',$class, __($message));
	}

}
