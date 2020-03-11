<!DOCTYPE html>
<html lang="en" class="no-js">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- remove 'no-js' class from the html tag -->
    <script type="text/javascript">document.documentElement.classList.remove('no-js');</script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?php wp_title(); ?></title>
    
    <!-- PRELOADING FONTS -->
    <link rel="preload" href="<?php echo get_template_directory_uri() . '/assets/fonts/icomoon.woff'; ?>" as="font" type="font/woff" crossorigin />
    <link rel="preload" href="<?php echo get_template_directory_uri() . '/assets/fonts/OptimusPrinceps.ttf'; ?>" as="font" type="font/ttf" crossorigin />
    
    <?php wp_head(); ?>
</head>

<body>
    <!-- HEADER SECTION -->
    <!-- CONTACT US STICKY CTA -->
    <a href="#contact-us-section" id="sticky-contact-cta" class="position-fixed text-decoration-none">
        <span class="text-white font-md-12px">CONTACT</span>
        <span class="bg-brown sticky-contact-icon">
            <picture>
                <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/webp/contact-icon.webp" type="image/webp" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contact-icon.png" />
            </picture>
        </span>
    </a>
    
    <!-- BACK TO TOP STICKY BUTTON -->
    <a href="#" id="back-to-top-btn" class="position-fixed text-decoration-none" style="opacity: 0;">
        <span class="icon-chevron-thin-up"></span>
    </a>

    <!-- BODY OVERLAY WHEN MENU IS TRIGGERED -->
    <div id="menu-overlay" style="opacity: 0; z-index: -1;"></div>

    <!-- THE MAIN MENU -->
    <?php get_template_part('section-templates/header-templates/menus', 'main_menu'); ?>

    <?php
    $has_breadcrumb = false;
    if (is_singular('service') || is_singular('attorney') || is_page_template('page-template/FAQ-template.php')) {
        $has_breadcrumb = true;
    }
    get_the_proper_header($has_breadcrumb);
    ?>