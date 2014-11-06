  <div class="col-sm-6 col-md-4 col-lg-4 casecol">
  <div class="casecontent">
      <?php if ( has_post_thumbnail() ): ?>
          <?php the_post_thumbnail( 'custom' ); ?>
      <?php endif; ?>
      <h2 class="casetitle"><?php the_title(); ?></h2>
      <?php the_excerpt(); ?>
      <?php
	  $link = get_field('download');
	  $url = get_home_url();
if ( is_user_logged_in() ) {
	echo '<p class="casep"><a class="whitetext" href="' . $link . '">Read Case Study</a></p>';
} else {
	echo '<p class="casep"><span class="whitetext">Log in to Read Case Study</span><br><a class="loginreg" href="' . $url . '/wp-login.php?redirect_to=/archive-case-studies">Login</a> | <a class="loginreg" href="' . $url . '/wp-login.php?action=register&redirect_to=/">Register</a></p>';
}
?>
  </div>
  </div>