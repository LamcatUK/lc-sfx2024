<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
$img = wp_get_attachment_image_url(get_field('profile_image'), 'full');
?>
<main id="main" class="fighter">
    <?php
    $content = get_the_content();
$blocks = parse_blocks($content);
$sidebar = array();
$after;
?>
    <section class="pt-2 breadcrumbs container-xl">
        <?php
if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<div id="breadcrumbs" class="mb-2">', '</div>');
}
?>
    </section>
    <div class="container-xl">
        <div class="row g-2 pb-2">
            <div class="col-lg-9 order-1">
                <div class="profile_card">
                    <img src="<?=$img?>" alt=""
                        class="profile_card__image">
                    <div class="profile_card__header">
                        <div class="profile_card__name">
                            <h1 class="fighter__title">
                                <?=get_the_title()?>
                            </h1>
                            <?php
                            $nickname = get_field('nickname', get_the_ID()) ?? null;
if ($nickname) {
    ?>
                            <div class="fighter__nickname">
                                "<?=get_field('nickname', get_the_ID())?>"
                            </div>
                            <?php
}
?>
                        </div>
                        <div class="profile_card__country">
                            <div>
                                <div class="country">
                                    <?=get_field('country')?>
                                </div>
                                <div class="city">
                                    <?=get_field('city')?>
                                </div>
                            </div>
                            <div class="flag">
                                <img class="flag-img"
                                    src="https://flagicons.lipis.dev/flags/4x3/<?=strtolower(get_field('country_code'))?>.svg"
                                    alt="">
                            </div>
                        </div>
                    </div>

                    <div class="profile_card__stats">
                        <div class="profile_card__details">
                            <div class="headline">Age</div>
                            <div>
                                <strong><?=calc_age(get_field('dob'))?></strong>
                                /
                                <?=get_field('dob')?>
                            </div>
                            <div class="headline">Height</div>
                            <div>
                                <strong><?=get_field('height')?>
                                    CM</strong>
                                /
                                <?=calc_imperial_height(get_field('height'))?>
                            </div>
                            <div class="headline mb-2">Weight</div>
                            <div>
                                <strong><?=get_field('weight')?>
                                    KG</strong>
                                /
                                <?=calc_imperial_weight(get_field('weight'))?>
                                LBS
                            </div>
                            <?php
                            if (get_field('association')) {
                                ?>
                            <div class="grid-span-2">
                                <div class="headline">Association/Gym</div>
                                <div>
                                    <?=get_field('association')?>
                                </div>
                            </div>
                            <?php
                            }
?>
                            <div class="grid-span-2">
                                <div class="headline">Class</div>
                                <div>
                                    <?=get_field('weight_class')->name?>
                                </div>
                            </div>
                            <?php
if (get_field('style')) {
    ?>
                            <div class="grid-span-2">
                                <div class="headline">Style</div>
                                <div>
                                    <?=get_field('style')?>
                                </div>
                            </div>
                            <?php
}
?>
                        </div>
                        <?php
                        $res = get_results(get_the_ID());
?>
                        <div class="profile_card__record">
                            <div class="wins_container">
                                <div class="wins">
                                    <div>Wins</div>
                                    <div class="text-end">
                                        <?=$res['wins']?>
                                    </div>
                                </div>
                                <div class="result">
                                    <div class="headline">KO/TKO</div>
                                    <div class="graph">
                                        <div class="chart">
                                            <div class="bar"
                                                style="--value:<?=pct($res['win_ko'], $res['wins'])?>">
                                            </div>
                                            <div class="val">
                                                <?=$res['win_ko']?>
                                            </div>
                                        </div>
                                        <?=pct($res['win_ko'], $res['wins'])?>
                                    </div>
                                </div>
                                <div class="result">
                                    <div class="headline">Submissions</div>
                                    <div class="graph">
                                        <div class="chart">
                                            <div class="bar"
                                                style="--value:<?=pct($res['win_sub'], $res['wins'])?>">
                                            </div>
                                            <div class="val">
                                                <?=$res['win_sub']?>
                                            </div>
                                        </div>
                                        <?=pct($res['win_sub'], $res['wins'])?>
                                    </div>
                                </div>
                                <div class="result">
                                    <div class="headline">Decisions </div>
                                    <div class="graph">
                                        <div class="chart">
                                            <div class="bar"
                                                style="--value:<?=pct($res['win_dec'], $res['wins'])?>">
                                            </div>
                                            <div class="val">
                                                <?=$res['win_dec']?>
                                            </div>
                                        </div>
                                        <?=pct($res['win_dec'], $res['wins'])?>
                                    </div>
                                </div>
                            </div>
                            <div class="losses_container">
                                <div class="losses">
                                    <div>Losses</div>
                                    <div class="text-end">
                                        <?=$res['losses']?>
                                    </div>
                                </div>
                                <div class="result">
                                    <div class="headline">KO/TKO</div>
                                    <div class="graph">
                                        <div class="chart">
                                            <div class="bar"
                                                style="--value:<?=pct($res['loss_ko'], $res['losses'])?>">
                                            </div>
                                            <div class="val">
                                                <?=$res['loss_ko']?>
                                            </div>
                                        </div>
                                        <?=pct($res['loss_ko'], $res['losses'])?>
                                    </div>
                                </div>
                                <div class="result">
                                    <div class="headline">Submissions</div>
                                    <div class="graph">
                                        <div class="chart">
                                            <div class="bar"
                                                style="--value:<?=pct($res['loss_sub'], $res['losses'])?>">
                                            </div>
                                            <div class="val">
                                                <?=$res['loss_sub']?>
                                            </div>
                                        </div>
                                        <?=pct($res['loss_sub'], $res['losses'])?>
                                    </div>
                                </div>
                                <div class="result">
                                    <div class="headline">Decisions </div>
                                    <div class="graph">
                                        <div class="chart">
                                            <div class="bar"
                                                style="--value:<?=pct($res['loss_dec'], $res['losses'])?>">
                                            </div>
                                            <div class="val">
                                                <?=$res['loss_dec']?>
                                            </div>
                                        </div>
                                        <?=pct($res['loss_dec'], $res['losses'])?>
                                    </div>
                                </div>
                            </div>
                            <div class="draws_container grid-span-2">
                                <div class="draws">
                                    <div>Draws</div>
                                    <div class="text-end">
                                        <?=$res['draws']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 mb-2">
                    <h2 class="headline mb-2 text-primary-900 fs-500">Biography</h2>
                    <?php
$mediaBlocks = array();

foreach ($blocks as $block) {
    if ($block['blockName'] == 'acf/lc-media') {
        $mediaBlocks[] = $block;
        continue;
    }
    echo render_block($block);
}


if (get_field('socials')) {
    $hasNonEmptyValue = false;
    foreach (get_field('socials') as $value) {
        if (!empty($value)) {
            $hasNonEmptyValue = true; // Set the flag to true if any value is non-empty
            break; // Exit the loop early because we found a non-empty value
        }
    }
    if ($hasNonEmptyValue) {
        ?>
                    <div class="follow">
                        <h3 class="">Follow On:</h3>
                        <?php
    $socials = get_field('socials');
        foreach ($socials as $s => $url) {
            if (!empty($url)) {
                ?>
                        <a href="<?=$url?>" target="_blank"
                            class="me-2"><i
                                class='fa-brands fa-<?=$s?>'></i></a>
                        <?php
            }
        }
        ?>
                    </div>
                    <?php
    }
}
?>
                </div>
                <?php
                $results = fight_history(get_the_ID());
if ($results) {
    ?>
                <div class="bg-white p-4 mb-2">
                    <h2 class="headline mb-2 text-primary-900 fs-500">SFX Fight History</h2>
                    <table class="table table-striped table-sm fs-200">
                        <thead>
                            <tr class="headline fs-300">
                                <th>Date</th>
                                <th>Result</th>
                                <th>Opponent</th>
                                <th>Method</th>
                                <th>Time</th>
                                <th>Event</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    foreach ($results as $res) {
        $opponent = $res['fighter_one'] == get_the_ID() ? $res['fighter_two']: $res['fighter_one'];
        $date_string = get_field('event_date', $res['event']);
        $date = DateTime::createFromFormat('Ymd', $date_string);

        ?>
                            <tr>
                                <td>
                                    <?=$date->format('M j, Y')?>
                                </td>
                                <td>
                                    <div
                                        class="headline fs-300 text-white text-center bg--<?=strtolower($res['result'])?>">
                                        <?=$res['result']?>
                                    </div>
                                </td>
                                <td><a href="<?=get_the_permalink($opponent)?>"
                                        class="fw-900"><?= get_the_title($opponent)?></a>
                                </td>
                                <td><?=$res['decision']?>
                                </td>
                                <td><?=$res['duration']?>
                                    (Rd.
                                    <?=$res['round']?>)
                                </td>
                                <td><a href="<?=get_the_permalink($res['event'])?>"
                                        class="fw-900"><?=get_the_title($res['event'])?></a>
                                </td>
                            </tr>
                            <?php
    }

    ?>
                        </tbody>
                    </table>
                </div>
                <?php
}


global $wpdb;
$current_fighter_id = get_the_ID();
$sql = $wpdb->prepare(
    "SELECT p.* FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} m1 ON p.ID = m1.post_id
    WHERE p.post_type = 'events'
    AND (m1.meta_key like 'event_card_%_fighter_%' AND m1.meta_value = %d)",
    $current_fighter_id
);
$events = $wpdb->get_results($sql);
if ($events) {
    ?>

                <div class="bg-white p-4 mb-2">
                    <h2 class="headline mb-2 text-primary-900 fs-500">Upcoming Events</h2>

                    <table class="table table-striped table-sm fs-200">
                        <thead>
                            <tr class="headline fs-300">
                                <th>Date</th>
                                <th>Event Name</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        foreach ($events as $event) {
                            $date_string = get_field('event_date', $event->ID);
                            $date = DateTime::createFromFormat('Ymd', $date_string);
                    
                            ?>
                            <tr
                                href="<?=get_the_permalink($event->ID)?>">
                                <td>
                                    <?=$date->format('M j, Y')?>
                                </td>
                                <td><a class="fw-900"
                                        href="<?=get_the_permalink($event->ID)?>"><?=$event->post_title?></a>
                                </td>
                                <td>
                                    <?=get_field('location', $event->ID)?>
                                </td>
                            </tr>
                            <?php
                        }
    ?>
                        </tbody>
                    </table>
                </div>
                <?php
}


if ($mediaBlocks) {
    ?>
                <div class="bg-white p-4 mb-2">
                    <h2 class="headline mb-2 text-primary-900 fs-500">Media</h2>
                    <?php
                    foreach ($mediaBlocks as $mb) {
                        echo render_block($mb);
                    }
    ?>
                </div>
                <?php
}

$n = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => 'related_fighters',
            'value'   => '"' . get_the_ID() . '"',
            'compare' => 'LIKE',
        ),
    )
));
if ($n->have_posts()) {
    ?>
                <div class="bg-white p-4 mb-2">
                    <h2 class="headline mb-2 text-primary-900 fs-500">News</h2>
                    <div class="news_index__grid">
                        <?php
                    while ($n->have_posts()) {
                        $n->the_post();
                        $categories = get_the_category();
                        ?>
                        <a href="<?=get_the_permalink()?>"
                            class="news_index__card">
                            <img src="<?=get_the_post_thumbnail_url(get_the_ID(), 'large')?>"
                                alt="">
                            <div class="news_index__inner">
                                <h2><?=get_the_title()?></h2>
                                <p><?=wp_trim_words(get_the_content(), 20)?>
                                </p>
                                <div class="news_index__meta">
                                    <?php
                                    if ($categories) {
                                        foreach ($categories as $category) {
                                            ?>
                                    <span
                                        class="news_index__category"><?=esc_html($category->name)?></span>
                                    <?php
                                        }
                                    }
                                    if (get_field('related_fighters', $n->ID)) {
                                        foreach (get_field('related_fighters') as $fighter) {
                                            ?>
                                    <span
                                        class="news_index__category"><?=get_the_title($fighter)?></span>
                                    <?php
                                        }
                                    }
                        ?>
                                    <div class="fs-300">
                                        <?=get_the_date()?>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
    ?>
                    </div>
                </div>
                <?php
                wp_reset_postdata();
}

$terms = get_the_terms(get_the_ID(), 'class');

$cats = get_the_category();
if ($terms && !is_wp_error($terms)) {
    $term_ids = wp_list_pluck($terms, 'term_id');

    $r = new WP_Query(array(
        'post_type' => 'fighters',
        'posts_per_page' => 3,
        'tax_query' => array(
            array(
                'taxonomy' => 'class',
                'field' => 'term_id',
                'terms' => $term_ids,
                'operator' => 'IN'
            ),
        ),
        'post__not_in' => array(get_the_ID())
    ));
    if ($r->have_posts()) {
        ?>
                <section class="fighters bg-white p-4 mb-2">
                    <div class="container-xl">
                        <h2 class="headline mb-2 text-primary-900 fs-500">Related Fighters</h2>
                        <div class="fighters__grid">
                            <?php
        while ($r->have_posts()) {
            $r->the_post();
            ?>
                            <a class="fighters__card"
                                href="<?=get_the_permalink()?>">
                                <img src="<?=get_the_post_thumbnail_url($r->ID, 'large')?>"
                                    alt="<?=get_the_title()?>">
                                <div class="fighters__card_inner">
                                    <div>
                                        <div class="card__name fs-400">
                                            <?=get_the_title()?>
                                        </div>
                                        <?php
                        $nickname = get_field('nickname', get_the_ID()) ?? null;
            if ($nickname) {
                ?>
                                        <div class="card__nickname fs-300">
                                            "<?=get_field('nickname', get_the_ID())?>"
                                        </div>
                                        <?php
            }
            ?>
                                    </div>
                                    <div class="card__weight fs-200">
                                        <?=get_field('weight_class', get_the_ID())->name?>
                                    </div>
                                    <div class="card__results fs-200">
                                        <?=get_wld(get_the_ID())?>
                                    </div>
                                </div>
                            </a>
                            <?php
        }
        ?>
                        </div>
                    </div>
                </section>
                <?php
    }
}
?>
            </div>
            <div class="col-lg-3 order-2">
                <div class="sidebar pb-2">
                    <?php
echo sidebar_latest_news();

echo sidebar_upcoming_events();

echo sidebar_vote_cta();

?>
                    <!--
                Ranking (for class)
-->
                </div>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
?>