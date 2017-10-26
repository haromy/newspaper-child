<?php

class td_block_70s extends td_block {



    function render($atts, $content = null) {
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        if (empty($td_column_number)) {
            $td_column_number = td_global::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $buffy = ''; //output buffer

        $buffy .= '<div class="' . $this->get_block_classes() . ' td-column-' . $td_column_number . '" ' . $this->get_block_html_atts() . '>';

        //get the block js
		    $buffy .= $this->get_block_css();

		    //get the js for this block
		    $buffy .= $this->get_block_js();

            // block title wrap
            $buffy .= '<div class="td-block-title-wrap">';
                $buffy .= $this->get_block_title(); //get the block title
                $buffy .= $this->get_pull_down_filter(); //get the sub category filter for this block
            $buffy .= '</div>';

	        $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner td-column-' . $td_column_number . '">';
	            $buffy .= $this->inner($this->td_query->posts, $td_column_number);//inner content of the block
	        $buffy .= '</div>';

	        //get the ajax pagination for this block
	        $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {

        $buffy = '';
        $td_block_layout = new td_block_layout();
        $td_post_count = 0; // the number of posts rendered
        $td_current_column = 1; //the current column


        if (!empty($posts)) {
            foreach ($posts as $post) {
                $td_module_card = new td_module_mx1_70s($post);
				if ($td_post_count == 0 || $td_post_count == 1 || $td_post_count == 4) {
                    $buffy .='<div class="row">';
				}
				if ($td_post_count == 0) {
					$buffy .='<div class="col-12">';
				}
				if ($td_post_count >= 1) {
					$buffy .='<div class="col-4">';
                }
                if ($td_post_count == 0) {
					$buffy .= $td_module_card->render('munculgambar');
				} else {
                    $buffy .= $td_module_card->render('hide');
                }
				if ($td_post_count > 0) {
					$buffy .='</div>';
				}
				if ($td_post_count == 0 || $td_post_count == 3 || $td_post_count == 6) {
					$buffy .='</div>';
				}
                $td_post_count++;
        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}
}