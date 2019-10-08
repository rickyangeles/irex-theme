<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once( 'library/blocks.php' );

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.css');
	wp_enqueue_style( 'swiper', get_stylesheet_directory_uri() . '/css/swiper.css');

    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
	wp_enqueue_script( 'swiper', get_stylesheet_directory_uri() . '/js/swiper.min.js');
	wp_enqueue_script( 'folding', get_stylesheet_directory_uri() . '/js/folding-content.min.js');

	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js');
	wp_enqueue_script( 'squeezebox', get_stylesheet_directory_uri() . '/js/squeezebox.min.js');
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/rickyangeles/irex-theme-child',
	__FILE__,
	'irex-theme-child'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

// //Optional: If you're using a private repository, specify the access token like this:
// $myUpdateChecker->setAuthentication('your-token-here');
//
//Optional: Set the branch that contains the stable release.
//$myUpdateChecker->setBranch('master');


/* Google Maps API */

// Add in your functions.php
add_action( 'wp_enqueue_scripts', 'themeprefix_google_map_script' ); // Firing the JS and API
// Enqueue Google Map scripts
function themeprefix_google_map_script() {
	wp_enqueue_script( 'google-map', get_stylesheet_directory_uri() . '/js/maps.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDhavbTbMkRVDucZhx7ohIgdxgLv5D0RxI', null, null, true); // Add in your key
}


//Adding project thumbnail size
add_theme_support('post-thumbnails');
add_image_size( 'featured-project', 400, 400, array( 'center', 'center' ) ); // Hard crop left top
add_image_size( 'page-banner', 1500, 320);
add_image_size( 'service-archive-banner', 1127, 203);
add_image_size( 'service-slideshow', 757, 482, array( 'center', 'center' ) );


//Get Subsidiary Services
function get_services_rest($services) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$services);
		$result=curl_exec($ch);
		$result=curl_exec($ch);
		$posts = json_decode($result, true);
		echo '<ul>';
		foreach ($posts as $post) {
			echo '<li><a href="<?php ' . $post['link'] . '">' . $post['title']['rendered'] . '</a></li>';
		}
		echo '</ul>';
}

//Get Subsidiary Locations
function get_locations_rest($locations, $title) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$locations);
		$result=curl_exec($ch);
		$result=curl_exec($ch);
		$posts = json_decode($result, true);
		echo '<ul>';
		foreach ($posts as $post) {
			$location = $post['title']['rendered'];
			$locationName = str_replace($title, '', $location);
			$locationName = preg_replace("/[^A-Za-z0-9]/","",$locationName);
			echo '<li><a href="<?php ' . $post['link'] . '">' . $locationName . '</a></li>';
		}
		echo '</ul>';
}
//Get Sub Logo
function get_logo_rest($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
	$result=curl_exec($ch);
	$logoImg = json_decode($result, true);
	foreach ($logoImg as $v) {
		$img = $v['url'];
		echo $img;
	}
}

//get number of connections
function total_connections($id) {
	$connection_map = get_post_meta( $id, 'dt_connection_map', true );
	$total_connections = 0;
	if ( ! empty( $connection_map['external'] ) ) {
		$total_connections = $total_connections + count( $connection_map['external'] );
	}

	return $total_connections;
}

function get_service_subsidiary($id) {

	$meta = get_post_meta($id, 'dt_connection_map', true);
	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_URL,$id);
	// $result=curl_exec($ch);
	// $result=curl_exec($ch);
	// $subs = json_decode($result, true);
	$post = $meta['external'];
	$idList = array();
	foreach ($post as $key => $value) {
		$idList[] = $value['post_id'];
	}
	return $idList;
}


//Custom limit on content and excerpt function
function excerpt($limit, $id) {
  $excerpt = explode(' ', get_the_excerpt($id), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]>', $content);
  return $content;
}



//Adding google fonts
function add_google_fonts() {
wp_enqueue_style( 'add_google_fonts', 'https://fonts.googleapis.com/css?family=Fira+Sans:300,400,500,700|Montserrat:400,500,700&display=swap', false );}
add_action( 'wp_enqueue_scripts', 'add_google_fonts' );


//Registering new menu locations
add_action( 'after_setup_theme', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu( 'top-menu', __( 'Top Menu', 'understrap' ) );
  register_nav_menu( 'footer-menu', __( 'Footer Menu', 'understrap' ) );
}



//Adding Option Pages
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url'		=> 'dashicons-feedback'
	));

	acf_add_options_page(array(
		'page_title' 	=> 'Global Content',
		'menu_title'	=> 'Global Content',
		'menu_slug'	=> 'global-content',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url'		=> 'dashicons-edit'
	));
}


add_action( 'init', 'cptui_register_my_cpts' );
//Adding CPTs
function cptui_register_my_cpts() {

	/**
	 * Post Type: Testimonials.
	 */

	$labels = array(
		"name" => __( "Testimonials", "understrap" ),
		"singular_name" => __( "Testimonial", "understrap" ),
		"menu_name" => __( "Testimonials", "understrap" ),
		"all_items" => __( "All Testimonials", "understrap" ),
		"add_new" => __( "Add Testimonial", "understrap" ),
		"add_new_item" => __( "Add New Testimonial", "understrap" ),
		"edit_item" => __( "Edit Testimonial", "understrap" ),
		"new_item" => __( "New Testimonial", "understrap" ),
		"view_item" => __( "View Testimonial", "understrap" ),
		"view_items" => __( "View Testimonials", "understrap" ),
		"search_items" => __( "Search Testimonial", "understrap" ),
		"not_found" => __( "No Testimonials Found", "understrap" ),
		"not_found_in_trash" => __( "No Testimonials found in Trash", "understrap" ),
		"parent_item_colon" => __( "Parent Testimonial", "understrap" ),
		"featured_image" => __( "Featured image for this Testimonial", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Testimonial", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Testimonial", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Testimonial", "understrap" ),
		"archives" => __( "Industry Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Testimonial", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Testimonial", "understrap" ),
		"filter_items_list" => __( "Filter Testimonials List", "understrap" ),
		"items_list_navigation" => __( "Testimonials list navigation", "understrap" ),
		"items_list" => __( "Testimonials List", "understrap" ),
		"attributes" => __( "Testimonial Attributes", "understrap" ),
		"name_admin_bar" => __( "Testimonial", "understrap" ),
		"parent_item_colon" => __( "Parent Testimonial", "understrap" ),
	);

	$args = array(
		"label" => __( "Testimonials", "understrap" ),
		"labels" => $labels,
		"description" => "Post type used to display testimonials.",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "testimonial",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "testimonial", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-comment",
		"supports" => array( "title", "editor", "thumbnail", "revisions", "page-attributes" ),
	);

	register_post_type( "testimonial", $args );

	/**
	 * Post Type: Industriess.
	 */

	$labels = array(
		"name" => __( "Industries", "understrap" ),
		"singular_name" => __( "Industry", "understrap" ),
		"menu_name" => __( "Industries", "understrap" ),
		"all_items" => __( "All Industries", "understrap" ),
		"add_new" => __( "Add Industry", "understrap" ),
		"add_new_item" => __( "Add New Industry", "understrap" ),
		"edit_item" => __( "Edit Industry", "understrap" ),
		"new_item" => __( "New Industry", "understrap" ),
		"view_item" => __( "View Industry", "understrap" ),
		"view_items" => __( "View Industries", "understrap" ),
		"search_items" => __( "Search Industry", "understrap" ),
		"not_found" => __( "No Industries Found", "understrap" ),
		"not_found_in_trash" => __( "No Industries found in Trash", "understrap" ),
		"parent_item_colon" => __( "Parent Industry", "understrap" ),
		"featured_image" => __( "Featured image for this Industry", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Industry", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Industry", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Industry", "understrap" ),
		"archives" => __( "Industry Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Industry", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Industry", "understrap" ),
		"filter_items_list" => __( "Filter Industries List", "understrap" ),
		"items_list_navigation" => __( "Industries list navigation", "understrap" ),
		"items_list" => __( "Industries List", "understrap" ),
		"attributes" => __( "Industries Attributes", "understrap" ),
		"name_admin_bar" => __( "Industry", "understrap" ),
		"parent_item_colon" => __( "Parent Industry", "understrap" ),
	);

	$args = array(
		"label" => __( "Industries", "understrap" ),
		"labels" => $labels,
		"description" => "Post type used to display industries.",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "industry",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "industries", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-building",
		"supports" => array( "title", "editor", "thumbnail", "revisions", "page-attributes" ),
	);

	register_post_type( "industry", $args );

	/**
	 * Post Type: Sevices.
	 */

	$labels = array(
		"name" => __( "Services", "understrap" ),
		"singular_name" => __( "Service", "understrap" ),
		"menu_name" => __( "Services", "understrap" ),
		"all_items" => __( "All Services", "understrap" ),
		"add_new" => __( "Add Service", "understrap" ),
		"add_new_item" => __( "Add New Service", "understrap" ),
		"edit_item" => __( "Edit Service", "understrap" ),
		"new_item" => __( "New Service", "understrap" ),
		"view_item" => __( "View Service", "understrap" ),
		"view_items" => __( "View Services", "understrap" ),
		"search_items" => __( "Search Service", "understrap" ),
		"not_found" => __( "No Services Found", "understrap" ),
		"not_found_in_trash" => __( "No Services found in Trash", "understrap" ),
		"parent_item_colon" => __( "Parent Service", "understrap" ),
		"featured_image" => __( "Featured image for this service", "understrap" ),
		"set_featured_image" => __( "Set featured image for this service", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this service", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this service", "understrap" ),
		"archives" => __( "Service Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Service", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this service", "understrap" ),
		"filter_items_list" => __( "Filter Services List", "understrap" ),
		"items_list_navigation" => __( "Services list navigation", "understrap" ),
		"items_list" => __( "Services List", "understrap" ),
		"attributes" => __( "Services Attributes", "understrap" ),
		"name_admin_bar" => __( "Service", "understrap" ),
		"parent_item_colon" => __( "Parent Service", "understrap" ),
	);

	$args = array(
		"label" => __( "Services", "understrap" ),
		"labels" => $labels,
		"description" => "Post type used to display services.",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "service",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "services", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-admin-generic",
		"supports" => array( "title", "editor", "thumbnail", "revisions", "page-attributes" ),
	);

	register_post_type( "service", $args );

	/**
	 * Post Type: Locations.
	 */

	$labels = array(
		"name" => __( "Locations", "understrap" ),
		"singular_name" => __( "Location", "understrap" ),
		"menu_name" => __( "Locations", "understrap" ),
		"all_items" => __( "All Locations", "understrap" ),
		"add_new" => __( "Add Location", "understrap" ),
		"add_new_item" => __( "Add New Location", "understrap" ),
		"edit_item" => __( "Edit Location", "understrap" ),
		"new_item" => __( "New Location", "understrap" ),
		"view_item" => __( "View Location", "understrap" ),
		"view_items" => __( "View Locations", "understrap" ),
		"search_items" => __( "Search Location", "understrap" ),
		"not_found" => __( "No Location Found", "understrap" ),
		"not_found_in_trash" => __( "No Locations found in trash", "understrap" ),
		"parent_item_colon" => __( "Parent Location", "understrap" ),
		"featured_image" => __( "Featured image for this location", "understrap" ),
		"set_featured_image" => __( "Set featured image for this location", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this location", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this location", "understrap" ),
		"archives" => __( "Location Archives", "understrap" ),
		"insert_into_item" => __( "Insert into location", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this location", "understrap" ),
		"filter_items_list" => __( "Filter location list", "understrap" ),
		"items_list_navigation" => __( "Locations list navigation", "understrap" ),
		"items_list" => __( "Locations list", "understrap" ),
		"attributes" => __( "Locations Atrributes", "understrap" ),
		"name_admin_bar" => __( "Location", "understrap" ),
		"parent_item_colon" => __( "Parent Location", "understrap" ),
	);

	$args = array(
		"label" => __( "Locations", "understrap" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "location",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "locations", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 7,
		"menu_icon" => "dashicons-location-alt",
		"supports" => array( "title", "editor", "thumbnail", "revisions" ),
	);

	register_post_type( "location", $args );

	/**
	 * Post Type: Resources.
	 */

	$labels = array(
		"name" => __( "Literature Downloads", "understrap" ),
		"singular_name" => __( "Literature Download", "understrap" ),
		"menu_name" => __( "Literature Download", "understrap" ),
		"all_items" => __( "All Literature Downloads", "understrap" ),
		"add_new" => __( "Add Literature Download", "understrap" ),
		"add_new_item" => __( "Add New Literature Download", "understrap" ),
		"edit_item" => __( "Edit Literature Download", "understrap" ),
		"new_item" => __( "New Literature Download", "understrap" ),
		"view_item" => __( "View Literature Download", "understrap" ),
		"view_items" => __( "View Literature Downloads", "understrap" ),
		"search_items" => __( "Search Literature Download", "understrap" ),
		"not_found" => __( "No resources found", "understrap" ),
		"not_found_in_trash" => __( "No Literature Downloads in trash", "understrap" ),
		"parent_item_colon" => __( "Parent Literature Download", "understrap" ),
		"featured_image" => __( "Featured image for this Literature Download", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Literature Download", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Literature Download", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Literature Download", "understrap" ),
		"archives" => __( "Literature Download Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Literature Download", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Literature Download", "understrap" ),
		"filter_items_list" => __( "Filter Literature Download list", "understrap" ),
		"items_list_navigation" => __( "Literature Download list navigation", "understrap" ),
		"items_list" => __( "Literature Downloads List", "understrap" ),
		"attributes" => __( "Literature Downloads Attributes", "understrap" ),
		"name_admin_bar" => __( "Literature Download", "understrap" ),
		"parent_item_colon" => __( "Parent Literature Download", "understrap" ),
	);

	$args = array(
		"label" => __( "Resources", "understrap" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "resource",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "resource", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 7,
		"menu_icon" => "dashicons-book",
		"supports" => array( "title", "editor", "thumbnail", "revisions" ),
	);

	register_post_type( "literature-downloads", $args );

	/**
	 * Post Type: Project Gallery.
	 */

	$labels = array(
		"name" => __( "Project Gallery", "understrap" ),
		"singular_name" => __( "Project Gallery", "understrap" ),
		"menu_name" => __( "Project Gallery", "understrap" ),
		"all_items" => __( "All Project Galleries", "understrap" ),
		"add_new" => __( "Add Project Gallery", "understrap" ),
		"add_new_item" => __( "Add New Project Gallery", "understrap" ),
		"edit_item" => __( "Edit Project Gallery", "understrap" ),
		"new_item" => __( "New Project Gallery", "understrap" ),
		"view_item" => __( "View Project Gallery", "understrap" ),
		"view_items" => __( "View Project Galleries", "understrap" ),
		"search_items" => __( "Search Project Gallery", "understrap" ),
		"not_found" => __( "No galleries found", "understrap" ),
		"not_found_in_trash" => __( "No Project Galleries in trash", "understrap" ),
		"parent_item_colon" => __( "Parent Project Gallery", "understrap" ),
		"featured_image" => __( "Featured image for this Project Gallery", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Project Gallery", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Project Gallery", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Project Gallery", "understrap" ),
		"archives" => __( "Project Gallery Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Project Gallery", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Project Gallery", "understrap" ),
		"filter_items_list" => __( "Filter Project Gallery list", "understrap" ),
		"items_list_navigation" => __( "Project Gallery list navigation", "understrap" ),
		"items_list" => __( "Project Galleries List", "understrap" ),
		"attributes" => __( "Project Galleries Attributes", "understrap" ),
		"name_admin_bar" => __( "Project Gallery", "understrap" ),
		"parent_item_colon" => __( "Parent Project Gallery", "understrap" ),
	);

	$args = array(
		"label" => __( "Project Gallery", "understrap" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "project-gallery",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "project-gallery", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 7,
		"menu_icon" => "dashicons-images-alt2",
		"supports" => array( "title", "editor", "thumbnail", "revisions" ),
	);

	register_post_type( "project_gallery", $args );

		/**
		 * Post Type: Gallery.
		 */

		$labels = array(
			"name" => __( "Gallery", "understrap" ),
			"singular_name" => __( "Gallery", "understrap" ),
			"menu_name" => __( "Gallery", "understrap" ),
			"all_items" => __( "All Galleries", "understrap" ),
			"add_new" => __( "Add Gallery", "understrap" ),
			"add_new_item" => __( "Add New Gallery", "understrap" ),
			"edit_item" => __( "Edit Gallery", "understrap" ),
			"new_item" => __( "New Gallery", "understrap" ),
			"view_item" => __( "View Gallery", "understrap" ),
			"view_items" => __( "View Galleries", "understrap" ),
			"search_items" => __( "Search Gallery", "understrap" ),
			"not_found" => __( "No galleries found", "understrap" ),
			"not_found_in_trash" => __( "No Galleries in trash", "understrap" ),
			"parent_item_colon" => __( "Parent Gallery", "understrap" ),
			"featured_image" => __( "Featured image for this Gallery", "understrap" ),
			"set_featured_image" => __( "Set featured image for this Gallery", "understrap" ),
			"remove_featured_image" => __( "Remove featured image from this Gallery", "understrap" ),
			"use_featured_image" => __( "Use as featured image for this Gallery", "understrap" ),
			"archives" => __( "Gallery Archives", "understrap" ),
			"insert_into_item" => __( "Insert into Gallery", "understrap" ),
			"uploaded_to_this_item" => __( "Uploaded to this Gallery", "understrap" ),
			"filter_items_list" => __( "Filter Gallery list", "understrap" ),
			"items_list_navigation" => __( "Gallery list navigation", "understrap" ),
			"items_list" => __( "Galleries List", "understrap" ),
			"attributes" => __( "Galleries Attributes", "understrap" ),
			"name_admin_bar" => __( "Gallery", "understrap" ),
			"parent_item_colon" => __( "Parent Gallery", "understrap" ),
		);

		$args = array(
			"label" => __( "Gallery", "understrap" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"delete_with_user" => false,
			"show_in_rest" => true,
			"rest_base" => "gallery",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "gallery", "with_front" => true ),
			"query_var" => true,
			"menu_position" => 7,
			"menu_icon" => "dashicons-slides",
			"supports" => array( "title", "editor", "thumbnail", "revisions" ),
		);

	register_post_type( "gallery", $args );
}



/* Registering Custom Taxonomies */
add_action('init', 'add_custom_taxonomy');
function add_custom_taxonomy() {
	register_taxonomy( 'subsidiary_tax', array('gallery', 'subsidiary', 'service', 'location', 'post', 'project_gallery', 'literature-downloads'), array( 'hierarchical' => true, 'label' => 'Subsidiary' ) );
	register_taxonomy( 'location_tax', array('location'), array( 'hierarchical' => true, 'label' => 'Location' ) );
}


/* Creating custom color pallete */
function theme_customize_register( $wp_customize ) {
  // Primary color
  $wp_customize->add_setting( 'primary_color', array(
	'default'   => '',
	'transport' => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
	'section' => 'colors',
	'label'   => esc_html__( 'Primary color', 'understrap' ),
  ) ) );

  // Seconadary color
  $wp_customize->add_setting( 'secondary_color', array(
	'default'   => '',
	'transport' => 'refresh',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
	'section' => 'colors',
	'label'   => esc_html__( 'Secondary color', 'understrap' ),
  ) ) );

  // Dark color
  $wp_customize->add_setting( 'dark_color', array(
	'default'   => '',
	'transport' => 'refresh',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dark_color', array(
	'section' => 'colors',
	'label'   => esc_html__( 'Dark color', 'understrap' ),
  ) ) );
}

add_action( 'customize_register', 'theme_customize_register' );
