<?php

$defer_scripts = [];

function register_styles_and_scripts()
{
    global $defer_scripts;
    
    // COMMON CSS FILES
    wp_enqueue_style('icomoon-styles', get_template_directory_uri() . "/assets/css/icomoon-style.css");
    // wp_enqueue_style('bootstrap-v4.3.1', get_template_directory_uri() . "/assets/css/bootstrap-v4.3.1.css");
    wp_enqueue_style('bootstrap-used-css', get_template_directory_uri() . "/assets/css/bootstrap-used-css.css");
    wp_enqueue_style('fonts-css', get_template_directory_uri() . "/assets/css/fonts.css");
    wp_enqueue_style('colors-css', get_template_directory_uri() . "/assets/css/colors.css");
    wp_enqueue_style('common-css', get_template_directory_uri() . "/assets/css/common.css");
    wp_enqueue_script('jquery');
    // wp_enqueue_script('jquery-min-js', get_template_directory_uri() . "/assets/lib/JQuery-min-v3.4.1.js", false, true);


    // HANDLING RESPONSIVE CSS
    if(is_front_page()) {
        wp_enqueue_style('responsive_homepage', get_template_directory_uri() . "/assets/css/responsive-homepage.css");
    } else {
        wp_enqueue_style('responsive', get_template_directory_uri() . "/assets/css/responsive.css");
    }

 // ADDING SLICK TO THE PAGES THAT USE IT
    if (!(is_page_template('page-template/contact-template.php') || is_home('blog')) || (is_single() && !is_singlular('service') && !is_singluar('attorney'))) {
        wp_enqueue_style('slick-theme-css', get_template_directory_uri() . "/assets/css/manually_minified_css_files/slick-theme-min.css");
        wp_enqueue_style('slick-css', get_template_directory_uri() . "/assets/css/manually_minified_css_files/slick-min.css");
        wp_enqueue_script('slick-min-js', get_template_directory_uri() . "/assets/lib/slick-1.8.1/slick.min.js", '', array('jquery'), true);
        
        array_push($defer_scripts, 'slick-min-js');
    }

    // COMMON JS FILES
    wp_enqueue_script('gyl-common-js', get_template_directory_uri() . "/assets/js/gyl_common.js", '', false, true);
    wp_enqueue_script('modernizr-js', get_template_directory_uri() . "/assets/lib/modernizr-custom-webp.js", '', false, true);

    array_push($defer_scripts, 'gyl-common-js');

    // LOADING STYLESHEETS AND SCRIPTS PAGE-BASED
    if (is_front_page() || is_page_template('page-template/our-attorneys.php')) {
        wp_enqueue_style('homepage_style', get_template_directory_uri() . "/assets/css/manually_minified_css_files/homepage-styles-min.css");
        wp_enqueue_script('homepage_script', get_template_directory_uri() . "/assets/js/homepage-custom.js", '', false, true);
        
        array_push($defer_scripts, 'homepage_script');
    } else if (is_singular('attorney')) {
        wp_enqueue_style('aboutpage-css', get_template_directory_uri() . "/assets/css/aboutpage-styles.css");
    } else if (is_page_template('page-template/FAQ-template.php')) {
        wp_enqueue_script('accordion-js', get_template_directory_uri() . "/assets/js/accordion.js", '', false, true);
    } else if (is_singular('service')) {
        wp_enqueue_script('accordion-js', get_template_directory_uri() . "/assets/js/accordion.js", '', false, true);
        wp_enqueue_style('services-css', get_template_directory_uri() . "/assets/css/servicespage-styles.css");
    } else if (is_single()) {
        wp_enqueue_style('single-css', get_template_directory_uri() . "/assets/css/blog-styles.css");
    } else if (is_page_template('page-template/contact-template.php')) {
        wp_enqueue_style('contact-css', get_template_directory_uri() . "/assets/css/contact-styles.css");
    } else if (is_home('blog') || is_search()) {
        wp_enqueue_style('pagenavi-css', get_template_directory_uri() . "/assets/css/pagenavi-css.css");
    }


   
}
add_action('wp_enqueue_scripts', 'register_styles_and_scripts');

// DEFER PARSING JAVASCRIPT FILES
function defer_scripts($tag, $handle, $src) {
    global $defer_scripts;
    
    if(in_array($handle, $defer_scripts)) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'defer_scripts', 10, 3);

//ACTIVATING SUPPORT FOR FEATURED IMAGES
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}

// ACTIVATING SUPPORT FOR MENUS
function register_my_menus()
{
    register_nav_menus(
        array(
            'main_menu' => 'Main Menu'
        )
    );
}
add_action('init', 'register_my_menus');

//TEMPALTE FUNCTIONS
function get_the_proper_header($has_breadcrumb = false)
{
    if (is_front_page()) {
        get_template_part('section-templates/header-templates/header', 'home');
    } else {
        set_query_var('has_breadcrumb', $has_breadcrumb);
        get_template_part('section-templates/header-templates/header', 'page');
    }
}

function custom_excerpt_length($length)
{
    return 30;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);


// CREATING NEW POST TYPES
// POST TYPE : Attorney
function create_post_type_attorney()
{
    $attorney_labels = array(
        'name' => 'Attorneys',
        'singular_name' => 'Attorney',
        'all_items' => 'All Attorneys',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Attorney Item',
        'edit_item' => 'Edit Attorney Item',
        'new_item' => 'New Attorney item',
        'view_item' => 'View Attorney item',
        'search_items' => 'Search in Attorney',
        'not_found' => 'No Attorney Item Found',
        'not_found_in_trash' => 'No Attorney item found in trash',
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $attorney_labels,
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'query_var' => true,
        'capability_type' => 'page',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'hierarchical' => false,
        'rewrite' => array('slug' => 'our-attorneys', 'with_front' => false),
        'has_archive' => 'true'
    );
    register_post_type('attorney', $args);
    flush_rewrite_rules();
}
add_action('init', 'create_post_type_attorney');

// POST TYPE : Service
function create_post_type_service()
{
    $service_labels = array(
        'name' => 'Service',
        'singular_name' => 'Service',
        'all_items' => 'All Services',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Service Item',
        'edit_item' => 'Edit Service Item',
        'new_item' => 'New Service item',
        'view_item' => 'View Service item',
        'search_items' => 'Search in Service',
        'not_found' => 'No Service Item Found',
        'not_found_in_trash' => 'No Service item found in trash',
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $service_labels,
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
        'query_var' => true,
        'capability_type' => 'page',
        'hierarchical' => true,
        'supports' => array('title', 'author', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'rewrite' => array('slug' => 'services', 'has_front' => false),
        'has_archive' => 'true'
    );
    register_post_type('service', $args);
    flush_rewrite_rules();
}
add_action('init', 'create_post_type_service');

// POST TYPE : Testimonial
function create_post_type_testimonial()
{
    $testimonial_labels = array(
        'name' => 'Testimonial',
        'singular_name' => 'Testimonial',
        'all_items' => 'All Testimonials',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Testimonial Item',
        'edit_item' => 'Edit Testimonial Item',
        'new_item' => 'New Testimonial item',
        'view_item' => 'View Testimonial item',
        'search_items' => 'Search in Testimonial',
        'not_found' => 'No Testimonial Item Found',
        'not_found_in_trash' => 'No Testimonial item found in trash',
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $testimonial_labels,
        'public' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-quote',
        'query_var' => true,
        'capability_type' => 'page',
        'supports' => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'rewrite' => array('slug' => 'testimonials', 'with_front' => false),
        'has_archive' => 'true'
    );
    register_post_type('testimonial', $args);
    flush_rewrite_rules();
}
add_action('init', 'create_post_type_testimonial');


// CREATING WIDGETS
function create_my_widgets()
{
    $args_footer_col_1 = array(
        'name' => 'Footer Column 1',
        'id' => 'gyl_footer_col_1',
        'description' => "What is put here will be displayed in the first column of theme's footer (the footer is only displayed for desktop users)",
        'before_title' => '<h3 class="text-brown font-md-18px">',
        'after_title' => '</h3><div class="text-darkgray-2 font-md-13px" style="padding-right: 15px;">',
        'before_widget' => '<div>',
        'after_widget' => '</div></div>'
    );
    register_sidebar($args_footer_col_1);

    $args_footer_col_2 = array(
        'name' => 'Footer Column 2',
        'id' => 'gyl_footer_col_2',
        'description' => "What is put here will be displayed in the second column of theme's footer (the footer is only displayed for desktop users)",
        'before_title' => '<h3 class="text-brown font-md-18px">',
        'after_title' => '</h3><div class="font-md-14px">',
        'before_widget' => '<div>',
        'after_widget' => '</div></div>'
    );
    register_sidebar($args_footer_col_2);

    $args_footer_col_3 = array(
        'name' => 'Footer Column 3',
        'id' => 'gyl_footer_col_3',
        'description' => "What is put here will be displayed in the third column of theme's footer (the footer is only displayed for desktop users)",
        'before_title' => '<h3 class="text-brown font-md-18px">',
        'after_title' => '</h3><div class="font-md-14px">',
        'before_widget' => '<div>',
        'after_widget' => '</div></div>'
    );
    register_sidebar($args_footer_col_3);

    $args_footer_col_4 = array(
        'name' => 'Footer Column 4',
        'id' => 'gyl_footer_col_4',
        'description' => "What is put here will be displayed in the fourth column of theme's footer (the footer is only displayed for desktop users)",
        'before_title' => '<h3 class="text-brown font-md-18px">',
        'after_title' => '</h3><div class="font-md-14px">',
        'before_widget' => '<div>',
        'after_widget' => '</div></div>'
    );
    register_sidebar($args_footer_col_4);

    $args_footer_copyright = array(
        'name' => 'Footer Copyright Section',
        'id' => 'gyl_footer_copyright',
        'description' => "What is put here will be displayed in the copyright section of the footer",
        'before_widget' => '',
        'after_widget' => ''
    );
    register_sidebar($args_footer_copyright);

    $args_sidebar_articles_archives = array(
        'name' => 'Sidebar Articles Archives Section',
        'id' => 'gyl_sidebar_articles_archives',
        'description' => "The articles archive section that will sort the articles based on the month they were published",
        'before_title' => '<h2 class="text-brown font-md-15-xl-30" style="margin-bottom: 30px;">',
        'after_title' => '</h2>',
        'before_widget' => '<div id="archives-container" class="bg-superlightgray">',
        'after_widget' => '</div>'
    );
    register_sidebar($args_sidebar_articles_archives);
}
add_action('init', 'create_my_widgets');


// CREATING CUSTOM TAXONOMIES
// TAXONOMY TYPE: Services
function create_taxonomy_type_services()
{
    $labels = array(
        'name' => 'Services',
        'singular_name' => 'Service',
        'search_items' => 'Search Services',
        'all_items' => 'All Services',
        'parent_item' => 'Parent Service',
        'parent_item_colon' => 'Parent Service:',
        'edit_item' => 'Edit Service',
        'update_item' => 'Update Service',
        'add_new_item' => 'Add New Service',
        'new_item_name' => 'New Service Name',
        'menu_name' => 'Service Types',
        'not_found' => 'No Service Type Found',
        'not_found_in_trash' => 'No Service Type found in trash',

    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'services')
    );

    register_taxonomy('services', array('service'), $args);
}
add_action('init', 'create_taxonomy_type_services');


// CUSTOMIZING DASHBOARD PANEL AND ADDING THEME OPTIONS
// require_once(get_template_directory() . "/dashboard-templates/admin.php");

// comment form fields re-defined:
add_filter('comment_form_default_fields', 'mo_comment_fields_custom_html');
function mo_comment_fields_custom_html($fields)
{
    // first unset the existing fields:
    unset($fields['comment']);
    unset($fields['author']);
    unset($fields['email']);
    unset($fields['url']);
    // then re-define them as needed:
    $fields['author'] = '<div class="form-group">
        <input id="author" name="author" type="text" placeholder="Alan Hansen" class="form-control font-md-14px font-sm-21px font-699-21px font-575-21px mr-lg-2 mb-3 mb-lg-0" required />
    </div>';
    $fields['email'] = '<div class="form-group">
        <input id="email" name="email" type="email" placeholder="Email Address" class="form-control font-md-14px font-sm-21px font-699-21px font-575-21px mr-lg-2 mb-3 mb-lg-0" required />
    </div>';

    $fields['comment_field'] = '<div class="form-group">
        <textarea id="comment" name="comment" placeholder="Your Comment" class="form-control font-md-14px font-sm-21px font-699-21px font-575-21px" aria-required="true" required="required"></textarea>
    </div>';

    return $fields;
}
// remove default comment form so it won't appear twice
add_filter('comment_form_defaults', 'mo_remove_default_comment_field', 10, 1);
function mo_remove_default_comment_field($defaults)
{
    if (isset($defaults['comment_field'])) {
        $defaults['comment_field'] = '';
    }
    return $defaults;
}



//SIDEBAR MENU HANDLING USING EXTERNAL CODE FROM https://gist.github.com/vwasteels/874f7d08726076bdc580
function findStartPoint($menu, $currentUrl, $parentNode = false) {
    foreach($menu as $menu_item) {
        if(str_replace('/service/', '', $menu_item->url) == $currentUrl) {
            return $parentNode; 
        } else {
            $returnValue = findStartPoint($menu_item->children, $currentUrl, $menu_item);       
            if($returnValue != null) {
                return $returnValue;
            }
        }
    }
}

function completeMenuTemplate($menu, $menu_template, $counter) {
    foreach($menu as $menu_item) {
        if(!empty($menu_item->children)) {
           
            $menu_template .= '<div class="accordion" id="menu-container-' . $counter . '" role="tablist">';
            $menu_template .= '<div class="card">';
            $menu_template .= '<div class="card-header single-sidebar-card-header" role="tab" id="menu-header-' . $counter . '">';
            $menu_template .= '<h5 class="mb-0">';
            $menu_template .= '<a class="single-sidebar-link" data-toggle="collapse" data-parent="#menu-container-' . $counter . '" href="#menu-body-' . $counter . '" aria-expanded="true">' . $menu_item->name . '</a>';
            $menu_template .= '</h5>';
            $menu_template .= '</div>';
            $menu_template .= '<div id="menu-body-' . $counter . '" class="collapse in" role="tabpanel">';
            $menu_template .= '<div class="card-body single-sidebar-card-body">';
            $returnValue = completeMenuTemplate($menu_item->children, '', $counter++);
            $menu_template .= $returnValue;
            $menu_template .= ' </div>';
            $menu_template .= ' </div>';
            $menu_template .= ' </div>';
            $menu_template .= ' </div>';
            
        } else {
            $menu_template .= '<h5 class="mb-0">';
            $menu_template .= '<a class="single-sidebar-link" href="'.  get_home_url() . '/' . str_replace('/page/', '', str_replace('/service/', '', $menu_item->url)) .'">' . $menu_item->name . '</a>';
            $menu_template .= '</h5>';
        }
        $counter++;
    }
    // var_dump($menu_template);
    return $menu_template;
}


/**
 * Get Menu Items From Location
 *
 * @param $location : location slug given as key in register_nav_menus
 */

function getMenuItemsFromLocation($location) {
	$theme_locations = get_nav_menu_locations();
	$menu_obj = get_term( $theme_locations[$location], 'nav_menu' );
	return is_wp_error($menu_obj) ? [] : getMenuItemsForParent($menu_obj->slug, 0);
}


/**
 * Get Menu Items For Parent
 * 
 * @param $menuSlug : menu slug for the CMS entry (not the key in register_nav_menus)
 * @param $parentId
 * @return array of items formatted as objects with : name / url / children (fetched recursively)
 */

function getMenuItemsForParent($menuSlug, $parentId) {
	$args = [
			'post_type' => 'nav_menu_item',
			'posts_per_page' => -1,
			'meta_key' => '_menu_item_menu_item_parent',
			'meta_value' => $parentId,
			'tax_query' => [
				[
					'taxonomy' => 'nav_menu',
					'field' => 'slug',
					'terms' => [$menuSlug]
				]
			],
			'order' => 'ASC',
			'orderby' => 'menu_order',
		];
	$tmpItems = query_posts($args);

// 		 print('<pre>'.print_r($tmpItems,true).'</pre>');
	$items = [];
	  
	
	foreach ( $tmpItems as $tmpItem ) {
		$item = new stdClass;
		$type = get_post_meta($tmpItem->ID, '_menu_item_type', true);
		
		switch($type):

			case 'post_type':
				$postId = get_post_meta($tmpItem->ID, '_menu_item_object_id', true);
				$post = get_post($postId);
				$item->name = $post->post_title;
				
				// check if the item has a parent and if so add it to the url
				$parentId = $post->post_parent;
				$parentSlug = $parentId != 0 ? get_post($parentId)->post_name : '';
				// echo '<pre>' , var_dump('parent: ' . $parentSlug) , '</pre>';
				
				if(empty($parentSlug)) $item->url = '/'.$post->post_type.'/'.$post->post_name;
				else $item->url = $parentSlug.'/'.$post->post_name;
				break;

			case 'custom':
				$item->name = $tmpItem->post_title;
				$item->url = get_post_meta($tmpItem->ID, '_menu_item_url', true);
				
			// note : this has to be completed with every '_menu_item_type' (could also come from plugin)

		endswitch;
		$item->children = getMenuItemsForParent($menuSlug, $tmpItem->ID);
		$items[] = $item;
	}

	return $items;
}


// LIMIT THE NUBMER OF CHARACTERS ALLOWED FOR TESTIMONIALS
add_action( 'admin_print_footer_scripts', 'check_title_length' );
function check_title_length() {
  global $post_type;
  if ('testimonial' != $post_type) 
    return;
  ?>
  
    <script id="charcounter" type="text/javascript">
    document.addEventListener('readystatechange', () => {
        if(document.readyState === 'complete') {
			var editor_char_limit = 400;
            
            $('.mce-statusbar').append('<span class="word-count-message"></span>');
            document.querySelector('.mce-statusbar').classList.add('visible');

            var iframe = document.getElementById('content_ifr');
			iframe.contentWindow.document.getElementById('tinymce').addEventListener('keyup', function() {
				// Strip HTML tags, WordPress shortcodes and white space
				editor_content = this.innerText.replace(/(<[a-zA-Z\/][^<>]*>|\[([^\]]+)\])|(\s+)/ig,''); 

				if ( editor_content.length > editor_char_limit ) {
					$('.word-count-message').addClass('toomanychars');
					$('.word-count-message').html('maximum characters allowed : 600');
					document.getElementById('publish').setAttribute('disabled', 'disabled');
				} else {
					$('.word-count-message').removeClass('toomanychars');
					$('.word-count-message').html('');
					document.getElementById('publish').removeAttribute('disabled');
				}
			});
			if(iframe.contentWindow.document.getElementById('tinymce').innerText.length > editor_char_limit) {
			    $('.word-count-message').addClass('toomanychars');
				$('.word-count-message').html('maximum characters allowed : 600');
				document.getElementById('publish').setAttribute('disabled', 'disabled');
			}
        }
    })
		
	</script>

	<style type="text/css">
	    .visible { visibility: visible !important };
		.word-count-message { font-size:1.1em; display:none; float:right; color:#fff; font-weight:bold; margin-top:2px; padding: 5px;}
		.toomanychars  { background:red; color: white; }
	</style>
  
  <?php
}


// disable text editor on homepage
add_action('admin_head', 'remove_content_editor');
function remove_content_editor()
{
    if((int)get_option('page_on_front') == get_the_ID())
    {
        remove_post_type_support('page', 'editor');
    }
}

// remove the divorce process steps section form all pages except homepage
add_action( 'admin_print_footer_scripts', 'remove_divorce_process_settings' );
function remove_divorce_process_settings() {
  global $post;
  if ('home' == $post->post_name) 
    return;
  ?>
  
    <script type="text/javascript">
    
    document.addEventListener('readystatechange', () => {
        if(document.readyState === 'complete') {
	        let section = document.getElementById('cfs_input_6601');
	        section.parentElement.removeChild(section);
	        
	        section = document.getElementById('cfs_input_6623');
	        section.parentElement.removeChild(section);
        }
    })
		
	</script>
	
  <?php
}


// hook into wp-head to paste css code into the head element that is responsible for showing the footer team photo
add_action('wp_head', 'render_css_for_team_photo');
function render_css_for_team_photo() {
    
    $team_photo_css = '<style>.no-webp #team-photo-container,.no-js #team-photo-container {background-image: url(' . get_field('team_photo_non-webp', get_page_by_path('home')->ID) . ')}';
    $team_photo_css .= '.webp #team-photo-container {background-image: url(' . get_field('team_photo_webp', get_page_by_path('home')->ID) . ');}</style>';    
                        
    
    echo $team_photo_css;
}



