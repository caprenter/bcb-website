<?php
/*
Template Name: Presenters Page
*/
/*Created by caprenter for BCB*/
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Presenters Template
 *
 *
 * @file           single-presenter.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<a href="http://www.bcbradio.co.uk/presenters/" class="back_presenters">Back to Presenters</a>

<div id="content" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'loop-header' ); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>
        <?php if( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'large', array( 'class' => 'presenter-image' ) ); ?>
        <?php endif; ?>

				<div class="post-entry">
          <?php //echo print_r(get_post_custom()); ?>
          <div class="presenter-content">
					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
          </div>
          <!--Custom Field Data-->
          <div class="widget-wrapper presenter">
            <h3 style="margin-top:0">Programmes</h3>
            <p><?php 
                  //echo get_post_meta($post->ID, "programmes", true); 
                  //create a link to the programme page
                  $programmes = get_post_meta($post->ID, "programmes", true); //may be a single programme or a comma seperated list
                  if ($programmes) {
                    echo '<ul>'; 
                    $programmes = explode( ',', $programmes );
                    foreach ($programmes as $programme) {
                        echo '<li>'; 
                        $prog_link = trim($programme); //trim spaces
                        //Create the slug
                        $programme_slug = sanitize_title($prog_link); //Use the inbuilt wordpress function to clean the sting to make a slug 
                        $page = get_page_by_path( $programme_slug , OBJECT, 'programme' );
                        if ( isset($page) ) {
                            echo '<a class="programme_link" href="http://www.bcbradio.co.uk/programmes/' . $programme_slug . '">' . $prog_link . '</a>';
                        } else {
                            echo htmlentities($programme);
                        }
                        echo '</li>';
                      }
                      echo '</ul>';
                    }
                ?>
            </p>
              <?php 
                $email = get_post_meta($post->ID, "email", true);
                $twitter = get_post_meta($post->ID, "twitter-name", true);
                $facebook = get_post_meta($post->ID, "facebook-name", true);
		$webpage = get_post_meta($post->ID, "webpage", true);
                if ($email || $twitter || $facebook ) {
                  echo '<h3 class="presenter-contact">Contact</h3>';
                  
		  if ($email) {
                    echo 'Email: <a href="mailto:' . htmlentities($email) . '">' . htmlentities($email) . '</a><br/>';  
                  } 
		  if ($webpage) {
                    echo 'Web: <a href="' . htmlentities($webpage) . '">' . htmlentities($webpage) . '</a><br/>';  
                  } 
                  if ($twitter) {
                    echo 'Twitter: <a href="https://twitter.com/' . htmlentities($twitter) . '">' . htmlentities($twitter) . '</a><br/>';  
                  }                  
                  if ($facebook) {
                    echo 'Facebook: <a href="https://www.facebook.com/' . htmlentities($facebook) . '">"' . htmlentities($facebook) . '</a><br/>'; 
                  }
                }
              ?>

          </div>
          <?php //echo get_post_meta($post->ID, "surname", true); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->

				<?php //get_template_part( 'post-data' ); ?>

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
