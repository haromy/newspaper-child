<?php

class geotimes_custom {
    var $plugin_url = '';
    var $plugin_path = '';

    function __construct() {
        $this->plugin_url = get_template_directory('', __FILE__); // path used for elements like images, css, etc which are available on end user
        $this->plugin_path = dirname(__FILE__); // used for internal (server side) files

        add_action('td_global_after', array($this, 'hook_td_global_after')); // hook used to add or modify items via Api
        add_action('register_sidebar', array($this, 'register_sidebar'));
        add_action('admin_enqueue_scripts', array('td_api_plugin', 'td_plugin_wpadmin_css')); // hook used to add custom css for wp-admin area
        add_action('wp_enqueue_scripts', array('td_api_plugin', 'td_plugin_frontend_css')); // hook used to add custom css used on frontend area
        
    }

    static function td_plugin_wpadmin_css() {
        //wp_enqueue_style('td-plugin-framework', plugins_url('', __FILE__) . '/wp-admin/style.css'); // backend css (admin_enqueue_scripts)
    }

    static function td_plugin_frontend_css() {
        //wp_enqueue_style('td-plugin-framework', plugins_url('', __FILE__) . '/css/style.css'); // frontend css (wp_enqueue_scripts)
    }

    function register_sidebar() {
        require_once 'widget_plus.php';
    }

    function hook_td_global_after() {
        // single template geotimes - 1
        td_api_single_template::add('single_layout_geotimes_1',
            array(
                'file' => $this->plugin_path . '/layout/single_layout_geotimes_1.php',
                'text' => 'single_layout_geotimes_1',
                //'img' => $this->plugin_url . '/images/panel/single_templates/single_template_77.png',
                'show_featured_image_on_all_pages' => true,
                'bg_box_layout_config' => 'auto',
                'bg_use_featured_image_as_background' => false,
                'bg_disable_background' => false
            )
        );
        // module single layout geotimes 1
        td_api_module::add('td_module_single_geotimes_1',
            array(
                'file' => $this->plugin_path . '/layout/modules/td_module_single_geotimes_1.php',
                'text' => 'Single Module geotimes',
                'img' => '',
                'used_on_blocks' => '',
                'excerpt_title' => '',
                'excerpt_content' => '',
                'enabled_on_more_articles_box' => false,
                'enabled_on_loops' => false,
                'uses_columns' => false,
                'category_label' => false,
                'class' => '',
                'group' => ''
            )
        );

        //module + block related dalam post
        td_api_block::add('td_block_related_posts_geotimes',
            array(
                'map_in_visual_composer' => false,
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_related_posts_geotimes.php',
            )
        );
        td_api_module::add('td_module_related_posts_geotimes',
            array(
                'file' => $this->plugin_path . '/layout/modules/td_module_related_posts_geotimes.php',
                'text' => 'Related posts module',
                'img' => '',
                'used_on_blocks' => array('td_block_related_posts'),
                'excerpt_title' => 25,
                'excerpt_content' => '',
                'enabled_on_more_articles_box' => false,
                'enabled_on_loops' => false,
                'uses_columns' => false,
                'category_label' => true,
                'class' => 'td-animation-stack',
                'group' => ''
            )
        );

        //module + block footer dalam post
        td_api_block::add('td_block_related_footer_geotimes',
            array(
                'map_in_visual_composer' => false,
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_related_footer_geotimes.php',
            )
        );
        td_api_module::add('td_module_related_footer_geotimes',
            array(
                'file' => $this->plugin_path . '/layout/modules/td_module_related_footer_geotimes.php',
                'text' => 'Related posts module',
                'img' => '',
                'used_on_blocks' => array('td_block_related_footer_geotimes'),
                'excerpt_title' => 25,
                'excerpt_content' => '',
                'enabled_on_more_articles_box' => false,
                'enabled_on_loops' => false,
                'uses_columns' => false,
                'category_label' => true,
                'class' => 'td-animation-stack',
                'group' => ''
            )
        );

        // module + block setelah related artikel dalam post
        td_api_block::add('td_block_opini_posts_geotimes',
            array(
                'map_in_visual_composer' => false,
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_opini_posts_geotimes.php',
            )
        );
        td_api_module::add('td_module_opini_posts_geotimes',
            array(
                'file' => $this->plugin_path . '/layout/modules/td_module_opini_posts_geotimes.php',
                'text' => 'Related posts module',
                'img' => '',
                'used_on_blocks' => array('td_block_opini_posts_geotimes'),
                'excerpt_title' => 25,
                'excerpt_content' => '',
                'enabled_on_more_articles_box' => false,
                'enabled_on_loops' => false,
                'uses_columns' => false,
                'category_label' => true,
                'class' => 'td-animation-stack',
                'group' => ''
            )
        );
        
        // module + block slide geotimes
        td_api_module::add('td_module_slide_geotimes',
            array(
                'file' => $this->plugin_path . "/layout/modules/td_module_slide_geotimes.php",
                'text' => 'Module Slide Geotimes',
                //'img' => $this->plugin_url . '/images/modules/td_module_77.png',
                'used_on_blocks' => array('td_block_slide_geotimes'),
                'excerpt_title' => 12,
                'excerpt_content' => 25,
                'enabled_on_more_articles_box' => false,
                'enabled_on_loops' => false,
                'uses_columns' => false, // if the module uses columns on the page template + loop
                'category_label' => false,
                'class' => '',
            )
        );
        td_api_block::add('td_block_slide_geotimes',
            array(
                'map_in_visual_composer' => true,
                "name" => 'Slide Geotimes',
                "base" => 'td_block_slide_geotimes',
                "class" => 'td_block_slide_geotimes',
                "controls" => "full",
                "category" => 'Blocks',
                'icon' => 'icon-pagebuilder-td_block_77',
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_slide_geotimes.php',
                "params" => array_merge(
                    td_config::get_map_block_general_array(),
                    td_config::get_map_filter_array()
                    //td_config::get_map_block_ajax_filter_array(),
                    //td_config::get_map_block_pagination_array()
                )
            )
        );
        
        // blok sidebar 
        td_api_module::add('td_module_sidebar',
            array(
                'file' => $this->plugin_path . "/layout/modules/td_module_sidebar.php",
                'text' => 'Module Sidebar',
                //'img' => $this->plugin_url . '/images/modules/td_module_sidebar.png',
                'used_on_blocks' => array('td_block_sidebar'),
                'excerpt_title' => 12,
                'excerpt_content' => 25,
                'enabled_on_more_articles_box' => true,
                'enabled_on_loops' => true,
                'uses_columns' => true, // if the module uses columns on the page template + loop
                'category_label' => true,
                'class' => 'td_module_wrap td-animation-stack',
            )
        );
        td_api_block::add('td_block_sidebar',
            array(
                'map_in_visual_composer' => true,
                "name" => 'Block Sidebar',
                "base" => 'td_block_sidebar',
                "class" => 'td_block_sidebar',
                "controls" => "full",
                "category" => 'Blocks',
                'icon' => 'icon-pagebuilder-td_block_sidebar',
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_sidebar.php',
                "params" => array_merge(
                    td_config::get_map_block_general_array(),
                    td_config::get_map_filter_array(),
                    td_config::get_map_block_ajax_filter_array(),
                    td_config::get_map_block_pagination_array()
                )
            )
        );

        // custom headline geomedia 1
        td_api_block::add('td_block_headline_geomedia_1',
            array(
                'map_in_visual_composer' => true,
                'map_in_td_composer' => true,
                "name" => 'Headline Geomedia 1',
                "base" => 'td_block_headline_geomedia_1',
                "class" => 'td_block_headline_geomedia_1',
                "controls" => "full",
                "category" => 'Blocks',
                'tdc_category' => 'Big Grids',
                //'icon' => 'icon-pagebuilder-td_block_big_grid_6',
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_headline_geomedia_1.php',
                "params" => td_config::td_block_big_grid_params(),
            )
        );
        td_api_module::add('td_module_card',
            array(
                'file' => $this->plugin_path . "/layout/modules/td_module_card.php",
                'text' => 'Module Card',
                //'img' => $this->plugin_url . '/images/modules/td_module_sidebar.png',
                'used_on_blocks' => array('td_block_headline_geomedia_1'),
                'excerpt_title' => 12,
                'excerpt_content' => 25,
                'enabled_on_more_articles_box' => true,
                'enabled_on_loops' => true,
                'uses_columns' => true, // if the module uses columns on the page template + loop
                'category_label' => true,
                'class' => 'td_module_wrap td-animation-stack',
            )
        );

        // blok card 2 x 3
        td_api_block::add('td_block_homepage_card_23',
            array(
                'map_in_visual_composer' => true,
                'map_in_td_composer' => true,
                "name" => 'geotimes card 2 x 3',
                "base" => 'td_block_homepage_card_23',
                "class" => 'td_block_homepage_card_23',
                "controls" => "full",
                "category" => 'Blocks',
                'tdc_category' => 'Blocks',
                //'icon' => 'icon-pagebuilder-td_block_77',
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_homepage_card_23.php',
                "params" => array_merge(
                    td_config::get_map_block_general_array(),
                    td_config::get_map_filter_array(),
                    td_config::get_map_block_ajax_filter_array(),
                    td_config::get_map_block_pagination_array()
                ) 
            ) 
        );

        // unregister header yang tidak diperlukan
        td_api_header_style::delete('2');
        td_api_header_style::delete('3');
        td_api_header_style::delete('4');
        td_api_header_style::delete('5');
        td_api_header_style::delete('6');
        td_api_header_style::delete('7');
        td_api_header_style::delete('8');
        td_api_header_style::delete('9');
        td_api_header_style::delete('10');
        td_api_header_style::delete('11');
        td_api_header_style::delete('12');
        td_api_header_style::delete('13');

        // hapus block yang tidak diperlukan
        td_api_single_template::delete('td_footer_template_14');

        
    }
}
new geotimes_custom();