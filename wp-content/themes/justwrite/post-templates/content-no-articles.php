<?php
/* ------------------------------------------------------------------------- *
 *  The template used in case no posts were found.
/* ------------------------------------------------------------------------- */
?>

<article class="post-template-1 nothing-found clearfix">
	<header class="not-found-header">
    <?php if( is_search() ) { ?>
		<h2><?php _e( 'It looks like nothing was found.', 'acosmin' ); ?><br /><a href="#" class="try-a-search"><?php ac_icon( 'search' ). ' ' . _e( 'Maybe try another search?', 'acosmin' ) ?></a></h2>
    <?php } else { ?>
    	<h2><?php _e( 'No posts found. Maybe add some! :)', 'acosmin' ); ?></h2>
    <?php } ?>
    </header>
</article><!-- END .post-template-1, .nothing-found -->