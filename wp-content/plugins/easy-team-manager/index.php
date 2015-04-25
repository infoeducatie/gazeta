<?php
/*-------------------------------------------------------------------------

   Plugin Name: Easy Team Manager
   Description: Easy Team Manager helps you to create team members with their short descriptions, social profiles link with smooth hover effects. You can add and manage their image, social profile's links, short description along with their name and position in your company.  Embed in any post/page using short-code <code>[easy-team-manager team_name="Team Name"]</code>
   Version: 1.3.2
   Plugin URI: http://www.jwthemes.com
   Author: JW Themes
   Author URI: http://www.jwthemes.com
   License: Under GPL2

--------------------------------------------------------------------------*/
register_activation_hook(__FILE__, 'register_upon_activation_easy_team_manager' );
function register_upon_activation_easy_team_manager(){//create the uploads folder upon activation
	add_option( 'jwthemes', true );
		$upload_dir=wp_upload_dir();
	  $upload_dir =$upload_dir['basedir'].""."/easy_team_manager/";
  	if (!is_dir($upload_dir)) {
		mkdir($upload_dir, 0777, true);
  	}
	//creating table upon activation
  	global $wpdb;
  	$table_name = $wpdb->prefix . "easy_team_manager_description";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name){ 

  	$sql = "CREATE TABLE $table_name (
  	id int NOT NULL AUTO_INCREMENT,
  	name varchar(250),
  	image varchar(50),
	ind_description varchar(300),
	position varchar(40),
	url varchar(40),
	email varchar(240),
	phone varchar(240),
	social_media varchar(500),
	p_num int,
	team_id int,
  	PRIMARY KEY id (id)
    );";
	}
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   	dbDelta( $sql );
	 global $wpdb;
	$table_name = $wpdb->prefix . "easy_team_manager";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name){ 

  	$sql1 = "CREATE TABLE $table_name (
  	tid int NOT NULL AUTO_INCREMENT,
  	team_name varchar(90),
  	description text,
	background_image varchar(150),
	setting varchar(250),
  	PRIMARY KEY tid (tid)
    );";
	}	
   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql1 );  
}
//Hooked to upgrade_clear_destination
function delete_old_plugin($removed, $local_destination, $remote_destination, $plugin) {
    global $wp_filesystem;

    if ( is_wp_error($removed) )
        return $removed; //Pass errors through.

    $plugin = isset($plugin['plugin']) ? $plugin['plugin'] : '';
    if ( empty($plugin) )
        return new WP_Error('bad_request', $this->strings['bad_request']);

    $plugins_dir = $wp_filesystem->wp_plugins_dir();
    $this_plugin_dir = trailingslashit( dirname($plugins_dir . $plugin) );

    if ( ! $wp_filesystem->exists($this_plugin_dir) ) //If its already vanished.
        return $removed;

    // If plugin is in its own directory, recursively delete the directory.
    if ( strpos($plugin, '/') && $this_plugin_dir != $plugins_dir ) //base check on if plugin includes directory separator AND that its not the root plugin folder
        $deleted = $wp_filesystem->delete($this_plugin_dir, true);
    else
        $deleted = $wp_filesystem->delete($plugins_dir . $plugin);

    if ( ! $deleted )
        return new WP_Error('remove_old_failed', $this->strings['remove_old_failed']);

    return true;
}
//admin_menu_setup

add_action('admin_menu','easy_team_manager_management');
function easy_team_manager_management() {
	//this is the main item for the menu
	add_menu_page('Team Manager', //page title
	'Team Manager', //menu title
	'manage_options', //capabilities
	'easy_team_manager', //menu slug
	'easy_team_manager', //function
	plugin_dir_url( __FILE__ ) . 'images/easy-team-manager.png'
	);
	//this is a submenu
	add_submenu_page('null', //parent slug
	'Add New Image', //page title
	'Add New Image', //menu title
	'manage_options', //capability
	'easy_team_manager_desc_create', //menu slug
	'easy_team_manager_desc_create'); //function
	add_submenu_page('easy_team_manager',
	'Add Team',
	'Add Team',
	'manage_options',
	'easy_team_manager_create',
	'easy_team_manager_create'
	);
	add_submenu_page('Null',
	'Edit Team Detail',
	'Edit Team Detail',
	'manage_options',
	'easy_team_manager_edit',
	'easy_team_manager_edit'
	);
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Data', //page title
	'Update', //menu title
	'manage_options', //capability
	'easy_team_manager_desc_edit', //menu slug
	'easy_team_manager_desc_edit'); //function
	
	add_submenu_page(null, //parent slug
	'remove_easy_team_manager Data', //page title
	'remove_easy_team_manager', //menu title
	'manage_options', //capability
	'remove_easy_team_manager', //menu slug
	'remove_easy_team_manager');
	
	add_submenu_page(null, //page title
	'see description',
	'see description', //menu title
	'manage_options', //capabilities
	'easy_team_manager_desc_list', //menu slug
	'easy_team_manager_desc_list' //function
	);
}
//starshortcode
add_shortcode('easy-team-manager', 'easy_team_manager_shortcode');
function easy_team_manager_shortcode($atts){
	ob_start();
	global $wpdb;
	    $team_name= $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."easy_team_manager ");
		foreach($team_name as $get_result)	
if($get_result->team_name==$atts['team_name']){
$setting_list=unserialize($get_result->setting);?>
   
    <section class="suvanno">
    <section class="the_team" style=" <?php if($setting_list['img_set']!="unset"){ $upload_dir=wp_upload_dir();?> background:url(<?php echo $upload_dir["baseurl"]."/"."easy_team_manager/".$get_result->background_image;?>);<?php } else {?> background:<?php echo $setting_list['background_color'];?>;<?php }?>">
        <div>
            <div class="easy_team_member_top">
                <h1><?php echo $get_result->team_name;?></h1>	
                <p><?php echo $get_result->description;?></p>
            </div>
            <?php }?>
            <div class="clearfix"></div>            
                <?php global $wpdb;
            $rw = $wpdb->get_results("SELECT * from ".$wpdb->prefix."easy_team_manager_description INNER JOIN ".$wpdb->prefix."easy_team_manager where ".$wpdb->prefix."easy_team_manager.tid = "."".$wpdb->prefix."easy_team_manager_description.team_id"." AND ".$wpdb->prefix."easy_team_manager.team_name='".$atts['team_name']."' ORDER BY p_num ASC");
            foreach ($rw as $row ){ $social_media=unserialize($row->social_media); $team_manager_color=unserialize($row->setting);$ind_name_detail=unserialize($row->name);$ind_email_detail=unserialize($row->email);$ind_phone_detail=unserialize($row->phone);
            if($ind_email_detail['sh']=='s_email' && $ind_phone_detail['sh']=='s_phone' ){?>
			<style>	
			.team_member_wrap{ height:340px !important;}
			.team_profile_desc{ height:300px !important;}
			</style>
            
            <?php }?>
                                        
            <div class="team_member_wrap">
                <div class="team_profile_wrap" style=" <?php if($ind_email_detail['sh']=='s_email' && $ind_phone_detail['sh']=='s_phone' ){?>height:355px !important; <?php } else if( $ind_email_detail['sh']=='h_email' && $ind_phone_detail['sh']=='s_phone'){?> height:285px !important;<?php }else if( $ind_email_detail['sh']=='s_email' && $ind_phone_detail['sh']=='h_phone'){?> height:280px !important;<?php }?>  border-color:<?php echo $team_manager_color['theme_color'] ;?>;">
                
                   <div class="team_profile_pic" style=" <?php if($row->image!=is_numeric($row->image)){ $upload_dir=wp_upload_dir();?> background:url(<?php echo $upload_dir["baseurl"]."/"."easy_team_manager/".$row->image;?>) no-repeat center center transparent;
    <?php } else {?> background:url(<?php echo plugins_url('images/blank_pic.png',__FILE__);?>) no-repeat center center transparent;><?php }?>">
                        <div class="team_profile_desc" style="background:<?php echo $team_manager_color['img_hv_color']; ?>;">
                        
                            <p><?php echo stripcslashes($row->ind_description); ?></p>
                        </div>
                    </div>
                        
                    <div class="team_profile_ttl" style=" <?php if($ind_email_detail['sh']=='s_email' && $ind_phone_detail['sh']=='s_phone' ){?>height:240px !important; <?php } else if( $ind_email_detail['sh']=='h_email' && $ind_phone_detail['sh']=='s_phone'){?> height:200px !important;<?php } else if( $ind_email_detail['sh']=='s_email' && $ind_phone_detail['sh']=='h_phone'){?> height:200px !important;<?php }?>">
                    
                  <h3 style="color:<?php echo $team_manager_color['theme_color'] ;?> !important"><?php if($ind_name_detail['sh']=="sh_show"){echo $ind_name_detail['name'];
}?></h3>
                        <h4><?php echo $row->position;?></h4>
                       <div><?php if(isset($ind_email_detail['email']) AND $ind_email_detail['sh']=='s_email')echo esc_attr($ind_email_detail['email']);?>
                       </div>					            			
                        <div><?php if(isset($ind_phone_detail['phone']) AND $ind_phone_detail['sh']=='s_phone')echo esc_attr($ind_phone_detail['phone']);?></div>
                        <style>
                            .team_social_links li:hover a{color:<?php echo $team_manager_color['theme_color'] ;?> !important;}
                        </style>
                        <div class="team_social_links">
                            <ul>   
                                <?php if(isset($social_media['ind_facebook_link']) AND $social_media['ind_facebook_link']!=''){?>
                                <li><a target="_blank" href="http://www.facebook.com/<?php echo $social_media['ind_facebook_link'];?>"> 
                                <i class="fa fa-facebook"></i></a></li><?php }?>
                                <?php if(isset($social_media['ind_twitter_link']) AND $social_media['ind_twitter_link']!=''){?>
                                <li><a target="_blank" href="http://www.twitter.com/<?php echo $social_media['ind_twitter_link'];?>"> 
                                <i class="fa fa-twitter"></i></a></li><?php }?>
                                
                                 <?php if(isset($social_media['ind_skype_link']) AND $social_media['ind_skype_link']!=''){?>

                                <li><a target="_blank" href="http://www.skype.com/<?php echo $social_media['ind_skype_link'];?>"> 
                                <i class="fa fa-skype"></i></a></li><?php }?>
                                <?php if(isset($social_media['ind_google_link']) AND $social_media['ind_google_link']!=''){?>
                                <li><a target="_blank" href="http://www.googleplus.com/<?php echo $social_media['ind_google_link'];?>"> 
                                <i class="fa fa-google"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['linkdin']) AND $social_media['linkdin']!=''){?>
                                
                                <li><a target="_blank" href="http://www.linkedin.com/<?php echo $social_media['linkdin'];?>"> 
                                <i class="fa fa-linkedin"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['instagram']) AND $social_media['instagram']!=''){?>
                                 <li><a target="_blank" href="http://www.instagram.com/<?php echo $social_media['instagram'];?>"> 
                                <i class="fa fa-instagram"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['youtube']) AND $social_media['youtube']!=''){?>
                                 <li><a target="_blank" href="http://www.youtube.com/<?php echo $social_media['youtube'];?>"> 
                                <i class="fa fa-youtube"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['vimeo']) AND $social_media['vimeo']!=''){?>
                                <li><a target="_blank" href="http://www.vimeo.com/<?php echo $social_media['vimeo'];?>"> 
                                <i class="fa fa-vimeo-square"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['stumbleupon']) AND $social_media['stumbleupon']!=''){?>
                                <li><a target="_blank" href="http://www.stumbleupon.com/<?php echo $social_media['stumbleupon'];?>"> 
                                <i class="fa fa-stumbleupon"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['timblr']) AND $social_media['timblr']!=''){?>
                                <li><a target="_blank" href="http://www.tumblr.com/<?php echo $social_media['timblr'];?>"> 
                                <i class="fa fa-tumblr"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['digg']) AND $social_media['digg']!=''){?>
                                <li><a target="_blank" href="http://www.digg.com/<?php echo $social_media['digg'];?>"> 
                                <i class="fa fa-digg"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['behance']) AND $social_media['behance']!=''){?>
                                <li><a target="_blank" href="http://www.behance.com/<?php echo $social_media['behance'];?>"> 
                                <i class="fa fa-behance"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['foursquare']) AND $social_media['foursquare']!=''){?>
                                <li><a target="_blank" href="http://www.foursquare.com/<?php echo $social_media['foursquare'];?>"> 
                                <i class="fa fa-foursquare"></i></a></li><?php }?>
                                
                                <?php if(isset($social_media['delicious']) AND $social_media['delicious']!=''){?>
                                <li><a href="http://www.delicious.com/<?php echo $social_media['delicious'];?>"> 
                                <i class="fa fa-delicious"></i></a></li><?php }?>
                                <?php if(isset($social_media['reddit']) AND $social_media['reddit']!=''){?>
                                <li><a target="_blank" href="http://www.reddit.com/<?php echo $social_media['reddit'];?>"> 
                                <i class="fa fa-reddit"></i></a></li><?php }?>
                                <?php if(isset($social_media['wordpress']) AND $social_media['wordpress']!=''){?>
                                <li><a target="_blank" href="http://www.wordpress.com/<?php echo $social_media['wordpress'];?>"> 
                                <i class="fa fa-wordpress"></i></a></li><?php }?>
                            </ul>  
                        </div>
                        <!--view_detail-->
                        <div>
                        <a href="<?php if(isset($row->url) && $row->url!=='') echo esc_url($row->url); ?>" target="_blank">view Detail</a>
                        </div>
                        <!--view_detail-->
                    </div>                            
                </div>
            </div><?php }?>
            <div style="clear:both"></div>
        </div>
    </section>
                   
	</section>                    	
	<?php return ob_get_clean();}
//endshortcode
require_once(plugin_dir_path(__FILE__) . 'inc/easy_team_manager_create.php');
require_once(plugin_dir_path(__FILE__) . 'inc/easy_team_manager.php');
require_once(plugin_dir_path(__FILE__) . 'inc/easy_team_manager_desc_list.php');
require_once(plugin_dir_path(__FILE__) . 'inc/easy_team_manager_desc_create.php');
require_once(plugin_dir_path(__FILE__) . 'inc/easy_team_manager_desc_edit.php');
require_once(plugin_dir_path(__FILE__) . 'inc/remove_easy_team_manager.php');
require_once(plugin_dir_path(__FILE__) . 'inc/easy_team_manager_edit.php');

//function for javascript css and jquery 
function team_enqueue_scripts_admin(){ 
	wp_register_script( 'iColorPicker', plugins_url( 'js/iColorPicker.js',__FILE__), array( 'jquery' ) );
  	if (is_admin()): 
	wp_enqueue_script('iColorPicker');
  	endif; //is_admin 
}
add_action( 'wp_print_scripts', 'team_enqueue_scripts_admin' );
add_action( 'wp_print_scripts', 'team_plugin_styles' );
function team_plugin_styles() {
	wp_register_style( 'style', plugins_url( 'css/style.css',__FILE__ ) );
	if (!is_admin()): 
    wp_enqueue_style( 'style' );
	endif;//!is_admin
	
	wp_register_style( 'font-awesome.min', plugins_url( 'css/font-awesome.min.css',__FILE__ ) );
	wp_enqueue_style( 'font-awesome.min' );

	wp_register_style( 'style-admin', plugins_url( 'css/style-admin.css',__FILE__ ) );
	if (is_admin()): 
	wp_enqueue_style( 'style-admin' );
  	endif; //is_admin
}?>