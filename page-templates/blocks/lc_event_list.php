<?php
if (get_field('dates') == 'Future') {
    $tense = 'Upcoming';
    $other = 'Past';
    $link = '/past-events/';
    $compare = '>=';
    $order = 'ASC';
} else {
    $tense = 'Previous';
    $other = 'Upcoming';
    $link = '/events/';
    $compare = '<';
    $order = 'DESC';
}
?>
<section class="event_list mb-2">
    <div class="container-xl bg-white py-4">
        <h2 class="headline mb-2 text-primary-900 fs-700"><?=$tense?>
            Events</h2>
        <a href="<?=$link?>" class="fw-900 link-arrow">View
            <?=$other?> Events</a>

        <div class="event_list__grid mt-5">
            <?php
$q = new WP_Query(array(
    'post_type' => 'events',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
          'key' => 'event_date',
          'value' => date('Ymd'),
          'compare' => $compare,
          'type' => 'DATE',
        ),
    ),
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => $order
));
if ($q->have_posts()) {
    while ($q->have_posts()) {
        $q->the_post();
        $date_string = get_field('event_date', get_the_ID());
        $date = DateTime::createFromFormat('Ymd', $date_string);
        $img = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_stylesheet_directory_uri() . '/img/missing-hero.png';
        ?>
            <a href="<?=get_the_permalink(get_the_ID())?>"
                class="event_list__card">
                <img src="<?=$img?>"
                    alt="<?=get_the_title()?>">
                <div class="event_list__meta">
                    <h3><?=get_the_title()?></h3>
                    <div class="event_date">
                        <?=$date->format('M j, Y')?>
                    </div>
                    <div class="event_location">
                        <?=get_field('location', get_the_ID())?>
                    </div>
                </div>
            </a>
            <?php
    }
} else {
    echo 'No ' . $tense . ' events.';
}
?>
        </div>
    </div>
</section>