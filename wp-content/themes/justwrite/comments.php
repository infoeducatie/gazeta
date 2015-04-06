<?php
/* ------------------------------------------------------------------------- *
 *	Comemnts Template			
/* ------------------------------------------------------------------------- */

// Disable Comments Globally

$disable_comments = of_get_option( 'ac_disable_elements' );
if ( !$disable_comments['comments'] ) :

// -------------------------------------------------

// Password Required

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

	<h2 class="comments-title">
		<?php
			printf( 
				_n( '<span class="comments-number">One thought on</span> <span class="title">&ldquo;%2$s&rdquo;</span>', 
					'<span class="comments-number">%1$s thoughts on</span> <span class="title">&ldquo;%2$s&rdquo;</span>', 
					get_comments_number(), 'acosmin' ),
				number_format_i18n( get_comments_number() ), 
				get_the_title() 
			);
		?>
	</h2>

	<ol class="comment-list clearfix">
		<?php
			wp_list_comments( array(
				'type'			=> 'all',
				'style'			=> 'ol',
				'short_ping'	=> true,
				'avatar_size'	=> 34,
				'callback'		=> 'ac_comment_template'
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav class="comments-pagination clearfix" role="navigation">
    	<div class="paging-wrap">
			<?php previous_comments_link( __( '&larr; Older Comments', 'acosmin' ) ); ?>
			<?php next_comments_link( __( 'Newer Comments &rarr;', 'acosmin' ) ); ?>
		</div>
	</nav><!-- END .comments-pagination -->
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'acosmin' ); ?></p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>

</section><!-- END #comments -->

<?php endif; ?>