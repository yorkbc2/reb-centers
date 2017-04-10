<form class="form-inline navbar-form" role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <input class="form-control" type="text" value="<?php echo get_search_query(); ?>" placeholder="<?php _e('Search', 'brainworks') ?>" name="s" id="s">
  <button class="btn-search" type="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
</form>
