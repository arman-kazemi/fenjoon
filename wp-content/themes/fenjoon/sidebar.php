<?php
$users = count_users();
$orders = wp_count_posts( 'orders' );
$projects = wp_count_posts( 'projects' );
?>
<aside class="aside">
		<div class="cols">
			<div class="col11">
				<div class="tile p1 mb2">
					<?php get_search_form();?>
				</div>
				<div class="tile p2 mb2">
					<p class="center size3 mb2"><?php _e( 'Submit a new order!', 'fenjoon' );?></p>
					<a class="button green" href="<?php echo home_url( 'order' );?>"><?php _e( 'Register new order', 'fenjoon' );?></a>
				</div>
				<div class="tile p2 mb2">
					<p class="center size3 mb1"><?php _e( 'Our statistics', 'fenjoon' );?></p>
					<ul>
						<li class="large icon calendar blue"><?php _e( 'Activity start', 'fenjoon' );?><span class="left"><?php _e( 'Year', 'fenjoon' );?> 1389</span></li><?php
						if( $users['avail_roles']['contributor'] ){?>
						<li class="large icon man-woman blue"><?php _e( 'Number of customers', 'fenjoon' );?><span class="left"><?php echo $users['avail_roles']['contributor'];?> <?php _e( 'Person', 'fenjoon' );?></span></li><?php
						}if( $users['avail_roles']['editor'] ){?>
						<li class="large icon user blue"><?php _e( 'Team members', 'fenjoon' );?><span class="left"><?php echo $users['avail_roles']['editor'] + 1;?> <?php _e( 'Person', 'fenjoon' );?></span></li><?php
						}if( $orders->publish ){?>
						<li class="large icon cart blue"><?php _e( 'Orders', 'fenjoon' );?><span class="left"><?php echo $orders->publish;?> <?php _e( 'Order', 'fenjoon' );?></span></li><?php
						}if( $projects->publish ){?>
						<li class="large icon power blue"><?php _e( 'Projects', 'fenjoon' );?><span class="left"><?php echo $projects->publish;?> <?php _e( 'Project', 'fenjoon' );?></span></li><?php
						}?>
					</ul>
				</div>
			</div>
		</div>
</aside>