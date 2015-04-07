<div class="metabox-holder">
<div class="meta-box-sortables">
	<div class="dcwp postbox">
		<h3 class="hndle"><span>Saved Streams</span><?php echo $help; ?></h3>
		<div class="inside">
			<div class="dcwss-help-text">
				<h3>Help<?php echo $close; ?></h3>
				<h4>Saved Streams</h4>
				<p>This section lists all of your previously saved social network streams.</p>
				<h4>Edit Stream</h4>
				<p>Click the "edit" icon to display the stream settings in the lower box. Change the stream options and click the "Edit Stream" button to save the new settings.</p>
				<h4>Delete Stream</h4>
				<p>Click the "delete" icon to delete the social stream - this will remove the stream completely from the WordPress system.</p>
				<h4>Social Wall Shortcode</h4>
				<p>Use the social wall shortcode to add a network wall to your page. The default number of columns for a wall is 4 - if you want to change the number of columns add the "cols" option to the shortcode - e.g. [dc_social_wall id="XXX" cols="3"].</p>
			</div>
			
			<div id="dc-streams">
				<?php
					$id = isset($_GET['stream']) ? $_GET['stream'] : '' ;
					echo dcwss_streams($id);
					$results = Array();
					$results = dcwss_get_stream($id);
					
					if(isset($_GET['stream'])){ ?>
					<p></p>
					<a href="options-general.php?page=social-stream" class="button-secondary">New Stream</a>
					<?php } ?>
			</div>
			</div></div></div></div>
			
			<?php $header = !isset($_GET['stream']) ? 'Create New Stream' : 'Edit Stream' ; ?>
			
<div class="metabox-holder">
<div class="meta-box-sortables">
	<div class="dcwp postbox">
		<h3 class="hndle"><span><?php echo $header; ?></span><?php echo $help; ?></h3>
		<div class="inside">
					  
			<div class="dcwss-help-text">
				<h3>Help<?php echo $close; ?></h3>
				<h4>Stream Name</h4>
				<p>Enter a descriptive name for the social network stream - this is for reference only.</p>
				<h4>Social Networks</h4>
				<p>This section allows you to set up the social networks that you want to include in the social stream. To add a social network enter at least one valid ID in the "ID" field. Separate mulitple ID's with a comma.</p>
				<p><strong>Link Text</strong> - enter the text to be used to link the feed item. For multiple feeds separate the link text for each feed with a comma.</p>
				<h4>Content to include in stream output</h4>
				<p>Select the content blocks that you want to include in each feed item - the type of content blocks available may vary between social networks.</p>
				<h4>Data feed to be shown</h4>
				<p>Social networks that have multiple feeds available will have each feed listed in the network tab. Select the feeds to be included using the "on/off" switch.</p>
				<p>Note: Save the stream settings by clicking the "update stream" or "create new stream" buttons when complete.</p>
				<h4>Remove Posts</h4>
				<p>Enter a list of URLs (separated by a comma) for any posts that you want to exclude from the stream.</p>
			</div>
			<form method="get" id="dcwss_streams" class="dcwp-form" action="options-general.php?page=social-stream">
			<div id="stream-container">
			<?php $name = isset($results['name']) ? $results['name'] : '' ; ?>
				<p><label style="font-weight:bold;margin-right: 6px;">Name: </label><input id="dc-stream-input" name="name" class="text-input" type="text" value="<?php echo $name; ?>" /></p>
				
				<input type="hidden" id="stream-id" name="stream-id" value="<?php echo $_GET['stream']; ?>" />

			<ul id="dcwss-sortable">
			
			<?php
				$css = '';
				
				foreach($networks as $function=>$v){
					
					if($function != ''){

						$css .= '.dcwss-sortable-li.li-'.$function.' a:hover, .dcwss-sortable-li.li-'.$function.'.active a {background:'.$colors[$function].';}';
					?>
						<li rel="<?php echo $function; ?>" class="dcwss-sortable-li li-<?php echo $function; ?>">
							<?php
								$src = dc_jqsocialstream::get_plugin_directory().'/images/dcwss-dark/'.$function.'.png';
								echo '<a href="#" class="icon-bg"><img src="'.$src.'" alt="" id="img-icon-'.$function.'" /></a>';
							?>
						</li>
					<?php
					}
				}
			?>
			</ul>
			<style><?php echo $css; ?></style>
			<div id="network-tab-container">
			<?php
			foreach($networks as $function=>$v){
					
					if($function != ''){
					
						$src = dc_jqsocialstream::get_plugin_directory().'/images/dcwss-dark/'.$function.'.png';
						$h4 = '<img src="'.$src.'" alt="" style="background:'.$colors[$function].';" />';
						
						?>
						<div class="network-tab" rel="<?php echo $function; ?>">
							<div class="network-options">
								<ul>
								<?php
									$list = '';
									
									foreach($defaults[$function] as $k=>$v){
										$label = $k == 'intro' ? 'Link Text' : $k ;
										$label = $k == 'search' ? 'Search Text' : $k ;
										$idv = isset($results['feeds_'.$function.'_'.$k]) ? $results['feeds_'.$function.'_'.$k] : $v ;
										
										if($k == 'out'){
										
											$list .= '<span class="help-text help-title">'.$helptext[$function][$k].'</span>';
											$section = explode(',', $defaults[$function]['out']);
											foreach($section as $s){
											
												$def = strlen(strstr($defaults[$function][$k],$s)) > 0 ? 'true' : 'false' ;
												$def = $function.$s == 'twitterthumb' ? 'false' : $def ;
												$idv = isset($results['feeds_'.$function.'_'.$k.'_'.$s]) ? $results['feeds_'.$function.'_'.$k.'_'.$s] : $def ;
												$list .= $s != '' ? '<li class="dcwss-out"><label>'.$s.':</label>'.dcwss_switch($idv, 'feeds_'.$function.'_'.$k.'_'.$s).'<span class="help-text help-float">'.$helptext[$function]['out-'.$s].'</span></li>': '' ;
												
											}
										} else if($k == 'feed'){
										
											$list .= '<span class="help-text help-title">'.$helptext[$function][$k].'</span>';
											$section = explode(',', $defaults[$function]['feed']);
											foreach($section as $s){
											
												$def = strlen(strstr($defaults[$function][$k],$s)) > 0 ? 'true' : 'false' ;
												$idv = isset($results['feeds_'.$function.'_'.$k.'_'.$s]) ? $results['feeds_'.$function.'_'.$k.'_'.$s] : $def ;
												$list .= $s != '' ? '<li class="dcwss-feeds"><label>'.$s.':</label>'.dcwss_switch($idv, 'feeds_'.$function.'_'.$k.'_'.$s).'<span class="help-text">'.$helptext[$function]['out-'.$s].'</span></li>': '' ;
												
											}
										} else {
										
											$e = '<input id="dcwss_'.$function.'_'.$k.'" name="feeds_'.$function.'_'.$k.'" class="text-input" type="text" value="'.$idv.'" />';
											
											if($function == 'vimeo' && $k == 'thumb'){
												$o = Array('small' => 'Small 100px wide', 'medium' => 'Medium 200px wide', 'large' => 'Large 640px wide');
												$e = dcwss_stream_select('feeds_'.$function.'_'.$k, $o, $idv);
											} else if ($function.$k == 'facebooktext' || $function.$k == 'rsstext'){
												$o = Array('contentSnippet' => 'Snippet', 'content' => 'Complete Text');
												$e = dcwss_stream_select('feeds_'.$function.'_'.$k, $o, $idv);
											} else if($function == 'facebook' && $k == 'image_width'){
												$o = Array('6' => 'Thumb - 180px', '5' => 'Small - 320px', '4' => 'Medium - 480px', '3' => 'Large - 600px');
												$e = dcwss_stream_select('feeds_'.$function.'_'.$k, $o, $idv);
											} else if ($function == 'facebook' && $k == 'thumb'){
												$e = dcwss_switch($idv, 'feeds_'.$function.'_'.$k);
											} else if($function == 'youtube' && $k == 'thumb'){
												$o = Array('default' => '120px x 90px', '0' => '480px x 360px');
												$e = dcwss_stream_select('feeds_'.$function.'_'.$k, $o, $idv);
											} else if($function == 'twitter' && $k == 'images'){
												$o = Array('' => 'None', 'thumb' => 'Thumb - w: 150px h: 150px', 'small' => 'Small - w: 340px h 150px', 'medium' => 'Medium - w: 600px h: 264px', 'large' => 'Large - w: 786px h: 346px');
												$e = dcwss_stream_select('feeds_'.$function.'_'.$k, $o, $idv);
											} else if ($function == 'twitter' && $k == 'retweets'){
												$e = dcwss_switch($idv, 'feeds_'.$function.'_'.$k);
											} else if ($function == 'twitter' && $k == 'replies'){
												$e = dcwss_switch($idv, 'feeds_'.$function.'_'.$k);
											}
											
											if($function == 'twitter' && $k == 'thumb'){
												$list .= '<input id="dcwss_'.$function.'_'.$k.'" name="feeds_'.$function.'_'.$k.'" type="hidden" value="true" />';
											} else {
												$list .= '<li><label>'.$label.':</label>'.$e.'<span class="help-text">'.$helptext[$function][$k].'</span></li>';
											}
										}
									}
									echo $list;
								?>
								</ul>
							</div>
						</div>
				<?php 
				}
			}
			?>
			</div>
			
			<?php $remove = isset($results['remove']) ? $results['remove'] : '' ; ?>
				<p><label style="font-weight:bold;display:block;margin: 0 6px 4px 0;">Remove Posts (enter the URL's of any specific posts you wish to remove - separate each URL with a comma): </label><input id="dc-stream-input" style="width: 100%;" name="remove" class="text-input" type="text" value="<?php echo $remove; ?>" /></p>
			
			<?php if(isset($_GET['stream'])){ ?>
					<a href="#" class="dc-stream-add add button-secondary">Save As New Stream</a>
					<a href="#" class="dc-stream-edit add button-primary">Update Stream</a> 
					
				<?php } else { ?>
					<a href="#" class="dc-stream-add add button-primary">Create New Stream</a>
				<?php } ?>
				<span id="dcwss-response"></span>
			</div>
			
			</form>
			<div class="clear"></div>
			</div></div></div></div>