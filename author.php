<?php
/*
Template Name: Author List Page
*/

get_header();

function duiwel_custom_list_users($args = '') {
    global $wpdb;
    $defaults = array(
        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
        'optioncount' => false, 'exclude_admin' => true,
        'show_fullname' => false, 'hide_empty' => false,
        'feed' => 'feed', 'feed_image' => '', 'feed_type' => 'rss2', 'echo' => true,
        'style' => 'list', 'html' => true
    );

    $args = wp_parse_args( $args, $defaults );
    extract( $args, EXTR_SKIP );

    $return = '';

    $query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number' ) );
    $query_args['fields'] = 'ids';
    $authors = get_users( $query_args );

    
    $author_count = array();
    foreach ((array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author") as $row )
        $author_count[$row->post_author] = $row->count;
        // need to count 'authors' here
        $totalusers = count($authors);
        // PAGINATION 
        $numrows = $totalusers;
        // number of rows to show per page
        $rowsperpage = 12;
        // find out total pages
        $totalpages = ceil($numrows / $rowsperpage);
        // get the current page or set a default
        if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
        // cast var as int
        $currentpage = (int) $_GET['currentpage'];
        } else {
        // default page num
        $currentpage = 1;
        } // end if
        // if current page is greater than total pages...
        if ($currentpage > $totalpages) {
        // set current page to last page
        $currentpage = $totalpages;
        } // end if
        // if current page is less than first page...
        if ($currentpage < 1) {
        // set current page to first page
        $currentpage = 1;
        } // end if

        // the offset of the list, based on current page 
        $offset = ($currentpage - 1) * $rowsperpage;
        // END PAGINATION
        // PAGINATION TO FOLLOW ARRAY

        //I need to take the SQL LIMIT function from the pagination code I found
        //and incorporate it into the arrays I'm using, cause I'm not actually
        //querying a SQL table, I'm querying an array

        $pagination_user_table = $authors;
        $paged_authors = array_slice( $pagination_user_table , $offset , $rowsperpage );
        // START NORMAL WP_LIST_AUTHOR 


    foreach ( $paged_authors as $author_id ) {
        $author = get_userdata( $author_id );
        if ( $exclude_admin && 'admin' == $author->display_name )
            continue;
        $posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;
        if ( !$posts && $hide_empty )
            continue;
        $link = '';
        if ( $show_fullname && $author->first_name && $author->last_name )
            $name = "$author->first_name $author->last_name";
        else
            $name = $author->display_name;
        if ( !$html ) {
            $return .= $name . ', ';
            continue; // No need to go further to process HTML.
        }
        if ( 'list' == $style ) {
            $return .= '';
        }
        //some extra Avatar stuff
        $avatar = 'wavatar';
        $link = '<div class="td_mod_wrap td-pb-padding-side item-list-author col-6 col-md-4">'; // open col
            $link .= '<div class="custom-item-details">'; // open custom item
                $link .= '<div class="item-details">'; // open item details
                    $link .= '<a href="' . get_author_posts_url($author->ID) . '">' . get_avatar($author->user_email, '70') . '</a>';
                    
                    $link .= '<div class="custom-author-list-name">';
                        $link .= '<a href="' . get_author_posts_url($author->ID) . '">' . $author->display_name . '</a>';
                    $link .= '</div>';

                    $link .= '<div class="custom-join-date">';
                        $link .= 'Menulis di Geotimes sejak ';
                        $link .= '<span>'.date( "j M Y", strtotime( $author->user_registered)).'</span>';
                    $link .= '</div>';

                    $link .= '<span class="custom-author-post-count">';
                    $link .= count_user_posts($author->ID). ' '  . __td('tulisan', TD_THEME_NAME);
                    $link .= '</span>';

                    $link .= '<div class="custom-author-description">';
                    $link .= list_authors_excerpt( get_the_author_meta('description', $author->ID) , 13 );
                    $link .= '</div>';
                
                $link .= '</div>'; // close item-detail
            $link .= '</div>'; // close custom item
        $link .= '</div>'; // close col
        $return .= $link;
    }

    $return = rtrim($return, ', ');

    if ( !$echo )
        return $return;
    echo $return;

        /////////////////////////////////////////
        ////// END WP_LIST_AUTHOR NORMALCY //////
        /////////////////////////////////////////
    // little spacer
    echo "<br/><br/>";
        //////////////////////////////
        ////// PAGINATION LINKS //////
        //////////////////////////////
        
/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show back links
if ($currentpage > 1) {
   // show << link to go back to page 1

   echo " <a href=' " , the_permalink() , "?currentpage=1'><<</a> ";

   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page

      echo " <a href=' " , the_permalink() , "?currentpage=$prevpage'><</a> ";



} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " [<b>$x</b>] ";
      // if not current page...
      } else {
         // make it a link
        echo " <a href=' " , the_permalink() , "?currentpage=$x'>$x</a> ";


      } // end else
   } // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page 

            echo " <a href=' " , the_permalink() , "?currentpage=$nextpage'>></a> ";

   // echo forward link for lastpage

            echo " <a href=' " , the_permalink() , "?currentpage=$totalpages'>>></a> ";


}
}




?>

<div id="directorylist" class="container">
    <div class="row">
        <?php duiwel_custom_list_users() ?>
    </div>
</div>

<?php get_footer(); ?>