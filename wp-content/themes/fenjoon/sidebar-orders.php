<?php
global $permalink, $title, $order_code, $project_id, $created_date, $modified_date, $total_price, $total_time;
if( !empty( $order_code ) && file_exists( THEME_DIR . '/tcpdf/tcpdf_barcodes_2d.php' ) ){
	require_once( THEME_DIR . '/tcpdf/tcpdf_barcodes_2d.php'  );
	$barcodeobj = new TCPDF2DBarcode( $permalink, 'QRCODE,H' );
}
?>
<aside class="aside">
	<div class="cols">
		<div class="col11">
			<div class="tile p1 mb2">
				<?php get_search_form();?>
			</div>
			<div class="tile p2 green mb2">
				<p class="center size3 mb2"><?php
					if( !empty( $title ) ){
						echo $title;
					}else{
						_e( 'Your order', 'fenjoon' );
					}?>
				</p>
				<ul><?php
					if( !empty( $order_code ) ){?>
					<li class="icon size3 barcode">
						<span class="ib"><?php echo $order_code;?></span>
						<span class="left"><?php _e( 'Identifier', 'fenjoon' );?></span>
					</li><?php
					}
					if( !empty( $order_code ) && !empty( $created_date ) ){?>
					<li class="icon size3 calendar">
						<span class="ib"><?php echo $created_date;?></span>
						<span class="left"><?php _e( 'Date created', 'fenjoon' );?></span>
					</li><?php
					}elseif( empty( $order_code ) ){?>
					<li class="icon size3 calendar">
						<span class="ib"><?php echo jdate( 'Y/m/d' );?></span>
						<span class="left"><?php _e( 'Date created', 'fenjoon' );?></span>
					</li><?php
					}
					if( !empty( $order_code ) && !empty( $modified_date ) ){?>
					<li class="icon size3 calendar">
						<span class="ib"><?php echo $modified_date;?></span>
						<span class="left"><?php _e( 'Correction', 'fenjoon' );?></span>
					</li><?php
					}?>
					<li class="icon size3 cart">
						<span class="ib" id="total_price"><?php echo $total_price;?></span>
						<span class="left"><?php _e( 'Toman', 'fenjoon' );?></span>
					</li>
					<li class="icon size3 alarm">
						<span class="ib" id="total_time"><?php echo $total_time;?></span>
						<span class="left"><?php _e( 'Days', 'fenjoon' );?></span>
					</li><?php
					if( !empty( $barcodeobj ) ){?>
						<li class="mt1 center mhidden"><?php
							echo $barcodeobj->getBarcodeHTML();?>
						</li><?php
					}?>
				</ul>
			</div><?php
			if( !empty( $project_id ) ){?>
			<div class="tile p2 blue mb2">
				<p class="center size3 mb2"><?php _e( 'Related project', 'fenjoon' );?></p>
				<a class="button green" title="<?php the_title_attribute( array( 'post' => $project_id ) ); ?>" href="<?php echo get_permalink( $project_id );?>"><?php _e( 'Project', 'fenjoon' );?></a>
			</div><?php
			}?>
			<div class="tile p2 mb2">
				<p class="center size3 mb2"><?php _e( 'Help', 'fenjoon' );?></p>
				<ul>
					<li class="icon size3 green checkbox checked">
						<span class="ib"><?php _e( 'Selected', 'fenjoon' );?></span>
					</li>
					<li class="icon size3 started checkbox checked">
						<span class="ib"><?php _e( 'In progress', 'fenjoon' );?></span>
					</li>
					<li class="icon size3 green checkbox unchecked">
						<span class="ib"><?php _e( 'Not selected', 'fenjoon' );?></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</aside>