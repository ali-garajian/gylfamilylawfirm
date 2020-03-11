<?php
get_header();
?>
<div id="blog-articles-section">
    <div id="article-thumbnails" class="row mx-0">

        <?php
        while (have_posts()) {
            the_post();
            
            $image[] = '';
            $image_url = null;
            if (has_post_thumbnail(get_the_ID())) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium');
                $image_url = $image[0];
            }else{
                $image_url = '/wp-content/uploads/2019/10/individual-income-tax-and-divorce-1.jpg';
            }
            ?>
            
            <div id="article-<?php the_ID(); ?>" class="article col-12 col-lg-4 position-relative text-center text-lg-left" style="background-image: url(<?php echo $image_url; ?>)">
                <div class="article-info position-absolute" onclick='window.open("<?php the_permalink(); ?>");'>
                    <div class="article-publish-date font-md-12px font-sm-18px font-699-18px font-575-18px text-lightgray mb-1  ">
                        <?php echo get_the_date('l, F j, Y'); ?>
                    </div>
                    <div class="article-title font-md-18px font-sm-27px font-699-27px font-575-27px mb-4">
                        <?php the_title(); ?>
                    </div>
                    <div class="article-excerpt font-md-18px font-sm-27px font-699-27px font-575-27px mb-4 pb-4">
                        <?php the_excerpt(); ?>
                        <span class="d-inline-block font-weight-bold font-md-18px font-sm-27px font-699-27px font-575-27px text-brown">READ
                            MORE</span>
                    </div>
                </div>
                <div class="article-meta-info text-lightgray position-absolute font-md-18px font-sm-27px font-699-27px font-575-27px pb-4">
                    <span class="mr-1 icon-eye"></span><span class="article-views-count mr-4"><?php the_views(); ?></span>
                    <!--<span class="mr-1 icon-like"></span><span class="article-likes-count mr-4">31</span>-->
                    <span class="mr-1 icon-bubble2"></span><span class="article-comments-count mr-4"><?php echo get_comments_number(); ?></span>
                    <span class="mr-1 icon-share-2 position-relative">
                        <span class="social-share-container position-absolute">
                            <span class="icon-facebook2 social-share-btn" title="Share on Facebook" onclick="NavigateToSocialMedia('https://www.facebook.com/sharer/sharer.php?', 'u=', '<?php the_permalink(); ?>', '&t=', '<?php the_title(); ?>');"></span>
                            <span class="icon-twitter social-share-btn" title="Tweet" onclick="NavigateToSocialMedia('https://twitter.com/intent/tweet?', 'text=%20Check%20up%20this%20awesome%20content', ': <?php the_title(); ?>', ':%20', '<?php the_permalink(); ?>');"></span>
                            <span class="icon-linkedin social-share-btn" title="Share on LinkedIn" onclick="NavigateToSocialMedia('http://www.linkedin.com/shareArticle?mini=true&', 'url=', '<?php the_permalink(); ?>', '&title=', '<?php the_title(); ?>');"></span>
                        </span>
                    </span>
                </div>
            </div>
        <?php
        }
        wp_reset_query();
        ?>
    </div>

    <!-- BLOG SECTION PAGINATION -->
    <nav class="pagenavi-container d-flex justify-content-center align-items-center">
        <?php wp_pagenavi(); ?>
    </nav>
</div>

<?php
wp_reset_query();

get_footer();

?>