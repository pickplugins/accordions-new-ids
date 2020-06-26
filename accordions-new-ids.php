<?php
/*
Plugin Name: Accordions - Generate header IDs
Plugin URI: https://www.pickplugins.com/item/accordions-html-css3-responsive-accordion-grid-for-wordpress/?ref=dashboard
Description: Fully responsive and mobile ready accordion grid for wordpress.
Version: 1.0.0
Author: PickPlugins
Author URI: http://pickplugins.com
Text Domain: accordions-xml
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 




add_shortcode('accordions_generate_header_ids', 'accordions_generate_header_ids');

function accordions_generate_header_ids(){

    $args = array(
        'post_type'=>'accordions',
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'date',
        'posts_per_page' => -1,

    );

    $wp_query = new WP_Query($args);


    if($wp_query->have_posts()){
        while ($wp_query->have_posts()){
            $wp_query->the_post();

            $post_id = get_the_ID();

            $accordions_options = get_post_meta($post_id,'accordions_options', true);
            $accordions_content = isset($accordions_options['content']) ? $accordions_options['content'] : array();

            $new_content = array();

            $i = 0;
            foreach ($accordions_content as $index => $content){

                $id = $i.'-'.$post_id;

                $new_content[$id] = $content;

                echo '<pre>'.var_export($index, true).'</pre>';
                $i++;
            }

            $accordions_options['content'] = $new_content;

            update_post_meta($post_id,'accordions_options', $accordions_options);

            echo '<pre>'.var_export($accordions_options, true).'</pre>';


        }
    }

}


