<?php
/* ------------------------------------------------------------------------- *
 *	Single (Post) template			
/* ------------------------------------------------------------------------- */

//  Settings
$disable_elements 	= of_get_option( 'ac_disable_elements' );
$disable_about 		= $disable_elements['about'];

//  Check if it is a post format
$format = get_post_format();

if ( false === $format ) {
	$format = 'single';	
}
?>

<?php get_header(); ?>

<section class="container<?php ac_mini_disabled() ?> clearfix">
	
    <?php get_sidebar( 'browse' ); ?>
    
    <div class="wrap-template-1 clearfix">
    
    <section class="content-wrap clearfix" role="main">
    
    	<section class="posts-wrap single-style-template-1 clearfix">
        
        <?php
			// Post Loop
			while ( have_posts() ) :
				the_post();
				get_template_part( 'post-templates/content', $format );
			endwhile;
		?>
        
        </section><!-- END .posts-wrap -->
        
        <section class="about-share clearfix">
        
        	<div class="as-wrap clearfix">
            	
                <aside class="share-pagination<?php if( $disable_about ) { echo ' about-disabled'; } ?> clearfix">
                    
                    <?php 
						// Next - Previous Post
						ac_post_nav_arrows(); 
					?>
                    
                    <div class="clear-border"></div>
                </aside><!-- END .share-pagination -->
                
               	<?php
					// Before Author Box
					ac_before_author_box(); 
				
					// About The Author Side
					if ( !$disable_about ) {
						get_template_part( 'post-templates/about-the-author' );
					}
					
					// After Author Box
					ac_after_author_box();
				?>
                
            </div><!-- END .as-wrap -->
        
        </section><!-- END .about-share -->
        
        <?php comments_template(); ?>
        
    </section><!-- END .content-wrap -->
    
    <?php get_sidebar( 'posts' ); ?>
    
    </div><!-- END .wrap-template-1 -->
    
</section><!-- END .container -->

<?php get_footer(); ?>