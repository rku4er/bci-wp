<form role="search" method="get" class="search-form navbar-form" action="<?php echo esc_url(home_url('/')); ?>">
  <input id="search-field" type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field form-control" placeholder="<?php _e('Search', 'roots'); ?>">
</form>