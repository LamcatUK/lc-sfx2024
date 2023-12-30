<?php

function cb_register_post_types()
{
    /**
     * Post Type: Fighters.
     */

    $labels = [
       "name" => esc_html__("Fighters", "lc-sfx2024"),
       "singular_name" => esc_html__("Fighter", "lc-sfx2024"),
    ];

    $args = [
        "label" => esc_html__("Fighters", "lc-sfx2024"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => true,
        "rewrite" => [ "slug" => "fighters", "with_front" => false ],
        "query_var" => true,
        "supports" => [ "title", "editor", "thumbnail" ],
        "show_in_graphql" => false,
    ];

    register_post_type("fighters", $args);

    /**
     * Post Type: events.
     */

    $labels = [
       "name" => esc_html__("Events", "lc-sfx2024"),
       "singular_name" => esc_html__("Event", "lc-sfx2024"),
    ];

    $args = [
        "label" => esc_html__("Events", "lc-sfx2024"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => true,
        "rewrite" => [ "slug" => "events", "with_front" => false ],
        "query_var" => true,
        "supports" => [ "title", "editor", "thumbnail" ],
        "show_in_graphql" => false,
    ];

    register_post_type("events", $args);

}

add_action('init', 'cb_register_post_types');
