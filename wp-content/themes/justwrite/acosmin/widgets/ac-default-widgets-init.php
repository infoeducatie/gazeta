<?php
/* ------------------------------------------------------------------------- *
 *  This file will initialize only default widgets
 *	______________________________________________
 *
 *	Updates via Framework Update
/* ------------------------------------------------------------------------- */

// Social Buttons Widget
require_once get_template_directory() . '/acosmin/widgets/default-social-buttons-widget.php';

/*	================================================ */

// Registering Default Widgets
register_widget( 'AC_Social_Buttons_Widget' );
?>