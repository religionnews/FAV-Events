<?php

add_filter( 'cmb_meta_boxes', 'rns_event_metabox' );
/**
 * Define the metabox and field configurations.
 */
function rns_event_metabox( array $meta_boxes ) {

  // Start with an underscore to hide fields from custom fields list
  $prefix = '_rns_event_';

  /**
   * Create an array of states and provinces for the select field
   *
   * @see https://github.com/amphibian/pi.reegion_select.ee_addon
   */
  $states_and_provinces[] = array( 'name' => '', 'value' => '' );
  $rs_states = array("AL" => "Alabama", "AK" => "Alaska", "AS" => "American Samoa", "AZ" => "Arizona", "AR" => "Arkansas", "CA" => "California", "CO" => "Colorado", "CT" => "Connecticut", "DE" => "Delaware", "DC" => "Distric of Columbia", "FM" => "Federated States of Micronesia", "FL" => "Florida", "GA" => "Georgia", "GU" => "Guam", "HI" => "Hawaii", "ID" => "Idaho", "IL" => "Illinois", "IN" => "Indiana", "IA" => "Iowa", "KS" => "Kansas", "KY" => "Kentucky", "LA" => "Louisiana", "ME" => "Maine", "MH" => "Marshall Islands", "MD" => "Maryland", "MA" => "Massachusetts", "MI" => "Michigan", "MN" => "Minnesota", "MS" => "Mississippi", "MO" => "Missouri", "MT" => "Montana", "NC" => "North Carolina", "ND" => "North Dakota", "MP" => "Northern Mariana Islands", "NE" => "Nebraska", "NV" => "Nevada", "NH" => "New Hampshire", "NJ" => "New Jersey", "NM" => "New Mexico", "NY" => "New York", "OH" => "Ohio", "OK" => "Oklahoma", "OR" => "Oregon", "PW" => "Palau", "PA" => "Pennsylvania", "PR" => "Puerto Rico", "RI" => "Rhode Island", "SC" => "South Carolina", "SD" => "South Dakota", "TN" => "Tennessee", "TX" => "Texas", "UT" => "Utah", "VT" => "Vermont", "VI" => "Virgin Islands", "VA" => "Virginia", "WA" => "Washington", "WV" => "West Virginia", "WI" => "Wisconsin", "WY" => "Wyoming", "AE" => "Armed Forces (AE)", "AA" => "Armed Forces Americas", "AP" => "Armed Forces Pacific");
  foreach ( $rs_states as $key => $value ) {
    $states_and_provinces[] = array( 'name' => $value, 'value' => $key );
  }
  $rs_provinces = array("AB" => "Alberta", "BC" => "British Columbia", "MB" => "Manitoba", "NB" => "New Brunswick", "NL" => "Newfoundland and Labrador", "NT" => "Northwest Territories", "NS" => "Nova Scotia", "NU" => "Nunavut", "ON" => "Ontario", "PE" => "Prince Edward Island", "QC" => "Quebec", "SK" => "Saskatchewan", "YT" => "Yukon");
  foreach ($rs_provinces as $key => $value) {
    $states_and_provinces[] = array( 'name' => $value, 'value' => $key );
  }

  $meta_boxes[] = array(
    'id'         => 'rns_event_metabox',
    'title'      => 'Event',
    'pages'      => array( 'rns_event' ), // Post type
    'context'    => 'advanced',
    'priority'   => 'high',
    'show_names' => true, // Show field names on the left
    'fields'     => array(
      array(
        'name' => 'Starts',
        'desc' => '',
        'id'   => $prefix . 'starts',
        'type' => 'text_datetime_timestamp',
      ),
      array(
        'name' => 'Ends',
        'desc' => '',
        'id'   => $prefix . 'ends',
        'type' => 'text_datetime_timestamp',
      ),
      array(
        'name' => 'All-Day Event',
        'desc' => '',
        'id' => $prefix . 'all_day_event',
        'type' => 'checkbox'
      ),
      array(
        'name' => 'Location',
        'desc' => '',
        'id' => $prefix . 'location',
        'type' => 'text'
      ),
      array(
        'name' => 'Address',
        'desc' => '',
        'id' => $prefix . 'address',
        'type' => 'text'
      ),
      array(
        'name' => 'Address 2',
        'desc' => '',
        'id' => $prefix . 'address_2',
        'type' => 'text'
      ),
      array(
        'name' => 'ZIP',
        'desc' => '',
        'id' => $prefix . 'zip',
        'type' => 'text'
      ),
      array(
        'name' => 'City',
        'desc' => '',
        'id' => $prefix . 'city',
        'type' => 'text'
      ),
      array(
        'name' => 'State/Province',
        'desc' => '',
        'id' => $prefix . 'state',
        'type' => 'select',
        'options' => $states_and_provinces,
      ),
      array(
        'name' => 'Country',
        'desc' => '',
        'id' => $prefix . 'country',
        'type' => 'text'
      ),
      array(
        'name' => 'Contact Organization',
        'desc' => '',
        'id' => $prefix . 'contact_organization',
        'type' => 'text'
      ),
      array(
        'name' => 'Contact Name',
        'desc' => '',
        'id' => $prefix . 'contact_name',
        'type' => 'text'
      ),
      array(
        'name' => 'Contact Email',
        'desc' => '',
        'id' => $prefix . 'contact_email',
        'type' => 'text'
      ),
      array(
        'name' => 'Contact Phone',
        'desc' => '',
        'id' => $prefix . 'contact_phone',
        'type' => 'text'
      ),
      array(
        'name' => 'Contact URL',
        'desc' => '',
        'id' => $prefix . 'contact_url',
        'type' => 'text'
      ),
      array(
        'name' => 'List contact information publicly?',
        'desc' => '',
        'id' => $prefix . 'list_publicly',
        'type' => 'checkbox'
      ),
      array(
        'name' => 'Ticket Required?',
        'desc' => '',
        'id' => $prefix . 'ticket_required',
        'type' => 'checkbox'
      ),
    ),
  );

  return $meta_boxes;
}

add_action( 'admin_enqueue_scripts', 'rns_events_enqueue_chosen' );
/**
 * Enqueues chosen.js on the Edit Event screen
 */
function rns_events_enqueue_chosen() {
  global $post;
  if ( $post && 'rns_event' == $post->post_type ) {
    wp_enqueue_script( 'rns-events-chosen', plugins_url( '/components/chosen/chosen/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), '0.9.14' );
    wp_enqueue_style( 'rns-events-chosen', plugins_url( '/components/chosen/chosen/chosen.css', __FILE__ ), null, '0.9.14' );
  }
}

add_action( 'admin_head', 'rns_events_hook_admin_js', 100 );
/**
 * Add the Event-related inline JS to the footer if we're editing an Event
 */
function rns_events_hook_admin_js() {
	global $post;
	if ( $post && 'rns_event' == $post->post_type ) {
		add_action( 'admin_footer', 'rns_events_call_chosen', 140 );
		add_action( 'admin_footer', 'rns_events_datetime_splitter', 160 );
		add_action( 'admin_footer', 'rns_events_all_day_event_toggle', 170 );
		add_action( 'admin_footer', 'rns_events_ziptastic_lookup', 180 );
	}
}

/**
 * Prints a script that calls chosen.js on the States dropdown on
 * the Edit Events screen
 */
function rns_events_call_chosen() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#_rns_event_state').chosen({allow_single_deselect: true});
    });
    </script>
    <?php
}

/**
 * Adds HTML to visually separate the parts of the datetime fields
 */
function rns_events_datetime_splitter() {
    ?>
    <script>
    jQuery(document).ready(function($) {
      rnsEventDatetimeSplitter('rns_event_starts');
      rnsEventDatetimeSplitter('rns_event_ends');
    });

    /**
     * Adds labels and a linebreak around the parts of a datetime field
     *
     * @param {string} field The ID of the field as defined in CMB
     */
    function rnsEventDatetimeSplitter(field) {
      jQuery('#_' + field + '_date').wrap('<label for="_' + field + '_date">').before('Date: ');
      jQuery('label[for="_' + field + '_date"]').after('<br>');
      jQuery('#_' + field + '_time').wrap('<label for="_' + field + '_time">').before('Time: ');
    }
    </script>
    <?php
}

/**
 * Hide the time fields if the current event is marked as an "All-Day Event"
 */
function rns_events_all_day_event_toggle() {
	?>
	<script>
	jQuery(document).ready(function($) {
		if ( rnsIsAllDayEvent() ) {
			rnsToggleTimeFields();
		}
		rnsAttachTimeToggle();
	})

	/**
	 * Determine whether "All-Day Event" is checked
	 * @return {bool}
	 */
	function rnsIsAllDayEvent() {
		return jQuery('input[name="_rns_event_all_day_event"]').attr('checked') === 'checked';
	}

	/**
	 * Toggle the Starts and Ends time fields
	 */
	function rnsToggleTimeFields() {
		jQuery('label[for="_rns_event_ends_time"]').toggle();
		jQuery('label[for="_rns_event_starts_time"]').toggle();
	}

	/**
	 * Fire rnsToggleTimeFields() when the "All-Day Event" checkbox is clicked
	 *
	 * Because the boxes will already be hidden or shown appropriately on page
	 * load, we can continue toggling them without additional checks
	 */
	function rnsAttachTimeToggle() {
		var all_day_cbox = jQuery('input[name="_rns_event_all_day_event"]');
		all_day_cbox.click(function() {
			rnsToggleTimeFields();
		})
	}
	</script>
	<?php
}

/**
 * Queries Ziptastic when the user enters 5 digits into the ZIP
 * field
 *
 * If the API call is successful, the City, State, and Country
 * fields will fill in automatically. Will not query the API if the
 * City field is already filled.
 *
 * @see http://css-tricks.com/using-ziptastic/
 */
function rns_events_ziptastic_lookup() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#_rns_event_zip').keyup(function() {
        var el = $(this);
        if ((el.val().length == 5) && $('#_rns_event_city').val() == '') {
          $.ajax({
            url: "http://zip.elevenbasetwo.com/v2",
            cache: false,
            dataType: "json",
            type: "GET",
            data: "zip=" + el.val(),
            success: function(result, success) {
              $("#_rns_event_city").val(result.city);
              $('#_rns_event_state option:contains(' + result.state + ')').attr('selected', 'selected');
              $('#_rns_event_state').trigger("liszt:updated");
              $("#_rns_event_country").val(result.country);
            },
          });
        }
      })
    });
    </script>
    <?php
}


add_filter( 'cmb_validate_text_datetime_timestamp', 'rns_fix_datetime_validation', 30, 3 );
/**
 * Allows blank values in a datetime field to pass validation
 *
 * If the date and time are blank, return an empty string. If there
 * is a date but no time, then enter the time as 00:00.
 *
 * Overrides the default CMB validation that returns the current
 * date or time if the field is blank.
 *
 * @return mixed The Unix time value to enter into the database
 */
function rns_fix_datetime_validation( $new, $post_id, $field ) {
  $data = $_POST[$field['id']];

  /* Bail if no datetime field exists */
  if ( is_null( $data ) )
    return;

  if ( $data['date'] === '' && $data['time'] === '' )
    $new = '';
  if ( $data['date'] !== '' && $data['time'] === '')
    $new = strtotime( $data['date'] . ' 00:00' );

  return $new;
}

