<?php

/* Set up the Presenters and Programmes as custom post types*/
if ( ! function_exists('custom_post_type') ) {

// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                => _x( 'Presenters', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Presenter', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Presenters', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Presenter', 'text_domain' ),
		'all_items'           => __( 'All Presenters', 'text_domain' ),
		'view_item'           => __( 'View Presenter', 'text_domain' ),
		'add_new_item'        => __( 'Add New Presenter', 'text_domain' ),
		'add_new'             => __( 'New Presenter', 'text_domain' ),
		'edit_item'           => __( 'Edit Presenter', 'text_domain' ),
		'update_item'         => __( 'Update Presenter', 'text_domain' ),
		'search_items'        => __( 'Search presenters', 'text_domain' ),
		'not_found'           => __( 'No presenters found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No presenters found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'presenter', 'text_domain' ),
		'description'         => __( 'Presenter information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'          => array('post_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-groups',
		'can_export'          => true,
		'has_archive'         => true, //IMPORTANT - we use archives to show all presenters on one page
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
    'rewrite' => array('slug' => 'presenters'),
	);
	register_post_type( 'presenter', $args );
  
  	$labels2 = array(
		'name'                => _x( 'Programmes', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Programme', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Programmes', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Programme', 'text_domain' ),
		'all_items'           => __( 'All Programmes', 'text_domain' ),
		'view_item'           => __( 'View Programme', 'text_domain' ),
		'add_new_item'        => __( 'Add New Programme', 'text_domain' ),
		'add_new'             => __( 'New Programme', 'text_domain' ),
		'edit_item'           => __( 'Edit Programme', 'text_domain' ),
		'update_item'         => __( 'Update Programme', 'text_domain' ),
		'search_items'        => __( 'Search Programmes', 'text_domain' ),
		'not_found'           => __( 'No Programmes found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Programmes found in Trash', 'text_domain' ),
	);
	$args2 = array(
		'label'               => __( 'programme', 'text_domain' ),
		'description'         => __( 'Programme information pages', 'text_domain' ),
		'labels'              => $labels2,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'          => array('post_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-album',
		'can_export'          => true,
		'has_archive'         => true, //IMPORTANT - we use archives to show all Programmes on one page
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
    'rewrite' => array('slug' => 'programmes'),
	);
	register_post_type( 'programme', $args2 );


}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );

}



//Add new query vars that the schedule page can use
//Also need to add a rewrite rule so we can parse the variables out.
//This allows us to use new-schedule/{year}/{month}/{day} to see the schedule

function wpse49393_query_vars($query_vars)
{
    $query_vars[] = 'dyear';
    $query_vars[] = 'dmonthnum';
    $query_vars[] = 'dday';
    return $query_vars;
}
add_filter('query_vars', 'wpse49393_query_vars');

function wpse49393_rewrite_rules_array($rewrite_rules)
{
    $rewrite_rules['schedule/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$'] = 'index.php?pagename=schedule&dyear=$matches[1]&dmonthnum=$matches[2]&dday=$matches[3]';
    return $rewrite_rules;
}
add_filter('rewrite_rules_array', 'wpse49393_rewrite_rules_array');
//*/
//End add query vars


$templatePath = get_stylesheet_directory();

//SOME USEFUL CONSTANTS

//the below is to initiate the google-api-php-client functions needed to parse the 
//google calendar.
//This repleces the Zend method used previously
// Here may not be the best place, but it'll do.
define('GOOGLE_API_LIB', $templatePath . '/google-api-php-client'); 
set_include_path(GOOGLE_API_LIB); //defined in functions.php
require_once (GOOGLE_API_LIB . '/autoload.php');
require_once (GOOGLE_API_LIB . '/src/Google/Client.php');
require_once (GOOGLE_API_LIB . '/src/Google/Service/Calendar.php');

date_default_timezone_set('Europe/London');

/* Queries the calendar in question and brings back some data
 * This function also formats it for us. In this case we want a list
 * 
 * name: outputCalendarByDateRange
 * @param
 * @return
 * 
*/
function outputCalendarByDateRange($startDate, $endDate) 
{
  // Google API Service Account info (NB it is important that this is a 'Service" account
  // Using the google-api-php-client, we are required to connect using a google 
  // developer account. The account credentials are in caprenter's account
  // Thanks to https://mytechscraps.wordpress.com/2014/05/15/accessing-google-calendar-using-the-php-api/
  global $templatePath;
  include ($templatePath . '/google-api-credentials.php'); //$client_id, $service_account_name, $key_file_location
  
  
  // Calendar id
  $calName = '0u75pl2eviul8pl1tcnsra3810@group.calendar.google.com';

  // Make a connection to google
  $client = new Google_Client();
  $client->setApplicationName("Calendar test");

  $service = new Google_Service_Calendar($client);

  $key = file_get_contents($key_file_location);
  $cred = new Google_Auth_AssertionCredentials(
   $service_account_name,
   array('https://www.googleapis.com/auth/calendar.readonly'),
   $key
  );

  $client->setAssertionCredentials($cred);
  
  $optParams = array("orderBy" => "startTime");
  $optParams = array("singleEvents" => true,
                      "timeMin" => $startDate,
                      "timeMax" => $endDate,
                      "orderBy" => "startTime",
                      "maxResults" => 2500);
  
  try {
    $events = $service->events->listEvents($calName, $optParams);
    return $events;
  
  } catch (Exception $e) {
    // Report the exception to the user
    echo "<div style=\"width:450px; \">\n";
    echo "Sorry, we can't connect to the calendar just now.";
    echo "</div>\n";

  }
}

/* Function to display the output of a google calendar feed as a list
 * 
 * name: theme_schedule_list
 * @param object $events Data returned from GCal feed.
 * @return
 * 
 */

function theme_schedule_list($events) {
  echo '<div class="schedule-list">';
  $i=0;
  foreach ($events->getItems() as $event) {
    //Check to see if the programme is on now, in the future or in the past
    $status = programme_status($event->start->dateTime, $event->end->dateTime);  
    //Build the output
    echo '<div class="programme ' . $status . '">';
    
    //Formats the time
    echo '<div class="programme_start">' . date('G:i',strtotime($event->start->dateTime));
    if ($status == "on") { echo '<div class="on-air">On Air</div>'; }
    echo '</div>';
    
    //Formats the programme infomation
    echo '<div class="programme_description">';
    
    //Title
    echo '<h4 class="title">';
    //create a link to the programme page
    $prog_link = trim($event->summary); //trim spaces
    
    //Create the slug
    $programme_slug = sanitize_title($prog_link); //Use the inbuilt wordpress function to clean the sting to make a slug
    //$programme_slug = preg_replace("/ /","-",$prog_link);
    //$programme_slug = strtolower($programme_slug);
    //Replace the presenter in the description text with a link
    $page = get_page_by_path( $programme_slug , OBJECT, 'programme' );
    if ( isset($page) ) {
        echo '<a class="presenter_link" href="http://www.bcbradio.co.uk/programmes/' . $programme_slug . '">' . $prog_link . '</a>';
    } else {
        echo htmlentities($event->summary);
    }
    echo '</h4>';
    
    //Description
    if (strlen($event->description)>0) {
      //Add links to presenter pages if presenter info is given
      //This is done by looking for the string; "Presented by: " which should then be followed by a comma separted list of presenters.
      //presenter names are turned into slugs that should match pages on the site
      $event->description = strip_tags($event->description,'<br><a>'); //Strip out any rogue html that may be there, but keep line breaks
      $presenter_check = explode("Presented by: ",$event->description);

      if (isset($presenter_check[1])) { //A string that doesn't contain the delimiter will simply return a one-length array of the original string.
        $presenters  = explode(',',$presenter_check[1]); //This should give an arry of each presenter name
        foreach ($presenters as $presenter) {
           //replace the string with a link
           $presenter = trim($presenter); //trim spaces

           //Create the slug
           $presenter_slug = sanitize_title($presenter); //using inbuilt wordpress function to create slug from string
           //$presenter_slug = preg_replace("/ /","-",$presenter);
           //$presenter_slug = strtolower($presenter_slug);

           //Replace the presenter in the description text with a link
           $page = get_page_by_path( $presenter_slug , OBJECT, 'presenter' );
			   if ( isset($page) ) {
					$event->description = preg_replace('/'. $presenter . '/', '<a class="presenter_link" href="http://www.bcbradio.co.uk/presenters/' . $presenter_slug . '">' . $presenter . '</a>', $event->description);
				}
        }
      }
      echo '<p>';
      echo  nl2br($event->description);
      if ($status == "on") { echo '<br /><a class="listen-live" href="http://www.bcbradio.co.uk/player/"><img src="http://www.bcbradio.co.uk/wp-content/uploads/play_button.png"/><span>Listen Live</span></a>'; }
    }
        echo '</p></div></div>';
  }
  echo '</div><div class="clear"></div>';
}
  

/* Function to display the show that is on air now
 * takes a list of shows/events from the google calendar
 * and checkes to see ifany of them are 'on now'
 * 
 * name: theme_on_air_now
 * @param object $events Data returned from GCal feed.
 * @return
 * 
 */

function theme_on_air_now($events) {
  
  foreach ($events->getItems() as $event) { //looping through each event
      
      //Check to see if the programme is on now, in the future or in the past
      $status = programme_status($event->start->dateTime, $event->end->dateTime);  
      if ($status == "on") {
        $found_on_air_event = true;
        echo '<a class="on-air-link" href="http://www.bcbradio.co.uk/player/" target="name"';
        echo " onclick=\"window.open('http://www.bcbradio.co.uk/player/index.html','name','height=665, width=380,toolbar=no,directories=no,status=no, menubar=no,scrollbars=no,resizable=no'); return false;\">";
        echo '<div class="listenlive">On Air Now</div>';
        echo '<span class="event-datetime">' . date('D jS M H:i',strtotime($event->start->dateTime)) . ' - ' .date('H:i',strtotime($event->end->dateTime)) . '</span>';

        //Formats the programme infomation
        echo '<div class="listenlive-title">';
          //Title
          echo '<h4 class="on-now-title">';
          echo htmlentities($event->summary);  
          echo '</h4></a>';
      
        //Description
        if (strlen($event->description)>0) {
		$presenter_check = explode("Presented by: ",$event->description);
			if (isset($presenter_check[1])) {
			$presenters  = explode(',',$presenter_check[1]);
			foreach ($presenters as $presenter) {
			   $presenter = trim($presenter);
			   $presenter_slug = preg_replace("/ /","-",$presenter);
			   $presenter_slug = strtolower($presenter_slug);
			   $page = get_page_by_path( $presenter_slug , OBJECT );
			   if ( isset($page) ) {
					$event->description = preg_replace('/'. $presenter . '/', '<a class="presenter_link" href="http://www.bcbradio.co.uk/presenters/' . $presenter_slug . '">' . $presenter . '</a>', $event->description);
				}
			}}	
          echo '<p class="on-now-description">';
          echo  nl2br($event->description);
          
          echo '<a class="listenlive-txt" href="http://www.bcbradio.co.uk/player/" target="name"';
          echo " onclick=\"window.open('http://www.bcbradio.co.uk/player/index.html','name','height=665, width=380,toolbar=no,directories=no,status=no, menubar=no,scrollbars=no,resizable=no'); return false;\">";
          echo 'Listen Live <img src="http://www.bcbradio.co.uk/wp-content/uploads/play_button.png"/></a>';
        } 
          echo '</p></div>';
      }
  }//end foreach event
  
  //If we have looped through everything and not found anything on air
  //Show some default text instead
  if (!isset($found_on_air_event)) { //Nothing on!
    echo '<div class="textwidget"><a href="http://www.bcbradio.co.uk/player/" target="name"';
    echo " onclick=\"window.open('http://www.bcbradio.co.uk/player/index.html','name','height=665, width=380,toolbar=no,directories=no,status=no, menubar=no,scrollbars=no,resizable=no'); return false;\" style=\"display:block; width:100%; margin:0 auto;\">";
    echo '<div class="standby">Listen Live Now <img src="http://www.bcbradio.co.uk/wp-content/uploads/play_button.png"/></div>';
    echo '<div class="listenlive-link">bcbradio.co.uk/player</div></a></div>';
  }
}


/* given a time object from the Zend data (with start and end time in it)
 * this function can tell if the assosiated event is on now, has finished
 * or is in the future 
 * 
 * name: programme_status
 * @param $when An object containing start and end time information
 * @return string future/past/om
 * 
*/
function programme_status ($start,$end) {
  $time_now = time();
  if (strtotime($start) > $time_now) {
    $status = "future";
  } elseif (strtotime($end) < $time_now) {
    $status = "past";
  } else {
    $status = "on";
  }
  return $status;
}


// Creating the On Air Now widget 
//Thanks to
//http://www.wpbeginner.com/wp-tutorials/how-to-create-a-custom-wordpress-widget/
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('On Air Now Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Widget to display what is on air now', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
  echo $args['before_title'] . $title . $args['after_title'];

  //Custom code to display in widget

  //Display the event that is on now
  /* Supply start and end dates 
   * 
   * Set endDate to be now, and startdate to be 4 hours 
   * earlier. This means we should get the current show
   * Not many shows are longer than 4 hours!
   * 
   * NB There may be nothing on!
   * 
  */
  $endDate = new DateTime(); //Date and time as it is now
  $startDate = clone $endDate;
  $startDate->modify( '-4 hours' );
  //Get the events
  $eventFeed = outputCalendarByDateRange($startDate->format('c'),$endDate->format('c'));

  //Display the event
  theme_on_air_now($eventFeed);
  echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
  $title = $instance[ 'title' ];
}
else {
  $title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );





/**
 * Breadcrumb Lists
 * Allows visitors to quickly navigate back to a previous section or the root page.
 *
 * Adopted from Dimox
 * REWRITTEN FOR BCB by caprenter. Taken from responsive theme/includes/functions.php
 *
 */
if( !function_exists( 'responsive_breadcrumb_lists' ) ) :

	function responsive_breadcrumb_lists() {

		/* === OPTIONS === */
		$text['home']     = __( 'Home', 'responsive' ); // text for the 'Home' link
		$text['category'] = __( 'Archive for %s', 'responsive' ); // text for a category page
		$text['search']   = __( 'Search results for: %s', 'responsive' ); // text for a search results page
		$text['tag']      = __( 'Posts tagged %s', 'responsive' ); // text for a tag page
		$text['author']   = __( 'View all posts by %s', 'responsive' ); // text for an author page
		$text['404']      = __( 'Error 404', 'responsive' ); // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter   = ' <span class="chevron">&#8250;</span> '; // delimiter between crumbs
		$before      = '<span class="breadcrumb-current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post, $paged, $page;
		$homeLink   = home_url( '/' );
		$linkBefore = '<span class="breadcrumb" typeof="v:Breadcrumb">';
		$linkAfter  = '</span>';
		$linkAttr   = ' rel="v:url" property="v:title"';
		$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if( is_front_page() ) {

			if( $showOnHome == 1 ) {
				echo '<div class="breadcrumb-list"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
			}

		}
		else {

			echo '<div class="breadcrumb-list" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf( $link, $homeLink, $text['home'] ) . $delimiter;

			if( is_home() ) {
				if( $showCurrent == 1 ) {
					echo $before . get_the_title( get_option( 'page_for_posts', true ) ) . $after;
				}

			}
			elseif( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if( $thisCat->parent != 0 ) {
					$cats = get_category_parents( $thisCat->parent, true, $delimiter );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats;
				}
				echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;

			}
			elseif( is_search() ) {
				echo $before . sprintf( $text['search'], get_search_query() ) . $after;

			}
			elseif( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
				echo $before . get_the_time( 'd' ) . $after;

			}
			elseif( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo $before . get_the_time( 'F' ) . $after;

			}
			elseif( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;

			}
			elseif( is_single() && !is_attachment() ) {
				if( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					printf( $link, $homeLink . $slug['slug'] . '/', $post_type->labels->name ); //DC - Only change is here: use name instead of singular_name and remove leading slash
					if( $showCurrent == 1 ) {
						echo $delimiter . $before . get_the_title() . $after;
					}
				}
				else {
					$cat  = get_the_category();
					$cat  = $cat[0];
					$cats = get_category_parents( $cat, true, $delimiter );
					if( $showCurrent == 0 ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					}
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats;
					if( $showCurrent == 1 ) {
						echo $before . get_the_title() . $after;
					}
				}

			}
			elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $before . $post_type->labels->name . $after; //DC Chage here as well.

			}
			elseif( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );

				if( isset( $cat[0] ) ) {
					$cat = $cat[0];
				}

				if( $cat ) {
					$cats = get_category_parents( $cat, true, $delimiter );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats;
				}

				printf( $link, get_permalink( $parent ), $parent->post_title );
				if( $showCurrent == 1 ) {
					echo $delimiter . $before . get_the_title() . $after;
				}

			}
			elseif( is_page() && !$post->post_parent ) {
				if( $showCurrent == 1 ) {
					echo $before . get_the_title() . $after;
				}

			}
			elseif( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();
				while( $parent_id ) {
					$page_child    = get_page( $parent_id );
					$breadcrumbs[] = sprintf( $link, get_permalink( $page_child->ID ), get_the_title( $page_child->ID ) );
					$parent_id     = $page_child->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[$i];
					if( $i != count( $breadcrumbs ) - 1 ) {
						echo $delimiter;
					}
				}
				if( $showCurrent == 1 ) {
					echo $delimiter . $before . get_the_title() . $after;
				}

			}
			elseif( is_tag() ) {
				echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

			}
			elseif( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before . sprintf( $text['author'], $userdata->display_name ) . $after;

			}
			elseif( is_404() ) {
				echo $before . $text['404'] . $after;

			}
			if( get_query_var( 'paged' ) ) {
				if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo $delimiter . sprintf( __( 'Page %s', 'responsive' ), max( $paged, $page ) );
				if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
			}

			echo '</div>';

		}
	} // end responsive_breadcrumb_lists

endif;
//ORDER PRESENTERS BY SURNAME FIX
add_action('pre_get_posts', 'orderPresentersBySurname');
 
function orderPresentersBySurname( $query )
{
	// validate
	if( is_admin() )
	{
		return $query;
	}
 
    // project example
    if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'presenter' )
    {
    	$query->set('orderby', 'meta_value');  
    	$query->set('meta_key', 'surname');  
    	$query->set('order', 'ASC'); 
    }   
 
	// always return
	return $query;
 
}

//ORDER Programme page alphabetically 
add_action('pre_get_posts', 'orderProgrammesAlphatbetically');
 
function orderProgrammesAlphatbetically ( $query )
{
	// validate
	if( is_admin() )
	{
		return $query;
	}
 
    // project example
    if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'programme' )
    {
    	$query->set('order', 'ASC'); 
      $query->set( 'orderby', 'title' );
    }   
 
	// always return
	return $query;
 
}


/**
 * Check if viewing on mobile for redirect to mobile landing page
 */

function mobile_home_redirect(){
if( wp_is_mobile() && is_front_page() ){
   wp_redirect( '/mobile-home' ); 
    exit;
}
}
add_action( 'template_redirect', 'mobile_home_redirect' );

/***
 * This will find out when a programme was last on, and is on next
 * It may find all occurances of last on next on for a specified time period
 * e.g. About Bradford is every day
 * Other shows are weekly, fortnightly, weekdays only etc
 * 
 * Called from single-programme.php
 * @programme - string
 * @startDate - datetime
 * @endDate - datetime
 * 
 * 
***/
function theme_laston_nexton ($programme, $startDate, $endDate) {
  
  $show_descriptions[] = "BCB Xtra";
  
  
  //Get all events from the calendar for the time period 
  $events = outputCalendarByDateRange($startDate->format('c'),$endDate->format('c'));
  $past_programmes  = array();
  $future_programmes = array();
  
  //NB Programme names may contain a curly single quote &#8217; or ampersands and probably other stuff
  $search[] = "&#8230;"; //... three dot elipse
  $replace[] = "...";
  $search[] = "&#8216;"; // curly single quote
  $replace[] = "'";
  $search [] = "&#8217;"; // another curly quote
  $replace[] = "'";
  //print_r($search);
  //print_r($replace);
  
  $programme = str_replace($search, $replace, $programme); //replace curly quote with single straight quote
  //echo $programme;  //echo html_entity_decode($programme);   
  //var_dump(html_entity_decode($programme));
  //Search through the events to match with the programme title, then display matches
  try {
    
    
      foreach ($events->getItems() as $event) {
        //echo date('Y-m-d G:i',strtotime($event->start->dateTime)) . " - " . htmlentities($event->summary) . '<br />';
        //See if the title matches our programme  
        //var_dump(html_entity_decode($event->summary));
        //echo $event->summary;
        if (html_entity_decode($programme) == html_entity_decode($event->summary)) { //html_entity_decode deals with ampersands (and more?)
          
          //Check to see if the programme is on now, in the future or in the past. Store those shows to display later
          $status = programme_status($event->start->dateTime, $event->end->dateTime);  
          //$status = "on";
          switch ($status) {
              case "past":
                  array_push($past_programmes, $event);
                  break;
              case "future":
                  array_push($future_programmes, $event);
                  break;
              case "on":
                  
                  echo '<div class="single-programme programme ' . $status . '">';
                      echo '<div>';
                          
                          echo '<a class="listen-live" href="http://www.bcbradio.co.uk/player/"><span>Listen Live</span><img src="http://www.bcbradio.co.uk/wp-content/uploads/play_button.png"/></a>';
                      echo '</div>';
                  echo '</div>';
                  break;
          }
        }
      }
      
      //When was it next on? This will be the first element of the $future_programmes array (as they are ordered by date when we first get them
      if(!empty($future_programmes)) {
          $next_on = array_shift ( $future_programmes );
          //Is it on Today, or tomorrow?
          if ( date('d m y',strtotime($next_on->start->dateTime)) == date('d m y',strtotime('today')) ) {
            $start_string = "Today<br>" . date('D, jS F, Y - G:i',strtotime($next_on->start->dateTime));
          } elseif ( date('d m y',strtotime($next_on->start->dateTime)) == date('d m y',strtotime('tomorrow')) ) {
            $start_string = "Tomorrow<br> " . date('D, jS F, Y - G:i',strtotime($next_on->start->dateTime));
          } else {
            $start_string = date('D, jS F, Y - G:i',strtotime($next_on->start->dateTime));
          }
            
          echo '<div class="programme-past programme-next">';
              echo '<h3>Next on</h3>';
              echo '<div class="programme-wrap">';
                      echo '<div class="event-datetime">' .$start_string . ' - ' . date('G:i',strtotime($next_on->end->dateTime)) . '</div>';
                      if (in_array((html_entity_decode($programme)), $show_descriptions)) {
                          echo show_description($next_on->description);
                      }
              echo '</div>';
          echo '</div>';
      }
      
      //When was it last on? This will be the last element of the $past_programmes array (as they are ordered by date when we first get them
      if(!empty($past_programmes)) {
          $last_on = array_pop ( $past_programmes );
          $listen_again_link = fetch_listen_again_link ($last_on->start->dateTime, $last_on->end->dateTime);
          //echo $listen_again_link;

         
          echo '<div class="programme-past">';
              echo '<h3>Last on</h3>';
              echo '<div class="programme-wrap">';
                  echo $listen_again_link;
                  //Description
                  if (strlen($last_on->description)>0) {
                    //Add links to presenter pages if presenter info is given
                    //This is done by looking for the string; "Presented by: " which should then be followed by a comma separted list of presenters.
                    //presenter names are turned into slugs that should match pages on the site
                    $presenter_check = explode("Presented by: ",$last_on->description);
                    if (isset($presenter_check[1])) { //A string that doesn't contain the delimiter will simply return a one-length array of the original string.
                      $presenters  = explode(',',$presenter_check[1]); //This should give an arry of each presenter name
                      foreach ($presenters as $presenter) {
                         //replace the string with a link
                         $presenter = trim($presenter); //trim spaces
                         //Create the slug
                         $presenter_slug = preg_replace("/ /","-",$presenter);
                         $presenter_slug = strtolower($presenter_slug);
                         //Replace the presenter in the description text with a link
                         $page = get_page_by_path( $presenter_slug , OBJECT, 'presenter' );
                         if ( isset($page) ) {
                          $last_on->description = preg_replace('/'. $presenter . '/', '<a class="presenter_link" href="http://www.bcbradio.co.uk/presenters/' . $presenter_slug . '">' . $presenter . '</a>', $last_on->description);
                        }
                      }
                    }
                    echo '<div class="calendardescription">';
                    echo  nl2br($last_on->description);
                    //echo  $last_on->description;
                    echo '</div>';
                  }
              echo '</div>';
          echo '</div>';
      }
      
      //Show more episodes if we have them NB some shows may have 28past shows and 28 future, so only show 5
      if (!empty($future_programmes) || !empty($past_programmes)) {
          echo '<div class="programme-future">';
              if (!empty($future_programmes)) {
                  $future_programmes = array_slice($future_programmes,0,5); //reduces the number to 5
                  
                  echo '<div class="programme-ep programme-next">';
                            echo '<h4>Coming up</h4>';
                                //echo '<ul>';
                                foreach ($future_programmes as $event) {
                                    //Is it on Today, or tomorrow?
                                    if ( date('d m y',strtotime($event->start->dateTime)) == date('d m y',strtotime('today')) ) {
                                      $start_string = "Today<br>" . date('D, jS F, Y - G:i',strtotime($event->start->dateTime));
                                    } elseif ( date('d m y',strtotime($event->start->dateTime)) == date('d m y',strtotime('tomorrow')) ) {
                                      $start_string = "Tomorrow<br> " . date('D, jS F, Y - G:i',strtotime($event->start->dateTime));
                                    } else {
                                      $start_string = date('D, jS F, Y - G:i',strtotime($event->start->dateTime));
                                    }
                                    echo '<div class="programme-wrap">';
                                        echo '<div class="event-datetime">' . $start_string . ' - ' . date('G:i',strtotime($event->end->dateTime)) . '</div>';
                                        if (in_array((html_entity_decode($programme)), $show_descriptions)) {
                                            echo show_description($event->description);
                                        }
                                    echo '</div>';
                                }
                                //echo '</ul>';
                  echo '</div>';
              }
          
              if (!empty($past_programmes)) {
                  //Need to reverse the order
                  $past_programmes = array_reverse($past_programmes);                  
                  $past_programmes = array_slice($past_programmes,0,5); //reduces the number to 5
				  echo '<div class="programme-ep">';
                  echo '<h4>Past episodes</h4>';
                     // echo '<ul>';
                      foreach ($past_programmes as $event) {
                          echo '<div class="programme-wrap">';
                          //print_r($event->start->dateTime);
                          $listen_again_link = fetch_listen_again_link ($event->start->dateTime, $event->end->dateTime);
                          echo $listen_again_link;
                              //echo date('D, jS F, Y - G:i',strtotime($event->start->dateTime)) . ' - ' . date('G:i',strtotime($event->end->dateTime));
                          if (in_array((html_entity_decode($programme)), $show_descriptions)) {
                              echo show_description($event->description);
                          }
                          echo '</div>';
                      }
                     // echo '</ul>';
				  echo '</div>';
                }
           echo '</div>';          
      }
      
  } catch (Exception $e) {
          //Formats the can't fetch programme infomation message
          echo '<div class="fetch-error">';
            //Title
            echo '<h4 class="on-now-title">';
            echo "Sorry, we can't find information about when this show is on";  
            echo '</div>';
  //} finally {
   //   print "this part is always executed n";
  }
  
  
}

/*
 * Given a date and time we can query the canstream podcast RSS to get a link for that time/date
 * We return a formated link. That way we only have one place to change this if we need to!
 *
*/
 
 
function fetch_listen_again_link ($startTime, $endTime){
  // Get a SimplePie feed object from the listen again service
  //This way we can link past programmes to the listen again service.
  //Thanks to https://code.tutsplus.com/articles/building-a-recent-post-widget-powered-by-simplepie--wp-35551
  
  //The canstream RSS only returns (I think) 15 items (This gives us 9am to midnight)
  //but we can request a date https://podcasts.canstream.co.uk/bcb/podcast.php?date=yyyy-mm-dd
  //and we can page results https://podcasts.canstream.co.uk/bcb/podcast.php?page=2
  // I haven't found a max results parameter
  //echo date('Y-m-d', strtotime($startTime));
  $feedURL = "https://podcasts.canstream.co.uk/bcb/podcast.php?date=" . date('Y-m-d', strtotime($startTime));
  if ( date('H' ,strtotime($startTime)) <= 8 ) {
    $feedURL = $feedURL . '&page=2'; // Anything after midnight and the breakfast show at 8am are on page 2 of the rss feed.
  }
  $rss = fetch_feed( $feedURL );
 
  if ( ! is_wp_error( $rss ) ) { // Checks that the object is created correctly
 
        // Figure out how many total items there are, but limit it to 5.
        //$maxitems = $rss->get_item_quantity( $feedNumber );
        $maxitems = 24;
 
        // Build an array of all the items, starting with element 0 (first element).
        $rss_items = $rss->get_items( 0, $maxitems );
 
  }

  // Loop through each feed item and display each item as a hyperlink.
  //echo '<ul>';
  foreach ( $rss_items as $item ) {
      //Check to see if we can match the pubdate eg: <pubDate>Sat, 25 Apr 2020 15:00:01 +0100</pubDate>
      //We only need to match on the hour (the supplied date time will be the start of a show, the RSS feed is 1 min into the hour)
      //!!Above assumes we get the right date back from the RSS feed!!
      //Should catch shows that start at half past.. 
      $rss_hour = date('H' ,strtotime($item -> get_Date()));
      //echo $rss_hour;
      $show_hour = date('H' ,strtotime($startTime));
      //echo $show_hour;
      
      if ( $show_hour == $rss_hour ) {
        
          //Was it last on Today, or yesterday?
          if ( date('d m y',strtotime($startTime)) == date('d m y',strtotime('today')) ) {
            $start_string = "Today<br>" . date('D, jS F - G:i',strtotime($startTime));
          } elseif ( date('d m y',strtotime($startTime)) == date('d m y',strtotime('yesterday')) ) {
            $start_string = "Yesterday<br>" . date('D, jS F - G:i',strtotime($startTime));
          } else {
            $start_string = date('D, jS F, Y - G:i',strtotime($startTime));
          }
          
          $display = '<div class="event-datetime">' . $start_string . ' - ' . date('G:i',strtotime($endTime))  . '</div>' . '<a href="' . esc_url($item -> get_permalink()) . '">' . ' <span class="listen-again-link">Listen Again</span></a>';
          return $display; //we can exit the loop here if we have a link      
          
          //echo '<li><a href="' . esc_url($item -> get_permalink()) . '" title="' . esc_html($item->get_title()) .'">';
            //echo esc_html($item->get_title()); 
          //echo '</a></li>';
      } 
  }

  //echo '</ul>';
  
  //if we get to here we've not found a link so return a simple string
  $display = '<div class="event-datetime">' . date('D, jS F, Y - G:i',strtotime($startTime)) . ' - ' . date('G:i',strtotime($endTime)) . '</div>';
  return $display;
}

/*
 * Takes a google calendar description and formats it make it a short one liner
 */ 
function show_description ($description) {
  
  //$description = trim($description);
  $description = nl2br($description);
  //echo $description;
  
  if (strlen ($description) > 140) {
      $description =  substr($description, 0, 140);
      $description = $description . '...';
  }
  
  $html = '<div class="calendardescription">' . $description . '</div>';
  
  return $html;
}
  
