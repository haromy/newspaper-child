<?php

class td_module_opini_posts_geotimes extends td_module {

    function get_title_related($cut_at = '') {
        $buffy = '';
        if (!empty($this->title)) {
            $buffy .= '<h5 class="card-title">';
            if ($this->is_single === true) {
                $buffy .= $this->title;
            } else {
                $buffy .='<a href="' . $this->href . '" rel="bookmark" title="' . $this->title_attribute . '">';
                $buffy .= $this->title;
                $buffy .='</a>';
            }
            $buffy .= '</h5>';
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


    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }
    

    function render() {
        ob_start();
        ?>
        <div class="<?php echo $this->get_module_classes();?> card">
            <div class="card-block">
                <?php echo $this->get_title_related();?>
            </div>
            <div class="card-footer row">
                <div class="col-12"><?php echo $this->get_author_geotimes();?></div>
            </div>
        </div>

        <?php return ob_get_clean();
    }

}