<?php

class td_block_slide_geotimes extends td_block {


    function render($atts, $content = null){
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)


        extract(shortcode_atts(
            array(
                'autoplay' => ''
            ),$atts));

        $buffy = ''; //output buffer





        if ($this->td_query->have_posts() and $this->td_query->found_posts > 1 ) {

            $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

		        //get the block js
		        $buffy .= $this->get_block_css();

		        //get the js for this block
		        //$buffy .= $this->get_block_js();

                // block title wrap
                $buffy .= '<div class="td-block-title-wrap">';
                    $buffy .= $this->get_block_title(); //get the block title
                    $buffy .= $this->get_pull_down_filter(); //get the sub category filter for this block
                $buffy .= '</div>';

                $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
                    $buffy .= $this->inner($this->td_query->posts, '' , $autoplay);
                $buffy .= '</div>';
            $buffy .= '</div> <!-- ./block1 -->';
        }
        return $buffy;
    }


    /**
     * @param $posts
     * @param string $td_column_number - get the column number
     * @param string $autoplay - not use via ajax
     * @param bool $is_ajax - if true the script will return the js inline, if not, it will use the td_js_buffer class
     * @return string
     */
    function inner($posts, $td_column_number = '', $autoplay = '', $is_ajax = false) {
        $buffy = '';

        if (empty($td_column_number)) {
            $td_column_number = td_global::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $td_post_count = 0; // the number of posts rendered

        $td_unique_id_slide = td_global::td_generate_unique_id();

        //@generic class for sliders : td-theme-slider
        $buffy .= '<div id="' . $td_unique_id_slide . '" class="sliding">';
            $buffy .= '<ul class="pgwSlider td_unique_id_slide">';
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        //$buffy .= td_modules::mod_slide_render($post, $td_column_number, $td_post_count);
                        $td_module_slide_geotimes = new td_module_slide_geotimes($post);
                        $buffy .= $td_module_slide_geotimes->render($td_column_number, $td_post_count, $td_unique_id_slide);
                        $td_post_count++;

	                    // Show only the first frame in tagDiv composer
	                    if (td_util::tdc_is_live_editor_iframe() or td_util::tdc_is_live_editor_ajax()) {
		                    break;
	                    }
                    }
                }
            $buffy .= '</ul>'; //close slider
        $buffy .= '</div>'; //close ios

	    // Suppress any iosSlider in tagDiv composer
	    if (td_util::tdc_is_live_editor_iframe() or td_util::tdc_is_live_editor_ajax()) {
		    return $buffy;
	    }

        if (!empty($autoplay)) {
            $autoplay_string =  '
            autoSlide: true,
            autoSlideTimer: ' . $autoplay * 1000 . ',
            ';
        } else {
            $autoplay_string = '';
        }

        //add resize events
        //$add_js_resize = '';
        //if($td_column_number > 1) {
            $add_js_resize = ',
                //onSliderLoaded : td_resize_normal_slide,
                //onSliderResize : td_resize_normal_slide_and_update';
        //}


        $slide_js = '
            jQuery(document).ready(function() {
                var pgwSlider = jQuery(".pgwSlider").pgwSlider();
                pgwSlider.reload({
                    intervalDuration : 4000,
                    selectionMode:"mouseOver",
                    displayControls:true,
                    touchControls:true,
                    verticalCentering:true,
                });
            });
        ';

        if ($is_ajax) {
            $buffy .= '<script>' . $slide_js . '</script>';
        } else {
            td_js_buffer::add_to_footer($slide_js);
        }

        return $buffy;
    }
}