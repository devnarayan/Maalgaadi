<?php



// Exit if accessed directly

if ( !defined( 'ABSPATH' ) ) {

	exit;

}



/**

 * Single Posts Template

 *

 *

 * @file           single.php

 * @package        Responsive

 * @author         Emil Uzelac

 * @copyright      2003 - 2014 CyberChimps

 * @license        license.txt

 * @version        Release: 1.0

 * @filesource     wp-content/themes/responsive/single.php

 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29

 * @since          available since Release 1.0

 */



get_header(); ?>


<div class="container">
<div id="content" class="<?php echo esc_attr( implode( ' ', responsive_get_content_classes() ) ); ?>">



	<?php get_template_part( 'loop-header', get_post_type() ); ?>

		

	<?php if ( have_posts() ) : ?>



		<?php while( have_posts() ) : the_post(); ?>



			<?php responsive_entry_before(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php responsive_entry_top(); ?>


                                 <?php  
                                // echo get_site_url(); 
 $mystring ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 $findme   = 'http://maalgaadi.net/testsite/IndoreProperty/sale/';
 $findme1   = 'http://maalgaadi.net/testsite/IndoreProperty/rent/';
$pos = strpos($mystring, $findme);
$pos1 = strpos($mystring, $findme1);

if ($pos !== false) {
   echo "success1";
}
elseif ($pos1 !== false) {
   echo "success2";
}
else {
   echo "fail";
}
?>

				<div class="post-entry">

					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>



					<?php if ( get_the_author_meta( 'description' ) != '' ) : ?>



						<div id="author-meta">

							<?php if ( function_exists( 'get_avatar' ) ) {

								echo get_avatar( get_the_author_meta( 'email' ), '80' );

							} ?>

							<div class="about-author"><?php _e( 'About', 'responsive' ); ?> <?php the_author_posts_link(); ?></div>

							<p><?php the_author_meta( 'description' ) ?></p>

						</div><!-- end of #author-meta -->



					<?php endif; // no description, no author's meta ?>



					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>

				</div><!-- end of .post-entry -->



				<div class="navigation">

					<div class="previous"><?php previous_post_link( '&#8249; %link' ); ?></div>

					<div class="next"><?php next_post_link( '%link &#8250;' ); ?></div>

				</div><!-- end of .navigation -->



				<?php get_template_part( 'post-data', get_post_type() ); ?>



				<?php responsive_entry_bottom(); ?>

			</div><!-- end of #post-<?php the_ID(); ?> -->

			<?php responsive_entry_after(); ?>



			<?php responsive_comments_before(); ?>

			<?php comments_template( '', true ); ?>

			<?php responsive_comments_after(); ?>



		<?php

		endwhile;



		get_template_part( 'loop-nav', get_post_type() );



	else :



		get_template_part( 'loop-no-posts', get_post_type() );



	endif;

	?>

</div>
<?php get_sidebar(); ?>
</div><!-- end of #content -->





<?php get_footer(); ?>

