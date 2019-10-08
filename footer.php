<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

$footerCopy = get_field('about_text', 'options');
$footerLogo = get_field('footer_logo', 'options');
$corpAddress = get_field('corporate_address', 'options');
$corpPhone = get_field('c_phone_number', 'options');
$corpFax	= get_field('c_fax_number', 'options');
$customerPhone = get_field('customer_phone', 'options');
$supplyPhone = get_field('suppliers_phone', 'options');
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper footer-menu">
	<div class="row">
		<div class="col-md-12">
			<?php
				if ( has_nav_menu('footer-menu') ) {
					wp_nav_menu( array(
						'menu' => 'Footer Menu',
						'container_class' => 'footer-menu-wrap',
					));
				}
			?>
		</div>
	</div>
</div>
<div class="wrapper footer" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="row">
			<div class="col-md-3">
				<img src="<?php echo $footerLogo['url']; ?>" alt="" class="footer-logo">
				<ul class="footer-social-media">
				<?php if( have_rows('social_icons','options') ): ?>
					<?php while( have_rows('social_icons','options') ): the_row();
						$socialIcon = get_sub_field('font_awesome_class');
						$socialURL = get_sub_field('social_media_url');
					?>
						<li><a href="<?php the_sub_field('font_awesome_class');?>"><i class="<?php echo $socialIcon; ?>"></i></a></li>
					<?php endwhile; ?>
				<?php endif; ?>

				</ul>
			</div>
			<div class="col-md-9">
					<?php echo $footerCopy; ?>
				<div class="row footer-contact-info">
					<div class="col-md-4">
						<strong>Corporate Office</strong>
						<ul class="corp-contact">
							<li><?php echo $corpAddress; ?></li>
							<li>P: <?php echo $corpPhone; ?></li>
							<li>F: <?php echo $corpFax; ?></li>
						</ul>
					</div>
					<div class="col-md-4">
						<strong>Customers:</strong>
						<ul class="customer-contact">
							<li>Toll Free 24/7 Service & Support</li>
							<li>P: <?php echo $customerPhone; ?></li>
						</ul>
					</div>
					<div class="col-md-4">
						<strong>Suppliers:</strong>
						<ul class="supply-contact">
							<li>P: <?php echo $supplyPhone; ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

	</div><!-- container end -->

</div><!-- wrapper end -->
<div class="subfooter container ">
	<div class="row">

		<div class="col-md-12">

			<footer class="site-footer" id="colophon">

				<div class="site-info">

					&copy; <?php echo date("Y"); echo " "; echo bloginfo('name'); ?>. All rights reserved.

				</div><!-- .site-info -->

			</footer><!-- #colophon -->

		</div><!--col end -->

	</div><!-- row end -->
</div>
</div><!-- #page we need this extra closing tag here -->
<?php wp_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</body>

</html>
