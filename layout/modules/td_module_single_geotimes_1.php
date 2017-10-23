<?php

/**
 * Class td_module_single
 */

class td_module_single_geotimes_1 extends td_module_single_base {

    function get_author_box($author_id = '') {
        if (!$this->is_single) {
            return '';
        }
        if (empty($author_id)) {
            $author_id = $this->post->post_author;
        }
        if (td_util::get_option('tds_show_author_box') == 'hide') {
            $buffy = '<div class="td-author-name vcard author" style="display: none"><span class="fn">';
            $buffy .= '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta('display_name', $author_id) . '</a>' ;
            $buffy .= '</span></div>';
            return $buffy;
        }
        
        $buffy = '';
        $hideAuthor = td_util::get_option('hide_author');
        if (empty($hideAuthor)) {
            $buffy .= '<div class="author-box-wrap">';
            $buffy .= '<a href="' . get_author_posts_url($author_id) . '">' ;
            $buffy .= get_avatar(get_the_author_meta('email', $author_id), '96');
            $buffy .= '</a>';
            $buffy .= '<div class="desc">';
            $buffy .= '<div class="td-author-name vcard author"><span class="fn">';
            $buffy .= '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta('display_name', $author_id) . '</a>' ;
            $buffy .= '</span></div>';
            if (get_the_author_meta('user_url', $author_id) != '') {
                $buffy .= '<div class="td-author-url"><a href="' . get_the_author_meta('user_url', $author_id) . '">' . get_the_author_meta('user_url', $author_id) . '</a></div>';
            }
            $buffy .= '<div class="td-author-description">';
            $buffy .=  get_the_author_meta('description', $author_id);
            $buffy .= '</div>';
            $buffy .= '<div class="td-author-social">';
            foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                //echo get_the_author_meta($td_social_id) . '<br>';
                $authorMeta = get_the_author_meta($td_social_id);
                if (!empty($authorMeta)) {
                    if ($td_social_id == 'twitter') {
                        if(filter_var($authorMeta, FILTER_VALIDATE_URL)){
                            
                        } else {
                            $authorMeta = str_replace('@', '', $authorMeta);
                            $authorMeta = 'http://twitter.com/' . $authorMeta;
                        }
                    }
                    $buffy .= td_social_icons::get_icon($authorMeta, $td_social_id, true);
                }
            }
            $buffy .= '</div>';
            $buffy .= '<div class="clearfix"></div>';
            $buffy .= '</div>'; ////desc
            $buffy .= '</div>'; //author-box-wrap
        }
        return $buffy;
    }

    function get_social_sharing_top() {
        if (!$this->is_single) {
            return;
        }

        if (td_util::get_option('tds_top_social_show') == 'hide' and td_util::get_option('tds_top_like_tweet_show') != 'show') {
            return;
        }

	    // used to style the sharing icon to be big on tablet
	    $td_no_like = '';
	    if (td_util::get_option('tds_top_like_tweet_show') == 'show') {
		    $td_no_like = 'td-with-like';
	    }

        $buffy = '';

        // @todo single-post-thumbnail appears to not be in used! please check
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->post->ID ), 'single-post-thumbnail' );

        $twitter_user = td_util::get_option('tds_tweeter_username');


        $buffy .= '<div class="td-post-sharing td-post-sharing-top ' . $td_no_like . '">';

	        if (td_util::get_option('tds_top_social_show') != 'hide') {

                /**
                 * get Pinterest share description
                 * get it from SEO by Yoast meta (if the plugin is active and the description is set) else use the post title
                 */
                if (is_plugin_active('wordpress-seo/wp-seo.php') and get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true) != '') {
                    $td_pinterest_share_description = get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true);
                } else{
                    $td_pinterest_share_description = htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
                }

                $buffy .= '
				<div class="td-default-sharing">
		            <a class="td-social-sharing-buttons td-social-facebook" href="https://www.facebook.com/sharer.php?u=' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-facebook"></i><div class="td-social-but-text">' . __td('Share on Facebook', TD_THEME_NAME) . '</div></a>
		            <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"  ><i class="td-icon-twitter"></i><div class="td-social-but-text">' . __td('Tweet on Twitter', TD_THEME_NAME) . '</div></a>
		            <a class="td-social-sharing-buttons td-social-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-googleplus"></i></a>
		            <a class="td-social-sharing-buttons td-social-pinterest" href="https://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink() ) . '&amp;media=' . ( ! empty( $image[0] ) ? $image[0] : '' ) . '&description=' . $td_pinterest_share_description . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-pinterest"></i></a>
		            <a class="td-social-sharing-buttons td-social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" ><i class="td-icon-whatsapp"></i></a>
	            </div>';
	        }


            if (td_util::get_option('tds_top_like_tweet_show') == 'show') {
                //classic share buttons
                $buffy .= '<div class="td-classic-sharing">';
                    $buffy .= '<ul>';

                    $buffy .= '<li class="td-classic-facebook">';
                    $buffy .= '<iframe frameBorder="0" src="' . td_global::$http_or_https . '://www.facebook.com/plugins/like.php?href=' . $this->href . '&amp;layout=button_count&amp;show_faces=false&amp;width=105&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:105px; height:21px; background-color:transparent;"></iframe>';
                    $buffy .= '</li>';

                    $buffy .= '<li class="td-classic-twitter">';
                    $buffy .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . esc_attr($this->href) . '" data-text="' . $this->title . '" data-via="' . td_util::get_option('tds_' . 'social_twitter') . '" data-lang="en">tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
                    $buffy .= '</li>';

                    $buffy .= '</ul>';
                $buffy .= '</div>';
            }

        $buffy .= '</div>';

        return $buffy;
    }

    function get_social_sharing_bottom() {
        if (!$this->is_single) {
            return;
        }

        if (td_util::get_option('tds_bottom_social_show') == 'hide' and td_util::get_option('tds_bottom_like_tweet_show') == 'hide') {
            return;
        }

	    // used to style the sharing icon to be big on tablet
	    $td_no_like = '';
	    if (td_util::get_option('tds_bottom_like_tweet_show') != 'hide') {
		    $td_no_like = 'td-with-like';
	    }

        $buffy = '';
        // @todo single-post-thumbnail appears to not be in used! please check
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->post->ID ), 'single-post-thumbnail' );
        $buffy .= '<div class="td-post-sharing td-post-sharing-bottom ' . $td_no_like . '"><span class="td-post-share-title">' . __td('SHARE', TD_THEME_NAME) . '</span>';


	    if (td_util::get_option('tds_bottom_social_show') != 'hide') {
		    $twitter_user = td_util::get_option( 'tds_tweeter_username' );

            /**
             * get Pinterest share description
             * get it from SEO by Yoast meta (if the plugin is active and the description is set) else use the post title
             */
            if (is_plugin_active('wordpress-seo/wp-seo.php') and get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true) != '') {
                $td_pinterest_share_description = get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true);
            } else{
                $td_pinterest_share_description = htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
            }

		    //default share buttons
		    $buffy .= '
            <div class="td-default-sharing">
	            <a class="td-social-sharing-buttons td-social-facebook" href="https://www.facebook.com/sharer.php?u=' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-facebook"></i><div class="td-social-but-text">Facebook</div></a>
	            <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"><i class="td-icon-twitter"></i><div class="td-social-but-text">Twitter</div></a>
	            <a class="td-social-sharing-buttons td-social-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-googleplus"></i></a>
	            <a class="td-social-sharing-buttons td-social-pinterest" href="https://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink() ) . '&amp;media=' . ( ! empty( $image[0] ) ? $image[0] : '' ) . '&description=' . $td_pinterest_share_description . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-pinterest"></i></a>
	            <a class="td-social-sharing-buttons td-social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" ><i class="td-icon-whatsapp"></i></a>
            </div>';
	    }


        if (td_util::get_option('tds_bottom_like_tweet_show') != 'hide') {
            //classic share buttons
            $buffy .= '<div class="td-classic-sharing">';
	            $buffy .= '<ul>';

	            $buffy .= '<li class="td-classic-facebook">';
	            $buffy .= '<iframe frameBorder="0" src="' . td_global::$http_or_https . '://www.facebook.com/plugins/like.php?href=' . $this->href . '&amp;layout=button_count&amp;show_faces=false&amp;width=105&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:105px; height:21px; background-color:transparent;"></iframe>';
	            $buffy .= '</li>';

	            $buffy .= '<li class="td-classic-twitter">';
	            $buffy .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . esc_attr($this->href) . '" data-text="' . $this->title . '" data-via="' . td_util::get_option('tds_' . 'social_twitter') . '" data-lang="en">tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	            $buffy .= '</li>';

	            $buffy .= '</ul>';
            $buffy .= '</div>';
        }





        $buffy .= '</div>';

        return $buffy;
    }

    function get_category_geotimes() {
        $terms_ui_array  = array();
    
    
        if ($this->post->post_type != 'post') {
            $category_spot_taxonomy = td_util::get_ctp_option($this->post->post_type, 'tds_category_spot_taxonomy');
            $terms_for_category_spot = wp_get_post_terms($this->post->ID, $category_spot_taxonomy);
            foreach ($terms_for_category_spot as $term_for_category_spot) {
                $term_for_category_spot_url = get_term_link($term_for_category_spot, $category_spot_taxonomy);
                if (!is_wp_error($term_for_category_spot_url)) {
                    $terms_ui_array[ $term_for_category_spot->name ]  = array(
                        'color'        => '',
                        'link'         => $term_for_category_spot_url,
                        'hide_on_post' => ''
                    );
                }
            }
    
        } else {
            $categories = get_the_category( $this->post->ID );
            if (!empty($categories)) {
                foreach ( $categories as $category ) {
                    if ( $category->name != TD_FEATURED_CAT ) {
                        $td_parent_cat_obj = get_category( $category->category_parent );
                        if ( ! empty( $td_parent_cat_obj->name ) and td_util::get_option('tds_default_category_display') != 'true') {
                            $tax_meta__color_parent                = td_util::get_category_option( $td_parent_cat_obj->cat_ID, 'tdc_color' );//swich by RADU A, get_tax_meta($td_parent_cat_obj->cat_ID,'tdc_color');
                            $tax_meta__hide_on_post_parent         = td_util::get_category_option( $td_parent_cat_obj->cat_ID, 'tdc_hide_on_post' );//swich by RADU A, get_tax_meta($td_parent_cat_obj->cat_ID,'tdc_hide_on_post');
                            $terms_ui_array[ $td_parent_cat_obj->name ] = array(
                                'color'        => $tax_meta__color_parent,
                                'link'         => get_category_link( $td_parent_cat_obj->cat_ID ),
                                'hide_on_post' => $tax_meta__hide_on_post_parent
                            );
                        }
                        $tax_meta_color                = td_util::get_category_option( $category->cat_ID, 'tdc_color' );//swich by RADU A, get_tax_meta($category->cat_ID,'tdc_color');
                        $tax_meta__hide_on_post_parent = td_util::get_category_option( $category->cat_ID, 'tdc_hide_on_post' );//swich by RADU A, get_tax_meta($category->cat_ID,'tdc_hide_on_post');
                        $terms_ui_array[ $category->name ]  = array(
                            'color'        => $tax_meta_color,
                            'link'         => get_category_link( $category->cat_ID ),
                            'hide_on_post' => $tax_meta__hide_on_post_parent
                        );
                    }
                }
            }
        }
        $buffy = '';
        if (td_util::get_option('tds_p_categories_tags') != 'hide') {
            $buffy .= '<ul class="kategory">';
            foreach ( $terms_ui_array as $term_name => $term_params ) {
                if ( $term_params['hide_on_post'] == 'hide' ) {
                    continue;
                }
                if ( ! empty( $term_params['color'] ) ) {
                    $td_cat_title_color = td_util::readable_colour($term_params['color'], 200, 'rgba(0, 0, 0, 0.9)', '#fff');
                    $td_cat_color = ' style="background-color:' . $term_params['color'] . '; color:' . $td_cat_title_color . '; border-color:' . $term_params['color']  . ';"';
                } else {
                    $td_cat_color = '';
                }
                $buffy .= '<li class="entry-category"><a ' . $td_cat_color . ' href="' . $term_params['link'] . '">' . $term_name . '</a></li>';
            }
            $buffy .= '</ul>';
        }
        return $buffy;
    }

    function get_title_geotimes($cut_at = '') {
        $buffy = '';
        if (!empty($this->title)) {
            $buffy .= '<div class="entry-title">';
            if ($this->is_single === true) {
                $buffy .= $this->title;
            } else {
                $buffy .='<a href="' . $this->href . '" rel="bookmark" title="' . $this->title_attribute . '">';
                $buffy .= $this->title;
                $buffy .='</a>';
            }
            $buffy .= '</div>';
        }

        return $buffy;
    }

    function get_author_geotimes() {
        $buffy = '';

        // used in ionMag to hide the date "." when the post date & comment count are off
        // it does nothing on newspaper & newsmag
        $post_author_no_dot = '';
        if ( td_util::get_option('tds_p_show_date') == 'hide' and td_util::get_option('tds_p_show_comments') == 'hide' ) {
            $post_author_no_dot = ' td-post-author-no-dot';
        }

        if (td_util::get_option('tds_p_show_author_name') != 'hide') {
            $buffy .= '<div class="td-post-author-name' . $post_author_no_dot . '">';
            $buffy .= '<a href="' . get_author_posts_url($this->post->post_author) . '">' . get_the_author_meta('display_name', $this->post->post_author) . '</a>' ;

            if (td_util::get_option('tds_p_show_author_name') != 'hide' and td_util::get_option('tds_p_show_date') != 'hide') {
                //$buffy .= '<div class="td-author-line"> - </div> ';
            }
            $buffy .= '</div>';
        }
        return $buffy;
    }
    
    function get_social_sharing_top_geotimes() {
        if (!$this->is_single) {
            return;
        }

        if (td_util::get_option('tds_top_social_show') == 'hide' and td_util::get_option('tds_top_like_tweet_show') != 'show') {
            return;
        }

	    // used to style the sharing icon to be big on tablet
	    $td_no_like = '';
	    if (td_util::get_option('tds_top_like_tweet_show') == 'show') {
		    $td_no_like = 'td-with-like';
	    }

        $buffy = '';

        // @todo single-post-thumbnail appears to not be in used! please check
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->post->ID ), 'single-post-thumbnail' );

        $twitter_user = td_util::get_option('tds_tweeter_username');


        $buffy .= '<div class="td-post-sharing td-post-sharing-top kiri' . $td_no_like . '">';

	        if (td_util::get_option('tds_top_social_show') != 'hide') {

                /**
                 * get Pinterest share description
                 * get it from SEO by Yoast meta (if the plugin is active and the description is set) else use the post title
                 */
                if (is_plugin_active('wordpress-seo/wp-seo.php') and get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true) != '') {
                    $td_pinterest_share_description = get_post_meta($this->post->ID, '_yoast_wpseo_metadesc', true);
                } else{
                    $td_pinterest_share_description = htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
                }

                $buffy .= '
				<div class="td-default-sharing">
		            <a class="td-social-sharing-buttons td-social-facebook" href="https://www.facebook.com/sharer.php?u=' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-facebook"></i></a>
		            <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"  ><i class="td-icon-twitter"></i></a>
		            <a class="td-social-sharing-buttons td-social-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-googleplus"></i></a>
		            <a class="td-social-sharing-buttons td-social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" ><i class="td-icon-whatsapp"></i></a>
	            </div>';
	        }


            if (td_util::get_option('tds_top_like_tweet_show') == 'show') {
                //classic share buttons
                $buffy .= '<div class="td-classic-sharing">';
                    $buffy .= '<ul>';

                    $buffy .= '<li class="td-classic-facebook">';
                    $buffy .= '<iframe frameBorder="0" src="' . td_global::$http_or_https . '://www.facebook.com/plugins/like.php?href=' . $this->href . '&amp;layout=button_count&amp;show_faces=false&amp;width=105&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:105px; height:21px; background-color:transparent;"></iframe>';
                    $buffy .= '</li>';

                    $buffy .= '<li class="td-classic-twitter">';
                    $buffy .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . esc_attr($this->href) . '" data-text="' . $this->title . '" data-via="' . td_util::get_option('tds_' . 'social_twitter') . '" data-lang="en">tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
                    $buffy .= '</li>';

                    $buffy .= '</ul>';
                $buffy .= '</div>';
            }

        $buffy .= '</div>';

        return $buffy;
    }

    function opini_posts_geotimes($force_sidebar_position = '') {
        global $post;
        $tds_kategori_related = td_util::get_option('tds_kategori_after_footer');
        $tds_jumlah_post = td_util::get_option('tds_kategori_after_footer_limit');

        $td_block_args = array (
            'custom_title'=>'',
            'limit' => $tds_jumlah_post,
            'td_ajax_filter_ids'=> $tds_kategori_related,
            'td_filter_default_txt'=>'',
            'ajax_pagination' => 'next_prev'
            //'td_column_number' => $td_column_number
        );
        return td_global_blocks::get_instance('td_block_opini_posts_geotimes')->render($td_block_args);
    }

    function related_posts_geotimes($force_sidebar_position = '') {
        global $post;
        if ($post->post_type != 'post') {
            return '';
        }
        if (td_util::get_option('tds_similar_articles') == 'hide') {
            return '';
        }
        if (td_util::get_option('tds_similar_articles_type') == 'by_tag') {
            $td_related_ajax_filter_type = 'cur_post_same_tags';
        } else {
            $td_related_ajax_filter_type = 'cur_post_same_categories';
        }
        $tds_similar_articles_rows = td_util::get_option('tds_similar_articles_rows');
        if (empty($tds_similar_articles_rows)) {
            $tds_similar_articles_rows = 2;
        }
        if (td_global::$cur_single_template_sidebar_pos == 'no_sidebar' or $force_sidebar_position === 'no_sidebar') {
            $td_related_limit = 4 * $tds_similar_articles_rows;
            $td_related_class = 'row td-related-full-width';
            $td_column_number = 4;
        } else {
            $td_related_limit = 4 * $tds_similar_articles_rows;
            $td_related_class = 'row td-related-full-width';
            $td_column_number = 4;
        }
        $td_block_args = array (
            'limit' => $td_related_limit,
            'ajax_pagination' => 'next_prev',
            'live_filter' => $td_related_ajax_filter_type,  //live atts - this is the default setting for this block
            'td_ajax_filter_type' => 'td_custom_related', //this filter type can overwrite the live filter @see
            'class' => $td_related_class,
            'td_column_number' => $td_column_number
        );
        return td_global_blocks::get_instance('td_block_related_posts_geotimes')->render($td_block_args);
    }
    
    function related_footer_geotimes($force_sidebar_position = '') {
        global $post;
        $tds_kategori_related = td_util::get_option('tds_kategori_related');
        $tds_jumlah_post = td_util::get_option('tds_jumlah_post');

        $td_block_args = array (
            'custom_title'=>'',
            'limit' => $tds_jumlah_post,
            'td_ajax_filter_ids'=> $tds_kategori_related, 
            'td_ajax_filter_type' => 'td_category_ids_filter',
            'td_filter_default_txt'=>''
            //'td_column_number' => $td_column_number
        );
        return td_global_blocks::get_instance('td_block_related_footer_geotimes')->render($td_block_args);
    }
}
