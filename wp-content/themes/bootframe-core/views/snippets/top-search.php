<form id="searchForm" class="smartlib-navbar-search-form pull-right"
      action="<?php echo home_url('/'); ?>" method="get"
      novalidate="novalidate">
    <a href="#" class="btn smartlib-search-close-form smartlib-btn-close"></a>

    <div class="input-group">
        <input id="search-input" type="text" name="s"
               placeholder="<?php _e( 'Search for ...', 'bootframe-core' ); ?>" value="">
								<span class="input-group-btn">
									<button class="btn btn-default btn-sm smartlib-search-btn" type="submit"><i
                                            class="fa fa-search"></i></button>
								</span>
    </div>
</form>