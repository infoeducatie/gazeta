<?php 
/* ------------------------------------------------------------------------- *
 *	Normal page template					
/* ------------------------------------------------------------------------- */

get_header(); ?>

<section class="container<?php ac_mini_disabled() ?> clearfix">

	<?php get_template_part( 'page-templates/template', 'page' ); ?>
    
</section><!-- END .container -->

<?php get_footer(); ?>