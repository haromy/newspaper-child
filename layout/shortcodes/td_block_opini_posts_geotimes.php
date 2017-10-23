<?php

/**
 * Class td_block_11
 */
class td_block_opini_posts_geotimes extends td_block {
    function render($atts, $content = null){
        parent::render($atts);

        if (empty($td_column_number)) {
            $td_column_number = td_global::vc_get_column_number();
        }
        $buffy = '';
        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';
		    $buffy .= $this->get_block_css();
		    $buffy .= $this->get_block_js();
            $buffy .= '<div class="td-block-title-wrap row">';
            $buffy .= '<div class="col-6"><h4 class="title">OPINI TERBARU</h4></div>';
            $buffy .= '<div class="col-6">'.$this->get_block_pagination().'</div>';
            $buffy .= '</div>';
            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner row">';
            $buffy .= $this->inner($this->td_query->posts);
            $buffy .= '</div>';
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {
        $td_current_column = 1;
        $buffy = '';

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $buffy .= '<div class="col-6 col-md-6 col-lg-3 kolommobile">';
                $td_module_opini_posts_geotimes = new td_module_opini_posts_geotimes($post);
                $buffy .= $td_module_opini_posts_geotimes->render($post);
                $buffy .= '</div>';
                $td_current_column++;
            }
        }
        return $buffy;
    }
}