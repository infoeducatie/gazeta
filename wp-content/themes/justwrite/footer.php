<?php
/* ------------------------------------------------------------------------- *
 *	Footer template					
/* ------------------------------------------------------------------------- */

//  Variables
$disable_stuff 		= of_get_option( 'ac_disable_elements' );
$disable_credit		= $disable_stuff['credit'];
$credit_link 		= 'http://www.acosmin.com/';
$the_wp_link		= 'http://wordpress.org/';
$copyright_text 	= get_theme_mod( 'ac_footer_copyright_text', 'Copyright 2013 JUSTWRITE. All rights reserved.' );
$logo_text			= get_theme_mod( 'ac_footer_logo_text', 'JustWrite' );
?>
		<?php 
			// Before the main <header> tag
			ac_before_footer();
		?>
		<footer id="main-footer" class="footer-wrap<?php ac_mini_disabled() ?> clearfix">
    		<aside class="footer-credits">
        		<a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'title' ); ?>" rel="nofollow" class="blog-title"><?php echo esc_html( $logo_text ); ?></a>
            	<strong class="copyright"><?php echo esc_html( $copyright_text ); ?></strong>
                <?php 
				if ( !$disable_credit ) : ?>
                <span class="theme-author">
                    <?php footer_text(); ?>
                    <a href="<?php echo $the_wp_link; ?>">Proudly powered by WordPress</a> &mdash;
                    <em>Theme: JustWrite by</em>
                    <a href="<?php echo $credit_link; ?>" title="Acosmin">Acosmin</a>
				</span>
                <?php endif; ?>
        	</aside><!-- END .footer-credits -->
			<a href="#" class="back-to-top"><?php ac_icon( 'angle-up' ); ?></a>
		</footer><!-- END .footer-wrap -->
    
    </div><!-- END .wrap -->
    
    <?php 
		// Before the <body> tag closes hook 
		ac_before_body_closed();
		
		// WP Footer
		wp_footer();
	?>
    
</body>
</html>