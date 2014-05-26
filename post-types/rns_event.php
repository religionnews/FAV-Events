<?php

function rns_event_init() {
	$taxonomy = 'rns_event';
	register_post_type( $taxonomy, array(
		'hierarchical'        => false,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'supports'            => array( 'title', 'editor', 'author' ),
		'has_archive'         => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'calendar', 'with_front' => false ),
		'labels'              => array(
			'name'                => __( 'Events', 'rns-events' ),
			'singular_name'       => __( 'Event', 'rns-events' ),
			'add_new'             => __( 'Add new Event', 'rns-events' ),
			'all_items'           => __( 'Events', 'rns-events' ),
			'add_new_item'        => __( 'Add new Event', 'rns-events' ),
			'edit_item'           => __( 'Edit Event', 'rns-events' ),
			'new_item'            => __( 'New Event', 'rns-events' ),
			'view_item'           => __( 'View Event', 'rns-events' ),
			'search_items'        => __( 'Search Events', 'rns-events' ),
			'not_found'           => __( 'No Events found', 'rns-events' ),
			'not_found_in_trash'  => __( 'No Events found in trash', 'rns-events' ),
			'parent_item_colon'   => __( 'Parent Event', 'rns-events' ),
			'menu_name'           => __( 'Events', 'rns-events' ),
		),
	) );
	
	register_taxonomy_for_object_type( 'rns_belief', $taxonomy );
}
add_action( 'init', 'rns_event_init' );

function rns_event_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['rns_event'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Event updated. <a target="_blank" href="%s">View Event</a>', 'rns-events'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'rns-events'),
		3 => __('Custom field deleted.', 'rns-events'),
		4 => __('Event updated.', 'rns-events'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s', 'rns-events'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Event published. <a href="%s">View Event</a>', 'rns-events'), esc_url( $permalink ) ),
		7 => __('Event saved.', 'rns-events'),
		8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview Event</a>', 'rns-events'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Event</a>', 'rns-events'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview Event</a>', 'rns-events'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'rns_event_updated_messages' );

add_filter( 'coauthors_supported_post_types', 'rns_event_no_coauthors' );
/**
 * Remove support for Co-Authors
 *
 * @link  http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
 *
 * @see  coauthors_plus::action_init_late()
 * 
 * @param  array $post_types Array of post types due for CAP support
 * @return array             The updated array
 */
function rns_event_no_coauthors( $post_types ) {
	if ( ( $key = array_search( 'rns_event', $post_types ) ) !== false ) {
		unset( $post_types[$key] );
	}
	return $post_types;
}
