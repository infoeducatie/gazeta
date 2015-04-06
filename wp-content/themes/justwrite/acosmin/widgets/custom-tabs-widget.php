<?php
/* ------------------------------------------------------------------------- *
 *  Tabs Widget
/* ------------------------------------------------------------------------- */

// Setup Widget
class AC_Tabs_Widget extends WP_Widget {

	function AC_Tabs_Widget() {
		// Settings
		$widget_ops = array( 'classname' => 'ac_tabs_widget', 'description' => 'Custom designed tabs for your main sidebar' );
		
		// Create the widget
		$this->WP_Widget( 'ac_tabs_widget', __('ACOSMIN: Tabs', 'acosmin'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// Widget Settings
		$show_popular_posts 	= isset( $instance['show_popular_posts'] ) ? $instance['show_popular_posts'] : false;
		$show_featured_posts	= isset( $instance['show_featured_posts'] ) ? $instance['show_featured_posts'] : false;
		$show_recent_posts		= isset( $instance['show_recent_posts'] ) ? $instance['show_recent_posts'] : false;
		$show_recent_comments	= isset( $instance['show_recent_comments'] ) ? $instance['show_recent_comments'] : false;
		$show_tags				= isset( $instance['show_tags'] ) ? $instance['show_tags'] : false;
		
		// How Many Posts Settings
		$popular_posts_number	= $instance['popular_posts_number'];
		$featured_posts_number	= $instance['featured_posts_number'];
		$recent_posts_number	= $instance['recent_posts_number'];
		$recent_comments_number	= $instance['recent_comments_number'];
		
		// Hide thumbnails
		$hide_recent_thumbs		= isset( $instance['hide_recent_thumbs'] ) ? $instance['hide_recent_thumbs'] : false;
		
		// Widget Front End Output
		echo '<aside class="side-box widget" id="ac-tabs-widget">';
		
		if( $show_popular_posts || $show_featured_posts || $show_recent_posts || $show_recent_comments || $show_tags ) {
			
			// Navigation
			echo '<nav class="tabs-widget-navigation clearfix">';
        	echo '<ul>';
        	if( $show_popular_posts )		{ echo '<li><a href="#tab-1" title="' . __('Popular Posts', 'acosmin') . '"><i class="fa fa-list-ol"></i></a></li>'; }
        	if( $show_featured_posts )		{ echo '<li><a href="#tab-2" title="' . __('Featured Posts', 'acosmin') . '"><i class="fa fa-star"></i></a></li>'; }
        	if( $show_recent_posts )		{ echo '<li><a href="#tab-3" title="' . __('Latest Posts', 'acosmin') . '"><i class="fa fa-bell"></i></a></li>'; }
        	if( $show_recent_comments )		{ echo '<li><a href="#tab-4" title="' . __('Recent Comments', 'acosmin') . '"><i class="fa fa-comments"></i></a></li>'; }
        	if( $show_tags )				{ echo '<li><a href="#tab-5" title="' . __('Tag Cloud', 'acosmin') . '"><i class="fa fa-tags"></i></a></li>'; }
        	echo '</ul>';
        	echo '</nav>';
			
			// Tabs & Content
			// -- Popular Posts
			if( $show_popular_posts ) {
				?>
                	<div class="sb-content clearfix" id="tab-1">
                    	<?php 
						$args = array( 
							'orderby' => 'comment_count', 
							'posts_per_page' => $popular_posts_number,
							'ignore_sticky_posts' => 1
						);
						$wp_query = new WP_Query();
						$wp_query->query($args);
						$count = 0; 
						?>
                    	<ul class="ac-popular-posts">
                        	<?php if( $wp_query->have_posts()) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
									$count++;
                             		$mcn = get_comments_number();
									$ncn = get_comments_number();
									
									if( $count == 1 ) { $max_comments_number = $mcn; };
									
									if ( $ncn != 0 ) {
											$make_percent = number_format(100 * $ncn / $max_comments_number);
							?>
                             <li>
                            	<span class="position"><?php echo $count; ?></span>
                                <div class="details">
                        			<span class="category"><?php ac_output_first_category(); ?></span>
                                    <?php the_title( '<a href="' . esc_url( get_permalink() ) . '" class="title" rel="bookmark">', '</a>' ); ?>
                            		<div class="the-percentage" style="width: <?php echo $make_percent; ?>%"></div>
                            		<a href="<?php comments_link(); ?>" class="comments-number"><?php ac_comments_number(); ?></a>
                        		</div>
                            </li>
                            <?php }; endwhile; else : ?>
                            <li><?php _e('No popular posts available!', 'acosmin'); ?></li>
                            <?php endif; wp_reset_postdata(); ?>
                        </ul>
                    </div>
                <?php
			} // .END $show_popular_posts
			
			// -- Featured Posts
			if( $show_featured_posts ) {
				?>
                	<div class="sb-content clearfix" id="tab-2">
                    	<?php 
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
                            			<span class="category"><?php ac_output_first_category(); echo get_post_meta('ac_featured_post') ?></span>
                                        <?php the_title( '<a href="' . esc_url( get_permalink() ) . '" class="title" rel="bookmark">', '</a>' ); ?>
                                		<a href="<?php the_permalink(); ?>" title="<?php _e('Read More', 'acosmin'); ?>" class="read-more"><?php ac_icon('ellipsis-h fa-lg') ?></a>
                            		</figcaption>
                        		</figure>
                    		</li>
                            <?php endwhile; endif; wp_reset_postdata(); ?>
                        </ul>
                    </div>
                <?php
			} // .END $show_featured_posts
			
			// -- Recent Posts
			if( $show_recent_posts ) {
				?>
                	<div class="sb-content clearfix" id="tab-3">
                    	<?php 
						$args = array(
							'posts_per_page' => $recent_posts_number,
							'ignore_sticky_posts' => 1
						);
						$wp_query = new WP_Query();
						$wp_query->query($args);
						$count = 0; 
						?>
                    	<ul class="ac-recent-posts">
                        	<?php if( $wp_query->have_posts()) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
									$count++;
							?>
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
                    </div>
                <?php
			} // .END $show_recent_posts
			
			// -- Recent Comments
			if( $show_recent_comments ) {
				?>
                	<div class="sb-content clearfix" id="tab-4">
                    	<?php
							$args = array( 
										'before_widget'		=> '',
										'after_widget'		=> '',
										'before_title'		=> '',
										'after_title'		=> ''
									);
							$instance = array( 
										'title'		=> ' ',
										'number'	=> $recent_comments_number
									);
							the_widget( 'WP_Widget_Recent_Comments', $instance, $args ); 
						?>
                    </div>
                <?php
			} // .END $show_recent_comments
			
			// -- Tag Cloud
			if( $show_tags ) {
				?>
                	<div class="sb-content clearfix" id="tab-5">
                    	<?php
							$args = array( 
										'before_widget'		=> '',
										'after_widget'		=> '',
										'before_title'		=> '',
										'after_title'		=> ''
									);
							$instance = array( 
										'title'		=> ' ',
										'filter'	=> 'tags'
									);
							the_widget( 'WP_Widget_Tag_Cloud', $instance, $args ); 
						?>
                    </div>
                <?php
			} // .END $show_tags
			
		} else {
			echo '<div class="sb-content">' . __('Please select some settings for this widget - Tabs', 'acosmin') . '</div>';
		}
		
		echo '</aside><!-- END .sidebox .widget -->';

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['show_popular_posts']		= $new_instance['show_popular_posts'];
		$instance['show_featured_posts']	= $new_instance['show_featured_posts'];
		$instance['show_recent_posts']		= $new_instance['show_recent_posts'];
		$instance['show_recent_comments']	= $new_instance['show_recent_comments'];
		$instance['show_tags']				= $new_instance['show_tags'];
		
		$instance['popular_posts_number'] 	= $new_instance['popular_posts_number'];
		$instance['featured_posts_number']	= $new_instance['featured_posts_number'];
		$instance['recent_posts_number']	= $new_instance['recent_posts_number'];
		$instance['recent_comments_number']	= $new_instance['recent_comments_number'];
		
		$instance['hide_recent_thumbs']		= $new_instance['hide_recent_thumbs'];

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'show_popular_posts' => true, 'show_featured_posts' => true, 'show_recent_posts' => true, 'show_recent_comments' => true, 'show_tags' => true, 'popular_posts_number' => 3, 'featured_posts_number' => 3, 'recent_posts_number' => 3, 'recent_comments_number' => 5, 'hide_recent_thumbs' => false );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_popular_posts'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_popular_posts' ); ?>" name="<?php echo $this->get_field_name( 'show_popular_posts' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_popular_posts' ); ?>"><?php _e('Show "Popular Posts" tab.', 'acosmin'); ?></label>
		</p>
        
        <p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_featured_posts'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_featured_posts' ); ?>" name="<?php echo $this->get_field_name( 'show_featured_posts' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_featured_posts' ); ?>"><?php _e('Show "Featured Posts" tab.', 'acosmin'); ?></label>
		</p>
        
        <p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_recent_posts'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_recent_posts' ); ?>" name="<?php echo $this->get_field_name( 'show_recent_posts' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_recent_posts' ); ?>"><?php _e('Show "Recent Posts" tab.', 'acosmin'); ?></label>
		</p>
        
        <p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_recent_comments'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_recent_comments' ); ?>" name="<?php echo $this->get_field_name( 'show_recent_comments' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_recent_comments' ); ?>"><?php _e('Show "Recent Comments" tab.', 'acosmin'); ?></label>
		</p>
        
        <p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_tags'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_tags' ); ?>" name="<?php echo $this->get_field_name( 'show_tags' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_tags' ); ?>"><?php _e('Show "Tag Cloud" tab.', 'acosmin'); ?></label>
		</p>
        
        <p class="ac_break_line"></p>
        
        <p><strong><?php _e('How many', 'acosmin'); ?> &not;</strong></p>
        
        <p class="ac_two_columns">
		<label for="<?php echo $this->get_field_id( 'popular_posts_number' ); ?>"><?php _e('Popular Posts', 'acosmin'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'popular_posts_number' ); ?>" name="<?php echo $this->get_field_name( 'popular_posts_number' ); ?>" value="<?php echo $instance['popular_posts_number']; ?>" size="3" />
		</p>
        
        <p class="ac_two_columns">
		<label for="<?php echo $this->get_field_id( 'featured_posts_number' ); ?>"><?php _e('Featured Posts', 'acosmin'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'featured_posts_number' ); ?>" name="<?php echo $this->get_field_name( 'featured_posts_number' ); ?>" value="<?php echo $instance['featured_posts_number']; ?>" size="3" />
		</p>
        
        <p class="ac_two_columns">
		<label for="<?php echo $this->get_field_id( 'recent_posts_number' ); ?>"><?php _e('Recent Posts', 'acosmin'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'recent_posts_number' ); ?>" name="<?php echo $this->get_field_name( 'recent_posts_number' ); ?>" value="<?php echo $instance['recent_posts_number']; ?>" size="3" />
		</p>
        
        <p class="ac_two_columns">
		<label for="<?php echo $this->get_field_id( 'recent_comments_number' ); ?>"><?php _e('Recent Comments', 'acosmin'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'recent_comments_number' ); ?>" name="<?php echo $this->get_field_name( 'recent_comments_number' ); ?>" value="<?php echo $instance['recent_comments_number']; ?>" size="3" />
		</p>
        
        <p class="ac_break_line"></p>
        
        <p><strong><?php _e('Hide post thumbnails in', 'acosmin'); ?> &not;</strong></p>
        
        <p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['hide_recent_thumbs'], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_recent_thumbs' ); ?>" name="<?php echo $this->get_field_name( 'hide_recent_thumbs' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'hide_recent_thumbs' ); ?>"><?php _e('"Recent Posts" tab.', 'acosmin'); ?></label>
		</p>

		<?php
	}

}
?>