<?php
/*
Plugin Name: FAV Events
Version: 1.4
Description: Custom post type, custom fields, and queries for the event calendar
Author: David Herrera
Text Domain: rns-events
*/

/* note: if you're the next developer to inherit this plugin I'm sorry.
Rather than trying to fix it just get a different event plugin that works

-- Russell Fair
*/

require_once( dirname(__FILE__) . '/post-types/rns_event.php' );
require_once( dirname(__FILE__) . '/queries.php' );
require_once( dirname(__FILE__) . '/functions.php' );

//added another class for FAVS - more of a last ditch hack than anything else
require_once( dirname(__FILE__) . '/display.php' );

if ( is_admin() )
  require_once( dirname(__FILE__) . '/metaboxes.php' );
