# newspaper-child by Geomedia Group
Customize Wordpress Theme using Newspaper<br />
company : [Geomedia Group](https://geomedia.id/)

# team :
1. [Fariz Darmaniar](https://www.linkedin.com/in/haromy/) - backend developer
2. [Fathhana E.](https://www.linkedin.com/in/fathhana-euclidea/) - frontend developer
3. [idham rahmanarto](https://www.linkedin.com/in/idham-rahmanarto-1257a348/) - UI UX designer

task list
- [x] \(core) custom header
- [x] \(core) custom slider
- [x] \(core) custom block headline 1
- [x] \(core) custom block headline 2
- [x] \(core) use bootstrap grid
- [x] \(core) custom single layout
- [x] \(core) custom layout related article in single layout
- [x] \(core) custom layout by category in footer single layout
- [x] \(core) custom block sidebar
- [x] \(core) custom block footer
- [x] \(core) custom block homepage
- [x] \(core) custom block card (3 row )
- [x] \(core) custom block card (2 row )
- [x] \(core) remove header style 2 - 13
- [x] \(core) custom author list
- [x] \(core) remove unused footer style
- [x] \(core) remove unused block + module

additional task list
- [x] fixing td_block_70s  row, col layout (30/10/2017)
- [x] fixing td_module_mx1_70s image size (30/10/2017)
- [x] fixing font style (30/10/2017)
- [x] fixing bug login page on mobile (30/10/2017)
- [x] add Din Pro regular + bold in CSS (30/10/2017)
- [x] fix footer - used favicon , get copyright text from theme panel, remove subscriber email, remove scroll to top icon (30/10/2017)
- [x] fix single layout font style (30/10/2017)
- [x] adding custom author page layout 1 & layout 2 (30/10/2017)
- [x] remove author layout 1 (31/10/2017)
- [x] edit autor page list layout (31/10/2017)
- [x] add ccs style 15 (Elegant Yet Approachable) (31/10/2017)
- [x] bugfix block sidebar (31/10/2017)
- [x] bugfix card style (01/11/2017)
- [x] add promoted row in single layout (01/11/2017)
- [x] add fetch wp api from another website in single layout (01/11/2017)
- [x] add style css 18 (contemporary and bold) - #1a1a1d - #4e4e50 - #6f2232 - #950740 - #c3073f (01/11/2017)

06/11/2017
- [x] fix headline
- [x] card homepage
- [x] fix single page

07/11/2017
- [x] fix single layout featured image
- [x] update footer (add border, fix layout)
- [x] add fontawesome
- [x] fix share button + author box in single layout
- [x] add sticky share buttom in mobile

08/11/2017
- [x] bugfix mobile share button
- [x] bugfix top menu
- [x] bugfix single layout geotimes
- [x] add single layout meramuda

09/11/2017
- [x] Add sidebar widget




# require :
edit file di newspaper core <br />
/Newspaper/includes/wp_booster/wp-admin/panel/views/td_panel_post_settings.php<br />
masukkan code dibawah di line : 407


    <div class="td-box-section-separator"></div>
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Kategori yang dimunculkan setelah artikel</span>
            <p>Masukkan ID dari kategori yang akan dimunculkan</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_kategori_after_footer'
            ));
            ?>
        </div>
    </div>
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Jumlah Post</span>
            <p>Masukkan jumlah post yang akan dimunculkan<br></p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_kategori_after_footer_limit'
            ));
            ?>
        </div>
    </div>

    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Related Kategori Footer</span>
            <p>Masukkan ID dari setiap kategori yang akan dimunculkan<br> dipisahkan dengan tanda baca ','</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_kategori_related'
            ));
            ?>
        </div>
    </div>
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">Jumlah Post</span>
            <p>Masukkan jumlah post yang akan dimunculkan<br></p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::input(array(
                'ds' => 'td_option',
                'option_id' => 'tds_jumlah_post'
            ));
            ?>
        </div>
    </div>
