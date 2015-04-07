<?php 

/************************************************************************/
/*** DISPLAY START
/************************************************************************/
class dpSocialTimeline_wpress_display {
	
	static $js_flag;
	static $js_declaration = array();
	static $id_timeline;
	static $items;
	static $custom;
	static $showFilter;
	static $showLayout;
	static $showTime;
	static $share;
	static $showSocialIcons;
	static $addColorbox;
	static $layoutMode;
	static $skin;
	static $itemWidth;
	static $total;
	public $items_html;

	function dpSocialTimeline_wpress_display($id, $items, $custom, $showFilter, $showTime, $showLayout, $showSocialIcons, $addColorbox, $layoutMode, $skin, $itemWidth, $total, $share) {
		self::$id_timeline = $id;
		self::$items = $items;
		self::$custom = $custom;
		self::$showFilter = $showFilter;
		self::$showLayout = $showLayout;
		self::$showTime = $showTime;
		self::$share = $share;
		self::$showSocialIcons = $showSocialIcons;
		self::$addColorbox = $addColorbox;
		self::$layoutMode = $layoutMode;
		self::$skin = $skin;
		self::$itemWidth = $itemWidth;
		self::$total = $total;

		self::return_dpSocialTimeline();
		add_action('wp_footer', array(__CLASS__, 'add_scripts'), 100);
		
	}
	
	static function add_scripts() {
		if(self::$js_flag) {
			foreach( self::$js_declaration as $key) { echo $key; }
		}
	}
	
	function return_dpSocialTimeline() {
		global $dpSocialTimeline, $wpdb, $table_prefix;
		
		$id = self::$id_timeline;
		
		require_once (dirname (__FILE__) . '/../classes/base.class.php');
		if(is_numeric($id)) {
			$dpSocialTimeline_class = new DpSocialTimeline( false, $id );
		} else {
			$dpSocialTimeline_class = new DpSocialTimeline( false, null, self::$items, self::$custom, self::$showFilter, self::$showLayout, self::$showTime, self::$showSocialIcons, self::$addColorbox, self::$layoutMode, self::$skin, self::$itemWidth, self::$total, self::$share  );
		}
		
		array_walk($dpSocialTimeline, 'dpSocialTimeline_reslash_multi');
		$rand_num = rand();
		
		$items_script= $dpSocialTimeline_class->addScripts();
		self::$js_declaration[] = $items_script;
		
		self::$js_flag = true;
		
		$items_html = $dpSocialTimeline_class->output();
				
		$this->items_html = $items_html;
	}
}

function dpSocialTimeline_simple_shortcode($atts) {
	extract(shortcode_atts(array(
		'id' => '',
		'items' => '',
		'custom' => '',
		'showfilter' => '',
		'showlayout' => '',
		'showtime' => '',
		'showsocialicons' => '',
		'addcolorbox' => '',
		'layoutmode' => '',
		'skin' => '',
		'itemwidth' => '',
		'total' => '',
		'share' => ''
	), $atts));
	
	if ( !is_admin() ){ 
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'isotope', dpSocialTimeline_plugin_url( 'js/isotope.pkgd.min.js' ),
			array('jquery'), DP_SOCIALTIMELINE_VER, true); 
		wp_enqueue_script( 'magnific-popup', dpSocialTimeline_plugin_url( 'js/jquery.magnific-popup.min.js' ),
			array('jquery'), DP_SOCIALTIMELINE_VER, true); 
		wp_enqueue_script( 'dpSocialTimeline', dpSocialTimeline_plugin_url( 'js/jquery.dpSocialTimeline.js' ),
			array('jquery'), DP_SOCIALTIMELINE_VER, true); 
			
		wp_enqueue_style( 'magnific-popup', dpSocialTimeline_plugin_url( 'css/magnific-popup.css' ),
			false, DP_SOCIALTIMELINE_VER, 'all');
		wp_enqueue_style( 'dpSocialTimeline_headcss', dpSocialTimeline_plugin_url( 'css/dpSocialTimeline.css' ),
			false, DP_SOCIALTIMELINE_VER, 'all');
	}
	
	$dpSocialTimeline_wpress_display = new dpSocialTimeline_wpress_display($id, $items, $custom, $showfilter, $showtime, $showlayout, $showsocialicons, $addcolorbox, $layoutmode, $skin, $itemwidth, $total, $share);
	return $dpSocialTimeline_wpress_display->items_html;
}
add_shortcode('dpSocialTimeline', 'dpSocialTimeline_simple_shortcode');

/************************************************************************/
/*** DISPLAY END
/************************************************************************/

/************************************************************************/
/*** WIDGET START
/************************************************************************/

class DpSocialTimeline_Widget extends WP_Widget {
	function __construct() {
		$params = array(
			'description' => 'Use the timeline as a widget.',
			'name' => 'DP Social Timeline'
		);
		
		parent::__construct('SocialTimeline', '', $params);
	}
	
	public function form($instance) {
		global $wpdb, $table_prefix;
		$table_name = $table_prefix.DP_SOCIALTIMELINE_TABLE;
		
		extract($instance);
		?>
        	<p>
            	<label for="<?php echo $this->get_field_id('title');?>">Title: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php if(isset($title)) echo esc_attr($title); ?>" />
            </p>
            
            <p>
            	<label for="<?php echo $this->get_field_id('description');?>">Description: </label>
                <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('description');?>" name="<?php echo $this->get_field_name('description');?>"><?php if(isset($description)) echo esc_attr($description); ?></textarea>
            </p>
            
            <p>
            	<label for="<?php echo $this->get_field_id('timeline');?>">Timeline: </label>
            	<select name="<?php echo $this->get_field_name('timeline');?>" id="<?php echo $this->get_field_id('timeline');?>">
                    <?php
                    $querystr = "
                    SELECT *
                    FROM $table_name
                    ORDER BY title ASC
                    ";
                    $timelines_obj = $wpdb->get_results($querystr, OBJECT);
                    foreach($timelines_obj as $timeline_key) {
                    ?>
                        <option value="<?php echo $timeline_key->id?>" <?php if($timeline == $timeline_key->id) {?> selected="selected" <?php } ?>><?php echo $timeline_key->title?></option>
                    <?php }?>
                </select>
            </p>
        <?php
	}
	
	public function widget($args, $instance) {
		global $wpdb, $table_prefix;
		$table_name = $table_prefix.DP_SOCIALTIMELINE_TABLE;
		
		extract($args);
		extract($instance);
		
		$title = apply_filters('widget_title', $title);
		$description = apply_filters('widget_description', $description);
		
		//if(empty($title)) $title = 'DP Social Timeline';
		
		echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<p>'. $description. '</p>';
			echo do_shortcode('[dpSocialTimeline id='.$timeline.']');
		echo $after_widget;
		
	}
}

add_action('widgets_init', 'dpSocialTimeline_register_widget');
function dpSocialTimeline_register_widget() {
	register_widget('DpSocialTimeline_Widget');
}

/************************************************************************/
/*** WIDGET END
/************************************************************************/
/*
function dpSocialTimeline_enqueue_scripts() {
	
}

add_action( 'init', 'dpSocialTimeline_enqueue_scripts' );

function dpSocialTimeline_enqueue_styles() {	
  global $post, $dpSocialTimeline;
  
  
}
add_action( 'wp', 'dpSocialTimeline_enqueue_styles' );
*/
//admin settings
function dpSocialTimeline_admin_scripts() {
	global $dpSocialTimeline;
	if ( is_admin() ){ // admin actions
		// Settings page only
		if ( isset($_GET['page']) && ('dpSocialTimeline-admin' == $_GET['page'] || 'dpSocialTimeline-twitter' == $_GET['page'])  ) {
		wp_register_script('jquery', false, false, false, false);
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
			
		wp_enqueue_style('thickbox');
		wp_enqueue_style( 'dpSocialTimeline_admin_head_css', dpSocialTimeline_plugin_url( 'css/admin-styles.css' ),
			false, DP_SOCIALTIMELINE_VER, 'all');
		
		wp_enqueue_script( 'isotope', dpSocialTimeline_plugin_url( 'js/jquery.isotope.min.js' ),
			array('jquery'), DP_SOCIALTIMELINE_VER, false); 
		wp_enqueue_script( 'magnific-popup', dpSocialTimeline_plugin_url( 'js/jquery.magnific-popup.min.js' ),
			array('jquery'), DP_SOCIALTIMELINE_VER, false); 
		wp_enqueue_script( 'dpSocialTimeline', dpSocialTimeline_plugin_url( 'js/jquery.dpSocialTimeline.js' ),
			array('jquery'), DP_SOCIALTIMELINE_VER, false); 
		wp_enqueue_script ( 'dpSocialTimeline_admin', dpSocialTimeline_plugin_url( 'js/admin_settings.js' )); 
		wp_localize_script( 'dpSocialTimeline', 'SocialTimelineAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'postPreviewNonce' => wp_create_nonce( 'ajax-get-items-nonce' ) ) );
	
		wp_enqueue_style( 'dpSocialTimeline_headcss', dpSocialTimeline_plugin_url( 'css/dpSocialTimeline.css' ),
			false, DP_SOCIALTIMELINE_VER, 'all');
		wp_enqueue_style( 'magnific-popup', dpSocialTimeline_plugin_url( 'css/magnific-popup.css' ),
			false, DP_SOCIALTIMELINE_VER, 'all');
		
		};
  	}
}

add_action( 'admin_init', 'dpSocialTimeline_admin_scripts' );

function dpSocialTimeline_admin_head() {
	global $dpSocialTimeline;
	if ( is_admin() ){ // admin actions
	   
	   // Timeline page only
		if ( isset($_GET['page']) && 'dpSocialTimeline-admin' == $_GET['page'] ) {
		?>
			<script type="text/javascript">
			// <![CDATA[
				function confirmTimelineDelete()
				{
					var agree=confirm("Delete this Timeline?");
					if (agree)
					return true ;
					else
					return false ;
				}
				
				function timeline_checkform ()
				{
					if (document.getElementById('title').value == "") {
						alert( "Please enter the title of the timeline." );
						document.getElementById('title').focus();
						return false ;
					}
										
					if (document.getElementById('dpSocialTimeline_width').value == "") {
						alert( "Please enter the width of the timeline." );
						document.getElementById('dpSocialTimeline_width').focus();
						return false ;
					}
					return true ;
				}
				
				function toggleFormat(chk, div) {
					if(jQuery(chk).attr("checked")) {
						jQuery('#'+div).slideDown('fast');
					} else {
						jQuery('#'+div).slideUp('fast');
					}
				}
								
			//]]>
			</script>
	<?php
	   } //Timeline page only
	   
	   
	 }//only for admin
}
add_action('admin_head', 'dpSocialTimeline_admin_head');
?>