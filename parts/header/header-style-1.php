<!--
Header style 1
-->
<div class="td-header-wrap td-header-style-1">

    <div class="td-header-top-menu-full td-container-wrap <?php echo td_util::get_option('td_full_top_bar'); ?>">
        <div class="td-container td-header-row td-header-top-menu">
            <?php td_api_top_bar_template::_helper_show_top_bar() ?>
        </div>
    </div>
    <div class="container-fluid networkmedia">
            <div class="row">
                <div class="col-2 linklogo">
                </div>
                <div class="col-md-1 linklogo">
                    <a href="https://setanmerah.net/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/setanmerah.png"></a>
                </div>
                <div class="col-md-1 linklogo">
                    <a href="https://poliklitik.com/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/poliklitik.png"></a>
                </div>
                <div class="col-md-1 linklogo">
                    <a href="https://meramuda.com/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/meramuda.png"></a>
                </div>
                <div class="col-md-1 linklogo">
                    <a href="https://geolive.id/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/geolive.png"></a>
                </div>
                <div class="col-md-1 linklogo">
                    <a href="https://inikpop.com/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/inikpop.png"></a>
                </div>
                <div class="col-md-1 linklogo">
                    <a href="https://ligalaga.id/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/ligalaga.png"></a>
                </div>
                <div class="col-md-1 linklogo">
                    <a href="http://infojakarta.net/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/infojakarta.png"></a>
                </div>
                <div class="col-md-1 linklogo">
                    <a href="http://gizmo.id/" target="_blank"><img class="logonetwork" src="<?php echo get_stylesheet_directory_uri()?>/logo/gizmo.png"></a>
                </div>
                <div class="col-2 linklogo">
                </div>
            </div>
    </div>

    <div class="td-banner-wrap-full td-logo-wrap-full td-container-wrap <?php echo td_util::get_option('td_full_header'); ?>">
        <div class="td-container td-header-row td-header-header">
            <div class="td-header-sp-logo">
                <?php locate_template('parts/header/logo-h1.php', true);?>
            </div>
            <div class="td-header-sp-recs">
                <?php locate_template('parts/header/ads.php', true); ?>
            </div>
        </div>
    </div>

    <div class="td-header-menu-wrap-full td-container-wrap <?php echo td_util::get_option('td_full_menu'); ?>">
        <div class="td-header-menu-wrap td-header-gradient">
            <div class="td-container td-header-row td-header-main-menu">
                <?php locate_template('parts/header/header-menu.php', true);?>
            </div>
        </div>
    </div>
</div>