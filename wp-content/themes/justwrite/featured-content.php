<?php
/* ------------------------------------------------------------------------- *
 *	The template used for displaying your featured articles in a slider.					
/* ------------------------------------------------------------------------- */

// Query Arguments
$args = array( 
	'posts_per_page'		=> of_get_option( 'ac_slider_how_many' ),
	'meta_key'				=> 'ac_featured_article',
	'meta_value'			=> 1, 
	'ignore_sticky_posts'	=> 1
);
$featured_posts = new WP_Query( $args );
$count = 0;
?>
            
<section id="main-slider" class="slider-wrap">
	<div class="slider">
		<ul>
        <?php if( $featured_posts->have_posts()) : while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); $count++; ?>
        
			<li>
				<figure class="thumbnail<?php if ( ! has_post_thumbnail() ) echo ' no-thumbnail'; ?>">
					<a href="<?php the_permalink(); ?>" rel="nofollow">
						<?php
							if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'ac-slide-thumbnail' );
							else :
								echo '<img src="' . get_template_directory_uri() . '/images/no-slide-thumbnail.png" alt="' . __( 'No Thumbnail', 'acosmin' ) . '" />';
							endif;
						?>
					</a>    
				</figure>
				<footer class="details">
					<aside class="info clearfix">
						<a href="<?php comments_link(); ?>" rel="nofollow" class="com"><?php ac_icon('comment'); ?></a>
						<time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time>
						<?php ac_output_first_category( 'category' ); ?>
					</aside>
                    <?php the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				</footer>
			</li>
            
        <?php endwhile; endif; wp_reset_postdata(); ?>
		</ul>
	</div><!-- END .slider -->
				
	<nav class="slider-controls clearfix">
		<a href="#" class="slide-btn prev-slide"><?php ac_icon('chevron-left'); ?></a>
		<a href="#" class="slide-btn next-slide"><?php ac_icon('chevron-right'); ?></a>
		<p class="slider-pagination clearfix"></p>
	</nav><!-- END .pagination -->
</section><!-- END .slider-wrap -->