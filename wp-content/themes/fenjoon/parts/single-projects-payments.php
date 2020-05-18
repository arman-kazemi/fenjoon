<?php
	global $wpdb, $project_id;
	
	$payments_table = $wpdb->prefix . 'payments';
	$query = "SELECT id, pay, date, pursuit, approved, note FROM {$payments_table} WHERE project_id = %d";
	$query = $wpdb->prepare( $query, $project_id );
	$results = $wpdb->get_results( $query, OBJECT );
	if( !empty( $results ) ){?>
		<table id="payments">
			<thead>
				<tr>
					<th class="w15"><?php _e( 'Payment', 'fenjoon' );?></th>
					<th class="w20"><?php _e( 'Payment date', 'fenjoon' );?></th>
					<th class="w15"><?php _e( 'Pursuit', 'fenjoon' );?></th>
					<th class="w20"><?php _e( 'Note', 'fenjoon' );?></th>
				</tr>
			</thead>
			<tbody><?php
			foreach( $results as $payment ){?>
				<tr class="payment<?php echo( $payment->approved ? ' bglightgreen' : '' );?>">
					<td class="w15"><?php echo number_format( $payment->pay );?></td>
					<td class="w20"><?php echo ( function_exists( 'jdate' ) ? jdate( 'Y/m/d', $payment->date ) : date( 'Y/m/d', $payment->date ) );?></td>
					<td class="w15"><?php echo $payment->pursuit;?></td>
					<td class="w20"><?php echo $payment->note;?></td>
				</tr><?php
			}?>
			</tbody>
		</table><?php
	}else{?>
		<p><?php _e( 'This project has not any payments yet.', 'fenjoon' );?></p><?php
	}?>	