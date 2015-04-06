<?php
/* ------------------------------------------------------------------------- *
 *	Sidebar template				
/* ------------------------------------------------------------------------- */
?>

<section class="sidebar clearfix">
	<?php if ( is_active_sidebar( 'main-sidebar' ) ) { dynamic_sidebar( 'main-sidebar' ); } 
		else { echo '<p class="add-some-widgets">' . __( 'Add some widgets! (Main Sidebar)', 'acosmin' ) . '</p>'; } ?><!-- END Sidebar Widgets -->
</section><!-- END .sidebar -->