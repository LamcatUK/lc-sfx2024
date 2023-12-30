<?php
$img = wp_get_attachment_image_url(get_field('background'), 'full') ?? null;
$title = get_field('title') ?: get_the_title();
?>
<section class="short_hero" style="background-image:url(<?=$img?>);">
    <div class="container-xl h-100 d-flex align-items-center">
        <h1><?=$title?></h1>
    </div>
</section>