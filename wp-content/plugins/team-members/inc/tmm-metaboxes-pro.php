<?php 

/* Hooks the metabox. */
add_action('admin_init', 'dmb_tmm_add_pro', 1);
function dmb_tmm_add_pro() {
	add_meta_box( 
		'tmm_pro', 
		'<span class="dashicons dashicons-unlock" style="color:#8ea93d;"></span> Get PRO&nbsp;', 
		'dmb_tmm_pro_display', // Below
		'tmm', 
		'side', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_tmm_pro_display() { ?>

	<div class="dmb_side_block">
		<div class="dmb_side_block_title">
			Hover photos
		</div>
		Add a second photo that will show when hovering over the first one.
	</div>

	<div class="dmb_side_block">
		<div class="dmb_side_block_title">
			Complementary box
		</div>
		Add complementary info in a hover box.
	</div>

	<div class="dmb_side_block">
		<div class="dmb_side_block_title">
			Full-width photos and more...
		</div>
		... Border thickness, members' height equalizing, photo positions, per member color, photo filters...
	</div>

	<a class="dmb_big_button_primary dmb_see_pro" target="_blank" href="https://wpdarko.com/items/team-members-pro">
		Check out PRO features&nbsp;
	</a>

	<span style="display:block;margin-top:15px; font-size:12px; color:#0073AA; line-height:20px;">
		<span class="dashicons dashicons-cart"></span> Discount code 
		<strong>7884661</strong> (10% OFF)
	</span>

<?php } ?>