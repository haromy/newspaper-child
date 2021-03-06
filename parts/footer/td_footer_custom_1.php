<?php
  $favicon = td_util::get_option('tds_favicon_upload');
  $copyright = stripslashes(td_util::get_option('tds_footer_copyright'));
?>
  <div class="container-fluid footer-top">
    <footer class="container text-white">
        <div class="row">
          <div class="col-1">
              <i class="fa fa-chevron-up fa-lg fa-border fa-custom-scroll" aria-hidden="true"></i>
          </div>
        </div>
        <div class="row sub-footer-menu">
            <div class="col">
              <div class="row">
                <?php
                  wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'menu_class' => 'footer-menu',
                    'fallback_cb' => 'td_wp_top_menu',
                    'container_class' => 'col menu'
                  ));
                ?> 
              </div>
            </div>  
        </div>
    </footer>
  </div>
  <div class="container-fluid footer-bottom">
    <footer class="container text-white">
      <div class="row pb-5">
        <div class="col-md-12 col-lg-4">
        </div>
        <div class="col-6 col-md-3 col-lg-2 borderkiri">
              <?php
                td_global::vc_set_custom_column_number(1);
                dynamic_sidebar('Footer 1');
              ?>
        </div>
        <div class="col-6 col-md-3 col-lg-2 borderkiri">
            <?php
              td_global::vc_set_custom_column_number(1);
              dynamic_sidebar('Footer 2');
            ?>
        </div>
        <div class="col-6 col-md-3 col-lg-2 borderkiri">
            <?php
              td_global::vc_set_custom_column_number(1);
              dynamic_sidebar('Footer 3');
            ?>
        </div>
        <div class="col-6 col-md-3 col-lg-2 borderkiri">
            <?php
              td_global::vc_set_custom_column_number(1);
              dynamic_sidebar('Footer 4');
            ?>
        </div>
      </div>
      <div class="row custom-footer-bottom">
        <div class="col-xs-12">
          <h6 class="text-bold pt-1 copyright"><?php echo $copyright; ?></h6>
        </div>
      </div>
    </footer>
  </div>