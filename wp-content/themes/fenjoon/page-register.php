<?php
/*
Template Name: Register
*/
get_header();
	get_sidebar();?><main class="main"><?php
	if( have_posts() ){?>
		<div class="cols">
			<div class="col col23">
				<div class="tile p2">
					<section><?php
						while( have_posts() ){the_post();?>
							<h2><?php the_title();?></h2><?php
							get_template_part( 'parts/register', 'form' );
						}?>
					</section>
				</div>
			</div><div class="col col13 last-child">
				<div class="tile p2">
					<div class="icon center blue user-check size50 mtb2"></div>
					<p class="center"><?php _e( 'Please login if you are already a fenjoon member', 'fenjoon' );?></p>
					<a class="button green mtb1" title="<?php _e( 'Login', 'fenjoon' );?>" href="<?php echo site_url( '/login/' );?>"><?php _e( 'Login', 'fenjoon' );?></a>
				</div>
			</div>
		</div><?php
	}?>
	</main>
</div><?php
get_footer();?>