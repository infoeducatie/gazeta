<?php

class Footer_Trademarks_Admin extends Footer_Putter_Admin{

	public function init() {
		add_action('admin_menu',array($this, 'admin_menu'));
	}

	public function admin_menu() {
		$this->screen_id = add_submenu_page($this->get_parent_slug(), __('Footer Trademarks'), __('Footer Trademarks'), 'manage_options', 
			$this->get_slug(), array($this,'page_content'));
		add_action('load-'.$this->get_screen_id(), array($this, 'load_page'));			
	}

	public function page_content() {
 		$title = $this->admin_heading('Footer Trademarks', FOOTER_PUTTER_ICON);				
		$this->print_admin_form_with_sidebar_start($title); 
		do_meta_boxes($this->get_screen_id(), 'side', null); 
		$this->print_admin_form_with_sidebar_middle(); 
		do_meta_boxes($this->get_screen_id(), 'normal', null); 
		$this->print_admin_form_end(__CLASS__);
	} 	

	public function load_page() {
		$this->add_tooltip_support();
		add_action ('admin_enqueue_scripts',array($this, 'enqueue_admin_styles'));
		add_action ('admin_enqueue_scripts',array($this, 'enqueue_postbox_scripts'));	
		$this->add_meta_box('intro', 'Instructions',  'intro_panel');
		$this->add_meta_box('tips', 'Tips',  'tips_panel');
		$this->add_meta_box('screenshots','Screenshots',  'screenshots_panel');
		$this->add_meta_box('news', 'DIY Webmastery News', 'news_panel',null, 'side');
	}	

	public function intro_panel() {
		$linkcat = admin_url('edit-tags.php?taxonomy=link_category');
		$addlink = admin_url('link-add.php');
		$widgets = admin_url('widgets.php');
		print <<< INTRO
<p class="attention">There are no settings on this page.</p>
<p class="attention">However, links are provided to where you set up trademarks or other symbols you want to appear in the footer.</p>

<p class="bigger">Firstly go to the <a href="{$linkcat}">Link Categories</a> and set up a link category called <i>Trust Marks</i> or something similar.</p>
<p class="bigger">Next go to the <a href="{$addlink}">Add Link</a> and add a link for each trademark
specifying the Image URL, and optionally the link URL and of course adding each link to your chosen link category. 
<p class="bigger">Finally go to the <a href="{$widgets}">Appearance | Widgets</a> and drag a trademark widget into the custom footer widget
area and select <i>Trust Marks</i> as the link category.</p>
INTRO;
	}  

	public function tips_panel() {
		print <<< TIPS
<h4>Image File Size</h4>
<p>The plugin uses the images "as is" so you need to provide suitably sized images. </p>
<p>For a consistent layout make sure all images are the same height. A typical height will be of the order of 50px to 100px depending on how prominantly you want them to feature.</p>
<h4>Image File Type</h4>
<p>If your image are JPGs files on a white background, and your footer has a white background then using JPGs will be fine. Otherwise your footer look better if you use PNG files on a transparent background</p>
TIPS;
	}  
	 
	public function screenshots_panel() {
		$img1 = plugins_url('images/add-link-category.jpg',dirname(__FILE__));		
		$img2 = plugins_url('images/add-link.jpg',dirname(__FILE__));
		print <<< SCREENSHOTS
<p>Below are annotated screenshots of creating the link category and adding a link .
<h4>Add A Link Category</h4>
<p><img src="{$img1}" alt="Screenshot of adding a trademark link category" /></p>
<h4>Add A Link</h4>
<p><img src="{$img2}" alt="Screenshot of adding a trademark link " /></p>
SCREENSHOTS;
	}  

 	function news_panel($post,$metabox){	
		Footer_Putter_Feed_Widget::display_feeds();
	}

}