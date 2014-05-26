<?php

class FAV_Event_Display{
    public $event_post_type = 'rns_event';

    function __construct(){
        add_action('template_redirect', array($this, 'add_filters'));
    }

    function add_filters(){
        global $post;
        if(get_post_type() == $this->event_post_type){
            //now do the magic sauce
            add_action('the_content', array($this, 'output_meta_display'));
            add_filter('rns_event_before_content', array($this, 'before_content_event_data'));
            add_filter('rns_event_after_content', array($this, 'after_content_event_data') );
        }
    }

    function output_meta_display($content){
        echo apply_filters('rns_event_before_content', '');
        echo $content;
        echo apply_filters('rns_event_after_content', '');
    }

    function before_content_event_data($incoming){
        $meta = get_post_custom(get_the_id());
        //FORMAT -- Event Date: 1:30 pm May 28, 2014
        $stuff = (isset($meta['_rns_event_starts'])) ? sprintf('<h3 class="event-date">%s: %s %s</h3>', __('Event Date', 'rns_events'),date('g:i a', $meta['_rns_event_starts'][0]), date('F j, Y', $meta['_rns_event_starts'][0])) : '<!-- no date given -->';
        return $stuff.$incoming;
    }

    function after_content_event_data($incoming){
        //FORMAT:
        // Location
        // The Giving Store at Glenwood Lutheran Church
        // 2545 Monroe St.
        // Toledo, OH 43620
        // US';=
        $meta = get_post_custom(get_the_id());
        $stuff = (isset($meta['_rns_event_contact_url'])) ? sprintf('<a href="%s" class="event-link" title="%s">%s</a>', esc_url($meta['_rns_event_contact_url'][0]), __('Visit Event Website', 'rns_events'), __('Visit Event Website', 'rns_events')) : '';
        $stuff .= sprintf('<h5>%s</h5>',  __('Location', 'rns_event'));
        $stuff .= (isset($meta['_rns_event_location'])) ? sprintf('%s<br />', $meta['_rns_event_location'][0]) : '';
        $stuff .= (isset($meta['_rns_event_address'])) ? sprintf('%s<br />', $meta['_rns_event_address'][0]) : '';
        $stuff .= (isset($meta['_rns_event_city'])) ? sprintf('%s ', $meta['_rns_event_city'][0]) : '';
        $stuff .= (isset($meta['_rns_event_state'])) ? sprintf('%s ', $meta['_rns_event_state'][0]) : '';
        $stuff .= (isset($meta['_rns_event_zip'])) ? sprintf('%s ', $meta['_rns_event_zip'][0]) : '';
        $stuff .= (isset($meta['_rns_event_country'])) ? sprintf('<br />%s ', $meta['_rns_event_country'][0]) : '';


        return $incoming.$stuff;
    }

}
new FAV_Event_Display;
