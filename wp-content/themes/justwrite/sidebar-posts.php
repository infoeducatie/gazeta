<?php
/* ------------------------------------------------------------------------- *
 *	This sidebar appears only in single view (posts)				
/* ------------------------------------------------------------------------- */
?>

<section class="sidebar posts-sidebar clearfix">
	<?php if ( is_active_sidebar( 'posts-sidebar' ) ) { dynamic_sidebar( 'posts-sidebar' ); } 
		else { echo '<p class="add-some-widgets">' . __( 'Add some widgets! (Posts Sidebar)', 'acosmin' ) . '</p>'; } ?><!-- END Sidebar Widgets -->
</section><!-- END .sidebar -->