<?php
/* ------------------------------------------------------------------------- *
 *  The template used for displaying posts in the Aside post format
/* ------------------------------------------------------------------------- */

// Custom Post Classes
$classes = array(
    'single-template-1',
    'clearfix',
);

// Meta/Options
$show_thumbnail = get_post_meta( get_the_ID(), 'ac_show_post_thumbnail', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="post-content">
    	<?php the_title( '<h2 class="title">', '</h2>' ); ?>
        <header class="details clearfix">
        	<time class="detail left index-post-date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time>
			<span class="detail left index-post-author"><em><?php _e( 'by', 'acosmin' ); ?></em> <?php the_author_posts_link(); ?></span>
			<span class="detail left index-post-category"><em><?php _e( 'in', 'acosmin' ); ?></em> <?php ac_output_first_category(); ?></span>
        <?php if ( !$show_thumbnail ) : ?>
            <a href="<?php echo esc_url( get_post_format_link( 'aside' ) ); ?>" title="<?php _e( 'Aside Archive', 'acosmin' ); ?>" class="post-format-icon"><?php ac_icon( 'coffee' ); ?></a>
            <?php else : endif; ?>
        </header><!-- END .details -->
        <?php if( $show_thumbnail && ac_check_paged() ) { ?>
        <figure class="featured-image-wrap">
        	<?php
			if ( has_post_thumbnail() && $paged == false ) : 
				the_post_thumbnail( 'ac-sidebar-featured' );
			else :
				echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'acosmin' ) . '" />';
			endif;
			?>
        </figure>
        <?php } ?>
		<div class="single-content<?php if( $show_thumbnail) { echo ' featured-image'; } ?>">
			<?php 
				the_content();
				
				the_tags('<div class="post-tags-wrap clearfix"><strong>' . __( 'Tagged with:', 'acosmin' ) . '</strong> <span>','</span>, <span>','</span></div>');
				
				wp_link_pages( array(
				'before'      => '<footer class="page-links-wrap"><div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'acosmin' ) . '</span>',
				'after'       => '</div></footer>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			?>
		</div><!-- END .single-content -->
	</div><!-- END .post-content -->
</article><!-- END #post-<?php the_ID(); ?> .post-template-1 -->
