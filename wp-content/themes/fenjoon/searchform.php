<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="full">
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		<a class="button blue" onclick="document.getElementById('searchform').submit();"><?php _e( 'Search', 'fenjoon' );?></a>

	</div>
</form>