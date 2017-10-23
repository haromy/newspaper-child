<?php
class td_module_card extends td_module {

    function get_image_geotimes($thumbType, $css_image = false) {
        $buffy = ''; //the output buffer
        $tds_hide_featured_image_placeholder = td_util::get_option('tds_hide_featured_image_placeholder');
        //retina image
        $srcset_sizes = '';

        // do we have a post thumb or a placeholder?
        if (!is_null($this->post_thumb_id) or ($tds_hide_featured_image_placeholder != 'hide_placeholder')) {

            if (!is_null($this->post_thumb_id)) {
                //if we have a thumb
                // check to see if the thumb size is enabled in the panel, we don't have to check for the default wordpress
                // thumbs (the default ones are already cut and we don't have  a panel setting for them)
                if (td_util::get_option('tds_thumb_' . $thumbType) != 'yes' and $thumbType != 'thumbnail') {
                    //the thumb is disabled, show a placeholder thumb from the theme with the "thumb disabled" message
                    global $_wp_additional_image_sizes;

                    if (empty($_wp_additional_image_sizes[$thumbType]['width'])) {
                        $td_temp_image_url[1] = '';
                    } else {
                        $td_temp_image_url[1] = $_wp_additional_image_sizes[$thumbType]['width'];
                    }

                    if (empty($_wp_additional_image_sizes[$thumbType]['height'])) {
                        $td_temp_image_url[2] = '';
                    } else {
                        $td_temp_image_url[2] = $_wp_additional_image_sizes[$thumbType]['height'];
                    }

					// For custom wordpress sizes (not 'thumbnail', 'medium', 'medium_large' or 'large'), get the image path using the api (no_image_path)
	                $thumb_disabled_path = td_global::$get_template_directory_uri;
	                if (strpos($thumbType, 'td_') === 0) {
			            $thumb_disabled_path = td_api_thumb::get_key($thumbType, 'no_image_path');
		            }
			        $td_temp_image_url[0] = $thumb_disabled_path . '/images/thumb-disabled/' . $thumbType . '.png';

                    $attachment_alt = 'alt=""';
                    $attachment_title = '';

                } else {
                    // the thumb is enabled from the panel, it's time to show the real thumb
                    $td_temp_image_url = wp_get_attachment_image_src($this->post_thumb_id, $thumbType);
                    $attachment_alt = get_post_meta($this->post_thumb_id, '_wp_attachment_image_alt', true );
                    $attachment_alt = 'alt="' . esc_attr(strip_tags($attachment_alt)) . '"';
                    $attachment_title = ' title="' . esc_attr(strip_tags($this->title)) . '"';

                    if (empty($td_temp_image_url[0])) {
                        $td_temp_image_url[0] = '';
                    }

                    if (empty($td_temp_image_url[1])) {
                        $td_temp_image_url[1] = '';
                    }

                    if (empty($td_temp_image_url[2])) {
                        $td_temp_image_url[2] = '';
                    }

                    //retina image
                    //don't display srcset_sizes on DEMO - it messes up Pagespeed score (8 March 2017)
                    if (TD_DEPLOY_MODE != 'demo') {
                        $srcset_sizes = td_util::get_srcset_sizes($this->post_thumb_id, $thumbType, $td_temp_image_url[1], $td_temp_image_url[0]);
                    }

                } // end panel thumb enabled check



            } else {
                //we have no thumb but the placeholder one is activated
                global $_wp_additional_image_sizes;

                if (empty($_wp_additional_image_sizes[$thumbType]['width'])) {
                    $td_temp_image_url[1] = '';
                } else {
                    $td_temp_image_url[1] = $_wp_additional_image_sizes[$thumbType]['width'];
                }

                if (empty($_wp_additional_image_sizes[$thumbType]['height'])) {
                    $td_temp_image_url[2] = '';
                } else {
                    $td_temp_image_url[2] = $_wp_additional_image_sizes[$thumbType]['height'];
                }

                /**
                 * get thumb height and width via api
                 * first we check the global in case a custom thumb is used
                 *
                 * The api thumb is checked only for additional sizes registered and if at least one of the settings (width or height) is empty.
                 * This should be enough to avoid getting a non existing id using api thumb.
                 */
	            if (!empty($_wp_additional_image_sizes) && array_key_exists($thumbType, $_wp_additional_image_sizes) && ($td_temp_image_url[1] == '' || $td_temp_image_url[2] == '')) {
                    $td_thumb_parameters = td_api_thumb::get_by_id($thumbType);
	                $td_temp_image_url[1] = $td_thumb_parameters['width'];
                    $td_temp_image_url[2] = $td_thumb_parameters['height'];
                }

	            // For custom wordpress sizes (not 'thumbnail', 'medium', 'medium_large' or 'large'), get the image path using the api (no_image_path)
	            $no_thumb_path = td_global::$get_template_directory_uri;
	            if (strpos($thumbType, 'td_') === 0) {
		            $no_thumb_path = rtrim(td_api_thumb::get_key($thumbType, 'no_image_path'), '/');
	            }
		        $td_temp_image_url[0] = $no_thumb_path . '/images/no-thumb/' . $thumbType . '.png';

                $attachment_alt = 'alt=""';
                $attachment_title = '';
            } //end    if ($this->post_has_thumb) {



            $buffy .= '<div class="td-module-thumb">';
                if (current_user_can('edit_posts')) {
                    $buffy .= '<a class="td-admin-edit" href="' . get_edit_post_link($this->post->ID) . '">edit</a>';
                }


                $buffy .= '<a href="' . $this->href . '" rel="bookmark" title="' . $this->title_attribute . '">';

                    // css image
                    if ($css_image === true) {
                        // retina image
                        if (td_util::get_option('tds_thumb_' . $thumbType . '_retina') == 'yes' && !empty($td_temp_image_url[1])) {
                            $retina_url = wp_get_attachment_image_src($this->post_thumb_id, $thumbType . '_retina');
                            if (!empty($retina_url[0])) {
                                $td_temp_image_url[0] = $retina_url[0];
                            }
                        }
                        $buffy .= '<span class="entry-thumb td-thumb-css" style="background-image: url(' . $td_temp_image_url[0] . ')"></span>';

                    // normal image
                    } else {
                        $buffy .= '<img width="' . $td_temp_image_url[1] . '" height="' . $td_temp_image_url[2] . '" class="img-fluid entry-thumb" src="' . $td_temp_image_url[0] . '"' . $srcset_sizes . ' ' . $attachment_alt . $attachment_title . '/>';
                    }

                    // on videos add the play icon
                    if (get_post_format($this->post->ID) == 'video') {

                        $use_small_post_format_icon_size = false;
                        // search in all the thumbs for the one that we are currently using here and see if it has post_format_icon_size = small
                        foreach (td_api_thumb::get_all() as $thumb_from_thumb_list) {
                            if ($thumb_from_thumb_list['name'] == $thumbType and $thumb_from_thumb_list['post_format_icon_size'] == 'small') {
                                $use_small_post_format_icon_size = true;
                                break;
                            }
                        }

                        // load the small or medium play icon
                        if ($use_small_post_format_icon_size === true) {
                            $buffy .= '<span class="td-video-play-ico td-video-small"><img width="20" height="20" class="td-retina" src="' . td_global::$get_template_directory_uri . '/images/icons/video-small.png' . '" alt="video"/></span>';
                        } else {
                            $buffy .= '<span class="td-video-play-ico"><img width="40" height="40" class="td-retina" src="' . td_global::$get_template_directory_uri . '/images/icons/ico-video-large.png' . '" alt="video"/></span>';
                        }
                    } // end on video if

                $buffy .= '</a>';
            $buffy .= '</div>'; //end wrapper

            return $buffy;
        }
    }
    function get_author_geotimes() {
        $buffy = '';

        if ($this->is_review === false) {
            if (td_util::get_option('tds_m_show_author_name') != 'hide') {
                $buffy .= '<span class="td-post-author-name">';
                $buffy .= '<a href="' . get_author_posts_url($this->post->post_author) . '">' . get_the_author_meta('display_name', $this->post->post_author) . '</a>' ;
                if (td_util::get_option('tds_m_show_author_name') != 'hide' and td_util::get_option('tds_m_show_date') != 'hide') {
                }
                $buffy .= '</span>';
            }

        }
        return $buffy;

    }
    
    function get_title_geotimes($cut_at = '') {
        $buffy = '';
        $buffy .= '<div class="card-title">';
        $buffy .='<a href="' . $this->href . '" rel="bookmark" title="' . $this->title_attribute . '">';

        if ($cut_at != '') {
            $buffy .= td_util::excerpt($this->title, $cut_at, 'show_shortcodes');

        } else {
            $current_module_class = get_class($this);
            if (td_api_module::_helper_check_excerpt_title($current_module_class)) {
                $db_title_excerpt = td_util::get_option($current_module_class . '_title_excerpt');
                if ($db_title_excerpt != '') {
                    $buffy .= td_util::excerpt($this->title, $db_title_excerpt, 'show_shortcodes');
                } else {
                    $module_api = td_api_module::get_by_id($current_module_class);
                    $buffy .= td_util::excerpt($this->title, $module_api['excerpt_title'], 'show_shortcodes');
                }
            } else {
                $buffy .= $this->title;
            }

        }
        $buffy .='</a>';
        $buffy .= '</div>';
        return $buffy;
    }

    function get_date_geotimes($show_stars_on_review = true) {
        $visibility_class = '';
        if (td_util::get_option('tds_m_show_date') == 'hide') {
            $visibility_class = ' td-visibility-hidden';
        }

        $buffy = '';
        if ($this->is_review and $show_stars_on_review === true) {
            //if review show stars
            $buffy .= '<div class="entry-review-stars">';
            $buffy .=  td_review::render_stars($this->td_review);
            $buffy .= '</div>';

        } else {
            if (td_util::get_option('tds_m_show_date') != 'hide') {
                $td_article_date_unix = get_the_time('U', $this->post->ID);
                $buffy .= '<span class="td-post-date">';
                    //$buffy .= '<time class="entry-date updated td-module-date' . $visibility_class . '" datetime="' . date(DATE_W3C, $td_article_date_unix) . '" >' . get_the_time(get_option('date_format'), $this->post->ID) . '</time>';
                    $buffy .= '<time class="entry-date updated td-module-date' . $visibility_class . '" datetime="' . date(DATE_W3C, $td_article_date_unix) . '" >─ ' .human_time_diff( $td_article_date_unix, current_time( 'timestamp' ) ).' lalu</time>';
                $buffy .= '</span>';
            }
        }

        return $buffy;
    }
    
    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render($argumen,$tanggal) {
        ob_start();
        ?>
        <div class="<?php echo $this->get_module_classes();?> card">
            <div class="card-img-top">
                <?php
                    
                    if ($argumen == 'show') {
                        echo $this->get_image_geotimes('td_324x160');
                    }
                ?>
            </div>
            <div class="card-block">
                    <?php echo $this->get_title_geotimes();?>
            </div>
            <div class="card-footer">
                <?php echo $this->get_author_geotimes();?>
                <?php
                    
                    if ($tanggal == 'show') {
                        echo $this->get_date_geotimes();
                    }
                ?>
            </div>
        </div>

        <?php return ob_get_clean();
    }
}