<?php

if(td_util::get_option('td_social_networks_show') == 'show') { ?>
<a class="slide-network">OUR NETWORK</a>
<div class="td-header-sp-top-widget">
    <?php

        //get the socials that are set by user
        $td_get_social_network = td_options::get_array('td_social_networks');

        if(!empty($td_get_social_network)) {
            foreach($td_get_social_network as $social_id => $social_link) {
                if(!empty($social_link)) {
                   echo td_social_icons::get_icon($social_link, $social_id, true);
                }
            }
        }
    ?>
</div>
<?php
}