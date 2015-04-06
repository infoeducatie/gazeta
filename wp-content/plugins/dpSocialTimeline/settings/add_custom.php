<?php
	$custom_nonce = dpSocialTimeline_generateRandomString();
	if(!isset($custom_title)) { $custom_title = ""; }
	if(!isset($custom_name)) { $custom_name = ""; }
	if(!isset($custom_url)) { $custom_url = ""; }
	if(!isset($custom_icon)) { $custom_icon = ""; }
?>
    <div class="postbox slidebox">
    	<input type="hidden" name="custom[]" class="custom_num" value="1" />
        <input type="hidden" name="nonce[]" class="custom_nonce" value="<?php echo $custom_nonce?>" />
        <div class="handlediv" title="<?php _e('Show/Hide Feed', 'dpSocialTimeline'); ?>"></div>
        <h3 class="hndle"><input type="text" name="custom_title[]" size="30" value="<?php if($custom_title != "") { echo $custom_title; } else { _e('My Custom Feed', 'dpSocialTimeline'); }?>" /></h3>
        
        <div class="dp_inside">
        	<div class="dp_inside_wrapper">
                <div class="categorydiv">
                    
                    
                    <div class="tabs-panel dpSocialTimeline_tabs_panel" style="display:block; ">
                        
                        <div class="option option-checkbox">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><?php _e('Name', 'dpSocialTimeline'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <input type="text" name="custom_name[]" style="width:150px;" id="dpSocialTimeline_custom_name" class="large-text" value="<?php echo $custom_name;?>">
                                        <br>
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="desc"><?php _e('Introduce the name of the custom feed.', 'dpSocialTimeline'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-checkbox">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><?php _e('Url', 'dpSocialTimeline'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <input type="text" name="custom_url[]" style="width:150px;" id="dpSocialTimeline_custom_url" class="large-text" value="<?php echo $custom_url;?>">
                                        <br>
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="desc"><?php _e('Introduce the URL of the custom feed.', 'dpSocialTimeline'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-checkbox">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><?php _e('Icon', 'dpSocialTimeline'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <input type="text" name="custom_icon[]" style="width:150px;" id="dpSocialTimeline_custom_icon" class="large-text" value="<?php echo $custom_icon;?>">
                                        <br>
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="desc"><?php _e('Introduce the url of the custom feed icon. (16x16 px)', 'dpSocialTimeline'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-checkbox no_border">
                            <div class="option-inner">
                                <label class="titledesc" style="width:60px;"><?php _e('Limit', 'dpSocialTimeline'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <input type="number" min="0" max="99" name="custom_limit[]" style="width:50px;" id="dpSocialTimeline_custom_limit" class="large-text" value="<?php echo $custom_limit;?>">
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
                <a href="javascript:void(0);" class="btn_custom_delete"><?php _e('Delete Feed', 'dpSocialTimeline'); ?></a>
            </div>
        </div>
    </div>
    