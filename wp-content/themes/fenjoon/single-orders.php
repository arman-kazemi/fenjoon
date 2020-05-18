<?php
/*
Template Name: New order
*/
$order_arr = array();
$progress_arr = array();
if( have_posts() ){
	while( have_posts() ){
		the_post();
		$order_id = $post->ID;
		$permalink = get_the_permalink();
		$title = get_the_title();
		$content = get_the_content();
		$created_date = get_the_date( 'Y/m/d' );
		$modified_date = get_the_modified_date( 'Y/m/d' );
		$metadata = get_post_meta( $order_id );
		$order_code = ( !empty( $metadata[ 'order_code' ] ) ? $metadata[ 'order_code' ][0] : '' );
		$project_id = ( !empty( $metadata[ 'project_id' ] ) ? $metadata[ 'project_id' ][0] : '' );
		$total_price = ( !empty( $metadata[ 'total_price' ] ) ? $metadata[ 'total_price' ][0] : 20 );
		$total_time = ( !empty( $metadata[ 'total_time' ] ) ? $metadata[ 'total_time' ][0] : 10 );
		$order_str = ( !empty( $metadata[ 'order_str' ] ) ? $metadata[ 'order_str' ][0] : '' );
		if( !empty( $order_str ) ) $order_arr = explode( '+', $order_str );
		if( !empty( $order_arr ) ){
			if( !empty( $project_id ) ){
				$progress_str = get_post_meta( $project_id, 'progress_str', 1 );
				if( !empty( $progress_str ) ) $progress_arr = explode( '+', $progress_str );
			}
		}
	}wp_reset_postdata();
}
if( ( !empty( $order_code ) && current_user_can( 'edit_post', $order_id ) ) || empty( $order_code ) ){
	if( $fenjoon_settings = get_option( 'fenjoon_settings' ) ){
		$developer_count = $fenjoon_settings[ 'developer_count' ];
		$man_hour_fee = $fenjoon_settings[ 'man_hour_fee' ];
		$daily_work_hours = $fenjoon_settings[ 'daily_work_hours' ];
	}else{
		$developer_count = 0;
		$man_hour_fee = 0;
		$daily_work_hours = 0;
	}
	$daily_man_power = ( 0 != ( $developer_count * $daily_work_hours ) ) ? ( $developer_count * $daily_work_hours ) : 1;
	$choice_sections = array( 'sitetypes', 'modules', 'features', 'standards' );
	$the_query = fjn_template_query( array( 'post_type' => $choice_sections ) );
	if( $the_query->have_posts() ){
		$order_sections = array();
		foreach( $choice_sections as $choice_section){
			$order_sections[ $choice_section ] = array();
		}
		$parents = array();
		$children = array();
		while( $the_query->have_posts() ){
			$the_query->the_post();
			if( 0 != $post->post_parent ){
				$parents[] = $post->post_parent;
				$children[$post->post_parent][] = $post->ID;
			}elseif( !in_array( $post->ID, $parents ) ){
				$parents[] = $post->ID;
			}
			$order_sections[ $post->post_type ][ $post->ID ]['title'] = $post->post_title;
			$order_sections[ $post->post_type ][ $post->ID ]['description'] = $post->post_excerpt;
		}wp_reset_postdata();
		$total_pt_price = array();
		foreach( $order_sections as $key => $order_section ){
			$total_pt_price[ $key ] = 0;
			foreach( $order_section as $choice_id => $choice_info ){
				if( 'sitetypes' == $key ){
					$order_sections[ $key ][ $choice_id ][ 'sitetype_str' ] = get_post_meta( $choice_id, 'sitetype_str', 1 );
				}elseif( 'sitetypes' != $key ){
					$order_sections[ $key ][ $choice_id ][ 'workforce' ] = get_post_meta( $choice_id, 'workforce', 1 );
					$total_pt_price[ $key ] += ( $order_sections[ $key ][ $choice_id ][ 'workforce' ] ) * $man_hour_fee;
				}
			}
		}
	}
	get_header();
	get_sidebar( 'orders' );?><main class="main"><?php
	if( $the_query->have_posts() ){
		foreach( $order_sections as $key => $order_section ){
			$post_type = get_post_type_object( $key );
			if( $post_type && !empty( $order_section ) ){?>
			<div class="cols <?php if( 'sitetypes' != $key ) echo 'post_type';?>">
				<div class="col col23">
					<div class="tile p2">
						<section class="section">
							<h2 class="icon <?php echo $post_type->name;?>"><?php echo $post_type->label;?></h2>
							<ul><?php
							foreach( $order_section as $choice_id => $choice_info ){
								if( in_array( $choice_id, $parents ) ){?>
									<li class="icon green option size2 <?php echo( 'sitetypes' == $key ? 'radio' : 'checkbox');?> <?php echo (in_array( $choice_id, $order_arr ) ? 'checked' : 'unchecked');?> <?php echo (in_array( $choice_id, $progress_arr ) ? 'started' : '');?>" value="<?php echo $choice_id;?>" id="option<?php echo $choice_id;?>"<?php
									if( 'sitetypes' == $key ){
										echo( $order_sections[ $key ][ $choice_id ][ 'sitetype_str' ] ? ' preselection="' . $order_sections[ $key ][ $choice_id ][ 'sitetype_str' ] . '"' : '' );
									}elseif( 'sitetypes' != $key ){
										echo( $order_sections[ $key ][ $choice_id ][ 'workforce' ] ? ' workforce="' . $order_sections[ $key ][ $choice_id ][ 'workforce' ] . '"' : '' );
									}?>
									><?php echo $choice_info['title'];?>
										<p class="description hidden"><?php echo $choice_info['description'];?></p>
									</li><?php
									if( !empty( $children[ $choice_id ] ) ){
										$coselected = get_post_meta( $choice_id, 'coselected_children', 1 );
										?>
										<ul class="pr3"><?php
											foreach( $children[ $choice_id ] as $child_id ){?>
												<li class="icon green option size2 checkbox <?php echo (in_array( $choice_id, $order_arr ) ? 'checked' : 'unchecked');?> <?php echo (in_array( $choice_id, $progress_arr ) ? 'started' : '');?> children<?php echo $choice_id; echo( in_array( $child_id, explode( ',', $coselected ) ) ? ' coselection' : '' );?>" value="<?php echo $child_id;?>" id="option<?php echo $child_id;?>" <?php if( 'sitetypes' != $key ){
										echo( $order_sections[ $key ][ $child_id ][ 'workforce' ] ? ' workforce="' . $order_sections[ $key ][ $child_id ][ 'workforce' ] . '"' : '' );
									}?>><?php echo $order_sections[ $key ][ $child_id ]['title'];?>
													<p class="description hidden"><?php echo $order_sections[ $key ][ $child_id ]['description'];?></p>
												</li><?php
											}?>
										</ul><?php
									}
								}
							}?>
							</ul>
						</section>
					</div>
					<?php if( 'sitetypes' != $key ){?>
				</div><div class="col col13 last-child">
					<div class="tile p2">
						<p class="center size5"><?php _e( 'Sum', 'fenjoon' ); echo ' ' . $post_type->label;?></p>
						<ul>
							<li class="icon green size5 align-right"><span class="your_pt_price ib">0</span><span class="left"><?php _e( 'Toman', 'fenjoon' );?></span></li>
							<li class="icon green size5 align-justify"><span class="total_pt_price ib"><?php echo $total_pt_price[ $key ];?></span><span class="left"><?php _e( 'Toman', 'fenjoon' );?></span></li>
						</ul>
					</div>
					<?php }?>
				</div>
			</div><?php
			}
		}?>
		<div class="cols">
			<div class="col col23">
				<div class="tile p2">
					<h2><?php _e( 'Complementary information', 'fenjoon' );?></h2>
					<form id="new_order" action="<?php echo site_url(); ?>/submit/" method="post">
						<input type="text" name="title" value="<?php if( !empty( $order_code ) && !empty( $title ) ) echo $title;?>" placeholder="<?php _e( 'Order title', 'fenjoon' );?>"><?php
						wp_nonce_field( 'fjn_submit-order', 'fjn_nonce' );
						$current_url = '';
						global $wp;
						$current_url = home_url( add_query_arg( array(), $wp->request ) );?>
						<textarea rows="5" name="content" placeholder="<?php _e( 'Order detail', 'fenjoon' );?>"><?php if( !empty( $order_code ) && !empty( $content ) ) echo $content;?></textarea>
						<input type="text" name="email" class="hidden">
						<input type="hidden" name="referrer" value="<?php echo $current_url;?>">
						<input type="hidden" name="string" value="<?php if( !empty( $order_str ) ) echo $order_str;?>"><?php
						if( !empty( $order_code ) && !empty( $order_id ) ){?>
							<input type="hidden" name="order_id" value="<?php echo $order_id;?>"><?php
						}?>
						<input type="hidden" name="action" value="<?php echo( !empty( $order_code ) && !empty( $order_id ) ? 'update_order' : 'new_order' );?>">
						<input type="hidden" id="daily_man_power" value="<?php echo $daily_man_power;?>">	
						<input type="hidden" id="man_hour_fee" value="<?php echo $man_hour_fee;?>">	
						<a class="button green" onclick="fjn_submit( 'new_order' );"><?php if( empty( $order_code ) ){ _e( 'Submit order', 'fenjoon' );}else{ _e( 'Update order', 'fenjoon' );}?></a>
					</form>
				</div>
			</div>
		</div><?php
	}?>
	</main><?php
}else{?>
	<div class="cols">
		<div class="col col11">
			<div class="tile red p1 size2 mb1"><?php echo $err[11];?></div>
		</div>
	</div><?php
}?>
</div><?php
get_footer(); ?>