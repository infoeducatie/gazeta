<?php
/* ------------------------------------------------------------------------- *
 *	Mini sidebar template
 *	_____________________
 *
 *	This is the sidebar located on the left side. If you want to disable it
 *	don't delete it. Go in: 
 *	WordPress Customise Panel -> "Mini-Sidebar" Tab
 *	and click on "Disable Mini-Sidebar".
 *	_____________________
 *
 *	Notes: 
 *	This sidebar appears only when your screen resolution is above 1600px;
 *	If your screen resolution is lower a "Browse more" buttuon will be
 *	displayed in the menu bar.				
/* ------------------------------------------------------------------------- */
?>

<?php if ( !get_theme_mod( 'ac_disable_minisidebar' ) ) { // Disable or Enable Mini-Sidebar ?>
<section class="mini-sidebar">
	<header class="browse-by-wrap clearfix">
    	<h2 class="browse-by-title"><?php _e( 'Browse By', 'acosmin' ); ?></h2>
        <a href="#" class="close-browse-by"><i class="fa fa-times"></i></a>
    </header><!-- END .browse-by -->
    
    <?php if( has_nav_menu( 'mini-first' ) ) { ?>
	<aside class="side-box">
		<h3 class="sidebar-heading" id="mini-first-title"><?php echo esc_html( get_theme_mod( 'ac_mini_first_title' ) ); ?></h3>
		<nav class="sb-content clearfix">
        	<?php
				// First Menu
				if(is_home()) { $page_state = 'current_page_item'; } else { $page_state = ''; }
				wp_nav_menu( array( 'container' => '', 'theme_location' => 'mini-first', 'items_wrap' => '<ul class="normal-list"><li class="'. $page_state .'"><a href="'. esc_url( home_url() ) .'" title="'. __('Go Home', 'acosmin') .'">'. __('Main Page', 'acosmin') .'</a></li>%3$s</ul>' ) );
			?>
		</nav><!-- END .sb-content -->
	</aside><!-- END .sidebox -->
    <?php } else { ?>	
		<aside class="side-box">
        	<h3 class="sidebar-heading"><?php esc_html_e( 'Add a menu', 'acosmin' ); ?></h3>
        	<nav class="sb-content clearfix">
            	<ul class="normal-list"><li class="current_page_item"><a href="#"><?php _e( 'Right Sidebar - First Menu', 'acosmin' ); ?></a></li></ul>
            </nav>
        </aside>
    <?php } ?>
    
     <?php if( has_nav_menu( 'mini-second' ) ) { ?>
    <aside class="side-box">
		<h3 class="sidebar-heading" id="mini-second-title"><?php echo esc_html( get_theme_mod( 'ac_mini_second_title', 'Add a menu') ); ?></h3>
		<nav class="sb-content clearfix">
			<?php
				// Second Menu
				wp_nav_menu( array( 'container' => '', 'theme_location' => 'mini-second', 'items_wrap' => '<ul class="normal-list">%3$s</ul>' ) ); 
			?>
		</nav><!-- END .sb-content -->
	</aside><!-- END .sidebox -->
    <?php } else { ?>	
		<aside class="side-box">
        	<h3 class="sidebar-heading"><?php esc_html_e( 'Add a menu', 'acosmin' ); ?></h3>
        	<nav class="sb-content clearfix">
            	<ul class="normal-list"><li class="current_page_item"><a href="#"><?php _e( 'Right Sidebar - Second Menu', 'acosmin' ); ?></a></li></ul>
            </nav>
        </aside>
    <?php } ?>
        
	<aside class="side-box">
		<h3 class="sidebar-heading"><?php _e( 'Archives', 'acosmin' ); ?></h3>
		<nav class="sb-content clearfix">
			<ul class="normal-list">
				<?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12 ) ); ?>
			</ul>
		</nav><!-- END .sb-content -->
	</aside><!-- END .sidebox -->
    
    <div class="side-box larger">
    		<h3 class="sidebar-heading"><?php _e( 'Calendar', 'acosmin' ); ?></h3>
            <div class="sb-content clearfix">
            	<?php get_calendar(true); ?>
		</div><!-- END .sb-content -->
	</div><!-- END .sidebox -->
    
    <div class="wrap-over-1600">
    	<!-- 
        	 If you want to add something in this sidebar please place your code bellow. 
        	 It will show up only when your screen resolution is above 1600 pixels.	
		-->
		
        <?php 
		$ad160_show 	= of_get_option( 'ac_ad160_show' );
		$ad160_code 	= of_get_option( 'ac_ad160_code' );
		$ad160_title 	= of_get_option( 'ac_ad160_title' );
		$ad160_url 		= of_get_option( 'ac_ad160_url' );
		if ( $ad160_show && $ad160_code != '' ) : ?>
        <div class="banner-160-wrap">
        	<div class="ad160">
            	<?php 
					if ( $ad160_title != '' ) {
						echo '<h5 class="banner-small-title"><a href="' . esc_url( $ad160_url ) . '">' . esc_html( $ad160_title ) . '</a></h5>';	
					}
					if ( $ad160_code != '' ) { 
						echo $ad160_code; 
					} 
				?>
            </div>
        </div>
        <?php endif; ?>
        
    </div><!-- END .wrap-over-1600 -->
</section><!-- END .mini-sidebar -->

<div class="mini-sidebar-bg"></div>
<?php } ?>