<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
				$query = new WP_Query(array(
				    'post_type' => 'dt_ext_connection',
				    'post_status' => 'publish',
					'posts_per_page' => -1,
				));
			?>


			<?php while ($query->have_posts()) : ?>
			    <?php $query->the_post(); ?>
				<?php
					$meta = get_post_meta(get_the_ID(), 'dt_external_connection_url', true);
					$meta .= "/wp/v2/service/";
				?>
				<?php echo $meta; ?>
				<?php $response = wp_remote_get($meta); ?>
			<?php endwhile; ?>

			<?php wp_reset_query(); ?>


			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'page' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
<script>
	jQuery(document).ready(function($) {
		$.getJSON('http://aep.local/wp-json/wp/v2/service/', function(json) {
			var obj = json;
			for(i = 0; i < obj.length; i++) {
	           	var title = obj[i]['title']['rendered'];

	        }
		});
	});
</script>
