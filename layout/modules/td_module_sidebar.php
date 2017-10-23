<?php
class td_module_sidebar extends td_module {
    
    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render($td_post_count) {
        $td_post_count+=1;
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            
            <div class="custom-post-count">
                <?php echo $td_post_count; ?>
            </div>
            <?php echo $this->get_title();?>
                
            <div class="td-module-meta-info">
                <?php echo $this->get_author();?>
            </div>

            <?php echo $this->get_quotes_on_blocks(); ?>

        </div>

        <?php return ob_get_clean();
    }
}