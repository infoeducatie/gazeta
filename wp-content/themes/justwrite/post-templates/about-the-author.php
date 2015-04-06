<?php
/* ------------------------------------------------------------------------- *
 *  About the author - Single vie (Post)
/* ------------------------------------------------------------------------- */

// Variables
$author_id			= get_the_author_meta( 'ID' );
$display_name		= get_the_author_meta( 'display_name', $author_id );
$user_url			= get_the_author_meta( 'user_url', $author_id );
?>

<aside class="about-the-author clearfix">
	<h2 class="title"><span class="about-inner"><?php _e('About the author','acosmin'); ?></span> <span class="author"><?php echo $display_name; ?></span></h2>
	<div class="ata-wrap clearfix">
		<figure class="avatar-wrap">
			<?php echo get_avatar( $author_id, 58 ); ?>
			<?php if( $user_url ) { ?>
			<figcaption class="links">
				<a href="<?php echo $user_url; ?>" class="author-link" title="<?php _e("Author's Link", 'acosmin'); ?>"><?php ac_icon('link');?></a>
			</figcaption>
			<?php } ?>
		</figure>
		<div class="info">
			<?php echo get_the_author_meta( 'description', $author_id ); ?>
		</div>
	</div>
                    
	<div class="clear-border"></div>
</aside><!-- END .about-the-author -->