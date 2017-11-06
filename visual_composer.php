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

        // module untuk kategori
        td_api_module::add('td_module_category',
            array(
                'file' => $this->plugin_path . "/layout/modules/td_module_category.php",
                'text' => 'Module Category',
                'excerpt_title' => 12,
                'excerpt_content' => 25,
                'enabled_on_more_articles_box' => true,
                'enabled_on_loops' => true,
                'uses_columns' => true, // if the module uses columns on the page template + loop
                'category_label' => true,
                'class' => 'td_module_wrap td-animation-stack td_module_category',
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

        //unregister single template yang tidak diperlukan
        td_api_single_template::delete('single_template_3');
        td_api_single_template::delete('single_template_4');
        td_api_single_template::delete('single_template_5');
        td_api_single_template::delete('single_template_6');
        td_api_single_template::delete('single_template_7');
        td_api_single_template::delete('single_template_8');
        td_api_single_template::delete('single_template_9');
        td_api_single_template::delete('single_template_12');
        td_api_single_template::delete('single_template_13');

        //unregister top bar template yang tidak diperlukan
        td_api_top_bar_template::delete('td_top_bar_template_2');
        td_api_top_bar_template::delete('td_top_bar_template_3');
        td_api_top_bar_template::delete('td_top_bar_template_4');

        //unregister top blok template yang tidak diperlukan
        td_api_block_template::delete('td_block_template_2');
        td_api_block_template::delete('td_block_template_3');
        td_api_block_template::delete('td_block_template_4');
        td_api_block_template::delete('td_block_template_5');
        td_api_block_template::delete('td_block_template_6');
        td_api_block_template::delete('td_block_template_7');
        td_api_block_template::delete('td_block_template_8');
        td_api_block_template::delete('td_block_template_9');
        td_api_block_template::delete('td_block_template_10');
        td_api_block_template::delete('td_block_template_11');
        td_api_block_template::delete('td_block_template_12');
        td_api_block_template::delete('td_block_template_13');
        td_api_block_template::delete('td_block_template_14');
        td_api_block_template::delete('td_block_template_15');
        td_api_block_template::delete('td_block_template_16');
        td_api_block_template::delete('td_block_template_17');

        //unregister unused block
        td_api_block::delete('td_block_1');
        td_api_block::delete('td_block_2');
        td_api_block::delete('td_block_3');
        td_api_block::delete('td_block_4');
        td_api_block::delete('td_block_6');
        td_api_block::delete('td_block_7');
        td_api_block::delete('td_block_8');
        td_api_block::delete('td_block_9');
        td_api_block::delete('td_block_10');
        td_api_block::delete('td_block_11');
        td_api_block::delete('td_block_12');
        td_api_block::delete('td_block_13');
        td_api_block::delete('td_block_17');
        td_api_block::delete('td_block_18');
        td_api_block::delete('td_block_19');
        td_api_block::delete('td_block_20');
        td_api_block::delete('td_block_21');
        td_api_block::delete('td_block_22');
        td_api_block::delete('td_block_23');
        td_api_block::delete('td_block_24');
        td_api_block::delete('td_block_25');

        td_api_block::delete('td_block_big_grid_1');
        td_api_block::delete('td_block_big_grid_2');
        td_api_block::delete('td_block_big_grid_3');
        td_api_block::delete('td_block_big_grid_4');
        td_api_block::delete('td_block_big_grid_5');
        td_api_block::delete('td_block_big_grid_6');
        td_api_block::delete('td_block_big_grid_7');
        td_api_block::delete('td_block_big_grid_8');
        td_api_block::delete('td_block_big_grid_9');
        td_api_block::delete('td_block_big_grid_10');
        td_api_block::delete('td_block_big_grid_11');
        td_api_block::delete('td_block_big_grid_12');
        td_api_block::delete('td_block_big_grid_fl_1');
        td_api_block::delete('td_block_big_grid_fl_2');
        td_api_block::delete('td_block_big_grid_fl_3');
        td_api_block::delete('td_block_big_grid_fl_4');
        td_api_block::delete('td_block_big_grid_fl_5');
        td_api_block::delete('td_block_big_grid_fl_6');
        td_api_block::delete('td_block_big_grid_fl_7');
        td_api_block::delete('td_block_big_grid_fl_8');
        td_api_block::delete('td_block_big_grid_fl_9');
        td_api_block::delete('td_block_big_grid_fl_10');
        td_api_block::delete('td_block_homepage_full_1');
        td_api_block::delete('td_block_popular_categories');

        //unregister unused module
        td_api_module::delete('td_module_1');
        td_api_module::delete('td_module_2');
        td_api_module::delete('td_module_4');
        td_api_module::delete('td_module_5');
        td_api_module::delete('td_module_6');
        td_api_module::delete('td_module_7');
        td_api_module::delete('td_module_8');
        td_api_module::delete('td_module_9');
        td_api_module::delete('td_module_10');
        td_api_module::delete('td_module_11');
        td_api_module::delete('td_module_12');
        td_api_module::delete('td_module_13');
        td_api_module::delete('td_module_14');
        td_api_module::delete('td_module_17');
        td_api_module::delete('td_module_18');
        td_api_module::delete('td_module_19');
        td_api_module::delete('td_module_mx3');
        td_api_module::delete('td_module_mx8');
        td_api_module::delete('td_module_mx16');
        td_api_module::delete('td_module_mx17');
        
        td_api_module::delete('td_module_mx5');
        td_api_module::delete('td_module_mx6');
        td_api_module::delete('td_module_mx9');
        td_api_module::delete('td_module_mx10');
        td_api_module::delete('td_module_mx11');
        td_api_module::delete('td_module_mx12');
        td_api_module::delete('td_module_mx13');
        td_api_module::delete('td_module_mx14');
        td_api_module::delete('td_module_mx15');
        td_api_module::delete('td_module_mx18');
        td_api_module::delete('td_module_mx19');
        td_api_module::delete('td_module_mx20');
        td_api_module::delete('td_module_mx21');
        td_api_module::delete('td_module_mx22');
        td_api_module::delete('td_module_mx23');
        td_api_module::delete('td_module_mx24');
        td_api_module::delete('td_module_mx25');
        td_api_module::delete('td_module_mx26');

        // hapus block yang tidak diperlukan
        td_api_single_template::delete('td_footer_template_14');

        // update module untuk used in block
        td_api_module::update('td_module_8',
            array(
                'file' => td_global::$get_template_directory . '/includes/modules/td_module_8.php',
                'text' => 'Module 8',
                'img' => td_global::$get_template_directory_uri . '/images/panel/modules/td_module_8.png',
                'used_on_blocks' => array('td_block_9'),
                'excerpt_title' => 15,
                'excerpt_content' => '',
                'enabled_on_more_articles_box' => true,
                'enabled_on_loops' => true,
                'uses_columns' => true,
                'category_label' => true,
                'class' => 'td_module_wrap',
                'group' => ''
            )
        );
        td_api_module::update('td_module_mx1',
            array(
                'file' => td_global::$get_template_directory . '/includes/modules/td_module_mx1.php',
                'text' => 'Module MX1',
                'img' => '',
                'used_on_blocks' => array('td_block_14'),
                'excerpt_title' => 25,
                'excerpt_content' => '',
                'enabled_on_more_articles_box' => false,
                'enabled_on_loops' => false,
                'uses_columns' => false,
                'category_label' => true,
                'class' => 'td_module_wrap td-animation-stack',
                'group' => ''
            )
        );

        // Add Custom Blok Homepage

        td_api_block::add('td_block_70s',
            array(
                'map_in_visual_composer' => true,
                'map_in_td_composer' => true,
                "name" => 'Block 70s',
                "base" => 'td_block_70s',
                "class" => 'td_block_70s',
                "controls" => "full",
                "category" => 'Blocks',
                'tdc_category' => 'Blocks',
                'icon' => 'icon-pagebuilder-td_block_70s',
                'file' => $this->plugin_path . '/layout/shortcodes/td_block_70s.php',
                "params" => array_merge(
                    td_config::get_map_block_general_array(),
                    td_config::get_map_filter_array(),
                    td_config::get_map_block_ajax_filter_array(),
                    td_config::get_map_block_pagination_array()
                )
            )
        );

        td_api_module::add('td_module_mx1_70s',
            array(
                'file' => $this->plugin_path . '/layout/modules/td_module_mx1_70s.php',
                'text' => 'Module MX1 Custom 70s',
                'img' => '',
                'used_on_blocks' => array('td_block_70s'),
                'excerpt_title' => 25,
                'excerpt_content' => '',
                'enabled_on_more_articles_box' => true,
                'enabled_on_loops' => true,
                'uses_columns' => true,            
                'category_label' => true,
                'class' => 'td_module_wrap td-animation-stack',
                'group' => '' 
            )
        );

        // Add Custom Footer
        td_api_footer_template::add('td_footer_custom_1',
        array(
            'img' => $this->plugin_url . '/images/panel/footer_templates/icon-footer-custom-1.png',
            'file' => $this->plugin_path . '/parts/footer/td_footer_custom_1.php',
            'text' => 'Style Custom 1'
        )
        );
        
        register_sidebar(array(
            'name'=>'Footer 4',
            'id' => 'td-footer-4',
            'before_widget' => '<aside class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<div class="block-title"><span>',
            'after_title' => '</span></div>'
        ));

        // Add List Author

        td_api_block::add('td_block_custom_list_authors',
        array(
            'map_in_visual_composer' => true,
            'map_in_td_composer' => true,
            "name" => 'Custom List Authors box',
            "base" => "td_block_custom_list_authors",
            "class" => "",
            "controls" => "full",
            "category" => 'Blocks',
            'icon' => 'icon-pagebuilder-td_block_custom_list_authors',
            'file' => $this->plugin_path . '/layout/shortcodes/td_block_custom_list_authors.php',
            "params" => array_merge(
                td_config::get_map_block_general_array(),
                array(
                    array (
                        "param_name" => "roles",
                        "type" => "textfield",
                        "value" => '',
                        "heading" => "User roles","description" => "Optional - Filter by role, add one or more user rolse, separate them with a comma (ex. Administrator, Editor, Author, Contributor, Subscriber). Please see Wordpress Roles and Capabilities",
                        "holder" => "div",
                        "class" => "",
                    ),
                    array(
                        "param_name" => "sort",
                        "type" => "dropdown",
                        "value" => array('- Sort by name -' => '', 'Sort by post count' => 'post_count'),
                        "heading" => 'Sort authors by:',
                        "description" => "",
                        "holder" => "div",
                        "class" => "tdc-dropdown-big",
                    ),
                    array(
                        "param_name" => "exclude",
                        "type" => "textfield",
                        "value" => '',
                        "heading" => "Exclude authors id (, separated)",
                        "description" => "",
                        "holder" => "div",
                        "class" => "",
                    ),
                    array(
                        "param_name" => "include",
                        "type" => "textfield",
                        "value" => '',
                        "heading" => "Include authors id (, separated) - do not use with exclude",
                        "description" => "",
                        "holder" => "div",
                        "class" => "",
                    ),
                    array(
                        'param_name' => 'el_class',
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Extra class',
                        'description' => 'Style particular content element differently - add a class name and refer to it in custom CSS',
                        'class' => 'tdc-textfield-extrabig',
                    ),
                    array (
                        'param_name' => 'css',
                        'value' => '',
                        'type' => 'css_editor',
                        'heading' => 'Css',
                        'group' => 'Design options',
                    ),
                    array (
                        'param_name' => 'tdc_css',
                        'value' => '',
                        'type' => 'tdc_css_editor',
                        'heading' => '',
                        'group' => 'Design options',
                    ),
                )
            )
        )
        );

        //Add list author excerpt
        function list_authors_excerpt ( $content, $limit = 20, $more = '...' ){                      
            return $data = wp_trim_words( strip_tags( $content ), $limit, $more );
        }
        
        
    }
}
new geotimes_custom();