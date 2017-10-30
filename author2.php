<?php
/*
Template Name: Author List Page 2
*/
get_header();
echo "<div class='container'>";
echo "<div class='row'>";
$number = 12;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset = ($paged - 1) * $number;

$args = array(
    'orderby' => 'name',
    'order' => 'ASC',
);
$users = get_users($args);

$args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'number' => $number,
    'offset' => $offset
);
$meber_arr = get_users($args);

$total_users = count($users);
$total_query = count($meber_arr);
$total_pages = ceil($total_users / $number);

foreach ($meber_arr as $userdata) {
    $buffy = '';
    $buffy .= '<div class="col-12 col-md-6 col-lg-6 col-xl-4 authorcol">';// open col
    $buffy .= '<div class="author-box">';
        $buffy .='<div class="avatar">';
            $buffy .= '<a href="' . get_author_posts_url($userdata->ID) . '">' . get_avatar($userdata->user_email, '70') . '</a>';
        $buffy .= '</div>';
        $buffy .='<div class="meta-desc">';
            $buffy .= '<a href="' . $userdata->user_url . '">' .$userdata->display_name. '</a>' ;
            $buffy .= '<div class="custom-join-date">';
                $buffy .= 'Menulis sejak ';
                $buffy .= '<span>';
                $buffy .= date( "M Y", strtotime( $userdata->user_registered));
                $buffy .= '</span>';
            $buffy .= '</div>';
            $buffy .= '<div class="excerpt-desc">';
            $buffy .= list_authors_excerpt( get_the_author_meta('description', $userdata->ID) , 15 );
            $buffy .= '</div>';
        $buffy .= '</div>';
    $buffy .= '</div>'; // close author box
    $buffy .= '</div>'; // close col
    echo $buffy;
}

$big = 999999999; // need an unlikely integer
$mypagei = paginate_links(array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format' => '&p=%#%',
    'prev_text' => __('« Previous'),
    'next_text' => __('Next »'),
    'total' => $total_pages,
    'current' => $paged,
    'end_size' => 1,
    'mid_size' => 4,
));

if ($mypagei != '') {
echo "<div class='col-12 center'>".$mypagei."</div>"; 
}
echo "</div>";
echo "</div>";
get_footer();
?>