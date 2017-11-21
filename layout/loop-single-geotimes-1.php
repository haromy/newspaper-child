<?php
/**
 * single Post template geotimes 1
 **/

function wp_inline_related_posts(){
    global $post;
    $int_number_of_related_posts = 1;
    $args = null;
    if( $current_post_type = get_post_type( $post )) {
        if($current_post_type != 'page') {
            $args = array(
                'posts_per_page'=> $int_number_of_related_posts,
                'order' => 'DESC',
                'orderby' => 'rand',
                'post_type' => $current_post_type,
                'post__not_in' => array( $post->ID )
            );
        } 			
    }//end of block for custom Post types
    if($pilihan_related==1){
        $categories = get_the_category($post->ID);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
            $args=array(
                'category__in' => $category_ids,
                'post__not_in' => array($post->ID),
                'posts_per_page'=> $int_number_of_related_posts,
                'ignore_sticky_posts'=>1,
                'has_password' => false ,
                'post_status'=> 'publish'
            );
        }
    } //end of block for categories
    //if($pilihan_related==2) {
        $ampforwp_tags = get_the_tags($post->ID);
        if ($ampforwp_tags) {
            $tag_ids = array();
            foreach($ampforwp_tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
            $args=array(
                'tag__in' => $tag_ids,
                'post__not_in' => array($post->ID),
                'orderby' => 'rand',
                'posts_per_page'=> $int_number_of_related_posts,
                'ignore_sticky_posts'=>1,
                'has_password' => false ,
                'post_status'=> 'publish'
            );
        }
    //}//end of block for tags
    $my_query = new wp_query( $args );
    if( $my_query->have_posts() ) { 
        $inline_related_posts = '<div class="relatedpost">';
        while( $my_query->have_posts() ) {
            $my_query->the_post();
            $related_post_permalink = get_permalink();
            $related_post_permalink = trailingslashit($related_post_permalink);
            $related_post_permalink = user_trailingslashit($related_post_permalink);
            if ( has_post_thumbnail() ) { 
                $title_class = 'has_related_thumbnail';
            } else {
                $title_class = 'no_related_thumbnail'; 
            }
            $inline_related_posts .= '<div class="card '.$title_class.'">';
            $inline_related_posts .= '<a href="'.esc_url( $related_post_permalink ).'" rel="bookmark" title="'.get_the_title().'">';
            $thumb_id_2 = get_post_thumbnail_id();
            $thumb_url_array_2 = wp_get_attachment_image_src($thumb_id_2, 'medium', true);
            $thumb_url_2 = $thumb_url_array_2[0];
            if ( has_post_thumbnail() ) { 
                $inline_related_posts .= '<img src="'.esc_url( $thumb_url_2 ).'" width="150" height="100" layout="responsive" class="img-fluid card-img-top"></img>';
            }
            $inline_related_posts .='<div class="card-body">';
            $inline_related_posts .= '<h6 class="card-title">'.get_the_title().'</h6>';
            $inline_related_posts .= '</div>';
            $inline_related_posts .='<div class="card-footer"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i><span class="readmore">Read more</span></div>';
            $inline_related_posts .='</a>';
            $inline_related_posts .='</div>';
        }
    }
    $inline_related_posts .= '</div>';
    wp_reset_postdata();
    return $inline_related_posts;
//related posts code ends here
}

add_filter('the_content','wp_generate_inline_related_posts');

function wp_generate_inline_related_posts($content){
	global $post;
	$break_point = '</p>';
	$content_parts = explode($break_point, $content);
	$no_of_parts = count($content_parts);
	$half_index = floor($no_of_parts / 3);
	$half_content = array_chunk($content_parts, $half_index);
	
    $html[] ='<div class="inline-related-posts">'.wp_inline_related_posts().'</div>';
    $html2[] ='<div class="inline-related-posts">'.wp_inline_related_posts().'</div>';
	$firs_content = $half_content[0];
    $second_content = $half_content[1];
    $third_content = $half_content[2];
	$final_content = array_merge($firs_content,$html,$second_content,$html2,$third_content);
	$final_content = implode($break_point, $final_content);
	$content = $final_content;
	return $content;
}

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