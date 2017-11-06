<?php
class td_module_sidebar extends td_module {

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

    function render($td_post_count) {
        $td_post_count+=1;
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?> row">
            <div class="col-1"><div class="custom-post-count"><?php echo $td_post_count; ?></div></div>
            <div class="col">
                <?php echo $this->get_title();?>
                <div class="td-module-meta-info">
                    <?php echo $this->get_author_geotimes();?>
                </div>
            </div>
        </div>

        <?php return ob_get_clean();
    }
}