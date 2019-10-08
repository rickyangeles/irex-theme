<?php

add_action('acf/init', 'my_acf_init');

add_filter( 'block_categories', function( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'flex-sections',
				'title' => __( 'Flex Sections', 'flex-sections' ),
			),
		)
	);
}, 10, 2 );

function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyDhavbTbMkRVDucZhx7ohIgdxgLv5D0RxI');

	// check function exists
	if( function_exists('acf_register_block') ) {

        // register a CTA block
		acf_register_block(array(
			'name'				=> 'cta',
			'title'				=> __('CTA'),
			'description'		=> __('A cta block.'),
			'render_callback'	=> 'custom_block_render_callback',
			'category'			=> 'flex-sections',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'cta', 'quote' ),
			'mode' 				=> 'edit',
		));

		// register a Full-Width block
		acf_register_block(array(
			'name'				=> 'full-width',
			'title'				=> __('Full-Width'),
			'description'		=> __('A Full-Width block.'),
			'render_callback'	=> 'custom_block_render_callback',
			'category'			=> 'flex-sections',
			'icon'				=> 'text',
			'keywords'			=> array( 'full-width', 'quote' ),
			'mode' 				=> 'edit',
		));

		// register a Post Grid block
		acf_register_block(array(
			'name'				=> 'postgrid',
			'title'				=> __('Post Grid'),
			'description'		=> __('A Post Grid block.'),
			'render_callback'	=> 'custom_block_render_callback',
			'category'			=> 'flex-sections',
			'icon'				=> 'screenoptions',
			'keywords'			=> array( 'post', 'quote' ),
			'mode' 				=> 'edit',
		));

		// register a Split Column block
		acf_register_block(array(
			'name'				=> 'split',
			'title'				=> __('Split Columns'),
			'description'		=> __('A Split Column block.'),
			'render_callback'	=> 'custom_block_render_callback',
			'category'			=> 'flex-sections',
			'icon'				=> 'feedback',
			'keywords'			=> array( 'split', 'quote' ),
			'mode' 				=> 'edit',
		));

		// register a Multi Column block
		acf_register_block(array(
			'name'				=> 'multi',
			'title'				=> __('Multi Column'),
			'description'		=> __('A Multi Column block.'),
			'render_callback'	=> 'custom_block_render_callback',
			'category'			=> 'flex-sections',
			'icon'				=> 'editor-table',
			'keywords'			=> array( 'multi', 'quote' ),
			'mode' 				=> 'edit',
		));


	}
}

function custom_block_render_callback( $block ) {
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);

	// include a template part from within the "template-parts/block" folder
	if( file_exists(STYLESHEETPATH . "/template-parts/block/content-{$slug}.php") ) {
		include( STYLESHEETPATH . "/template-parts/block/content-{$slug}.php" );
	}
}


?>
