<?php

/**
 * Clean up the_excerpt()
 */
function roots_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'roots') . '</a>';
}
add_filter('excerpt_more', 'roots_excerpt_more');

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
      $query->set('post_type', 'post');
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
        $output .= '<a href="'. $url .'" '. $target .'>' . __('Read More', 'roots') . '</a>';
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
        $prefix = get_sub_field('prefix') .'</h2>';
        $title = get_sub_field('title') .'</h2>';

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