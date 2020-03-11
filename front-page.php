<?php

get_header();
?>
<main>
    <?php

    // //REVIEWS SECTION 
    get_template_part('section-templates/homepage-templates/reviews');

    // // LAWYER TALKS SECTION 
    get_template_part('section-templates/homepage-templates/lawyer-talks');

    // // TESTIMONIAL SECTION 
    get_template_part('section-templates/homepage-templates/testimonials');

    // // GET HELP SECTION 
    get_template_part('section-templates/homepage-templates/get-help');

    // // MEET OUR LAWYERS SECTION 
    get_template_part('section-templates/homepage-templates/meet-our-lawyers');
        
    // // TAB SECTION - DESKTOP VIEW 
    get_template_part('section-templates/homepage-templates/tab-section-desktop');

    // // TAB SECTION - MOBILE VIEW 
    get_template_part('section-templates/homepage-templates/tab-section-mobile');

    // // HOW TO PREPARE SECTION 
    get_template_part('section-templates/homepage-templates/how-to-prepare');

    // // PROCESS SECTION 
    get_template_part('section-templates/homepage-templates/process');

    ?>

</main>


<?php
get_footer();
?>