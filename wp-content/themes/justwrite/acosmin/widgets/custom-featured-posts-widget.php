<?php
/* ------------------------------------------------------------------------- *
 *  Featured Posts Widget
/* ------------------------------------------------------------------------- */

// Setup Widget
class AC_Featured_Posts_Widget extends WP_Widget {

	function AC_Featured_Posts_Widget() {
		// Settings
		$widget_ops = array( 'classname' => 'ac_featured_posts_widget', 'description' => 'Displays posts you set as featured in the editor area.' );
		
		// Create the widget
		$this->WP_Widget( 'ac_featured_posts_widget', __('ACOSMIN: Featured Posts', 'acosmin'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// Widget Settings
		$title = apply_filters('widget_title', $instance['title'] );
		$featured_posts_number	= $instance['featured_posts_number'];
		
		echo $before_widget;

		// Widget Front End Output
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
	

		$args = array( 
			'posts_per_page'		=> $featured_posts_number,
			'meta_key'				=> 'ac_featured_article',
			'meta_value'			=> 1, 
			'ignore_sticky_posts'	=> 1
		);
		$wp_query = new WP_Query();
		$wp_query->query( $args );
		$count = 0; 
		?>
		<ul class="ac-featured-posts">
			<?php if( $wp_query->have_posts()) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); $count++; ?>
			<li id="featured-post-<?php echo $count; ?>">
				<figure class="thumbnail<?php if ( ! has_post_thumbnail() ) echo ' no-thumbnail'; ?>">
					<?php 
					if ( has_post_thumbnail() ) : 
						the_post_thumbnail( 'ac-sidebar-featured' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'acosmin' ) . '" />';
					endif;
					?>
					<figcaption class="details">
						<span class="category"><?php ac_output_first_category(); ?></span>
						<?php the_title( '<a href="' . esc_url( get_permalink() ) . '" class="title" rel="bookmark">', '</a>' ); ?>
						<a href="<?php the_permalink(); ?>" title="<?php _e('Read More', 'acosmin'); ?>" class="read-more"><?php ac_icon('ellipsis-h fa-lg') ?></a>
					</figcaption>
				</figure>
			</li>
			<?php endwhile; endif; wp_reset_postdata(); ?>
		</ul>
		<?php
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['featured_posts_number'] 	= $new_instance['featured_posts_number'];

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Featured Posts', 'featured_posts_number' => 3 );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'acosmin'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        
        <p><strong><?php _e('How many', 'acosmin'); ?> &not;</strong></p>
        
        <p class="ac_two_columns">
		<label for="<?php echo $this->get_field_id( 'featured_posts_number' ); ?>"><?php _e('Featured Posts', 'acosmin'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'featured_posts_number' ); ?>" name="<?php echo $this->get_field_name( 'featured_posts_number' ); ?>" value="<?php echo $instance['featured_posts_number']; ?>" size="3" />
		</p>

		<?php
	}

}
?>