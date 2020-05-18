<form id="register" action="<?php echo site_url(); ?>/submit/" method="post">
	<input type="text" name="username" class="center" placeholder="<?php _e( 'Username', 'fenjoon' );?>">
	<input type="text" name="useremail" class="center" placeholder="<?php _e( 'email', 'fenjoon' );?>">
	<input type="text" name="password" class="center" placeholder="<?php _e( 'Password', 'fenjoon' );?>"><?php
	wp_nonce_field( 'fjn_submit-register', 'fjn_nonce' );?>
	<input type="text" name="email" class="hidden">
	<input type="hidden" name="action" value="register">
	<a class="button green size2" onclick="fjn_submit( 'register' );"><?php _e( 'Register', 'fenjoon' );?></a>
</form>