<?php
/* ------------------------------------------------------------------------- *
 *  This file will initialize only custom widgets
/* ------------------------------------------------------------------------- */

// Tabs Widget
require_once get_template_directory() . '/acosmin/widgets/custom-tabs-widget.php';

// Popular Posts Widget
require_once get_template_directory() . '/acosmin/widgets/custom-popular-posts-widget.php';

// Recent Posts Widget
require_once get_template_directory() . '/acosmin/widgets/custom-recent-posts-widget.php';

// Featured Posts Widget
require_once get_template_directory() . '/acosmin/widgets/custom-featured-posts-widget.php';

/*	================================================ */

// Registering Custom Widgets
register_widget( 'AC_Tabs_Widget' );
register_widget( 'AC_Popular_Posts_Widget' );
register_widget( 'AC_Recent_Posts_Widget' );
register_widget( 'AC_Featured_Posts_Widget' );
?>