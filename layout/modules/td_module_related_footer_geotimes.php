<?php

class td_module_related_footer_geotimes extends td_module {

    function get_views() {
        $buffy = '';
        if (td_util::get_option('tds_p_show_views') != 'hide') {
            $buffy .= '<div class="td-post-views">';
            $buffy .= '<i class="td-icon-views"></i>';
            // WP-Post Views Counter
            if (function_exists('the_views')) {
                $post_views = the_views(false);
                $buffy .= $post_views;
            }
            // Default Theme Views Counter
            else {
                $buffy .= '<span class="td-nr-views-' . $this->post->ID . '">' . td_page_views::get_page_views($this->post->ID) .'</span>';
            }

            $buffy .= '</div>';
        }
        return $buffy;
    }

    function get_title_related($cut_at = '') {
        $buffy = '';
        if (!empty($this->title)) {
            $buffy .= '<div class="card-title">';
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

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render($td_current_column) {
        ob_start();
        ?>
        <div class="row">
            <div class="col-1 custom-post-count"><?php echo $td_current_column;?></div>
            <div class="col"><?php echo $this->get_title_related();?></div>
        </div>

        <?php return ob_get_clean();
    }

}