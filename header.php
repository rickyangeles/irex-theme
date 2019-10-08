<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.2/css/all.css" integrity="sha384-XxNLWSzCxOe/CFcHcAiJAZ7LarLmw3f4975gOO6QkxvULbGGNDoSOTzItGUG++Q+" crossorigin="anonymous">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<?php wp_head(); ?>

</head>
<?php
function theme_get_customizer_css() {
  ob_start();

  $primary_color = get_theme_mod( 'primary_color', '' );
  $secondary_color = get_theme_mod( 'secondary_color', '' );
  $dark_color = get_theme_mod( 'secondary_color', '' );
  if ( ! empty( $primary_color ) ) {
	?>
		h1,h2,h3,h4,h5,h6 {
		  color: <?php echo $primary_color; ?>!important;
		}
		.btn-primary, .footer-menu {
			background-color:  <?php echo $primary_color; ?>;
		}

	<?php
  }

  if ( ! empty( $secondary_color ) ) {
	?>
		@media (min-width: 768px) {
			#navbarNavDropdown>ul>li:last-child a {
				background-color: <?php echo $secondary_color; ?>;
				color: white!important;
			}
		}

		.footer .footer-contact-info strong {
			color: <?php echo $secondary_color; ?>
		}
		.btn-secondary, .footer-menu li:last-child a {
			background-color:  <?php echo $secondary_color; ?>;
			color: white!important;
		}
	<?php
  }

  if ( ! empty( $dark_color ) ) {
	?>
		@media (min-width: 768px) {
			#navbarNavDropdown>ul>li:last-child a {
				background-color: <?php echo $secondary_color; ?>;
				color: white!important;
			}
		}

		.footer .footer-contact-info strong {
			color: <?php echo $secondary_color; ?>
		}
		.btn-secondary, .footer-menu li:last-child a {
			background-color:  <?php echo $secondary_color; ?>;
			color: white!important;
		}
	<?php
  }

  $css = ob_get_clean();
  return $css;
} ?>
<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div class="header" id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

		<nav class="navbar navbar-expand-md navbar-primary bg-white">

		<?php if ( 'container' == $container ) : ?>
			<div class="container">
		<?php endif; ?>

					<!-- Your site title as branding in the menu -->
					<?php $logo = get_field('header_logo','options'); if ( $logo ) : ?>
						<a href="/" class="header-logo"><img src="<?php echo $logo['url']; ?>" /></a>
					<?php endif; ?>

					<!-- Top Menu -->

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
					<span class="navbar-toggler-icon"><i class="fal fa-bars"></i></span>
				</button>


				<?php
					if (has_nav_menu('top-menu')) {
						wp_nav_menu( array(
							'menu' => 'Top Menu',
							'container_class' => 'top-menu-wrap',
						));
					}
				?>
				<!-- The WordPress Menu goes here -->
				<?php
					if ( has_nav_menu('primary') ) {
						wp_nav_menu(
							array(
								'theme_location'  => 'primary',
								'container_class' => 'collapse navbar-collapse',
								'container_id'    => 'navbarNavDropdown',
								'menu_class'      => 'navbar-nav ml-auto',
								'fallback_cb'     => '',
								'menu_id'         => 'main-menu',
								'depth'           => 4,
								'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
							)
						);
					}
				?>

			<?php if ( 'container' == $container ) : ?>
			</div><!-- .container -->
			<?php endif; ?>

		</nav><!-- .site-navigation -->

	</div><!-- #wrapper-navbar end -->
