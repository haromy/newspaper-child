<div class="td-container-wrap footer-custom-1 <?php echo td_util::get_option('td_full_footer'); ?>">
    <footer class="sub-footer text-white">
        <div class="row px-3 pt-1 td-scroll-up custom-scroll-top">
          <a href="#">
            <img src="http://localhost/tes_inikpop/wp-content/uploads/2017/10/back-icon.png" style="width:40px; height:46px;">
            <span class="text-white ml-2">Back to top</span>
          </a>
        </div>
        <div class="row sub-footer-menu">
            <div class="col-sm-10 col-md-8">
            <ul class="mb-0 pl-0 float-left">
              <li class="custom-home"><a href="<?php echo esc_url(home_url( '/' )); ?>"><img src="http://localhost/tes_inikpop/wp-content/uploads/2017/10/home-icon.png" style="width:25px"></a></li>
              <?php
                wp_nav_menu(array(
                  'theme_location' => 'footer-menu',
                  'menu_class' => 'footer-menu',
                  'fallback_cb' => 'td_wp_top_menu',
                  'container_class' => 'menu-top-container'
                ));
              ?> 
            </ul>
            </div>  
            <div class="col-sm-2 col-md-4 footer-geo-network text-center">
                <a href="#" class="mb-0">
                  <img src="http://localhost/tes_inikpop/wp-content/uploads/2017/10/icon-ex.png" style="width: 20px; margin-right:10px;"> GEOMEDIA NETWORK
                </a>
            </div>  
        </div>
    </footer>
    <footer class="footer custom-footer text-white pb-2">
      <div class="row pb-5">
        <div class="col-md-12 col-lg-4">
          <p class="sign-up-email">Sign up to our daily email</p>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Email address" aria-label="Email address">
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="button">Sign up</button>
            </span>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 pl-0">
          <ul class="pl-0">
              <?php
                td_global::vc_set_custom_column_number(1);
                dynamic_sidebar('Footer 1');
              ?>
          </ul>
        </div>
        <div class="col-md-6 col-lg-2 pl-0">
          <ul class="pl-0">
            <?php
              td_global::vc_set_custom_column_number(1);
              dynamic_sidebar('Footer 2');
            ?>
          </ul>
        </div>
        <div class="col-md-6 col-lg-2 pl-0">
          <ul class="pl-0">
            <?php
              td_global::vc_set_custom_column_number(1);
              dynamic_sidebar('Footer 3');
            ?>
          </ul>
        </div>
        <div class="col-md-6 col-lg-2 pl-0">
          <ul class="pl-0">
            <?php
              td_global::vc_set_custom_column_number(1);
              dynamic_sidebar('Footer 4');
            ?>
          </ul>
        </div>
      </div>
      <div class="row custom-footer-bottom">
        <div class="col-xs-12">
          <p class="text-bold pt-1">INDONESIA OPINION PAGE | ACTUAL CRITICAL INSPIRING</p>
        </div>
      </div>
    </footer>
</div>