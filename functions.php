<?php

function replace_core_jquery_version() {
    wp_deregister_script( 'jquery-core' );
    wp_register_script( 'jquery-core', "https://code.jquery.com/jquery-3.1.1.min.js", array(), '3.1.1' );
    wp_deregister_script( 'jquery-migrate' );
    wp_register_script( 'jquery-migrate', "https://code.jquery.com/jquery-migrate-3.0.0.min.js", array(), '3.0.0' );
}
//add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 1001);
function theme_enqueue_styles() {
    //wp_enqueue_style('td-theme', get_template_directory_uri() . '/style.css', '', TD_THEME_VERSION, 'all' );
    wp_enqueue_style('td-theme', get_stylesheet_directory_uri() . '/style-setanmerah-1.css', '', TD_THEME_VERSION, 'all' );
    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/grid.css', array('td-theme'), TD_THEME_VERSION . 'c', 'all' );
    wp_enqueue_style('fontawesome', get_stylesheet_directory_uri() . '/css/fontawesome.css', array('td-theme'), TD_THEME_VERSION . 'c', 'all' );
    //wp_enqueue_style('td-theme-child', get_stylesheet_directory_uri() . '/style-clean-crisp.css', array('td-theme'), TD_THEME_VERSION . 'c', 'all' );
}

function my_scripts_method() {
    wp_enqueue_script('custom-script',get_stylesheet_directory_uri() . '/js/custom.js',array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

require_once('visual_composer.php');


// remove
//add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
        //echo getPostViews(get_the_ID());
        echo wpp_get_views( get_the_ID() );
    }
}

// insert related post dalam artikel
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
    //if($pilihan_related==1){
        $categories = get_the_category($post->ID);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
            $args=array(
                'category__in' => $category_ids,
                'post__not_in' => array($post->ID),
                'orderby' => 'rand',
                'posts_per_page'=> $int_number_of_related_posts,
                'ignore_sticky_posts'=>1,
                'has_password' => false ,
                'post_status'=> 'publish'
            );
        }
    //} //end of block for categories
    if($pilihan_related==2) {
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
    }//end of block for tags
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
        $inline_related_posts .= '</div>';
    }
    wp_reset_postdata();
    return $inline_related_posts;
//related posts code ends here
}

function SisipRelatedArtikel($content) {
    global $post;
    $html ='<div class="inline-related-posts">'.wp_inline_related_posts().'</div>';
    $html2 ='<div class="inline-related-posts">'.wp_inline_related_posts().'</div>';
    $output = '';
    $parts = explode("</p>", $content);
    $count = count($parts);
    for($i=0; $i<$count; $i++) {
        if ($i == 3) {
            $output .= $parts[$i] . '</p>' . $html;
        }
        if ($i == 7) {
            $output .= $parts[$i] . '</p>' . $html2;
        }
        if ($i != 3 && $i != 7) {
            $output .= $parts[$i] . '</p>';
        }
    }
    return $output;
}
add_filter('the_content','SisipRelatedArtikel');