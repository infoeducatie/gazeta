<?php 

/* Handles team shortcodes. */
add_shortcode("tmm", "tmm_sc");
function tmm_sc($atts) {

  global $post;

  /* Gets table slug (post name). */
  $all_attr = shortcode_atts( array( "name" => '' ), $atts );
  $name = $all_attr['name'];

  /* Gets the team. */
  $args = array('post_type' => 'tmm', 'name' => $name);
  $custom_posts = get_posts($args);

  foreach($custom_posts as $post) : setup_postdata($post);

    $members = get_post_meta( get_the_id(), '_tmm_head', true );
    $tmm_columns = get_post_meta( $post->ID, '_tmm_columns', true );
    $tmm_color = get_post_meta( $post->ID, '_tmm_color', true );
    $tmm_bio_alignment = get_post_meta( $post->ID, '_tmm_bio_alignment', true );

    /* Checks if member links open in new window. */
    $tmm_piclink_beh = get_post_meta( $post->ID, '_tmm_piclink_beh', true );
    ($tmm_piclink_beh == 'new' ? $tmm_plb = 'target="_blank"' : $tmm_plb = '');

    /* Checks if forcing original fonts. */
    $original_font = get_post_meta( $post->ID, '_tmm_original_font', true );
    ($original_font && $original_font != 'no' ? $ori_f = 'tmm_ori_f' : $ori_f = '');

    $team_view = '';
    $team_view .= '<div class="tmm tmm_'.$name.'">';
      $team_view .= '<div class="tmm_'.$tmm_columns.'_columns tmm_wrap '.$ori_f.'">';

        if (is_array($members) || is_object($members)) {
          foreach ($members as $key => $member) {
            
            /* Creates Team container. */
            if($key%2 == 0) {
              /* Checks if group of two (alignment). */
              $team_view .= '<span class="tmm_two_containers_tablet"></span>';
            }
            if($key%$tmm_columns == 0) {
              /* Checks if first div of group and closes. */
              if($key > 0) $team_view .= '</div><span class="tmm_columns_containers_desktop"></span>';
              $team_view .= '<div class="tmm_container">';
            }

            /* START member. */
            $team_view .= '<div class="tmm_member" style="border-top:'.$tmm_color.' solid 5px;">';

              /* Displays member photo. */
              if (!empty($member['_tmm_photo_url']))
                $team_view .= '<a '.$tmm_plb.' href="'.$member['_tmm_photo_url'].'" title="'.$member['_tmm_firstname'].' '.$member['_tmm_lastname'].'">';

                if (!empty($member['_tmm_photo']))
                  $team_view .= '<div class="tmm_photo tmm_phover_'.$name.'_'.$key.'" style="background: url('.$member['_tmm_photo'].'); margin-left:auto; margin-right:auto; background-size:cover !important;"></div>';

              if (!empty($member['_tmm_photo_url'])) 
                $team_view .= '</a>';

              /* Creates text block. */
              $team_view .= '<div class="tmm_textblock">';

                /* Displays names. */
                $team_view .= '<div class="tmm_names">';
                  if (!empty($member['_tmm_firstname']))
                    $team_view .= '<span class="tmm_fname">'.$member['_tmm_firstname'].'</span> ';
                  if (!empty($member['_tmm_lastname']))
                    $team_view .= '<span class="tmm_lname">'.$member['_tmm_lastname'].'</span>';
                $team_view .= '</div>';

                /* Displays jobs. */
                if (!empty($member['_tmm_job']))
                $team_view .= '<div class="tmm_job">'.$member['_tmm_job'].'</div>';

                /* Displays bios. */
                if (!empty($member['_tmm_desc']))
                $team_view .= '<div class="tmm_desc" style="text-align:'.$tmm_bio_alignment.'">'.do_shortcode($member['_tmm_desc']).'</div>';

                /* Creates social block. */
                $team_view .= '<div class="tmm_scblock">';

                  /* Displays social links. */
                  for ($i = 1; $i <= 3; $i++) {
                    if ($member['_tmm_sc_type'.$i] != 'nada') {
                      if ($member['_tmm_sc_type'.$i] == 'email') {
                        $team_view .= '<a class="tmm_sociallink" href="mailto:'.(!empty($member['_tmm_sc_url'.$i])?$member['_tmm_sc_url'.$i]:'').'" title="'.(!empty($member['_tmm_sc_title'.$i])?$member['_tmm_sc_title'.$i]:'').'"><img alt="'.(!empty($member['_tmm_sc_title'.$i])?$member['_tmm_sc_title'.$i]:'').'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type'.$i].'.png"/></a>';
                      } else {
                        $team_view .= '<a target="_blank" class="tmm_sociallink" href="'.(!empty($member['_tmm_sc_url'.$i])?$member['_tmm_sc_url'.$i]:'').'" title="'.(!empty($member['_tmm_sc_title'.$i])?$member['_tmm_sc_title'.$i]:'').'"><img alt="'.(!empty($member['_tmm_sc_title'.$i])?$member['_tmm_sc_title'.$i]:'').'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type'.$i].'.png"/></a>';
                      }
                    }
                  }

                $team_view .= '</div>'; // Closes social block.
              $team_view .= '</div>'; // Closes text block.
            $team_view .= '</div>'; // END member.

            $page_count = count( $members );
            if ($key == $page_count - 1) $team_view .= '<div style="clear:both;"></div>';
          }
        }

        $team_view .= '</div>'; // Closes container.
      $team_view .= '</div>'; // Closes wrap.
    $team_view .= '</div>'; // Closes tmm.

  endforeach; wp_reset_postdata();
  return $team_view;
  
}

?>