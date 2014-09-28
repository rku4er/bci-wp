<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

    <div class="entry-content">
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </div>

    <?php
      $newsletter = function_exists('get_field') ? get_field('newsletter', 'options') : '';
      if($newsletter): ?>

      <section class="newsletter">
        <?php gravity_form($newsletter->id, true, false, false, null, true); ?>
      </section>
    <?php endif; ?>

    <footer>
      <?php get_template_part('templates/entry-meta'); ?>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>

    <section class="comment-wrapper">
      <?php comments_template('/templates/comments.php'); ?>
    </section>

  </article>
<?php endwhile; ?>
