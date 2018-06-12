<form class="form-inline navbar-form" role="search" method="get"  id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
    <input class="form-control" type="search" name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder="<?php _e('Search', 'brainworks') ?>">
    <button class="btn-search" type="submit" id="searchsubmit">
        <i class="fa fa-search" aria-hidden="true"></i>
    </button>
</form>
