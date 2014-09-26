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

  $home_posts = get_field('posts_on_blog_page', 'options');
  $category_posts = get_field('posts_on_category_page', 'options');

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
 * Social Icons shortcode
 */
function socialicons_func($atts, $content = null) {
    $atts = shortcode_atts(array(), $atts);

    $output = '';

    if(have_rows('social_icons', 'options')){

        $output .= '<ul class="socialicons">';

        while(have_rows('social_icons', 'options')){

          the_row();

          $output .= '<li><a href="'. get_sub_field('url') .'" class="'. get_sub_field('slug') .'-dark" target="_blank">'. get_sub_field('name') .'</a></li>';

        }

        $output .= '</ul>';

    }

    return $output;
}

add_shortcode('socialicons', 'socialicons_func');
