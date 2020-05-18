<?php
/*
Template Name: Web design
*/
 get_header();
	get_sidebar();?><main class="main"><?php
	$slug = $post->post_name;
	$post_type = get_post_type_object( $slug );
	$the_query = fjn_template_query( array( 'post_type' => $slug ) );
	if( $the_query->have_posts() ){?>
		<div class="cols">
			<div class="col col11">
				<div class="tile p2">
					<section>
						<h2><?php the_title();?></h2>
						<p class="justify mb2"><?php echo $post_type->description;?></p><?php
						while( $the_query->have_posts() ){ $the_query->the_post();?>
							<section class="mb2">
								<h3 class="icon backblue pr1 <?php echo $slug;?>"><?php the_title(); ?></h3><?php
								the_content();?>
								<div class="center">
									<a class="button link green mt2 prl2" title="<?php echo $post->post_title;?>" href="<?php the_permalink();?>"><?php _e( 'Say more', 'fenjoon' );?></a>
								</div>
							</section><?php
						}wp_reset_postdata();?>
					</section>
				</div>
			</div>
		</div><?php
	}?>
	</main>
</div><?php
get_footer();?>