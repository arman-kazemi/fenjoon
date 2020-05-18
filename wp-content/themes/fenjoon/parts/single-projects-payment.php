<?php	global $project_code, $project_id;?>

<form id="payment" action="<?php echo site_url(); ?>/submit/" method="post">
	<input type="text" name="payment[pay]" class="center" maxlength="9" placeholder="<?php _e( 'Payment', 'fenjoon' );?>">
	<table class="date mb1">
		<tr>
			<td class="w20"><input type="text" name="payment[day]" class="center" maxlength="2" placeholder="<?php _e( 'Day', 'fenjoon' );?>"></td>
			<td>/</td>
			<td class="w20"><input type="text" name="payment[month]" class="center" maxlength="2" placeholder="<?php _e( 'Month', 'fenjoon' );?>"></td>
			<td>/</td>
			<td class="w40"><input type="text" name="payment[year]" class="center" maxlength="4" placeholder="<?php _e( 'Year', 'fenjoon' );?>"></td>
		</tr>
	</table>
	<input type="text" name="payment[pursuit]" class="center" maxlength="10" placeholder="<?php _e( 'Pursuit', 'fenjoon' );?>">
	<input type="text" name="payment[note]" class="center" maxlength="50" placeholder="<?php _e( 'Note', 'fenjoon' );?>"><?php
	wp_nonce_field( 'fjn_submit-payment', 'fjn_nonce' );
	$current_url = '';
	global $wp;
	$current_url = home_url( add_query_arg( array(), $wp->request ) );?>
	<input type="text" name="email" class="hidden">
	<input type="hidden" name="referrer" value="<?php echo $current_url;?>"><?php
	if( !empty( $project_code ) && !empty( $project_id ) ){?>
	<input type="hidden" name="project_id" value="<?php echo $project_id;?>"><?php
	}?>
	<input type="hidden" name="action" value="payment">
	<a class="button green" onclick="fjn_submit( 'payment' );"><?php _e( 'Submit payment', 'fenjoon' );?></a>
</form>