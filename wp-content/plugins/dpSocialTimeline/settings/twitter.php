<?php 
// This function displays the admin page content
function dpSocialTimeline_twitter() {
	global $dpSocialTimeline;
	
	?>
	
	<div class="wrap" style="clear:both;" id="dp_options">
    <h2></h2>
    <form method="post" action="options.php" enctype="multipart/form-data">
	<?php settings_fields('dpSocialTimeline-group'); ?>
    <?php foreach($dpSocialTimeline as $key=>$value) {?>
    <input type="hidden" name="dpSocialTimeline_options[<?php echo $key?>]" value="<?php echo $value?>" />
    <?php }?>
	<div style="clear:both;"></div>
 	<!--end of poststuff --> 
 	<div id="dp_ui_content">
    	
 
        <div id="menu_general_settings">
            <div class="titleArea">
                <div class="wrapper">
                    <div class="pageTitle">
                        <img src="<?php echo dpSocialTimeline_plugin_url('images/logo.png')?>" alt="<?php _e('Social Timeline','dpSocialTimeline'); ?>" />
                        <span><?php _e('Add your API credentials.','dpSocialTimeline'); ?></span>
                    </div>
                    
                    <div class="clear"></div>
                </div>
            </div>
        </div>
                
        <div class="wrapper no_margin">
				<h2>Twitter Credentials</h2>
            		<div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Consumer Key:','dpSocialTimeline'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type='text' name='dpSocialTimeline_options[twitter_consumer_key]' value="<?php echo $dpSocialTimeline['twitter_consumer_key']?>"/>
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Consumer Secret:','dpSocialTimeline'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type='text' name='dpSocialTimeline_options[twitter_consumer_secret]' value="<?php echo $dpSocialTimeline['twitter_consumer_secret']?>"/>
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Access Token:','dpSocialTimeline'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type='text' name='dpSocialTimeline_options[twitter_access_token]' value="<?php echo $dpSocialTimeline['twitter_access_token']?>"/>
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select no_border">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Access Token Secret:','dpSocialTimeline'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type='text' name='dpSocialTimeline_options[twitter_access_secret]' value="<?php echo $dpSocialTimeline['twitter_access_secret']?>"/>
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    
                    <strong>Instructions to get the Credentials</strong>
                    <ol>
                        <li><a href="https://dev.twitter.com/apps/new">Add a new Twitter application</a></li>
                        <li>Fill in Name, Description, Website, and Callback URL (don't leave any blank) with anything you want</li>
                        <li>Agree to rules, fill out captcha, and submit your application</li>
                        <li>Click the button "Create my access token" and then go to the OAuth tab.</li>
                        <li>Copy the Consumer key, Consumer secret, Access token and Access token secret into the fields above</li>
                        <li>Click the Save Settings button at the bottom of this page</li>
                    </ol>
        	
            <hr />
            
            <h2><?php _e('Instagram Credentials','dpSocialTimeline'); ?></h2>
            <div class="option option-select no_border">
                <div class="option-inner">
                    <label class="titledesc"><?php _e('Client ID:','dpSocialTimeline'); ?></label>
                    <div class="formcontainer">
                        <div class="forminp">
                            <input type='text' name='dpSocialTimeline_options[instagram_client_id]' value="<?php echo $dpSocialTimeline['instagram_client_id']?>"/>
                            <br>
                        </div>
                        <div class="desc"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            
            
            <strong><?php _e('Instructions to get the client ID','dpSocialTimeline'); ?></strong>
            <ol>
                <li>Register an app at <a href="http://instagram.com/developer/" target="_blank">http://instagram.com/developer/</a></li>
                <li>You will find the client ID in <a href="http://instagram.com/developer/clients/manage/" target="_blank">http://instagram.com/developer/clients/manage/</a></li>
            </ol>
            
            <hr />
            
            <h2><?php _e('Facebook API Keys','dpSocialTimeline'); ?></h2>
            <div class="option option-select">
                <div class="option-inner">
                    <label class="titledesc"><?php _e('App ID:','dpSocialTimeline'); ?></label>
                    <div class="formcontainer">
                        <div class="forminp">
                            <input type='text' name='dpSocialTimeline_options[facebook_app_id]' value="<?php echo $dpSocialTimeline['facebook_app_id']?>"/>
                            <br>
                        </div>
                        <div class="desc"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            
            <div class="option option-select no_border">
                <div class="option-inner">
                    <label class="titledesc"><?php _e('App Secret:','dpSocialTimeline'); ?></label>
                    <div class="formcontainer">
                        <div class="forminp">
                            <input type='text' name='dpSocialTimeline_options[facebook_app_secret]' value="<?php echo $dpSocialTimeline['facebook_app_secret']?>"/>
                            <br>
                        </div>
                        <div class="desc"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            
            
            <strong><?php _e('Instructions to get the Facebook API keys','dpSocialTimeline'); ?></strong>
            <ol>
                <li>If you are not registered as a developer in Facebook, you will have to register in <a href="https://developers.facebook.com/">https://developers.facebook.com/</a>, go to Apps -> Register as a Developer</li>
                <li>Once you are registered go to <a href="https://developers.facebook.com/">https://developers.facebook.com/</a> Apps -> Create a new App and fill the form</li>
                <li>If you created the App succesfully, you will see the new App ID and Secret keys in the dashboard</li>
            </ol>
        </div>
    </div>
	 <!--end of poststuff --> 
     <p align="right">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
	</form>
	
    <div class="clear"></div>
	
<?php	
}
function dpSocialTimeline_register_mysettings() { // whitelist options
  register_setting( 'dpSocialTimeline-group', 'dpSocialTimeline_options' );
}
?>