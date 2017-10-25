<?php

class td_module_mx1_70s extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render($argument) {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <?php 
            if($argument == 'munculgambar') {
                echo $this->get_image('td_696x385');
            }
            else {
                echo $this->get_image('td_356x364');
            }
            ?>
            <div class="td-module-meta-info">
                <?php echo $this->get_title();?>
                <div class="td-editor-date">
                    <?php if (td_util::get_option('tds_category_module_mx1_70s') == 'yes') { echo $this->get_category(); }?>
                    <span class="td-author-date">
                        <?php echo $this->get_author();?>
                        <?php echo $this->get_date();?>
                    </span>
                </div>
            </div>
        </div>

        <?php return ob_get_clean();
    }
}