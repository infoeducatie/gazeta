<?php
/* ------------------------------------------------------------------------- *
 *  Custom post options
 *	___________________
 *
 *	This will help us display two meta options when you write a post:
 *	- Mark this post as featured
 *	- Display post thumbnail in single view
/* ------------------------------------------------------------------------- */



/*  Add a metabox to display options
/* ------------------------------------ */
add_action('admin_menu', 'ac_options_box');
function ac_options_box() {
	add_meta_box('ac_post_side_meta', 'Post Options:', 'ac_post_options', 'post', 'side', 'high');
}



/*  Metabox output
/* ------------------------------------ */
function ac_post_options() {
	global $post;
	?>
    <form>
		<p>
			<input type="checkbox" class="checkbox" name="ac_featured_article" value="1" <?php checked(get_post_meta($post->ID, 'ac_featured_article', true), 1 ); ?> /><label for="ac_featured_article"><?php _e('Mark this post as featured', 'acosmin') ?></label>
		</p>
        
        <p>
			<input type="checkbox" class="checkbox" name="ac_show_post_thumbnail" value="1" <?php checked(get_post_meta($post->ID, 'ac_show_post_thumbnail', true), 1 ); ?> /><label for="ac_show_post_thumbnail"><?php _e('Post thumbnail in single view', 'acosmin') ?></label>
		</p>
    </form>
    
    <?php
	}



/*  Save meta information
/* ------------------------------------ */	
add_action('save_post', 'save_added_options');
function save_added_options($postID){
	global $post;

	if($parent_id = wp_is_post_revision($postID))
	{
	  $postID = $parent_id;
	}
	
	if ( isset($_POST['save']) || isset($_POST['publish']) ) {
		update_custom_meta($postID, isset($_POST['ac_featured_article']), 'ac_featured_article');
		update_custom_meta($postID, isset($_POST['ac_show_post_thumbnail']), 'ac_show_post_thumbnail');
	}
	
}



/*  Update meta information
/* ------------------------------------ */
function update_custom_meta($postID, $newvalue, $field_name) {
	if(!get_post_meta($postID, $field_name)){
		add_post_meta($postID, $field_name, $newvalue);
	}else{
		update_post_meta($postID, $field_name, $newvalue);
	}
}
?>