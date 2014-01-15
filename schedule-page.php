<?php
/*
Template Name: Schedule Page
*/
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Schedule Page Template
 *
 *
 * @file           schedule-page.php
 * @package        Responsive Child theme for BCB
 * @author         Emil Uzelac - edited by David Carpenter
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive-childtheme-master/schedule-page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); 
//global $wp_query;
//var_dump($wp_query->query_vars);
//echo $wp_query->query_vars['dday'];
?>

<div id="content" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'loop-header' ); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry">

          <?php
          /* Shedule info pulled from a google calendar */

          /* Supply start and end dates for the schedule to show
           * 
           * Our day is from 3am in the morning until 2am the following day
           * BCB's day is really 8am through to 2am the next day
           * 
          */
          
          //Create the navigation for the schedule
          //days are calculated at midnight
          $days_past = -4; //go back one more day than you want. This is past 3 days
          $days_future = 6; //go forward one less day than you want. This is future 7 days
          
          //Check to see if we have a date set in the URL e.g. schedule/2013/12/06
          if (isset($wp_query->query_vars['dday']) &&
              isset($wp_query->query_vars['dmonthnum']) &&
              isset($wp_query->query_vars['dyear']) ) {
                //Sanitize the data
                $month = filter_var($wp_query->query_vars['dmonthnum'], FILTER_SANITIZE_NUMBER_INT);
                $day = filter_var($wp_query->query_vars['dday'], FILTER_SANITIZE_NUMBER_INT);
                $year= filter_var($wp_query->query_vars['dyear'], FILTER_SANITIZE_NUMBER_INT);
                //Check that it is a real date
                if (checkdate($month,$day,$year)) { //returns false on fail
                  $today = strtotime(date('Y-m-d'));
                  $supplied_date = strtotime("$year-$month-$day");
                  //Check the supplied date is in our range of days
                  if ($supplied_date >= $today + 60*60*24*$days_past &&
                      $supplied_date <= $today + 60*60*24*$days_future ) {
                    
                      $use_this_date = true;
                      $days_difference = number_format(($supplied_date - $today)/(60*60*24)); //returns integer value need to add 1 to get the correct date
                      //echo $days_difference;die;
                  }
                }
          }
          
          //Display the schedule by day navigation
          ?>
          <div class="schedule-nav">
          <ol>
            <?php 
            if (!isset($today)) { //won't be set if a date is not supplied
              $today = strtotime(date('Y-m-d'));
            }
            //Loop through the range of days and print a link to each day
            for ($i=$days_past;$i<=$days_future;$i++) {
              //Need to highlight the date we are on...
              if (isset($days_difference)) {
                if ($i == $days_difference) {
                  echo '<li class="featured-day">';
                } else {
                  echo '<li>';
                }
              } elseif ($i==0) { //today!
                echo '<li class="featured-day">';
              } else {
                echo '<li>';
              }
              //Create a link like: schedule/2013/12/21
              echo '<a href="' . get_site_url() . '/schedule/' . date("Y",$today + $i*60*60*24) . '/' . date("m",$today + $i*60*60*24) . '/' . date("d",$today + $i*60*60*24) . '/">';
              if ($i==0) { //TODAY!
                echo '<span class="day">TODAY</span><br/><span class="date">' .  date("j M",$today + $i*60*60*24) . '</span>';
              } else {
                echo '<span class="day">' . date("D",$today + $i*60*60*24) . '</span>';
                echo '<br />';
                echo '<span class="date">' . date("j M",$today + $i*60*60*24) . '</span>';
              }
              echo '</a>';
              echo '</li>';

            }
            ?>
            </ol>
          </div>
          <div style="clear:left"></div>
          
          <?php
          //Get the schedule info for the given date...
          if (isset($use_this_date)) {
            $startDate = new DateTime("$year-$month-$day");
          } else {
             $startDate = new DateTime(); //Date and time as it is now
           }
          //$startDate = new DateTime('2013-11-20'); //Date and time defined
          $endDate = new DateTime($startDate->format('Y-m-d'));
          $startDate = clone $endDate;
          //var_dump($endDate); die;
          $startDate->modify( '+2 hours' );
          $endDate->modify( '+26 hours' );
          //$endDate = new DateTime($startDate->format('Y-m-d') + (26*60*60)); //Set end date to be the start of the day
          //$endDate->add(new DateInterval('P1DT2H')); //Then add an interval of 1 day and 2 hours to take us to 2am the next day
          //$endDate = $startDate;

          //outputCalendarByDateRange($startDate->format('Y-m-d'),$endDate->format('Y-m-d'));
          //Get the output stating at the start of the start of the day in startDate (Y-m-d) and then at iso format date 'c' of end interval later. 
          //outputCalendarByDateRange($startDate->format('Y-m-d'),$endDate->format('c'));
          //The folowing functions can be found in functions.php
          $eventFeed = outputCalendarByDateRange($startDate->format('c'),$endDate->format('c'));
          theme_schedule_list($eventFeed);
          ?>

					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->

				<?php get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

			<?php responsive_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php responsive_comments_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
