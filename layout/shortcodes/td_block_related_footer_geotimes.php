<?php

/**
 * Class td_block_11
 */
class td_block_related_footer_geotimes extends td_block {


    function render($atts, $content = null){
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        if (empty($td_column_number)) {
            $td_column_number = td_global::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $buffy = ''; //output buffer

        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

		    //get the block js
		    $buffy .= $this->get_block_css(); 

		    //get the js for this block
		    $buffy .= $this->get_block_js();

            // block title wrap
            $buffy .= '<div class="td-block-title-wrap row">';
                $buffy .= '<div class="col-lg-2"><h4 class="title">MOST VIEWED</h4></div>';
               // $buffy .= $this->get_block_title(); //get the block title
                $buffy .= '<div class="col-lg-10 filter">'.$this->get_pull_down_filter().'</div>'; //get the sub category filter for this block
            $buffy .= '</div>';
            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner row">';
                    $buffy .= $this->inner($this->td_query->posts); //inner content of the block
            $buffy .= '</div>';
            $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {
        $td_current_column = 1;
        $buffy = '';
        $buffy .='<div class="col-lg-6 offset-lg-3">';
        $buffy .= '<div class="row">';
        if (!empty($posts)) {
            foreach ($posts as $post) {
                if ($td_current_column == 1 || $td_current_column == 6) {
                    $buffy .= '<div class="col-6 kolommobile">';
                }
                $td_module_related_footer_geotimes = new td_module_related_footer_geotimes($post);
                $buffy .= $td_module_related_footer_geotimes->render($td_current_column);
                if ($td_current_column == 5 || $td_current_column == 10) {
                    $buffy .= '</div>';
                }
            $td_current_column++;
            }
        }
        $buffy .= '</div>';
        $buffy .= '</div>';
        return $buffy;
    }
}