<?php
/* ------------------------------------------------------------------------- *
 *  Social Buttons Widget
/* ------------------------------------------------------------------------- */

// Setup Widget
class AC_Social_Buttons_Widget extends WP_Widget {
	
	// Widget Information
	function ac_social_buttons_widget()  {
		
		$widget_ops = array('classname' => 'ac-social-buttons-widget', 'description' => __('Displays buttons for your social profiles.', 'acosmin') );
		
		$this->WP_Widget('ac_social_buttons_widget', __('ACOSMIN: Social Buttons', 'acosmin'), $widget_ops);
		
	}
	
	// Widget Display
	function widget( $args, $instance ) {
		
		extract( $args );
		$social_names = array( 'Twitter', 'Facebook', 'Google Plus', 'RSS', 'YouTube', 'Instagram', 'FlickR', 'Tumblr', 'VK', 'Pinterest', 'LinkedIn', 'Dribbble', 'GitHub' );
		
		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;
		if ( $title ) { 
			echo $before_title . $title . $after_title; 
		}
		?>
        
        <ul class="sidebar-social clearfix">
        	<?php
			$count = 0; 
			foreach( $social_names as $social_name ) {
				$social_id = strtolower($social_name);
				$social_title = $social_id . "_title";
				$social_icon = str_replace(' ', '-', $social_id);
				if( $instance[$social_id] && $instance[$social_id] != '' ) {
					$count++;
					if( $count % 2 == 0 ) { $social_align = 'alignright'; } else { $social_align = 'alignleft'; }
					echo '<li class="' . $social_align . '"><a href="'. esc_url( $instance[$social_id] ) .'" class="social-btn ' . $social_icon . '">' . esc_html( $instance[$social_title] ) . ac_icon( $social_icon, false ) . '</a></li>';
				}
			} ?>
        </ul>
        
        <?php
		echo $after_widget;
	}
	
	/* Update settings.*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
	    $instance['title'] = strip_tags( $new_instance['title'] );
		$social_names = array( 'Twitter', 'Facebook', 'Google Plus', 'RSS', 'YouTube', 'Instagram', 'FlickR', 'Tumblr', 'VK', 'Pinterest', 'LinkedIn', 'Dribbble', 'GitHub' );
		
		foreach ( $social_names as $social_name )
		{
			$social_id = strtolower($social_name);
			$social_title = $social_id . "_title";
			$instance[$social_id] = strip_tags( $new_instance[$social_id] );
			$instance[$social_title] = strip_tags( $new_instance[$social_title] );
		}
		
		return $instance;
	}
	
	// Display Form Fields
	function form( $instance ) {
		
		$social_names = array( 'Twitter', 'Facebook', 'Google Plus', 'RSS', 'YouTube', 'Instagram', 'FlickR', 'Tumblr', 'VK', 'Pinterest', 'LinkedIn', 'Dribbble', 'GitHub' );

		/* Default settings */
		$defaults = array( 'title' => 'Widget Title' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$social_id = ''; 
		$social_title = '';
		
		?>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'acosmin'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>
        
        <p class="ac_break_line"></p>
        
		<?php
		
		foreach ( $social_names as $social_name ) {
			
			$social_id = strtolower($social_name);
			$social_title = $social_id . "_title";

			?>
 	 		<p class="ac_two_columns">
 				<label for="<?php echo $this->get_field_id( $social_id ); ?>"><strong><?php echo $social_name; ?> URL</strong></label> 
				<input type="text" id="<?php echo $this->get_field_id( $social_id ); ?>" name="<?php echo $this->get_field_name( $social_id ); ?>" value="<?php if(isset($instance[$social_id])) { echo esc_url( $instance[$social_id] ); }; ?>" /> 

			</p> 
			<p class="ac_two_columns last"> 

 				<label for="<?php echo $this->get_field_id( $social_title ); ?>">Label</label>
				<input type="text"  id="<?php echo $this->get_field_id( $social_title ); ?>" name="<?php echo $this->get_field_name( $social_title ); ?>" value="<?php if(isset($instance[$social_title])) { echo $instance[$social_title]; }; ?>" />
			</p> 
            <?php 
		}

	}

}
register_widget( 'AC_Social_Buttons_Widget' );