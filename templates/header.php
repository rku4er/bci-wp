<?php
  $logo = '<a href="'. get_bloginfo('url') .'"><img src="'. get_template_directory_uri() .'/assets/img/bg/logo.png" alt="'. get_bloginfo('name') .'"></a>';
?>

<header class="navbar navbar-default navbar-static-top" role="banner">

  <div class="container">

    <div class="group clearfix">

      <section class="section-right clearfix">
        <nav class="secondary-nav">
          <?php
            if (has_nav_menu('secondary_navigation')) :
              wp_nav_menu(array('theme_location' => 'secondary_navigation', 'menu_class' => 'nav navbar-nav'));
            endif;
          ?>
        </nav>

        <a href="#" class="custom-link"><span>Private Exchange Support Services</span></a>
      </section>

      <section class="section-left">
        <?php if(is_home()): ?>
          <h1 class="logo"><?php echo $logo; ?></h1>
        <?php else: ?>
          <strong class="logo"><?php echo $logo; ?></strong>
        <?php endif; ?>

        <p class="tagline"><?php echo get_bloginfo('description'); ?></p>
      </section>

    </div>

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <nav class="primary-nav collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>

  </div>

</header>