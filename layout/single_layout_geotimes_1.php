<?php
// Template Geotimes 1

locate_template('includes/wp_booster/td_single_template_vars.php', true);

get_header();

global $loop_sidebar_position, $td_sidebar_position, $post;

$td_mod_single = new td_module_single_geotimes_1($post);


?>
<div class="td-main-content-wrap td-container-wrap">

    <div class="template-geotimes-1">
        <article id="post-<?php echo $td_mod_single->post->ID;?>" class="<?php echo join(' ', get_post_class());?>" <?php echo $td_mod_single->get_item_scope();?>>
            <div class="post-header">
                <!-- breadcrumb -->
                <div class="container breadcrumb">
                    <div class="row">
                        <div class="col">
                            <div class="td-crumb-container"><?php echo td_page_generator::get_single_breadcrumbs($td_mod_single->title); ?></div>
                                <?php
                                $tds_post_style_12_title = td_util::get_option('tds_post_style_12_title');

                                // ad spot
                                echo td_global_blocks::get_instance('td_block_ad_box')->render(array('spot_id' => 'post_style_12', 'spot_title' => $tds_post_style_12_title));
                                ?>
                        </div>
                    </div>
                </div>
                <!-- judul artikel -->
                <div class="container headpost">
                    <div class="row">
                        <div class="col-xl-2">
                            <?php echo $td_mod_single->get_category_geotimes(); ?>
                        </div>
                        <div class="col-xl-6">
                            <?php echo $td_mod_single->get_title_geotimes();?>
                            <div class="td-module-meta-info">
                                <?php echo $td_mod_single->get_author_geotimes();?>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            
                        </div>
                    </div>
                </div>
                <!-- subtitle -->
                <div class="container-fluid sub-meta">
                    <div class="row subtitle">
                        <div class="container">
                            <div class="row">
                            <div class="col-xl-6 offset-xl-2">
                                <div class="text"><?php get_the_subtitle( $post ); ?></div>
                                <?php if (!empty($td_mod_single->td_post_theme_settings['td_subtitle'])) { ?>
                                    <p class="td-post-sub-title"><?php echo $td_mod_single->td_post_theme_settings['td_subtitle'];?></p>
                                <?php } ?>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- featured image -->
                <div class="container featured-image">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="td-post-content">
                                    <?php
                                    if (!empty(td_global::$load_featured_img_from_template)) {
                                        echo $td_mod_single->get_image(td_global::$load_featured_img_from_template);
                                    } else {
                                        echo $td_mod_single->get_image('td_696x385');
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 hidden-md-down">
                                <div class="judulartikelpoliklitik">KARTUN HARI INI</div>
                                <div class="postingpoliklitik"></div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="container post-content">
                    <?php

                    //the default template
                    switch ($loop_sidebar_position) {
                        default:
                            ?>  
                            <div class="row">
                                <div class="col-lg-8 main-content" role="main">
                                    <div class="row">
                                        <div class="col-xl-3 td-module-meta-info social-sharing-top">
                                            <?php echo $td_mod_single->get_social_sharing_top_geotimes();?>
                                            <div class="row kiri">
                                                <div class="col-6 col-lg-3 col-xl-6"><?php echo $td_mod_single->get_views();?></div>
                                                <div class="col-6 col-lg col-xl-6"><?php echo $td_mod_single->get_comments();?></div>
                                            </div>
                                            <?php echo $td_mod_single->get_date(false);?>
                                        </div>
                                        <div class="col-xl-9">
                                            <?php
                                                locate_template('/layout/loop-single-geotimes-1.php', true);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-4 td-main-sidebar" role="complementary">
                                    <div class="td-ss-main-sidebar hidden-md-down">
                                        <?php get_sidebar(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row social-sharing-bottom">
                                <div class="col-lg-8 col-xl-6 offset-xl-2 border">
                                    <?php echo $td_mod_single->get_social_sharing_bottom_geotimes();?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 col-xl-6 offset-xl-2">
                                    <?php echo $td_mod_single->get_next_prev_posts();?>
                                </div>
                            </div>
                            <div class="row box-author">
                                <div class="col-lg-8 col-xl-6 offset-xl-2">
                                    <?php echo $td_mod_single->get_author_box();?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <?php echo do_shortcode('[fbcomments count="off"]');?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <?php comments_template('', true);?>
                                </div>
                            </div>
                            </div>
                            <div class="container-fluid mgid">
                            <div class="row">
                                <div class="container">
                                    <div class="col-12">
                                        <!-- Composite Start -->
                                        <div id="M284964ScriptRootC172279">
                                                <div id="M284964PreloadC172279">
                                                Loading...
                                            </div>
                                                <script>
                                                        (function(){
                                                    var D=new Date(),d=document,b='body',ce='createElement',ac='appendChild',st='style',ds='display',n='none',gi='getElementById';
                                                    var i=d[ce]('iframe');i[st][ds]=n;d[gi]("M284964ScriptRootC172279")[ac](i);try{var iw=i.contentWindow.document;iw.open();iw.writeln("<ht"+"ml><bo"+"dy></bo"+"dy></ht"+"ml>");iw.close();var c=iw[b];}
                                                    catch(e){var iw=d;var c=d[gi]("M284964ScriptRootC172279");}var dv=iw[ce]('div');dv.id="MG_ID";dv[st][ds]=n;dv.innerHTML=172279;c[ac](dv);
                                                    var s=iw[ce]('script');s.async='async';s.defer='defer';s.charset='utf-8';s.src="//jsc.mgid.com/g/e/geotimes.co.id.172279.js?t="+D.getYear()+D.getMonth()+D.getDate()+D.getHours();c[ac](s);})();
                                            </script>
                                        </div>
                                        <!-- Composite End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="container">
                                        <div class="col hidden-lg-up">
                                        <div class="judulartikelpoliklitik">KARTUN HARI INI</div>
                                        <div class="postingpoliklitik"></div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid related-artikel">
                                <div class="row">
                                    <div class="container">
                                        <?php echo $td_mod_single->related_posts_geotimes();?>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid opini-artikel">
                                <div class="container">
                                    <?php echo $td_mod_single->opini_posts_geotimes();?>
                                </div>
                            </div>
                            <div class="container-fluid footer-artikel">
                                <div class="container">
                                    <?php echo $td_mod_single->related_footer_geotimes();?>
                                </div>
                            </div>
                            <div class="container-fluid footer-sticky-bottom">
                                <div class="sticky-bottom">
                                <?php echo $td_mod_single->get_social_sharing_bottom_geotimes();?>
                                </div>
                            </div>
                            <?php
                            break;

                        case 'sidebar_left':
                            ?>
                            <div class="row">
                            <div class="col-8 td-main-content <?php echo $td_sidebar_position; ?>-content" role="main">
                                <div class="td-ss-main-content">
                                    <?php
                                    locate_template('/layout/loop-single-geotimes-1.php', true);
                                    comments_template('', true);
                                    ?>
                                </div>
                            </div>
                            <div class="col-4 td-main-sidebar" role="complementary">
                                <div class="td-ss-main-sidebar">
                                    <?php get_sidebar(); ?>
                                </div>
                            </div>
                            </div>
                            <?php
                            break;

                        case 'no_sidebar':
                            td_global::$load_featured_img_from_template = 'td_1068x0';
                            ?>
                            <div class="row">
                            <div class="col-12 td-main-content" role="main">
                                <div class="td-ss-main-content">
                                    <?php
                                    locate_template('/layout/loop-single-geotimes-1.php', true);
                                    comments_template('', true);
                                    ?>
                                </div>
                            </div>
                            </div>
                            <?php
                            break;

                    }
                    ?>
        </article>
    </div>
</div>

<?php

get_footer();