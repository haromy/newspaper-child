<?php

class td_block_related_posts_geotimes extends td_block {
    function render($atts, $content = null) {
        if (td_util::get_option('tds_similar_articles_type') == 'by_tag') {
            $current_post_tags = wp_get_post_tags(get_the_ID());
            if (empty($current_post_tags)) {
                return '';
            }
        }


        parent::render($atts);
        extract(shortcode_atts(
                array(
                    'td_column_number' => ''
                ), $atts));
        if ($this->td_query->post_count == 0) {
            return;
        }
        $buffy = ''; //output buffer
        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

	    //get the js for this block
	    $buffy .= $this->get_block_js();


        //get the filter for this block
        $buffy .= '<div class="col-xl-3">';
        $buffy .= '<div class="row">';
        $buffy .= '<div class="col-8"><h4 class="title">ARTIKEL TERKAIT</h4></div>';
        $buffy .= '<div class="col">'.$this->get_block_pagination().'</div>';
        $buffy .= '</div></div>';

        $buffy .= '<div class="col-xl-9 konten"><div class="row">';
        $buffy .= '<div id=' . $this->block_uid . ' class="col td_block_inner">';
        $buffy .= $this->inner($this->td_query->posts, $td_column_number);  //inner content of the block
        $buffy .= '</div></div>';
        $buffy .= '</div></div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {
        $td_block_layout = new td_block_layout();
        $td_block_layout->row_class = 'row';
        $td_block_layout->span4_class = 'col-6 col-lg-3 kolommobile';
        $buffy = '';
        $td_current_column = 1;
        $nomorurut = 0;
        if (!empty($posts)) {
            foreach ($posts as $td_post_count => $post) {
                $td_module_related_posts_geotimes = new td_module_related_posts_geotimes($post);
                switch ($td_column_number) {
                    case '3':
                        $buffy .= $td_block_layout->open_row();
                        $buffy .= $td_block_layout->open4();
                        $buffy .= $td_module_related_posts_geotimes->render();
                        $buffy .= $td_block_layout->close4();
                        if ($td_current_column == 3) {
                            $buffy .= $td_block_layout->close_row();
                        }
                        break;
                    case '4':
                        $buffy .= $td_block_layout->open_row();    
                        $buffy .= $td_block_layout->open4();
                        $buffy .= $td_module_related_posts_geotimes->render($nomorurut);
                        $buffy .= $td_block_layout->close4();
                        if ($td_current_column == 4) {
                            $buffy .= $td_block_layout->close_row();
                        }
                        break;
                    case '5':
                        $buffy .= $td_block_layout->open_row();
                        $buffy .= $td_block_layout->open4();
                        $buffy .= $td_module_related_posts_geotimes->render();
                        $buffy .= $td_block_layout->close4();
                        if ($td_current_column == 5) {
                            $buffy .= $td_block_layout->close_row();
                        }
                        break;
                }
                if ($td_current_column == $td_column_number) {
                    $td_current_column = 1;
                } else {
                    $td_current_column++;
                }
                $nomorurut++;
            } //end for each
        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}

