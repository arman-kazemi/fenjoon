<?php
if( have_posts() ){
	while( have_posts() ){
		the_post();
		$project_id = $post->ID;
		$permalink = get_the_permalink();
		$title = get_the_title();
		$created_date = get_the_date( 'Y/m/d' );
		$modified_date = get_the_modified_date( 'Y/m/d' );
		$metadata = get_post_meta( $project_id );
		$project_code = ( $metadata[ 'project_code' ] ? $metadata[ 'project_code' ][0] : '' );
		$project_str = ( $metadata[ 'project_str' ] ? $metadata[ 'project_str' ][0] : '' );
		if( !empty( $project_str ) ) $workforce_values = fjn_get_meta_by_key( 'workforce', $project_str );
		$progress_str = ( $metadata[ 'progress_str' ] ? $metadata[ 'progress_str' ][0] : '' );
		$done_str = ( $metadata[ 'done_str' ] ? $metadata[ 'done_str' ][0] : '' );
		
		$order_id = ( $metadata[ 'order_id' ] ? $metadata[ 'order_id' ][0] : '' );
		$metadata_order = get_post_meta( $order_id );
		$total_price = ( $metadata_order[ 'total_price' ] ? $metadata_order[ 'total_price' ][0] : 20 );
		$total_time = ( $metadata_order[ 'total_time' ] ? (int)$metadata_order[ 'total_time' ][0] : 10 );
		$created = get_the_time( 'U' );
		$elapsed_time = human_time_diff( $created, current_time('timestamp') );
		$remaining_time = human_time_diff( current_time('timestamp') - $created + strtotime('+' . $total_time . 'days' ) );
		//$remaining_time = $total_time - $elapsed_time;
	}
}
if( !empty( $project_code ) && current_user_can( 'edit_post', $project_id ) ){
fjn_msg_reporting( $msg, $err );
$project_arr = explode( '+', $project_str );
$progress_arr = explode( '+', $progress_str );
$done_arr = explode( '+', $done_str );

$status_labels = array( 'done' => __( 'Done', 'fenjoon' ), 'inprogress' => __( 'In progress', 'fenjoon' ), 'inqueue' => __( 'In queue', 'fenjoon' ) );
$statuses = array( 'done', 'inprogress', 'inqueue' );
$types = array( 'modules', 'features', 'standards' );
$post_types = array();
foreach( $types as $type ){
	$post_type = get_post_type_object( $type );
	$post_types[ $type ] = $post_type->label;
}
$args = array( 'post_type' => $types, 'post__in' => $project_arr, 'orderby' => 'menu_order', 'post_status' => 'publish', 'posts_per_page' => -1 );
$the_query = new WP_Query( $args );
if( $the_query->have_posts() ){
	$titles = array();
	while( $the_query->have_posts() ){ $the_query->the_post();
		if( in_array( $post->ID, $done_arr ) ){
			$titles['done'][$post->post_type][] = $post->post_title;
		}elseif( in_array( $post->ID, $progress_arr ) ){
			$titles['inprogress'][$post->post_type][] = $post->post_title;
		}else{
			$titles['inqueue'][$post->post_type][] = $post->post_title;
		}
	}
	wp_reset_postdata();
}
$titles_sorted = array();
foreach( $statuses as $status ){
	if( !empty( $titles[ $status ] ) ){
		foreach( $types as $type ){
			if( !empty( $titles[ $status ][ $type ] ) ) $titles_sorted[ $status ][ $type ] = $titles[ $status ][ $type ];
		}
	}
}
$backcolor[ 'done' ] = 'backgreen';
$backcolor[ 'inprogress' ] = 'backorange';
$backcolor[ 'inqueue' ] = 'backred';
	get_header();
	get_sidebar( 'projects' );?><main class="main">
		<div class="cols">
			<div class="col col23">
				<div class="tile p2">
					<section class="section">
						<h2 class="icon"><?php _e( 'Project status', 'fenjoon' );?></h2><?php
						foreach( $titles_sorted as $status => $status_titles ){?>
						<section class="mb1">
							<h3 class="icon pr1 <?php echo $backcolor[ $status ];?> <?php echo $status;?>"><?php echo $status_labels[ $status ];?></h3><?php
							foreach( $status_titles as $pt => $pt_titles ){?>
								<ul><?php
								foreach( $pt_titles as $pt_title ){?>
									<li class="icon checkbox <?php echo $pt;?>"><?php echo $pt_title;?></li><?php
								}?>
								</ul><?php
							}?>
						</section><?php
						}
						?>
					</section>
				</div>
			</div><div class="col col13 last-child">
				<div class="tile p2"><?php
				if( !empty( $workforce_values ) ){?>
					<div id="g1" style="width:100X;"></div><?php
				}?>
					<p class="center size3 mt2"><?php _e( 'Project summary', 'fenjoon' );?></p>
					<ul><?php
						if( !empty( $elapsed_time ) ){?>
						<li class="icon size3 alarm">
							<span class="ib"><?php echo $elapsed_time?></span>
							<span class="left"><?php _e( 'Elapsed time', 'fenjoon' );?></span>
						</li><?php
						}
						if( !empty( $remaining_time ) ){?>
						<li class="icon size3 alarm">
							<span class="ib"><?php echo $remaining_time?></span>
							<span class="left"><?php _e( 'Remaining time', 'fenjoon' );?></span>
						</li><?php
						}?>
					</ul>
				</div>
			</div>
		</div>
		<div class="cols">
			<div class="col col23">
				<div class="tile p2">
					<section class="section mb2">
						<h2 class="icon"><?php _e( 'Project instalments', 'fenjoon' );?></h2>
						<?php get_template_part( 'parts/single-projects', 'instalments' );?>
					</section>
					<section class="section mb2">
						<h2 class="icon"><?php _e( 'Payment history', 'fenjoon' );?></h2>
						<?php get_template_part( 'parts/single-projects', 'payments' );?>
					</section>
					<section class="section">
						<h2 class="icon"><?php _e( 'Submit new payment', 'fenjoon' );?></h2>
						<?php get_template_part( 'parts/single-projects', 'payment' );?>
					</section>
				</div>
			</div>
			</div><div class="col col13 last-child">
			</div>
		</div>
	</main><?php
}else{?>
	<div class="cols">
		<div class="col col11">
			<div class="tile red p1 size2 mb1"><?php echo $err[11];?></div>
		</div>
	</div><?php
}?>
</div><?php
get_footer( 'projects' ); ?>