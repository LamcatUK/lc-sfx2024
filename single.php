<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
$img = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>
<main id="main" class="blog">
    <?php
    $content = get_the_content();
$blocks = parse_blocks($content);
$sidebar = array();
$after;
?>
    <section class="breadcrumbs container-xl">
        <?php
if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<div id="breadcrumbs" class="mb-2">', '</div>');
}
?>
    </section>
    <div class="container-xl">
        <div class="row g-2">
            <div class="col-lg-9 order-1">
                <img src="<?=$img?>" alt="" class="blog__image">
                <div class="blog__content bg-white p-4 mb-2">
                    <h1 class="blog__title"><?=get_the_title()?></h1>
                    <div class="news_index__meta mb-4">
                        <?php

$categories = get_the_category();

if ($categories) {
    foreach ($categories as $category) {
        ?>
                        <span
                            class="news_index__category"><?=esc_html($category->name)?></span>
                        <?php
    }
}


if (get_field('related_fighters')) {
    foreach (get_field('related_fighters') as $fighter) {
        ?>
                        <a href="<?=get_the_permalink($fighter)?>"
                            class="news_index__category"><?=get_the_title($fighter)?></a>
                        <?php
    }
}

?>
                        <div class="fs-300"><?=get_the_date()?></div>
                    </div>
                    <?php
// $count = estimate_reading_time_in_minutes(get_the_content(), 200, true, true);
// echo $count;

foreach ($blocks as $block) {
    if ($block['blockName'] == 'core/heading') {
        if (!array_key_exists('level', $block['attrs'])) {
            $heading = strip_tags($block['innerHTML']);
            $id = acf_slugify($heading);
            echo '<a id="' . $id . '" class="anchor"></a>';
            $sidebar[$heading] = $id;
        }
    }
    echo render_block($block);
}
?>
                </div>
            </div>
            <div class="col-lg-3 order-2">
                <div class="sidebar pb-2">
                    <?php
echo sidebar_latest_news(get_the_ID());
echo sidebar_upcoming_events();
echo sidebar_vote_cta();
?>
                </div>
            </div>
        </div>
    </div>
    <?php
            $cats = get_the_category();
$ids = wp_list_pluck($cats, 'term_id');
$r = new WP_Query(array(
    'category__in' => $ids,
    'posts_per_page' => 3,
    'post__not_in' => array(get_the_ID())
));
if ($r->have_posts()) {
    ?>
    <section class="related_news pb-2">
        <div class="container-xl">
            <div class="bg-white p-4 mb-2">
                <h2>Related News</h2>
                <div class="related_news__grid">
                    <?php
while ($r->have_posts()) {
    $r->the_post();
    ?>
                    <a class="related_news__card"
                        href="<?=get_the_permalink()?>">
                        <img src="<?=get_the_post_thumbnail_url(get_the_ID(), 'large')?>"
                            alt="">
                        <h3><?=get_the_title()?></h3>
                    </a>
                    <?php
}
    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
</main>
<?php
get_footer();
?>