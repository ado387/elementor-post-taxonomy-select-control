<?php


if ( did_action( 'elementor/loaded' ) ) {

	function custom_elementor_controls() {
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;

		// Add post-select control.
		require_once THEME_FOLDER_INC . '/elementor/class-post-select.php';
		$controls_manager->register_control( 'custom-post-select', new Custom_Post_Select() );

		// Add taxonomy-select control.
		require_once THEME_FOLDER_INC . '/elementor/class-taxonomy-select.php';
		$controls_manager->register_control( 'custom-taxonomy-select', new Custom_Taxonomy_Select() );
	}

	add_action( 'elementor/controls/controls_registered', 'custom_elementor_controls' );
}

/**
 * Handles ajax posts requests.
 *
 * @see https://developer.wordpress.org/reference/classes/wp_query/
 */
function custom_post_query() {

	// Prepare base response structure required by select2.js
	$response = array(
		'results' => array(),
		'pagination' => array(
			'more' => false,
		),
	);

	if ( empty( $_POST ) ) {
		wp_send_json( array( 'error' => 'Post empty'), 400 );
	}

	$args = $_POST;

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$response['results'][] = array(
				'id'   => get_the_ID(),
				'text' => get_the_title(),
			);
		}

		if ( ! empty( $args['paged'] ) && $args['paged'] < $query->max_num_pages ) {
			$response['pagination']['more'] = true;
		}
	}

	wp_send_json( $response );
}



/**
 * Handles ajax term requests.
 * 
 * @see https://developer.wordpress.org/reference/functions/get_terms/
 * @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/ For accepted arguments.
 */
function custom_terms_query() {

	// Prepare response structure.
	$response = array(
		'results' => array(),
		'pagination' => array(
			'more' => false,
		),
	);

	if ( empty( $_POST ) ) {
		wp_send_json( array( 'error' => 'Post empty'), 400 );
	}

	$args = $_POST;

	$terms = get_terms( $args );

	if ( is_wp_error( $terms ) ) {
		wp_send_json( array( 'error' => $terms->get_error_message()) );
	}

	if ( $terms ) {

		foreach ( $terms as $term ) {
			$response['results'][] = array(
					'id'   => $term->term_id,
					'text' => $term->name,
			);
		}

	}

	wp_send_json( $response );
}


if ( is_admin() ) {
	add_action( 'wp_ajax_custom_post_query', 'custom_post_query' );
	add_action( 'wp_ajax_custom_terms_query', 'custom_terms_query' );
}
