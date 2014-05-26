<?php

add_action( 'pre_get_posts', 'be_event_query' );
/**
 * Customize Event Query using Post Meta
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/customize-the-wordpress-query/
 * @param object $query data
 *
 */
function be_event_query( $query ) {

  if ( $query->is_main_query() && ! is_admin() && is_post_type_archive( 'rns_event' ) ) {
    // Begin with the next upcoming event, and go into the future
    $meta_query = array(
      array(
        'key' => '_rns_event_starts',
        'value' => strtotime( 'today ' . get_option( 'timezone_string' ) ),
        'compare' => '>'
      )
    );
    $query->set( 'meta_query', $meta_query );
    $query->set( 'orderby', 'meta_value_num' );
    $query->set( 'meta_key', '_rns_event_starts' );
    $query->set( 'order', 'asc' );
  }

}

function rns_get_upcoming_events( $number = 3, $expires = DAY_IN_SECONDS ) {
  $transient = 'rns_upcoming_events_' . $number;
  if ( false === ( $upcoming_events = get_transient( $transient ) ) ) {
    $meta_query = array(
      array(
        'key' => '_rns_event_starts',
        'value' => strtotime( 'today ' . get_option( 'timezone_string' ) ),
        'compare' => '>'
      )
    );
    $args = array(
      'post_type' => 'rns_event',
      'posts_per_page' => $number,
      'meta_query' => $meta_query,
      'orderby' => 'meta_value_num',
      'meta_key' => '_rns_event_starts',
      'order' => 'ASC',
    );
    $upcoming_events = new WP_Query( $args );
    set_transient( $transient, $upcoming_events, $expires );
  }
  return $upcoming_events;
}
