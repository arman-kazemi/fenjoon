<?php
	global $wpdb, $project_id;
	$concern = array(
		1 => __( 'Web design', 'fenjoon' ),
		2 => __( 'Support', 'fenjoon' ),
		3 => __( 'Host registration', 'fenjoon' ),
		4 => __( 'Domain registration', 'fenjoon' ),
		5 => __( 'Content development', 'fenjoon' ),
		6 => __( 'Penalty', 'fenjoon' )
	);
	
	$instalments_table = $wpdb->prefix . 'instalments';
	$query = "SELECT concern, amount, due, passed FROM {$instalments_table} WHERE project_id = %d";
	$query = $wpdb->prepare( $query, $project_id );
	$results = $wpdb->get_results( $query, OBJECT );
	if( !empty( $results ) ){?>
		<table id="instalments">
			<thead>
				<tr>
					<th class="w15"><?php _e( 'Amount', 'fenjoon' );?></th>
					<th class="w20"><?php _e( 'Due', 'fenjoon' );?></th>
					<th class="w35"><?php _e( 'Concern', 'fenjoon' );?></th>
				</tr>
			</thead>
			<tbody><?php
			foreach( $results as $instalment ){?>
				<tr class="instalment<?php echo( $instalment->passed ? ' bglightgreen' : '' );?>">
					<td class="w15"><?php echo number_format( $instalment->amount );?></td>
					<td class="w20"><?php echo ( function_exists( 'jdate' ) ? jdate( 'Y/m/d', $instalment->due ) : date( 'Y/m/d', $instalment->due ) );?></td>
					<td class="w35" value="<?php echo( $instalment->concern ? $instalment->concern : 0 );?>"><?php echo( $instalment->concern ? $concern[ $instalment->concern ] : '' );?></td>
				</tr><?php
			}?>
			</tbody>
		</table><?php
	}else{?>
		<p><?php _e( 'This project has not any instalments yet.', 'fenjoon' );?></p><?php
	}?>