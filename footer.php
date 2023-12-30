<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package lc-sfx2024
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

?>
<footer class="footer pt-5">
    <div class="container-xl">
        <div class="row pb-4">
            <div class="col-md-6 col-lg-3 mb-3">
                <img src="<?=get_stylesheet_directory_uri()?>/img/sfx-logo.svg"
                    alt="">
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <strong>Contact Us</strong>
                <ul class="fa-ul">
                    <li><span class="fa-li"><i class="fa-solid fa-envelope"></i></span>
                        <?=do_shortcode('[contact_email]')?>
                    </li>
                </ul>
                <strong>Connect</strong>
                <div class="social-icons">
                    <?=do_shortcode('[social_icons]')?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-2">
                <?php wp_nav_menu(array('theme_location' => 'footer_menu1')); ?>
            </div>
            <div class="col-sm-6 col-lg-3 mb-2">
                <?php wp_nav_menu(array('theme_location' => 'footer_menu2')); ?>
            </div>
        </div>
    </div>
</footer>
<div class="colophon">
    <div class="container-xl d-md-flex justify-content-between">
        <div>&copy; <?=date('Y')?> SFX
            Championships.</div>
        <div>
            <a href="/privacy-policy/">Privacy</a> &amp; <a href="/cookie-policy/">Cookie Policy</a>
            |
            <span>Site by <a href="https://www.lamcat.co.uk/">Lamcat</a></span>
        </div>
    </div>
</div>
<?php wp_footer();
if (get_field('gtm_property', 'options')) {
    ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe
        src="https://www.googletagmanager.com/ns.html?id=<?=get_field('gtm_property', 'options')?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
}
?>
<script>
    function jumpTo(anchor_id) {
        var url = location.href; //Saving URL without hash.
        location.href = "#" + anchor_id; //Navigate to the target element.
        history.replaceState(null, null, url); //method modifies the current history entry.
    }

    function scrollSmoothTo(elementId) {
        var element = document.getElementById(elementId);
        element.scrollIntoView({
            block: 'start',
            behavior: 'smooth'
        });
    }
</script>
</body>

</html>