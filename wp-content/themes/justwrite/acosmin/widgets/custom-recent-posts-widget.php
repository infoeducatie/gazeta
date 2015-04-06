<?php
/* ------------------------------------------------------------------------- *
 *  Recent Posts Widget
/* ------------------------------------------------------------------------- */

// Setup Widget
class AC_Recent_Posts_Widget extends WP_Widget {

	function AC_Recent_Posts_Widget() {
		// Settings
		$widget_ops = array( 'classname' => 'ac_recent_posts_widget', 'description' => 'Displays your most recent articles. With or without thumbnails' );
		
		// Create the widget
		$this->WP_Widget( 'ac_recent_posts_widget', __('ACOSMIN: Recent Posts', 'acosmin'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// Widget Settings
		$title = apply_filters('widget_title', $instance['title'] );
		$recent_posts_number	= $instance['recent_posts_number'];
		$hide_recent_thumbs		= isset( $instance['hide_recent_thumbs'] ) ? $instance['hide_recent_thumbs'] : false;
		
		echo $before_widget;

		// Widget Front End Output
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
			
		$args = array(
				'posts_per_page' => $recent_posts_number,
				'ignore_sticky_posts' => 1
		);
		$wp_query = new WP_Query();
		$wp_query->query($args);
		$count = 0; 
		?>
		<ul class="ac-recent-posts">
			<?php if( $wp_query->have_posts()) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); $count++; ?>
			<li class="clearfix<?php if( $hide_recent_thumbs ) { echo ' full-width'; } ?>">
				<?php if( !$hide_recent_thumbs ) { ?>
				<figure class="thumbnail">
					<?php 
					if ( has_post_thumbnail() ) : 
						the_post_thumbnail( 'ac-sidebar-small-thumbnail' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'acosmin' ) . '" class="no-thumbnail" />';
					endif;
					?>
				</figure>
				<?php } ?>
				<div class="details">
					<span class="category"><?php ac_output_first_category(); ?></span>
					<?php the_title( '<a href="' . esc_url( get_permalink() ) . '" class="title" rel="bookmark">', '</a>' ); ?>
					<a href="<?php comments_link(); ?>" class="comments-number"><?php ac_comments_number(); ?></a>
				</div>
			</li>
			<?php endwhile; else : ?>
			<li><?php _e('No popular posts available!', 'acosmin'); ?></li>
			<?php endif; wp_reset_postdata(); ?>
		</ul>
		<?php
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['recent_posts_number'] 	= $new_instance['recent_posts_number'];
		$instance['hide_recent_thumbs']		= $new_instance['hide_recent_thumbs'];

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Recent Posts', 'recent_posts_number' => 5, 'hide_recent_thumbs' => false );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'acosmin'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        
        <p class="ac_break_line"></p>
        
        <p><strong><?php _e('How many', 'acosmin'); ?> &not;</strong></p>
        
        <p class="ac_two_columns">
		<label for="<?php echo $this->get_field_id( 'recent_posts_number' ); ?>"><?php _e('Recent Posts', 'acosmin'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'recent_posts_number' ); ?>" name="<?php echo $this->get_field_name( 'recent_posts_number' ); ?>" value="<?php echo $instance['recent_posts_number']; ?>" size="3" />
		</p>
        
        <p class="ac_break_line"></p>
        
        <p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['hide_recent_thumbs'], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_recent_thumbs' ); ?>" name="<?php echo $this->get_field_name( 'hide_recent_thumbs' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'hide_recent_thumbs' ); ?>"><?php _e('Hide post thumbnails.', 'acosmin'); ?></label>
		</p>

		<?php
	}

}
?>