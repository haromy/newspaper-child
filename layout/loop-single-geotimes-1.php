<?php
/**
 * single Post template geotimes 1
 **/

if (have_posts()) {
    the_post();
    $td_mod_single = new td_module_single_geotimes_1($post);
    ?>
        <div class="td-post-content">
            <?php echo $td_mod_single->get_content();?>
        </div>


        <footer>
            <?php echo $td_mod_single->get_post_pagination();?>
            <?php echo $td_mod_single->get_review();?>

            <div class="td-post-source-tags">
                <?php echo $td_mod_single->get_source_and_via();?>
                <?php echo $td_mod_single->get_the_tags();?>
            </div>
            
	        <?php echo $td_mod_single->get_item_scope_meta();?>
        </footer>

    
<?php
} else {
    //no posts
    echo td_page_generator::no_posts();
}