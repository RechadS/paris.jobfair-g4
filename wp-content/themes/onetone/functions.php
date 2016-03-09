<?php

define( 'ONETONE_THEME_BASE_URL', get_template_directory_uri());
define( 'ONETONE_OPTIONS_FRAMEWORK', get_template_directory().'/admin/' ); 
define( 'ONETONE_OPTIONS_FRAMEWORK_URI',  ONETONE_THEME_BASE_URL. '/admin/'); 
define('ONETONE_OPTIONS_PREFIXED' ,'onetone_');

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/' );
require_once dirname( __FILE__ ) . '/admin/options-framework.php';
require_once get_template_directory() . '/includes/admin-options.php';

/**
 * Required: include options framework.
 **/
load_template( trailingslashit( get_template_directory() ) . 'admin/options-framework.php' );

/**
 * Mobile Detect Library
 **/
 if(!class_exists("Mobile_Detect")){
   load_template( trailingslashit( get_template_directory() ) . 'includes/Mobile_Detect.php' );
 }
/**
 * Theme setup
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-setup.php' );

/**
 * Theme Functions
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-functions.php' );

/**
 * Theme breadcrumb
 **/
load_template( trailingslashit( get_template_directory() ) . 'includes/class-breadcrumb.php');
/**
 * Theme widget
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-widget.php' );


 

add_filter( 'manage_edit-entreprise_columns', 'my_edit_entreprise_columns' ) ;

function my_edit_entreprise_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Entreprise' ),
		'en_charge' => __( 'En Charge' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_entreprise_posts_custom_column', 'my_manage_entreprise_columns', 10, 2 );

function my_manage_entreprise_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'en_charge' :

			/* Get the post meta. */
			$encharge = get_post_meta( $post_id, 'en_charge', true );

			/* If no duration is found, output a default message. */
			if ( empty( $encharge ) )
				echo __( 'Non Défini' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __( '%s' ), $encharge );

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter( 'manage_edit-entreprise_sortable_columns', 'my_entreprise_sortable_columns' );

function my_entreprise_sortable_columns( $columns ) {

	$columns['en_charge'] = 'en_charge';

	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'my_edit_entreprise_load' );

function my_edit_entreprise_load() {
	add_filter( 'request', 'my_sort_entreprise' );
}

/* Sorts the movies. */
function my_sort_entreprise( $vars ) {

	/* Check if we're viewing the 'movie' post type. */
	if ( isset( $vars['post_type'] ) && 'entreprise' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'duration'. */
		if ( isset( $vars['orderby'] ) && 'en_charge' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'en_charge',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}