<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

$page_for_posts = get_option('page_for_posts');

get_header();
?>
<main id="main">
    <?php
$img = get_the_post_thumbnail_url($page_for_posts, 'full') ?? null;
?>
    <section class="short_hero"
        style="background-image:url(<?=$img?>);">
        <div class="container-xl h-100 d-flex align-items-center">
            <h1>SFX <span>News</span></h1>
        </div>
    </section>
    <section class="news_index pb-4">
        <div class="container-xl bg-white py-4">
            <div class="news_index__grid">
                <?php
    $style = 'news_index__card--first';
while (have_posts()) {
    the_post();
    $categories = get_the_category();
    ?>
                <a href="<?=get_the_permalink()?>"
                    class="news_index__card <?=$style?>">
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
    if (get_field('related_fighters')) {
        foreach (get_field('related_fighters') as $fighter) {
            ?>
                            <span
                                class="news_index__category"><?=get_the_title($fighter)?></span>
                            <?php
        }
    }
    ?>
                            <div class="fs-300"><?=get_the_date()?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
    $style = '';
}
?>
            </div>
        </div>
    </section>
</main>
<?php

get_footer();
?>