<?php
/* ------------------------------------------------------------------------- *
 *  Normal page template
/* ------------------------------------------------------------------------- */

// Custom Post Classes
$classes = array(
    'single-template-1',
	'page-template-normal',
    'clearfix'
);
?>

<?php get_sidebar( 'browse' ); ?>
    
<div class="wrap-template-1 clearfix">
    
    <section class="content-wrap clearfix" role="main">
    	
        <section class="posts-wrap single-style-template-1 clearfix">
        
		<?php
			while ( have_posts() ) : the_post();
		?>	
        
        	<article id="page-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
            	<div class="post-content">
            	
                	<?php the_title( '<h2 class="title">', '</h2>' ); ?>
                    
                    <div class="single-content">
                    	<?php the_content(); ?>
                    </div><!-- END .single-content -->
                
            	</div>
            </article>
        	
		<?php endwhile;	?>
		
        </section><!-- END .posts-wrap -->
        
        <?php comments_template(); ?>
        
 	</section><!-- END .content-wrap -->
    
    <?php get_sidebar(); ?>
    
</div><!-- END .wrap-template-1 -->