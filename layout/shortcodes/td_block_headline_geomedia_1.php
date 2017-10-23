<?php

/**
 *
 * Class td_block_big_grid_6
 */
class td_block_headline_geomedia_1 extends td_block {

    const POST_LIMIT = 7;

    function render($atts, $content = null){
        extract(shortcode_atts(
            array(
                'td_grid_style' => 'td-grid-style-1'
            ), $atts));


        $atts['limit'] = self::POST_LIMIT;

        parent::render($atts); 


        $buffy = '';

        $buffy .= '<div class="' . $this->get_block_classes(array($td_grid_style, 'td-hover-1 td-big-grids')) . '" ' . $this->get_block_html_atts() . '>';

		    //get the block css
		    $buffy .= $this->get_block_css();

            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
                $buffy .= $this->inner($this->td_query->posts, $this->get_att('td_column_number')); //inner content of the block
            $buffy .= '</div>';
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {
        $buffy = '';
        if (!empty($posts)) {
            if ($td_column_number==1 || $td_column_number==2) {
                $buffy .= td_util::get_block_error('Big grid 6', 'Please move this shortcode on a full row in order for it to work.');
            } else {
                $buffy .= '<div class="row">';
                $post_count = 1;
                $td_scroll_posts = '';
                foreach ($posts as $post) {
                    $td_module_card = new td_module_card($post);
                    if($post_count==1) {
                        $buffy.='<div class="col-lg-6 kiri">';
                        $buffy .= $td_module_card->render('show','hide');
                        $buffy.='</div>';
                    }
                    if($post_count==2) {
                        $buffy.='<div class="col-lg-6 kanan">';
                        $buffy .='<div class="row">';
                        $buffy .='<div class="col-4 atas1">';
                        $buffy .= $td_module_card->render('show','hide');
                        $buffy.='</div>';
                    }
                    if($post_count==3) {
                        $buffy.='<div class="col-4 atas2">';
                        $buffy .= $td_module_card->render('show','hide');
                        $buffy.='</div>';
                    }
                    if($post_count==4) {
                        $buffy.='<div class="col-4 atas3">';
                        $buffy .= $td_module_card->render('show','hide');
                        $buffy.='</div></div>';
                    }
                    if($post_count==5) {
                        $buffy.='<div class="row"><div class="col-md-6 bawahkiri">';
                        $buffy .= $td_module_card->render('show','hide');
                        $buffy.='</div>';
                    }
                    if($post_count>6) {
                        $buffy.='<div class="col-md-6 bawahkanan">';
                        for($i==0;$i<3;$i++){
                            $buffy .= $td_module_card->render('hide','hide');
                        }
                        $buffy.='</div></div>';
                        break;
                    }
                    $post_count++;
                }
                $buffy .= '</div>'; // close td-big-grid-wrapper
            }
        }

        return $buffy;
    }
}