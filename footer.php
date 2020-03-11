<?php
//determine if the current page is the blog or contact page and if so don't display the recent articles section
$display_recent_articles = true;
if (is_home() || is_page_template('page-template/contact-template.php') || is_single() || is_date() || is_page('sitemap') || is_page('privacy-policy') || is_404()) {
    $display_recent_articles = false;
}

?>

<footer>
    <!-- RECENT ARTICLES SECTION -->
    <?php
    if ($display_recent_articles) {
        get_template_part('section-templates/footer-templates/footer', 'blogroll');
    }
    ?>

    <!-- CONTACT US SECTION -->
    <?php get_template_part('section-templates/footer-templates/footer', 'contact_us_section'); ?>

    <!-- TEAM PHOTO SECTION -->
    <div id="team-photo-section" class="w-100 overflow-hidden">
        <div id="team-photo-container" class="w-100 h-100 <?php the_field('team_photo_class_name', get_page_by_path('home')->ID); ?>"></div>
    </div>

    <!-- BOTTOM FOOTER SECTION -->
    <?php get_template_part('section-templates/footer-templates/footer', 'bottom_section'); ?>

    <!--<?php if(is_front_page()) { ?>-->
    <!--    <script defer="defer" type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/request_css.js"></script>-->
    <!--<?php } ?>-->
    
    <?php wp_footer(); ?>

</footer>

</body>

    
</html>