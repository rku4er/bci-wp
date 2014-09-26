<footer class="content-info" role="contentinfo">

  <a href="#header" class="btn-back" title="go top"><span class="icon-arrowtop-white"></span></a>

  <div class="widget-columns">
    <div class="container">
        <?php dynamic_sidebar('sidebar-footer'); ?>
    </div>
  </div>

  <section class="copyright">
      <div class="container">&copy; Copyright <?php the_date('Y') ?>, McLeod Creative</div>
  </section>

</footer>

<?php wp_footer(); ?>
