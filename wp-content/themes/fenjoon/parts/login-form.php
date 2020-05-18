<form id="login" action="<?php echo site_url(); ?>/submit/" method="post">
	<input type="text" name="username" class="center" placeholder="<?php _e( 'Username', 'fenjoon' );?>">
	<input type="password" name="password" class="center" placeholder="<?php _e( 'Password', 'fenjoon' );?>"><?php
	wp_nonce_field( 'fjn_submit-login', 'fjn_nonce' );?>
	<input type="text" name="email" class="hidden">
	<input type="hidden" name="action" value="login">
	<a class="button green size2" onclick="fjn_submit( 'login' );"><?php _e( 'Login', 'fenjoon' );?></a>
</form>