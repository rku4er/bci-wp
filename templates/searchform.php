<form role="search" method="get" class="search-form navbar-form navbar-right" action="<?php echo esc_url(home_url('/')); ?>">
  <p class="form-group">
      <label for="search-field" class="icon-search-0"></label>
      <input id="search-field" type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field form-control" placeholder="<?php _e('Search', 'roots'); ?>">
  </p>
</form>
