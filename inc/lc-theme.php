<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

require_once LC_THEME_DIR . '/inc/lc-posttypes.php';
require_once LC_THEME_DIR . '/inc/lc-taxonomies.php';
require_once LC_THEME_DIR . '/inc/lc-utility.php';
require_once LC_THEME_DIR . '/inc/lc-blocks.php';
// require_once LC_THEME_DIR . '/inc/lc-news.php';
// require_once LC_THEME_DIR . '/inc/lc-careers.php';


// Remove unwanted SVG filter injection WP
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');


add_filter('big_image_size_threshold', '__return_false');

// Remove comment-reply.min.js from footer
function remove_comment_reply_header_hook()
{
    wp_deregister_script('comment-reply');
}
add_action('init', 'remove_comment_reply_header_hook');

add_action('admin_menu', 'remove_comments_menu');
function remove_comments_menu()
{
    remove_menu_page('edit-comments.php');
}

add_filter('theme_page_templates', 'child_theme_remove_page_template');
function child_theme_remove_page_template($page_templates)
{
    // unset($page_templates['page-templates/blank.php'],$page_templates['page-templates/empty.php'], $page_templates['page-templates/fullwidthpage.php'], $page_templates['page-templates/left-sidebarpage.php'], $page_templates['page-templates/right-sidebarpage.php'], $page_templates['page-templates/both-sidebarspage.php']);
    unset($page_templates['page-templates/blank.php'],$page_templates['page-templates/empty.php'], $page_templates['page-templates/left-sidebarpage.php'], $page_templates['page-templates/right-sidebarpage.php'], $page_templates['page-templates/both-sidebarspage.php']);
    return $page_templates;
}
add_action('after_setup_theme', 'remove_understrap_post_formats', 11);
function remove_understrap_post_formats()
{
    remove_theme_support('post-formats', array( 'aside', 'image', 'video' , 'quote' , 'link' ));
}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(
        array(
            'page_title' 	=> 'Site-Wide Settings',
            'menu_title'	=> 'Site-Wide Settings',
            'menu_slug' 	=> 'theme-general-settings',
            'capability'	=> 'edit_posts',
        )
    );
    acf_add_options_page(
        array(
            'page_title' 	=> 'SFX Results',
            'menu_title'	=> 'SFX Results',
            'menu_slug' 	=> 'theme-sfx-results',
            'capability'	=> 'edit_posts',
        )
    );
}

function widgets_init()
{
    register_nav_menus(array(
        'primary_nav' => __('Primary Nav', 'lc-sfx2024'),
    ));
    register_nav_menus(array(
        'footer_menu1' => __('Footer Menu 1', 'lc-sfx2024'),
    ));
    register_nav_menus(array(
        'footer_menu2' => __('Footer Menu 2', 'lc-sfx2024'),
    ));

    unregister_sidebar('hero');
    unregister_sidebar('herocanvas');
    unregister_sidebar('statichero');
    unregister_sidebar('left-sidebar');
    unregister_sidebar('right-sidebar');
    unregister_sidebar('footerfull');
    unregister_nav_menu('primary');
}
add_action('widgets_init', 'widgets_init', 11);


remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

//Custom Dashboard Widget
add_action('wp_dashboard_setup', 'register_LC_dashboard_widget');
function register_LC_dashboard_widget()
{
    wp_add_dashboard_widget(
        'lc_dashboard_widget',
        'Lamcat',
        'lc_dashboard_widget_display'
    );
}

function lc_dashboard_widget_display()
{
    ?>
<div style="display: flex; align-items: center; justify-content: space-around;">
    <img style="width: 50%;"
        src="<?= get_stylesheet_directory_uri().'/img/lc-full.jpg'; ?>">
    <a class="button button-primary" target="_blank" rel="noopener nofollow noreferrer"
        href="mailto:hello@lamcat.co.uk/">Contact</a>
</div>
<div>
    <p><strong>Thanks for choosing Lamcat!</strong></p>
    <hr>
    <p>Got a problem with your site, or want to make some changes & need us to take a look for you?</p>
    <p>Use the link above to get in touch and we'll get back to you ASAP.</p>
</div>
<?php
}


add_filter(
    'wpseo_breadcrumb_links',
    function ($links) {
        global $post;
        if (is_singular('fighters')) {
            $t = get_the_category($post->ID);
            $breadcrumb[] = array(
                'url' => '/fighters/',
                'text' => 'Fighters',
            );
            array_splice($links, 1, -2, $breadcrumb);
        }
        if (is_singular('events')) {
            $t = get_the_category($post->ID);
            $breadcrumb[] = array(
                'url' => '/events/',
                'text' => 'Events',
            );
            array_splice($links, 1, -2, $breadcrumb);
        }
        return $links;
    }
);

// remove discussion metabox
function cc_gutenberg_register_files()
{
    // script file
    wp_register_script(
        'cc-block-script',
        get_stylesheet_directory_uri() .'/js/block-script.js', // adjust the path to the JS file
        array( 'wp-blocks', 'wp-edit-post' )
    );
    // register block editor script
    register_block_type('cc/ma-block-files', array(
        'editor_script' => 'cc-block-script'
    ));
}
add_action('init', 'cc_gutenberg_register_files');

function understrap_all_excerpts_get_more_link($post_excerpt)
{
    if (is_admin() || ! get_the_ID()) {
        return $post_excerpt;
    }
    return $post_excerpt;
}

//* Remove Yoast SEO breadcrumbs from Revelanssi's search results
add_filter('the_content', 'wpdocs_remove_shortcode_from_index');
function wpdocs_remove_shortcode_from_index($content)
{
    if (is_search()) {
        $content = strip_shortcodes($content);
    }
    return $content;
}

// GF really is pants.
/**
 * Change submit from input to button
 *
 * Do not use example provided by Gravity Forms as it strips out the button attributes including onClick
 */
// function wd_gf_update_submit_button($button_input, $form)
// {
//     //save attribute string to $button_match[1]
//     preg_match("/<input([^\/>]*)(\s\/)*>/", $button_input, $button_match);

//     //remove value attribute (since we aren't using an input)
//     $button_atts = str_replace("value='" . $form['button']['text'] . "' ", "", $button_match[1]);

//     // create the button element with the button text inside the button element instead of set as the value
//     return '<button ' . $button_atts . '><span>' . $form['button']['text'] . '</span></button>';
// }
// add_filter('gform_submit_button', 'wd_gf_update_submit_button', 10, 2);




function LC_theme_enqueue()
{
    // Get the theme data.
    $the_theme     = wp_get_theme();
    $theme_version = $the_theme->get('Version');

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    // Grab asset urls.
    $theme_styles  = "/css/child-theme{$suffix}.css";
    $theme_scripts = "/js/child-theme{$suffix}.js";
    
    $css_version = $theme_version . '.' . filemtime(get_stylesheet_directory() . $theme_styles);

    // wp_enqueue_style('lightbox-stylesheet', get_stylesheet_directory_uri() . '/css/lightbox.min.css', array(), $the_theme->get('Version'));
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox-plus-jquery.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js', array(), null, true);
    // wp_enqueue_style('slick-styles', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), $the_theme->get('Version'));
    // wp_enqueue_style('slick-theme-styles', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array(), $the_theme->get('Version'));
    // wp_enqueue_script('slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), null, true);
    wp_enqueue_style('aos-style', "https://unpkg.com/aos@2.3.1/dist/aos.css", array());
    wp_enqueue_script('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), null, true);
    // wp_enqueue_script('parallax', get_stylesheet_directory_uri() . '/js/parallax.min.js', array('jquery'), $the_theme->get('Version'), true);
    // wp_enqueue_script('child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array('jquery'), $css_version, true);
    wp_enqueue_script('child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $css_version, true);

    wp_enqueue_style('child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version);
    // wp_enqueue_script( 'jquery' );
    
    $js_version = $theme_version . '.' . filemtime(get_stylesheet_directory() . $theme_scripts);
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'LC_theme_enqueue');


// black thumbnails - fix alpha channel
/**
 * Patch to prevent black PDF backgrounds.
 *
 * https://core.trac.wordpress.org/ticket/45982
 */
// require_once ABSPATH . 'wp-includes/class-wp-image-editor.php';
// require_once ABSPATH . 'wp-includes/class-wp-image-editor-imagick.php';

// // phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
// final class ExtendedWpImageEditorImagick extends WP_Image_Editor_Imagick
// {
//     /**
//      * Add properties to the image produced by Ghostscript to prevent black PDF backgrounds.
//      *
//      * @return true|WP_error
//      */
//     // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
//     protected function pdf_load_source()
//     {
//         $loaded = parent::pdf_load_source();

//         try {
//             $this->image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
//             $this->image->setBackgroundColor('#ffffff');
//         } catch (Exception $exception) {
//             error_log($exception->getMessage());
//         }

//         return $loaded;
//     }
// }

// /**
//  * Filters the list of image editing library classes to prevent black PDF backgrounds.
//  *
//  * @param array $editors
//  * @return array
//  */
// add_filter('wp_image_editors', function (array $editors): array {
//     array_unshift($editors, ExtendedWpImageEditorImagick::class);

//     return $editors;
// });




function lc_post_nav()
{
    ?>
<div class="d-flex justify-content-between">
    <?php
    $prev_post_obj = get_adjacent_post('', '', true);
    if ($prev_post_obj) {
        $prev_post_ID   = isset($prev_post_obj->ID) ? $prev_post_obj->ID : '';
        $prev_post_link     = get_permalink($prev_post_ID);
        ?>
    <a href="<?php echo $prev_post_link; ?>" rel="next"
        class="btn btn-previous btn-green">Previous</a>
    <?php
    }

    $next_post_obj  = get_adjacent_post('', '', false);
    if ($next_post_obj) {
        $next_post_ID   = isset($next_post_obj->ID) ? $next_post_obj->ID : '';
        $next_post_link     = get_permalink($next_post_ID);
        ?>
    <a href="<?php echo $next_post_link; ?>" rel="next"
        class="btn btn-next btn-green">Next</a>
    <?php
    }
    ?>
</div>
<?php

}


/* append button to primary nav */
add_filter('wp_nav_menu_items', 'add_admin_link', 10, 2);
function add_admin_link($items, $args)
{
    $vote = get_field('show_vote', 'options') ?? null;
    if(isset($vote) && !empty($vote) && $vote[0] == 'Yes') {
        if ($args->theme_location == 'primary_nav') {
            $items .= '<li><a class="btn btn-highlight" title="Vote" href="/rankings/vote/">Vote</a></li>';
        }
    }
    return $items;
}



// get image id from first slide in lc-hero
function get_hero($postID)
{
    $blocks = parse_blocks(get_the_content(null, false, $postID));
    $bg = '';
    foreach ($blocks as $b) {
        if ('acf/lc-hero' === $b['blockName']) {
            $bg = $b['attrs']['data']['slides_0_background'];
            return $bg;
        }
    }
    return;
}

add_filter('wpcf7_autop_or_not', '__return_false');

// add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2);
function add_current_nav_class($classes, $item)
{
    if (! ($item instanceof WP_Post)) {
        return $classes;
    }

    $post = get_post();
    if (empty($post)) {
        return $classes;
    }

    $post_type          = get_post_type($post->ID);
    $post_type_object   = get_post_type_object($post_type);

    if (! ($post_type_object instanceof WP_Post_Type) || ! $post_type_object->has_archive) {
        return $classes;
    }
        
    $post_type_slug = $post_type_object->rewrite['slug'];
    $menu_slug      = strtolower(trim($item->url));

    if (empty($post_type_slug) || empty($menu_slug)) {
        return $classes;
    }
    if (strpos($menu_slug, $post_type_slug) === false) {
        return $classes;
    }
        
    $classes[] = 'current-menu-item';

    return $classes;
}

/*---------------------------------------------------------------------------*/
function calc_age($dob)
{
    $birthDate = new DateTime($dob);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    return $age;
}
function calc_imperial_height($cm)
{
    $inches = $cm / 2.54;
    $feet = floor($inches / 12);
    $remainingInches = round($inches - ($feet * 12));
    $height = $feet . "'" . $remainingInches . '"';
    return $height;
}

function calc_imperial_weight($kg)
{
    return round($kg * 2.20462);
}

function get_wld($id)
{
    $res = fight_history($id);
    $obj = array(
        'wins' => 0,
        'losses' => 0,
        'draws' => 0,
    );
    foreach ($res as $r) {
        if ($r['result'] == 'Win') {
            $obj['wins']++;
        } elseif ($r['result'] == 'Loss') {
            $obj['losses']++;
        } else {
            $obj['draws']++;
        }
    }

    return $obj['wins'] . '-' . $obj['losses'] . '-' . $obj['draws'];
}

function get_results($id)
{
    $res = fight_history($id);
    $obj = array(
        'wins' => 0,
        'losses' => 0,
        'draws' => 0,
        'win_ko' => 0,
        'win_sub' => 0,
        'win_dec' => 0,
        'loss_ko' => 0,
        'loss_sub' => 0,
        'loss_dec' => 0,
    );
    foreach ($res as $r) {
        if ($r['result'] == 'Win') {
            $obj['wins']++;
            switch ($r['decision']) {
                case 'KO/TKO':
                    $obj['win_ko']++;
                    break;
                case 'Submission':
                    $obj['win_sub']++;
                    break;
                case 'Decision':
                    $obj['win_dec']++;
                    break;
            }
        } elseif ($r['result'] == 'Loss') {
            $obj['losses']++;
            switch ($r['decision']) {
                case 'KO/TKO':
                    $obj['loss_ko']++;
                    break;
                case 'Submission':
                    $obj['loss_sub']++;
                    break;
                case 'Decision':
                    $obj['loss_dec']++;
                    break;
            }
        } elseif ($r['result'] == 'Draw') {
            $obj['draws']++;
        }
    }
    return $obj;
}
function pct($i, $t)
{
    if ($t == 0) {
        return '0%';
    }
    $p = ($i / $t) * 100;
    $p = sprintf('%3d%%', $p);
    return $p;
}

function fight_history($id)
{

    $res = get_field('results', 'options');
    
    $filteredResults = array_filter($res, function ($res) use ($id) {
        return $res["fighter_one"] == $id || $res["fighter_two"] == $id;
    });

    foreach ($filteredResults as &$f) {
        $f['date'] = get_field('event_date', $f['event']);
        if ($f['result'] == 'Win' && $f['fighter_one'] == $id) {
            $f['result'] = 'Win';
        } elseif ($f['result'] == 'Win' && $f['fighter_two'] == $id) {
            $f['result'] = 'Loss';
        } elseif ($f['result'] == 'Loss' && $f['fighter_one'] == $id) {
            $f['result'] = 'Loss';
        } elseif ($f['result'] == 'Loss' && $f['fighter_two'] == $id) {
            $f['result'] = 'Win';
        }
    }

    usort($filteredResults, 'compareDatesDesc');
    
    return $filteredResults;

}
function compareDatesAsc($a, $b)
{
    return strcmp($a['date'], $b['date']);
}
function compareDatesDesc($a, $b)
{
    return strcmp($b['date'], $a['date']);
}


function date_to_cal($date)
{
    if (preg_match('/^(\d{4})(\d{2})(\d{2})$/', $date, $matches)) {

        $monthMap = [
            "01" => "Jan",
            "02" => "Feb",
            "03" => "Mar",
            "04" => "Apr",
            "05" => "May",
            "06" => "Jun",
            "07" => "Jul",
            "08" => "Aug",
            "09" => "Sep",
            "10" => "Oct",
            "11" => "Nov",
            "12" => "Dec",
        ];

        ob_start();
        $year = $matches[1];
        $month = $matches[2];
        $day = $matches[3];
        ?>
<div class="cal">
    <div class="mon"><?=$monthMap[$month]?></div>
    <div class="day"><?=$day?></div>
    <div class="year"><?=$year?></div>
</div>
<?php
        return ob_get_clean();
    } else {
        return;
    }
}

function get_results_by_event($event_id)
{
    $res = get_field('results', 'options');
    
    $filteredResults = array_filter($res, function ($res) use ($event_id) {
        return $res['event'] == $event_id;
    });
    
    return $filteredResults;
}

/*---------------------------- sidebars --*/

function sidebar_latest_news($ids = 0)
{
    ob_start();
    $q = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
        'post__not_in' => array($ids),
    ));
    if ($q->have_posts()) {
        ?>
<div class="sidebar_panel">
    <h3 class="headline fs-500">Latest <span>News</span></h3>
    <div class="sidebar_panel__data">
        <ul>
            <?php
        while ($q->have_posts()) {
            $q->the_post();
            ?>
            <li><a
                    href="<?=get_the_permalink()?>"><?=get_the_title()?></a>
            </li>
            <?php
        }
        ?>
        </ul>
    </div>
</div>
<?php
    }
    wp_reset_postdata();
    return ob_get_clean();
}

function sidebar_upcoming_events($ids = 0)
{
    ob_start();
    
    $q = new WP_Query(array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
              'key' => 'event_date',
              'value' => date('Ymd'),
              'compare' => '>=',
              'type' => 'DATE',
            ),
        ),
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'post__not_in' => array($ids),
    ));
    if ($q->have_posts()) {
        ?>
<div class="sidebar_panel">
    <h3 class="headline fs-500">Upcoming <span>Events</span></h3>
    <div class="sidebar_panel__data">
        <?php
        while ($q->have_posts()) {
            $q->the_post();
            ?>
        <a href="<?=get_the_permalink(get_the_ID())?>"
            class="sidebar_panel__event">
            <?=date_to_cal(get_field('event_date'))?>
            <div>
                <h4 class="headline fs-400 mb-0">
                    <?=get_the_title()?>
                </h4>
                <div>
                    <?=get_field('location')?>
                </div>
            </div>
        </a>
        <?php
        }
        ?>
    </div>
</div>
<?php
    }
    wp_reset_postdata();
    return ob_get_clean();
}

function sidebar_vote_cta()
{
    ob_start();
    $vote = get_field('show_vote', 'options') ?? null;
    if(isset($vote) && !empty($vote) && $vote[0] == 'Yes') {
        ?>
<div class="sidebar_panel">
    <h3 class="headline fs-500">Register <span>Your Vote!</span></h3>
    <div class="sidebar_panel__data">
        <p>Who would you like to see matched on our next fight card?</p>
        <a class="button button--block" href="/rankings/vote/">Vote</a>
    </div>
</div>
<?php
    }
    return ob_get_clean();
}

?>