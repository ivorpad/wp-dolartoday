<?php
/*
Plugin Name: DolarToday
Plugin URI: http://ivorpad.com
Description: Display DolarToday Prices as a shortcode or Widget.
Version: 1.0
Author: Ivor Padilla
Author URI: http://ivorpad.com
License: GPL2
*/

/*
 * Disclaimer: This plugin nor its author are related to DolarToday and its entities.
 */

if ( !defined('ABSPATH') )
    die('-1');


function dt_get_api_response($url, $transient) {
    $cached = get_transient($transient);
    if( false !== $cached ) {
        return json_decode($cached);
    }

    $response = wp_remote_get($url);

    if( is_wp_error( $response ) ) {
        return "The API is having issues, please try again later.";
    }

    // If the API uses tilde we must encode to utf8
    // and retrieve body $response.
    $body = utf8_encode ( wp_remote_retrieve_body($response) );


    set_transient( $transient, $body, 60*60*4 );

    // Decoding JSON string
    return json_decode($body); 
}

function dt_display_dolar_today() {   
    $dolartoday = dt_get_api_response('https://s3.amazonaws.com/dolartoday/data.json', 'dt_dolar_today_transient');
    echo "<div class='dolar_today_shortcode'>";
    include plugin_dir_path(__FILE__) . 'templates/info-display.php';
    echo "</div>";
}

add_shortcode('dolartoday', 'dt_display_dolar_today');

function dt_enqueue_styles() {
    wp_enqueue_style(
        'dt-style',
        plugins_url('styles/dt-style.css', __FILE__)
    );
}
add_action('wp_enqueue_scripts', 'dt_enqueue_styles');

include plugin_dir_path(__FILE__) . 'widget.php';
