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

