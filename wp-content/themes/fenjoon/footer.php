	<footer></footer>
<?php wp_footer();?>
	<script>
		window.onload = function(){
			if( typeof onload_msg_reporting === 'function' ) onload_msg_reporting();
			if( typeof onload_order === 'function' ) onload_order();
			if( typeof onload_enter_submit === 'function' ) onload_enter_submit();
			if( typeof onload_menubox === 'function' ) onload_menubox();<?php
			if( is_page_template( 'single-projects.php' ) || is_singular( 'projects' ) ){
				global $project_id, $workforce_values, $done_arr;
				if( current_user_can( 'edit_post', $project_id ) && !empty( $workforce_values ) ){
					$done_work = 0;
					$total_work = 0;
					foreach( $workforce_values as $key => $workforce_value ){
						$total_work += (int)$workforce_value;
						if( in_array( (string)$key, $done_arr ) ) $done_work += (int)$workforce_value;
					}
					$percent = ( !empty( $total_work ) ? (int)( 100 * $done_work / $total_work ) : 0 );?>
				var g1 = new JustGage({
					id: 'g1', 
					titleFontColor: '#424F59',
					valueFontColor: '#424F59',
					showInnerShadow: true,
					shadowOpacity: 0.2,
					levelColors: [ '#7FB952' ],
					value: <?php echo $percent;?>,
					labelFontColor: '#424F59',
					min: 0,
					max: 100,
					startAnimationType: 'linear',
					startAnimationTime: 3000,
					title: '<?php _e( 'Project progress', 'fenjoon' );?>',
					levelColorsGradient: false
				});<?php
				}
			}?>
		}
	</script>
</body>
</html>
