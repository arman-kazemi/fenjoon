<?php
/*
Template Name: Login
*/
get_header();
	get_sidebar();?><main class="main"><?php
	if( have_posts() ){
		while( have_posts() ){the_post();?>
		<div class="cols">
			<div class="col col23">
				<div class="tile p2">
					<section>
						<h2><?php the_title();?></h2><?php
						get_template_part( 'parts/login', 'form' );?>
					</section>
				</div>
			</div><div class="col col13 last-child">
				<div class="tile p2">
						<div class="icon center blue user size50 mtb2"></div>
						<p class="center"><?php _e( 'Register on fenjoon to be able to submit new orders', 'fenjoon' );?></p>
						<a class="button green mtb1" title="<?php _e( 'Register', 'fenjoon' );?>" href="<?php echo site_url( '/register/' );?>"><?php _e( 'Register', 'fenjoon' );?></a>
				</div>
			</div>
		</div><?php
		}
	}?>
	</main>
</div><?php
get_footer();?>