<?php while (have_posts()) : the_post(); ?>
  <article class="hentry">
    <div class="entry-content">
      <?php get_template_part('templates/page', 'header'); ?>
      <?php get_template_part('templates/content', 'page'); ?>
    </div>
  </article>
<?php endwhile; ?>