<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
$img = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_stylesheet_directory_uri() . '/img/missing-hero.png';
?>
<main id="main" class="event">
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
        <div class="row g-2">
            <div class="col-lg-9 order-1">
                <img src="<?=$img?>" alt="" class="event__image">
                <div class="bg-white p-4 mb-2">
                    <h1 class="event__title"><?=get_the_title()?>
                    </h1>
                    <div>
                        <?=get_field('event_date')?>
                    </div>
                    <div>
                        <?=get_field('location')?>
                    </div>

                    <?php
// $count = estimate_reading_time_in_minutes(get_the_content(), 200, true, true);
// echo $count;

foreach ($blocks as $block) {
    echo render_block($block);
}
?>
                </div>
                <?php

$event_date_obj = DateTime::createFromFormat('Ymd', get_field('event_date'));
$current_date = new DateTime();


if ($event_date_obj < $current_date) {
    $res = get_results_by_event(get_the_ID());
    ?>
                <div class="bg-white p-4 mb-2">
                    <h2 class="headline mb-2 text-primary-900 fs-500">Results</h2>
                    <table class="table table-striped table-sm fs-200">
                        <thead>
                            <tr class="headline fs-300">
                                <th>Fighter One</th>
                                <th>&nbsp;</th>
                                <th>Fighter Two</th>
                                <th>Result</th>
                                <th>Method</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    foreach ($res as $r) {
        // var_dump($r);
        ?>
                            <tr>
                                <td><a href="<?=get_the_permalink($r['fighter_one'])?>"
                                        class="fw-900"><?= get_the_title($r['fighter_one'])?></a>
                                </td>
                                <td>vs</td>
                                <td><a href="<?=get_the_permalink($r['fighter_two'])?>"
                                        class="fw-900"><?= get_the_title($r['fighter_two'])?></a>
                                </td>
                                <td>
                                    <?=$r['result']?>
                                </td>
                                <td>
                                    <?=$r['decision']?>
                                </td>
                                <td>
                                    <?=$r['duration']?>
                                    (Rd.
                                    <?=$r['round']?>)
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

if (have_rows('event_card') && $event_date_obj >= $current_date) {
    ?>
                <div class="bg-white p-4 mb-2">
                    <h2 class="headline mb-2 text-primary-900 fs-500">Event Card</h2>

                    <div class="glide">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                <?php
    while (have_rows('event_card')) {
        the_row();
        $f1 = get_sub_field('fighter_one');
        $f2 = get_sub_field('fighter_two');
        ?>
                                <li class="glide__slide event_cards">
                                    <div class="event_cards__card">
                                        <div class="overlay"></div>
                                        <a class="card__image"
                                            href="<?=get_the_permalink($f1)?>">
                                            <img src="<?=get_the_post_thumbnail_url($f1, 'medium')?>"
                                                alt="<?=get_the_title($f1)?>">
                                        </a>
                                        <div class="card__gap"></div>
                                        <a class="card__image"
                                            href="<?=get_the_permalink($f2)?>">
                                            <img src="<?=get_the_post_thumbnail_url($f2, 'medium')?>"
                                                alt="<?=get_the_title($f2)?>">
                                        </a>
                                        <a class="card__name"
                                            href="<?=get_the_permalink($f1)?>">
                                            <?=get_the_title($f1)?>
                                        </a>
                                        <div class="card__gap">VS</div>
                                        <a class="card__name"
                                            href="<?=get_the_permalink($f2)?>">
                                            <?=get_the_title($f2)?>
                                        </a>
                                        <?php
                        if (get_sub_field('title_fight') != '') {
                            ?>
                                        <div class="card__title grid-span-3">
                                            <?=get_sub_field('title_fight')?>
                                        </div>
                                        <?php
                        }
        ?>
                                        <div class="card__stat">
                                            <?=get_wld($f1)?>
                                        </div>
                                        <div class="card__gap">SFX Record</div>
                                        <div class="card__stat">
                                            <?=get_wld($f2)?>
                                        </div>

                                        <div class="card__stat">
                                            <?=get_field('height', $f1)?>
                                            CM
                                        </div>
                                        <div class="card__gap">Height</div>
                                        <div class="card__stat">
                                            <?=get_field('height', $f2)?>
                                            CM
                                        </div>

                                        <div class="card__stat">
                                            <?=get_field('weight', $f1)?>
                                            KG
                                        </div>
                                        <div class="card__gap">Weight</div>
                                        <div class="card__stat">
                                            <?=get_field('weight', $f2)?>
                                            KG
                                        </div>

                                        <div class="card__stat">
                                            <img class="flag-img"
                                                src="https://flagicons.lipis.dev/flags/4x3/<?=strtolower(get_field('country_code', $f1))?>.svg"
                                                alt="" height="15px" width="20px">
                                            <?=get_field('country', $f1)?>
                                        </div>
                                        <div class="card__gap">Country</div>
                                        <div class="card__stat">
                                            <img class="flag-img"
                                                src="https://flagicons.lipis.dev/flags/4x3/<?=strtolower(get_field('country_code', $f2))?>.svg"
                                                alt="" height="15px" width="20px">
                                            <?=get_field('country', $f2)?>
                                        </div>


                                    </div>
                                </li>
                                <?php

    }
    ?>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-center gap-2" data-glide-el="controls">
                            <button data-glide-dir="<" class="button"><i class="fa-solid fa-angle-left"></i>
                                Prev</button>
                            <button data-glide-dir=">" class="button">Next <i
                                    class="fa-solid fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
                <?php
}

?>

            </div>
            <div class="col-lg-3 order-2">
                <div class="sidebar pb-2">
                    <?php
echo sidebar_latest_news();
echo sidebar_upcoming_events(get_the_ID());
echo sidebar_vote_cta();
?>
                </div>
            </div>
        </div>
    </div>
</main>
<link rel="stylesheet" href="https://unpkg.com/@glidejs/glide@3.2.3/dist/css/glide.core.min.css">
<script src="https://unpkg.com/@glidejs/glide"></script>
<script>
    var glide = new Glide('.glide', {
        type: 'carousel',
        perView: 1.5,
        focusAt: 'center',
        breakpoints: {
            1024: {
                perView: 1
            }
        }
    }).mount()
</script>
<?php
get_footer();
?>