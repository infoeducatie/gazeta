<?php

// BASE Class

class DpSocialTimeline {
	
	var $nonce;
	var $is_admin = false;
	var $id_timeline = null;
	var $customData = null;
	var $timeline_obj;
	var $table;
	
	function DpSocialTimeline( $is_admin = false, $id_timeline = null, $items = null, $custom = null, $showFilter = null, $showLayout = null, $showTime = null, $showSocialIcons = null, $addColorbox = null, $layoutMode = null, $skin = null, $itemWidth = null, $total = null, $share= null ) 
	{
		global $table_prefix;
		
		$customData = array();
		$this->table = $table_prefix.DP_SOCIALTIMELINE_TABLE;
		$this->timeline_obj = (object)array();
		$this->timeline_obj->timelineItemWidth = "";
		$this->timeline_obj->columnsItemWidth = "";
		$this->timeline_obj->oneColumnItemWidth = "";
		$this->timeline_obj->lang_week = "";
		$this->timeline_obj->lang_weeks = "";
		$this->timeline_obj->lang_day = "";
		$this->timeline_obj->lang_days = "";
		$this->timeline_obj->lang_hour = "";
		$this->timeline_obj->lang_hours = "";
		$this->timeline_obj->lang_minute = "";
		$this->timeline_obj->lang_minutes = "";
		$this->timeline_obj->lang_about = "";
		$this->timeline_obj->lang_ago = "";
		$this->timeline_obj->lang_less = "";

		if($is_admin) { $this->is_admin = true; }
		if(is_numeric($id_timeline)) { 
			$this->setTimeline($id_timeline); 
		} else {
			$customData['items'] = $items;
			$customData['custom'] = $custom;
			$customData['showFilter'] = $showFilter;
			$customData['showLayout'] = $showLayout;
			$customData['showTime'] = $showTime;
			$customData['share'] = $share;
			$customData['showSocialIcons'] = $showSocialIcons;
			$customData['addColorbox'] = $addColorbox;
			$customData['layoutMode'] = $layoutMode;
			$customData['skin'] = $skin;
			$customData['itemWidth'] = $itemWidth;
			$customData['total'] = $total;
			$this->setTimelineCustomData($customData);
		}
		$this->nonce = rand();


    }
	
	function setTimeline($id) {
		$this->id_timeline = $id;	
		
		$this->getTimelineData();
	}
	
	function setTimelineCustomData($customData) {
		$items = '['.str_replace("'", '"', $customData['items']).']';
		$custom = '['.str_replace("'", '"', $customData['custom']).']';
		$this->customData = 1;	
		
		@$this->timeline_obj->active = 1;
		$this->timeline_obj->showFilter = (is_numeric($customData['showFilter']) ? $customData['showFilter'] : 1);
		$this->timeline_obj->showTime = (is_numeric($customData['showTime']) ? $customData['showTime'] : 1);
		$this->timeline_obj->share = (is_numeric($customData['share']) ? $customData['share'] : 1);
		$this->timeline_obj->showLayout = (is_numeric($customData['showLayout']) ? $customData['showLayout'] : 1);
		$this->timeline_obj->showSocialIcons = (is_numeric($customData['showSocialIcons']) ? $customData['showSocialIcons'] : 1);
		$this->timeline_obj->addColorbox = (is_numeric($customData['addColorbox']) ? $customData['addColorbox'] : 1);
		$this->timeline_obj->layoutMode = (isset($customData['layoutMode']) && $customData['layoutMode'] != "" ? $customData['layoutMode'] : "timeline");
		$this->timeline_obj->skin = (isset($customData['skin']) && $customData['skin'] != "" ? $customData['skin'] : "light");
		$this->timeline_obj->total = (is_numeric($customData['total']) ? $customData['total'] : 10);
		$this->timeline_obj->itemWidth = (!empty($customData['itemWidth']) ? $customData['itemWidth'] : 200);
		$this->timeline_obj->items = $items;
		$this->timeline_obj->custom = $custom;
	}
	
	function setTimelinePreview($data) {
		$this->id_timeline = 0;	
		$this->timeline_obj = (object)$data;
	}
	
	function getNonce() {
		if(!is_numeric($this->id_timeline) && !isset($this->customData)) { return false; }
		
		return $this->nonce;
	}
	
	function getTimelineData() {
		global $wpdb;
		
		if(!is_numeric($this->id_timeline) && !isset($this->customData)) { return false; }
		
		$querystr = "
		SELECT *
		FROM ".$this->table ."
		WHERE id = ".$this->id_timeline;
		
		$timeline_obj = $wpdb->get_results($querystr, OBJECT);
		$timeline_obj = $timeline_obj[0];	

		$this->timeline_obj = $timeline_obj;
	}
	
	function addScripts( $print = false ) 
	{
		
		$script='<script type="text/javascript">
		// <![CDATA[
		jQuery(document).ready(function() {
			
			jQuery("#dp_timeline_id'.$this->nonce.'").dpSocialTimeline({
				';
			if(is_numeric($this->id_timeline) || isset($this->customData)) {
				if(function_exists('mb_convert_encoding')) {
					$this->timeline_obj->items = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'dpSocialTimeline_replace_unicode_escape_sequence', str_replace('u0', '\u0', $this->timeline_obj->items));
				}
				
				$timeline_feeds = json_decode($this->timeline_obj->items);
				$timeline_feeds = dpSocialTimeline_stripslashesFull($timeline_feeds);

				if(is_array($timeline_feeds)) {
					$feeds = array();
					$feed_html = '';
					foreach($timeline_feeds as $key) {
						if($key->name == 'twitter') { 
							$tw_string = "";
							$twitter_arr = explode(",", $key->data);
							foreach($twitter_arr as $twitter) {
								if(trim($twitter) == "") { continue; }
								if($tw_string != "") { $tw_string .= ","; }
								$tw_string .= dpSocialTimeline_plugin_url('lib/user_timeline.php?screen_name='.trim($twitter).'&include_rts='.($key->include_retweets ? 'true' : 'false'));
							}
							$key->data = $tw_string; 
						}
						if($key->name == 'twitter_hash') { 
							$tw_string = "";
							$twitter_arr = explode(",", $key->data);
							foreach($twitter_arr as $twitter) {
								if(trim($twitter) == "") { continue; }
								if($tw_string != "") { $tw_string .= ","; }
								$tw_string .= dpSocialTimeline_plugin_url('lib/search.php?q=%23'.trim($twitter));
							}
							$key->data = $tw_string; 
						}
						if($key->name == 'facebook_page') { 
							$fb_string = "";
							$fb_arr = explode(",", $key->data);
							foreach($fb_arr as $fb) {
								if(trim($fb) == "") { continue; }
								if($fb_string != "") { $fb_string .= ","; }
								$fb_string .= dpSocialTimeline_plugin_url('lib/facebook_page.php?page_id='.trim($fb));
							}
							$key->data = $fb_string; 
						}
						if($key->name == 'foursquare') { 
							$fq_string = "";
							$foursquare_arr = explode(",", $key->data);
							foreach($foursquare_arr as $foursquare) {
								if(trim($foursquare) == "") { continue; }
								if($fq_string != "") { $fq_string .= ","; }
								$fq_string .= dpSocialTimeline_plugin_url('lib/foursquare.php?url='.urlencode(trim($foursquare)));
							}
							$key->data = $fq_string; 
						}
						if($key->name == 'instagram') { 
							$instagram_string = "";
							$instagram_arr = explode(",", $key->data);
							foreach($instagram_arr as $instagram) {
								if(trim($instagram) == "") { continue; }
								if($instagram_string != "") { $instagram_string .= ","; }
								$instagram_string .= dpSocialTimeline_plugin_url('instagram_auth/instagram.php?username='.trim($instagram));
							}
							$key->data = $instagram_string; 
						}
						if($key->name == 'instagram_hash') { 
							$instagram_hash_string = "";
							$instagram_hash_arr = explode(",", $key->data);
							foreach($instagram_hash_arr as $instagram_hash) {
								if(trim($instagram_hash) == "") { continue; }
								if($instagram_hash_string != "") { $instagram_hash_string .= ","; }
								$instagram_hash_string .= dpSocialTimeline_plugin_url('instagram_auth/instagram_hash.php?tag='.trim($instagram_hash));
							}
							$key->data = $instagram_hash_string; 
						}
						if($key->name == 'google') { 
							$google_string = "";
							$google_arr = explode(",", $key->data);
							foreach($google_arr as $google) {
								if(trim($google) == "") { continue; }
								if($google_string != "") { $google_string .= ","; }
								$google_string .= (substr($google, 0, 4) == 'http' ? $google : 'http://'.$google);
							}
							$key->data = $google_string; 
						}
						$feeds[$key->name][] = array("data" => $key->data, "limit" => $key->limit);
					}
					
					foreach($feeds as $key=>$value) {
						$data = '';
						$limit = '';
						if($key == 'Facebook page') { $key = 'facebook_page'; }
						foreach( $value as $k ) {
  							$data .= $k['data'].',';
							
							if(!is_numeric($k['limit'])) { $k['limit'] = 0; }
							$limit .= $k['limit'].',';
						}
						$data = substr($data, 0, -1);
						$limit = substr($limit, 0, -1);
						if($data == "") { continue; }
						$feed_html .='
						"'.$key.'": {data: "'.$data.'", limit: "'.$limit.'"},'; 
					}
					$feed_html = substr($feed_html, 0, -1);
				}
				
				$timeline_custom = json_decode($this->timeline_obj->custom);
				if(is_array($timeline_custom)) {
					$custom_html = '';
					foreach($timeline_custom as $key) {
						$custom_html .='
						"'.$key->name.'": {name: "'.$key->name.'", url: "'.$key->url.'", icon: "'.$key->icon.'"'.( is_numeric($key->limit) ? ', limit: "'.$key->limit.'"' : '' ).'},'; 
					}
					$custom_html = substr($custom_html, 0, -1);
				}

				$script .= '
				feeds: 
				{
					'.$feed_html.'
				},
				custom: 
				{
					'.$custom_html.'
				},
				layoutMode: "'.$this->timeline_obj->layoutMode.'",
				addColorbox: '.(is_numeric($this->timeline_obj->addColorbox) ? $this->timeline_obj->addColorbox : 0).',
				showSocialIcons: '.(is_numeric($this->timeline_obj->showSocialIcons) ? $this->timeline_obj->showSocialIcons : 0).',
				cache: '.(is_numeric($this->timeline_obj->cache) ? $this->timeline_obj->cache : 0).',
				cacheTime: '.(is_numeric($this->timeline_obj->cacheTime) ? $this->timeline_obj->cacheTime : 900).',
				allowMultipleFilters: '.(is_numeric($this->timeline_obj->allowMultipleFilters) ? $this->timeline_obj->allowMultipleFilters : 0).',
				showFilter: '.(is_numeric($this->timeline_obj->showFilter) ? $this->timeline_obj->showFilter : 0).',
				showLayout: '.(is_numeric($this->timeline_obj->showLayout) ? $this->timeline_obj->showLayout : 0).',
				showTime: '.(is_numeric($this->timeline_obj->showTime) ? $this->timeline_obj->showTime : 0).',
				share: '.(is_numeric($this->timeline_obj->share) ? $this->timeline_obj->share : 0).',
				rtl: '.(is_numeric($this->timeline_obj->rtl) ? $this->timeline_obj->rtl : 0).',
				total: '.(is_numeric($this->timeline_obj->total) ? $this->timeline_obj->total : 10).',
				itemWidth: "'.(isset($this->timeline_obj->itemWidth) ? $this->timeline_obj->itemWidth : 200).'",
				timelineItemWidth: "'.(isset($this->timeline_obj->timelineItemWidth) ? $this->timeline_obj->timelineItemWidth : '').'",
				columnsItemWidth: "'.(isset($this->timeline_obj->columnsItemWidth) ? $this->timeline_obj->columnsItemWidth : '').'",
				oneColumnItemWidth: "'.(isset($this->timeline_obj->oneColumnItemWidth) ? $this->timeline_obj->oneColumnItemWidth : '').'",
				skin: "'.$this->timeline_obj->skin.'",
				
				lang_week: "'.($this->timeline_obj->lang_week != "" ? $this->timeline_obj->lang_week : "week").'",
				lang_weeks: "'.($this->timeline_obj->lang_weeks != "" ? $this->timeline_obj->lang_weeks : "weeks").'",
				lang_day: "'.($this->timeline_obj->lang_day != "" ? $this->timeline_obj->lang_day : "day").'",
				lang_days: "'.($this->timeline_obj->lang_days != "" ? $this->timeline_obj->lang_days : "days").'",
				lang_hour: "'.($this->timeline_obj->lang_hour != "" ? $this->timeline_obj->lang_hour : "hour").'",
				lang_hours: "'.($this->timeline_obj->lang_hours != "" ? $this->timeline_obj->lang_hours : "hours").'",
				lang_minute: "'.($this->timeline_obj->lang_minute != "" ? $this->timeline_obj->lang_minute : "minute").'",
				lang_minutes: "'.($this->timeline_obj->lang_minutes != "" ? $this->timeline_obj->lang_minutes : "minutes").'",
				lang_about: "'.($this->timeline_obj->lang_about != "" ? $this->timeline_obj->lang_about : "about").'",
				lang_ago: "'.($this->timeline_obj->lang_ago != "" ? $this->timeline_obj->lang_ago : "ago").'",
				lang_less: "'.($this->timeline_obj->lang_less != "" ? $this->timeline_obj->lang_less : "less than a minute ago").'",
				';
			}
			$script .= '
				nonce: "dp_timeline_id'.$this->nonce.'"
			});
			
		});
		
		//]]>
		</script>';
		
		if($print)
			echo $script;	
		else
			return $script;
		
	}
	
	function output( $print = false ) 
	{
		if(isset($this->timeline_obj->active) && !$this->timeline_obj->active && !$this->is_admin) { return; }
		$width = "";
		$html = "";
		
		if(isset($this->timeline_obj->width) && !$this->is_admin) { $width = 'style="margin: 0 auto; width: '.$this->timeline_obj->width.$this->timeline_obj->width_unity.' " '; }
		
		if($this->is_admin) {
			$html .= '
			<div class="dpSocialTimeline_ModalSlider dpSocialTimeline_HideModal">';
		}
		
		$html .= '<div '.$width.' id="dp_timeline_id'.$this->nonce.'"></div>';
		
		if($this->is_admin) {
			$html .= '
			</div>';
		}
		
		if($print)
			echo $html;	
		else
			return $html;
		
	}
	
}
?>