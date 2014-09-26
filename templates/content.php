<article <?php post_class(); ?>>
  <header>
    <?php if ( has_post_thumbnail() ): ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'custom' ); ?></a>
    <?php endif; ?>
  </header>
  <div class="entry-summary">
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php the_excerpt(); ?>
  </div>
  <footer>
      <?php get_template_part('templates/entry-meta'); ?>
  </footer>
</article>