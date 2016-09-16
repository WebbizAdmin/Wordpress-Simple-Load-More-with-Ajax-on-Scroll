<?php
/**
* Plugin Name: Webbiz Load More
* Description: This allows a user to load more posts
* Author: Jason Morton
* Author URI: https://webbiz.ie
* Version: 1.0
* License: GPL2
* Text Domain: webbiz-laodmore
* Domain Path: /plugins
*/

/*
Copyright (C) Year  Author  Email

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* Register scripts and style sheets
*/
function wb_loadmore_register_styles() {
	wp_register_style( 'loadmore-css',  plugin_dir_url( __FILE__ ) . 'css/loadmore.css'); 
	wp_enqueue_style( 'loadmore-css' );
}

function wb_loadmore_register_ajax() {
	wp_register_script( 'loadmore-js',  plugin_dir_url( __FILE__ ) . 'js/loadmore.js', array('jquery'), 1.0, true);
	wp_enqueue_script( 'loadmore-js' );
	wp_localize_script('loadmore-js', 'loadMoreJS', array(
	    'pluginsUrl' => plugins_url(),
	    'ajaxurl'   => admin_url('admin-ajax.php')
	));
}

add_action( 'wp_enqueue_scripts', 'wb_loadmore_register_styles' );
add_action( 'wp_enqueue_scripts', 'wb_loadmore_register_ajax' );


/**
* Ajax function
*/
function wb_post_load_more() {
	// Variables
	$numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 0;
	$page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 0;

	query_posts( array(
		'posts_per_page' => $numPosts,
		'paged'	=> $page
	));

	if ( have_posts() ) :


		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;
		wp_reset_query();
		// the_posts_navigation();
	endif; 
	wp_die();
	
}
add_action('wp_ajax_nopriv_wb_load_more', 'wb_post_load_more');
add_action('wp_ajax_wb_load_more', 'wb_post_load_more');











