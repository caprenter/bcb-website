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
          <div class="widget-wrapper" style="float:left; width:33%; margin-top:-110px">
            <h3 style="margin-top:0">Programmes</h3>
            <p><?php echo get_post_meta($post->ID, "programmes", true); ?></p>
              <?php 
                $email = get_post_meta($post->ID, "email", true);
                $twitter = get_post_meta($post->ID, "twitter-name", true);
                $facebook = get_post_meta($post->ID, "facebook-name", true);
                if ($email || $twitter || $facebook ) {
                  echo '<h3 class="presenter-contact">Contact</h3>';
                  if ($email) {
                    echo "Email: " . htmlentities($email) . "<br/>"; 
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
