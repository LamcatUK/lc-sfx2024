<section class="media">
    <?php
    while(have_rows('media')) {
        the_row();
        if (get_sub_field('type') == 'Image') {
            $imgPreview = wp_get_attachment_image_url(get_sub_field('image'), 'large');
            $imgFull = wp_get_attachment_image_url(get_sub_field('image'), 'full');
            $overlay = 'overlay--img';
        } elseif (get_sub_field('type') == 'Video') {
            $imgPreview = 'https://i.ytimg.com/vi/' . get_sub_field('video_id') . '/hqdefault.jpg';
            $imgFull = 'https://www.youtube.com/watch?v=' . get_sub_field('video_id');
            $overlay = 'overlay--vid';
        }
        ?>
    <a class="media__card" href="<?=$imgFull?>" data-fancybox
        data-caption="<?=get_sub_field('title')?>">
        <div class="overlay <?=$overlay?>"></div>
        <img src="<?=$imgPreview?>"
            alt="<?=get_sub_field('title')?>">
        <div class="media__title">
            <?=get_sub_field('title')?>
        </div>
    </a>
    <?php
    }
    ?>
</section>
<?php
add_action('wp_footer', function () {
    ?>
<link rel="stylesheet"
    href="<?=get_stylesheet_directory_uri()?>/css/fancybox.css">
<script src="<?=get_stylesheet_directory_uri()?>/js/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>
<?php
})
    ?>