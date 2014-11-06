<?php

/**
 * Clean up the_excerpt()
 */
function roots_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . '</a>';
}
add_filter('excerpt_more', 'roots_excerpt_more');

function custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Manage output of wp_title()
 */
function roots_wp_title($title) {
  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  return $title;
}
add_filter('wp_title', 'roots_wp_title', 10);

/**
 * Filtering the Wrapper: Custom Post Types
 */
function roots_wrap_base_cpts($templates) {
    $cpt = get_post_type();
    if ($cpt) {
       array_unshift($templates, 'base-' . $cpt . '.php');
    }
    return $templates;
}

add_filter('roots_wrap_base', 'roots_wrap_base_cpts');

/**
 * Search Filter
 */
function search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
      $query->set('post_type', array('page', 'post', 'case_study', 'job_opportunity'));
    }
  }
}

add_action('pre_get_posts','search_filter');

/**
 * Search Filter
 */
function my_post_queries( $query ) {

  $home_posts = function_exists('get_field') ? get_field('posts_on_blog_page', 'options') : '';
  $category_posts = function_exists('get_field') ? get_field('posts_on_category_page', 'options') : '';

  // do not alter the query on wp-admin pages and only alter it if it's the main query
  if (!is_admin() && $query->is_main_query()){

    // alter the query for the home and category pages
    if(is_home()){
      $query->set('posts_per_page', $home_posts ? $home_posts : 4);
    }

    if(is_category()){
      $query->set('posts_per_page', $category_posts ? $category_posts : 4);
    }

  }
}

add_action( 'pre_get_posts', 'my_post_queries' );

/**
 * Copyright shortcode
 */
function copyright_func($atts, $content = null) {
    $atts = shortcode_atts(array(), $atts);

    $output = '';

    $copyright = function_exists('get_field') ? get_field('copyright', 'options') : '';

    if($copyright){
      $output .= 'Copyright &copy; ' . date('Y') . ' ' . $copyright;
    }

    return $output;
}

add_shortcode('copyright', 'copyright_func');



/**
 * Slider shortcode
 */
function slider_func($atts, $content = null) {
  $atts = shortcode_atts(array(
    'timeout' => '0'
  ), $atts);

  $output = '';

  $slider = function_exists('get_field') ? get_field('slider') : '';

  if($slider){

    $output .= '<section id="home-slider" class="carousel slide carousel-fade" data-ride="carousel" data-interval="'. $atts['timeout'] .'">';

    $output .= '<div class="carousel-inner">';

    $i = 0;

    while(have_rows('slider')){

        the_row();
        $i++;
        $active = ($i == 1) ? 'active' : '';
        $img_src = wp_get_attachment_image_src(get_sub_field('image'), 'home-slider', false);
        $target = get_sub_field('new_window') ? 'target="_blank"' : '';
        $image = '<img src="'. $img_src[0] .'" alt="">';
        $url = get_sub_field('url');
        $title = '<h2 class="title">' . get_sub_field('title') . '</h2>';
        $caption = '<p class="caption">'. get_sub_field('caption') .'</p>';

        $output .= '<div class="item '. $active .'">'; // item begin
        $output .= $url ? '<a href="'. $url .'" '. $target .'>' . $image . '</a>' : $image;
        $output .= '<div class="bar">';
        $output .= $title;
        $output .= $caption;
        $output .= '<a href="'. $url .'" '. $target .' class="more"><span class="like-table"><span class="like-table-cell">' . __('Read More', 'roots') . '</span></span></a>';
        $output .= '</div>';
        $output .= '</div>'; // item end
    }

    $output .= '</div>';

    $output .= '</section>';

  }

  return $output;
}

add_shortcode('slider', 'slider_func');

/**
 * Home Links shortcode
 */
function links_func($atts, $content = null) {
  $atts = shortcode_atts(array(), $atts);

  $output = '';

  $slider = function_exists('get_field') ? get_field('links') : '';

  if($slider){

    $output .= '<section id="home-links" class="links btn-group btn-group-justified">';

    $i = 0;

    while(have_rows('links')){

        the_row();
        $url = get_sub_field('url');
        $prefix = get_sub_field('prefix');
        $title = get_sub_field('title');

        $output .= '<div class="btn-group">'; // item begin
        $output .= '<p>'. $prefix .'</p>';
        $output .= '<h3><a href="'. $url .'">' . $title . '</a></h3>';
        $output .= '</div>'; // item end
    }

    $output .= '</section>';

  }

  return $output;
}

add_shortcode('links', 'links_func');

/**
 * Demos shortcode
 */
function demos_func($atts, $content = null) {
  $atts = shortcode_atts(array(
    'items_in_row' => '3'
  ), $atts);

  $num = 12 / $atts['items_in_row'];

  $output = '';

  $demos = function_exists('get_field') ? get_field('demos') : '';

  if($demos){

    $output .= '<section id="demos" class="demos">';

    $i = 0;

    while(have_rows('demos')){

        the_row();
        $i++;
        $url = get_sub_field('url');
        $full_src = wp_get_attachment_image_src(get_sub_field('image'), 'full', false);
        $thumb_src = wp_get_attachment_image_src(get_sub_field('image'), 'demos', false);
		$caption = get_sub_field('caption');
        $lightbox = get_sub_field('lightbox') ? 'rel="lightbox[demos]"' : '';
        $href = $url ? $url : $full_src[0];

        if($i == 1 || ($i-1)%$atts['items_in_row'] == 0){
          $output .= '<div class="row">';
        }

        $output .= '<div class="imgcaption col-sm-'. $num .'">';
        $output .= '<h3 style="background-image: url('. $thumb_src[0] .')"><a target="_blank" href="'. $href .'"'. $lightbox .'><img src="'. $thumb_src[0] .'" alt=""></a></h3>';
        $output .= '<br>'. $caption .'</div>';

        if($i == count(get_field('demos')) || $i%$atts['items_in_row'] == 0){
          $output .= '</div>';
        }
    }

    $output .= '</section>';

  }

  return $output;
}

add_shortcode('demos', 'demos_func');

/**
 * About images shortcode
 */
function about_images_func($atts, $content = null) {
  $atts = shortcode_atts(array(
    'items_in_row' => '4'
  ), $atts);

  $num = 12 / $atts['items_in_row'];

  $output = '';

  $about_images = function_exists('get_field') ? get_field('about_images') : '';

  if($about_images){

    $output .= '<section id="about_images" class="demos">';

    $i = 0;

    while(have_rows('about_images')){

        the_row();
        $i++;
        $full_src = wp_get_attachment_image_src(get_sub_field('image'), 'full', false);
        $thumb_src = wp_get_attachment_image_src(get_sub_field('image'), 'demos', false);
        $lightbox = get_sub_field('lightbox') ? 'rel="lightbox[about_images]"' : '';
        $href = get_sub_field('url');

        if($i == 1 || ($i-1)%$atts['items_in_row'] == 0){
          $output .= '<div class="row">';
        }

        $output .= '<div class="col-sm-'. $num .'">';
        $output .= '<h3 style="background-image: url('. $thumb_src[0] .')"><a href="'. $href .'"'. $lightbox .'><img src="'. $thumb_src[0] .'" alt=""></a></h3>';
        $output .= '</div>';

        if($i == count(get_field('about_images')) || $i%$atts['items_in_row'] == 0){
          $output .= '</div>';
        }
    }

    $output .= '</section>';

  }

  return $output;
}

add_shortcode('images', 'about_images_func');

// Return Custom Taxonomy terms
add_shortcode( 'terms', 'list_terms_custom_taxonomy' );
function list_terms_custom_taxonomy( $atts, $content = null ) {
  $atts = shortcode_atts(array(
    'taxonomy' => ''
  ), $atts);

  $output = '';

  $args = array(
    'taxonomy' => $atts['taxonomy'],
    'title_li' => '',
    'echo' => false
  );

  $output .= '<ul>';
  $output .= wp_list_categories($args);
  $output .= '</ul>';

  return $output;
}

// List of Custom Posts shortcode
add_shortcode( 'posts', 'list_posts_custom_post_type' );
function list_posts_custom_post_type( $atts, $content = null ) {
  $atts = shortcode_atts(array(
    'type' => ''
  ), $atts);

  $output = '';

  $args = array(
    'posts_per_page'   => -1,
    'post_type'        => $atts['type'],
    'post_status'      => 'publish',
  );

  $posts = get_posts($args);

  $output .= '<ul>';

  foreach($posts as $custom_post){
    $output .= '<li><a href="'. get_post_permalink($custom_post->ID) .'">'. $custom_post->post_title .'</a></li>';
  }

  $output .= '</ul>';

  return $output;
}

// Bottom Info Shortcode
add_shortcode( 'bottom_info', 'bottom_info_func' );
function bottom_info_func( $atts, $content = null ) {
  $atts = shortcode_atts(array(), $atts);

  $output = '';

  $showInfo = function_exists('get_field') ? get_field('show_bottom_info') : '';

  if($showInfo){
    $left_info = get_field('info_left');
    $right_info = get_field('info_right');

    $output .= '<div class="row">';

    $output .= '<div class="col-sm-4">'. $left_info .'</div>';

    $output .= '<div class="col-sm-8">'. $right_info .'</div>';

    $output .= '</div>';
  }

  return $output;
}

add_shortcode('container_open', 'container_open_func');
function container_open_func($atts, $content = null) {
  return '<div class="container">';
}

add_shortcode('container_close', 'container_close_func');
function container_close_func($atts, $content = null) {
  return '</div>';
}

add_shortcode('row_open', 'row_open_func');
function row_open_func($atts, $content = null) {
  return '<div class="row">';
}

add_shortcode('row_close', 'row_close_func');
function row_close_func($atts, $content = null) {
  return '</div>';
}

add_shortcode('column_open', 'column_open_func');
function column_open_func($atts, $content = null) {
  return '<div class="col-md-6">';
}

add_shortcode('column_close', 'column_close_func');
function column_close_func($atts, $content = null) {
  return '</div>';
}

// [login_links]
add_shortcode( 'login_links', 'login_links_func' );
function login_links_func( $atts, $content = null ) {
  $atts = shortcode_atts(array(), $atts);

  $output = '';

  global $post;
  $post_slug = $post->post_name;

  if ( !is_user_logged_in() ) {
    $output .= '<a href="'. get_bloginfo('url') .'/wp-login.php?redirect_to=/'. $post_slug .'/">Login</a> | <a href="'. get_bloginfo('url') .'/wp-login.php?action=register&redirect_to=/'. $post_slug .'/">Register</a>';
  }

  return $output;
}

function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bg/logo.png);
			background-size:313px 112px;
            padding-bottom: 30px;
        }
		.login h1 a {
			height: 112px !important;
			width: 313px !important;
		}
		.wp-core-ui .button-primary {
			background-color: #9ccc3c;
			border-color: #9ccc3c;
		}
		.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {
			background-color: #959698;
			border-color: #959698;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );