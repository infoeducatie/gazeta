<?php
/* ------------------------------------------------------------------------- *
 *	Header template					
/* ------------------------------------------------------------------------- */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	// After the <body> tag starts hook 
	ac_after_body(); 
?>

<header id="main-header" class="header-wrap">

<div class="wrap">

	<div class="top<?php ac_mini_disabled(); ac_logo_class(); ?> clearfix">
    
    	<div class="logo<?php ac_logo_class(); ?>">
        	<a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-contents<?php ac_logo_class(); ?>"><?php ac_get_logo(); ?></a>
            <?php
				// Ads variables - Options Panel
				$ad728_show = of_get_option( 'ac_ad728_show' );
				$ad728_code =  of_get_option( 'ac_ad728_code' );
				
				if ( $ad728_show == '' ) :
			?>
            <h1 class="description"><?php bloginfo( 'description' ); ?></h1>
            <?php endif; ?>
        </div><!-- END .logo -->
        
        <?php 
		if ( $ad728_show && $ad728_code != '' ) : ?>
        <div class="advertising728">
        	<?php if ( $ad728_code != '' ) { echo $ad728_code; } ?>
        </div><!-- END .advertising728 -->
        <?php endif; ?>
        
    </div><!-- END .top -->
    
    <nav class="menu-wrap<?php ac_mini_disabled(); if ( get_theme_mod( 'ac_disable_stickymenu' ) ) { echo ' sticky-disabled'; } ?>" role="navigation">
		<?php 
			if( has_nav_menu( 'main' ) ) {
				wp_nav_menu( array( 'container' => '', 'theme_location' => 'main', 'items_wrap' => '<ul class="menu-main mobile-menu superfish">%3$s</ul>' ) );
			} else {
				echo '<ul class="menu-main mobile-menu superfish"><li class="current_page_item"><a>' . __( 'Add a menu', 'acosmin' )  . '</a></li></ul>';
			}
		?>
        
        <a href="#" class="mobile-menu-button"><?php ac_icon( 'bars' ) ?></a>
        <?php if ( !get_theme_mod( 'ac_disable_minisidebar' ) ) { ?>
        <a href="#" class="browse-more" id="browse-more"><?php echo ac_icon('caret-down', false) . __( 'Browse', 'acosmin' ) ?></a>
        <?php } ?>
        <a href="#" class="search-button"><?php ac_icon( 'search' ) ?></a>
        
        <ul class="header-social-icons clearfix">
			<?php
				// Social variables - Options Panel
				$header_fb 	= of_get_option( 'ac_facebook_url' );
				$header_tw 	= of_get_option( 'ac_twitter_username' );
				$header_gp 	= of_get_option( 'ac_gplus_url' );
				$header_rss = of_get_option( 'ac_custom_rss_url' );
				
			?>
			<?php if ( $header_tw != '' ) { ?><li><a href="https://twitter.com/<?php echo esc_html( $header_tw ); ?>" class="social-btn left twitter"><?php ac_icon('twitter'); ?></a></li><?php } ?>
			<?php if ( $header_fb != '' ) { ?><li><a href="<?php echo esc_url( $header_fb ); ?>" class="social-btn right facebook"><?php ac_icon('facebook'); ?></a></li><?php } ?>
			<?php if ( $header_gp != '' ) { ?><li><a href="<?php echo esc_url( $header_gp ); ?>" class="social-btn left google-plus"><?php ac_icon('google-plus'); ?></a></li><?php } ?>
			<li><a href="<?php if( $header_rss != '' ) { echo esc_url( $header_rss ); } else { bloginfo( 'rss2_url' ); } ?>" class="social-btn right rss"><?php ac_icon('rss'); ?></a></li>
        </ul><!-- END .header-social-icons -->
        
        <div class="search-wrap nobs">
        	<form role="search" id="header-search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            	<input type="submit" class="search-submit" value="<?php _e( 'Search', 'acosmin' ); ?>" />
            	<div class="field-wrap">
					<input type="search" class="search-field" placeholder="<?php _e( 'introdu cuvinte cheie ...', 'acosmin' ); ?>" value="<?php get_search_query(); ?>" name="s" title="<?php _e( 'Căutare:', 'acosmin' ); ?>" />
				</div>
			</form>
        </div><!-- END .search-wrap -->
        
    </nav><!-- END .menu-wrap -->
    
</div><!-- END .wrap -->

</header><!-- END .header-wrap -->

<?php
	// After the main <header> tag
	ac_after_header(); 
?>

<div class="wrap<?php ac_mini_disabled() ?>" id="content-wrap">

<?php
	// Bellow .wrap class
	ac_bellow_wrap_class(); 
?>
