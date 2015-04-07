<?php
	$social_nonce = dpSocialTimeline_generateRandomString();
	if(!isset($social_title)) { $social_title = ""; }
?>
    <div class="postbox slidebox">
    	<input type="hidden" name="social[]" class="social_num" value="1" />
        <input type="hidden" name="nonce[]" class="social_nonce" value="<?php echo $social_nonce?>" />
        <div class="handlediv" title="<?php _e('Show/Hide Feed', 'dpSocialTimeline'); ?>"></div>
        <h3 class="hndle"><input type="text" name="social_title[]" size="30" value="<?php if($social_title != "") { echo $social_title; } else { _e('My Social Feed', 'dpSocialTimeline'); }?>" /></h3>
        
        <div class="dp_inside">
        	<div class="dp_inside_wrapper">
                <div class="categorydiv">
                    
                    
                    <div class="tabs-panel dpSocialTimeline_tabs_panel" style="display:block; ">
                        <div class="option option-checkbox">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><?php _e('Feed', 'dpSocialTimeline'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                    	<select name="social_name[]" style="width:150px;" class="large-text dpSocialTimeline_social_name" id="dpSocialTimeline_social_name" onchange="changeSocialFeed(this);">
                                        	<option value="twitter" <?php if($social_name == 'twitter') { echo 'selected="selected"'; }?>>Twitter</option>
                                            <option value="twitter_hash" <?php if($social_name == 'twitter_hash') { echo 'selected="selected"'; }?>>Twitter Hashtag</option>
                                            <option value="facebook_page" <?php if($social_name == 'facebook_page') { echo 'selected="selected"'; }?>>Facebook Page</option>
                                            <option value="google" <?php if($social_name == 'google') { echo 'selected="selected"'; }?>>Google+</option>
                                            <option value="instagram" <?php if($social_name == 'instagram') { echo 'selected="selected"'; }?>>Instagram</option>
                                            <option value="instagram_hash" <?php if($social_name == 'instagram_hash') { echo 'selected="selected"'; }?>>Instagram Hashtag</option>
                                            <option value="500px" <?php if($social_name == '500px') { echo 'selected="selected"'; }?>>500px</option>
                                            <option value="delicious" <?php if($social_name == 'delicious') { echo 'selected="selected"'; }?>>Delicious</option>
                                            <option value="flickr" <?php if($social_name == 'flickr') { echo 'selected="selected"'; }?>>Flickr</option>
                                            <option value="flickr_hash" <?php if($social_name == 'flickr_hash') { echo 'selected="selected"'; }?>>Flickr Hashtag</option>
                                            <option value="tumblr" <?php if($social_name == 'tumblr') { echo 'selected="selected"'; }?>>Tumblr</option>
                                            <option value="youtube" <?php if($social_name == 'youtube') { echo 'selected="selected"'; }?>>Youtube</option>
                                            <option value="youtube_search" <?php if($social_name == 'youtube_search') { echo 'selected="selected"'; }?>>Youtube Search</option>
                                            <option value="dribbble" <?php if($social_name == 'dribbble') { echo 'selected="selected"'; }?>>Dribbble</option>
                                            <option value="digg" <?php if($social_name == 'digg') { echo 'selected="selected"'; }?>>Digg</option>
                                            <option value="pinterest" <?php if($social_name == 'pinterest') { echo 'selected="selected"'; }?>>Pinterest</option>
                                            <option value="vimeo" <?php if($social_name == 'vimeo') { echo 'selected="selected"'; }?>>Vimeo</option>
                                            <option value="soundcloud" <?php if($social_name == 'soundcloud') { echo 'selected="selected"'; }?>>Soundcloud</option>
                                            <option value="foursquare" <?php if($social_name == 'foursquare') { echo 'selected="selected"'; }?>>Foursquare Checkins</option>
                                            <option value="lastfm_tracks" <?php if($social_name == 'lastfm_tracks') { echo 'selected="selected"'; }?>>Lastfm - Recent Tracks Feed</option>
                                            <option value="lastfm_events" <?php if($social_name == 'lastfm_events') { echo 'selected="selected"'; }?>>Lastfm - Upcoming Events</option>
                                            <option value="lastfm_loved" <?php if($social_name == 'lastfm_loved') { echo 'selected="selected"'; }?>>Lastfm - Loved Tracks</option>
                                            <option value="lastfm_artist_events" <?php if($social_name == 'lastfm_artist_events') { echo 'selected="selected"'; }?>>Lastfm - Artist Current Events</option>
                                            <option value="lastfm_journal" <?php if($social_name == 'lastfm_journal') { echo 'selected="selected"'; }?>>Lastfm - Recent Journals Feed</option>
                                        </select>
                                        
                                        <br>
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="desc"><?php _e('Select the social feed.', 'dpSocialTimeline'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-checkbox">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><span class="title_username_desc"><?php _e('Username', 'dpSocialTimeline'); ?></span></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <input type="text" name="social_data[]" style="width:150px;" id="dpSocialTimeline_social_data" class="large-text" value="<?php echo $social_data;?>">
                                        <br>
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="desc username_desc"><?php _e('Introduce the username, and don\'t forget to set the <a href="'.dpSocialTimeline_admin_url( array( 'page' => 'dpSocialTimeline-twitter' ) ).'" target="_blank">twitter credentials</a>', 'dpSocialTimeline'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-checkbox include_retweets" style="display:none;">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><?php _e('Include Retweets?', 'dpSocialTimeline'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                    	<select name="social_include_retweets[]">
                                        	<option value="0"><?php _e('No', 'dpSocialTimeline'); ?></option>
                                            <option value="1" <?php echo ($include_retweets ? "selected='selected'" : "" );?>><?php _e('Yes', 'dpSocialTimeline'); ?></option>
                                        </select>
                                        
                                        <br>
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="desc"><?php _e('Set a limit for this feed.', 'dpSocialTimeline'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-checkbox no_border">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><?php _e('Limit', 'dpSocialTimeline'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <input type="number" min="0" max="99" name="social_limit[]" style="width:50px;" id="dpSocialTimeline_social_limit" class="large-text" value="<?php echo $social_limit;?>">
                                        
                                        <br>
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="desc"><?php _e('Set a limit for this feed.', 'dpSocialTimeline'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        
                    </div>
                                    
                    
                    
                </div>
            
                <div class="clear"></div>
                <a href="javascript:void(0);" class="btn_social_delete"><?php _e('Delete Feed', 'dpSocialTimeline'); ?></a>
            </div>
        </div>
    </div>
    