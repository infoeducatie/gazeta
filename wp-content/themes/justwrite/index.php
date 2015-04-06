<?php
/* ------------------------------------------------------------------------- *
 *	Index template					
/* ------------------------------------------------------------------------- */
?>
<?php get_header(); ?>

<section class="container<?php ac_mini_disabled() ?> clearfix">
	
    <?php get_sidebar( 'browse' ); ?>
    
    <div class="wrap-template-1 clearfix">
    
    <section class="content-wrap" role="main">
    	
        <?php
			if ( of_get_option( 'ac_show_slider' ) && is_front_page() && !is_paged() && ac_featured_posts_count() > 2 ) {
				get_template_part( 'featured-content' );
			}
		?>

    	<div class="posts-wrap clearfix">
        
        <?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'post-templates/content' );
				endwhile;
			else :
				get_template_part( 'post-templates/content', 'no-articles' );
			endif;			
		?>
        
        </div><!-- END .posts-wrap -->
        
        <?php ac_paginate(); ?>
        
    </section><!-- END .content-wrap -->
    
    <?php get_sidebar(); ?>
    
    </div><!-- END .wrap-template-1 -->
    
</section><!-- END .container -->

<?php get_footer(); ?>