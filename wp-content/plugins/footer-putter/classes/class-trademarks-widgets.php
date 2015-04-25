<?php

class Footer_Putter_Trademark_Widget extends WP_Widget {

	private $instance;
	private $tooltips;

	private $tips = array(
			'title' => array('heading' => 'Title', 'tip' => 'Widget Title'),
			'category' => array('heading' => 'Category', 'tip' => 'Select Link Category for Your Trademarks'),
			'limit' => array('heading' => 'Number of links', 'tip' => 'Number of trademarks to show'),
			'orderby' => array('heading' => 'Order By', 'tip' => 'Sort by name, rating, ID or random'),
			'nofollow' => array('heading' => 'Make Links Nofollow', 'tip' => 'Mark the links with rel=nofollow'),
			'visibility' => array('heading' => 'Widget Visibility', 'tip' => 'Determine on which pages the footer widget is displayed'),
			);

    private	$defaults = array( 'title' => '',
    	'category' => false, 'limit' => '', 'orderby' => 'name', 'nofollow' => false, 'visibility' => '');

	function get_tips() {
		return $this->tips;
	}
	
	function get_defaults() {
		return $this->defaults;
	}
		
	function __construct() {
		add_filter('pre_option_link_manager_enabled', '__return_true' );
		$widget_ops = array('description' => __( 'Trademarks, Service Marks and Kitemarks') );
		parent::__construct('footer_trademarks', __('Trademarks Widget'), $widget_ops);
	}

    function nofollow_links( $content) {
	    return preg_replace_callback( '/<a([^>]*)>(.*?)<\/a[^>]*>/is', array( &$this, 'nofollow_link' ), $content ) ;
    }

    function nofollow_link($matches) { //make link nofollow
		$attrs = shortcode_parse_atts( stripslashes ($matches[ 1 ]) );
		$atts='';
        $rel = ' rel="nofollow"';
		foreach ( $attrs AS $key => $value ) {
			$key = strtolower($key);
            $nofollow = '';
			if ('rel' == $key) {
              $rel = '';
              if (strpos($value, 'follow') === FALSE) $nofollow = ' nofollow';
            }
            $atts .= sprintf(' %1$s="%2$s%3$s"', $key, $value, $nofollow);
		}
		return sprintf('<a%1$s%2$s>%3$s</a>', $rel, $atts, $matches[ 2 ]);
	}

	function widget( $args, $instance ) {
		extract($args, EXTR_SKIP);
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		if (Footer_Putter_Utils::hide_widget($instance['visibility'])) return; //check visibility requirements

		$title = apply_filters('widget_title', $instance['title'] );
		$category = isset($instance['category']) ? $instance['category'] : false;
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';
		$order = $orderby == 'rating' ? 'DESC' : 'ASC';
		$limit = (isset( $instance['limit'] ) && $instance['limit']) ? $instance['limit'] : -1;
		$nofollow = isset( $instance['nofollow'] ) && $instance['nofollow'];

		$links = wp_list_bookmarks(apply_filters('widget_links_args', array(
			'echo' => 0,
			'title_before' => $before_title, 'title_after' => $after_title,
			'title_li' => '', 'categorize' => false,
			'before' => '', 'after' => '',
			'category_before' => '', 'category_after' => '',
			'show_images' => true, 'show_description' => false,
			'show_name' => false, 'show_rating' => false,
			'category' => $category, 'class' => 'trademark widget',
			'orderby' => $orderby, 'order' => $order,
			'limit' => $limit,
		)));
		echo $before_widget;
 		if ($title) echo $before_title . $title . $after_title;
        if ($nofollow)
		    echo $this->nofollow_links($links);
        else
            echo $links;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = wp_parse_args( (array) $old_instance, $this->defaults );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['orderby'] = 'name';
		if ( in_array( $new_instance['orderby'], array( 'name', 'rating', 'id', 'rand' ) ) )
			$instance['orderby'] = $new_instance['orderby'];
		$instance['category'] = intval( $new_instance['category'] );
		$instance['limit'] = ! empty( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : '';
		$instance['nofollow'] = !empty($new_instance['nofollow']);
		$instance['visibility'] = trim($new_instance['visibility']);
		return $instance;
	}

	function form( $instance ) {
		$this->instance = wp_parse_args( (array) $instance, $this->get_defaults() );
		$this->tooltips = new Footer_Putter_Tooltip($this->get_tips());

		$links = array();
		$link_cats = get_terms( 'link_category' );
		foreach ( $link_cats as $link_cat ) {
			$id = intval($link_cat->term_id);
			$links[$id] = $link_cat->name;
		}
		$this->print_form_field('title', 'text', array(), array('size' => 10));
		$this->print_form_field('category', 'select', $links);
		$this->print_form_field('orderby', 'select', array(
			'name' => __( 'Link title'),
			'rating' => __( 'Link rating'),
			'id' => __( 'Link ID'),
			'rand' => __( 'Random')
		));
		$this->print_form_field('limit',  'text', array(),  array('size' => 3 ,'maxlength' => 3));
		$this->print_form_field('nofollow',  'checkbox');
	    $this->print_form_field('visibility', 'radio',
			Footer_Putter_Utils::get_visibility_options(), array('separator' => '<br />'));
	}

	function print_form_field ($fld, $type, $options = array(), $args = array()) {
		$value = array_key_exists($fld,$this->instance) ? $this->instance[$fld] : false;
		print Footer_Putter_Utils::form_field(
			$this->get_field_id($fld), $this->get_field_name($fld), $this->tooltips->tip($fld), $value, $type, $options, $args,'br');
	}
}