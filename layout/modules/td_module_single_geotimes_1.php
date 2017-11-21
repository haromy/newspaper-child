<?php

/**
 * Class td_module_single
 */


class td_social_icons1 {
    static $td_social_icons_array = array(
        'behance' => 'Behance',
        'blogger' => 'Blogger',
        'delicious' => 'Delicious',
        'deviantart' => 'Deviantart',
        'digg' => 'Digg',
        'dribbble' => 'Dribbble',
        'evernote' => 'Evernote',
        'facebook' => 'Facebook',
        'flickr' => 'Flickr',
        'forrst' => 'Forrst',
        'googleplus' => 'Google+',
        'grooveshark' => 'Grooveshark',
        'instagram' => 'Instagram',
        'lastfm' => 'Lastfm',
        'linkedin' => 'Linkedin',
        'mail-1' => 'Mail',
        'myspace' => 'Myspace',
        'path' => 'Path',
        'paypal' => 'Paypal',
        'pinterest' => 'Pinterest',
        'reddit' => 'Reddit',
        'rss' => 'RSS',
        'share' => 'Share',
        'skype' => 'Skype',
        'soundcloud' => 'Soundcloud',
        'spotify' => 'Spotify',
        'stackoverflow' => 'Stackoverflow',
        'steam' => 'Steam',
        'stumbleupon' => 'StumbleUpon',
        'tumblr' => 'Tumblr',
        'twitter' => 'Twitter',
        'vimeo' => 'Vimeo',
        'vk' => 'VKontakte',
        'windows' => 'Windows',
        'wordpress' => 'WordPress',
        'yahoo' => 'Yahoo',
        'youtube' => 'Youtube'
    );




    static function get_icon($url, $icon_id, $open_in_new_window = false, $show_icon_id = false) {
        if ($open_in_new_window !== false) {
            $td_a_target = ' target="_blank"';
        } else {
            $td_a_target = '';
        }

		// append mailto: the email only if we have an @ and we don't have the mailto: already in place
	    if (
		    $icon_id == 'mail-1'
		    and strpos($url, '@') !== false
		        and strpos(strtolower($url), 'mailto:') === false
	    ) {
		    $url = 'mailto:' . $url;
	    }

        //if the $show_icon_id parameter is set to true also add the social network name
        if($show_icon_id === true){
            return '
            <span class="td-social-icon-wrap">
                <a' . $td_a_target . ' href="' . $url . '" title="' . self::$td_social_icons_array[$icon_id] . '">
                    <i class="td-icon-font td-icon-' . $icon_id . '"></i>
                    <span class="td-social-name">' . self::$td_social_icons_array[$icon_id] . '</span>
                </a>
            </span>';
        }

        return '<a' . $td_a_target . ' href="' . $url . '" title="' . self::$td_social_icons_array[$icon_id] . '">
                <i class="fa fa-' . $icon_id . ' fa-square-custom"></i>
            </a>';
    }

}



class td_module_single_geotimes_1 extends td_module_single_base {

    function get_content() {
        
                /*  ----------------------------------------------------------------------------
                    Prepare the content
                */
                $content = get_the_content(__td('Continue', TD_THEME_NAME));
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);
        
        
        
                /** ----------------------------------------------------------------------------
                 * Smart list support. class_exists and new object WORK VIA AUTOLOAD
                 * @see td_autoload_classes::loading_classes
                 */
                //$td_smart_list = get_post_meta($this->post->ID, 'td_smart_list', true);
                $td_post_theme_settings = td_util::get_post_meta_array($this->post->ID, 'td_post_theme_settings');
                if (!empty($td_post_theme_settings['smart_list_template'])) {
        
                    $td_smart_list_class = $td_post_theme_settings['smart_list_template'];
                    if (class_exists($td_smart_list_class)) {
                        /**
                         * @var $td_smart_list_obj td_smart_list
                         */
                        $td_smart_list_obj = new $td_smart_list_class();  // make the class from string * magic :)
        
                        // prepare the settings for the smart list
                        $smart_list_settings = array(
                            'post_content' => $content,
                            'counting_order_asc' => false,
                            'td_smart_list_h' => 'h3',
                            'extract_first_image' => td_api_smart_list::get_key($td_smart_list_class, 'extract_first_image')
                        );
        
                        if (!empty($td_post_theme_settings['td_smart_list_order'])) {
                            $smart_list_settings['counting_order_asc'] = true;
                        }
        
                        if (!empty($td_post_theme_settings['td_smart_list_h'])) {
                            $smart_list_settings['td_smart_list_h'] = $td_post_theme_settings['td_smart_list_h'];
                        }
                        return $td_smart_list_obj->render_from_post_content($smart_list_settings);
                    } else {
                        // there was an error?
                        td_util::error(__FILE__, 'Missing smart list: ' . $td_smart_list_class . '. Did you disabled a tagDiv plugin?');
                    }
                }
                /*  ----------------------------------------------------------------------------
                    end smart list - if we have a list, the function returns above
                 */
        
        
        
        
                /*  ----------------------------------------------------------------------------
                    ad support on content
                */
        
                //read the current ad settings
                $tds_inline_ad_paragraph = td_util::get_option('tds_inline_ad_paragraph');
                $tds_inline_ad_align = td_util::get_option('tds_inline_ad_align');
        
                //ads titles
                $tds_inline_ad_title = td_util::get_option('tds_content_inline_title');
                $tds_bottom_ad_title = td_util::get_option('tds_content_bottom_title');
                $tds_top_ad_title = td_util::get_option('tds_content_top_title');
        
                //show the inline ad at the last paragraph ( replacing the bottom ad ) whenever there are not as many paragraphs mentioned in After Paragraph field
                // ..and the article bottom ad is not active
                $show_inline_ad_at_bottom = false;
        
                //add the inline ad
                if (td_util::is_ad_spot_enabled('content_inline') and is_single()) {
                    if (empty($tds_inline_ad_paragraph)) {
                        $tds_inline_ad_paragraph = 0;
                    }
        
                    $content_buffer = ''; // we replace the content with this buffer at the end
                    $content_parts = preg_split('/(<blockquote.*\/blockquote>)/Us', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        
                    $p_open_tag_count = 0; // count how many <p> tags we have added to the buffer
                    foreach ($content_parts as $content_part_index => $content_part_value) {
                        if (!empty($content_part_value)) {
        
                            //skip <blockquote> parts - look for <p> in the other parts
                            if (preg_match('/(<blockquote.*>)/U', $content_part_value) !== 1) {
                                $section_parts = preg_split('/(<p.*>)/U', $content_part_value, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        
                                foreach ($section_parts as $section_part_index => $section_part_value) {
                                    if (!empty($section_part_value)) {
                                        // Show the ad ONLY IF THE CURRENT PART IS A <p> opening tag and before the <p> -> so we will have <p>content</p>  ~ad~ <p>content</p>
                                        // and prevent cases like <p> ~ad~ content</p>
                                        if (preg_match('/(<p.*>)/U', $section_part_value) === 1) {
                                            if ($tds_inline_ad_paragraph == $p_open_tag_count) {
                                                $show_inline_ad_at_bottom = true;
                                                switch ($tds_inline_ad_align) {
                                                    case 'left':
                                                        $content_buffer .= td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'align' => 'left', 'spot_title' => $tds_inline_ad_title ));
                                                        break;
        
                                                    case 'right':
                                                        $content_buffer .= td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'align' => 'right', 'spot_title' => $tds_inline_ad_title));
                                                        break;
        
                                                    default:
                                                        $content_buffer .= td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'spot_title' => $tds_inline_ad_title));
                                                        break;
                                                }
                                            }
                                            $p_open_tag_count ++;
                                        }
                                        //add section to buffer
                                        $content_buffer .= $section_part_value;
                                    }
                                }
        
                            } else {
                                //add <blockquote> to buffer
                                $content_buffer .= $content_part_value;
                            }
                        }
                    }
                    $content = $content_buffer;
                }
        
        
                //add the top ad
                if (td_util::is_ad_spot_enabled('content_top') && is_single()) {
        
                    //disable the top ad on post template 1, it breaks the layout, the top image and ad should float on the left side of the content
                    if (!empty($td_post_theme_settings['td_post_template'])) {
                        $td_default_site_post_template = $td_post_theme_settings['td_post_template'];
        
                    //if the post individual template is not set, check the global settings, if template 1 is set disable the top ad
                    } else {
                        $td_default_site_post_template = td_util::get_option('td_default_site_post_template');
                    }
        
                    //default post template - is empty, check td_api_single_template::_helper_td_global_list_to_metaboxes()
                    if (empty($td_default_site_post_template)) {
                        $td_default_site_post_template = 'single_template';
                    }
        
                    //check if ad is excluded from current post template
                    if (td_api_single_template::get_key($td_default_site_post_template, 'exclude_ad_content_top') === false) {
                        $content = td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_top', 'spot_title' => $tds_top_ad_title)) . $content;
                    }
                }
        
        
                //add bottom ad
                if (td_util::is_ad_spot_enabled('content_bottom') && is_single()) {
                    $content = $content . td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_bottom', 'spot_title' => $tds_bottom_ad_title));
                } else {
                    if ( $show_inline_ad_at_bottom !== true ) {
                        switch ($tds_inline_ad_align) {
                            case 'left':
                                $content = $content . td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'align' => 'left', 'spot_title' => $tds_inline_ad_title ));
                                break;
        
                            case 'right':
                                $content = $content . td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'align' => 'right', 'spot_title' => $tds_inline_ad_title));
                                break;
        
                            default:
                                $content = $content . td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'content_inline', 'spot_title' => $tds_inline_ad_title));
                                break;
                        }
                    }
                }
        
                return $content;
            }

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
            foreach (td_social_icons1::$td_social_icons_array as $td_social_id => $td_social_name) {
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
                    $buffy .= td_social_icons1::get_icon($authorMeta, $td_social_id, true);
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
		            <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"  onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-twitter"></i><div class="td-social-but-text">' . __td('Tweet on Twitter', TD_THEME_NAME) . '</div></a>
		            <a class="td-social-sharing-buttons td-social-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-googleplus"></i></a>
		            <a class="td-social-sharing-buttons td-social-pinterest" href="https://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink() ) . '&amp;media=' . ( ! empty( $image[0] ) ? $image[0] : '' ) . '&description=' . $td_pinterest_share_description . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="td-icon-pinterest"></i></a>
                    <a class="td-social-sharing-buttons td-social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" ><i class="td-icon-whatsapp"></i></a
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
                    <a class="td-button-social social-facebook" href="https://www.facebook.com/sharer.php?u=' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-facebook fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"  ><i class="fa fa-twitter fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-google-plus fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-whatsapp fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-email" href="" ><i class="fa fa-envelope-o fa-24 fa-border" aria-hidden="true"></i></a>
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
    function get_social_sharing_bottom_geotimes() {
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
                    <a class="td-button-social social-facebook" href="https://www.facebook.com/sharer.php?u=' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-facebook fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-twitter" href="https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( esc_url( get_permalink() ) ) . '&via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '"  onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-twitter fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-google-plus fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-whatsapp" href="whatsapp://send?text=' . htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '%20-%20' . urlencode( esc_url( get_permalink() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-whatsapp fa-24 fa-border" aria-hidden="true"></i></a>
                    <a class="td-button-social social-email" href="mailto:?subject='. htmlspecialchars(urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') .'&amp;body='. urlencode( esc_url( get_permalink() ) ) .'"><i class="fa fa-envelope-o fa-24 fa-border" aria-hidden="true"></i></a>
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
            'td_ajax_filter_type' => 'td_category_ids_filter'
            //'td_column_number' => $td_column_number
        );
        return td_global_blocks::get_instance('td_block_related_footer_geotimes')->render($td_block_args);
    }
}
