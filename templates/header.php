<header class="navbar navbar-default navbar-static-top" role="banner">

  <div class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a href="<?php echo get_bloginfo('url'); ?>" class="navbar-brand"><?php echo get_bloginfo('name'); ?></a>

    </div>

    <?php get_search_form(); ?>

    <nav class="collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>

  </div>

</header>