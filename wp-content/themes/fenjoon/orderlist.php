<?php
/*
Template Name: Order list
*/
get_header();
if( $current_user->ID ){
$the_query = fjn_template_query( array( 'post_type' => 'orders', 'author' => $current_user->ID ) );
	get_sidebar();?><main class="main">
		<div class="cols">
			<div class="col col11">
				<div class="tile p2">
					<section class="section">
					<h2 class="icon cart"><?php _e( 'List of your orders', 'fenjoon' );?></h2><?php
					if( $the_query->have_posts() ){?>
						<table>
							<thead>
								<tr>
									<th class="mhidden"><?php _e( 'Code', 'fenjoon' );?></th>
									<th><?php _e( 'Title', 'fenjoon' );?></th>
									<th class="mhidden"><?php _e( 'Date created', 'fenjoon' );?></th>
									<th class="mhidden"><?php _e( 'Date modified', 'fenjoon' );?></th>
									<th class="mhidden"><?php _e( 'Price', 'fenjoon' );?></th>
									<th class="mhidden"><?php _e( 'Time', 'fenjoon' );?></th>
									<th><?php _e( 'Status', 'fenjoon' );?></th>
								</tr>
							</thead>
							<tbody><?php
							while( $the_query->have_posts() ){ $the_query->the_post();
								$metadata = get_post_meta( $post->ID );
								$order_code = ( !empty( $metadata[ 'order_code' ] ) ? $metadata[ 'order_code' ][0] : '' );
								$project_id = ( !empty( $metadata[ 'project_id' ] ) ? $metadata[ 'project_id' ][0] : '' );
								$total_price = ( !empty( $metadata[ 'total_price' ] ) ? $metadata[ 'total_price' ][0] : 0 );
								$total_time = ( !empty( $metadata[ 'total_time' ] ) ? $metadata[ 'total_time' ][0] : 0 );?>
								<tr>
									<td class="mhidden"><?php echo $order_code;?></td>
									<td><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></td>
									<td class="mhidden"><?php the_date( 'Y/m/d' ); ?></td>
									<td class="mhidden"><?php the_modified_date( 'Y/m/d' ); ?></td>
									<td class="mhidden"><?php echo $total_price;?></td>
									<td class="mhidden"><?php echo $total_time; ?></td>
									<td><?php if( !empty( $project_id ) ){?><a title="<?php the_title_attribute( array( 'post' => $project_id ) ); ?>" href="<?php echo get_permalink( $project_id );?>"><?php _e( 'Project', 'fenjoon' );?></a><?php }elseif( 'pending' == $post->post_status ){ _e( 'Submitted', 'fenjoon' );}elseif( 'publish' == $post->post_status ){ _e( 'Checking', 'fenjoon' );}?></td>
								</tr><?php
							}?>
							</tbody>
						</table><?php
					}else{?>
						<p><?php _e( 'You have not submitted any orders yet', 'fenjoon' );?></p><?php
					}?>
					</section>
				</div>					
			</div>					
		</div>
	</main><?php
}else{?>
		<div class="cols">
			<div class="col col11">
				<div class="tile red padding1 size2 mb1"><?php echo $err[11];?></div>
			</div>
		</div><?php
}?>
</div>
<?php get_footer();?>