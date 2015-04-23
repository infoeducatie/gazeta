<?php
class wp_lightbox_2_design_settings_page{
	private $menu_name;
	private $databese_settings;
	public  $initial_values;
	
	
	function __construct($params){
		// set plugin url
		if(isset($params['plugin_url']))
			$this->plugin_url=$params['plugin_url'];
		else
			$this->plugin_url=trailingslashit(dirname(plugins_url('',__FILE__)));
		// set plugin path
		if(isset($params['plugin_path']))
			$this->plugin_path=$params['plugin_path'];
		else
			$this->plugin_path=trailingslashit(dirname(plugin_dir_path('',__FILE__)));
			
		$this->databese_settings=$params['databese_settings'];
	
		/*ajax parametrs*/
		add_action( 'wp_ajax_save_in_databese_lightbox2_design', array($this,'save_parametrs') );
	
	}
	public function save_parametrs(){
		 $initial_values=array(	'jqlb_overlay_opacity'=>'80');	
	$kk=1;	
		if(isset($_POST['wp_lightbox_2_design_settings_page']) && wp_verify_nonce( $_POST['wp_lightbox_2_design_settings_page'],'wp_lightbox_2_design_settings_page')){
			
			foreach($initial_values as $key => $value){
				if(isset($_POST[$key])){
					update_option($key,stripslashes($_POST[$key]));
				}
				else{
					$kk=0;
					printf('error saving %s <br>',$key);
				}
			}	
		}
		else{
			die('Authorization Problem ');
		}
		if($kk==0){
			exit;
		}
		die('sax_normala');
	}
	/*#################### CONTROLERRR ########################*/
	/*#################### CONTROLERRR ########################*/
	/*#################### CONTROLERRR ########################*/
	public function controller_page(){
		
			$this->display_table_list_answers();
	}
	

	private function display_table_list_answers(){
		
        $initial_values= $this->databese_settings;
		
		
	foreach($initial_values as $key => $value){		
			$$key=$value;
	}
	?>
		
        <style>
		.popup_settings{
			<?php echo $youtube_plus_show_popup?'':'display:none;'; ?>
		}
		.pro_subtitle_span{
		color: rgba(10, 154, 62, 1);
		}
        </style>
        <h2>Lightbox Design Settings</h2>	
        <div class="main_yutube_plus_params">	
        <table class="wp-list-table widefat fixed posts wp_lightbox2_settings_table" style="width: 900px; min-width:320px !important;table-layout: fixed;">
            <thead>
                <tr>
                    <th width="60%">
                   		<span> Lightbox Design Settings </span>
                    </th> 
                    <th  width="40%">
                   		<span style="float:right"><a href="http://wpdevart.com/wordpress-lightbox-plugin/" target="_blank" style="color: rgba(10, 154, 62, 1);; font-weight: bold; font-size: 18px; text-decoration: none;">Upgrade to Pro Version</a><br></span>
                    </th>                  
                             
                </tr>
            </thead>
            <tbody>
            	<tr>
                    <td>     
                    	Overlay opacity: <span title="Set overlay opacity for lightbox." class="desription_class">?</span>
                    </td>
                    <td>     
                            <input type="text" name="jqlb_overlay_opacity" id="jqlb_overlay_opacity" class="slider_input" value="<?php echo $jqlb_overlay_opacity; ?>">
                            <div class="slider_parametrs" id="jqlb_overlay_opacity_div"></div>
                            <span id="jqlb_overlay_opacity_span" class="slider_span"></span>

                    </td>
                </tr>
                <tr>
                    <td>     
                    	Overlay color:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Choose overlay opacity for lightbox." class="desription_class">?</span>
                    </td>
                    <td>   
                        <div class="disabled_for_pro" onclick="alert(text_of_upgrate_version)">
                          <div class="wp-picker-container"><a tabindex="0" class="wp-color-result" title="Select Color" data-current="Current Color" style="background-color: rgb(0, 0, 0);"></a></div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Overlay close function:<span class='pro_subtitle_span'>Pro feature!</span><span title="This function will close the lightbox when you click on overlay. " class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_overlay_close_radio" checked="checked" value="1">Yes</label>
                        <label onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_overlay_close_radio" value="0">No</label>
                       
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Lightbox image Border width:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Type here Lightbox image Border width." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_border_width" id="jqlb_border_width" value="<?php echo $jqlb_border_width; ?>"><small>(px)</small>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Lightbox image Border color:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Choose Border color for Lightbox image." class="desription_class">?</span>
                    </td>
                    <td>     
                    	 <div class="disabled_for_pro" onclick="alert(text_of_upgrate_version)">
                          <div class="wp-picker-container"><a tabindex="0" class="wp-color-result" title="Select Color" data-current="Current Color" style="background-color: rgb(255, 255, 255);"></a></div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Lightbox image Border radius:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Type here Lightbox image Border radius." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_border_radius" id="jqlb_border_radius" value="<?php echo $jqlb_border_radius; ?>"><small>(px)</small>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Show/Hide image numbers (ex. Image 1 of 3):<span class='pro_subtitle_span'>Pro feature!</span> <span title="Choose to show or hide numbers for images." class="desription_class">?</span>
                    </td>
                   <td class="radio_input">     
                    	<label onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_show_text_for_image_radio" checked="checked" value="1">Show</label>
                        <label onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_show_text_for_image_radio" value="0">Hide</label>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Image info and close button background opacity:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Set image info and close button background opacity." class="desription_class">?</span>
                    </td>
                    <td>     
                            <input onMouseDown="alert(text_of_upgrate_version); return false;" type="text" name="jqlb_image_info_background_transparency" id="jqlb_image_info_background_transparency" class="slider_input" value="<?php echo $jqlb_image_info_background_transparency; ?>">
                            <div onMouseDown="alert(text_of_upgrate_version); return false;" class="slider_parametrs" id="jqlb_image_info_background_transparency_div"></div>
                            <span onMouseDown="alert(text_of_upgrate_version); return false;" id="jqlb_image_info_background_transparency_span" class="slider_span"></span>

                    </td>
                </tr>
                  <tr>
                    <td>     
                    	Image info and close button background color:<span class='pro_subtitle_span'>Pro feature!</span>     <span title="Set Image info and close button background color." class="desription_class">?</span>
                    </td>
                    <td>     
                    	 <div class="disabled_for_pro" onclick="alert(text_of_upgrate_version)">
                          <div class="wp-picker-container"><a tabindex="0" class="wp-color-result" title="Select Color" data-current="Current Color" style="background-color: rgb(255, 255, 255);"></a></div>
                        </div>
                    </td>
                </tr>
                  <tr>
                    <td>     
                    	Image info text color (include download link and other text):<span class='pro_subtitle_span'>Pro feature!</span> <span title="Set Image info text color." class="desription_class">?</span>
                    </td>
                    <td>     
                    	 <div class="disabled_for_pro" onclick="alert(text_of_upgrate_version)">
                          <div class="wp-picker-container"><a tabindex="0" class="wp-color-result" title="Select Color" data-current="Current Color" style="background-color: rgb(0, 0, 0);"></a></div>
                        </div>
                    </td>
                </tr>
                 </tr>
                  <tr>
                    <td>     
                    	Image info text font-size (include download link and other text):<span class='pro_subtitle_span'>Pro feature!</span>    <span title="Type Image info text font-size (include download link and other text)" class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_image_info_text_fontsize" id="jqlb_image_info_text_fontsize" value="10"><small>(px)</small>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Next image title tag:<span class='pro_subtitle_span'>Pro feature!</span>   <span title="Type here next image title tag." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_next_image_title" id="jqlb_next_image_title" value="<?php echo __('next image', 'jqlb'); ?>">
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Previous image title tag:<span class='pro_subtitle_span'>Pro feature!</span>   <span title="Type here previous image title tag." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_previous_image_title" id="jqlb_previous_image_title" value="<?php echo __('previous image', 'jqlb'); ?>">
                    </td>
                </tr>          
                
                 <tr>
                    <td>     
                    	Choose next/Previous button image:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Choose Next/Previous button for lightbox." class="desription_class">?</span>
                    </td>
                   <td class="radio_input">    
                   <select onMouseDown="alert(text_of_upgrate_version); return false;" id="theme_for_next_previus">
                       <option value="">Standart</option>
                       <option value="theme0">Theme1</option>
                       <option value="theme1">Theme2</option>
                       <option value="theme2">Theme3</option>
                       <option value="theme3">Theme4</option>
                       <option value="theme4">Theme5</option>
                       <option value="theme5">Theme6</option>
                       <option value="theme6">Theme7</option>
                       <option value="theme7">Theme8</option>
                       <option value="theme8">Theme9</option>
                       <option value="theme9">Theme10</option>
                       <option value="theme10">Theme11</option>
                   </select><small>or choose custom</small> <br /> <br />
                    	<div class="option_group next_button">            
                            <div style="display:inline-block; float:left;height: 60px;">
                            	 <input class="upload-button button-secondary action" onMouseDown="alert(text_of_upgrate_version); return false;" style="width:114px;" type="button"  value=" Upload Next "/>
                                <input type="text" class="upload" id="jqlb_next_button_image" name="jqlb_next_button_image" size="15" value="<?php echo $jqlb_next_button_image ?>"/>                                                        
                            </div>
                             <span style="height:60px;display: inline-block;">
                            	<img src="<?php echo $jqlb_next_button_image ?>" style="max-width:60px; max-height:60px;"/>
                            </span>
                        </div>   
                        <div class="option_group previous_button">                            
                            <div style="display:inline-block; float:left;height: 60px;">
                            	<input class="upload-button button-secondary action" onMouseDown="alert(text_of_upgrate_version); return false;" type="button" value="Upload  Previus"/>
                                <input type="text" class="upload" id="jqlb_previous_button_image" name="jqlb_previous_button_image" size="15" value="<?php echo $jqlb_previous_button_image ?>"/>                                                                  
                            </div>
                             <span style="height:60px;display: inline-block;">
                            <img src="<?php echo $jqlb_previous_button_image ?>" style="max-width:60px; max-height:60px;" />
                            </span>
                        </div>                      
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Maximum Width:<span class='pro_subtitle_span'>Pro feature!</span> <span title=" Type maximum width for lightbox images." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_maximum_width" id="jqlb_maximum_width" value="<?php echo $jqlb_maximum_width; ?>"><small>(px)</small>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Maximum Height:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Type maximum height for lightbox images." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_maximum_height" id="jqlb_maximum_height" value="<?php echo $jqlb_maximum_height; ?>"><small>(px)</small>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Show/Hide close button:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Choose to show or hide close button." class="desription_class">?</span>
                    </td>
                   <td class="radio_input">     
                    	<label  onMouseDown="alert(text_of_upgrate_version); return false;"><input onMouseDown="alert(text_of_upgrate_version); return false;" type="radio" name="jqlb_show_close_button_radio" <?php checked($jqlb_show_close_button,'1'); ?> value="1">Show</label>
                        <label  onMouseDown="alert(text_of_upgrate_version); return false;"><input onMouseDown="alert(text_of_upgrate_version); return false;" type="radio" name="jqlb_show_close_button_radio" <?php checked($jqlb_show_close_button,'0'); ?> value="0">Hide</label>
                    </td>
                </tr>
                 <tr>
                    <td>     
                    	Close button max height:<span class='pro_subtitle_span'>Pro feature!</span> <span title="Type here close button max height." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_close_image_max_heght" id="jqlb_close_image_max_heght" value="<?php echo $jqlb_close_image_max_heght; ?>"><small>(px)</small>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Close button image title tag:<span class='pro_subtitle_span'>Pro feature!</span>  <span title="Type here close button image title tag." class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_close_image_title" id="jqlb_close_image_title" value="<?php echo $jqlb_close_image_title; ?>">
                    </td>
                </tr>
                 <tr>
                    <td>     
                    	Lightbox close button image:<span class='pro_subtitle_span'>Pro feature!</span><span title="Choose one, or upload your own image for close button." class="desription_class">?</span>
                    </td>
                   <td class="radio_input">  
                    <select onMouseDown="alert(text_of_upgrate_version); return false;" id="theme_for_close_image">
                       <option value="">Standart</option>
                       <option value="theme0">Theme1</option>
                       <option value="theme1">Theme2</option>
                       <option value="theme2">Theme3</option>
                       <option value="theme3">Theme4</option>
                       <option value="theme4">Theme5</option>
                        <option value="theme4">Theme6</option>
                   </select><small>or choose custom</small> <br /> <br />   
                    	 <div class="option_group">                            
                            <div style="display:inline-block; float:left;height: 60px;">
                            	<input class="upload-button button-secondary action" onMouseDown="alert(text_of_upgrate_version); return false;" type="button" value="Upload  Image"/>
                                <input type="text" class="upload" id="jqlb_image_for_close_lightbox" name="jqlb_image_for_close_lightbox" size="15" value="<?php echo $jqlb_image_for_close_lightbox ?>"/>                                                                  
                            </div>
                             <span style="height:60px;display: inline-block;">
                            <img src="<?php echo $jqlb_image_for_close_lightbox ?>" style="max-width:60px; max-height:60px;" />
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Keyboard navigation:<span class='pro_subtitle_span'>Pro feature!</span> <span title="With this feature users also can change images with keyboard." class="desription_class">?</span>
                    </td>
                   <td class="radio_input">     
                    	<label  onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_keyboard_navigation_radio" checked='checked' value="1">Enable</label>
                        <label  onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio" onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_keyboard_navigation_radio" value="0">Disable</label>

                    </td>
                </tr>                        
                <tr>
                    <td>     
                    	Fix position for lightbox:<span class='pro_subtitle_span'>Pro feature!</span><span title=" That's mean your lightbox shouldn't change position when users scroll up or down." class="desription_class">?</span>
                    </td>
                   <td class="radio_input">     
                    	<label  onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio"  onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_popup_size_fix_radio" value="1">Fix</label>
                        <label  onMouseDown="alert(text_of_upgrate_version); return false;"><input type="radio"  onMouseDown="alert(text_of_upgrate_version); return false;" name="jqlb_popup_size_fix_radio" checked="checked" value="0">Normal</label>

                    </td>
                </tr>             
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" width="100%"><button type="button" id="save_button_general" class="save_button button button-primary"><span class="save_button_span">Save Settings</span> <span class="saving_in_progress"> </span><span class="sucsses_save"> </span><span class="error_in_saving"> </span></button></th>
                </tr>
            </tfoot>
		</table>
         <?php wp_nonce_field('wp_lightbox_2_design_settings_page','wp_lightbox_2_design_settings_page'); ?>
	</div><br /><br /><span class="error_massage"></span>
   
		<script>
		
			text_of_upgrate_version="If you want to use this feature upgrade to Wp Lightbox 2 Pro";
		
		jQuery(document).ready(function(e) {
			jQuery('.upload-button').click(function () {
				
					window.parent.uploadID = jQuery(this).next('input');
					window.parent.upimageID = jQuery(this).parent().parent().find('img');
					/*grab the specific input*/
					formfield = jQuery('.upload').attr('name');
					tb_show('', 'media-upload.php?type=image&height=640&width=1000&TB_iframe=true');
					return false;
				});
				window.send_to_editor = function (html) {
					imgurl = jQuery('img', html).attr('src');
					window.parent.uploadID.val(imgurl);
					window.parent.upimageID.attr('src',imgurl);
					/*assign the value to the input*/
					tb_remove();
				};	
				jQuery('#theme_for_next_previus').change(function(){
					
					var next_button_link='next.gif';
					if(jQuery(this).val()!='')
						next_button_link=jQuery(this).val()+'/next.png';
						
					var previous_button_link='prev.gif';
					if(jQuery(this).val()!='')
						previous_button_link=jQuery(this).val()+'/prev.png';
						
					jQuery(this).parent().find('.next_button .upload').val('<?php echo $this->plugin_url; ?>styles/images/'+next_button_link);
					jQuery(this).parent().find('.previous_button .upload').val('<?php echo $this->plugin_url; ?>styles/images/'+previous_button_link);
					jQuery(this).parent().find('.next_button img').attr('src','<?php echo $this->plugin_url; ?>styles/images/'+next_button_link);
					jQuery(this).parent().find('.previous_button img').attr('src','<?php echo $this->plugin_url; ?>styles/images/'+previous_button_link);
				});
				jQuery('#theme_for_close_image').change(function(){
					
					var close_button_link='closelabel.gif';
					if(jQuery(this).val()!='')
						close_button_link=jQuery(this).val()+'/closelabel.png';		
				
					jQuery(this).parent().find('.option_group .upload').val('<?php echo $this->plugin_url; ?>styles/images/'+close_button_link);
					jQuery(this).parent().find('.option_group img').attr('src','<?php echo $this->plugin_url; ?>styles/images/'+close_button_link);
				})	
				
				
			
			jQuery( "#jqlb_overlay_opacity_div" ).slider({
				range: "min",
				value: "<?php echo ($jqlb_overlay_opacity)?$jqlb_overlay_opacity:'100';  ?>",
				min: 0,
				max: 100,
				slide: function( event, ui ) {
					jQuery( "#jqlb_overlay_opacity" ).val( ui.value);
					jQuery( "#jqlb_overlay_opacity_span" ).html( ui.value+'%' );
				}
			});
			jQuery( "#jqlb_overlay_opacity_span" ).html( '<?php echo ($jqlb_overlay_opacity)?$jqlb_overlay_opacity:'100';  ?>%' );
			jQuery( "#jqlb_image_info_background_transparency_div" ).slider({
				range: "min",
				value: "<?php echo ($jqlb_image_info_background_transparency)?$jqlb_image_info_background_transparency:'100';  ?>",
				min: 0,
				max: 100,
				slide: function( event, ui ) {
					return false;
				}
			});
			jQuery( "#jqlb_image_info_background_transparency_span" ).html( '<?php echo ($jqlb_image_info_background_transparency)?$jqlb_image_info_background_transparency:'100';  ?>%' );
			
			jQuery( "#jqlb_overlay_color" ).wpColorPicker();
			jQuery( "#jqlb_border_color" ).wpColorPicker();
			jQuery( "#jqlb_image_info_text_color" ).wpColorPicker();
			jQuery( "#jqlb_image_info_bg_color" ).wpColorPicker();
			
			jQuery('#save_button_general').click(function(){
				
				jQuery('#save_button_general').addClass('padding_loading');
				jQuery("#save_button_general").prop('disabled', true);
				jQuery('.saving_in_progress').css('display','inline-block');
				generete_checkbox('parametr_chechbox');					
				generete_radio_input('radio_input');
				jQuery.ajax({
					type:'POST',
					url: "<?php echo admin_url( 'admin-ajax.php?action=save_in_databese_lightbox2_design' ); ?>",
					data: {wp_lightbox_2_design_settings_page:jQuery('#wp_lightbox_2_design_settings_page').val()<?php foreach($initial_values as $key => $value){echo ','.$key.':jQuery("#'.$key.'").val()';} ?>},
				}).done(function(date) {
					if(date=='sax_normala'){
					jQuery('.saving_in_progress').css('display','none');
					jQuery('.sucsses_save').css('display','inline-block');
					setTimeout(function(){jQuery('.sucsses_save').css('display','none');jQuery('#save_button_general').removeClass('padding_loading');jQuery("#save_button_general").prop('disabled', false);},2500);
					}else{
						jQuery('.saving_in_progress').css('display','none');
						jQuery('.error_in_saving').css('display','inline-block');
						jQuery('.error_massage').css('display','inline-block');
						jQuery('.error_massage').html(date);
						setTimeout(function(){jQuery('#save_button_general').removeClass('padding_loading');jQuery("#save_button_general").prop('disabled', false);},5000);
					}
			
				});
			});
			function generete_radio_input(radio_class){
				jQuery('.'+radio_class).each(function(index, element) {
				   jQuery(this).find('input[type=hidden]').val(jQuery(this).find('input[type=radio]:checked').val())
				});
			}
			function generete_checkbox(checkbox_class){
				jQuery('.'+checkbox_class).each(function(index, element) {
					if(jQuery(this).find('input[type=checkbox]').prop('checked'))
						jQuery(this).find('input[type=hidden]').val(jQuery(this).find('input[type=checkbox]:checked').val());
					else
						jQuery(this).find('input[type=hidden]').val(0);
				});
			}

		});
			
        </script>

		<?php
	}	
	
}


 ?>