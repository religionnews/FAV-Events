<?php

/**
 * Check whether an event is marked as being all-day
 *
 * @since 1.1
 *
 * @return bool
 * @author David Herrera
 */
function rns_is_all_day_event( $post_id ) {
	if ( ! is_numeric( $post_id ) ) {
		return false;
	}

	return get_post_meta( $post_id, '_rns_event_all_day_event', true ) === 'on';
}
