<?php
global $permalink, $title, $project_code, $order_id, $created_date, $modified_date, $total_price, $total_time;
if( !empty( $project_code ) && file_exists( THEME_DIR . '/tcpdf/tcpdf_barcodes_2d.php' ) ){
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
					if( !empty( $project_code ) ){?>
					<li class="icon size3 barcode">
						<span class="ib"><?php echo $project_code;?></span>
						<span class="left"><?php _e( 'Identifier', 'fenjoon' );?></span>
					</li><?php
					}
					if( !empty( $project_code ) && !empty( $created_date ) ){?>
					<li class="icon size3 calendar">
						<span class="ib"><?php echo $created_date;?></span>
						<span class="left"><?php _e( 'Date created', 'fenjoon' );?></span>
					</li><?php
					}elseif( empty( $project_code ) ){?>
					<li class="icon size3 calendar">
						<span class="ib"><?php echo jdate( 'Y/m/d' );?></span>
						<span class="left"><?php _e( 'Date created', 'fenjoon' );?></span>
					</li><?php
					}
					if( !empty( $project_code ) && !empty( $modified_date ) ){?>
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
						<li class="mt1 center"><?php
							echo $barcodeobj->getBarcodeHTML();?>
						</li><?php
					}?>
				</ul>
			</div><?php
			if( !empty( $order_id ) ){?>
			<div class="tile p2 blue mb2">
				<p class="center size3 mb2"><?php _e( 'Related order', 'fenjoon' );?></p>
				<a class="button green" title="<?php the_title_attribute( array( 'post' => $order_id ) ); ?>" href="<?php echo get_permalink( $order_id );?>"><?php _e( 'Order', 'fenjoon' );?></a>
			</div><?php
			}?>
			<div class="tile p2 mb2">
				<p class="center size3 mb2"><?php _e( 'Help', 'fenjoon' );?></p>
				<ul>
					<li class="icon size3 modules">
						<span class="ib"><?php _e( 'Modules', 'fenjoon' );?></span>
					</li>
					<li class="icon size3 features">
						<span class="ib"><?php _e( 'Features', 'fenjoon' );?></span>
					</li>
					<li class="icon size3 standards">
						<span class="ib"><?php _e( 'Standards', 'fenjoon' );?></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</aside>