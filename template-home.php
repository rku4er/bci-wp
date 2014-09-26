<?php
/*
Template Name: Homepage
*/
?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'roots'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php
    $front_posts = get_field('posts_on_front_page', 'options');
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $front_posts ? $front_posts : 4
    );
    query_posts($args);
?>

<div class="columns clearfix">
  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/content', get_post_format()); ?>
  <?php endwhile; ?>
</div>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <a href="<?php echo get_field('blog_page', 'options'); ?>" class="more">More Posts</a>
  </nav>
<?php endif; ?>

<?php wp_reset_query(); ?>
