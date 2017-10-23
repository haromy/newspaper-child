<?php
// v3 - for wp_010

class td_block_sidebar extends td_block {

    function get_block_title_sidebar() {
        $custom_title = $this->get_att('custom_title');
        $custom_url = $this->get_att('custom_url');
        $buffy = '';
        $buffy .= '<h4 class="custom-block-title">';
        if (!empty($custom_url)) {
            $buffy .= '<a href="' . esc_url($custom_url) . '" class="td-pulldown-size">' . esc_html($custom_title) . '</a>';
        } else {
            $buffy .= '<span class="td-pulldown-size">' . esc_html($custom_title) . '</span>';
        }
        $buffy .= '</h4>';
        return $buffy;
    }
    
    function render($atts, $content = null) {
        parent::render($atts);
        $buffy = '';
        $buffy .= $this->get_block_js();

        $buffy .= '<div class="' . $this->get_block_classes() . '">';
            $buffy .= $this->get_block_title_sidebar();
            $buffy .= $this->get_pull_down_filter();

            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
                $buffy .= $this->inner($this->td_query->posts);
            $buffy .= '</div>';
            $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {
        $buffy = '';
        $td_block_layout = new td_block_layout();
        if (empty($td_column_number)) {
            $td_column_number = td_global::vc_get_column_number(); // get the column width of the block from the page builder API
        }
        $td_post_count = 0; // the number of posts rendered
        $td_current_column = 1; //the current columng

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $td_module_sidebar = new td_module_sidebar($post);

                switch ($td_column_number) {

                    case '1': //one column layout
                        $buffy .= $td_block_layout->open12();
                        $buffy .= $td_module_sidebar->render($td_post_count);
                        $buffy .= $td_block_layout->close12();
                        break;

                    case '2': //two column layout
                        $buffy .= $td_block_layout->open_row();
                        $buffy .= $td_block_layout->open6();
                        $buffy .= $td_module_sidebar->render($td_post_count);
                        $buffy .= $td_block_layout->close6();
                        if ($td_current_column == 2) {
                            $buffy .= $td_block_layout->close_row();
                        }
                        break;

                    case '3': //three column layout
                        $buffy .= $td_block_layout->open_row();
                        $buffy .= $td_block_layout->open4();
                        $buffy .= $td_module_sidebar->render($td_post_count);
                        $buffy .= $td_block_layout->close4();
                        if ($td_current_column == 3) {
                            $buffy .= $td_block_layout->close_row();
                        }
                        break;
                }
                if ($td_current_column == $td_column_number) {
                    $td_current_column = 1;
                } else {
                    $td_current_column++;
                }

                $td_post_count++;
            }
        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}