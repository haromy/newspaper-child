<?php
class td_block_custom_list_authors extends td_block {


	/** 
	 * Disable loop block features. This block does not use a loop and it dosn't need to run a query.
	 */
	function __construct() {
		parent::disable_loop_block_features();
	}



    function render($atts, $content = null) {
        //$td_block_layout = new td_block_template_1();
        //$td_block_layout->get
	    parent::render($atts);
        global $wpdb;

        $sort = '';

        extract(shortcode_atts(
            array(
                'roles' => '',
                'sort' => '',
                'exclude' => '',
                'include' => ''
            ), $atts));



        //print_r($atts);
        //die;

        $get_users_array = array();

        if (!empty($exclude)) {
            $exclude_array = explode(',', $exclude);
            $get_users_array['exclude'] = $exclude_array;
        }

        if (!empty($include)) {
            $include_array = explode(',', $include);
            $get_users_array['include'] = $include_array;
        }


        if (empty($sort)) {
            $get_users_array['orderby'] = 'display_name';
            //$td_authors = get_users(array('orderby' => 'display_name'));
        } else {
            $get_users_array['orderby'] = 'post_count';
            $get_users_array['order'] = 'DESC';
            //$td_authors = get_users(array('orderby' => 'post_count', 'order' => 'DESC'));
        }

        if (!empty($roles)) {
            $roles_in = array();
            $roles_buffer = explode(',', $roles);
            foreach ($roles_buffer as $role) {
                //clear the empty space
                $roles_in[] = trim($role);
            }
            //role__in was added in wp 4.4
            $get_users_array['role__in'] = $roles_in;
        }

        $td_authors = get_users($get_users_array);
        $register_author= get_the_author_meta('user_registered', $td_author->ID);


        $buffy = '';
        $buffy .= '<div class="' . $this->get_block_classes(array('td_top_authors')) . ' row" ' . $this->get_block_html_atts() . '>';

	    //get the block js
	    $buffy .= $this->get_block_css();

        $buffy .= $this->get_block_title();
	    $buffy .= $this->get_pull_down_filter();


        if (!empty($td_authors)) {
            foreach ($td_authors as $td_author) {
                //echo td_global::$current_author_obj->ID;
                //echo $td_author->ID;
                //print_r($td_author);
                
                $current_author_class = '';
                if (!empty(td_global::$current_author_obj->ID) and td_global::$current_author_obj->ID == $td_author->ID) {
                    $current_author_class = ' td-active';
                }
                $buffy .= '<div class="td_mod_wrap td-pb-padding-side item-list-author' . $current_author_class . ' col-md-4">';
                //$buffy .= '<a href="' . get_author_posts_url($td_author->ID) . '">' . get_avatar($td_author->user_email, '70') . '</a>';
                $buffy .= '<div class="custom-item-details">';
                $buffy .= '<div class="item-details">';
                $buffy .= '<a href="' . get_author_posts_url($td_author->ID) . '">' . get_avatar($td_author->user_email, '70') . '</a>';

                $buffy .= '<div class="custom-author-list-name">';
                $buffy .= '<a href="' . get_author_posts_url($td_author->ID) . '">' . $td_author->display_name . '</a>';
                $buffy .= '</div>';     

                $buffy .= '<div class="custom-join-date">';
                $buffy .= 'Menulis di Geotimes sejak';
                $buffy .= '<span>';
                $buffy .= date( "j M Y", strtotime( $td_author->user_registered));
                $buffy .= '</span>';
                $buffy .= '</div>';
                
                $buffy .= '<span class="custom-author-post-count">';
                $buffy .= count_user_posts($td_author->ID). ' '  . __td('tulisan', TD_THEME_NAME);
                $buffy .= '</span>';
                

                $buffy .= '<div>';
                $buffy .= '<a href="#" class="custom-subscribe">Subscribe</a> ';
                $buffy .= '<div class="td-author-social">';
                $i = 0;
                foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                    $authorMeta = get_the_author_meta($td_social_id, $td_author->ID);
                    if (!empty($authorMeta)) {
                        $buffy.= td_social_icons::get_icon($authorMeta, $td_social_id, true );
                        if (++$i == 2) break;
                    }
                }
                $buffy .= '<a href="#" class="custom-more-socials" onclick="event.preventDefault();"><img src="http://localhost/newApp/wp-content/uploads/2017/10/author-more.png"></a>';
                $buffy .= '</div>';
                $buffy .= '</div>';
                
                
                $buffy .= '<div class="custom-author-description">';
                $buffy .= list_authors_excerpt( get_the_author_meta('description', $td_author->ID) , 13 );
                $buffy .= '</div>';
                
                $buffy .= '<div class="custom-author-btn-more">';
                $buffy .= '<a href="' . get_author_posts_url($td_author->ID) . '"><img src="http://localhost/newApp/wp-content/uploads/2017/10/arrow-icon-black.png"><span>Baca</span></a>';
                $buffy .= '</div>';
                $buffy .= '</div>'; //end of custom-item-detail

                $buffy .= '<div class="item-overlay top">';
                $buffy .= '<a href="#" class="more-social-close" onclick="event.preventDefault();" >x</a>';
                $buffy .= '<p>SOCIALS</p>';
                $buffy .= '<div class="td-author-social">';
                foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                    $authorMeta = get_the_author_meta($td_social_id, $td_author->ID);
                    if (!empty($authorMeta)) {
                        $buffy.= td_social_icons::get_icon($authorMeta, $td_social_id, true );
                    }
                }
                $buffy .= '</div>';
                $buffy .= '</div>'; //end of item-overlay
                
                
                $buffy .= '</div>';
                $buffy .= '</div>';
            }
        }



        $buffy .= '</div>';


        return $buffy;

    }
}