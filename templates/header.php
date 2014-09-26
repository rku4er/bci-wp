<header id="header">

  <section class="navbar navbar-default navbar-static-top">

    <div class="container">

      <?php get_search_form(); ?>

      <?php if(have_rows('social_icons', 'options')): ?>

        <ul class="socialicons nav navbar-nav navbar-right">

        <?php while(have_rows('social_icons', 'options')): the_row(); ?>

          <li><a href="<?php the_sub_field('url'); ?>" class="<?php the_sub_field('slug'); ?>-white" target="_blank"><?php the_sub_field('name'); ?></a></li>

        <?php endwhile; ?>

        </ul>

      <?php endif; ?>

      <div class="navbar-header">

        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

      </div>

    </div>

  </section>

  <section class="header" role="banner">

    <div class="container">

      <?php $logo = '<a href="'. get_bloginfo('url') .'"><img src="'. get_template_directory_uri() .'/assets/img/bg/one-bride-guide-logo.png" alt="'. get_bloginfo('name') .'"></a>'; ?>

      <?php if(is_home()): ?>
        <h1 class="logo"><?php echo $logo; ?></h1>
      <?php else: ?>
        <strong class="logo"><?php echo $logo; ?></strong>
      <?php endif; ?>

      <p class="tagline"><?php echo get_bloginfo('description'); ?></p>

      <?php
        if(get_field('latest_issue_image', 'options')):
          $src = wp_get_attachment_image_src(get_field('latest_issue_image', 'options'), 'thumbnail');
      ?>
      <div class="latest-issue clearfix">
        <a href="<?php echo get_field('latest_issue_url', 'options'); ?>">
          Read Our <br> Latest Issue
          <img src="<?php echo $src[0]; ?>" alt="">
        </a>
      </div>
      <?php endif; ?>

      <div class="collapse navbar-collapse">

        <nav role="navigation" class="clearfix">
          <?php
            if (has_nav_menu('primary_navigation')) :
              wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
            endif;
          ?>
        </nav>

      </div>

    </div>

  </section>

</header>

<?php if(get_field('top_banner', 'options')): ?>
  <section class="top-banner">
    <div class="container">
      <?php echo do_shortcode(get_field('top_banner', 'options')); ?>
    </div>
  </section>
<?php endif; ?>