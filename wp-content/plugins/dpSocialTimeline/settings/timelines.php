<?php 
// This function displays the admin page content
function dpSocialTimeline_timelines_page() {
	global $dpSocialTimeline, $wpdb, $table_prefix;
	$table_name = $table_prefix.DP_SOCIALTIMELINE_TABLE;

	if ($_POST['submit']) {
		
	   foreach($_POST as $key=>$value) { $$key = $value; }
	   
	   if($active != 1) { $active = 0; }
	   if($addColorbox != 1) { $addColorbox = 0; }
	   if($showSocialIcons != 1) { $showSocialIcons = 0; }
	   if($cache != 1) { $cache = 0; }
	   if($allowMultipleFilters != 1) { $allowMultipleFilters = 0; }
	   if($showFilter != 1) { $showFilter = 0; }
	   if($showLayout != 1) { $showLayout = 0; }
	   if($showTime != 1) { $showTime = 0; }
	   if($share != 1) { $share = 0; }
	   if($rtl != 1) { $rtl = 0; }
	   if(!is_numeric($total)) { $total = 10; }
	   
	   if (is_numeric($_POST['timeline_id']) && $_POST['timeline_id'] > 0) {
	   
	   	   $sql = "UPDATE $table_name SET ";
		   $sql .= "title = '$title', ";
		   $sql .= "layoutMode = '$layoutMode', ";
		   $sql .= "addColorbox = $addColorbox, ";
		   $sql .= "showSocialIcons = $showSocialIcons, ";
		   $sql .= "cache = $cache, ";
		   $sql .= "cacheTime = '$cacheTime', ";
		   $sql .= "allowMultipleFilters = $allowMultipleFilters, ";
		   $sql .= "showFilter = $showFilter, ";
		   $sql .= "showLayout = $showLayout, ";
		   $sql .= "showTime = $showTime, ";
		   $sql .= "share = $share, ";
		   $sql .= "rtl = $rtl, ";
		   $sql .= "itemWidth = '$itemWidth', ";
		   $sql .= "timelineItemWidth = '$timelineItemWidth', ";
		   $sql .= "columnsItemWidth = '$columnsItemWidth', ";
		   $sql .= "oneColumnItemWidth = '$oneColumnItemWidth', ";
		   $sql .= "skin = '$skin', ";
		   $sql .= "total = $total, ";
		   $sql .= "width = '$width', ";
		   $sql .= "width_unity = '$width_unity', ";
		   $sql .= "lang_week = '$lang_week', ";
		   $sql .= "lang_weeks = '$lang_weeks', ";
		   $sql .= "lang_day = '$lang_day', ";
		   $sql .= "lang_days = '$lang_days', ";
		   $sql .= "lang_hour = '$lang_hour', ";
		   $sql .= "lang_hours = '$lang_hours', ";
		   $sql .= "lang_minute = '$lang_minute', ";
		   $sql .= "lang_minutes = '$lang_minutes', ";
		   $sql .= "lang_about = '$lang_about', ";
		   $sql .= "lang_ago = '$lang_ago', ";
		   $sql .= "lang_less = '$lang_less', ";
		   $sql .= "active = $active ";
		   $sql .= "WHERE id = $timeline_id ";
		   $result = $wpdb->query($sql);
		   
		   
	   } else {
		   
		   $sql = "INSERT INTO $table_name (";
		   $sql .= "items, ";
		   $sql .= "custom, ";
		   $sql .= "title, ";
		   $sql .= "layoutMode, ";
		   $sql .= "addColorbox, ";
		   $sql .= "showSocialIcons, ";
		   $sql .= "cache, ";
		   $sql .= "cacheTime, ";
		   $sql .= "allowMultipleFilters, ";
		   $sql .= "showFilter, ";
		   $sql .= "showLayout, ";
		   $sql .= "showTime, ";
		   $sql .= "share, ";
		   $sql .= "rtl, ";
		   $sql .= "itemWidth, ";
		   $sql .= "timelineItemWidth, ";
		   $sql .= "columnsItemWidth, ";
		   $sql .= "oneColumnItemWidth, ";
		   $sql .= "skin, ";
		   $sql .= "total, ";
		   $sql .= "width, ";
		   $sql .= "width_unity, ";
		   $sql .= "lang_week, ";
		   $sql .= "lang_weeks, ";
		   $sql .= "lang_day, ";
		   $sql .= "lang_days, ";
		   $sql .= "lang_hour, ";
		   $sql .= "lang_hours, ";
		   $sql .= "lang_minute, ";
		   $sql .= "lang_minutes, ";
		   $sql .= "lang_about, ";
		   $sql .= "lang_ago, ";
		   $sql .= "lang_less, ";
		   $sql .= "active ";
		   $sql .= ") VALUES ( ";
		   $sql .= "'', ";
		   $sql .= "'', ";
		   $sql .= "'$title', ";
		   $sql .= "'$layoutMode', ";
		   $sql .= "$addColorbox, ";
		   $sql .= "$showSocialIcons, ";
		   $sql .= "$cache, ";
		   $sql .= "'$cacheTime', ";
		   $sql .= "$allowMultipleFilters, ";
		   $sql .= "$showFilter, ";
		   $sql .= "$showLayout, ";
		   $sql .= "$showTime, ";
		   $sql .= "$share, ";
		   $sql .= "$rtl, ";
		   $sql .= "'$itemWidth', ";
		   $sql .= "'$timelineItemWidth', ";
		   $sql .= "'$columnsItemWidth', ";
		   $sql .= "'$oneColumnItemWidth', ";
		   $sql .= "'$skin', ";
		   $sql .= "$total, ";
		   $sql .= "'$width', ";
		   $sql .= "'$width_unity', ";
		   $sql .= "'$lang_week', ";
		   $sql .= "'$lang_weeks', ";
		   $sql .= "'$lang_day', ";
		   $sql .= "'$lang_days', ";
		   $sql .= "'$lang_hour', ";
		   $sql .= "'$lang_hours', ";
		   $sql .= "'$lang_minute', ";
		   $sql .= "'$lang_minutes', ";
		   $sql .= "'$lang_about', ";
		   $sql .= "'$lang_ago', ";
		   $sql .= "'$lang_less', ";
		   $sql .= "$active ";
		   $sql .= ");";
		   $result = $wpdb->query($sql);
		   $timeline_id = $wpdb->insert_id;
	   }
	   
	   
	   if(is_array($custom)) {
		   $custom_arr = array();
	
		   for($i = 0; $i < count($custom) - 1; $i++) {
			   $custom_arr[$i]['title'] = $custom_title[($i + 1)];
			   $custom_arr[$i]['name'] = $custom_name[($i + 1)];
			   $custom_arr[$i]['url'] = $custom_url[($i + 1)];
			   $custom_arr[$i]['icon'] = $custom_icon[($i + 1)];
			   $custom_arr[$i]['limit'] = $custom_limit[($i + 1)];
		   }
		   $custom_feed = json_encode($custom_arr);
		   
		   $sql = "UPDATE $table_name SET custom = '".$custom_feed."' WHERE id = $timeline_id;";
		   $wpdb->query($sql);
	   }
	   
	   if(is_array($social)) {
		   $social_arr = array();
	
		   for($i = 0; $i < count($social) - 1; $i++) {
			   $social_arr[$i]['title'] = $social_title[($i + 1)];
			   $social_arr[$i]['name'] = $social_name[($i + 1)];
			   $social_arr[$i]['data'] = $social_data[($i + 1)];
			   $social_arr[$i]['limit'] = $social_limit[($i + 1)];
			   $social_arr[$i]['include_retweets'] = $social_include_retweets[($i + 1)];
		   }
		   $social_feed = json_encode($social_arr);
		   $sql = "UPDATE $table_name SET items = '".$social_feed."' WHERE id = $timeline_id;";
		   $wpdb->query($sql);
	   }
	   
	   wp_redirect( admin_url('admin.php?page=dpSocialTimeline-admin&settings-updated=1') );
	   exit;
	}
	
	if ($_GET['delete_timeline']) {
	   $timeline_id = $_GET['delete_timeline'];
	   
	   $sql = "DELETE FROM $table_name WHERE id = $timeline_id;";
	   $result = $wpdb->query($sql);
	   	   
	   wp_redirect( admin_url('admin.php?page=dpSocialTimeline-admin&settings-updated=1') );
	   exit;
	}
	
	
	require_once (dirname (__FILE__) . '/../classes/base.class.php');
	if(!isset($title)) { $title = ""; }
	
	?>
	<script type="text/javascript">
        // <![CDATA[
            function changeSocialFeed(inp) {
                var title_desc = 'Username';
				
				jQuery(inp).closest('.slidebox').find('.include_retweets').hide();
				
                switch(jQuery(inp).val()) {
					case 'delicious':
					case '500px':
					case 'tumblr':
					case 'youtube':
					case 'dribbble':
					case 'digg':
					case 'pinterest':
					case 'vimeo':
					case 'soundcloud':
					case 'lastfm_tracks':
					case 'lastfm_events':
					case 'lastfm_loved':
					case 'lastfm_journal':
                        title_desc = 'Username';
						username_desc = 'Introduce the data of the social feed.';
                        break;
					case 'twitter':
                        title_desc = 'Username';
						username_desc = 'Introduce the username, and don\'t forget to set the <a href="<?php echo dpSocialTimeline_admin_url( array( 'page' => 'dpSocialTimeline-twitter' ) )?>" target="_blank">twitter credentials</a>';
						jQuery(inp).closest('.slidebox').find('.include_retweets').show();
                        break;
					case 'facebook_page':
                        title_desc = 'Page ID';
						username_desc = 'Facebook Page ID, find the ID of your FB page in <a href="http://findmyfacebookid.com/" target="_blank">http://findmyfacebookid.com/</a>, and don\'t forget to set the <a href="<?php echo dpSocialTimeline_admin_url( array( 'page' => 'dpSocialTimeline-twitter' ) )?>" target="_blank">FB API credentials</a>';
                        break;	
					case 'google':
                        title_desc = 'G+ RSS';
						username_desc = 'Google+ is not adding RSS feed support oficially, so you will have to go to <a href="http://gplusrss.com/" target="_blank">http://gplusrss.com/</a>, login with your g+ account and use the RSS url in this option';
                        break;
					case 'lastfm_artist_events':
                        title_desc = 'Artist Username';
						username_desc = 'Introduce the data of the social feed.';
                        break;	
                    case 'flickr':
                        title_desc = 'User ID';
						username_desc = 'Flickr User ID, find your ID in <a href="http://idgettr.com/" target="_blank">http://idgettr.com/</a>';
                        break;	
					case 'instagram_hash':
						title_desc = 'Hashtag';
						username_desc = 'Try using lowercase in case that it doesn\'t work.';
						break;
					case 'instagram':
						title_desc = 'Username';
						username_desc = 'Introduce the username, and don\'t forget to set the <a href="<?php echo dpSocialTimeline_admin_url( array( 'page' => 'dpSocialTimeline-twitter' ) )?>" target="_blank">client ID</a>';
						break;
					case 'twitter_hash':
                        title_desc = 'Hashtag';
						username_desc = 'Introduce the data of the social feed, and don\'t forget to set the <a href="<?php echo dpSocialTimeline_admin_url( array( 'page' => 'dpSocialTimeline-twitter' ) )?>" target="_blank">twitter credentials</a>';
                        break;
					case 'youtube_search':
                        title_desc = 'Search';
						username_desc = 'Introduce the data of the social feed.';
                        break;
					case 'foursquare':	
						title_desc = 'RSS feed url';
						username_desc = 'Get your RSS feed in <a href="https://foursquare.com/feeds/" target="_blank">https://foursquare.com/feeds/</a>.';
                        break;
                }

                jQuery(inp).closest('.slidebox').find('.title_username_desc').html(title_desc);
				if(username_desc != '') {
					jQuery(inp).closest('.slidebox').find('.username_desc').html(username_desc);
				}
            }
        //]]>
    </script>
	<div class="wrap" style="clear:both;" id="dp_options">
    <h2></h2>
	<div style="clear:both;"></div>
 	<!--end of poststuff --> 
 	<div id="dp_ui_content">
    	
		<?php if(!is_numeric($_GET['add']) && !is_numeric($_GET['edit'])) {	?>
 
        
        <div id="menu_general_settings">
            <div class="titleArea">
                <div class="wrapper">
                    <div class="pageTitle">
                        <img src="<?php echo dpSocialTimeline_plugin_url('images/logo.png')?>" alt="<?php _e('Social Timeline','dpSocialTimeline'); ?>" />
                        <span><?php _e('Use the shortcode in your posts or pages.','dpSocialTimeline'); ?></span>
                    </div>
                    
                    <div class="clear"></div>
                </div>
            </div>
        </div>
                
                <div class="wrapper">

                <form action="" method="post">
					<?php settings_fields('dpSocialTimeline-group'); ?>
                    
                    <input type="hidden" name="remove_posts_timeline" value="1" />
                    
                    	<div class="submit">
                        
                        <input type="button" class="button" value="<?php echo __( 'Add new timeline', 'dpSocialTimeline' )?>" name="add_timeline" onclick="location.href='<?php echo dpSocialTimeline_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        <table class="widefat" cellpadding="0" cellspacing="0" id="sort-table">
                        	<thead>
                        		<tr style="cursor:default !important;">
                                	<th><?php _e('ID','dpSocialTimeline'); ?></th>
                                    <th><?php _e('Shortcode','dpSocialTimeline'); ?></th>
                                    <th><?php _e('Title','dpSocialTimeline'); ?></th>
                                    <th style="text-align:center;"><?php _e('Active','dpSocialTimeline'); ?></th>
                                    <th style="text-align:center;"><?php _e('Actions','dpSocialTimeline'); ?></th>
                                 </tr>
                            </thead>
                            <tbody>
                        <?php 
						$counter = 0;
                        $querystr = "
                        SELECT timelines.*
                        FROM $table_name timelines
                        ORDER BY timelines.title ASC
                        ";
                        $timelines_obj = $wpdb->get_results($querystr, OBJECT);
                        foreach($timelines_obj as $timeline) {
							$dpSocialTimeline_class = new DpSocialTimeline( true, (is_numeric($timeline->id) ? $timeline->id : null) );
							
							$timeline_nonce = $dpSocialTimeline_class->getNonce();
							
							if(function_exists('mb_convert_encoding')) {
								$timeline->title = utf8_decode(htmlentities($timeline->title));
							}
							
                            echo '<tr id="'.$timeline->id.'">
									<td width="5%">'.$timeline->id.'</td>
									<td width="20%">[dpSocialTimeline id='.$timeline->id.']</td>
									<td width="45%">'.$timeline->title.'</td>
									<td width="5%" align="center"><img src="'.dpSocialTimeline_plugin_url('images/admin/icon-'.($timeline->active ? 'on' : 'off').'.gif').'" alt="" /></td>
									<td width="25%" align="center">
										<input type="button" value="'.__( 'Edit', 'dpSocialTimeline' ).'" name="edit_timeline" class="button-secondary" onclick="location.href=\''.admin_url('admin.php?page=dpSocialTimeline-admin&edit='.$timeline->id).'\';" />
										<input type="button" value="'.__( 'Delete', 'dpSocialTimeline' ).'" name="delete_timeline" class="button-secondary" onclick="if(confirmTimelineDelete()) { location.href=\''.admin_url('admin.php?page=dpSocialTimeline-admin&delete_timeline='.$timeline->id.'&noheader=true').'\'; }" />
									</td>
								</tr>'; 
							$counter++;
                        }
                        ?>
                        
                    		</tbody>
                            <tfoot>
                            	<tr style="cursor:default !important;">
                                	<th><?php _e('ID','dpSocialTimeline'); ?></th>
                                    <th><?php _e('Shortcode','dpSocialTimeline'); ?></th>
                                    <th><?php _e('Title','dpSocialTimeline'); ?></th>
                                    <th style="text-align:center;"><?php _e('Active','dpSocialTimeline'); ?></th>
                                    <th style="text-align:center;"><?php _e('Actions','dpSocialTimeline'); ?></th>
                                 </tr>
                            </tfoot>
                        </table>
                        
                        <div class="submit">
                        
                        <input type="button" class="button" value="<?php echo __( 'Add new timeline', 'dpSocialTimeline' )?>" name="add_timeline" onclick="location.href='<?php echo dpSocialTimeline_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        <div class="clear"></div>
                 </form>
             	</div>
            </div>
        <?php } elseif(is_numeric($_GET['add']) || is_numeric($_GET['edit'])) {
		
		if(is_numeric($_GET['edit'])){
			$timeline_id = $_GET['edit'];
			$querystr = "
			SELECT *
			FROM $table_name 
			WHERE id = $timeline_id
			";
			$timeline_obj = $wpdb->get_results($querystr, OBJECT);
			$timeline_obj = $timeline_obj[0];	
			foreach($timeline_obj as $key=>$value) { $$key = $value; }
		} else {
			$showSocialIcons = 1;
			$showFilter = 1;
			$showLayout = 1;
			$showTime = 1;
			$share = 1;
			$rtl = 0;
			$itemWidth = 200;
			$total = 10;
			$width = 100;
			$width_unity = '%';
			$cache = 0;
			$cacheTime = 900;
			$allowMultipleFilters = 1;
		}
		
		$dpSocialTimeline_class = new DpSocialTimeline( true, (is_numeric($timeline_id) ? $timeline_id : null) );
		
		$timeline_nonce = $dpSocialTimeline_class->getNonce();
		
		
		?>
        
        <form method="post" action="<?php echo admin_url('admin.php?page=dpSocialTimeline-admin&noheader=true'); ?>" onsubmit="return timeline_checkform();">
        <div id="menu_general_settings">
            <div class="titleArea">
                <div class="wrapper">
                    <div class="pageTitle">
                        <img src="<?php echo dpSocialTimeline_plugin_url('images/logo.png')?>" alt="<?php _e('Social Timeline','dpSocialTimeline'); ?>" />
                        <span><?php _e('Customize the Timeline.','dpSocialTimeline'); ?></span>
                        
                    </div>
                    
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="wrapper">
        	
            <div class="dp_submit">
                <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
                <input type="button" class="button" value="<?php _e('Back') ?>" onclick="location.href='<?php echo admin_url('admin.php?page=dpSocialTimeline-admin');?>'" />
            </div>
       		
            <input type="hidden" name="submit" value="1" />
            <?php if(is_numeric($id) && $id > 0) {?>
            	<input type="hidden" name="timeline_id" value="<?php echo $id?>" />
            <?php }?>
            <?php settings_fields('dpSocialTimeline-group'); ?>
            <div style="clear:both;"></div>
             <!--end of poststuff --> 
             
             <div class="col-left">
                <div class="metabox-holder has-right-sidebar">
                    <div class="editor-wrapper meta-box-sortables">
                        <div class="editor-body">
                            <div id="titlediv">
                            	<h4>Title</h4>
                                <input name="title" maxlength="80" id="title" type="text" value="<?php echo $title?>"/>
                            </div>
                            
                            <div class="social_feeds_wrapper">
                                <h4>Social Feeds</h4>
                                <div id="dp_timelines_social" class="slideboxes dp-sortable">
                                    <div id="clone_add_social">
                                        <?php include('add_feed.php');?>
                                    </div>
                                    <?php
                                    if(is_numeric($_GET['edit'])){
										if(function_exists('mb_convert_encoding')) {
                                        	$items = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'dpSocialTimeline_replace_unicode_escape_sequence', str_replace('u0', '\u0', $items));
										}
										
                                        $timeline_feeds = json_decode($items);
										$timeline_feeds = dpSocialTimeline_stripslashesFull($timeline_feeds);
										foreach($timeline_feeds as $key) {
											$social_title = $key->title;
											$social_name = $key->name;
											$social_data = $key->data;
											$social_limit = $key->limit;
											$include_retweets = $key->include_retweets;

                                        	include('add_feed.php');
										}
                                    } else {
                                        include('add_feed.php');
                                    }?>
                                </div>
                                
                                <div id="add-new-slide"> 
                                    <a class="button-secondary" id="dp_uni_btn_add_social" href="javascript:void(0);">Add a New Social Feed</a>
                                </div>
                            </div>
                            
                            <div class="custom_feeds_wrapper">
                                <h4>Custom Feeds</h4>
                                <div id="dp_timelines_custom" class="slideboxes dp-sortable">
                                    <div id="clone_add_custom">
                                        <?php include('add_custom.php');?>
                                    </div>
                                    <?php
                                    if(is_numeric($_GET['edit'])){
                                        
                                        $timeline_custom = json_decode($custom);
										foreach($timeline_custom as $key) {
											$custom_title = $key->title;
											$custom_name = $key->name;
											$custom_url = $key->url;
											$custom_icon = $key->icon;
											$custom_limit = $key->limit;

                                        	include('add_custom.php');
										}
                                    } else {
                                        include('add_custom.php');
                                    }?>
                                </div>
                                
                                <div id="add-new-slide"> 
                                    <a class="button-secondary" id="dp_uni_btn_add_custom" href="javascript:void(0);"><?php _e('Add a New Custom Feed', 'dpSocialTimeline'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
                
              <div class="col-right metabox-holder meta-box-sortables">
              <div class="slideboxes dp-sortable">
              	<div class="postbox slidebox">
                    <div class="handlediv" title="<?php _e('Show/Hide Timeline', 'dpSocialTimeline'); ?>"></div>
                    <h3 class="hndle"><?php _e('General Settings','dpSocialTimeline'); ?></h3>
                    
                    <div class="dp_inside" style="display:block;">
                    	<div class="dp_inside_wrapper">
                            <div id="div_general_settings">
                            
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Active','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="active" id="dpSocialTimeline_active" class="checkbox" <?php if($active) {?>checked="checked" <?php }?> value="1" />
                                                <br>
                                            </div>
                                            
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('On/Off the timeline','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                    			
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Skin','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <select name="skin" id="dpSocialTimeline_skin" class="large-text">
                                                    <option value="light" <?php if($skin == 'light') {?> selected="selected" <?php }?>>Light</option>
                                                    <option value="dark" <?php if($skin == 'dark') {?> selected="selected" <?php }?>>Dark</option>
                                                    <option value="modern" <?php if($skin == 'modern') {?> selected="selected" <?php }?>>Modern</option>
                                                </select>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Select the skin style.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Layout Mode','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <select name="layoutMode" id="dpSocialTimeline_layoutMode" class="large-text">
                                                    <option value="timeline" <?php if($layoutMode == 'timeline') {?> selected="selected" <?php }?>>Timeline</option>
                                                    <option value="columns" <?php if($layoutMode == 'columns') {?> selected="selected" <?php }?>>Columns</option>
                                                    <option value="one_column" <?php if($layoutMode == 'one_column') {?> selected="selected" <?php }?>>One Column</option>
                                                </select>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Select the layout mode.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Total','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="number" min="0" max="99" name="total" style="width:50px;" id="dpSocialTimeline_total" class="large-text" value="<?php echo $total;?>">
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set a total of items to retrieve.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Lightbox','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="addColorbox" class="checkbox" id="dpSocialTimeline_addColorbox" value="1" <?php if($addColorbox) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Add Lightbox support for images and videos.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Show Social Icons','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="showSocialIcons" class="checkbox" id="dpSocialTimeline_showSocialIcons" value="1" <?php if($showSocialIcons) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set if you want to show the social icons.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Cache','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="cache" class="checkbox" id="dpSocialTimeline_cache" value="1" <?php if($cache) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Enable/disable the cache feature.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Cache Time','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="cacheTime" id="dpSocialTimeline_cacheTime" maxlength="6" style="width:50px;" class="large-text" value="<?php echo $cacheTime?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set the cache expire time in seconds.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Show Filter','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="showFilter" class="checkbox" id="dpSocialTimeline_showFilter" value="1" <?php if($showFilter) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set if you want to show the filter buttons.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Allow Multiple Filters','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="allowMultipleFilters" class="checkbox" id="dpSocialTimeline_allowMultipleFilters" value="1" <?php if($allowMultipleFilters) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Enable/disable the multiple social filter.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Show Layout','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="showLayout" class="checkbox" id="dpSocialTimeline_showLayout" value="1" <?php if($showLayout) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set if you want to show the layout buttons.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Show Feed Time','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="showTime" class="checkbox" id="dpSocialTimeline_showTime" value="1" <?php if($showTime) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set if you want to show the feed time.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Show "Share" Buttons','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="share" class="checkbox" id="dpSocialTimeline_share" value="1" <?php if($share) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set if you want to show the share buttons.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-checkbox">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('RTL','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="checkbox" name="rtl" class="checkbox" id="dpSocialTimeline_rtl" value="1" <?php if($rtl) {?>checked="checked" <?php }?> />
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Enable/Disable RTL layout.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select" style="display: none;">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Items Width','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="itemWidth" id="dpSocialTimeline_itemWidth" maxlength="6" style="width:50px;" class="large-text" value="<?php echo $itemWidth?>" /> 
                                                px
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set the width of each item in the timeline.','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select" style="display:none;">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Items Width in "Timeline"','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="timelineItemWidth" id="dpSocialTimeline_timelineItemWidth" maxlength="6" style="width:50px;" class="large-text" value="<?php echo $timelineItemWidth?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set the width of each item in the "timeline" Layout. Example in pixels: <strong>300px</strong> or percentage <strong>100%</strong>','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Items Width in "Columns"','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="columnsItemWidth" id="dpSocialTimeline_columnsItemWidth" maxlength="6" style="width:50px;" class="large-text" value="<?php echo $columnsItemWidth?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set the width of each item in the "columns" Layout. Example in pixels: <strong>300px</strong> or percentage <strong>100%</strong>','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Items Width in "One Column"','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="oneColumnItemWidth" id="dpSocialTimeline_oneColumnItemWidth" maxlength="6" style="width:50px;" class="large-text" value="<?php echo $oneColumnItemWidth?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set the width of each item in the "One Column" Layout. Example in pixels: <strong>300px</strong> or percentage <strong>100%</strong>','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            
                                <div class="option option-select no_border">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Total Width','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="width" id="dpSocialTimeline_width" maxlength="4" style="width:50px;" class="large-text" value="<?php echo $width?>" /> 
                                                <select name="width_unity" id="dpSocialTimeline_width_unity" style="width:60px;" class="large-text">
                                                    <option value="px" <?php if($width_unity == 'px') {?> selected="selected" <?php }?>>px</option>
                                                    <option value="%" <?php if($width_unity == '%') {?> selected="selected" <?php }?>>%</option>
                                                </select>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Set the width of the timeline','dpSocialTimeline'); ?></div>
                                    </div>
                                </div>
                            	<div class="clear"></div>
                        	</div>
                      	</div>
               		</div>

                </div>
                
                <div class="postbox slidebox">
                    <div class="handlediv" title="<?php _e('Show/Hide Timeline', 'dpSocialTimeline'); ?>"></div>
                    <h3 class="hndle"><?php _e('Translations','dpSocialTimeline'); ?></h3>
                    
                    <div class="dp_inside" style="display:none;">
                    	<div class="dp_inside_wrapper">
                            <div id="div_translations">
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Week','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_week" id="dpSocialTimeline_lang_week" style="width:100px;" class="large-text" value="<?php echo ($lang_week != "" ? $lang_week : "week" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "week" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Weeks','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_weeks" id="dpSocialTimeline_lang_weeks" style="width:100px;" class="large-text" value="<?php echo ($lang_weeks != "" ? $lang_weeks : "weeks" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "weeks" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Day','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_day" id="dpSocialTimeline_lang_day" style="width:100px;" class="large-text" value="<?php echo ($lang_day != "" ? $lang_day : "day" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "day" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Days','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_days" id="dpSocialTimeline_lang_days" style="width:100px;" class="large-text" value="<?php echo ($lang_days != "" ? $lang_days : "days" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "days" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Hour','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_hour" id="dpSocialTimeline_lang_hour" style="width:100px;" class="large-text" value="<?php echo ($lang_hour != "" ? $lang_hour : "hour" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "hour" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Hours','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_hours" id="dpSocialTimeline_lang_hours" style="width:100px;" class="large-text" value="<?php echo ($lang_hours != "" ? $lang_hours : "hours" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "hours" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Minute','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_minute" id="dpSocialTimeline_lang_minute" style="width:100px;" class="large-text" value="<?php echo ($lang_minute != "" ? $lang_minute : "minute" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "minute" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Minutes','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_minutes" id="dpSocialTimeline_lang_minutes" style="width:100px;" class="large-text" value="<?php echo ($lang_minutes != "" ? $lang_minutes : "minutes" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "minutes" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('About','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_about" id="dpSocialTimeline_lang_about" style="width:100px;" class="large-text" value="<?php echo ($lang_about != "" ? $lang_about : "about" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "about" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Ago','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_ago" id="dpSocialTimeline_lang_ago" style="width:100px;" class="large-text" value="<?php echo ($lang_ago != "" ? $lang_ago : "ago" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "ago" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>
                                
                                <div class="option option-select no_border">
                                    <div class="option-inner">
                                        <label class="titledesc"><?php _e('Less than a minute ago','dpSocialTimeline'); ?></label>
                                        <div class="formcontainer">
                                            <div class="forminp">
                                                <input type="text" name="lang_less" id="dpSocialTimeline_lang_less" style="width:100px;" class="large-text" value="<?php echo ($lang_less != "" ? $lang_less : "Less than a minute ago" )?>" /> 
                                                
                                                <br>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="desc"><?php _e('Translation for "Less than a minute ago" label.','dpSocialTimeline'); ?></div>
                                    </div>
                            	</div>
                            	<div class="clear"></div>

                		</div>
             		</div>
                 </div>
                 <div class="clear"></div>
             </div>
             </div>
            <div class="dp_submit">
                <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
                <input type="button" class="button" value="<?php _e('Back') ?>" onclick="location.href='<?php echo admin_url('admin.php?page=dpSocialTimeline-admin');?>'" />
            </div>
            </div>
            <script type="text/javascript">
                toggleFormat(document.getElementById('dpSocialTimeline_auto_slide'), 'div_auto_slide');
                toggleFormat(document.getElementById('dpSocialTimeline_show_navigation'), 'div_show_navigation');
                toggleFormat(document.getElementById('dpSocialTimeline_delay_transition'), 'div_delay_transition');
            </script>
        </div>
     </form>
     </div>
<?php 
if(is_numeric($_GET['edit'])) {
?>
<script type="text/javascript">
	jQuery('.dpSocialTimeline_social_name').each(function() {	
		changeSocialFeed(jQuery(this));
	});
</script>

<?php }?>
        <?php }?>
	 <!--end of poststuff --> 
	
	
    <div class="clear"></div>
	
	<?php	
}
?>